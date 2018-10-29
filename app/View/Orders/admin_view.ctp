<style>
	.form_outer{
		margin-bottom:20px;
	}
	.form_outer.no-margin{
		margin:0px;
	}
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Order</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($order['Order']['id']); ?></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><?php echo h($order['Order']['first_name']); ?></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><?php echo h($order['Order']['last_name']); ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo h($order['Order']['email']); ?></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td><?php echo h($order['Order']['phone']); ?></td>
				</tr>
			 
				<tr>
					<td>Shipping Address</td>
					<td><?php echo h($order['Order']['shipping_address']); ?></td>
				</tr>
				<tr>
					<td>Shipping Address2</td>
					<td><?php echo h($order['Order']['shipping_address2']); ?></td>
				</tr>
				<tr>
					<td>Shipping City</td>
					<td><?php echo h($order['Order']['shipping_city']); ?></td>
				</tr>
				<tr>
					<td>Shipping Zip</td>
					<td><?php echo h($order['Order']['shipping_zip']); ?></td>
				</tr>
				<tr>
					<td>Shipping State</td>
					<td><?php echo h($order['Order']['shipping_state']); ?></td>
				</tr>
				<tr>
					<td>Shipping Country</td>
					<td><?php echo h($order['Order']['shipping_country']); ?></td>
				</tr>
				<tr>
					<td>Weight</td>
					<td><?php echo h($order['Order']['weight']); ?></td>
				</tr>
				<tr>
					<td>Order Item Count</td>
					<td><?php echo h($order['Order']['order_item_count']); ?></td>
				</tr>
				<tr>
					<td>Subtotal</td>
					<td><?php echo h($order['Order']['subtotal']); ?></td>
				</tr>
				<tr>
					<td>Total</td>
					<td><?php echo h($order['Order']['total']); ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?php echo h($order['Order']['status']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($order['Order']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($order['Order']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="page_heading">
	<h2>Related Order Items</h2>
</div>
<div class="row">
	<div class="col-sm-10">
		<div class="form_outer no-margin">
			<?php if (!empty($order['OrderItem'])): ?>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th>Id</th>
					<th>Order Id</th>
					<th>Product Id</th>
					<th>Name</th>
					<th>Quantity</th>
					<th>Weight</th>
					<th>Price</th>
					<th>Subtotal</th>
					<th>Created</th>
					<th>Modified</th>
					<th>Actions</th>
				</tr>
				<?php foreach ($order['OrderItem'] as $orderItem): ?>
				<tr>
					<td><?php echo $orderItem['id']; ?></td>
					<td><?php echo $orderItem['order_id']; ?></td>
					<td><?php echo $orderItem['product_id']; ?></td>
					<td><?php echo $orderItem['name']; ?></td>
					<td><?php echo $orderItem['quantity']; ?></td>
					<td><?php echo $orderItem['weight']; ?></td>
					<td><?php echo $orderItem['price']; ?></td>
					<td><?php echo $orderItem['subtotal']; ?></td>
					<td><?php echo $orderItem['created']; ?></td>
					<td><?php echo $orderItem['modified']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('controller' => 'order_items', 'action' => 'view', $orderItem['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php echo $this->Html->link('Edit', array('controller' => 'order_items', 'action' => 'edit', $orderItem['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<?php echo $this->Form->postLink('Delete', array('controller' => 'order_items', 'action' => 'delete', $orderItem['id']), array('class' => 'btn btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $orderItem['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<?php endif; ?>
		</div>
	</div>
</div>
