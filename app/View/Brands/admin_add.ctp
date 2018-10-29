<style>
	.form_outer form,
	.form_outer .input,
	.form_outer label{
		width:100%;
		float:left;
	}
	.form_outer .input{
		margin-bottom:11px !important;
	}
</style>
<div class="page_heading">
	<h2>Add Band</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Brand'); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>