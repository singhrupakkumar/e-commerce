<style>
	.form_outer form .input{
		width:100%;
		float:left;
		margin-bottom:11px;
	}
</style>
<div class="page_heading">
	<h2>Edit Order</h2>
</div>
<div class="row">
    <div class="col col-lg-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Order'); ?>
			<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('first_name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('last_name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('phone', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_address', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_address2', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_city', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_zip', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_state', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('shipping_country', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('weight', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('order_item_count', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('subtotal', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('total', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('status', array('class' => 'form-control')); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary'));?>
			<?php echo $this->Form->end();?>
		</div>
    </div>
</div>