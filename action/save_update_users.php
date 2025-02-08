<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	$insert = new Insert();
	$update = new Update();
	$select= new Select();
	$delete = new Delete_data();
	$alert = "";
	$message = "";
	$selectedUsersId = $function->post("hdn_users_id");
	$selectedUsersNumber = $function->post("hdn_users_number");
	$selectedFirstName = $function->post("txt_users_first_name");
	$selectedMiddleName = $function->post("txt_users_middle_name");
	$selectedLastName = $function->post("txt_users_last_name");
	$selectedSuffix = $function->post("txt_users_suffix");
	$selectedBday = $function->post("txt_users_birthday");
	$selectedDateHired = $function->post("txt_users_date_hired");
	$selectedUserType = $function->post("hdn_user_type");
	$selectedPosition = $function->post("slt_users_position");
	$savedUserDetails = $select->get_user_details($selectedUsersId);
	$savedLoginType = $savedUserDetails["login_type_id"];
	$userTypeDetails = $select->get_user_type($selectedUserType);
	$selectUserTypeDesc = $userTypeDetails["users_type_desc"];
	$selectedPicture = $function->post("hdn_users_picture");
	$uploadFolder = "assets/uploads/images";
	if(isset($_FILES["fle_users_picture"]["tmp_name"]) && $_FILES["fle_users_picture"]["tmp_name"] != ""){
		$uploadPicture = $uploadFolder."/users_picture/".$selectUserTypeDesc;
		$fileName = $_FILES["fle_users_picture"]["name"];
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		$uploadName = $selectedUsersNumberDisplay."_picture.".$fileExtension;
		$tmpFile = $_FILES["fle_users_picture"]["tmp_name"];
		$selectedPicture = $uploadPicture."/".$uploadName;
		$uploadFullPath = root_url($selectedPicture);
		if(!move_uploaded_file($tmpFile, $uploadFullPath)){
			$alert = "error";
			$message = "Error in uploading Image";
		}
	}
	$selectedSignature = $function->post("hdn_users_signature");
	if(isset($_FILES["fle_users_signature"]["tmp_name"]) && $_FILES["fle_users_signature"]["tmp_name"] != ""){
		$uploadSignature = $uploadFolder."/users_signature/".$selectUserTypeDesc;
		$fileName = $_FILES["fle_users_signature"]["name"];
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
		$uploadName = $selectedUsersNumberDisplay."_signature.".$fileExtension;
		$tmpFile = $_FILES["fle_users_signature"]["tmp_name"];
		$selectedSignature = $uploadSignature."/".$uploadName;
		$uploadFullPath = root_url($selectedSignature);
		if(!move_uploaded_file($tmpFile, $uploadFullPath)){
			$alert = "error";
			$message = "Error in uploading Signature";
		}
	}
	
	if($alert == ""){
		$usersData = array(
			"first_name" => $selectedFirstName, 
			"middle_name" => $selectedMiddleName, 
			"last_name" => $selectedLastName, 
			"second_name" => $selectedSuffix, 
			"birthday" => $selectedBday, 
			"date_hire" => $selectedDateHired, 
			"users_picture" => $selectedPicture, 
			"users_signature" => $selectedSignature, 
			"date_updated" => date("Y-m-d H:i:s"), 
			"updated_by" => ID
		);
		$usersCondition = array(
			"users_id" => $selectedUsersId
		);
		$updateUsers = $update->users($usersData, $usersCondition);
		if(!is_numeric($updateUsers)){
			$alert = "error";
			$message = "Error in updating users <br>";
			$message .= "Error: ".$updateUsers;
		}
	}
	
	if($alert == ""){
		$selectedPassword = $function->post("txt_users_password");
		$selectedLoginType = $function->post("slt_users_login_type");
		$usersLoginData = array();
		if($savedLoginType != $selectedLoginType){
			$usersLoginData += array(
				"login_type_id" => $selectedLoginType
			);
		}
		
		if($selectedPassword != ""){
			$deleteUsersLoginCondition = array(
				"users_id" => $selectedUsersId, 
				"status" => "active", 
				"password_status" => "active"
			);
			$deleteUsersLogin = $delete->users_login($deleteUsersLoginCondition, ID, "change_by_admin");
			if(!is_numeric($deleteUsersLogin)){
				$alert = "error";
				$message = "Error in deleting existing password: <br>";
				$message .= "Error: ".$deleteUsersLogin;
			}
			
			if($alert == ""){
				$usersLoginData += array(
					"users_password" => $selectedPassword
				);
			}
		}
		
		if(!empty($usersLoginData)){
			$usersLoginData = array(
				"users_id" => $selectedUsersId, 
				"login_type_id" => $selectedLoginType, 
				"users_password" => $selectedPassword, 
				"password_status" => "active", 
				"password_remarks" => "add_by_admin", 
				"date_added" => date("Y-m-d H:i:s"), 
				"added_by" => ID
			);
			$insertUsersLogin = $insert->users_login($usersLoginData);
			if(!is_numeric($insertUsersLogin)){
				$alert = "error";
				$message = "Error in inserting users login: <br>";
				$message .= "Error: ".$insertUsersLogin;
			}
		}
	}
	
	if($alert == ""){
		$deleteUsersContactNumberCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersContactNumber = $delete->users_contact_number($deleteUsersContactNumberCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersContactNumber)){
			$alert = "error";
			$message = "Error in deleting existing users contact number: <br>";
			$message .= "Error: ".$deleteUsersContactNumber;
		}
	}
	
	if($alert == ""){
		$usersContactNumberData = array();
		$contactNumberList = $select->get_active_contact_numbers_list();
		if(!empty($contactNumberList)){
			foreach($contactNumberList as $cnRows){
				$contactCode = $cnRows["contact_number_type_code"];
				$contactNumberValue = $function->post("txt_users_".$contactCode."_number");
				if($contactNumberValue != ""){
					$usersContactNumberData[] = array(
						"users_id" => $selectedUsersId, 
						"contact_number_type_id" => $cnRows["contact_number_type_id"], 
						"contact_number_value" => $contactNumberValue, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transaction_status" => "active", 
						"transact_by" => ID, 
						"transaction_remarks" => "add_by_admin", 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		
		if(!empty($usersContactNumberData)){
			$insertUsersContactNumber = $insert->users_contact_number($usersContactNumberData);
			if(!is_numeric($insertUsersContactNumber)){
				$alert = "error";
				$message = "Error in inserting users contact number: <br>";
				$message .= "Error: ".$insertUsersContactNumber;
			}
		}
	}
	
	if($alert == ""){
		$deleteUsersAddressCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersAddress = $delete->users_address($deleteUsersAddressCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersAddress)){
			$alert = "error";
			$message = "Error in deleting existing users address: <br>";
			$message .= "Error: ".$deleteUsersAddress;
		}
	}
	
	if($alert == ""){
		$usersAddressData = array();
		$addressList = $select->get_active_address_list();
		if(!empty($addressList)){
			foreach($addressList as $adRows){
				$addressCode = $adRows["address_type_code"];
				$number = $function->post("txt_users_number_".$addressCode."_address");
				$street = $function->post("txt_users_street_".$addressCode."_address");
				$barangay = $function->post("txt_users_barangay_".$addressCode."_address");
				$city = $function->post("txt_users_city_".$addressCode."_address");
				$zipCode = $function->post("txt_users_zip_code_".$addressCode."_address");
				$province = $function->post("txt_users_province_".$addressCode."_address");
				$country = $function->post("txt_users_country_".$addressCode."_address");
				if($barangay != "" && $city != "" && $zipCode != "" && $province != "" && $country != ""){
					$usersAddressData[] = array(
						"users_id" => $selectedUsersId, 
						"address_type_id" => $adRows["address_type_id"], 
						"number" => $number, 
						"street" => $street, 
						"barangay" => $barangay, 
						"city" => $city, 
						"zip_code" => $zipCode, 
						"province" => $province, 
						"country" => $country, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transaction_status" => "active", 
						"transaction_remarks" => "add_by_admin", 
						"transact_by" => ID, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		
		if(!empty($usersAddressData)){
			$insertUsersAddress = $insert->users_address($usersAddressData);
			if(!is_numeric($insertUsersAddress)){
				$alert = "error";
				$message = "Error in inserting users address: <br>";
				$message .= "Error: ".$insertUsersAddress;
			}
		}
	}
	
	if($alert == ""){
		$deleteUsersIdentificationCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersIdentification = $delete->users_identification($deleteUsersIdentificationCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersIdentification)){
			$alert = "error";
			$message = "Error in deleting existing users identification: <br>";
			$message .= "Error: ".$deleteUsersIdentification;
		}
	}
	
	if($alert == ""){
		$usersIdData = array();
		$governmentIdList = $select->get_active_government_id();
		if(!empty($governmentIdList)){
			foreach($governmentIdList as $govRows){
				$govIdCode = $govRows["identification_code"];
				$govIdValue = $function->post("txt_users_".$govIdCode."_number");
				if($govIdValue != ""){
					$usersIdData[] = array(
						"users_id" => $selectedUsersId, 
						"identification_id" => $govRows["identification_id"], 
						"id_value" => $govIdValue, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transact_by" => ID, 
						"transaction_remark" => "add_by_admin", 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		$professionalIdList = $select->get_active_professional_id();
		if(!empty($professionalIdList)){
			foreach($professionalIdList as $proRows){
				$proIdCode = $proRows["identification_code"];
				$proIdValue = $function->post("txt_users_".$proIdCode."_number");
				if($proIdValue != ""){
					$usersIdData[] = array(
						"users_id" => $selectedUsersId, 
						"identification_id" => $proRows["identification_id"], 
						"id_value" => $proIdValue, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transact_by" => ID, 
						"transaction_remark" => "add_by_admin", 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		
		if(!empty($usersIdData)){
			$insertUsersIdentification = $insert->users_identification($usersIdData);
			if(!is_numeric($insertUsersIdentification)){
				$alert = "error";
				$message = "Error in inserting users identification: <br>";
				$message .= "Error: ".$insertUsersIdentification;
			}
		}
	}
	
	if($alert == ""){
		$deleteUsersPositionCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersPosition = $delete->users_position($deleteUsersPositionCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersPosition)){
			$alert = "error";
			$message = "Error in deleting existing users position: <br>";
			$message .= "Error: ".$deleteUsersPosition;
		}
	}
	
	if($alert == ""){
		$usersPositionData = array(
			"users_id" => $selectedUsersId, 
			"positions_id" => $selectedPosition, 
			"transaction_remarks" => "add_by_admin", 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertUsersPosition = $insert->users_position($usersPositionData);
		if(!is_numeric($insertUsersPosition)){
			$alert = "error";
			$message = "Error in inserting users position: <br>";
			$message .= "Error: ".$insertUsersPosition;
		}
	}
	
	if($alert == ""){
		$deleteUsersStatusCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersStatus = $delete->users_status($deleteUsersStatusCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersStatus)){
			$alert = "error";
			$message = "Error in deleting existing users status: <br>";
			$message .= "Error: ".$deleteUsersStatus;
		}
	}
	
	if($alert == ""){
		$selectedStatus = $function->post("slt_users_status");
		$usersStatusData = array(
			"users_id" => $selectedUsersId, 
			"users_type_status_id" => $selectedStatus, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transaction_remarks" => "add_by_admin", 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertUsersStatus = $insert->users_status($usersStatusData);
		if(!is_numeric($insertUsersStatus)){
			$alert = "error";
			$message = "Error in inserting users status: <br>";
			$message .= "Error: ".$insertUsersStatus;
		}
	}
	
	if($alert == ""){
		$deleteUsersRateCondition = array(
			"users_id" => $selectedUsersId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteUsersRate = $delete->users_rate($deleteUsersRateCondition, ID, "change_by_admin");
		if(!is_numeric($deleteUsersRate)){
			$alert = "error";
			$message = "Error in deleting existing users rate: <br>";
			$message .= "Error: ".$deleteUsersRate;
		}
	}
	
	if($alert == ""){
		if($selectedUserType == "1"){
			$selectedRatedType = $function->post("slt_users_rate_type");
			$selectedRateValue = $function->post("txt_users_rate_value");
			$usersRateData = array(
				"users_id" => $selectedUsersId, 
				"rate_type_id" => $selectedRatedType, 
				"rate_value" => $selectedRateValue, 
				"transact_by" => ID, 
				"date_transaction" => date("Y-m-d H:i:s"), 
				"date_added" => date("Y-m-d H:i:s"), 
				"added_by" => ID
			);
			
			$insertUsersRate = $insert->users_rate($usersRateData);
			if(!is_numeric($insertUsersRate)){
				$alert = "error";
				$message = "Error in inserting users rate: <br>";
				$message .= "Error: ".$insertUsersRate;
			}
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Update Saved";
	}
	
	$redirect = base_url("pages/maintenance/users.php?action=edit&id=".$selectedUsersId);
	$function->flash_message($alert, $message, $redirect);
?>