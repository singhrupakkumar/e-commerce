
<?php echo $this->set('title_for_layout', 'Wishlist');
// print_r($datalist);
// exit;
?>
  <!---------------------My wishlist------------------>
  
  <div class="container">
    <div class="col-sm-12">
      <div class="fancy05">
        <h2>My Wishlist</h2>
      </div>
    </div>
    <div class="col-sm-12">
	 <?php if(!empty($datalist)){?> 
      <div class="remal_txt">
<a href="<?php echo $this->webroot;?>/products/wishlist_deleteall?user_id=<?php echo $loggeduser ; ?>" onclick="return confirm('Do you really want to remove all Wishlist?')">Remove All</a>

      </div>
	 <?php } ?> 
      </div>
    
    <div class="col-sm-12">
      <div class="row">
	  
	<?php foreach($datalist as $val):?>
        <div class="my-wishlist">
          <div class="mywish_head">
            <div class="col-sm-12">
              <div class="mywish_left">
                <h2><?php echo $val['Product']['name'];  ?></h2>  
              </div>
              <div class="mywish_close"><a href="<?php echo $this->webroot;?>/products/wishlist_delete?product_id=<?php echo $val['Product']['id']; ?>" onclick="return confirm('Are you really want to remove this product?')" ><img src="<?php echo $this->webroot;?>home/images/cross_icon.png" class="pull-right" alt="" ></a></div>
              
            </div>
            
          </div>
          <div class="col-sm-2">
            <a href="<?php echo $this->webroot."products/view/".$val['Product']['slug'] ; ?>">   
                <div class="mymish_img">

<?php echo $this->Html->Image('/images/large/' . $val['Product']['image'], array('alt' => $val['Product']['name'],'class'=>'img-responsive')); ?>
                </div>
                </a>
          </div>
          <div class="col-sm-4">
            <div class="price">$<?php echo $val['Product']['price']; ?></div>
     
           
            
          </div>
          <!--<div class="col-sm-4">-->
            <!--<div class="listwsh_item">-->
             <?php // echo $val['Product']['description'] ;?>
     
           <!-- </div>-->
       <!--   </div>-->
            <div class="col-sm-6">
            <div class="listwsh_item">
         <span class="badge"><?php if($val['Wishlist']['get_alert']==1 && $val['Product']['on_sale']==1 ){ echo "On sale" ; } ?></span> 
            </div>
            <div  class="notfybtn">
                
             <form action="<?php echo $this->webroot;?>/products/get_alerts" method="POST"> 
                    <input type="hidden" value="<?php echo $loggeduser ;?>" name="user_id">
                    <input type="hidden" value="<?php echo $val['Product']['id'] ;?>" name="product_id"> 
                  
                     <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"> 
                  <?php if($val['Wishlist']['get_alert']== 0) { ?>   <button type="submit" <?php if (empty($loggeduser)) {?>disabled="disabled" <?php } ?> class="btn defult_btn3">Notify me</button> <?php } ?>
              </form>  
        
            </div>
          </div>
        </div>
       <?php endforeach; ?>
       <?php if(empty($datalist)){?> 
       <div class="cart_sec" style="text-align: center;">  Wishilst is empty!</div>
       <?php }  ?>
      </div>
    </div>
  </div>
  
  <!---------------------My wishlist------------------> 