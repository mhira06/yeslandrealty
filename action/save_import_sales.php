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
	$response = array();
	if(isset($_FILES["fle_import_files"]["name"]) && $_FILES["fle_import_files"]["name"] == ""){
		$alert = "error";
		$message = "Please select a file";
	}
	
	if($alert == ""){
		$uploadPath = "assets/uploads/documents/sales";
		$uploadName = $uploadPath."/".$_FILES["fle_import_files"]["name"];
		$uploadFullPath = root_url($uploadName);
		if(!move_uploaded_file($_FILES["fle_import_files"]["tmp_name"], $uploadFullPath)){
			$alert = "error";
			$message .= "Error in uploading File ";
		}
	}
	
	if($alert == ""){
		$loadPhpExcel = root_url("libraries/php_excel/PHPExcel.php");
		include($loadPhpExcel);
		
		$inputFileType = PHPExcel_IOFactory::identify($uploadFullPath);
		$phpExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
		$phpExcelReader->setReadDataOnly(true);
		
		$objPHPExcel = $phpExcelReader->load($uploadFullPath);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		$highestRow = $objWorksheet->getHighestRow();
		$excelData = array();
		for ($row = 1; $row <= $highestRow; $row++){ 
			$startValue = ($row + 2);
			//$cell = "A".$documentCodeRow;
			$clientsFirstName = $objWorksheet->getCell("A".$startValue)->getValue();
			$clientsMiddleName = $objWorksheet->getCell("B".$startValue)->getValue();
			$clientsLastName = $objWorksheet->getCell("C".$startValue)->getValue();
			$projectName = $objWorksheet->getCell("D".$startValue)->getValue();
			$location = $objWorksheet->getCell("E".$startValue)->getValue();
			$dateReserve = $objWorksheet->getCell("F".$startValue)->getValue();
			$netPrice = $objWorksheet->getCell("G".$startValue)->getValue();
			$quantity = $objWorksheet->getCell("H".$startValue)->getValue();
			$salesFirstName = $objWorksheet->getCell("I".$startValue)->getValue();
			$salesMiddleName = $objWorksheet->getCell("J".$startValue)->getValue();
			$salesLastName = $objWorksheet->getCell("K".$startValue)->getValue();
			$dateReserveValue = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dateReserve));
			if($clientsFirstName != ""){
				$excelData[] = array(
					"clients_first_name" => $clientsFirstName, 
					"clients_middle_name" => $clientsMiddleName, 
					"clients_last_name" => $clientsLastName, 
					"project_name" => $projectName, 
					"location" => $location, 
					"date_reserve" => $dateReserveValue, 
					"net_price" => $netPrice, 
					"quantity" => $quantity, 
					"sales_first_name" => $salesFirstName, 
					"sales_middle_name" => $salesMiddleName, 
					"sales_last_name" => $salesLastName
				);
			}
			
		}
	}
	
	if($alert == ""){
		if(empty($excelData)){
			$alert = "error";
			$message = "No Data to upload. Please change the file";
		}
	}
	
	if($alert == ""){
		$salesHistoryData = array();
		$count = 1;
		foreach($excelData as $eRows){
			$clientsId = "";
			$usersId = "";
			$clientsFirstName = $eRows["clients_first_name"];
			$clientsMiddleName = $eRows["clients_middle_name"];
			$clientsLastName = $eRows["clients_last_name"];
			$clientsCondition = "first_name = '".$clientsFirstName."' 
								and middle_name = '".$clientsMiddleName."' 
								and last_name = '".$clientsLastName."'";
			$clientsDetails = $select->get_active_clients_details("", $clientsCondition);
			$clientsId = isset($clientsDetails["clients_id"]) ? $clientsDetails["clients_id"] : "";
			if($clientsId == ""){
				$clientsData = array(
					"first_name" => $clientsFirstName, 
					"middle_name" => $clientsMiddleName, 
					"last_name" => $clientsLastName, 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID, 
					"remarks" => "from_import"
				);
				$insertClients = $insert->clients($clientsData);
				if(!is_numeric($insertClients)){
					$alert = "error";
					$message = "Error in inserting new clients";
					$message .= " at ".$count;
					$message .= "Error: ".$insertClients;
				}
				else{
					$clientsId = $insertClients;
				}
			}
			
			if($alert == ""){
				$salesFirstName = $eRows["sales_first_name"];
				$salesMiddleName = $eRows["sales_middle_name"];
				$salesLastName = $eRows["sales_last_name"];
				$usersCondition = "ut.users_type_id = '2' 
									and u.first_name = '".$salesFirstName."' 
									and u.middle_name = '".$salesMiddleName."' 
									and u.last_name = '".$salesLastName."'";
				$usersDetails = $select->get_active_users_details("", $usersCondition);
				$usersId = isset($usersDetails["users_id"]) ? $usersDetails["users_id"] : "";
				if($usersId == ""){
					$usersNumber = $function->get_users_number(2);
					$selectedUsersNumber = $usersNumber["value"];
					$selectedUsersNumberDisplay = $usersNumber["display"];
					$selectedUsersType = $usersNumber["users_type"];
					
					$usersData = array(
						"users_number" => $selectedUsersNumber, 
						"first_name" => $salesFirstName, 
						"middle_name" => $salesMiddleName, 
						"last_name" => $salesLastName, 
						"users_status" => "pending", 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID, 
						"remarks" => "from_import"
					);
					$insertUsers = $insert->users($usersData);
					if(!is_numeric($insertUsers)){
						$alert = "error";
						$message = "Error in inserting users: <br>";
						$message .= " at ".$count;
						$message .= "Error: ".$insertUsers;
					}
					else{
						$usersId = $insertUsers;
					}
					if($alert == ""){
						$usersLoginData = array(
							"users_id" => $usersId, 
							"login_type_id" => "2", 
							"users_password" => "12345", 
							"password_status" => "active", 
							"password_remarks" => "New - From Import of Sales", 
							"date_added" => date("Y-m-d H:i:s"), 
							"added_by" => ID
						);
						$insertUsersLogin = $insert->users_login($usersLoginData);
						if(!is_numeric($insertUsersLogin)){
							$alert = "error";
							$message = "Error in inserting users login: <br>";
							$message .= " at ".$count;
							$message .= "Error: ".$insertUsersLogin;
						}
					}
					
					if($alert == ""){
						$usersStatusData = array(
							"users_id" => $usersId, 
							"users_type_status_id" => "4", 
							"date_transaction" => date("Y-m-d H:i:s"), 
							"date_added" => date("Y-m-d H:i:s"), 
							"added_by" => ID, 
							"transaction_remarks" => "from_import_of_sales"
						);
						$insertUsersStatus = $insert->users_status($usersStatusData);
						if(!is_numeric($insertUsersStatus)){
							$alert = "error";
							$message = "Error in inserting users status: <br>";
							$message .= "Error: ".$insertUsersStatus;
						}
					}
				}
			}
			
			if($alert == ""){
				$selectedProject = $eRows["project_name"];
				$selectedLocation = $eRows["location"];
				$selectedPrice = $eRows["net_price"];
				$selectedQuantity = $eRows["quantity"];
				$selectedDateReserve = $eRows["date_reserve"];
				$salesData = array(
					"clients_id" => $clientsId, 
					"project_name" => $selectedProject, 
					"location" => $selectedLocation, 
					"price" => $selectedPrice, 
					"quantity" => $selectedQuantity, 
					"date_reserve" => $selectedDateReserve, 
					"status_id" => 10, 
					"date_transaction" => date("Y-m-d H:i:s"), 
					"transact_by" => $usersId, 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID
				);
				$insertSales = $insert->sales($salesData);
				if(!is_numeric($insertSales)){
					$alert = "error";
					$message = "Error in inserting new sales <br>";
					$message .= "At ".$count." <br>";
					$message .= "Error : ".$insertSales;
				}
			}
			
			if($alert == ""){
				$salesHistoryData[] = array(
					"sales_id" => $insertSales,
					"status_id" => 10, 
					"date_transaction" => date("Y-m-d H:i:s"), 
					"transact_by" => $usersId, 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID, 
					"transaction_remarks" => "From Import of data"
				);
			}
			
			$count++;
		}
	}
	
	if($alert == ""){
		if(empty($salesHistoryData)){
			$alert = "error";
			$message = "No Sales Data Found. ";
		}
	}
	
	if($alert == ""){
		$insertSalesHistory = $insert->sales_history($salesHistoryData);
		if(!is_numeric($insertSalesHistory)){
			$alert = "error";
			$message = "Error in inserting new sales history<br>";
			$message .= "Error : ".$insertSalesHistory;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Import Sales Complete";
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
	//$function->echo_array($excelData);
?>