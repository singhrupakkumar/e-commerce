<style>
	.form_outer form .input{
		width:100%;
		float:left;
		margin-bottom:11px;
	}
</style>
<div class="page_heading">
	<h2>Add Category</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Category'); ?>
			<?php echo $this->Form->input('parent_id', array('class' => 'form-control', 'empty' => true)); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>