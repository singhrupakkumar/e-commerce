<?php echo $this->set('title_for_layout', 'Customer Reviews'); 
//print_r($reviews);
?>
  <!---------------------Customer Reviews------------------>
  
  
  
  <div class="container">
    <div class="row">
      <div class="customer_reiv ">  
        <div class="col-sm-12">
          <div class="fancy">
            <h2>Customer Reviews</h2>
          </div>
        </div>
        <div class="review_sec voffset3">
          <div class="col-sm-11 col-sm-push-1 col-xs-12">
           
              <div class="col-sm-7">
                <div class="star-reviw">
                 <!-- <div class="star_rating">
<i class="fa fa-star" aria-hidden="true"></i> 
<i class="fa fa-star" aria-hidden="true"></i> 
<i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> 
<i class="fa fa-star-o" aria-hidden="true"></i><span><?php echo count($reviews);?> Reviews</span> </div>
                </div>
                <div class="qution_ans"> <span>1 Questions / 1 Answers</span> </div> -->
              </div>
              <div class="col-sm-5">
                <div class="reviw-button">
                 <!-- <button class="btn defult_btn" data-toggle="collapse" data-target="#writrw">Write a Review</button>
                  <button class="btn defult_btn2" data-toggle="collapse" data-target="#askquestn">Ask a Question</button>-->
                </div>
              </div>
            </div>
            <div id="writrw" class="collapse">
              <form action="" method="post" class="reviw_from">
                <div class="clearfix">
                  <div class="col-sm-6">
                    <div class="form-group label-floating">
                      <label class="control-label">Full Name</label>
                      <input type="email" class="form-control">
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group label-floating">
                      <label class="control-label">Email Address</label>
                      <input type="email" class="form-control">
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div class="col-sm-12">
                    <div class="form-group label-floating">
                      <label class="control-label">Here can be your nice text</label>
                      <textarea class="form-control"  rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div class="col-sm-12">
                    <div class="star-reviw">
                      <div class="star_rating"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div class="col-sm-12">
                    <div class="pull-right">
                      <button class="btn defult_btn">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div id="askquestn" class="collapse">
              <form action="" method="post" class="reviw_from">
                <div class="clearfix">
                  <div class="col-sm-6">
                    <div class="form-group label-floating">
                      <label class="control-label">Full Name</label>
                      <input type="email" class="form-control">
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div class="col-sm-12">
                    <div class="form-group label-floating">
                      <label class="control-label">Here can be your nice text</label>
                      <textarea class="form-control"  rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div class="col-sm-12">
                    <div class="pull-right">
                      <button class="btn defult_btn">Submit</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            
            <!------------Show Review Section----------------------->
            <div class="show_reviewsec">
              <ul class="nav nav-tabs">
              <!--  <li class="active"><a data-toggle="tab" href="#cusreviw">Reviews (<?php echo count($reviews);?>)</a></li>-->
                <li><a data-toggle="tab" href="#question"></a></li>
              </ul>
               <?php foreach ($reviews as $rval):
                   
                   if($rval['Review']['product_id']== $_GET['product_id']):
                   ?> 
              <div class="tab-content">
                <div id="cusreviw" class="tab-pane fade in active">
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="custmr-name"><?php echo $rval['Review']['name'];?></div>
                    </div>
                    <div class="col-sm-4">
                      <div class="verify">Verified Buyer</div>
                    </div>
                    <div class="col-sm-6">
                      <div class="review_date"><?php echo $rval['Review']['created'];?></div>
                    </div>
                  </div>
                  <div class="star-reviw">
                    <div class="star_rating">
                                                    <?php 
 $rate = count($reviews);

 $avg = '';
 foreach($reviews as $rt){
	 
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
                    </div>
                  </div>
                  <p class="voffset2"><?php echo $rval['Product']['name'];?></p>
                  <p> <?php echo $rval['Review']['text'];?> </p>
                  <div class="share_cust"> </div>
                  <div class="review_helpfl"> </div>
                </div>
                <div id="question" class="tab-pane fade">
                  <h3>Menu 1</h3>
                  <p>Some content in menu 1.</p>
                </div>
              
              </div>
               <?php

               endif; 
               endforeach;?> 
            </div>
         
        </div>
      </div>
    </div>
  </div>
  </div>