<div class="page_heading">
	<h2>Add Static page</h2>
</div>
<p>
	<?php $x=$this->Session->flash();
		if($x){ ?>
	<div class="alert success">
		<span class="icon"></span>
		<strong>Success!</strong>
		<?php echo $x; ?>
	</div>
	<?php } ?>
</p>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
            <?php echo $this->Form->create('Staticpage',array('id'=>'tab','type'=>'file')); ?>
				<div class="form-group"> 
					<label>Position</label>
					<?php echo $this->Form->select('position',array('about'=>'About Us', 'blog' => 'Blog', 'outstory' => 'Our Story', 
					't&c'=>'Term & Conditions','return&exchange' => 'Return & Exchange',
					'about_wear_org' => 'About Wear Organic','green&plant' => 'Green Plant', 'home' => 'Welcome to Shop','faq' => 'Faq'),
					array('class'=>'form-control','empty' => '--Select position--','required'))
					?>
				</div>
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="data[Staticpage][title]" class="form-control span12">                        
				</div>
				<div class="form-group">
					<label>Image</label> 
					<input class="form-control" type="file" name="data[Staticpage][image]">
				</div>  
				<div class="form-group">
					<?php echo $this->Form->input('show_main', array('type' => 'checkbox')); ?> 
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea rows="2" name="data[Staticpage][description]" class="form-control" id="edi" ></textarea>
				</div>
				<h6>If add FAQ question please select category</h6>
				<div class="form-group">
					<label>Categories</label> 
					<select class="form-control" name="data[Staticpage][category]">
						<option value="0">Payments</option>
						<option value="1">How it works</option>
						<option value="2">Delivery delay</option>
						<option value="3">Takeaway</option>
						<option value="4">Preorder</option>
						<option value="5">Register</option>
						<option value="6">Pricing</option>
						<option value="7">Privacy</option>
					</select>
				</div>
				<input type="hidden" name="data[Staticpage][created]" value="<?php echo date('Y-m-d H:i:s'); ?>">
				<input type="hidden" name="data[Staticpage][status]" value="1">
				<div class="btn-toolbar list-toolbar">
					<button class="btn btn-primary" name="submit">Save</button>
				</div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
    
   <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
             selector: "#edi",
             plugins : "media"

    });
    </script>