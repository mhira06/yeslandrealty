<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	$insert = new Insert();
	$update = new Update();
	$alert = "";
	$message = "";
	$response = array();
	$ipAddress = $generate->ip_address();
	$logintType = isset($sessionUser["login_type"]) ? $sessionUser["login_type"] : "";
	$oldPassword = $function->post("txt_old_password");
	$newPassword = $function->post("txt_new_password");
	$confirmNewPassword = $function->post("txt_confirm_password");
	if($oldPassword == ""){
		$alert = "danger";
		$message = "No Old Password Detected.";
	}
	
	if($alert == ""){
		if($newPassword == ""){
			$alert = "danger";
			$message = "No New Password Detected";
		}
	}
	
	if($alert == ""){
		if($confirmNewPassword == ""){
			$alert = "danger";
			$message = "No New Passoword Detected";
		}
	}
	
	if($alert == ""){
		if($confirmNewPassword != $newPassword){
			$alert = "danger";
			$message = "New password is not confirm";
		}
	}
	if($alert == ""){
		$updateCondition = array(
			"users_id" => ID, 
			"password_status" => "active", 
			"status" => "active"
		);
		$updateData = array(
			"password_status" => "inactive", 
			"remarks" => "Due to update", 
			"date_updated" => date("Y-m-d H:i:s")
		);
		$updateUsersLogin = $update->users_login($updateData, $updateCondition);
		if(!is_numeric($updateUsersLogin)){
			$alert = "error";
			$message = "Error in inactivating recent password: <br>";
			$message .= $updateUsersLogin;
		}
	}
	
	if($alert == ""){
		$insertData = array(
			"users_id" => ID, 
			"login_type_id" => $logintType, 
			"users_password" => $confirmNewPassword, 
			"password_status" => "active", 
			"password_remarks" => "Set in change password", 
			"ip_address" => $ipAddress, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertUsersLogin = $insert->users_login($insertData);
		if(!is_numeric($insertUsersLogin)){
			$alert = "error";
			$message = "Error in inserting new password: <br>";
			$message .= $insertUsersLogin;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Change Passsword Complete: ";
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message
	);
	
	echo json_encode($response);
?>