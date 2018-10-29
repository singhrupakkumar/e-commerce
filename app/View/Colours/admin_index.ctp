<style>
	table{
		width:100%;
		margin:0px;
	}
	table td.actions{
		width:28% !important;
	}
	.form_outer{
		margin-bottom:20px;	
	}
</style>
<div class="page_heading">
	<h2>Colors</h2>
</div>
<div class="row">
	<div class="col-sm-7">
		<div class="form_outer">
			<div class="up-img_sec">
				<?php echo $this->Html->link('Add Color', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions">Actions</th>
				</tr>
				<?php
				if(!empty($color)):
				foreach ($color as $tag): ?>
				<tr>
					<td><?php echo $tag['Colour']['id']; ?></td>
					<td><?php echo $tag['Colour']['name']; ?></td>
					<td><?php echo $tag['Colour']['created']; ?></td>
					<td><?php echo $tag['Colour']['modified']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'view', $tag['Colour']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $tag['Colour']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $tag['Colour']['id']), array('class' => 'btn btn-danger btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $tag['Colour']['id'])); ?>
					</td>
				</tr>
				<?php endforeach;
				endif;
				?>
			</table>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>