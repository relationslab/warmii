<div class="bills view">
<h2><?php  echo __('Bill'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bill['Bill']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sender'); ?></dt>
		<dd>
			<?php echo $this->Html->link($bill['Sender']['id'], array('controller' => 'senders', 'action' => 'view', $bill['Sender']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Letters'); ?></dt>
		<dd>
			<?php echo $this->Html->link($bill['Letters']['id'], array('controller' => 'letters', 'action' => 'view', $bill['Letters']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($bill['Bill']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($bill['Bill']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($bill['Bill']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($bill['Bill']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bill'), array('action' => 'edit', $bill['Bill']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Bill'), array('action' => 'delete', $bill['Bill']['id']), null, __('Are you sure you want to delete # %s?', $bill['Bill']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Bills'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bill'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Senders'), array('controller' => 'senders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sender'), array('controller' => 'senders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Letters'), array('controller' => 'letters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Letters'), array('controller' => 'letters', 'action' => 'add')); ?> </li>
	</ul>
</div>
