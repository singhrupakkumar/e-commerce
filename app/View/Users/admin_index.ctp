<style>
	.form_outer{
		margin-bottom:20px;
	}
	table{
		width:100%;
		margin:0px;
	}
	table tr .actions{
		width:29% !important;
	}
	.pull-right .search_user{
		width:100%;
		float:left;
	}
	.pull-right .btn{
		float:right;
	}
	.pull-right input.form-control{
		width:auto;
		float:right;
		margin-right:4px;
	}
</style>
<div class="page_heading">
	<h2>Users</h2>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form_outer">
			<div class="up-img_sec">
				<form id="" class="col-sm-5 pull-right" action="">
					<div class="search_user">
						<button type="submit" class="search_button1 btn btn-primary">Search</button>
						<input type="text" class="form-control" placeholder="Search User by Email">
					</div>
				</form>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>

					<th><?php echo $this->Paginator->sort('role');?></th>
					<th><?php echo $this->Paginator->sort('name');?></th>
					<th><?php echo $this->Paginator->sort('username');?></th>
					<th><?php echo $this->Paginator->sort('active');?></th>
					<th><?php echo $this->Paginator->sort('created');?></th>
					<th><?php echo $this->Paginator->sort('modified');?></th>
					<th class="actions">Actions</th>
				</tr>
				<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo h($user['User']['role']); ?></td>
					<td><?php echo h($user['User']['name']); ?></td>
					<td><?php echo h($user['User']['username']); ?></td>
					<td><?php echo h($user['User']['active']); ?></td>
					<td><?php echo h($user['User']['created']); ?></td>
					<td><?php echo h($user['User']['modified']); ?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php echo $this->Html->link('Change Password', array('action' => 'password', $user['User']['id']), array('class' => 'btn btn-default btn-xs btn-tags')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<?php echo $this->Form->postLink('Delete User', array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-default btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>