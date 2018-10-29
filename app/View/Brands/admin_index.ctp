<style>
	.form_outer{
		margin-bottom:20px;
	}
	.form_outer table{
		width:100%;
		margin:0px;
	}
	.form_outer table .actions{
		width:33% !important;
	}
</style>
<div class="page_heading">
	<h2>Bands</h2>
</div>
<div class="row">
	<div class="col-sm-7">
		<div class="form_outer">
			<div class="up-img_sec">
				<?php echo $this->Html->link('Add New Band', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('slug'); ?></th>
					<th><?php echo $this->Paginator->sort('active'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions">Actions</th>
				</tr>
				<?php foreach ($brands as $brand): ?>
					<tr>
						<td><?php echo h($brand['Brand']['id']); ?></td>
						<td><?php echo h($brand['Brand']['name']); ?></td>
						<td><?php echo h($brand['Brand']['slug']); ?></td>
						<td><?php echo $this->Html->link($this->Html->image('icon_' . $brand['Brand']['active'] . '.png'), array('controller' => 'brands', 'action' => 'switch', 'active', $brand['Brand']['id']), array('class' => 'status', 'escape' => false)); ?></td>
						<td><?php echo h($brand['Brand']['created']); ?></td>
						<td><?php echo h($brand['Brand']['modified']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link('View', array('action' => 'view', $brand['Brand']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
							<?php echo $this->Html->link('Edit', array('action' => 'edit', $brand['Brand']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
							<?php echo $this->Form->postLink('Delete Band', array('action' => 'delete', $brand['Brand']['id']), array('class' => 'btn btn-default btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $brand['Brand']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>