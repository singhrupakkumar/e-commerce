<?php echo $this->set('title_for_layout', 'Checkout'); ?>  
<!---------------------order_detls------------------>
<?php echo $this->Html->script(array('cart.js'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('shop_address.js'), array('inline' => false)); ?>
<?php echo $this->Html->script(array('jquery.validate.js', 'additional-methods.js', 'shop_review.js'), array('inline' => false)); ?>
   <div class="container">
    <div class="col-sm-12">
      <div class="fancy">
        <h2>Checkout</h2>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <div class="order_detls_sec">
          <div class="panel-group" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading"> 
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> <span class="badge">1</span> Order Details</a> </h4>
                <div class="chnagebtn">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><button class="btn readmr_btn">Change</button></a> 
                </div>
              </div>
              <div id="collapse1" class="panel-collapse collapse <?php  // if(empty($_GET['panel'])){ echo "in"; }?>">
                <div class="panel-body">
                  <div class="cart_sec">
                   <?php if(empty($shop['OrderItem'])) : ?>

Shopping Cart is empty

<?php else: ?>

<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'cartupdate'))); ?>


     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_tbl">
      <thead>
          <tr>
            <th>Item (S)</th>
             <th>QTY</th>
            <th>PRICE</th>
            <th>DELIVERY DETAILS</th>
             <th>SUBTOTAL</th>
             <th>REMOVE</th>
          </tr>
          </thead>
          <tbody>

<?php $tabindex = 1; ?>
<?php foreach ($shop['OrderItem'] as $key => $item): ?>



		       <tr id="row-<?php echo $key; ?>">
            <td data-label="ITEM">
            <div class="cartpdt_img">
                <?php echo $this->Html->image('/images/large/' . $item['Product']['image'], array('class' => 'img-responsive')); ?>
               
            </div>
            <div class="cart_desc">
            	<h3><?php echo $this->Html->link($item['Product']['name'], array('controller' => 'products', 'action' => 'view', 'slug' => $item['Product']['slug'])); ?></h3>
                <p><?php echo $item['Product']['description']; ?></p>
            </div>
            
            </td>
			   <?php
            $mods = 0;
            if(isset($item['Product']['productmod_name'])) :
            $mods = $item['Product']['productmod_id'];
            ?>
            <br />
            <small><?php echo $item['Product']['productmod_name']; ?></small> 
            <?php endif; ?>
            <td>
   <?php echo $this->Form->input('quantity-' . $key, array('div' => false, 'class' => 'numeric form-control input-small', 'label' => false, 'size' => 2, 'maxlength' => 2, 'tabindex' => $tabindex++, 'data-id' => $item['Product']['id'], 'data-mods' => $mods, 'value' => $item['quantity'])); ?>
            </td>
            <td data-label="Price" class="price_prdt" id="price-<?php echo $key; ?>">$<?php echo $item['Product']['price']; ?></td>
            <td data-label="Delivery Details"><div class="delivry_colr">Free</div><span>Delivery in 7-8 business days</span></td>
            <td data-label="Sub Total" class="price_prdt" id="subtotal_<?php echo $key; ?>"><strong>$<?php echo $item['subtotal']; ?></strong></td>
            <td data-label="Delete" ><span class="remove" id="<?php echo $key; ?>"></span></td>
          </tr> 

<?php endforeach; ?>
<tr>
    <div class="col col-sm-12">
        <div class="pull-right">
        <?php echo $this->Form->button('<i class="icon-refresh icon"></i> Recalculate', array('class' => 'btn btn-default', 'escape' => false));?>
        <?php echo $this->Form->end(); ?>
        </div>
    </div>
</tr>

<?php endif; ?> 
      </tbody>
        
        </table>
                  </div>
                </div>
              </div>
            </div> 
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"> <span class="badge">2</span>   Address</a> </h4>
                <div class="chnagebtn">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">  <button class="btn readmr_btn">Change</button></a> 
                </div>
              </div>
              <div id="collapse2" class="panel-collapse collapse <?php if($this->request->query('panel')==2){ echo "in"; }?>">  
                <div class="panel-body">
                  <div class="order_address">
                   <?php echo $this->Form->create('Order'); ?>

                      
                      <div class="col-sm-9 col-sm-offset-2">
                      <div class="ordr_addrssinr">
                        <div class="row">
                          <div class="col-sm-4">
                            <?php echo $this->Form->input('first_name', array('class' => 'form-control','placeholder'=> 'Enter First Name here')); ?>
                             
                              <input type="hidden" name="data[Order][uid]" value="<?php echo $loggeduser ;?>">  
                          </div>
                          <div class="col-sm-4">
                          
                            <?php echo $this->Form->input('last_name', array('class' => 'form-control','placeholder'=> 'Enter Last Name Here')); ?>
                           
                          </div>
                          <div class="col-sm-4">
                          <?php echo $this->Form->input('phone', array('class' => 'form-control field','placeholder'=> 'Phone Number', 'required' => 'required' , 'type' => 'text', 'autocomplete' => 'off', 'maxlength' => '10')); ?>
                          </div>
                        </div>
                        <div class="shipg">
                        <div class="clearfix">
                        <?php echo $this->Form->input('email', array('class' => 'form-control','placeholder'=> 'Enter Email Here')); ?> 
                   
                        </div> 
                        <div class="clearfix">
                        <label>Address</label>
                        <?php echo $this->Form->textarea('shipping_address', array('class' => 'form-control','placeholder'=> 'Enter Address Here','cols'=>'2')); ?> 
                   
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                             <?php echo $this->Form->input('shipping_city', array('class' => 'form-control','placeholder'=> 'Enter City Name Here','pattern'=>'[a-zA-Z ]+', 'autocomplete' => 'off')); ?>
                         
                          </div>
                          <div class="col-sm-3">
                           <?php echo $this->Form->input('shipping_state', array('class' => 'form-control','placeholder'=> 'Enter State Name Here','pattern'=>'[a-zA-Z ]+', 'autocomplete' => 'off')); ?>
                         
                          </div>
                          <div class="col-sm-3">
                            <?php echo $this->Form->input('shipping_zip', array('class' => 'form-control field','placeholder'=> 'Enter Zip Code Here', 'autocomplete' => 'off')); ?>
                          
                          </div>
                            
                          <div class="col-sm-3">
                            <?php echo $this->Form->input('shipping_country', array('class' => 'form-control','placeholder'=> 'Enter Country Name Here','pattern'=>'[a-zA-Z ]+', 'autocomplete' => 'off')); ?>
                          
                          </div> 
                        </div>
                        <div class="clearfix"> 
                        <div class="sav_btn">
                 <?php echo $this->Form->button('Save &amp; Continue', array('class' => 'btn defult_btn2','id'=>'sub'));?>
                        </div>
                        </div>
                      </div>
                    </div>
                       
                        <?php echo $this->Form->end(); ?>    
                    <div class="col-sm-12">

                    <div class="show_addres">
                    <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" checked="false">
                                <strong><?php if(!empty($shop['Order']['first_name'])) echo $shop['Order']['first_name'];?> <?php if(!empty($shop['Order']['last_name'])) echo $shop['Order']['last_name'];?></strong><br/>
                                <?php if(!empty($shop['Order']['email'])) echo $shop['Order']['email'];?><br/>
                                <?php if(!empty($shop['Order']['phone'])) echo $shop['Order']['phone'];?>  
                            </label>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> <span class="badge">3</span> Place Order</a> </h4>
                <div class="chnagebtnnone">&nbsp;</div>
              </div>
              <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                <div class="place_ordr">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="plac_tbl">
                    <thead>
                      <tr>
                        <th>Item (<?php echo $shop['Order']['quantity']; ?>)</th>
                        <th><?php echo $item['Product']['created']; ?></th>
                      </tr>
                      </thead>
                      <tbody>
                   <?php foreach ($shop['OrderItem'] as $key => $item): ?>       
                      <tr>
                        <td>
                        <div class="place_img">
                        <?php echo $this->Html->image('/images/large/' . $item['Product']['image'], array('class' => 'img-responsive')); ?>      
                           
                        </div>
                        <div class="place_decs">
                        	<h3><?php echo $item['Product']['name']; ?></h3>
                            <p><?php echo $item['Product']['description']; ?></p>
                        </div>
                        </td>
                        <td>$<?php echo $item['Product']['price']; ?></td>
                      </tr>
                      <?php endforeach; ?>
                 
                      <tr>
                        <td class="grand_tlt">                      
                        <strong>Grand Total</strong>
                        </td>
                        <td data-label="Grand Total" >$<?php echo $shop['Order']['total']; ?></td>
                      </tr>
                      </tbody>
                      <div class="clearfix"></div>
                    </table>
                    
                    <div class="shipng_adrs"> 
                    	<h3>Shipping Address</h3> 
                        <p><?php if(!empty($shop['Order']['shipping_address'])) { echo $shop['Order']['shipping_address']; } ?><br/>
                      <?php if(!empty($shop['Order']['shipping_city'])) { echo $shop['Order']['shipping_city']; } ?> .<br/>
                       <?php if(!empty($shop['Order']['shipping_state'])) { echo $shop['Order']['shipping_state']; } ?>  <?php if(!empty($shop['Order']['shipping_zip'])) { echo $shop['Order']['shipping_zip']; } ?><br/>
                      
                       <?php if(!empty($shop['Order']['shipping_country'])) echo $shop['Order']['shipping_country'];?></p>
                                            </div>                    

                </div>   
                
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"> <span class="badge">4</span> Payment</a> </h4>
                <div class="chnagebtnnone">&nbsp;</div>
              </div>
              <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                
                <div class="payment_mthd">
                <div class="payment_innr">
              <form action="<?php echo $this->webroot."shop/review"?>" method="post">
                 <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" checked="true">
                         
                            Pay with Paypal
                        </label>
                    </div>
                    <div class="paymnt_img"><input type="image" name='submit' src="<?php echo $this->webroot;?>home/images/paypal_icon.png" alt="" ></div>
   
              </form>
                </div>  
                </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>


  <!---------------------order_detls------------------> 