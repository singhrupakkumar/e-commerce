<h1>Login</h1>

<br />

<div class="row">
    <div class="col-sm-3">

        <?php echo $this->Form->create('User', array('action' => 'login')); ?>
        <?php echo $this->Form->input('username', array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
        <br />
        <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
        <br />
        <?php echo $this->Form->button('Login', array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>
        <br />
        <br />
        <br />

    </div>
</div>