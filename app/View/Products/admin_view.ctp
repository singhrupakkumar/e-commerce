<style>
	table{
		width:100%;
		margin:0px;
	}
	.input_file-sec{
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Product</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<div class="up-img_sec">
				<h2>Upload Image</h2>
				<?php echo $this->Form->create('Product', array('type' => 'file')); ?>
				<?php echo $this->Form->input('id', array('value' => $product['Product']['id'])); ?>
				<?php echo $this->Form->input('slug', array('type' => 'hidden', 'value' => $product['Product']['slug'])); ?>
				<div class="input_file-sec">
					<?php echo $this->Form->input('image', array('type' => 'file','div'=>false)); ?>
					<span class="input_img">Choose Image</span>
					<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($product['Product']['id']); ?></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><?php echo $this->Html->Image('/images/small/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'image')); ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo h($product['Product']['name']); ?></td>
				</tr>
				<tr>
					<td>Slug</td>
					<td><?php echo h($product['Product']['slug']); ?></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><?php echo h($product['Product']['description']); ?></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><?php echo h($product['Product']['image']); ?></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><?php echo h($product['Product']['price']); ?></td>
				</tr>
				<tr>
					<td>Weight</td>
					<td><?php echo h($product['Product']['weight']); ?></td>
				</tr>
				<tr>
					<td>Brand</td>
					<td><?php echo h($product['Brand']['name']); ?></td>
				</tr>
				<tr>
					<td>Category</td>
					<td><?php echo h($product['Category']['name']); ?></td>
				</tr>
				<tr>
					<td>Tags</td>
					<td><?php echo h($product['Product']['tags']); ?></td>
				</tr>
				<tr>
					<td>Active</td>
					<td><?php echo $this->Html->link($this->Html->image('icon_' . $product['Product']['active'] . '.png'), array('controller' => 'products', 'action' => 'switch', 'active', $product['Product']['id']), array('class' => 'status', 'escape' => false)); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($product['Product']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($product['Product']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>