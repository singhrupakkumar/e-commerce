<?php echo $this->set('title_for_layout', 'Contact Us'); ?>
<div class="container">

<div class="col-sm-12">
                <div class="fancy05">
                  <h2>Contact us</h2>
                </div>
    
    <?php
if(isset($_POST['email'])) {
     
    // CHANGE THE TWO LINES BELOW
    
     
    $email_subject = "Wooden Shop contact form submissions";
     
     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
	
	
	
    $email_to =  Configure::read('Settings.ADMIN_EMAIL');
    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- place your own success html below -->
 
<h3 style="color:#093; font-size:20px;text-align: center;">Thank you for contacting us. We will be in touch with you very soon.</h3>
 
<?php
}
?>
    
    
    
    
    
</div>
       <div class="contact_us">
            <div class="row">
              <div class="clearfix">
            <div class="col-sm-4 col-xs-12">
          <div class="contact-detail-box">
            <i class="fa fa-th fa-3x text-colored"></i>
            <h4>Get In Touch</h4>
            <abbr title="Phone">Phone:</abbr><?php echo $adminemail[0]['User']['phone'];?><br>
            Email: <a href="mailto:<?php echo $adminemail[0]['User']['email'];?>" class="text-muted"><?php echo $adminemail[0]['User']['email'];?></a>
          </div>
        </div><!-- end col -->

        <div class="col-sm-4 col-xs-12">
          <div class="contact-detail-box">
            <i class="fa fa-map-marker fa-3x text-colored"></i>
            <h4>Our Location</h4>

            <address>
            Address: <?php echo $adminemail[0]['User']['address'];?>, <?php echo $adminemail[0]['User']['city'];?><br>
          </address>
          </div>
        </div><!-- end col -->

        <div class="col-sm-4 col-xs-12">
          <div class="contact-detail-box">
            <i class="fa fa-book fa-3x text-colored"></i>
            <h4>24x7 Support</h4>

            <p>Industry's standard dummy text.</p>
           
          </div>
         
      
        </div><!-- end col -->
        </div>
        
        <div class="col-sm-6 col-xs-12">
    <div class="contact_inner">
        
      
      <form class="form-horizontal" name="htmlform" method="post">
      <input  type="text" name="first_name" class="form-control" placeholder="First Name"  required="required" pattern="[a-zA-Z][a-zA-Z0-9\s]*">    
      <input  type="text" name="last_name" class="form-control" placeholder="Last Name"  required="required" pattern="[a-zA-Z][a-zA-Z0-9\s]*">
     
      <input  type="email" name="email" class="form-control" placeholder="Email" required="required">  
      <input  type="number" name="telephone"class="form-control" placeholder="Phone" required="required">
      <textarea  name="comments" class="form-control" placeholder="Comment" required="required"></textarea>
      
        <button class="btn btn-danger btn-md defult_btn">Submit</button>
      </form>
      </div>
      </div>
      
      <div class="col-sm-6 col-xs-12">
    <div class="contact_inner contc_map">
    	<div style="width: 100%"><iframe width="100%" height="343" src="http://www.citymaps.ie/create-google-map/map.php?width=100%&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street%2C%20Dublin%2C%20Ireland+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="http://www.mapsdirections.info/ro/creeaza-harta-google/">Adauga Google Map Website-ului</a> na <a href="http://www.mapsdirections.info/ro/">Planificare rută cu Google Maps</a></iframe></div><br />
      </div>
      </div>
            
        </div>
        </div>
</div>



