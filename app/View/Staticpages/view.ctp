<?php echo $this->set('title_for_layout', $staticpage['Staticpage']['title']);
$this->Html->addCrumb('Blog/', '/staticpages/blog');
 ?>
  <div class="container">
    <div class="col-sm-12">
      <div class="fancy">
        <h2><?php echo $this->fetch('title') ?></h2>
      </div>
    </div>
  
    <div class="blog_sec">
      <div class="row">
        <div class="blog_cntr">
          <div class="col-sm-3"> <img src="<?php echo $this->webroot."files/staticpage/".$staticpage['Staticpage']['image'];?>"  class="img-responsive" alt=""> </div>
          
          <div class="col-sm-9">
            <h2><?php echo $staticpage['Staticpage']['title'];?></h2>
           <?php echo $staticpage['Staticpage']['description'];?>
            
          </div>
        
        </div>
      </div>
           
    </div>
  </div> 