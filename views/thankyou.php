<?php
if (!defined('APPLICATION')) die();
?>

<div class="FeedbackForm">
<h1><?php echo T('Feedback');?></h1>

<?php 
	if (Gdn::Session()->CheckPermission('Garden.Plugins.Manage'))
		echo '<p>'. Anchor(T('Settings'), '/settings/feedbacktwo').'</p>';
?>
	
<?php if (function_exists('Chunk') && C('Plugins.Feedback.ChunkID')) echo Chunk(C('Plugins.Feedback.ChunkID')) ?>

<span style="font-size: 200%;">
<?php echo T('Your message has been sent.');?>
</span>

</div>