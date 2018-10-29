<style>
	.form_outer form .input{
		width:100%;
		float:left;
		margin-bottom:11px;
	}
	.form_outer form label{
		width:100%;
		float:left;
	}
</style>
<div class="page_heading">
	<h2>Add User</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
        <?php echo $this->Form->create('User');?>
        <?php echo $this->Form->input('role', array('class' => 'form-control', 'options' => array('admin' => 'admin', 'customer' => 'customer'))); ?>
        <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
        <?php echo $this->Form->input('username', array('class' => 'form-control')); ?>
        <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
        <?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>