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
	
	$selectedOrder = $function->post("order_id");
	$selectedStatus = $function->post("selected_status");
	$selectedQuantity = $function->post("quantity");
	$selectedRemarks = $function->post("remarks");
	$selectedActionDesc = $function->post("action_desc");
	
	$orderedCondition = "ito.items_orders_id = '".$selectedOrder."'";
	$orderedDetails = $select->get_active_ordered_items_details("", $orderedCondition);
	if(empty($orderedDetails)){
		$alert = "error";
		$message = "No Found Ordered Details";
	}
	
	
	if($alert == ""){
		$updateStockStatus = array(16, 17);
		if(in_array($selectedStatus, $updateStockStatus)){
			$itemsSizeId = $orderedDetails["items_size_id"];
			$itemCondition = "isi.items_size_id = '".$itemsSizeId."'";
			$itemDetails = $select->get_active_items_display_details($itemCondition);
			$availableStock = isset($itemDetails["available_stock"]) ? $itemDetails["available_stock"] : 0;
			$newStock = ($selectedQuantity + $availableStock);
			
			$deleteItemStockCondition = array(
				"items_sizes_id" => $itemsSizeId, 
				"transaction_status" => "active", 
				"status" => "active"
			);
			$remarks = $selectedActionDesc." Order Id: ".$selectedOrder;
			$deleteItemStock = $delete->items_stock($deleteItemStockCondition, ID, $remarks);
			if(!is_numeric($deleteItemStock)){
				$alert = "danger";
				$message = "Error in updating stock: <br>";
				$message .= "Error: ".$deleteItemStock;
			}
			
			if($alert == ""){
				$itemStockData = array(
					"items_sizes_id" => $itemsSizeId, 
					"quantity" => $newStock, 
					"transact_by" => ID, 
					"date_transaction" => date("Y-m-d H:i:s"), 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID
				);
				$insertItemsStocks = $insert->items_stock($itemStockData);
				if(!is_numeric($insertItemsStocks)){
					$alert = "danger";
					$message = "Error in saving items stock: <br>";
					$message .= "Error: ".$insertItemsStocks;
				}
			}
		}
	}
	
	if($alert == ""){
		$itemsOrderData = array(
			"status_id" => $selectedStatus, 
			"date_updated" => date("Y-m-d H:i:s"), 
			"updated_by" => ID
		);
		$itemsOrderCondition = array(
			"items_orders_id" => $selectedOrder
		);
		$updateOrderItem = $update->items_order($itemsOrderData, $itemsOrderCondition);
		if(!is_numeric($updateOrderItem)){
			$alert = "error";
			$message = "Error in removing Items: <br>";
			$message .= "Error: ".$updateOrderItem;
		}
	}
	
	if($alert == ""){
		$itemsHistoryData = array(
			"items_order_id" => $selectedOrder, 
			"quantity" => $selectedQuantity, 
			"status_id" => $selectedStatus, 
			"transaction_remarks" => $selectedRemarks, 
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
		$message = "Transaction Done: ".$selectedActionDesc." Item "; 
	}
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>