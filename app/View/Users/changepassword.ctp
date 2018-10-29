 <?php echo $this->set('title_for_layout', 'Change your Password'); ?>
  <div class="container">
  <div class="col-sm-6 col-sm-offset-3">
    <div class="row">  
      <div class="nww_passwrd">
      
     
      <h2>Change your Password</h2>
      <?php echo $this->Form->create('User', array('id' => 'changepassword')); ?>
      <div class="col-sm-12">
     
  <div class="form-inr">
	<div class="form-group label-floating">
		<label>Old Password</label>
		   <input name="data[User][old_password]" type="password" class="form-control login-field focus_frm" value="" placeholder="Old Password" id="login-name" />
		
	</div>
	
	<div class="form-group label-floating">
		<label >New Password</label>
		    <input name="data[User][new_password]" type="password" class="form-control login-field focus_frm" value="" placeholder="New Password" id="login-pass" />
		
	</div>



	<div class="form-group label-floating">
		<label>Confirm Password</label>
		
		 <input name="data[User][cpassword]" type="password" class="form-control login-field focus_frm" value="" placeholder="Confirm New Password" id="login-pass" />
		
	</div>

      </div>
    </div>
    
    <div class="col-sm-12">
    <div class="row">
    <div class="reser_btn">
   
    	<input class="btn defult_btn btn_chdpwd" name="submit" type="submit" value="CHANGE PASSWORD">
       
    
       </div> 
     </div>  
    </div>
    <?php echo $this->Form->end(); ?>
      	
      </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
    $(document).ready(function() {
                $("#changepassword").validate({
                    errorElement: 'span',
                    rules: {
                        "data[User][old_password]": "required",
                         "data[User][new_password]": "required",
                        "data[User][cpassword]": {
                            required: true,
                            minlength: 8,
                            equalTo: "#pass1"
                        }

                    },
                    messages: {
                        "data[User][old_password]": "Please Enter Old password",
                        "data[User][new_password]": "Please Enter New password",
                        "data[User][cpassword]": {
                            required: "Please Enter confirm password",
                            equalTo: "Confirm Password is not matching your Password"
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
</script> 