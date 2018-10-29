<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $title_for_layout; ?></title>
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-------------------- Bootstrap ------------------------->
<link href="<?php echo $this->webroot; ?>home/css/bootstrap.min.css" rel="stylesheet">
<!-------------------- Style ------------------------->
<link href="<?php echo $this->webroot; ?>home/css/style.css" rel="stylesheet">
<!-------------------- Material Design ------------------------->
<link href="<?php echo $this->webroot; ?>home/css/material-kit.css" rel="stylesheet">
<link href="<?php echo $this->webroot; ?>home/css/demo.css" rel="stylesheet">
<link href="<?php echo $this->webroot; ?>home/css/admin.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	
	 <script>
$(document).ready(function(){
 $(".field").keydown(function(event){

            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 58) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }
            
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190){
                event.preventDefault();
            }
        });
		
      });
  </script>
	
    <?php echo $this->Html->script(array('bootstrap.min.js')); ?>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <?php echo $this->Html->script(array('js.js')); ?>
    <?php echo $this->App->js(); ?>
    <?php echo $this->fetch('meta'); ?>
    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
<!-------------------- font-awesome ------------------------->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!-------------------- Roboto ------------------------->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
    .flash-msg{text-align: center;}
    #flashMessage {text-align: center;
    font-weight: bold;
    color: green;} 
</style>
</head>
<?php 
$ses_user =$this->Session->read('User');
$logout =$this->Session->read('logout');

$googleloginurl =$this->Session->read('googlelogin');
  ?>
<body>
<?php if($this->fetch('title') !='Api Forgot password'): ?>    
<header>
<div class="header">
  <div class="container">
    <div class="row">
      <div class="top-nav">
        <div class="col-sm-6 col-xs-12">
          <div class="top-search">
          
        
            <div class="free-shp">
              <p>Free Shipping in United States and Canada</p>
            </div>
          
           
            <div class="serach">
                
                

                    <?php echo $this->Form->create('Product', array('type' => 'GET', 'url' => array('controller' => 'products', 'action' => 'search'))); ?>

                    <?php echo $this->Form->input('search', array('label' => false, 'div' => false, 'id' => 's', 'class' => 'input-sm s','placeholder'=>'Search by Product Name', 'autocomplete' => 'off')); ?>
                   
                      <button type="submit" class="btn defult_btn scrh_btn"><i class="fa fa-search" aria-hidden="true"></i> </button>
                    <span id="cartbutton" style="display:none;">
                        <?php echo $this->Html->link('Shopping Cart', array('controller' => 'shop', 'action' => 'cart'), array('class' => 'btn btn-sm btn-success')); ?>
                    </span>
                    <?php echo $this->Form->end(); ?>
  
            </div>
           
            
          </div>
        </div>
      
        <div class="col-sm-6 col-xs-12">
          <div class="shipping">
            <ul class="pull-right">
              <li><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:<?php echo Configure::read('Settings.SHOP_PHONE'); ?>"><?php echo Configure::read('Settings.SHOP_PHONE'); ?></a></li>
                 <?php if (!empty($loggeduser)) { ?>
              <li><a href="<?php echo $this->webroot."users/showwishlist" ;?>">Wishlist</a><?php } ?></li>
              <li><a href="<?php echo $this->webroot ?>shop/cart" ><img src="<?php echo $this->webroot;?>home/images/cart_icn.png"  alt=""> <span class="badge"><?php $shop = $this->Session->read('Shop');   echo count($shop['OrderItem']); ?> </span></a></li>
			   <?php if (empty($loggeduser) && !$this->Session->check('User') && empty($ses_user)){ ?>
               <li><a href="#" data-toggle="modal" data-target="#signupModal">Signup</a></li> 
              <li><a href="#" data-toggle="modal" data-target="#loginModal">Signin</a></li> 
			 <?php } else { ?>
				<li><a href="<?php echo $this->webroot."users/myaccount" ;?>"> My Profile </a> </li>
				<li><a href="<?php if($this->Session->check('User') && $ses_user){echo $logout;}else{ echo $this->webroot.'users/logout';} ?>">Log Out</a> </li> 
			 <?php } ?>	 
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-menu">
    <nav class="navbar navbar-default navbar-blck" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="<?php echo $this->webroot ;?>shop/index"><img src="<?php echo $this->webroot ;?>home/images/logo.png " width="75"></a> </div>
        <div class="collapse navbar-collapse main-nav" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="<?php if($this->fetch('title') =='Wooden Watches'){ echo "active"; }?>"><a href="<?php echo $this->webroot ;?>category/wooden-watches">Wooden Watches</a></li>
            <li class="<?php if($this->fetch('title') =='Wooden bracelets'){ echo "active"; }?>"><a href="<?php echo $this->webroot ;?>category/wooden-bracelets">Wooden bracelets</a></li>
            <li class="<?php if($this->fetch('title') =='Organic T-Shirts'){ echo "active"; }?>"><a href="<?php echo $this->webroot ;?>category/organic-t-shirts">Organic T-Shirts</a></li>
            <li class="<?php if($this->fetch('title') =='Shop Instagram'){ echo "active"; }?>"><a href="<?php echo $this->webroot ;?>category/shop-instagram">Shop Instagram</a></li>
            <li class="<?php if($this->fetch('title') =='Our Story'){ echo "active"; }?>"><a href="<?php echo $this->webroot."staticpages/our_story"; ?>">Our Story</a></li> 
          </ul>  
        </div>
      </div>
    </nav>
  </div>
  </div>
</header>

<!--------------Banner------------------->

<!--------------Banner------------------->
 <?php $pageTitle = $this->fetch('title'); 
 if($pageTitle == 'Shop'):
 ?>
<div class="banner-sldr">
  <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
    <!-- Indicators -->
    <ol class="carousel-indicators">
             <?php 
       $item = 0; 
       foreach ($sliderimage as $img): ?>   
        <li data-target="#myCarousel" data-slide-to="<?php echo $item ;?>" class="<?php if($item ==0) { echo "active" ; }?>"></li>
      <?php 
      $item++; 
      endforeach ;?>  
    </ol>
    
    <!-- Wrapper for slides -->
    
    <div class="carousel-inner" role="listbox">
       <?php 
       $item = 0; 
       foreach ($sliderimage as $img): $item++; ?> 
        <div class="item <?php if($item ==1) { echo "active" ; }?>"> <img src="<?php echo $this->webroot."files/staticpage/".$img['Staticpage']['image'];?>" alt="Chania" >
        <div class="carousel-caption">
          <h2><span><?php echo $img['Staticpage']['title']; ?></span></h2> 
          <p><?php echo $img['Staticpage']['description']; ?></p>
        </div>
      </div>
       <?php endforeach; ?> 
  
    </div>
    
    <!-- Left and right controls --> 
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
</div>
<?php else : ?>
<!----------------Slider ends-----------------------> 

<!----------------Shop All Watches----------------------->

<div class="wdn-wact-bnnr">
<img src="<?php echo $this->webroot ;?>home/images/wooden-watches-bg.jpg" alt="" class="img_head" >
<div class="wodn_watchinr">
  <h1><?php echo $pageTitle ;?> </h1>
  </div>  
  <div class="overlay"></div>
</div>
<?php endif ;
endif;
?>
<div class="smart_container">

            <?php
			echo $this->Session->flash(); ?>
			
			<div class="container">
				<div class="breadcrumlst">    
				<ol class="breadcrumb">

					<li> <?php echo $this->Html->link('Home', array('controller' => 'shop', 'action' => 'index')); ?> / <?php echo $this->Html->getCrumbs(' / '); ?></li>
					 <li class="active"><?php echo $pageTitle ;?></li>
				
				</ol>    
				</div>
		   </div>

            <?php echo $this->fetch('content'); ?>
       
	   
<div class="message" style="text-align:center;font-weight: bold;"></div>
<div class="last-offr">
<div class="container">
<div class="row">
<div class="last-offr-inner">

		  <div class="col-sm-6">
        <h4>Get the Latest <span>Offers and Exclusives</span></h4>
        <p>Great deals sent to your inbox and you could win a $100 gift card</p>
        </div>
        <div class="col-sm-6">
         <form class="form-subs" method="post" id="subscribe">
        <div class="subscribe">
       <input id="email" type="email" name="email" value="" aria-required="true" aria-invalid="false" placeholder="Your Email Address...">
       <button id="nwsltr" type="button" name="nwsltr" class="btn defult_btn subs_btn"> Subscribe</button>
       </div>
       </form>
        </div>
   
</div>


</div>
</div>
</div>	   


</div><!---smart_container end---->
<!-------------------Footer--------------------->
<?php if($this->fetch('title') !='Api Forgot password'): ?>  



<footer>
<div class="container">
<div class="row">
        <div class="footer">
        
        <div class="col-sm-3 col-xs-12">
        <ul class="footr-links">
        <li><a href="<?php echo $this->webroot."staticpages/faq"; ?>">FAQ's</a></li>
        <li><a href="<?php echo $this->webroot."staticpages/privacy_policy"; ?>">Privacy Policy</a></li>
        </ul>
        </div>
        
        <div class="col-sm-3 col-xs-12">
        
        <ul>
       
        <li><a href="<?php echo $this->webroot."staticpages/blog"; ?>">Blog</a></li>
        <li><a href="<?php echo $this->webroot."staticpages/about_us"; ?>">About Us</a></li>
        <li><a href="<?php echo $this->webroot."staticpages/contact_us"; ?>">Contact Us</a></li>
        </ul>
        
        <address>Working days, Hours<br> <span>Mon - Sun / 9:00 Am - 8:00 PM</span></address>
        
        </div>
        
        <div class="col-sm-3 col-xs-12">
        <ul>
        <li><a href="<?php echo $this->webroot."staticpages/shop_instagram"; ?>">Shop Instagram</a></li>
       
        </ul>
        <address>1500 S Diego Drive, Suite 204
        San Diego, CA - 92093
        888-888-8888</address>
        <span><a href="mailto:<?php echo Configure::read('Settings.ADMIN_EMAIL'); ?>"><?php echo Configure::read('Settings.ADMIN_EMAIL'); ?></a></span>
        </div>
        
        <div class="col-sm-3 col-xs-12">
      		
            <div class="secrty">
            		<ul>
            <li>	<img src="<?php echo $this->webroot; ?>home/images/macafee.png" alt=""  class="img-responsive"></li>
            <li>    <img src="<?php echo $this->webroot; ?>home/images/athurize.png" alt=""  class="img-responsive"></li>
                </ul>
            </div>
            
          
            	<div class="social-follow">
                <h4>Follow us:</h4>
                <ul>
                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="https://in.pinterest.com/login/"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>                
                </ul>
                </ul>
                </div>
            </div>
        
        
        
        </div>
        
        <hr/>
        
      
</div>
</div>


<div class="container">
	<div class="row">
    <div class="footer_btm">
    <div class="col-sm-6 col-xs-12">
      <div class="bottom-footer">
        <ul>
           <li><a href="#">Site Map</a></li> 
           <li><a href="<?php echo $this->webroot."staticpages/term_conditon";?>">Terms & Conditions</a></li>
           <li><a href="#">Made in USA</a></li>
            <li><a href="#">&copy; 2016 Wear Organic LLC</a></li> 
            
        </ul>
        </div>
        </div>
        <div class="col-sm-6 col-xs-12">
      <div class="paymnt-footer">
        <ul>
        	<li><a href="#"><img src="<?php echo $this->webroot; ?>home/images/paypal.png" alt="" ></a></li>
            <li><a href="#"><img src="<?php echo $this->webroot; ?>home/images/visa.png" alt="" ></a></li>
            <li><a href="#"><img src="<?php echo $this->webroot; ?>home/images/masercard.png" alt="" ></a></li>            
            
        </ul>
        </div>
        </div>
      </div>  
    </div>
</div>

</footer>
<?php endif; ?>



<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h4 class="modal-title" id="myModalLabel">Sign In</h4>
      </div>
      <div class="modal-body">
         <form action="<?php echo $this->webroot; ?>users/login" method="post"  id="myLogin" class="login-frm">
         <div class="form-group label-floating">
         <label class="control-label">Email</label>
         <input type="text" name="data[User][username]" class="form-control" >
         </div>
          <div class="form-group label-floating">
          <label class="control-label">Password</label>
         <input type="Password"  name="data[User][password]" class="form-control">
		 <input type="hidden" name="data[User][server]" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
         </div>
         <button type="submit" class="btn defult_btn2">Sign In</button>
        </form>
      </div>
      <div class="modal-footer">
      <p><a href="<?php echo $this->webroot; ?>users/forgetpwd">Forgot Password?</a></p>
      <div class="horiznl_line">
      <h3><span class="line-center">OR</span></h3>
      </div>
     <p class="fnt_drkgry">Access with your Social Account</p>   
      <div class="social-icon">
        <?php if(!$this->Session->check('User') && empty($ses_user))   { ?>   
       <a type="button" class="btn btn-just-icon btn-round fb-fb" id="facebook"><i class="fa fa-facebook"></i></a>
       <?php }  else{ }?>         
       <a type="button" href="<?php echo  $this->webroot."users/google_login"; ?> " class="btn btn-just-icon btn-round gplus-gplus"><i class="fa fa-google-plus"></i></a>
       <a type="button" href="<?php echo $this->webroot."users/twitter_process"?>" class="btn btn-just-icon btn-round tw-tw"><i class="fa fa-twitter"></i></a>
       </div> 
      </div>
    </div>
  </div>
</div>


<!-- Register Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h4 class="modal-title" id="myModalLabel">Sign up</h4>
      </div>
      <div class="modal-body">
         <form action="<?php echo $this->webroot; ?>users/add" method="post" id="myRegister" class="register-frm">
         
         <div class="form-group label-floating">
         <label class="control-label">Email Address</label>
         <input type="email" id="emailid" name="data[User][email]" class="form-control" >
         </div>
         
          <div class="label-frm ">
          <label class="gender" class="control-label">Gender</label>
          
           <div class="radio">
                <label>
                    <input type="radio" value="male" id="gender1" checked name="data[User][gender]">
                    Male
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="female" id="gender2" name="data[User][gender]">
                    Female
                </label>
            </div>
         
         
         </div>
         
         
         
         <div class="form-group label-floating">
          <label class="control-label">DD/MM/YYYY</label>
       <!--  <input type="text" name="data[User][birth]"  class="form-control">-->
          <input class="form-control" id="date" name="data[User][birth]" placeholder="" type="text"/>
         </div>
         
         <div class="form-group label-floating">
          <label class="control-label">Mobile Number</label>
         <input type="number" name="data[User][phone]"  class="form-control">
         </div>
         
         <div class="form-group label-floating">
          <label class="control-label">Password</label>
         <input type="Password" name="data[User][password]" id="password1" required="required"   class="form-control">
         </div>
         
         <div class="form-group label-floating">
          <label class="control-label">Confirm Password</label>
         <input type="Password" id="password2" name="data[User][cpassword]" class="form-control">
         </div>
         
         <button type="submit" id="create" class="btn defult_btn2">Create Account</button>
        </form>
      </div> 
      <div class="modal-footer">
      <p>Already have an Account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Sign In</a></p> 
      </div>
    </div>
  </div>
</div>




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 

<script src="<?php echo $this->webroot; ?>home/js/material-kit.js" ></script> 
<script src="<?php echo $this->webroot; ?>home/js/bootstrap-datepicker.js" ></script> 
<script src="<?php echo $this->webroot; ?>home/js/nouislider.min.js" ></script> 
<script src="<?php echo $this->webroot; ?>home/js/material.min.js" ></script>
 <?php echo $this->Html->script('oauthpopup');  ?> 
<script type="text/javascript">
        function valid_email_address(email)
        {
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            return pattern.test(email);
        }
        
     jQuery('#create').on("click", function ($) {
         
            if(jQuery("#emailid").val()== ''){
            alert('Email is Required');
       }
       var pss1 = jQuery("#password1").val();
       var pss2 = jQuery("#password2").val();
       if(pss1 != pss2){
           alert('password mismatch');
           return false ;
       } 
 
     });
        
        jQuery('#nwsltr').on("click", function ($) {
            if (!valid_email_address(jQuery("#email").val()))
            {
                jQuery(".message").html('Please make sure you enter a valid email address.');
            }
            else
            {

                jQuery(".message").html("<span style='color:green;'>Almost done, please check your email address to confirmation.</span>");
                jQuery.ajax({
                    url: '<?php echo $this->webroot ;?>/shop/newsletter',
                    data: jQuery('#subscribe').serialize(),
                    type: 'POST',
                    success: function (msg) {
                        if (msg == "success")
                        {
                            jQuery("#email").val("");
                            jQuery(".message").html('<span style="color:green;">You have successfully subscribed to our mailing list.</span>');

                        }
                        else
                        {
                            jQuery(".message").html('<span style="color:green;">Please make sure you enter a valid email address.</span>');
                        }
                    }
                });
            }
            return false;
        });
        
    </script> 
 
    <script type="text/javascript">
            $('#facebook').click(function(e){
	//alert('hello');
        $.oauthpopup({
            path: '<?php echo $this->webroot;?>users/fblogin', 
			width:600,
			height:300,
            callback: function(){
                window.location.reload();
            }
        });
		e.preventDefault();
    });
	
  </script>  
  

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('#date'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>

</body>
</html>