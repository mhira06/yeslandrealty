<?php
	include("../classes/functions.php");
	$function = new Functions();
	$select = new Select();
	$alert = "";
	$message = "";
	$sessionArray = array();
	$userName = $function->post("txt_username");
	$passWord = $function->post("txt_password");
	$page = "login.php";
	if($userName == ""){
		$alert = "error";
		$message = "No Username Found.";
	}
	if($alert == ""){
		if($passWord == ""){
			$alert = "error";
			$message = "No Password Found";
		}
	}
	if($alert == ""){
		$userLogin = $select->users_login($userName, $passWord);
		if(empty($userLogin)){
			$alert = "error";
			$message= "No User Found.";
		}
		//$function->echo_array($userLogin);
		
	}
	if($alert == ""){
		$userId = $userLogin["users_id"];
		$userNumber = $userLogin["users_number"];
		$userNumberDisplay = $userLogin["users_number_display"];
		$userFirstName = $userLogin["first_name"];
		$userLastName = $userLogin["last_name"];
		$userFullName = $userLogin["full_name"];
		$userLoginType = $userLogin["login_type_id"];
		$userType = $userLogin["users_type_id"];
		$userPicture = $userLogin["users_picture"];
		$usersStatus = $userLogin["users_status"];
		if($userLoginType == ""){
			$alert = "error";
			$message = "No Login Type Detected";
		}
	}
	
	if($alert == ""){
		if($userType == ""){
			$alert = "error";
			$message = "No User Type Detected.";
		}
	}
	
	if($alert == ""){
		if($usersStatus == "Pending"){
			$alert = "warning";
			$message = "Please change your password";
			$page .= "?action=change_password";
			$sessionArray = array(
				"id" => $userId, 
				"number" => $userNumber, 
				"number_display" => $userNumberDisplay, 
				"logged_id" => 0
			);
		}
	}
	if($alert == ""){
		$page = "dashboard.php";
		$sessionArray = array(
			"id" => $userId, 
			"number" => $userNumber, 
			"number_display" => $userNumberDisplay, 
			"first_name" => $userFirstName, 
			"last_name" => $userLastName, 
			"full_name" => $userFullName, 
			"profile_picture" => $userPicture, 
			"login_type" => $userLoginType, 
			"user_type" => $userType, 
			"logged_id" => 1
		);
		$alert = "success";
		$message = "Welcome to your Dashboard ".$userFullName;
	}
	if(!empty($sessionArray)){
		$_SESSION[PROJECT]["user"] = $sessionArray;
	}
	$redirect = base_url("pages/display/".$page);
	$function->flash_message($alert, $message, $redirect);
	
?>