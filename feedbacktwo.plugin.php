<?php if (!defined('APPLICATION')) exit();

$PluginInfo['FeedbackTwo'] = array(
	'Name' => 'Feedback 2',
	'Description' => 'Page with simple form of response.',
	'Version' => '1.0.0',
	'Date' => '10.09.2012 15:23:52',
	'Updated' => '12.09.2012 4:00:18',
	'Author' => 'S',
	'AuthorUrl' => 'http://rv-home.ru/',
	'RequiredApplications' => array(
		'Dashboard' => '>=2.0.18'
	),
	'SettingsUrl' => '/settings/feedbacktwo',
	'RequiredTheme' => FALSE,
	'RequiredPlugins' => FALSE,
	'RegisterPermissions' => FALSE,
	'SettingsPermission' => FALSE,
	'License' => 'X.Net License'
);

class FeedbackTwoPlugin extends Gdn_Plugin {
	
	public function RootController_Feedback_Create($Sender) {
		$Form = Gdn::Factory('Form');
		$Sender->Form = $Form;
		$FeedbackModel = new FeedbackModel();
		$Form->SetModel($FeedbackModel);
		
		if ($Form->IsPostBack()) {
			self::CureName($Sender);
			// Check for double post.
			if (!$FeedbackModel->IsDoublePost($Form->FormValues())) {
				$Settings = array('SendMessage' => TRUE);
				$FeedbackID = $Form->Save($Settings);
				if ($FeedbackID) {
					$Sender->View = $this->GetView('thankyou.php');	
				}
			} else {
				$Sender->View = $this->GetView('thankyou.php');	
			}
		}

		$Sender->Head = new HeadModule($Sender);
		$Sender->AddJsFile('jquery.js');
		$Sender->AddJsFile('jquery.livequery.js');
		$Sender->AddJsFile('jquery.autogrow.js');
		$Sender->AddJsFile('global.js');
		$Sender->AddJsFile('plugins/FeedbackTwo/js/feedbacktwo.js');
		$Sender->AddCssFile('style.css');
		$Sender->AddCssFile('plugins/FeedbackTwo/design/style.css');
		$Sender->MasterView = 'default';
		if (!$Sender->View) {
			$Sender->View = $this->GetView('index.php');	
		}
		$Sender->Title(T('FeedbackTwo.Title', T('Feedback')));
		$Sender->Render();
	}

	public function SettingsController_FeedbackTwo_Create($Sender) {
		$Sender->Permission('Garden.Plugins.Manage');
		$Sender->AddSideMenu();
		$Form = Gdn::Factory('Form');
		$Sender->Form = $Form;
		$Validation = new Gdn_Validation();
		$ConfigurationModel = new Gdn_ConfigurationModel($Validation);
		$ConfigurationModel->SetField(array(
			'Plugins.FeedbackTwo.To',
			'Plugins.FeedbackTwo.Bcc',
			'Plugins.FeedbackTwo.ChunkID'
		));
		$Form->SetModel($ConfigurationModel);
		$FormValues = $Form->FormValues();
		if (GetValue('Plugins.FeedbackTwo.ChunkID', $FormValues)) {
			settype($FormValues['Plugins.FeedbackTwo.ChunkID'], 'int');
		}
		$Form->FormValues($FormValues);
		// If seeing the form for the first time...
		if ($Form->AuthenticatedPostBack() === FALSE) {
			// Apply the config settings to the form.
			$Form->SetData($ConfigurationModel->Data);
		} else {
			// Define some validation rules for the fields being saved.
			$ConfigurationModel->Validation->ApplyRule('Plugins.FeedbackTwo.To', 'Required');
			$ConfigurationModel->Validation->ApplyRule('Plugins.FeedbackTwo.ChunkID', 'Integer');
			if ($Form->Save() !== FALSE) {
				self::InformMessage(T('Saved'));
			}
		}
		$Sender->Title(T('Settings'), T('FeedbackTwo.Title', T('Feedback')));
		$Sender->View = $this->GetView('settings.php');
		$Sender->Render();
	}

	/**
	* Fixes name. 
	* 
	* @param mixed 
	* @return mixed $Result.
	*/

	protected function CureName($Sender) {
		$Form = $Sender->Form;
		$Name = trim($Form->GetFormValue('Name'));
		if (function_exists('mb_convert_case')) {
			$Name = mb_convert_case($Name, MB_CASE_TITLE, 'utf-8');
		}
		$Form->SetFormValue('Name', $Name);
	}

	public function Structure() {
		Gdn::Structure()
			->Engine('MyISAM')
			->Table('Feedback')
			->PrimaryKey('FeedbackID', 'int')
			->Column('YourName', 'varchar(120)', True)
			->Column('YourEmail', 'varchar(80)', True)
			->Column('InsertUserID', 'int', True)
			->Column('DateInserted', 'datetime')
			->Column('InsertUserID', 'int', True)
			->Column('InsertIPAddress', 'varchar(15)', True)
			->Column('Phone', 'varchar(20)', True)
			->Column('Message', 'text')
			->Set(FALSE, FALSE);
	}
	
	public function Setup() {
		$this->Structure();
	}

	private static function InformMessage($Message, $Sprite = 'Check') {
		$Controller = Gdn::Controller();
		if ($Controller) {
			$Options = array('Sprite' => $Sprite, 'CssClass' => 'Dismissable AutoDismiss');
			$Controller->InformMessage($Message, $Options);
		}
	}
}