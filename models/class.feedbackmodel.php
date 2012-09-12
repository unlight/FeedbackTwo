<?php if (!defined('APPLICATION')) exit();

class FeedbackModel extends Gdn_Model {

	public function __construct() {
		parent::__construct('Feedback');
	}

	public function GetID($RowID) {
		$this->SQL->Select('f.*');
		$Conditions['f.FeedbackID'] = $RowID;
		$Conditions['InsertUserInfo'] = TRUE;
		$Result = $this->Get($Conditions, FALSE, FALSE, FALSE)->FirstRow();
		return $Result;
	}

	public function Get($Conditions = FALSE, $Offset = FALSE, $Limit = FALSE, $OrderBy = FALSE, $OrderDirection = 'desc') {
		$bCountQuery = GetValue('bCountQuery', $Conditions, FALSE, TRUE);

		if ($bCountQuery) {
			$this->SQL->Select('*', 'count', 'RowCount');
			$Offset = FALSE;
			$Limit = FALSE;
			$OrderBy = FALSE;
		}

		if (!$bCountQuery) {
			$IsSelectRow = GetValue('f.FeedbackID', $Conditions);

			$InsertUserInfo = GetValue('InsertUserInfo', $Conditions, FALSE, TRUE);
			if ($InsertUserInfo) {
				$this->SQL
					->LeftJoin('User u', 'u.UserID = f.InsertUserID')
					->Select('f.YourName, u.Name', 'coalesce', 'InsertName')
					->Select('f.YourEmail, u.Email', 'coalesce', 'InsertEmail')
					->Select('u.Gender', '', 'InsertGender');
			}
		}

		if ($OrderBy !== FALSE) {
			$OrderBys = array_map('trim', explode(',', $OrderBy));
			foreach ($OrderBys as $OrderBy) {
				if (!strpos($OrderBy, ' ')) {
					$OrderBy .= ' ' .  $OrderDirection;
				}
				list($Field, $Direction) = explode(' ', $OrderBy);
				$this->SQL->OrderBy($Field, $Direction);
			}
		}

		$this->EventArguments['bCountQuery'] = $bCountQuery;
		$this->EventArguments['Conditions'] =& $Conditions;
		$this->FireEvent('BeforeGet');

		if (is_array($Conditions)) {
			$this->SQL->Where($Conditions);
		}

		$Alias = 'f';
		$Result = $this->SQL
			->From($this->Name . ' ' . $Alias)
			->Limit($Limit, $Offset)
			->Get();
		if ($bCountQuery) {
			$Result = $Result->FirstRow()->RowCount;
		}
		
		return $Result;
	}

	public function IsDoublePost($FormValues) {
		$LastFeedback = Gdn_Model::Get('FeedbackID', 'desc', 1)->FirstRow();
		$Result = ($LastFeedback && $LastFeedback->Message == $FormValues['Message']);
		return $Result;
	}

	public function Save($Values, $Settings = FALSE) {
		$Values = self::SetNullValues($Values);
		$IsAuthorized = GetValue('IsAuthorized', $Settings, Gdn::Session()->IsValid());
		$SendMessage = GetValue('SendMessage', $Settings, FALSE);
		$IsInsert = (GetValue('FeedbackID', $Values) === FALSE);
		
		if (!$IsAuthorized) {
			$this->Validation->ApplyRule('YourName', 'Required', 'You must enter your name.');
			$this->Validation->ApplyRule('YourEmail', 'Required');
			$this->Validation->ApplyRule('YourEmail', 'Email', 'You must enter your e-mail (will not be published).');
		}

		$this->Validation->ApplyRule('Message', 'Required');
		$RowID = parent::Save($Values);
		
		if ($RowID) {
			if ($SendMessage) {
				$this->SendMessage($RowID);
			}
		}

		return $RowID;
	}

	public function SendMessage($RowID) {
		$Message = $this->GetID($RowID);
		$User = UserBuilder($Message, 'Insert');
		$Data = array('Message' => $Message, 'User' => $User);
		$Subject = FormatString(T('FeedbackTwo.Email.Subject'), $Data);
		$Body = FormatString(T('FeedbackTwo.Email.Body'), $Data);

		$To = C('Plugins.FeedbackTwo.To');
		if (!$To) return FALSE;

		$Email = new Gdn_Email();
		if (C('Plugins.FeedbackTwo.Bcc')) {
			$Email->Bcc(C('Plugins.FeedbackTwo.Bcc'));
		}
	
		try {
			$Email
				->Subject($Subject)
				->To($To)
				->From($Message->YourEmail, $Message->YourName)
				->Message($Body)
				->Send();
		} catch (Exception $Exception) {
			trigger_error($Exception->GetMessage());
		}
	}

	public static function SetNullValues(&$Fields, $Nulls = array('')) {
		if (!is_array($Nulls)) $Nulls = array_slice(func_get_args(), 1);
		foreach ($Fields as &$Value) {
			if (is_scalar($Value) && in_array($Value, $Nulls, TRUE)) $Value = NULL;
		}
		return $Fields;
	}
}