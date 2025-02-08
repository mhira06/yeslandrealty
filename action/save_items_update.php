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
	$uploadName = "";
	$response = array();
	$selectedItemSizeId = $function->post("hdn_items_size_id");
	$selectedItemsColor = $function->post("hdn_items_size_id");
	$selectedPrice = $function->post("txt_items_stock_price");
	$selectedStock = $function->post("txt_items_stock_qty");
	$selectedItemCode = $function->post("hdn_items_type_code");
	$recentImage = $function->post("hdn_items_image");
	
	if($selectedPrice == ""){
		$alert = "danger";
		$message = "No Price Detected";
	}
	
	if($alert == ""){
		if($selectedStock == ""){
			$alert = "danger";
			$message = "No Stock Detected";
		}
	}
	
	
	if($alert == ""){
		$deleteItemPriceCondition = array(
			"items_size_id" => $selectedItemSizeId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteItemPrice = $delete->items_price($deleteItemPriceCondition, ID, "update of price");
		if(!is_numeric($deleteItemPrice)){
			$alert = "danger";
			$message = "Error in deleting recent items price. <br>";
			$message .= "Error: ".$deleteItemPrice;
		}
	}
	
	if($alert == ""){
		$itemsPriceData = array(
			"items_size_id" => $selectedItemSizeId, 
			"price" => $selectedPrice, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID
		);
		
		$insertItemsPrice = $insert->items_price($itemsPriceData);
		if(!is_numeric($insertItemsPrice)){
			$alert = "danger";
			$message = "Error in saving new items price. <br>";
			$message .= "Error: ".$insertItemsPrice;
		}
	}
	
	if($alert == ""){
		$deleteItemStockCondition = array(
			"items_sizes_id" => $selectedItemSizeId, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteItemStock = $delete->items_stock($deleteItemStockCondition, ID, "update of price");
		if(!is_numeric($deleteItemStock)){
			$alert = "danger";
			$message = "Error in deleting recent items stock. <br>";
			$message .= "Error: ".$deleteItemStock;
		}
	}
	
	if($alert == ""){
		$itemsStockData = array(
			"items_sizes_id" => $selectedItemSizeId, 
			"quantity" => $selectedStock, 
			"date_transaction" => date("Y-m-d H:i:s"), 
			"transact_by" => ID, 
			"date_added" => date("Y-m-d H:i:s"), 
			"added_by" => ID, 
			"remarks" => "from update stock"
		);
		
		$insertItemsStock = $insert->items_stock($itemsStockData);
		if(!is_numeric($insertItemsStock)){
			$alert = "danger";
			$message = "Error in saving new items stock. <br>";
			$message .= "Error: ".$insertItemsStock;
		}
	}
	
	if($alert == ""){
		if(isset($_FILES["fle_items_image"]["name"]) && $_FILES["fle_items_image"]["name"] != ""){
			if($recentImage != ""){
				if(file_exists($recentImage)){
					unlink($recentImage);
				}
			}
			$uploadPath = "assets/images/items/".$selectedItemCode;
			$uploadName = $uploadPath."/".$_FILES["fle_items_image"]["name"];
			$uploadFullPath = root_url($uploadName);
			if(!move_uploaded_file($_FILES["fle_items_image"]["tmp_name"], $uploadFullPath)){
				$alert = "error";
				$message = "Error in uploading Image";
			}
		}
	}
	
	if($alert == ""){
		if($uploadName != ""){
			$itemsColorData = array(
				"image" => $uploadName, 
				"date_updated" => date("Y-m-d H:i:s"), 
				"updated_by" => ID
			);
			
			$itemsColorCondition = array(
				"items_colors_id" => $selectedItemsColor
			);
			
			$updateItemsColor = $update->items_colors($itemsColorData, $itemsColorCondition);
			if(!is_numeric($updateItemsColor)){
				$alert = "danger";
				$message = "Error in saving new image. <br>";
				$message .= "Error: ".$updateItemsColor;
			}
		}
		
	}
	if($alert == ""){
		$alert = "success";
		$message = "Transcation Complete: Item Update Success";
	}
	
	
	
	$response = array(
		"output" => $alert, 
		"message" => $message, 
		"header" => ucfirst($alert)
	);
	
	echo json_encode($response);
?>