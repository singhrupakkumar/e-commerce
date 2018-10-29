<div class="page_heading">
	<h2>Edit Static Page</h2>
</div>
<?php //print_r($admin_edit); ?>  
<p>
	<?php $x=$this->Session->flash();
		if($x){ ?>
		<div class="alert success">
			<span class="icon"></span>
			<strong>Success!</strong><?php echo $x; ?>
		</div>
	<?php } ?>
</p>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
            <?php echo $this->Form->create('Staticpage',array('id'=>'tab','type'=>'file')); ?>                
            <div class="form-group"> 
                <?php echo $this->Form->select('position',array('about'=>'About Us', 'blog' => 'Blog', 'outstory' => 'Our Story',
                'privacypolicy' => 'Privacy and Policy','return&exchange' => 'Return & Exchange',
                'about_wear_org' => 'About Wear Organic','t&c' => 'Terms & Conditions','green&plant' => 'Green Plant', 'home' => 'Welcome to Shop','faq' => 'FAQ')
				,array('class'=>'form-control','empty' => '--Select position--','required'))
                ?>
 
                                         
            </div>   
            <?php if($admin_edit['Staticpage']['position']=='faq'){
				$cats = array('Payments','How it works','Delivery delay','Takeaway','Preorder','Register','Pricing','Privacy');
			?>
            <div class="form-group">
				<?php echo $this->Form->input('category',array('type'=>'select','options'=>$cats)); ?>
            </div>
            <?php }?>
            <div class="form-group">
				<?php echo $this->Form->input('title',array('class'=>'form-control'));?>
            </div> 
            <?php if($admin_edit['Staticpage']['position']!='faq'){ ?>
            <div class="form-group">
				<?php echo $this->Form->input('image',array('class' => 'form-control', 'type'=>'file'));?>      
            </div>
            <?php }?>
			<div class="form-group">
				<?php echo $this->Form->input('show_main', array('type' => 'checkbox')); ?> 
            </div>
            <div class="form-group">
				<?php echo $this->Form->input('description',array('class'=>'form-control','type'=>'textarea'));?>
            </div>
			<div class="form-group">
				<label>Status</label><br>
				<?php echo $this->Form->select('status',array('1'=>'Active','0'=>'Deactive'),
				array('label'=>"",'class'=>'form-control','data-placeholder'=>'Choose a Name')); ?>
            </div>
            <input type="hidden" name="data[Staticpage][created]" value="<?php echo date('Y-m-d H:i:s'); ?>">
			<div class="btn-toolbar list-toolbar">
                <button class="btn btn-primary" name="submit"><i class="fa fa-save"></i>Update</button>
                <a href="<?php echo $this->Html->url(array('controller' => 'Staticpages', 'action' => 'admin_index')); ?>" data-toggle="modal" class="btn btn-danger">Cancel</a>
			</div>
            <?php echo $this->Form->end();?>
        </div>
	</div>
</div>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
             selector: "textarea",
             plugins : "media"
    });
    </script>