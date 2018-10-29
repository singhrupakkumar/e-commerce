<style>
.checkbox {
    display: inline-block;
    padding-top: 0;
    margin-top: 0;
    margin-bottom: 0;
    vertical-align: bottom;
}
label[for="TagName"]{
	width:100%;
	float:left;
}
input.form-control{
	width:auto;
	float:left;
}
button.btn-primary{
	float:left;
	margin-left:4px;
}
.btn{
	float:left;
}
form{
	display:table;
	width:100%;
}
.list-inner,
table{
	width:100%;
	float:left;
}
img{
	display:block;
	margin:0 auto;
	max-width:100%;
}
</style>
<div class="page_heading">
	<h2>Edit Product Tag</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td valign="top">
						<?php echo $this->Html->Image('/images/small/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'image')); ?>
					</td>
					<td valign="top">
						Name: <?php echo h($product['Product']['name']); ?>
						<br />
						Tags: '<?php echo $product['Product']['tags']; ?>'
					</td>
				</tr>
			</table>
			<div class="list-inner">
				<?php echo $this->Form->create('Product'); ?>
				<?php echo $this->Form->input('id', array('value' => $product['Product']['id'])); ?>
				<br />
				<table class="table-striped table-bordered table-condensed table-hover">
					<tr>
						<td valign="top">
							<?php $rows = ceil(count($tags) / 8); ?>
							<?php $counter = 0; ?>
							<?php foreach ($tags as $k => $v) : ?>
							<?php
								echo $this->Form->input("Product.tags][]", array(
									'type' => 'checkbox',
									'hiddenField' => false,
									'label' => $v,
									'value' => $v,
									'id' => $v,
									'checked' => (in_array($v, $selectedTags)) ? 'checked' : false,
								));
							?>
							<br />
							<?php $counter++; ?>
							<?php if($counter % $rows === 0 ) : ?>
						</td>
						<td valign="top">
							<?php endif; ?>
							<?php endforeach; ?>
						</td>
					</tr>
				</table>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="list-inner">
				<h2>Add New Tag</h2>
				<?php echo $this->Form->create('Tag', array('url' => array('controller' => 'tags', 'action' => 'add'))); ?>
				<?php echo $this->Form->input('name', array('class' => 'form-control', 'div' => false)); ?>
				<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>