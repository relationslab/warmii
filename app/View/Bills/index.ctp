<div class="bills index">
	<h2><?php echo __('Bills'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('sender_id'); ?></th>
			<th><?php echo $this->Paginator->sort('letters_id'); ?></th>
			<th><?php echo $this->Paginator->sort('amount'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th><?php echo $this->Paginator->sort('deleted'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($bills as $bill): ?>
	<tr>
		<td><?php echo h($bill['Bill']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bill['Sender']['id'], array('controller' => 'senders', 'action' => 'view', $bill['Sender']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($bill['Letters']['id'], array('controller' => 'letters', 'action' => 'view', $bill['Letters']['id'])); ?>
		</td>
		<td><?php echo h($bill['Bill']['amount']); ?>&nbsp;</td>
		<td><?php echo h($bill['Bill']['created']); ?>&nbsp;</td>
		<td><?php echo h($bill['Bill']['updated']); ?>&nbsp;</td>
		<td><?php echo h($bill['Bill']['deleted']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $bill['Bill']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bill['Bill']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $bill['Bill']['id']), null, __('Are you sure you want to delete # %s?', $bill['Bill']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Bill'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Senders'), array('controller' => 'senders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sender'), array('controller' => 'senders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Letters'), array('controller' => 'letters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Letters'), array('controller' => 'letters', 'action' => 'add')); ?> </li>
	</ul>
</div>
