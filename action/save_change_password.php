<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	$insert = new Insert();
	$update = new Update();
	$select = new Select();
	$alert = "";
	$message = "";
	$response = array();
	$ipAddress = $generate->ip_address();
	$oldPassword = $function->post("txt_old_password");
	$newPassword = $function->post("txt_new_password");
	$confirmNewPassword = $function->post("txt_confirm_password");
	$page = "login.php?action=change_password";
	$response = array();
	$sessionArray = array();
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
		$usersDetails = $select->get_user_details(ID);
		if(empty($usersDetails)){
			$alert = "danger";
			$message = "New Users Details Found: ";
			$message .= "USER_ID: ".ID;
		}
	}
	
	if($alert == ""){
		$savedOldPassword = $usersDetails["users_password"];
		$userFirstName = $usersDetails["first_name"];
		$userLastName = $usersDetails["last_name"];
		$userFullName = $usersDetails["full_name"];
		$userLoginType = $usersDetails["login_type_id"];
		$userType = $usersDetails["users_type_id"];
		$userPicture = $usersDetails["users_picture"];
		if($savedOldPassword != $oldPassword){
			$alert = "danger";
			$message = "Old Password is not equal to Saved Password<br>";
			//$message .= "Old Password:".$oldPassword."<br>";
			//$message .= "Save Old Password: ".$savedOldPassword;
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
			"remarks" => "Set New Password", 
			"date_updated" => date("Y-m-d H:i:s")
		);
		$updateUsersLogin = $update->users_login($updateData, $updateCondition);
		if(!is_numeric($updateUsersLogin)){
			$alert = "danger";
			$message = "Error in inactivating recent password: <br>";
			$message .= $updateUsersLogin;
		}
	}
	
	if($alert == ""){
		$insertData = array(
			"users_id" => ID, 
			"login_type_id" => $userLoginType, 
			"users_password" => $confirmNewPassword, 
			"password_status" => "active", 
			"password_remarks" => "Set New Password", 
			"ip_address" => $ipAddress, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertUsersLogin = $insert->users_login($insertData);
		if(!is_numeric($insertUsersLogin)){
			$alert = "danger";
			$message = "Error in inserting new password: <br>";
			$message .= $insertUsersLogin;
		}
	}
	
	if($alert == ""){
		$usersData = array(
			"users_status" => "active",
			"date_updated" => date("Y-m-d H:i:s"), 
			"updated_by" => ID
		);
		
		$usersCondition = array(
			"users_id" => ID
		);
		
		$updateUsers = $update->users($usersData, $usersCondition);
		if(!is_numeric($updateUsersLogin)){
			$alert = "danger";
			$message = "Error in updating users status: <br>";
			$message .= $updateUsersLogin;
		}
	}
	
	if($alert == ""){
		$page = "dashboard.php";
		$sessionArray = array(
			"first_name" => $userFirstName, 
			"last_name" => $userLastName, 
			"full_name" => $userFullName, 
			"profile_picture" => $userPicture, 
			"login_type" => $userLoginType, 
			"user_type" => $userType
		);
		$alert = "success";
		$message = "Welcome to your Dashboard ".$userFullName;
	}
	
	if(!empty($sessionArray)){
		$_SESSION[PROJECT]["user"] += $sessionArray;
		$_SESSION[PROJECT]["user"]["logged_id"] = 1;
	}
	$response = array(
		"output" => $alert, 
		"message" => $message
	);
	
	echo json_encode($response);
	//$redirect = base_url("pages/display/".$page);
	//$function->flash_message($alert, $message, $redirect);
	
?>