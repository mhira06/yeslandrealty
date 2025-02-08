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
	$page = "manage_sales.php?action=add_sales";
	
	$selectedClient = $function->post("slt_sales_client");
	$selectedProject = $function->post("txt_sales_project");
	$selectedLocation = $function->post("txt_sales_location");
	$selectedDateReservation = $function->post("txt_sales_date_reservation");
	$selectedPrice = $function->post("txt_sales_price");
	$selectedQuantity = $function->post("txt_sales_quantity");
	$selectedAgent = $function->post("slt_sales_agent");
	
	$salesData = array(
		"clients_id" => $selectedClient, 
		"project_name" => $selectedProject, 
		"location" => $selectedLocation, 
		"price" => $selectedPrice, 
		"quantity" => $selectedQuantity, 
		"date_reserve" => $selectedDateReservation, 
		"status_id" => 10, 
		"date_transaction" => date("Y-m-d H:i:s"), 
		"transact_by" => $selectedAgent, 
		"date_added" => date("Y-m-d H:i:s"), 
		"added_by" => ID
	);
	$insertSales = $insert->sales($salesData);
	if(!is_numeric($insertSales)){
		$alert = "error";
		$message = "Error in inserting new sales <br>";
		$message .= "Error : ".$insertSales;
	}
	
	if($alert == ""){
		$salesHistoryData = array(
			"sales_id" => $insertSales,
			"status_id" => 10, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => $selectedAgent, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertSalesHistory = $insert->sales_history($salesHistoryData);
		if(!is_numeric($insertSalesHistory)){
			$alert = "error";
			$message = "Error in inserting new sales history <br>";
			$message .= "Error : ".$insertSalesHistory;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Sales Saved";
	}
	
	$redirect = base_url("pages/administration/".$page);
	$function->flash_message($alert, $message, $redirect);
?>