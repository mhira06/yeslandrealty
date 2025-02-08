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
	
	$selectedSales = $function->post("sales_id");
	$selectedStatus = $function->post("status_id");
	$selectedRemarks = $function->post("remarks");
	$selectedActionDesc = $function->post("action_desc");
	
	$salesData = array(
		"status_id" => $selectedStatus, 
		"date_updated" => date("Y-m-d H:i:s"), 
		"updated_by" => ID
	);
	
	$salesCondition = array(
		"sales_id" => $selectedSales
	);
	
	$updateSales = $update->sales($salesData, $salesCondition);
	if(!is_numeric($updateSales)){
		$alert = "error";
		$message = "Error in updating status of sales: <br>";
		$message .= "Error : ".$updateSales;
	}
	
	if($alert == ""){
		$salesHistoryData = array(
			"sales_id" => $selectedSales,
			"status_id" => $selectedStatus, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID, 
			"transaction_remarks" => $selectedRemarks
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
		$message = "Transaction Done: Sales ".$selectedActionDesc;
	}
	
	$response = array(
		"output" => $alert,
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
	
?>