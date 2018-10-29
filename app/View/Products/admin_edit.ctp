<div class="page_heading">
	<h2>Edit Product</h2>
</div>   
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<?php echo $this->Form->create('Product',array('type'=>'file')); ?>
			<?php echo $this->Form->input('id'); ?>
			<br />
			<?php echo $this->Form->input('category_id', array('class' => 'form-control','empty'=>'Select Category')); ?>
			<br />
			<div class="row" id="row_dim">
			<?php echo $this->Form->input('brand_id', array('class' => 'form-control','empty'=>'Select')); ?>
			<br />
			 <?php echo $this->Form->input('woodtype_id', array('class' => 'form-control','empty'=>'Select')); ?>
			<br />
				<?php echo $this->Form->input('mechanism_id', array('class' => 'form-control','empty'=>'Select')); ?> 
			<br />
			<?php echo $this->Form->input('series', array('class' => 'form-control','empty'=>'Select')); ?>
			<br />
			</div>
			<div id="row_dim1">
        <?php echo $this->Form->input('colour_id', array('class' => 'form-control','empty'=>'Select')); ?>
        <br />
        <?php echo $this->Form->input('theme_id', array('class' => 'form-control','empty'=>'Select')); ?>
        <br />
        <?php echo $this->Form->input('style_id', array('class' => 'form-control','empty'=>'Select')); ?>
        <br />
        <?php echo $this->Form->input('gemstone_id', array('class' => 'form-control','empty'=>'Select')); ?>
        
        <br />
        <?php echo $this->Form->input('material_id', array('class' => 'form-control','empty'=>'Select')); ?>
        <br />
        </div>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
			<br /> 
			<?php echo $this->Form->input('slug', array('class' => 'form-control')); ?>
			<br />
			<?php echo $this->Form->input('description', array('class' => 'form-control ckeditor')); ?>
			 <br />
			<?php echo $this->Form->input('feature', array('class' => 'form-control ckeditor')); ?> 
			<br />
			<?php echo $this->Html->Image('/images/large/'.$product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => 'image', 'class' => 'image'));
			echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control')); ?> 
			<br />
			<h5>Only youtube embed url </h5>  
			<?php echo $this->Form->input('video', array('class' => 'form-control')); ?> 
			<br /> 
			<?php echo $this->Form->input('price', array('class' => 'form-control')); ?>  
			<br />
			<?php echo $this->Form->input('weight', array('class' => 'form-control')); ?>
			<br />
			<?php echo $this->Form->input('active', array('type' => 'checkbox')); ?>
			<br />
			<?php echo $this->Form->input('on_sale', array('type' => 'checkbox')); ?>
			<br />
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
    </div>
</div>
<?php echo $this->Html->script('ckeditor/ckeditor', array('inline' => false)); ?>
<script type="text/javascript">
    var basePath = "<?php echo Router::url('/'); ?>";
    CKEDITOR.replace('ProductDescription', {
        filebrowserBrowseUrl : basePath + 'js/kcfinder/browse.php?type=files',
        filebrowserImageBrowseUrl : basePath + 'js/kcfinder/browse.php?type=images',
        filebrowserFlashBrowseUrl : basePath + 'js/kcfinder/browse.php?type=flash',
        filebrowserUploadUrl : basePath + 'js/kcfinder/upload.php?type=files',
        filebrowserImageUploadUrl : basePath + 'js/kcfinder/upload.php?type=images',
        filebrowserFlashUploadUrl : basePath + 'js/kcfinder/upload.php?type=flash' 
    });
</script>

<script>
$(function() {
    $('#row_dim').hide(); 
	$('#row_dim1').hide(); 	
   var cat = $('#ProductCategoryId').val();
		
        if(cat == '1' || cat == '2' || cat == '3') {
            $('#row_dim').show();
			$('#row_dim1').hide();	
        }else if(cat == '4' || cat == '5' || cat == '6'){
		 $('#row_dim1').show(); 
		$('#row_dim').hide();	
		}
		else { 
            $('#row_dim').hide();
			$('#row_dim1').hide();	
        } 
  
});
</script>


