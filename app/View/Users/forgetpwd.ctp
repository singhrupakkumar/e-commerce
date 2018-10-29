<?php echo $this->set('title_for_layout', 'Forgot Password'); ?> 
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="row">
            <?php 
			$x=$this->Session->flash(); 
           if($x)
           {
               echo $x;
           }
           
         
         ?>
      <div class="nww_passwrd">
       
     
      <h2>Forgot Password</h2>
       <?php echo $this->Form->create('User');   ?>
        <div class="form-nwpass">
      <div class="col-sm-12 col-xs-12">
     
  <div class="form-inr">
	<div class="form-group label-floating">
		<label class="forgtpaswrd">Enter your Email Address, and we’ll send you a 
password reset link on email.</label>
		
	</div>



	<div class="form-group label-floating">
		<label class="control-label">name@example.com</label>
		<input type="text"  name="data[User][username]" class="form-control">
	</div>

      </div>
    </div>
   
    
    <div class="col-sm-12">
    <div class="row">
    <div class="reser_btn">
   <input type="submit" class="btn defult_btn" name="submit" value="SEND EMAIL">
       </div> 
     </div>  
    </div>
    </div>
   <?php $this->Form->end(); ?>
      	
      </div>
      </div>
    </div>
  </div>  