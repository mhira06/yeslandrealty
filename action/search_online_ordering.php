<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();

	$selectedAction = $function->post("hdn_search_action");
	$selectedItemType = $function->post("slt_online_ordering_type");
	$selectedDateOrdered = $function->post("txt_search_date_ordered");
	$redirectPage = "";
	$sessionName = "";
	$searchCondition = "";
	$sessionArray = array();
	switch($selectedAction){
		case "manage_online_ordering":
			$redirectPage = "pages/administration/manage_online_ordering.php";
			$sessionName = "manage_online_ordering";
		break;
		
		case "view_orders":
			$redirectPage = "pages/display/online_ordering.php?action=view_orders";
			$sessionName = "view_orders";
		break;
		
		default: 
			$redirectPage = "pages/display/online_ordering.php";
			$sessionName = "online_ordering";
		break;
	}
	
	if($selectedItemType != ""){
		$itemTypeList = $generate->array_to_in($selectedItemType);
		$itemTypeCondition = "it.items_type_id in ('".$itemTypeList."')";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$itemTypeCondition;
		$sessionArray += array(
			"item_type" => $selectedItemType
		);
	}
	
	if($selectedDateOrdered != ""){
		list($startDate, $endDate) = explode(" - ", $selectedDateOrdered);
		$selectedStartDate = $function->format_date_2($startDate, "m/d/Y", "Y-m-d");
		$selectedEndDate = $function->format_date_2($endDate, "m/d/Y", "Y-m-d"); 
		$dateCondition = "date(ito.date_transaction) >= '".$selectedStartDate."'
						and date(ito.date_transaction) <= '".$selectedEndDate."'";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$dateCondition;
		$sessionArray += array(
			"start_date" => $selectedStartDate, 
			"end_date" => $selectedEndDate
		);
	}
	if($searchCondition != ""){
		$sessionArray += array(
			"search_condition" => $searchCondition
		);
	}
	
	if(!empty($sessionArray)){
		$_SESSION[PROJECT][$sessionName] = $sessionArray;
	}
	$alert = "success";
	$message = "Transaction Done: Seach Complete";
	
	
	$redirect = base_url($redirectPage);
	$function->flash_message($alert, $message, $redirect);
?>