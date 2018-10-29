<?php echo $this->set('title_for_layout', 'Wooden Watches'); ?>
<!----------------Watches-----------------------> 

<div class="container">
	<div class="row">
    	<div class="col-sm-3 col-sm-12">
        <div class="lft-catagry">
        	
            <div class="panel-group wrap" id="accordion" role="tablist" aria-multiselectable="true">
			<form method="post" id="filterform" action="<?php echo $this->webroot."staticpages/wooden_watches" ;?>">
      <div class="panel">
        <div class="panel-heading" role="tab" id="headingOne">
          <h2 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Wood Type
        </a>
      </h2>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
          <div class="prdct-list">
           <ul>
           
            <?php 
            foreach ($alltag as $val){
            
              ?>
    
            <li><?php echo $val['Tag']['name']; ?>&nbsp;&nbsp;  <input type="radio" name="tag" value="<?php echo $val['Tag']['id']; ?>"></li>
            <?php } ?>  
     
           </ul> 
           </div>
          </div>
        </div>
      </div>
      <!-- end of panel -->

   
      <!-- end of panel -->

      <div class="panel">
        <div class="panel-heading" role="tab" id="headingThree">
          <h2 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Series
        </a>
      </h2>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
          <div class="panel-body">
           <div class="prdct-list">
           <ul>
		   <?php 
               foreach ($serise as $val):
               ?>
            <li><?php echo $val['Series']['name']; ?>&nbsp;&nbsp;  <input type="radio" name="serise" value="<?php echo $val['Series']['id']; ?>"></li>    
           	
                <?php endforeach; ?> 

           </ul>
           </div>
          </div>
        </div>
      </div>
      <!-- end of panel -->

      <div class="panel">
        <div class="panel-heading" role="tab" id="headingFour">
          <h2 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Band Type
        </a>
      </h2>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
          <div class="panel-body">
          <div class="prdct-list">
           <ul>
         <?php 
               foreach ($brand as $val):
               ?>
            <li><?php echo $val['Brand']['name']; ?>&nbsp;&nbsp;  <input type="radio" name="brand" value="<?php echo $val['Brand']['id']; ?>"></li>    
           	
                <?php endforeach; ?> 
           </ul>
           </div>
          </div>
        </div>
      </div>
      <!-- end of panel -->
      
       <div class="panel">
        <div class="panel-heading" role="tab" id="headingFive">
          <h2 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Related Categories
        </a>
      </h2>
        </div>
        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
          <div class="panel-body">
           <div class="prdct-list">
           <ul>
               
           <?php 
               foreach ($category as $val):
               ?>
            <li><?php echo $val['Category']['name']; ?>&nbsp;&nbsp;  <input type="radio" name="category" value="<?php echo $val['Category']['id']; ?>"></li>    
           	
                <?php endforeach; ?>       
       
           </ul>
           </div>
          </div>
        </div>
		<button type="submit" class="btn btn-info" name="filterbtn">Filter</button>
      </div>
		</form>
    </div>
            
            
        </div>    
        </div>
        
        <div class="col-sm-9 col-sm-12">
         <div class="common-head">
        
         <div class="col-sm-6 col-xs-12">
         <h2><a href="<?php echo $this->webroot;?>category/men-watches">Men's Watches</a></h2>
         </div>
         
           <div class="col-sm-6 col-xs-12">
         <h2><a href="<?php echo $this->webroot;?>category/women-watches">Men's Watches</a></h2>
         </div>
         
         </div>
         <!---------common-head----------->
         
         
         <div class="watch_txt">
         	<p>350 words on wooden watches by wear organic Lorem Ipsum 
                    has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make
                    a type specimen book. It has survived not only five centuries, but also 
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also.........
                </p>
         </div>
         
         <div class="prodcut_view">
             
            <?php 
			if(!empty($productswatchpage)):
			
			foreach ($productswatchpage  as $val):?> 
          <!---------product_item--------------->
             <div class="col-sm-3 col-xs-12">
             <div class="product_item">
             	<h3><?php echo  $val['Series']['name'] ;?> Series</h3>
                <div class="product_item_img">
                   <a href="<?php echo $this->webroot."product/".$val['Product']['slug'];?>"> 
                <div class="overlay"></div>
                <?php echo $this->Html->Image('/images/large/' . $val['Product']['image'], array('alt' => $val['Product']['name'], 'class' => 'img-thumbnail img-responsive')); ?>
                </a>
                </div>
                <div class="product_dsrp">
                <div class="product_name"><?php echo  $val['Product']['name'] ;?></div>
                <div class="product_price">$<?php echo  $val['Product']['price'] ;?></div>
                </div>
                <div class="product_reviews">
                <div class="product_review">
                    
                    <?php 
 $rate = count($val['Review']);

 $avg = '';
 foreach($val['Review'] as $rt){
	 
	$avg += $rt['punctuality'];

	 }

       $rate1 = $rate?$rate:1;
	 $avgRating = $avg/$rate1;

	 ?>

           
                 <?php if($avgRating){ echo round($avgRating);}  ?> Reviews</div>
                <div class="product_rating"> 
                  <?php
			 $i=round($avgRating);
                                        
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
             <!---------product_item--------------->
               <?php endforeach ;
		$paginator = $this->Paginator; 
			   ?>
			 <div class="col-xs-12">
			 <?php 
		 echo $paginator->numbers(array(
    'before' => '<div class="pagination-sm ftr_pagination"><ul class="pagination pagination-primary">',
    'separator' => '',
    'currentClass' => 'active',
    'tag' => 'li',
    'after' => '</ul></div>'
      ));
	
			 ?>

            </div>	
		<?php
		else:
		 echo "Product Not find";
		 endif;
		 
			   ?>
			   
 		   
             
             
             
<!-----------------Shop on Instagram------------------->



<div class="instargm">
<div class="col-sm-12">
        <div class="fancy">
          <h2>Shop on Instagram</h2>
        </div>
      </div>

<div class="shop-insta">      
  <div class="col-sm-12">    
          <?php foreach ($products_instagram  as $val1):?> 
            <div class="col-md-3 col-sm-6 col-xs-12 portfolio-item">
                <a href="<?php echo $this->webroot."product/".$val1['Product']['slug'];?>">
                 <div class="overlay-portfl"></div>
                   <?php echo $this->Html->Image('/images/large/' . $val1['Product']['image'], array('alt' => $val1['Product']['name'], 'class' => 'img-thumbnail img-responsive')); ?>
                </a>
            </div>
           <?php endforeach;?> 
       
       
     </div>
</div>

</div>



<!-----------------Shop on Instagram------------------->

             
       
        </div>
    </div>
</div>
</div>



<!----------------Watches-----------------------> 
