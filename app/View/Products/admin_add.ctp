<style>
	.form_outer form,
	.form_outer .input,
	.form_outer label,{
		width:100%;
		float:left;
	}
	.form_outer .input{
		margin-bottom:11px !important;
	}
</style>
<div class="page_heading">
	<h2>Add New Product</h2>
</div>

<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Product',array('type'=>'file')); ?>
			<?php echo $this->Form->input('category_id', array('class' => 'form-control','empty'=>'Select Category')); ?>
			<div class="row" id="row_dim">
				<?php echo $this->Form->input('brand_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('series', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('mechanism_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('woodtype_id', array('class' => 'form-control','empty'=>'Select')); ?>
			</div>
			<div id="row_dim1">
				<?php echo $this->Form->input('colour_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('theme_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('style_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('gemstone_id', array('class' => 'form-control','empty'=>'Select')); ?>
				<?php echo $this->Form->input('material_id', array('class' => 'form-control','empty'=>'Select')); ?>
			</div>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('description', array('class' => 'form-control ckeditor')); ?>
			<?php echo $this->Form->input('feature', array('class' => 'form-control ckeditor')); ?>
			<?php echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control')); ?>  
			<h5>Only Youtube embed URL</h5> 
			<?php echo $this->Form->input('video', array('class' => 'form-control')); ?> 
			<?php echo $this->Form->input('price', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('weight', array('class' => 'form-control')); ?>
			<?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
			<?php echo $this->Form->input('on_sale', array('type' => 'checkbox')); ?> 
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>
<script>
$(function() {
    $('#row_dim').hide(); 
	$('#row_dim1').hide(); 	
    $('#ProductCategoryId').change(function(){
		
        if($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3') {
            $('#row_dim').show();
			$('#row_dim1').hide();	
        }else if($(this).val() == '4' || $(this).val() == '5' || $(this).val() == '6'){
		 $('#row_dim1').show(); 
		$('#row_dim').hide();	
		}
		else { 
            $('#row_dim').hide();
			$('#row_dim1').hide();	
        } 
    });
});
</script>