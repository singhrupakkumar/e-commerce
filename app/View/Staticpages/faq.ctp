
<?php echo $this->set('title_for_layout', "FAQ's"); ?>
 <!----------------Watches-----------------------> 

<div class="container">

<div class="col-sm-12">
                <div class="fancy">
                  <h2>Frequently Asked Questions</h2>
                </div>
          	</div>
        <div class="privacy_policy">
            <div class="col-sm-12 ">
               <div class="faq_colps">
               
                <div class="panel-group" id="accordion">
				
	<?php
    $cos = 0;
	foreach($faqs as $content):
	$cos++;
	?>			
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cos ;?>">
        Q: <?php echo $content['Staticpage']['title'];?></a>
      </h4>
    </div>
    <div id="collapse<?php echo $cos ;?>" class="panel-collapse collapse <?php if($cos==1){ echo "in" ;}?>">
      <div class="panel-body"><?php echo $content['Staticpage']['description'];?></div>
    </div>
  </div>
  
  <?php endforeach ;?>

</div> 
               
               
               </div>

              
               
                
        </div>
        
        </div>
</div>
