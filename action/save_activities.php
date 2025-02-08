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
	$url = "manage_activities.php";
	$selectedId = $function->post("hdn_activities_id");
	$selectedAction = $function->post("hdn_activities_action");
	$selectedTitle = $function->post("txt_activities_title");
	$selectedDesc = $function->post("txt_activities_desc");
	$selectedLocation = $function->post("txt_activities_location");
	$selectedDate = $function->post("txt_activities_dates");
	$selectedAttendees = $function->post("slt_activities_attendees");
	$selectedRegistrationEnd = $function->post("txt_activities_date_end");
	$selectedStatus = $function->post("slt_activities_status");
	$selectedRemarks = $function->post("txtarea_activities_remarks");
	list($start, $end) = explode(" - ", $selectedDate);
	$startDate = $function->format_date_2($start, "m/d/Y", "Y-m-d");
	$endDate = $function->format_date_2($end, "m/d/Y", "Y-m-d");
	if(empty($selectedAttendees)){
		$alert = "error";
		$message = "No Attendees Selected";
	}
	if($alert == ""){
		switch($selectedAction){
			case "add":
				$activitiesData = array(
					"activities_title" => $selectedTitle, 
					"activities_desc" => $selectedDesc, 
					"location" => $selectedLocation, 
					"start_date" => $startDate, 
					"end_date" => $endDate, 
					"date_registration_end" => $selectedRegistrationEnd, 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID
				);
				$insertActivities = $insert->activities($activitiesData);
				if(!is_numeric($insertActivities)){
					$alert = "error";
					$message = "Error in inserting Activities: <br>";
					$message .= "Error : ".$insertActivities;
				}
				
				if($alert == ""){
					$selectedId = $insertActivities;
					$activitiesHistoryData = array(
						"activities_id" => $selectedId, 
						"status_id" => "12", 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transact_by" => ID, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID, 
					);
				}
				
			break;
			
			case "edit":
				$url .= "?id=".$selectedId;
				$activitiesData = array(
					"activities_title" => $selectedTitle, 
					"activities_desc" => $selectedDesc, 
					"location" => $selectedLocation, 
					"start_date" => $startDate, 
					"end_date" => $endDate, 
					"date_registration_end" => $selectedRegistrationEnd, 
					"status_id" => $selectedStatus, 
					"date_updated" => date("Y-m-d H:i:s"), 
					"updated_by" => ID
				);
				$activitiesCondition = array(
					"activities_id" => $selectedId
				);
				$updateActivities = $update->activities($activitiesData, $activitiesCondition);
				if(!is_numeric($updateActivities)){
					$alert = "error";
					$message = "Error in updating Activities: <br>";
					$message .= "Error : ".$updateActivities;
				}
				
				if($alert == ""){
					$activitiesHistoryData = array(
						"activities_id" => $selectedId, 
						"status_id" => $selectedStatus, 
						"transaction_remarks" => $selectedRemarks, 
						"date_transaction" => date("Y-m-d H:i:s"), 
						"transact_by" => ID, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID, 
					);
				}
			break;
		}
	}
	
	if($alert == ""){
		$deleteTargetAttendessCondition = array(
			"activities_id" => $selectedId, 
			"status" => "active"
		);
		$deleteTargetAttendees = $delete->target_activities_attendees($deleteTargetAttendessCondition, ID, "due to update");
		if(!is_numeric($deleteTargetAttendees)){
			$alert = "error";
			$message = "Error in deleting Activities Attendees: <br>";
			$message .= "Error : ".$deleteTargetAttendees;
		}
	}
	
	if($alert == ""){
		$targetAttendessData = array();
		foreach($selectedAttendees as $sRows){
			$targetAttendessData[] = array(
				"activities_id" => $selectedId, 
				"positions_id" => $sRows, 
				"date_added" => date("Y-m-d H:i:s"), 
				"added_by" => ID
			);
		}
			
		if(empty($targetAttendessData)){
			$alert = "error";
			$message = "No Target Attendees Data Found";
		}
	}
	
	if($alert == ""){
		$insertTargetAttendees = $insert->activities_target_attendees($targetAttendessData);
		if(!is_numeric($insertTargetAttendees)){
			$alert = "error";
			$message = "Error in inserting target attendees. <br>";
			$message .= "Error: ".$insertTargetAttendees;
		}
	}
	
	if($alert == ""){
		if(!empty($activitiesHistoryData)){
			$insertActivitiesHistory = $insert->activities_status_history($activitiesHistoryData);
			if(!is_numeric($insertActivitiesHistory)){
				$alert = "error";
				$message = "Error in inserting activities history. <br>";
				$message .= "Error: ".$insertActivitiesHistory;
			}
		}
	}
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Activity Saved!";
 	}
	
	$redirect = base_url("pages/administration/".$url);
	$function->flash_message($alert, $message, $redirect);
?>