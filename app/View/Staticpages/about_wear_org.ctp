<?php 
echo $this->set('title_for_layout', 'About Wear Organic'); 
?>  
<div class="container">

		<div class="col-sm-12">
                <div class="fancy">
                  <h2>About Wear Organic</h2>
                </div>
        </div>
		<?php
if(!empty($about_wear_org)):
		foreach($about_wear_org as $content):?>
		        <div class="about_us">
            <div class="col-sm-12"><h2><?php echo $content['Staticpage']['title'];?></h2></div>
			<div class="col-sm-9 col-xs-12">
  
                
               <p><?php echo $content['Staticpage']['description'];?></p>
                
        </div>
        <div class="col-sm-3 col-xs-12">
          <div class="abt_img">      
        <img src="<?php echo $this->webroot."files/staticpage/".$content['Staticpage']['image'];?>" alt="" class="img-responsive">
           </div>     
        </div>
        
        
        </div>
	<?php endforeach ;
	endif;
	?>	
		
		</div>