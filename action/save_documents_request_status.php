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
	
	$selectedDocumentRequest = $function->post("documents_request_id");
	$selectedStatus = $function->post("selected_status");
	$selectedAction = $function->post("action_desc");
	$selectedRemarks = $function->post("remarks");
	
	$documentsRequestData = array(
		"status_id" => $selectedStatus, 
		"date_updated" => date("Y-m-d H:i:s"), 
		"updated_by" => ID
	);
	
	$documentsRequestCondition = array(
		"documents_request_id" => $selectedDocumentRequest
	);
	
	$updateDocumentRequest = $update->documents_request($documentsRequestData, $documentsRequestCondition);
	if(!is_numeric($updateDocumentRequest)){
		$alert = "error";
		$message = "Error in updating documents request. <br>";
		$message .= "Error: ".$updateDocumentRequest;
	}
	
	if($alert == ""){
		$documentsRequestHistoryData = array(
			"documents_request_id" => $selectedDocumentRequest, 
			"status_id" => $selectedStatus, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transaction_remarks" => $selectedRemarks, 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		
		$insertDocumentRequestHistory = $insert->documents_request_history($documentsRequestHistoryData);
		if(!is_numeric($insertDocumentRequestHistory)){
			$alert = "error";
			$message = "Error in saving new documents request history. <br>";
			$message .= "Error: ".$insertDocumentRequestHistory;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: ".$selectedAction." Done "; 
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>