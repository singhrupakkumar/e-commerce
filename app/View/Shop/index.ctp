


<div class="all-shop">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="fancy02">
          <h2>Shop All Watches</h2>
        </div>
      </div>
      
           
      <div class="shop_wcht">
	  
		<?php
		foreach($productswatch as $key):
		?>
	  
      	<div class="col-sm-3">
        <div class="show-watch">        
        <div class="shpwatch_img">
		<a href="<?php echo $this->webroot."product/".$key['Product']['slug'];?>">
        <div class="overlay"></div>
		<?php echo $this->Html->Image('/images/large/' . $key['Product']['image'], array('alt' => $key['Product']['name'], 'class' => 'img-responsive')); ?>
        </div>
		</a>
        <h3><?php echo $key ['Product']['name']; ?></h3>
        </div>        
        </div>
        <?php
			endforeach ;
			?>
 
      </div>   <!---------shop_wcht ends---------->   
      
      
      
    </div>
  </div>
</div>


<div class="all-shop">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="fancy">
          <h2>Shop Wooden Bracelets</h2>
        </div>
      </div>
      
      
      <div class="shop_wcht">
	  	<?php
		foreach($products_braslate as $key2):
		?>
	  
      	<div class="col-sm-3">
        <div class="show-watch">        
        <div class="shpwatch_img">
		<a href="<?php echo $this->webroot."product/".$key2['Product']['slug'];?>">
        <div class="overlay"></div>
       <?php echo $this->Html->Image('/images/large/' . $key2['Product']['image'], array('alt' => $key2['Product']['name'], 'class' => 'img-responsive')); ?>
        </div>
		</a>
        <h3><?php echo $key2 ['Product']['name']; ?></h3>
        </div>        
        </div>
          <?php
			endforeach ;
			?>
      </div>   <!---------shop_wcht ends---------->   
      
    
      
    </div>
  </div>
</div>

<!--------------------offer---------------------->

<div class="offer">
<div class="container">
<div class="row">
<div class="offer_innr">
<div class="col-sm-6 col-xs-12">
<a href="<?php echo $this->webroot;?>staticpages/about_wear_org"><div class="abt_sec">
	<div class="abt_img">
    <div class="overlay-abt"></div>
    <img src="<?php echo $this->webroot ;?>home/images/aboutwaer_bg.jpg" alt="" class="img-responsive" >
    </div>
     <div class="abt_txt">
     <p>About Wear Organic</p>
    </div>
</div></a>
</div>

<div class="col-sm-6 col-xs-12">
<a href="<?php echo $this->webroot;?>staticpages/green_plant">	<div class="abt_sec"> 
<div class="abt_img">
    <div class="overlay-abt"></div>
    <img src="<?php echo $this->webroot ;?>home/images/plant-a-tree-bg.jpg" alt="" class="img-responsive" >
    </div>
    <div class="abt_txt">
    <p>Plant a Tree for Every Watch Sold</p>
    </div>
</div></a>
</div>

</div>
</div>
</div>
</div>

<!-----------------Shop on Instagram------------------->

<div class="container">
<div class="row">
<div class="instargm">
<div class="col-sm-12">
        <div class="fancy02">
          <h2>Shop on Instagram</h2>
        </div>
      </div>

<div class="shop-insta">      
  <div class="col-sm-12">    
       	<?php
		foreach($products_instagram as $key3):
		?>
            <div class="col-md-3 col-sm-6 col-xs-12 portfolio-item">
                <a href="<?php echo $this->webroot."product/".$key3['Product']['slug'];?>"> 
                <div class="insta-portfo">
                 <div class="overlay-portfl"></div>
				  <?php echo $this->Html->Image('/images/large/' . $key3['Product']['image'], array('alt' => $key3['Product']['name'], 'class' => 'img-responsive')); ?>
                  </div>
                </a>
            </div>
		<?php endforeach ; ?>	
  </div>
</div>


</div>

</div>
</div>

<!-----------------Shop on Instagram------------------->

<!-----------------Media Covarage------------------->

<div class="media-covrg clearfix">
<div class="container">
<div class="row">
<div class="col-sm-12">
        <div class="fancy02">
          <h2>Media Coverage</h2>
        </div>
      </div>

</div>
		 	<?php
		foreach($products_media as $key4):
		?>
   
            <div class="col-md-3 portfolio-item">
                <a href="<?php echo $this->webroot."product/".$key4['Product']['slug'];?>">
                <div class="insta-portfo">
                <div class="overlay-media"></div>
                  <?php echo $this->Html->Image('/images/large/' . $key4['Product']['image'], array('alt' => $key4['Product']['name'], 'class' => 'img-responsive')); ?>
                  </div>
                </a>
            </div>
		<?php endforeach ; ?>	
    
        
</div>
</div>
<!-----------------Media Covarage------------------->

<!-----------------Get the latest ofers------------------->

