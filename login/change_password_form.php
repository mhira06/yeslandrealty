<form 
	class="login100-form validate-form" 
	name = "frm_change_password"
	id = "frm_change_password" 
	method = "POST" 
	action = "<?php echo base_url("action/save_change_password.php"); ?>" 
	autocomplete = "off">

	<div id = "div_result"><?php
		echo $function->display_flash();
		//$function->echo_array($_SESSION);
	?></div>
	<input type = "hidden" name = "hdn_change_password_source" id = "hdn_change_password_source" value = "login">
	<span class="login100-form-title">YLR Change Password</span>
	<div class="wrap-input100 validate-input" data-validate = "Password is required">
		<input class="input100" type="password" name="txt_old_password" id = "txt_old_password" placeholder="Old Password">
		<span class="focus-input100"></span>
		<span class="symbol-input100">
			<i class="fa fa-lock" aria-hidden="true"></i>
		</span>
	</div>
	<div class="wrap-input100 validate-input" data-validate = "Password is required">
		<input class="input100" type="password" name="txt_new_password" id = "txt_new_password" placeholder="New Password">
		<span class="focus-input100"></span>
		<span class="symbol-input100">
			<i class="fa fa-lock" aria-hidden="true"></i>
		</span>
	</div>
	<div class="wrap-input100 validate-input" data-validate = "Password is required">
		<input class="input100" type="password" name="txt_confirm_password" id = "txt_confirm_password" placeholder="Confirm Password">
		<span class="focus-input100"></span>
		<span class="symbol-input100">
			<i class="fa fa-lock" aria-hidden="true"></i>
		</span>
	</div>
	
	<div class="container-login100-form-btn">
		<button type = "submit" class="login100-form-btn"> Save </button>
	</div>
</form>