<?php echo $this->set('title_for_layout', 'Blogs'); ?> 
  <div class="container">
    <div class="col-sm-12">
      <div class="fancy04">
        <h2>Blogs</h2>
      </div>
    </div>
      <?php foreach ($blogs as $val):?>
    <div class="blog_sec">
      <div class="row">
        <div class="blog_cntr">
          <div class="col-sm-3"> 
          <img src="<?php echo $this->webroot."files/staticpage/".$val['Staticpage']['image'];?>"  class="img-responsive" alt=""> 
          </div>
          <div class="col-sm-9">
            <h2><?php echo $val['Staticpage']['title'];?></h2>
           <?php echo $val['Staticpage']['description'];?>
            <div class="pull-right">
              <a href="<?php echo "view/".$val['Staticpage']['id'];?>"><button class="btn btn-md defult_btn">Read More</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
   <?php endforeach;?>  

  </div> 