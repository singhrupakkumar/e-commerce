<?php 
echo $this->set('title_for_layout', 'My Order'); 
?>   
  <div class="container">
    <div class="col-sm-12">
      <div class="fancy07">
        <h2>My Order</h2> 
      </div>
    </div>
    
    
    
    
    
    <div class="col-sm-12">
      <div class="row">
      
<?php 

if(!empty($orderdataa)):
    
   $i = 0; 
foreach($orderdataa as $order) :
    
    
    $i++;

    ?>
      
      
      
        <div class="my-wishlist trck-odr">
          <div class="mywish_head">
            <div class="col-sm-5">
              <div class="mywish_left">
                <h2>Product Details</h2>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="track_ordrlist">
              	<ul>
                	<li><a href="#">Placed</a></li>
                    <li><a href="#">Confirmed</a></li>
                    <li><a href="#">Cancelled</a></li>
                    <li><a href="#">Delivered</a></li>
                   
                </ul>
              
              </div>
            </div>
            <div class="col-sm-2">
              <div class="subtotl">
              	Price
              
              </div>
            </div>
          </div>
          <div class="col-sm-2 col-xs-12">
            <div class="mymish_img"><img src="<?php echo $this->webroot."images/large/".$order['products']['image'];?>"
			alt="<?php echo $order['order_items']['name'];?>" class="img-responsive" ></div>
          </div>
          <div class="col-sm-3 col-xs-12">            
            <div class="descript"><?php echo $order['order_items']['name'];?></div>             
            <div class="notfy"> <span>QTY: <?php echo $order['order_items']['quantity'];?></span> </div>
            <div  class="notfybtn">
               <?php if($order['orders']['status'] != 1)  { ?> <button class="btn defult_btn" data-toggle="collapse" data-target="#writrw<?php echo $i ;?>">Review Product</button><?php } ?>
            </div>
          </div>
          <div class="col-sm-5 col-xs-12">
            <div class="listwsh_item">
             
             <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-3 bs-wizard-step complete">               
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($order['orders']['status']==1){ echo "current"; } ?>"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->                
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($order['orders']['status']==2){ echo "current"; } ?>"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->                 
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($order['orders']['status']==3){ echo "current"; } ?>"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step active"><!-- active -->                  
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot <?php if($order['orders']['status']==4){ echo "current"; } ?>"></a>
                  
                </div>
            </div>
              
            </div>
            
            <div class="procsng_mbl">
            <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-2 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum">Approval</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Processing</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum">Shipping</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot bg-no"></a>
                  
                </div>
                
                <div class="col-xs-4 bs-wizard-step active"><!-- active -->
                  <div class="text-center bs-wizard-stepnum">Delivery</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  
                </div>
            </div>
            
            </div>
            
            
            
          </div>
           <div class="col-sm-2 col-xs-12">
           <div class="subtl">$<?php echo $order['order_items']['price'];?></div>
           </div>
          
          <div class="col-sm-12 col-xs-12">
          <div class="row">
          <div class="ftr_trck">
             <div class="col-sm-7"> <h3> Total</h3></div>
             <div class="col-sm-5">
          <h3>$<?php echo $order['order_items']['subtotal'];?></h3> 
          </div>
          
          </div>
          </div>
          </div>
           
        </div>
          
        <!------------review div------------->
        
        
         <div id="writrw<?php echo $i ;?>" class="collapse">
              <form action="<?php echo $this->webroot."shop/savereview"; ?>" method="post" class="reviw_from">
              <div class="clearfix">
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Full Name</label>
                    <input type="text" name="data[Review][name]" class="form-control" required>
		<input type="hidden" name="prod_avg_rate"  value="<?php echo  $order['products']['avg_rating'] ;?>" class="form-control">
                  
                    
                     <input type="hidden" name="data[Review][product_id]" value="<?php echo $order['products']['id'] ; ?>"> 
                    <input type="hidden" name="data[Review][uid]" value="<?php echo $loggeduser ;?>"> 
                    <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
                    <div class="clearfix"></div>
                   </div>
                </div> 
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Email Address</label>
                    <input type="email" name="data[Review][email]" class="form-control" required>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="form-group label-floating">
                    <label class="control-label">Here can be your nice text</label>
                    <textarea class="form-control" name="data[Review][text]"  rows="2" required></textarea>
                  </div>
                </div>
              </div>
              <div class="clearfix">  
                <div class="col-sm-12">
                  <div class="star-reviw">
                      <div class="stars rating" id="rating"> 
                    <span class="fa fa-star"></span> 
                    <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                      <input type="hidden" name="data[Review][punctuality]" id="ratingsval<?php echo $i ;?>" value="" required>  
                 </div>   
                    
                  </div>
                </div>
              </div>
			    <script>
      $('.rating span').each(function(){

    $(this).click(function(){
        if(!$(this).hasClass('checked')){
            $(this).addClass('checked');
            $(this).prevAll().addClass('checked');
            var rate = $('#rating .checked').length;
        }else{
            $(this).nextAll().removeClass('checked');
            var rate = $('#rating .checked').length;
        }
       
        $('#ratingsval'+'<?php echo $i ;?>').val(rate);
    });
});
  </script> 
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="pull-right">
                      <button type="submit" class="btn defult_btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          
          
          
       <?php endforeach ;
       else:
           echo '<p style="text-align:center; font-weight:bold;"> Order list empty</p>';
       endif;
       ?> 
        
        
      </div>
    </div>
    
    
  </div>



