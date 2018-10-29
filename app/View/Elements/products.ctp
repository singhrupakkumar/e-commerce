<style>
    .ftr_pagination .pagination > li.current{
  /* border: 1px solid #dadada; */
    padding: 8px 14px;
    /* height: 36px; */
    line-height: 36px;
    background-color: #000;
    color: #fff;
}
</style>
            <?php 

        
			if(!empty($products)):
			
			foreach ($products  as $val):?> 
          <!---------product_item--------------->
             <div class="col-sm-3 col-xs-12">
             <div class="product_item">
                <h3><?php if(!empty($val['Series']['name'])) { echo  $val['Series']['name']  ; }?></h3>
                <div class="product_item_img">
                   <a href="<?php echo $this->webroot."product/".$val['Product']['slug'];?>"> 
                <div class="overlay"></div>
                <?php echo $this->Html->Image('/images/large/' . $val['Product']['image'], array('alt' => $val['Product']['name'], 'class' => 'img-responsive')); ?> 
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

           
                 <?php if($rate){ echo round($rate);}  ?> Reviews</div> 
                <div class="product_rating"> 
                  <?php
			 $i=round($avgRating);
                            
                         for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <?php 
                                        
                                        }  
                                          for($j=0;$j<$i;$j++){
                                        ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
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
                  
    <?php echo $this->Paginator->numbers(array(
    'before' => '<div class="pagination-sm ftr_pagination"><ul class="pagination pagination-primary">',
    'separator' => '', 
    'tag' => 'li',
    'after' => '</ul></div>'
      )); ?>

            </div>	
		<?php
		else:
		 echo "Product Not find";
		 endif;
		 
			   ?>
             
             
                      <!------------------Featured starts-------------------------->
                  
            <?php if(!empty($category['Category']['name'])):
			
			 foreach($popular as $popval){}
                   if($popval['Review'] !=null) { 
			  
			?>
            <div class="col-sm-12">
            <div class="featurd_rivew voffset6">
           	 <div class="col-xs-12">
                <div class="fancy">
                  <h2>Featured Reviews</h2>
                </div>
          	</div>
            <div class="fetrd_continer">
               <?php 
               if(!empty($popular)):
               foreach($popular as $popval):
                
                   ?> 
            	<div class="col-sm-6">
                    <p><strong><?php echo $popval['Review'][0]['name']; ?></strong></p>
                    <div class="product_rating rating"> 
                        
                              <?php
                           $avRating =   $popval['Review'][0]['Product']['avg_rating'];
                           $i=round($avRating);   
                              for($j=0;$j<$i;$j++){
                                        ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
                                        <?php
                                        } for($h=0;$h<5-$i;$h++){?>  
                                         
                                         <i class="fa fa-star-o" aria-hidden="true"></i>  
                                        <?php 
                                        
                                        } 
                                        ?>   
                            
                    </div>
                    <p class="voffset2 headr"><?php echo $popval['Review'][0]['Product']['name']; ?></p>
                    <p><?php echo $popval['Review'][0]['Product']['description']; ?>
                    </p>
                    <p class="voffset3"><?php echo $popval['Review'][0]['created']; ?></p>
                </div>
               <?php 
				
               endforeach;
               endif;
               ?> 
            </div>    
            </div>
            </div>
            <?php 
			   }	
			endif ;
				 
			?>
     <!------------------Featured end--------------------------> 
 
             
<!-----------------Shop on Instagram-------------------> 




