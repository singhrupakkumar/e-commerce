<style>
	table{
		width:100%;
		margin:0px;
	}
	.form_outer{
		margin-bottom:20px;
	}
	.pull-right .filter,
	.pull-right .search_user{
		width:100%;
		float:left;
	}
	.search_user input.form-control{
		width:auto;
		float:right;
		margin-right:4px;
	}
	.search_user .btn{
		float:right;
	}
</style>
<div class="page_heading">
	<h2>Orders</h2>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form_outer">
			<div class="up-img_sec">
				<div class="col-sm-5 pull-right">
					<form id="" class="filter" action="#" >
						<div class="search_user">
							<button type="submit" class="search_button1 btn btn-primary">Search</button>
							<input type="text" class="form-control" placeholder="Search Order by Email">
						</div>
					</form>
				</div>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('first_name'); ?></th>
					<th><?php echo $this->Paginator->sort('last_name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('phone'); ?></th>
					<th><?php echo $this->Paginator->sort('shipping_city'); ?></th>
					<th><?php echo $this->Paginator->sort('shipping_zip'); ?></th>
					<th><?php echo $this->Paginator->sort('shipping_state'); ?></th>
					<th><?php echo $this->Paginator->sort('shipping_country'); ?></th>
					<th><?php echo $this->Paginator->sort('weight'); ?></th>
					<th><?php echo $this->Paginator->sort('subtotal'); ?></th>
					<th><?php echo $this->Paginator->sort('total'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th>Actions</th>
				</tr>
				<?php foreach ($orders as $order): ?>
				<tr>
					<td><?php echo h($order['Order']['first_name']); ?></td>
					<td><?php echo h($order['Order']['last_name']); ?></td>
					<td><?php echo h($order['Order']['email']); ?></td>
					<td><?php echo h($order['Order']['phone']); ?></td>
					<td><?php echo h($order['Order']['shipping_city']); ?></td>
					<td><?php echo h($order['Order']['shipping_zip']); ?></td>
					<td><?php echo h($order['Order']['shipping_state']); ?></td>
					<td><?php echo h($order['Order']['shipping_country']); ?></td>
					<td><?php echo h($order['Order']['weight']); ?></td>
					<td><?php echo h($order['Order']['subtotal']); ?></td>
					<td><?php echo h($order['Order']['total']); ?></td>
					<td><?php echo h($order['Order']['created']); ?></td>
					<td>
					<form method="POST">
					<input type="hidden" name="orderid" value="<?php echo $order['Order']['id']; ?>">
					<input type="hidden" name="user_email" value="<?php echo $order['Order']['email']; ?>">
					<select name="orderstatus" onchange="this.form.submit()" class="dlsts">
						<option value="1" <?php if($order['Order']['status']==1){ echo "selected" ;}?> >Placed</option>
						<option value="2" <?php if($order['Order']['status']==2){ echo "selected" ;}?> >Confirmed</option>
						<option value="3" <?php if($order['Order']['status']==3){ echo "selected" ;}?> >Cancelled</option>
						<option value="4" <?php if($order['Order']['status']==4){ echo "selected" ;}?> >Delivered</option>
				
					</select>
					</form>
					</td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<?php echo $this->Form->postLink('Delete Order', array('action' => 'delete', $order['Order']['id']), array('class' => 'btn btn-default btn-delet'), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>
<?php echo $this->element('pagination'); ?>