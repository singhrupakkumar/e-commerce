<?php echo $this->set('title_for_layout', 'About Us'); ?>
<div class="container">

		<div class="col-sm-12">
                <div class="fancy01">
                  <h2>About us</h2>
                </div>
        </div>
		<?php foreach($abouts as $content):?>
        <div class="about_us">
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
