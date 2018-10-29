<?php  
 //print_r($review[0]['Review']['text']); 
//exit;
?>
<?php echo $this->Html->script(array('addtocart.js'), array('inline' => false)); ?>

<?php
$this->Html->addCrumb($product['Brand']['name'], array('controller' => 'brands', 'action' => 'view', 'slug' => $product['Brand']['slug']));
$this->Html->addCrumb($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', 'slug' => $product['Category']['slug']));
//$this->Html->addCrumb($product['Product']['name']); 
?> 
<style>
     #share_button {cursor: pointer;}   
 </style>   
<script>
$(document).ready(function() {

    $('#modselector').change(function(){
        $('#productprice').html($(this).find(':selected').data('price'));  
        $('#modselected').val($(this).find(':selected').val());
    });

});
</script>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({appId: '407521412930578', status: true, cookie: true,
xfbml: true});
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol +
'//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());
</script>
<div class="container">
    <div class="cart-shp">
      <div class="wrapper row">
        <div class="preview col-sm-6 col-xs-12">
          <div class="preview-pic tab-content">
            <div class="tab-pane active" id="pic-1"> <?php echo $this->Html->Image('/images/large/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'img-responsive')); ?>
			</div>
		<?php 
		$tab =1;
		foreach($products_slider['Gallary'] as $val):
		$tab++;
		?>	
          <div class="tab-pane" id="pic-<?php echo $tab ;?>">
		  <?php echo $this->Html->Image('/images/large/' . $val['image']); ?>
		  </div>
		  <?php endforeach ;?>
		  </div>
          <ul class="preview-thumbnail nav nav-tabs">
		   <li class="active"><a data-target="#pic-1" data-toggle="tab"><?php echo $this->Html->Image('/images/large/' . $product['Product']['image'], array('alt' => $product['Product']['name'], 'class' => 'img-responsive')); ?></a></li>	
               <?php
			   $ab = 1;
            foreach($products_slider['Gallary'] as $val):
			$ab++;
			if($ab !=4){ 
                ?> 
		<li><a data-target="#pic-<?php echo  $ab;?>" data-toggle="tab"><?php echo $this->Html->Image('/images/large/' . $val['image']); ?></a></li>
           
           
          <?php 
			}
		  endforeach;?>
          </ul>
        </div>
        <div class="details col-sm-6 col-xs-12">
          <h3 class="product-title"><?php echo $product['Product']['name']; ?></h3>
          <div class="rating"> 
                                  <?php 
 $rate = count($review);

 $avg = '';
 foreach($review as $rt){
	 
	$avg += $rt['Review']['punctuality'];

	 }

       $rate1 = $rate?$rate:1;
	 $avgRating = $avg/$rate1; 

	 ?>
              
                      <?php
			 $i=round($avgRating);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                       <span class="fa fa-star checked"></span> 
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <span class="fa fa-star"></span>
                                        <?php 
                                        
                                        } 
			                    ?>  
          
              <span class="review-no"><?php if($rate){ echo round( $rate);}  ?> reviews</span>
          </div>
          <p class="price" id="productprice">$ <?php echo $product['Product']['price']; ?></p>
          
           <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'add'))); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $product['Product']['id'])); ?>
          
          <div class="crt_btn">
               <?php echo $this->Form->button('Add to Cart', array('class' => 'btn defult_btn btn_cart', 'id' => 'addtocart', 'id' => $product['Product']['id']));?>
        <?php echo $this->Form->end(); ?>
        
            <!--<input type="text" class="form-control" placeholder="1" disabled >-->
          </div>
          <div class="cart_flt">
            <div class="addt-wish">
                
                <form action="<?php echo $this->webroot;?>/products/addwishlist" method="POST">
                    <input type="hidden" value="<?php echo $loggeduser ;?>" name="user_id">
                    <input type="hidden" value="<?php echo $product['Product']['id'] ;?>" name="product_id">
                     <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"> 
                     <?php if (!empty($loggeduser)) { ?>
                     <button type="submit"  class="btn defult_btn btn_cart ">Add to Wishlist</button>
                 </form>  
                 <?php   }else{
         echo '<button id="wishcheck" class="btn defult_btn btn_cart">Add to Wishlist</button>';    
        }
        ?>   
               
            </div>
            <div class="get-product">
              <form action="<?php echo $this->webroot;?>/products/get_alerts" method="POST"> 
                    <input type="hidden" value="<?php echo $loggeduser ;?>" name="user_id">
                    <input type="hidden" value="<?php echo $product['Product']['id'] ;?>" name="product_id">
                  
                     <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"> 
                       <?php 
        if (!empty($loggeduser)) { ?>
                     <button type="submit" class="btn defult_btn btn_cart ">Get Product Alerts</button>
              </form> 
           <?php   }else{
         echo '<button id="check" class="btn defult_btn btn_cart">Get product Alerts</button>';    
        }
        ?>    
            </div>
          </div>
          <ul class="nav nav-pills featrd_tab">
            <li class="active"><a data-toggle="pill" href="#home">Features</a></li>
            <li><a data-toggle="pill" href="#menu1">Shipping &amp; Returns</a></li>
          </ul>

			

			
		  <div class="tab-content">
            <div id="home" class="tab-pane featrd_pane fade in active"> 
              <ul>
              <?php  echo $product['Product']['feature'];?>  
              </ul>
            </div>
			
            <div id="menu1" class="tab-pane fade">
             <?php 
           
             echo $return['Staticpage']['description'];?>   
            </div>
          </div>
          <h5 class="sizes">
          Share:
              <span class="size" id="share_button" data-toggle="tooltip" title="Facebook"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></span> 
              <span class="size" data-toggle="tooltip" title="Twitter">
             <a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=http://rupak.crystalbiltech.com/shop/product/<?php echo $product['Product']['slug']; ?>&pubid=ra-42fed1e187bae420&title=AddThis%20%7C%20Home&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a> 
             </span>
              <span class="size" data-toggle="tooltip" title="Pinterest">           
             <a target="_blank" href="http://pinterest.com/pin/create/button/?url=http://rupak.crystalbiltech.com/shop/product/<?php echo $product['Product']['slug']; ?>&media=https://rupak.crystalbiltech.com/shop/images/large/<?php echo $product['Product']['image']; ?>&description=<?php echo $product['Product']['description']; ?>" class="pin-it-button" count-layout="horizontal">
  <img src="https://addons.opera.com/media/extensions/55/19155/1.1-rev1/icons/icon_64x64.png" width="33" height="33" alt="Pinterest"> 
</a> 
</span>
			<span class="size" data-toggle="tooltip" title="Email">
            <a href="https://api.addthis.com/oexchange/0.8/forward/email/offer?url=http://rupak.crystalbiltech.com/shop/product/<?php echo $product['Product']['slug']; ?>&pubid=ra-42fed1e187bae420&title=AddThis%20%7C%20Home&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/email.png" border="0" alt="Email"/></a>   
            </span>
            <!--  <a href="https://plus.google.com/share?url=http://rupak.crystalbiltech.com/shop/product/<?php echo $product['Product']['slug']; ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" > <span class="size" data-toggle="tooltip" title="Email">Email</span></a> -->
          </h5>
           
          </div>
      </div> 
    </div> 
	
				<script type="text/javascript">
$(document).ready(function(){
$('#share_button').click(function(e){
e.preventDefault();
FB.ui(
{
method: 'feed',
name: '<?php echo $product['Product']['name']; ?>.',
link: ' https://rupak.crystalbiltech.com/shop/',
picture: 'https://rupak.crystalbiltech.com/shop/images/large/<?php echo $product['Product']['image']; ?>',
caption: '<?php echo "Price: $".$product['Product']['price']; ?>',
description: '',
message: ''
}); 
});
});
</script>
    
    <!----------------Watches----------------------->
    
    <div class="head_cart">
      <div class="cart_head">
        <h2><?php echo $product['Product']['name']; ?></h2>
        <?php echo $product['Product']['description']; ?>
      </div>
    </div>
    <!----------------product video--------------------->
    <?php if(!empty($product['Product']['video'])){ ?> 
   <div class="green_plnt">
       <iframe width="100%" style="min-height: 280px;" 
               src="<?php echo $product['Product']['video'];  ?>">  
        </iframe> 
  </div>
    <?php } ?>
    <!-------------------video end--------------->
    

    <!-----------------Shop on Instagram-------------------> 
    
    <div class="instargm">
      <div class="row">
        <div class="col-sm-12">
          <div class="fancy">
            <h2>Shop on Instagram</h2>
          </div>
        </div>
        <div class="shop-insta">
          <div class="col-sm-12">
              <?php
		foreach($products_instagram as $key):
		?>
              
            <div class="col-md-3 col-sm-6 col-xs-12 portfolio-item">
                <a href="<?php echo $this->webroot."product/".$key['Product']['slug'];?>">
                 <div class="insta-portfo">
              <div class="overlay-portfl"></div>
             
            <?php echo $this->Html->Image('/images/large/' . $key['Product']['image'], array('alt' => $key['Product']['name'], 'class' => 'img-responsive')); ?>
            </div> 
                </a> 
            </div>
              <?php endforeach; ?>
           
          </div>
        </div>
      </div>
    </div>
    
    <!-----------------Shop on Instagram-------------------> 
    
    <!---------------------Cutomer Reviews------------------>
    <div class="customer_reiv ">
      <div class="col-sm-12">
        <div class="fancy">
          <h2>Customer Reviews</h2>
        </div>
      </div>
      <div class="review_sec voffset3">
        <div class="col-sm-11 col-sm-push-1 col-xs-12">
          <div class="row">
            <div class="col-sm-7">
              <div class="star-reviw">
                <div class="star_rating">
                      <?php
					 
					  
			 $i=round($avgRating);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                       <span class="fa fa-star checked"></span> 
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <span class="fa fa-star"></span>
                                        <?php 
                                        
                                        } 
			                    ?> 
                    <span class="reviews"><?php if( $rate){ echo round( $rate);}  ?> Reviews</span> </div>
              </div>
              <div class="qution_ans"> <span><?php if($qustion){ echo count($qustion); } ?> Questions /  Answers</span> </div>
            </div>
            <div class="col-sm-5">
              <div class="reviw-button pull-right">
               <!--<button type="button" class="btn defult_btn" data-toggle="collapse" data-target="#writrw">Write a Review</button>-->
                <button type="button" class="btn defult_btn2" data-toggle="collapse" data-target="#askquestn">Ask a Question</button>
              </div>
            </div>
          </div>
          <div id="writrw" class="collapse">
              <form action="<?php echo $this->webroot."shop/savereview"; ?>" method="post" class="reviw_from">
              <div class="clearfix">
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Full Name</label>
                    <input type="text" name="data[Review][name]" class="form-control">
					<input type="hidden" name="prod_avg_rate"  value="<?php echo $avgRating ;?>" class="form-control">
                  
                    
                     <input type="hidden" name="data[Review][product_id]" value="<?php echo $product['Product']['id']; ?>"> 
                    <input type="hidden" name="data[Review][uid]" value="<?php echo $loggeduser ;?>"> 
                    <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
                    <div class="clearfix"></div>
                   </div>
                </div> 
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Email Address</label>
                    <input type="email" name="data[Review][email]" class="form-control">
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="form-group label-floating">
                    <label class="control-label">Here can be your nice text</label>
                    <textarea class="form-control" name="data[Review][text]"  rows="2"></textarea>
                  </div>
                </div>
              </div>
              <div class="clearfix">  
                <div class="col-sm-12">
                  <div class="star-reviw">
                      <div class="stars rating" id="rating1"> 
                    <span class="fa fa-star"></span> 
                    <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                     <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                      <input type="hidden" name="data[Review][punctuality]" id="ratings1" value="">  
                 </div>   
                    
                  </div>
                </div>
              </div>
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="pull-right">
                      <button type="submit" class="btn defult_btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div id="askquestn" class="collapse">
            <form action="<?php echo $this->webroot."users/user_ask_ques"; ?>" method="post" id="reviw_from" class="reviw_from">
              <div class="clearfix">
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Full Name</label>
                    <input type="text" name="data[Admin_contact][name]" class="form-control">
                      <input type="hidden" name="data[Admin_contact][product_id]" value="<?php echo $product['Product']['id']; ?>" required> 
                    <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" required>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div> 
                  <div class="clearfix">
                <div class="col-sm-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Email</label>
                    <input type="email" name="data[Admin_contact][email]" id="ask_email" class="form-control" required>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div> 
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="form-group label-floating">
                    <label class="control-label">Here can be your nice text</label>
                    <textarea class="form-control" name="data[Admin_contact][msg]"  rows="2" required></textarea>
                  </div>
                </div>
              </div>
              <div class="clearfix">
                <div class="col-sm-12">
                  <div class="pull-right">
                      <button type="submit" id="ask_btn" class="btn defult_btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          
          <!------------Show Review Section----------------------->
          <div class="show_reviewsec">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#cusreviw">Reviews (<?php if( $rate){ echo round( $rate);}  ?>)</a></li>
              <li><a data-toggle="tab" href="#question">Question (<?php if($qustion){ echo count($qustion); } ?>)</a></li>
            </ul>
            <div class="tab-content">
              <div id="cusreviw" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-sm-2">
                      <div class="custmr-name"><?php if(!empty($review)){ echo $review[0]['Review']['name']; } ?></div>
                  </div>
                  <div class="col-sm-4">
                    
                  </div>
                  <div class="col-sm-6">
                    <div class="review_date"><?php if(!empty($review)){ echo $review[0]['Review']['created']; } ?></div>
                  </div>
                </div>
                <div class="star-reviw">
                  <div class="star_rating">        <?php
                  if(!empty($avgRating)){
			 $i=round($avgRating);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                       <span class="fa fa-star checked"></span> 
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <span class="fa fa-star"></span>
                                        <?php 
                                        
                                        } 
                  }
			                    ?>  </div>
                </div>
               
                <p><?php if(!empty($review)){ echo $review[0]['Review']['text']; } ?> </p>  
                <div class="share_cust"></div> 
               
              </div>
              <div id="question" class="tab-pane fade">
              
              </div>
              <?php  if(!empty($avgRating)){ ?>  <div class="more_btn"><a href="<?php echo $this->webroot."staticpages/cust_reviews?product_id=".$product['Product']['id'];?>" charset="btn ">Read More Reviews..</a></div><?php } ?>
            </div>
          </div>
          <!--------------Show Review Section------------------------> 
          
        </div>
      </div>
    </div>
    <!---------------------Cutomer Reviews------------------> 
    
  </div>
  <!-----------------Container ends------------------->
  
  <div class="green_plnt"> <img src="<?php echo  $this->webroot;?>home/images/greenplant-bg.jpg" alt="" class="img_head">
    <div class="greenp_plntiner">
      <h2><span>Green</span> Plant Initiative</h2>
      <p>For every watch sold we plant 5 trees and help children to receive education and shelter.</p> 
      <div class="voffset5">
          <div class="readmore"><span class="btn readmr_btn"><a href="<?php echo $this->webroot."staticpages/green_plant";?>">Read More</a></span> </div>
      </div>
    </div>
    <div class="overlay-dark"></div>
  </div>
  
  <!------------------Popular catagories starts-------------------------->
  <div class="other_product">
    <div class="container">
      <div class="row">
        <div class="populr_catagry prodcut_view">
          <div class="col-sm-12">
            <div class="fancy06">
              <h2>Other Religious Bracelets You May Like</h2>
            </div>
          </div>
           <?php
		foreach($products_braslate as $key2):
		?> 
          <!---------product_item--------------->
          <div class="col-sm-3 col-xs-12">
            <div class="product_item">
              <div class="product_item_img">
                <a href="<?php echo $this->webroot."product/".$key2['Product']['slug'];?>">
                    <div class="overlay"></div>
                  <?php echo $this->Html->Image('/images/large/' . $key2['Product']['image'], array('alt' => $key2['Product']['name'], 'class' => 'img-responsive')); ?>
              </div></a>
              <div class="product_dsrp">
                <div class="product_name"><?php echo $key2 ['Product']['name']; ?></div>
                <div class="product_price">$<?php echo $key2 ['Product']['price']; ?></div>
              </div>
              <div class="product_reviews">
                <div class="product_review">
                                       <?php 
 $rate = count($key2['Review']);

 $avg = '';
 foreach($key2['Review'] as $rt){
	 
	$avg += $rt['punctuality'];

	 }

       $rate1 = $rate?$rate:1;
	 $avgRating1 = $avg/$rate1;

	 ?>
                    
                    <?php if( $rate){ echo round( $rate);}  ?> Reviews</div>
                <div class="product_rating">
                           <?php
			 $i=round($avgRating1);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <?php 
                                        
                                        } 
			                    ?> 
                </div>
              </div>
            </div>
          </div>
          
         <?php endforeach;?> 

          <!---------product_item---------------> 
          
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"> 
$(document).ready(function(){
$('#check').click(function(e){
 alert('you must login first');

 $('#loginModal').modal('show');
return false; 
});

$('#wishcheck').click(function(e){ 
 alert('you must login first');

 $('#loginModal').modal('show');
return false; 
});

$('#reviw_from').submit(function(e){ 
 var askemail = $('#ask_email').val();
 if(askemail ==''){
	 alert('Please Enter Email Id');
	 e.preventDefault()
 }

});

});

</script>
  <!------------------Popular catagories starts--------------------------> 