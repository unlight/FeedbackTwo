<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo $this->Data('Title');?> <?php echo Anchor(T('Feedback'), '/feedback', '', array('target' => '_blank'));?></h1>

<?php echo $this->Form->Open(); ?>
<?php echo $this->Form->Errors(); ?>

<ul>

<li><?php 
	echo $this->Form->Label('Plugins.FeedbackTwo.To', 'Plugins.FeedbackTwo.To');
	echo $this->Form->TextBox('Plugins.FeedbackTwo.To');
	echo Wrap(T('FeedbackTwo.To.Description', 'p'));
	?>
</li>

<li><?php 
	echo $this->Form->Label('Plugins.FeedbackTwo.Bcc', 'Plugins.FeedbackTwo.Bcc');
	echo $this->Form->TextBox('Plugins.FeedbackTwo.Bcc');
	echo Wrap(T('FeedbackTwo.Bcc.Description', 'p'));
	?>
</li>

<?php if (C('EnabledApplications.Candy')): ?>
	<li>
	<?php 
		echo $this->Form->Label('Plugins.FeedbackTwo.ChunkID', 'Plugins.FeedbackTwo.ChunkID');
		echo $this->Form->TextBox('Plugins.FeedbackTwo.ChunkID');
		$Description = sprintf(T('FeedbackTwo.ChunkID.Description'), Url('/candy/chunk/browse'), Url('/candy/chunk/update'));
		echo Wrap($Description, 'p');
		?>
	</li>
<?php endif; ?>

</ul>

<?php echo $this->Form->Button('Save'); ?>
<?php echo $this->Form->Close(); ?>