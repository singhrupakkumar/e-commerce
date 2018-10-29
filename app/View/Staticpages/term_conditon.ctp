<?php echo $this->set('title_for_layout', 'Terms & Conditions'); ?>
<div class="container">

<div class="col-sm-12">
                <div class="fancy">
                  <h2>Terms & Conditions</h2>
                </div>
          	</div>
        <div class="privacy_policy">
         <div class="col-sm-12 ">
		 <?php foreach($tc as $content):?>
               <div class="voffset4">
                <h2><?php echo $content['Staticpage']['title'];?></h2>
               <p><?php echo $content['Staticpage']['description'];?></p>
                </div>
<?php endforeach ;?>
        </div>
        
        </div>
</div>
