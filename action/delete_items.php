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
	$response = array();
	$selectedItems = $function->post("items");
	$selectedRemarks = $function->post("remarks");
	$itemSizeCondition = array(
		"items_size_id" => $selectedItems, 
		"status" => "active"
	);
	$deleteItemSize = $delete->items_size($itemSizeCondition, ID, $selectedRemarks);
	
	if(!is_numeric($deleteItemSize)){
		$alert = "error";
		$message = "Error in deleting items size: <br>";
		$message .= "Error: ".$deleteItemSize;
	}
	
	if($alert == ""){
		$itemStockCondition = array(
			"items_sizes_id" => $selectedItems, 
			"status" => "active", 
			"transaction_status" => "active"
		);
		$deleteItemStock = $delete->items_stock($itemStockCondition, ID, $selectedRemarks);
		if(!is_numeric($deleteItemStock)){
			$alert = "error";
			$message = "Error in deleting items stock: <br>";
			$message .= "Error: ".$deleteItemStock;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transaction Done: Item Successfully Deleted";
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>