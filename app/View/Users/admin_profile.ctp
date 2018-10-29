<div class="contact_us">
    
            <h2>EDIT PROFILE</h2>
	
		<?php print_r($data);?>
		
		
	   
	  <form action="<?php echo $this->webroot."admin/users/profile"; ?>" id="editform" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="PUT"></div>      
      <div class="editfrm">
      <div class="col-sm-3"><label for="last_name">Full Name </label></div>
       <div class="col-sm-9">  <input type="text" name="data[User][name]" value="<?php echo $data['User']['name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
      </div> 
      
        <div class="editfrm">
         <div class="col-sm-3">  <label for="last_name">First Name</label></div>
       <div class="col-sm-9">   <input type="text" name="data[User][first_name]" value="<?php echo $data['User']['first_name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="last_name">Last Name </label></div>
       <div class="col-sm-9">   <input type="text" name="data[User][last_name]" value="<?php echo $data['User']['last_name']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="email">Email Address </label></div>
       <div class="col-sm-9">  <input name="data[User][email]" value="<?php echo $data['User']['email']; ?>" type="text" maxlength="80" size="30"></div>
       </div>
       
        <div class="editfrm">
        <div class="col-sm-3"><label for="first_name">Address </label></div>
       <div class="col-sm-9">  <input type="text" name="data[User][address]" value="<?php echo $data['User']['address']; ?>" maxlength="50" size="30" required="required"></div>
       </div>
       
        <div class="editfrm">
        <div class="col-sm-3">  <label for="last_name">City </label></div>
       <div class="col-sm-9">  <input type="text" name="data[User][city]" value="<?php echo $data['User']['city']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="email">State</label></div>
       <div class="col-sm-9">  <input type="text" name="data[User][state]" value="<?php echo $data['User']['state']; ?>" maxlength="80" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
         <div class="col-sm-3"><label for="first_name">Country</label></div>
       <div class="col-sm-9">   <input type="text" name="data[User][country]" value="<?php echo $data['User']['country']; ?>" maxlength="50" size="30" required="required" pattern="[A-Za-z\s]+" title="Alphbets Only"></div>
       </div>
       
        <div class="editfrm">
          <div class="col-sm-3"><label for="last_name">Zip</label></div>
       <div class="col-sm-9"> <input type="number" name="data[User][zip]" value="<?php echo $data['User']['zip']; ?>" maxlength="50" size="30" required="required"></div>
       </div>
       
       
        <div class="editfrm">
          <div class="col-sm-3"><label for="email">Phone</label></div>
       <div class="col-sm-9"> <input type="number" name="data[User][phone]" value="<?php echo $data['User']['phone']; ?>" maxlength="80" size="30" required="required"></div>
       </div>
       
       <div class="editfrm">  
       <div class="col-sm-12"> <button type="submit" name="submit" class="btn defult_btn contact_us1">SUBMIT</button></div>
       </div>
      

</form>	
		</div>