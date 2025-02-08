<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	$insert = new Insert();
	$update = new Update();
	$select= new Select();
	$delete = new Delete_data();
	if(ID == ""){
		redirect();
	}
	$selectedUsersId = ID;
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
						"transaction_remarks" => "update_by_user", 
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
						"transaction_remarks" => "update_by_user", 
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
		$alert = "success";
		$message = "Transaction Done: Update Saved";
	}
	
	$redirect = base_url("pages/display/profile.php");
	$function->flash_message($alert, $message, $redirect);
	