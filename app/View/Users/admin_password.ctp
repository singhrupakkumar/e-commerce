<style>
	.form_outer span{
		width:100%;
		float:left;
		margin-bottom:11px;
	}
	.form_outer span strong{
		font-weight:bold;
	}
	.form_outer form label{
		width:100%;
		float:left;
		margin-bottom:11px;
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
	<h2>Change Password</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<span>
				<strong>Username</strong> : <?php echo $this->Form->value('User.username'); ?>
			</span>
			<?php echo $this->Form->create('User');?>
			<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('password', array('class' => 'form-control', 'value' => '')); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary'));?>
			<?php echo $this->Form->end();?>
		</div>
    </div>
</div>