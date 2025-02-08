<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	
	$alert = "";
	$message = "";
	$searchCondition = "";
	$sessionArray = array();
	
	$redirectPage = "pages/administration/";
	
	$seletedDateReserve = $function->post("txt_sales_date_reserve");
	$selectedAction = $function->post("hdn_sales_action");
	$selectedSummary = $function->get("summary");
	if($selectedAction == ""){
		$selectedAction = $function->get("action");
	}
	switch($selectedAction){
		case "sales":
			$redirectPage = "pages/display/";
		break;
	}
	$sessionName = $selectedAction;
	$redirectPage .= $sessionName.".php";
	
	if($seletedDateReserve != ""){
		list($startDate, $endDate) = explode(" - ", $seletedDateReserve);
		$selectedStartDate = $function->format_date_2($startDate, "m/d/Y", "Y-m-d");
		$selectedEndDate = $function->format_date_2($endDate, "m/d/Y", "Y-m-d"); 
		$dateCondition = "date(sa.date_reserve) >= '".$selectedStartDate."'
						and date(sa.date_reserve) <= '".$selectedEndDate."'";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$dateCondition;
		$sessionArray += array(
			"start_date" => $selectedStartDate, 
			"end_date" => $selectedEndDate
		);
	}
	if($selectedSummary != ""){
		$startDate = "";
		$endDate = "";
		$dateCondition  = "sa_s.status_id != '11'";
		switch($selectedSummary){
			case "daily":
				$startDate = date("Y-m-d");
				$endDate = date("Y-m-d");
			break;
			
			case "monthly":
				$startDate = date("Y-m-01");
				$endDate = date("Y-m-d");
			break;
			
			case "yearly":
				$startDate = date("Y-01-01");
				$endDate = date("Y-m-d");
			break;
		}
		
		$dateCondition .= " and date(sa.date_reserve) >= '".$startDate."'
							and date(sa.date_reserve) <= '".$endDate."'";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$dateCondition;
		$sessionArray += array(
			"summary" => $selectedSummary, 
			"start_date" => $startDate, 
			"end_date" => $endDate
		);
	}
	if($searchCondition != ""){
		$sessionArray += array(
			"search_condition" => $searchCondition
		);
	}
	//$function->echo_array($sessionArray);
	//exit;
	if(!empty($sessionArray)){
		$_SESSION[PROJECT][$sessionName] = $sessionArray;
	}
	$alert = "success";
	$message = "Transaction Done: Seach Complete";
	
	
	$redirect = base_url($redirectPage);
	$function->flash_message($alert, $message, $redirect);
?>