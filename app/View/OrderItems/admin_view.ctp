<style>
	table{
		width:100%;
		margin:0px;
	}
	table img{
		width:100%;
	}
</style>
<div class="page_heading">
	<h2>View Order Item</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tbody>
					<tr>
						<td>ID</td>
						<td><?php echo $orderitem['OrderItem']['id'];?></td>
					</tr>
					<tr>
						<td>Order</td>
						<td><a href="<?php echo $this->webroot."admin/orders/view".$orderitem['OrderItem']['order_id'];?>"><?php echo $orderitem['OrderItem']['order_id'];?></a></td>
					</tr>
					<tr>
						<td>Product ID</td>
						<td><?php echo $orderitem['OrderItem']['product_id'];?></td>
					</tr>
					<tr>
						<td>Name</td>
						<td><?php echo $orderitem['OrderItem']['name'];?></td>
					</tr>
					<tr>
						<td>Image</td>
						<td><img src="<?php echo $orderitem['OrderItem']['image'];?>"></td>
					</tr>
					<tr>
						<td>Quantity</td>
						<td><?php echo $orderitem['OrderItem']['quantity'];?></td>
					</tr>
					<tr>
						<td>Weight</td>
						<td><?php echo $orderitem['OrderItem']['weight'];?></td>
					</tr>
					<tr>
						<td>Price</td>
						<td><?php echo $orderitem['OrderItem']['price'];?></td>
					</tr>
					<tr>
						<td>Subtotal</td>
						<td><?php echo $orderitem['OrderItem']['subtotal'];?></td>
					</tr>
					<tr>
						<td>Created</td>
						<td><?php echo $orderitem['OrderItem']['created'];?></td>
					</tr>
					<tr>
						<td>Modified</td>
						<td><?php echo $orderitem['OrderItem']['modified'];?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>