<?php if($ajax != 1): ?>

<?php $this->Html->addCrumb('Search'); ?>

<div class="container">
    
      <div class="col-sm-12">
        <div class="fancy01">
          <h2>Search</h2>
        </div>
          </div>
    
<!--<h1>Search</h1>-->

<br />

<div class="row">

    <div class="center_box">
<?php echo $this->Form->create('Product', array('type' => 'GET')); ?>

<div class="col col-sm-4 col-sm-offset-3">
    <?php echo $this->Form->input('search', array('label' => false, 'div' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'value' => $search)); ?>
</div>

<div class="col col-sm-3">
    <?php echo $this->Form->button('Search', array('div' => false, 'class' => 'btn btn-sm btn-primary black')); ?>
</div>

<?php echo $this->Form->end(); ?>

        </div>
        
</div>

</div><!--container-->
<br />
<br />

<?php endif; ?>

<?php // echo $this->Html->script('search.js', array('inline' => false)); ?>

<?php if(!empty($search)) : ?>

<?php $this->Html->addCrumb($search); ?>

<?php if(!empty($products)) : ?>

<?php echo $this->element('products'); ?>

<br />
<br />
<br />

<?php else: ?>

<h3>No Results</h3>

<?php endif; ?>
<?php endif; ?>

