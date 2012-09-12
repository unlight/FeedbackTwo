<?php
if (!defined('APPLICATION')) die();
// if div has class "AjaxForm" and there is a form in this div, the form will be ajax-posted
?>

<div id="FeedbackForm" class="FeedbackForm">
<h1><?php echo $this->Data('Title');?></h1>

<?php echo $this->Form->Open(); ?>

<?php
	if (Gdn::Session()->CheckPermission('Garden.Plugins.Manage')) { 
		echo '<p>'. Anchor(T('Settings'), '/settings/feedbacktwo').'</p>';
	}
?>
	
<?php if (function_exists('Chunk') && C('Plugins.Feedback.ChunkID')) echo Chunk(C('Plugins.Feedback.ChunkID')) ?>

<?php echo $this->Form->Errors() ?>

<ul>
	
	<?php if (!Gdn::Session()->IsValid()): ?>
	<li><?php 
		echo $this->Form->Label('Your Name', 'YourName');
		echo $this->Form->TextBox('YourName');?>
	</li>
	<li><?php 
		echo $this->Form->Label('Your Email', 'YourEmail');
		echo $this->Form->TextBox('YourEmail');?>
	</li>
	<?php endif; ?>
	
	<?php if (C('Plugins.FeedbackTwo.ShowPhoneField')): ?>
	<li><?php
		echo $this->Form->Label('Your Phone', 'Phone');
		echo $this->Form->TextBox('Phone');?>
	</li>
	<?php endif; ?>

	<li><?php 
		echo $this->Form->Label('Feedback message', 'Message', array('class' => 'FullWidth'));
		echo $this->Form->TextBox('Message', array('Multiline' => TRUE, 'class' => 'TextBox FullWidth'));?>
	</li>
</ul>

<?php echo $this->Form->Button('Send Message', array ('style' => 'font-size: 110%')) ?>
<?php echo $this->Form->Close() ?>
</div>