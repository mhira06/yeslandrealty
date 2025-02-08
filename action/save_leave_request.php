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
	$alert = "";
	$message = "";
	$selectedLeaveType = $function->post("slt_leave_type");
	$selectedLeaveDate = $function->post("txt_leave_date");
	$selectedLeaveReason = $function->post("txtarea_leave_reason");
	
	if($selectedLeaveType == ""){
		$alert = "error";
		$message = "No Leave Type";
	}
	
	if($alert == ""){
		if($selectedLeaveDate == ""){
			$alert = "error";
			$message = "No Leave Date";
		}
	}
	
	if($alert == ""){
		if($selectedLeaveReason == ""){
			$alert = "error";
			$message = "No Leave Reason";
		}
	}
	
	if($alert == ""){
		$usersLeaveDetails = $select->get_users_leave_credit_details_2($selectedLeaveType);
		if(empty($usersLeaveDetails)){
			$alert = "error";
			$message = "No Users Leave Details Found";
		}
		//$startDate = 
		//$function->echo_array($usersLeaveDetails);
	}
	
	if($alert == ""){
		$dateFrom = $usersLeaveDetails["date_from"];
		$dateTo = $usersLeaveDetails["date_to"];
		$availableCredit = $usersLeaveDetails["users_leave_credit"];
		$usersLeaveTypeId = $usersLeaveDetails["users_type_leave_id"];
		$usersUsedLeaveDetails = $select->get_active_users_used_leaves(ID, $usersLeaveTypeId, $dateFrom, $dateTo);
		$usersTotalUsedCredit = isset($usersUsedLeaveDetails["total_used_leave_credits"]) ? $usersUsedLeaveDetails["total_used_leave_credits"] : 0;
		$remainingLeaveCredit = ($availableCredit - $usersTotalUsedCredit);
		list($start, $end) = explode(" - ", $selectedLeaveDate);
		$startDate = $function->format_date_2($start, "m/d/Y", "Y-m-d");
		$endDate = $function->format_date_2($end, "m/d/Y", "Y-m-d");
		$rangeDate = $function->generate->range_date($startDate, $endDate, "Y-m-d");
		$countDate = count($rangeDate);
		if($countDate > $remainingLeaveCredit){
			$alert = "error";
			$message = "No Enough Credit";
		}
	}
	if($alert == ""){
		if(empty($rangeDate)){
			$alert = "error";
			$message = "Error in generating dates.";
		}
	}
	
	if($alert == ""){
		if($startDate < $dateFrom){
			$alert = "error";
			$message = "Invalid Leave Request. <br>";
			$message = "Start Date Error. <br>";
			$message .= "Leave request must start on ".$dateFrom;
		}
	}
	
	if($alert == ""){
		if($startDate > $dateTo){
			$alert = "error";
			$message = "Invalid Leave Request. <br>";
			$message .= "Start Date Error. <br>";
			$message .= "Leave request is until ".$dateTo;
		}
	}
	
	if($alert == ""){
		if($endDate < $dateFrom){
			$alert = "error";
			$message = "Invalid Leave Request. <br>";
			$message .= "End Date Error. <br>";
			$message .= "Leave request must start on ".$dateFrom;
		}
	}
	
	if($alert == ""){
		if($endDate > $dateTo){
			$alert = "error";
			$message = "Invalid Leave Request. <br>";
			$message .= "End Date Error. <br>";
			$message .= "Leave request is until ".$dateTo;
		}
	}
	
	if($alert == ""){
		$usersLeaveDate = $select->get_users_leave_dates(ID, $rangeDate);
		//$function->echo_array($usersLeaveDate);
		//exit;
		if(!empty($usersLeaveDate)){
			$alert = "error";
			$message = "Your requested date is conflict with your another request.";
		}
	}
	
	if($alert == ""){
		$leaveTransactionData = array(
			"users_leave_credit_id" => $selectedLeaveType, 
			"status_id" => 1, 
			"credits_deducted" => $countDate,
			"leave_reason" => $selectedLeaveReason, 
			"transact_by" => ID, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertLeaveTransaction = $insert->leave_transaction($leaveTransactionData);
		if(!is_numeric($insertLeaveTransaction)){
			$alert = "error";
			$message = "Error in leave transaction: <br>";
			$message .= "Message: ".$insertLeaveTransaction;
		}
	}
	
	if($alert == ""){
		$leaveTransactionHistoryData = array(
			"leave_transaction_id" => $insertLeaveTransaction, 
			"status_id" => 1, 
			"transaction_remarks" => $selectedLeaveReason, 
			"transact_by" => ID, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertLeaveTransactionHistory = $insert->leave_transaction_history($leaveTransactionHistoryData);
		if(!is_numeric($insertLeaveTransactionHistory)){
			$alert = "error";
			$message = "Error in leave Transaction History Data: <br>";
			$message .= "Error: ".$insertLeaveTransactionHistory;
		}
	}
	
	if($alert == ""){
		$leaveTransactionDatesData = array();
		foreach($rangeDate as $raRows){
			$leaveTransactionDatesData[] = array(
				"leave_transaction_id" => $insertLeaveTransaction, 
				"leave_date" => $raRows, 
				"date_added" => date("Y-m-d H:i:s"), 
				"added_by" => ID
			);
		}
		
		if(empty($leaveTransactionDatesData)){
			$alert = "error";
			$message = "No Leave Found";
		}
	}
	
	if($alert == ""){
		$insertLeaveDates = $insert->leave_dates($leaveTransactionDatesData);
		if(!is_numeric($insertLeaveDates)){
			$alert = "error";
			$message = "Error in inserting leave.";
			$message .= "Error: ".$insertLeaveDates;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Leave Saved";
	}
	
	$redirect = base_url("pages/display/leave.php?action=add");
	$function->flash_message($alert, $message, $redirect);
?>