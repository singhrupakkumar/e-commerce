<?php 
 echo $this->set('title_for_layout', 'Green Plant Initiative');
if(!empty($greenplant)): 
?>
  <div class="container">
    <div class="col-sm-12">
 <div class="fancy">
                  <h2>Green Plant Initiative</h2>
                </div>
    </div>
   <?php foreach ($greenplant as $val):?>
    <div class="blog_sec">
      <div class="row">
        <div class="blog_cntr">
          <div class="col-sm-3 col-xs-12"> <img src="<?php echo $this->webroot."files/staticpage/".$val['Staticpage']['image'];?>"  class="img-responsive" alt=""> </div>
          
          <div class="col-sm-9 col-xs-12">
            <h2><?php echo $val['Staticpage']['title'];?></h2>
           <?php echo $val['Staticpage']['description'];?>
            
          </div>
        
        </div>
      </div>
       
    </div>
	<?php endforeach ;?>
  </div> 
  <?php 
  else:
  echo "No Content"; 
  endif;
  ?>