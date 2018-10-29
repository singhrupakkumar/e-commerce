<style>
	.form_outer form .input{
		width:100%;
		float:left;
	}
	.form_outer form label{
		width:100%;
		float:left;
	}
	.form_outer form .form-control{
		width:auto;
		float:left;
		margin-right:4px;
	}
	.form_outer form .btn{
		float:left;
	}
</style>
<div class="page_heading">
	<h2>Add Wood Type</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Woodtype'); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control', 'div' => false)); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>