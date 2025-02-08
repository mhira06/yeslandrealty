<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$searchCondition = "";
	$sessionArray = array();
	
	$startDate = $function->post("txt_search_leave_date_start");
	$endDate = $function->post("txt_search_leave_date_end");
	$redirect = base_url("pages/display/leave.php");
	
	if($startDate != ""){
		$startCondition = "leave_dates.start_date >= '".$startDate."'";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$startCondition;
		$sessionArray += array(
			"start_date" => $startDate
		);
	}
	
	if($endDate != ""){
		$endCondition = "leave_dates.end_date <= '".$endDate."'";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$endCondition;
		$sessionArray += array(
			"end_date" => $endDate
		);
	}
	
	if($searchCondition != ""){
		$sessionArray += array(
			"search_condition" => $searchCondition
		);
	}
	
	if(!empty($sessionArray)){
		$_SESSION[PROJECT]["leave"] = $sessionArray;
	}
	
	$alert = "success";
	$message = "Search Complete";
	
	$function->flash_message($alert, $message, $redirect);
?>