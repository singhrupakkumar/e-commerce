<style>
	table{
		width:100%;
		margin:0px;
	}
	.form_outer{
		margin-bottom:20px;
	}
	table tr th:nth-child(2){
		width:40% !important;
	}
	table tr th:nth-child(5),
	table tr th:nth-child(6),
	table tr th:nth-child(7),
	table tr th:nth-child(8){
		width:11% !important;
	}
</style>
<div class="page_heading">
	<h2><?php echo __('Review'); ?></h2>
</div>
<div class="row">
	<div class="col-sm-10">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<thead>
					<tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th> 
							<th><?php echo $this->Paginator->sort('Product'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('email'); ?></th>
							<th><?php echo $this->Paginator->sort('Product Review'); ?></th>
							<th><?php echo $this->Paginator->sort('Product Rating'); ?></th>
							<th><?php echo $this->Paginator->sort('created'); ?></th>
							<th><?php echo $this->Paginator->sort('modified'); ?></th>         
							<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($reviews as $time): ?>
					<tr>
						<td><?php echo h($time['Review']['id']); ?>&nbsp;</td>
						<td><?php echo h($time['Product']['name']); ?>&nbsp;</td>

						<td><?php echo h($time['Review']['name']); ?>&nbsp;</td>
						<td><?php echo h($time['Review']['email']); ?>&nbsp;</td>
						<td><?php echo h($time['Review']['text']); ?>&nbsp;</td>
						<td><?php echo h($time['Review']['punctuality']); ?>&nbsp;</td>
						<td><?php echo h($time['Review']['created']); ?>&nbsp;</td>
						<td><?php echo h($time['Review']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $time['Review']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
							
							<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $time['Review']['id']), array(), __('Are you sure you want to delete # %s?', $time['Review']['id'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
	<p>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
		));
		?>	
	</p>
	<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>

