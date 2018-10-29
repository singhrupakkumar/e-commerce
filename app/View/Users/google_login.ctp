

<div class="container">

<div class="col-sm-12">
                <div class="fancy">
                  <h2>Google Profile</h2>
                </div>
          	</div>
        <div class="privacy_policy">
          <?php
		   if (isset($authUrl)){ 
	//show login url
	echo '<div align="center">';
	echo '<h3>Login with Google -- Demo</h3>';
	echo '<div>Please click login button to connect to Google.</div>';
	echo '<a class="login" href="' . $authUrl . '"><button class="btn btn-info">Google Login</button></a>';
	echo '</div>';
	
		}
		  
		  
		  
		  
if(!empty($exist)) //if user already exist change greeting text to "Welcome Back"
    {
        echo 'Welcome back '.$exist[0]['User']['name'].'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]<br/>';
		 echo 'Email:-'.$exist[0]['User']['email'].'! ';

		echo '<img src="'.$exist[0]['User']['image'].'" style="float: right;margin-top: 33px;" />';
    }

?>
        
        </div>
</div>
