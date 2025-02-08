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
	$page = "document_request.php";
	$selectedDocumentType = $function->post("slt_documents_request_document_type");
	$selectedOtherDocuments = $function->post("txt_documents_request_other_document");
	$selectedDateNeeded = $function->post("txt_documents_request_date_need");
	$selectedPurpose = $function->post("txtarea_document_request_purpose");
	
	$documentsRequestData = array(
		"documents_type_id" => $selectedDocumentType, 
		"other_document" => $selectedOtherDocuments, 
		"date_need" => $selectedDateNeeded, 
		"status_id" => 19, 
		"transaction_remarks" => $selectedPurpose, 
		"date_transaction" => date("Y-m-d H:i:s"), 
		"transact_by" => ID, 
		"date_added" => date("Y-m-d H:i:s"), 
		"added_by" => ID
	);
	
	$insertDocumentsRequest = $insert->documents_request($documentsRequestData);
	if(!is_numeric($insertDocumentsRequest)){
		$alert = "error";
		$message = "Error in saving new documents request. <br>";
		$message .= "Error: ".$insertDocumentsRequest;
	}
	
	if($alert == ""){
		$documentsRequestHistoryData = array(
			"documents_request_id" => $insertDocumentsRequest, 
			"status_id" => 19, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"transaction_remarks" => $selectedPurpose, 
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
		$message = "Transaction Done: Document Requested Successfully "; 
	}
	$redirect = base_url("pages/display/".$page);
	$function->flash_message($alert, $message, $redirect);
?>