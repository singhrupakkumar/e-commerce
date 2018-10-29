<style>
	.pull-right form{
		width:100%;
		float:left;
	}
	.pull-right form .search_username{
		width:100%;
		float:left;
	}
	.search_username .form-control{
		width:auto;
		float:right;
		margin-right:4px;
	}
	.search_username .btn{
		float:right;
	}
	.form_outer{
		margin-bottom:20px;
	}
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Static Pages</h2>
</div>
<p>
    <?php $x = $this->Session->flash();
		if ($x) { ?>
		<div class="alert success">
			<span class="icon"></span>
			<strong></strong><?php echo $x; ?>
		</div>
	<?php } ?>
</p>
<div class="row">
	<div class="col-sm-12">
		<div class="form_outer">
			<div class="up-img_sec">
				<a href="<?php echo $this->Html->url(array('controller' => 'Staticpages', 'action' => 'admin_add')); ?>"><span class="btn btn-default"><i class="fa fa-plus"></i>Add New Page</span></a>
				<div class="col-sm-5 pull-right">
					<?php echo $this->Form->create("Staticpage", array("action" => "admin_index")); ?>
						<div class="search_username">
							<button type="submit" class="search_button1 btn btn-primary">Search</button>
							<input type="text" name="keyword" value="<?php if (@$keyword) {
								echo $keyword;
								} ?>" placeholder="Search Here !!!" class="form-control"/>
						</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
			<?php echo $this->Form->create('Staticpage', array("action" => "deleteall", 'id' => 'mbc')); ?>
			<table class="table-striped table-bordered table-condensed table-hover">
				<thead>
					<tr>
					   <th><?php echo $this->Paginator->sort('Title'); ?></th>
						<th><?php echo $this->Paginator->sort('Image'); ?></th>
						<th><?php echo $this->Paginator->sort('Created'); ?></th>
						<th><?php echo $this->Paginator->sort('Status'); ?></th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if($staticpages){
					if(isset($staticpages)){
					foreach ($staticpages as $staticpage){ ?>
						<tr>
							<td><?php echo h($staticpage['Staticpage']['title']); ?>&nbsp;</td>
							<td>
							<?php
								$ext = pathinfo($staticpage['Staticpage']['image'], PATHINFO_EXTENSION);
								if(empty($ext)){
								echo  'No Image';
							}
							else
								{
								echo $this->Html->image('../files/staticpage/'.$staticpage['Staticpage']['image']
								,array('alt'=>'Not Image','height'=>'70px','width'=>'100px')); 
								}
							?> 
							</td>
							<td><?php echo h($staticpage['Staticpage']['created']); ?>&nbsp;</td>
							<td>
								<?php if($staticpage['Staticpage']['status']==1){ echo "Active"; }else { echo "Block";}?>&nbsp;
							</td>
							<td class="actions">
								<?php echo $this->Html->link(__('View'), array('action' => 'view', $staticpage['Staticpage']['id']), array('class' => 'view1 btn btn-default btn-xs btn-view')); ?>	
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $staticpage['Staticpage']['id']), array('class' => 'edit1 btn btn-default btn-xs btn-edit')); ?>
								<?php //echo $this->Form->postLink(__('Delete'),array('action' => 'delete', $staticpage['Staticpage']['id']), array('class' => 'delete1'), __('Are you sure you want to delete # %s?', $staticpage['Staticpage']['id'])); ?>   
							</td>
						</tr>
					 <?php } } } else { { ?> 
					<p class="not_found">NOT FOUND</p>
					 <?php } } ?>
				</tbody>
			</table>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>