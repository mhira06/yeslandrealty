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
	$selectedLeave = $function->post("leave");
	
	if(empty($selectedLeave)){
		$alert = "danger";
		$message = "No Leave Selected";
	}
	
	if($alert == ""){
		$leaveTransactionStatusData = array();
		foreach($selectedLeave as $sRows){
			$leaveTransactionStatusData[] = array(
				"leave_transaction_id" => $sRows, 
				"status_id" => "5", 
				"date_transaction" => date("Y-m-d H:i:s"), 
				"date_added" => date("Y-m-d H:i:s"), 
				"transact_by" => ID, 
				"added_by" => ID
			);
		}
		if(empty($leaveTransactionStatusData)){
			$alert = "danger";
			$message = "No Leave Transaction Data Found. ";
			$message .= "Kindly contact administrator";
		}
	}
	
	if($alert == ""){
		$leaveData = array(
			"status_id" => "5", 
			"date_updated" => date("Y-m-d H:i:s"), 
			"updated_by" => ID
		);
		$leaveCondition = array(
			"leave_transaction_id" => $selectedLeave
		);
		$updateLeave = $update->leave_transaction($leaveData, $leaveCondition);
		if(!is_numeric($updateLeave)){
			$alert = "error";
			$message = "Error in updating leave: ";
			$message .= "Error: ".$updateLeave;
		}
	}
	
	if($alert == ""){
		$insertLeaveHistory = $insert->leave_transaction_history($leaveTransactionStatusData);
		if(!is_numeric($insertLeaveHistory)){
			$alert = "danger";
			$message = "Error in saving leave History: ";
			$message .= "Error: ".$insertLeaveHistory;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Leave Cancelled"; 
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>