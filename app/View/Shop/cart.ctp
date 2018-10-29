 
<div class="container">
     <div class="col-sm-12">
      <div class="fancy03">
        <h2>Cart</h2>
      </div>
     </div>
	 
     <div class="col-sm-12">
      <div class="row">      
      <div class="cart_sec" style="text-align: center;"> 
<?php echo $this->set('title_for_layout', 'Shopping Cart'); ?>
<?php echo $this->Html->script(array('cart.js'), array('inline' => false)); ?>
<?php if(empty($shop['OrderItem'])) : ?>

Shopping Cart is empty

<?php else: ?>

<?php echo $this->Form->create(NULL, array('url' => array('controller' => 'shop', 'action' => 'cartupdate'))); ?>


     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_tbl">
         <h2>Cart (<?php echo count($shop['OrderItem'] ); ?>)</h2>
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
        <?php echo $this->Html->link('<i class="icon-remove icon"></i> Clear Cart', array('controller' => 'shop', 'action' => 'clear'), array('class' => 'btn defult_btn', 'escape' => false)); ?>
        &nbsp; &nbsp;
        <?php echo $this->Form->button('<i class="icon-refresh icon"></i> Recalculate', array('class' => 'btn defult_btn2', 'escape' => false));?>
        <?php echo $this->Form->end(); ?>
        </div>
    </div>
</tr>

<?php endif; ?>
      </tbody>
          <tfoot>
          <tr>
          <td colspan="6" class="text-right" ><?php if(!empty($shop['OrderItem'])) {?> Estimated Total : <strong>$<?php } echo $shop['Order']['total']; ?></strong></td>
          </tr>
          <!--<tr><td colspan="6" class="fot_blk">&nbsp;</td></tr>-->
          </tfoot>
        </table>
        </div>  
        
       </div>
    </div> 
     
     <?php if(!empty($shop['OrderItem'])) {?>
     <div class="col-sm-12">
     <div class="checkout_btn">
        <?php 
        if (!empty($loggeduser)) {
        echo $this->Html->link('<i class="glyphicon glyphicon-arrow-right"></i> Checkout', array('controller' => 'shop', 'action' => 'address'), array('class' => 'btn defult_btn', 'escape' => false)); 
        }else{
         echo '<button id="check" class="btn defult_btn">Checkout</button>';   
        }
        ?>
     </div>
     </div>
     <?php } ?>
     
     
  </div>
<script type="text/javascript"> 
$(document).ready(function(){
$('#check').click(function(e){
 alert('you must login first');

 $('#loginModal').modal('show');

});
});
</script>


 
 