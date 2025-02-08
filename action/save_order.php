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
	$page = "online_ordering.php?action=order";
	$selectedItems = $function->post("hdn_items_id");
	$selectedItemsColor = $function->post("hdn_items_colors_id");
	$selectedItemsSize = $function->post("hdn_items_sizes_id");
	$selectedItemStock = $function->post("hdn_items_available_stock");
	$selectedQuantity = $function->post("txt_order_quantity");
	$page .= "&id=".$selectedItems;
	if($selectedItemsColor == ""){
		$alert = "error";
		$message = "Please select a color.";
	}
	
	if($alert == ""){
		if($selectedItemsSize == ""){
			$alert = "error";
			$message = "Please select a size.";
		}
	}
	
	if($alert == ""){
		if($selectedItemStock == ""){
			$alert = "error";
			$message = "No Identified Stock. Please contact admin to check";
		}
	}
	
	if($alert == ""){
		if($selectedItemStock <= 0){
			$alert = "error";
			$message = "Item is out of stock";
		}
	}
	
	if($alert == ""){
		if($selectedQuantity == ""){
			$alert = "error";
			$message = "Please input quantity";
		}
	}
	
	if($alert == ""){
		if($selectedQuantity <= 0){
			$alert = "error";
			$message = "Prefer quantity must greater than 0";
		}
	}
	
	if($alert == ""){
		if($selectedQuantity > $selectedItemStock){
			$alert = "error";
			$message = "Invalid Quantity. Prefer quantity must be lowered than available stock.";
		}
	}
	
	if($alert == ""){
		$itemsOrderData = array(
			"items_size_id" => $selectedItemsSize,
			"users_id" => ID, 
			"status_id" => 8, 
			"quantity" => $selectedQuantity, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		$insertItemsOrder = $insert->items_order($itemsOrderData);
		if(!is_numeric($insertItemsOrder)){
			$alert = "danger";
			$message = "Error in saving order: <br>";
			$message .= "Error: ".$insertItemsOrder;
		}
	}
	
	if($alert == ""){
		$itemsHistoryData = array(
			"items_order_id" => $insertItemsOrder, 
			"quantity" => $selectedQuantity, 
			"status_id" => 8, 
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
		$message = "Transaction Done: Save Order "; 
		$page = "online_ordering.php?action=invoice";
	}
	$redirect = base_url("pages/display/".$page);
	$function->flash_message($alert, $message, $redirect);
?>