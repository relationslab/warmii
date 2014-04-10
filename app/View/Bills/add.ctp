<div class="bills form">
<?php echo $this->Form->create('Bill'); ?>
	<fieldset>
		<legend><?php echo __('Add Bill'); ?></legend>
	<?php
		echo $this->Form->input('sender_id');
		echo $this->Form->input('letters_id');
		echo $this->Form->input('amount');
		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Bills'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Senders'), array('controller' => 'senders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sender'), array('controller' => 'senders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Letters'), array('controller' => 'letters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Letters'), array('controller' => 'letters', 'action' => 'add')); ?> </li>
	</ul>
</div>
