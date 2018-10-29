 <?php echo $this->set('title_for_layout', 'Reset Password'); ?> 
 <div class="con_main">
     	<div class="container">
        
          <div class="page_inn"><!--page inn start-->
        
        <div class="col-sm-3"></div>
     <div class="col-sm-6">
     <div class="login_box_m">
         <?php $x=$this->Session->flash(); 
           if($x)
           {
               echo $x;
           }
           
         
         ?>
   <div class="login_b"><h1>Reset password</h1></div> 
   <div class="loign_form">
     <?php echo $this->Form->create('User',array('id'=>'reset'));   ?>
     <div class="reset-gp">
       <div class="col-sm-5">
       <label>Password  <i>*</i></label>
       </div>
        <div class="col-sm-7">
        <input type="password"  class="form-control" id="pass5" name="data[User][password]" required >
        </div>
        </div>
        <div class="reset-gp">
        <div class="col-sm-5">
        <label>Confirm Password <i>*</i></label>
         </div>
         <div class="col-sm-7">
        <input type="password"  class="form-control"  name="data[User][password_confirm]" required>
         </div>
         </div>
       <div class="col-sm-12"> 
       <div class="login_buttonn "><input type="submit" name="submit" value="Submit" class="btn defult_btn"></div>
       </div>
      </div>
      
   
     <?php $this->Form->end(); ?>
     </div> </div>
   
   <div class="col-sm-3"></div>
   

   </div></div>
     </div><!--page inn end-->
     <script type="text/javascript">
          $(document).ready(function() {
                $("#reset").validate({
                    errorElement: 'span',
                    rules: {
                      "data[User][password]": "required",
                        "data[User][password_confirm]": {
                            required: true,
                            minlength: 8,
                            equalTo: "#pass5"
                        }
                    },
                    messages: {
                           "data[User][password_confirm]": {
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