<?php echo $this->set('title_for_layout', 'Privacy Policy'); ?>
<div class="container">

<div class="col-sm-12">
                <div class="fancy02">
                  <h2>Privacy Policy</h2>
                </div>
          	</div>
        <div class="privacy_policy">
         <div class="col-sm-12 ">
		 <?php foreach($privacy as $content):?>
               
               <!-- <h2><?php// echo $content['Staticpage']['title'];?></h2>-->
              <?php echo $content['Staticpage']['description'];?>
                
<?php endforeach ;?>
        </div>
        
        </div>
</div>
