<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	$insert = new Insert();
	$update = new Update();
	$select = new Select();
	$delete = new Delete_data();
	
	$alert = "";
	$message = "";
	$response = "";
	
	$selectedClientsFirstName = $function->post("txt_clients_first_name");
	$selectedClientsMiddleName = $function->post("txt_clients_middle_name");
	$selectedClientsLastName = $function->post("txt_clients_last_name");
	
	if($selectedClientsFirstName == ""){
		$alert = "error";
		$message = "First Name is required";
	}
	
	if($alert == ""){
		if($selectedClientsLastName == ""){
			$alert = "error";
			$message = "Last Name is required";
		}
	}
	
	if($alert == ""){
		$clientsData = array(
			"first_name" => $selectedClientsFirstName, 
			"middle_name" => $selectedClientsMiddleName, 
			"last_name" => $selectedClientsLastName, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertClients = $insert->clients($clientsData);
		if(!is_numeric($insertClients)){
			$alert = "error";
			$message = "Error in inserting new clients";
			$message .= "Error: ".$insertClients;
		}
	}
	
	if($alert == ""){
		$clientsContactNumberData = array();
		$contactNumberList = $select->get_active_contact_numbers_list();
		if(!empty($contactNumberList)){
			foreach($contactNumberList as $cnRows){
				$contactCode = $cnRows["contact_number_type_code"];
				$contactNumberValue = $function->post("txt_clients_".$contactCode."_number");
				if($contactNumberValue != ""){
					$clientsContactNumberData[] = array(
						"clients_id" => $insertClients, 
						"contact_number_type_id" => $cnRows["contact_number_type_id"], 
						"contact_number_value" => $contactNumberValue, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transaction_status" => "active", 
						"transact_by" => ID, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		
		if(!empty($clientsContactNumberData)){
			$insertClientsNumber = $insert->clients_contact_number($clientsContactNumberData);
			if(!is_numeric($insertClientsNumber)){
				$alert = "error";
				$message = "Error in inserting clients contact number: <br>";
				$message .= "Error: ".$insertClientsNumber;
			}
		}
	}
	
	if($alert == ""){
		$clientsAddressData = array();
		$addressList = $select->get_active_address_list();
		if(!empty($addressList)){
			foreach($addressList as $adRows){
				$addressCode = $adRows["address_type_code"];
				$number = $function->post("txt_clients_number_".$addressCode."_address");
				$street = $function->post("txt_clients_street_".$addressCode."_address");
				$barangay = $function->post("txt_clients_barangay_".$addressCode."_address");
				$city = $function->post("txt_clients_city_".$addressCode."_address");
				$zipCode = $function->post("txt_clients_zip_code_".$addressCode."_address");
				$province = $function->post("txt_clients_province_".$addressCode."_address");
				$country = $function->post("txt_clients_country_".$addressCode."_address");
				if($barangay != "" && $city != "" && $zipCode != "" && $province != "" && $country != ""){
					$clientsAddressData[] = array(
						"clients_id" => $insertClients, 
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
						"transact_by" => ID, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		
		if(!empty($clientsAddressData)){
			$insertClientsAddress = $insert->clients_address($clientsAddressData);
			if(!is_numeric($insertClientsAddress)){
				$alert = "error";
				$message = "Error in inserting clients address: <br>";
				$message .= "Error: ".$insertClientsAddress;
			}
		}
		
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: New Clients Saved";
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
	
?>