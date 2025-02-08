<?php
	$formAction = $action == "add" ? "save_users" : "save_update_users";
	$selectedId = $function->get("id");
	$usersDetails = $selectedId != "" ? $select->get_user_details($selectedId) : array();
	//$function->echo_array($usersDetails);
	$selectedFirstName = isset($usersDetails["first_name"]) ? $usersDetails["first_name"] : "";
	$selectedLastName = isset($usersDetails["last_name"]) ? $usersDetails["last_name"] : "";
	$selectedMiddleName = isset($usersDetails["middle_name"]) ? $usersDetails["middle_name"] : "";
	$selectedSuffix = isset($usersDetails["second_name"]) ? $usersDetails["second_name"] : "";
	$selectedBirthday = isset($usersDetails["birthday"]) ? $usersDetails["birthday"] : "";
	$selectedAge = isset($usersDetails["age"]) ? $usersDetails["age"] : "";
	$selectedPicture = isset($usersDetails["users_picture"]) ? $usersDetails["users_picture"] : "";
	$selectedSignature = isset($usersDetails["users_signature"]) ? $usersDetails["users_signature"] : "";
	$selectedUserType = isset($usersDetails["users_type_id"]) ? $usersDetails["users_type_id"] : "";
	$selectedUserNumber = isset($usersDetails["users_number"]) ? $usersDetails["users_number"] : "";
	$selectedUserNumberDisplay = isset($usersDetails["users_number_display"]) ? $usersDetails["users_number_display"] : "";
	$selectedUserStatus = isset($usersDetails["users_type_status_id"]) ? $usersDetails["users_type_status_id"] : "";
	$selectedPosition = isset($usersDetails["positions_id"]) ? $usersDetails["positions_id"] : "";
	$selectedDateHired = isset($usersDetails["date_hire"]) ? $usersDetails["date_hire"] : "";
	$selectedRateType = isset($usersDetails["rate_type_id"]) ? $usersDetails["rate_type_id"] : "";
	$selectedRateValue = isset($usersDetails["rate_value"]) ? $usersDetails["rate_value"] : "";
	$selectedLoginType = isset($usersDetails["login_type_id"]) ? $usersDetails["login_type_id"] : "";
	
?>
<div class = "card card-primary card-outline">
	<div class = "card-header">
		<h3 class = "card-title">Registration Form</h3>
		<div class = "card-tools">
			<a href = "<?php echo base_url("pages/maintenance/users.php");?>" class = "btn btn-flat btn-danger">Back</a>
		</div>
	</div>
	<form 
		name = "frm_users" 
		id = "frm_users" 
		method = "POST" 
		enctype="multipart/form-data"
		action = "<?php echo base_url("action/".$formAction.".php")?>"
		autocomplete = "off">
		<input 
			type = "hidden" 
			name = "hdn_users_id" 
			id = "hdn_users_id" 
			value = "<?php echo $selectedId; ?>">
		<input 
			type = "hidden" 
			name = "hdn_action" 
			id = "hdn_action" 
			value = "<?php echo $action; ?>">
		<div class = "card-body">
		<?php
			$function->display_flash();
			$usersPersonalPage = root_url("pages/includes/maintenance/users/users_personal_details.php");
			include($usersPersonalPage);
			
			$usersContactNumber = root_url("pages/includes/maintenance/users/users_contact_number.php");
			include($usersContactNumber);
			
			$usersAddress = root_url("pages/includes/maintenance/users/users_address.php");
			include($usersAddress);
		?>
			<hr>
		<?php
			$usersIdentification = root_url("pages/includes/maintenance/users/users_identification.php");
			include($usersIdentification);
		?>
			<hr>
		<?php
			$usersCompanyInfo = root_url("pages/includes/maintenance/users/users_company_info.php");
			include($usersCompanyInfo);
		?>
			<hr>
		<?php
			$usersCredentials = root_url("pages/includes/maintenance/users/users_credentials.php");
			include($usersCredentials);
		?>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_save" 
				class = "btn btn-flat btn-success">Save</button>
		</div>
	</form>
</div>