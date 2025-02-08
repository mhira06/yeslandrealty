<form 
	class="login100-form validate-form" 
	name = "frm_login"
	id = "frm_login" 
	method = "POST" 
	action = "<?php echo base_url("action/authenticate_user.php"); ?>" 
	autocomplete = "off">
<?php
	echo $function->display_flash();
?>
	<span class="login100-form-title">YLR Login</span>
	<div class="wrap-input100 validate-input" data-validate = "Invalid Username">
		<input class="input100" type="text" name="txt_username" id = "txt_username" placeholder="Username">
		<span class="focus-input100"></span>
		<span class="symbol-input100">
			<i class="fa fa-envelope" aria-hidden="true"></i>
		</span>
	</div>
	<div class="wrap-input100 validate-input" data-validate = "Password is required">
		<input class="input100" type="password" name="txt_password" id = "txt_password" placeholder="Password">
		<span class="focus-input100"></span>
		<span class="symbol-input100">
			<i class="fa fa-lock" aria-hidden="true"></i>
		</span>
	</div>
	
	<div class="container-login100-form-btn">
		<button type = "submit" class="login100-form-btn"> Login </button>
	</div>
</form>