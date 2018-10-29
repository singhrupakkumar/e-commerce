 <?php echo $this->set('title_for_layout', 'Bands'); ?>
<?php $this->Html->addCrumb($brand['Brand']['name']); ?>

<h1><?php echo $brand['Brand']['name']; ?><small> Products</small></h1>
<div class="container">
	<div class="row">
<div class="col-sm-12">
<div class="prodcut_view">
    
<?php if (!empty($products)): ?>

<?php echo $this->element('products'); ?>

<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>

<?php endif; ?>

       </div>
    </div>
</div>
</div>