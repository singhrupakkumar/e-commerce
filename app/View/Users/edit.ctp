<?php echo $this->set('title_for_layout', 'Edit Profile'); ?>

<style> 


 @media (max-width: 980px) {
.banner_slide {
    height: 547px !important;
    margin-bottom: 4%;
}
	/*.contact_us {
		  width: 92% !important; 
		  margin:0 4% !important;
		  
	 }*/
.container.margin_60_35 {
    margin-top: -10% !important;
}
 }

 @media (max-width: 800px) {
.banner_slide {
    height: 452px !important;
}
	/*.contact_us {
		  width: 92% !important; 
		  margin:0 4% !important;
	 }*/
.container.margin_60_35 {
    margin-top: -21% !important;
}
 }
 @media (max-width: 768px) {
.banner_slide {
    height: 433px !important;
}
/*	.contact_us {
		  width: 92% !important; 
		  margin:0 4% !important;
	 }*/
.container.margin_60_35 {
    margin-top: -21% !important;
}
 }
  @media (max-width: 360px) {
.banner_slide {
    height: 280px !important;
}
.venue-detailsnew {
    margin: -36px 0 6px;
}
	/*.contact_us {
		  width: 92% !important; 
		  margin:0 4% !important;
	 }*/
.container.margin_60_35 {
    margin-top: -32% !important;
}
.active11 {
   box-shadow: 0 0 1px #c5c5c5 !important;
    display: block;
    font-size: 11px !important;
    height: 30px !important;
    line-height: 30px !important;
    margin-bottom: 14px;
    margin-top: -7%;
    padding: 0 24px !important;
    width: 129px !important;
}
.account_child {
    background: rgba(255, 255, 255, 0.95) none repeat scroll 0 0;
    box-shadow: 0 0 3px #c5c5c5;
    display: none;
    height: 185px;
    overflow: hidden;
    padding: 4% 0;
    position: absolute;
    right: 1px;
    top: 24px;
    width: 165px;
    z-index: 999999;
}
  }

 @media (max-width: 320px) {
	/*.contact_us {
		  width: 92% !important; 
		  margin:0 4% !important;
	 }*/
.container.margin_60_35 {
    margin-top: -42% !important;
}
.venue-detailsnew {
    color: #d71f26;
    font-size: 22px;
    font-weight: 500;
    letter-spacing: 0.4px;
    margin: -58px 0 6px;
    padding: 0;
    text-transform: uppercase;
}
.venue-detailsnew1 {
    font-size: 13px;
    line-height: 31px;
    margin: 10px 0 0;
}

.nomargin_top {
    color: #d71f26 !important;
    font-size: 25px !important;
    margin-top: -22px !important;
}	 
.path1 > img {
    float: left !important;
    left: 0 !important;
    position: relative!important;
    top: 0;
    width: 100% !important;
}
.newsletter-cta-text {
    font-size: 13px;
    padding: 0 8px;
    width: 95%;
}

.neigh {
    margin: 0 41%;
    width: 17%;
}
.newsletter-cta-text {
    font-size: 13px;
}
.banner_slide h2 {
    color: #fff;
    font-size: 21px;
    left: 39%;
    position: absolute;
    top: 17%;
}

ul.btn_log {
    float: right;
    position: absolute;
    right: 1%;
    top: 24%;
    width: 50%;
}
.newsletter-cta{
	  background-color: #d71f26;
    border: 1px solid #e9e9eb;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    float: left;
    font-size: 12px;
    margin: 5px 0 7px 23%;
    outline: medium none;
    padding: 12px 4.2rem;
}

 }
 .img-responsive1 {
    margin-top: 30px;
}

</style>


<!-- Content ================================================== -->
<div class="container">
	<div class="row">
    	<div class="col-sm-6  col-sm-offset-3">
   <div class="contact_us">
   <?php
                $x = $this->Session->flash();
                if ($x) {
                    echo $x;
                }
                ?> 
            <h2 >EDIT PROFILE</h2>
	
		
		
		
	   
	  <?php echo $this->Form->create('User', array('id' => 'editform')); ?>
      
      <div class="editfrm">
      <div class="col-sm-3"><label for="last_name">Full Name </label></div>
       <div class="col-sm-9">  <input  type="text" name="data[User][name]" value="<?php echo $data['User']['name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
      </div> 
      
        <div class="editfrm">
         <div class="col-sm-3">  <label for="last_name">First Name</label></div>
       <div class="col-sm-9">   <input  type="text" name="data[User][first_name]" value="<?php echo $data['User']['first_name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="last_name">Last Name </label></div>
       <div class="col-sm-9">   <input  type="text" name="data[User][last_name]" value="<?php echo $data['User']['last_name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="email">Email Address </label></div>
       <div class="col-sm-9">  <input name="data[User][email]" value="<?php echo $data['User']['email']; ?>" type="text"  maxlength="80" size="30"/></div>
       </div>
       
        <div class="editfrm">
        <div class="col-sm-3"><label for="first_name">Address </label></div>
       <div class="col-sm-9">  <input  type="text" name="data[User][address]" value="<?php echo $data['User']['address']; ?>" maxlength="50" size="30" required="required"></div>
       </div>
       
        <div class="editfrm">
        <div class="col-sm-3">  <label for="last_name">City </label></div>
       <div class="col-sm-9">  <input  type="text" name="data[User][city]" value="<?php echo $data['User']['city']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="email">State</label></div>
       <div class="col-sm-9">  <input  type="text" name="data[User][state]" value="<?php echo $data['User']['state']; ?>" maxlength="80" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="first_name">Country</label></div>
       <div class="col-sm-9">   <input  type="text" name="data[User][country]" value="<?php echo $data['User']['country']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
          <div class="col-sm-3"><label for="last_name">Zip</label></div>
       <div class="col-sm-9"> <input  type="number" name="data[User][zip]" value="<?php echo $data['User']['zip']; ?>" maxlength="50" size="30" required="required"></div>
       </div>
       
       
        <div class="editfrm">
          <div class="col-sm-3"><label for="email">Phone</label></div>
       <div class="col-sm-9"> <input  type="number" name="data[User][phone]" value="<?php echo $data['User']['phone']; ?>" maxlength="80" size="30" required="required"></div>
       </div>
       
       <div class="editfrm">  
       <div class="col-sm-12"> <button type="submit" name="submit" class="btn defult_btn contact_us1">SUBMIT</button></div>
       </div>
      

<?php echo $this->Form->end(); ?>
	
		</div>
       </div>  
	</div><!-- End row -->
	<!--<hr class="more_margin">-->
   

</div><!-- End container -->
























<!--
<div class="con_main">
    <div class="container">
        <div class="edit">
            <h2>Edit Profile</h2>
            <h4><?php
                //$x = $this->Session->flash();
               // if ($x) {
                 //   echo $x;
                //}
                ?></h4>
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="edit_box">
                    <?php //echo $this->Form->create('User', array('id' => 'editform')); ?>
                    <label>Username</label>
                    <input name="data[User][username]" value="<?php //echo $data['User']['username']; ?>" type="text" readonly/><br/>
                    <label>Full Name</label>
                    <input name="data[User][name]" value="<?php //echo $data['User']['name']; ?>" type="text"/><br/>
                    <label>E-mail</label>
                    <input name="data[User][email]" value="<?php //echo $data['User']['email']; ?>" type="text"/><br/>
                    <label>Address</label>
                    <input name="data[User][address]" value="<?php //echo $data['User']['address']; ?>" type="text"/><br/>
                    <label>City</label>
                    <input name="data[User][city]" value="<?php //echo $data['User']['city']; ?>" type="text"/><br/>
                    <label>State</label>
                    <input name="data[User][state]" value="<?php //echo $data['User']['state']; ?>" type="text"/><br/>
                    <label>Country</label>
                    <input name="data[User][country]" value="<?php //echo $data['User']['country']; ?>" type="text"/><br/>
                    <label>Zip</label>
                    <input name="data[User][zip]" value="<?php //echo $data['User']['zip']; ?>" type="text"/><br/>
                    <label>Phone</label>
                    <input name="data[User][phone]" value="<?php //echo $data['User']['phone']; ?>" type="text"/><br/>
                </div>
                <input name="submit" type="submit" value="Submit"/>
            </div>
        </div>
        <?php //echo $this->Form->end(); ?>
        <div class="col-sm-3"></div>
    </div>
</div>
</div>
</div>-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#editform").validate({
            errorElement: 'span',
            rules: {
                "data[User][fname]": "required",
                "data[User][lname]": "required",
                "data[User][email]": "required"
            },
            messages: {
                "data[User][fname]": "Please enter your First Name",
                "data[User][lname]": "Please enter your Last Name",
                "data[User][cor]": "Please enter your Country of residence",
                "data[User][currency]": "Please enter your currency",
                "data[User][email]": "Please enter your E-mail ID"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>