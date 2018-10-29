<?php echo $this->set('title_for_layout', 'Our Story'); ?>


<!----------------Watches-----------------------> 

<div class="container">

		<div class="col-sm-12">
                <div class="fancy01">
                  <h2>Our Story</h2>
                </div>
        </div>
		<?php foreach($outstory as $content):?>
        <div class="about_us">
            <!--<h2><?php// echo $content['Staticpage']['title'];?></h2> -->
        <div class="col-sm-3 col-xs-12 pull-right">
          <div class="abt_img">      
        <img src="<?php echo$this->webroot."files/staticpage/".$content['Staticpage']['image']; ?>" alt=""  class="img-responsive">
           </div>     
        </div>
            <div class="col-sm-9 col-xs-12 pull-left">
                
               <?php echo $content['Staticpage']['description'];?>
                
        </div>
        
        
        
        </div>
		<?php endforeach ;?>
</div>
