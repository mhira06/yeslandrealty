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
	$selectedItemsOrder = $function->post("items_order");
	$selectedQuantity = $function->post("quantity");
	
	$itemsOrderData = array(
		"status_id" => 18, 
		"date_updated" => date("Y-m-d H:i:s"), 
		"updated_by" => ID
	);
	$itemsOrderCondition = array(
		"items_orders_id" => $selectedItemsOrder
	);
	$updateOrderItem = $update->items_order($itemsOrderData, $itemsOrderCondition);
	if(!is_numeric($updateOrderItem)){
		$alert = "error";
		$message = "Error in removing Items: <br>";
		$message .= "Error: ".$updateOrderItem;
	}
	
	if($alert == ""){
		$itemsHistoryData = array(
			"items_order_id" => $selectedItemsOrder, 
			"quantity" => $selectedQuantity, 
			"status_id" => 18, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertItemsOrderHistory = $insert->items_order_history($itemsHistoryData);
		if(!is_numeric($insertItemsOrderHistory)){
			$alert = "danger";
			$message = "Error in saving order history: <br>";
			$message .= "Error: ".$insertItemsOrderHistory;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Removed Item "; 
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>