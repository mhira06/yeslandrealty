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
	$response = array();
	
	$selectedUsersId = $function->post("hdn_leave_users_id");
	$selectedDateHired = $function->post("hdn_leave_date_hired");
	$selectedEmployeeStatus = $function->post("hdn_leave_employee_status");
	$usersLeaveCredit = $select->get_users_leave_credit_details($selectedUsersId);
	$selectedStartDate = isset($usersLeaveCredit["date_from"]) ? $usersLeaveCredit["date_from"] : $selectedDateHired;
	$selectedEndDate = $function->format_date_3($selectedStartDate, "+1 year", "Y-m-d");
	$usersLeaveCreditData = array();
	$leaveList = $select->get_active_employees_leave_types($selectedEmployeeStatus);
	foreach($leaveList as $leRows){
		$usersTypeLeave = $leRows["users_type_leave_id"];
		$leaveCredit = $function->post("txt_leave_credit_".$usersTypeLeave);
		if($alert == ""){
			if($leaveCredit == ""){
				$alert = "danger";
				$message = "No Leave Credit Found for ".$leRows["leave_type_desc"];
			}
		}
		if($alert == ""){
			$usedLeave = $select->get_active_users_used_leaves($selectedUsersId, $usersTypeLeave, $selectedStartDate, $selectedEndDate);
			$countUsedLeave = isset($usedLeave["total_used_leave_credits"]) && $usedLeave["total_used_leave_credits"] != "" ? $usedLeave["total_used_leave_credits"] : 0;
			//$function->echo_array($usedLeave);
			//echo "qwe".$countUsedLeave;
			if($countUsedLeave == 0){
				$deleteUsersLeaveCreditCondition = array(
					"users_id" => $selectedUsersId, 
					"users_type_leave_id" => $usersTypeLeave, 
					"transaction_status" => "active", 
					"status" => "active"
				);
				$deleteUsersLeaveCredit = $delete->users_leave_credit($deleteUsersLeaveCreditCondition, ID, "update by admin");
				if(!is_numeric($deleteUsersLeaveCredit)){
					$alert = "danger";
					$message = "Error in deleting old leave credit <br>";
					$message .= "Message: ".$deleteUsersLeaveCredit;
				}
				if($alert == ""){
					//echo "asdf";
					$usersLeaveCreditData[] = array(
						"users_id" => $selectedUsersId, 
						"users_type_leave_id" => $usersTypeLeave, 
						"leave_credit" => $leaveCredit, 
						"date_from" => $selectedStartDate, 
						"date_to" => $selectedEndDate, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transact_by" => ID, 
						"transaction_status" => "active", 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID
					);
				}
			}
		}
		if($alert != ""){
			break;
		}
		
	}
	//echo $alert;
	if($alert == ""){
		if(empty($usersLeaveCreditData)){
			$alert = "danger";
			$message = "No Leave Credit Data. User may used his/her date. <br>";
			$message .= "Please wait for the expiration date before resetting the leave date";
		}
	}
	
	if($alert == ""){
		//$function->echo_array($usersLeaveCreditData);
		if(!empty($usersLeaveCreditData)){
			$inserUsersLeaveCredit = $insert->users_leave_credit($usersLeaveCreditData);
			if(!is_numeric($inserUsersLeaveCredit)){
				$alert = "danger";
				$message = "Error in saving new leave credits <br>";
				$message .= "Error: ".$inserUsersLeaveCredit;
			}
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Users Leave Credit Saved.";
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message
	);
	echo json_encode($response);
?>