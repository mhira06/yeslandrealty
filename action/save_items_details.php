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
	$itemTypeCode = "";
	$itemsColorIdList = array();
	$itemsSizeIdList = array();
	$page = "items.php?action=update_items";
	$selectedItemType = $function->post("slt_update_items_type");
	$selectedItem = $function->post("slt_update_items");
	$selectedItemsColorCount = ($function->post("hdn_items_colors_count") != "" ? $function->post("hdn_items_colors_count") : 0);
	
	if($selectedItemType == ""){
		$alert = "error";
		$message = "No Item Type selected";
		
	}
	if($alert == ""){
		if($selectedItem == ""){
			$alert = "error";
			$message = "No Item selected";
			$page .= "&item_type=".$selectedItemType;
		}
	}
	
	
	if($alert == ""){
		if($selectedItemsColorCount <= 0){
			$alert = "error";
			$message = "No Color Found";
		}
	}
	
	if($alert == ""){
		$itemTypeCondition = "items_type_id = '".$selectedItemType."'";
		$itemTypeDetails = $select->get_active_items_type_details("", $itemTypeCondition);
		//$function->echo_array($itemTypeDetails);
		//exit;
		if(!empty($itemTypeDetails)){
			$itemTypeCode = $itemTypeDetails["items_type_code"];
		}
	}
	
	if($alert == ""){
		if($itemTypeCode == ""){
			$alert = "error";
			$message = "No Item Type Details Found. Please contact administrator";
			$page .= "&item=".$selectedItem;
		}
	}
	if($alert == ""){
		$page .= "&item_type=".$selectedItemType;
		$page .= "&item=".$selectedItem;
	}
	if($alert == ""){
		$itemsColorCondition = "items_id = '".$selectedItem."'";
		$itemsColorList = $select->get_active_items_color_list("", $itemsColorCondition);
		if(!empty($itemsColorList)){
			foreach($itemsColorList as $iCoRows){
				$itemsColorIdList[] = $iCoRows["items_colors_id"];
			}
		}
	}
	
	if($alert == ""){
		if(!empty($itemsColorIdList)){
			$itemColorCondition = array(
				"items_colors_id" => $itemsColorIdList
			);
			$itemsColorRemarks = "due_to_update";
			$deleteItemColor = $delete->items_color($itemColorCondition, ID, $itemsColorRemarks);
			if(!is_numeric($deleteItemColor)){
				$alert = "error";
				$message = "Error in deleting items color: <br>";
				$message .= "Error: ".$deleteItemColor;
			}
		}
	}
	
	if($alert == ""){
		$itemColorId = $select->generate->array_to_in($itemsColorIdList);
		$itemSizeCondition = "items_colors_id in ('".$itemColorId."')";
		$itemSizeList = $select->get_active_items_size_list("", $itemSizeCondition);
		foreach($itemSizeList as $iSiRows){
			$itemsSizeIdList[] = $iSiRows["items_size_id"];
		}
	}
	
	if($alert == ""){
		if(!empty($itemsSizeIdList)){
			$itemSizeCondition = array(
				"items_size_id" => $itemsSizeIdList
			);
			$itemSizeRemarks = "due_to_update";
			$deleteItemSize = $delete->items_size($itemSizeCondition, ID, $itemSizeRemarks);
			if(!is_numeric($deleteItemSize)){
				$alert = "error";
				$message = "Error in deleting items size: <br>";
				$message .= "Error: ".$deleteItemSize;
			}
		}
	}
	
	if($alert == ""){
		$deleteItemStockCondition = array(
			"items_sizes_id" => $itemsSizeIdList, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteItemStock = $delete->items_stock($deleteItemStockCondition, ID, "due_to_update");
		if(!is_numeric($deleteItemStock)){
			$alert = "danger";
			$message = "Error in deleting items stock. <br>";
			$message .= "Error: ".$deleteItemStock;
		}
	}
	
	if($alert == ""){
		$deleteItemPriceCondition = array(
			"items_size_id" => $itemsSizeIdList, 
			"transaction_status" => "active", 
			"status" => "active"
		);
		$deleteItemPrice = $delete->items_price($deleteItemPriceCondition, ID, "due_to_update");
		if(!is_numeric($deleteItemPrice)){
			$alert = "danger";
			$message = "Error in deleting recent items price. <br>";
			$message .= "Error: ".$deleteItemPrice;
		}
	}
	
	
	if($alert == ""){
		$itemsStockData = array();
		$itemsPriceData = array();
		for($x = 1; $x <= $selectedItemsColorCount; $x++){
			$selectedColor = $function->post("slt_items_color_".$x);
			$selectedItemSize = $function->post("slt_items_sizes_".$x);
			$itemsImage = $function->post("hdn_recent_image_".$x);
			if(isset($_FILES["fle_items_image_".$x]["name"]) && $_FILES["fle_items_image_".$x]["name"] != ""){
				$uploadPath = "assets/images/items/".$itemTypeCode;
				$baseUploadPath = root_url($uploadPath);
				if (!is_dir($baseUploadPath)) {
				   mkdir($baseUploadPath, 0777, TRUE);
				}
				
				$uploadName = $uploadPath."/".$_FILES["fle_items_image_".$x]["name"];
				$uploadFullPath = root_url($uploadName);
				if(!move_uploaded_file($_FILES["fle_items_image_".$x]["tmp_name"], $uploadFullPath)){
					$alert = "error";
					$message .= "Error in uploading Image at ".$x;
				}
				else{
					$itemsImage = $uploadName;
				}
			}
			if($alert == ""){
				$itemsColorData = array(
					"items_id" => $selectedItem, 
					"colors_id" => $selectedColor, 
					"image" => $itemsImage, 
					"date_added" => date("Y-m-d H:i:s"), 
					"added_by" => ID,
					"remarks" => "Added through system"
				);
				$insertItemsColor = $insert->items_colors($itemsColorData);
				if(!is_numeric($insertItemsColor)){
					$alert = "error";
					$message .= "Error in insert new items color: <br>";
					$message .= "Error: ".$insertItemsColor;
				}
			}
			
			if($alert == ""){
				$selectedItemSize = $function->post("slt_items_sizes_".$x);
				//$itemSizeData = arra
				foreach($selectedItemSize as $sRows){
					$availableStock = $function->post("txt_items_stock_".$sRows."_".$x) != "" ? $function->post("txt_items_stock_".$sRows."_".$x) : 0;
					$itemPrice = $function->post("txt_items_price_".$sRows."_".$x) != "" ? $function->post("txt_items_price_".$sRows."_".$x) : 0;
					$itemSizeData = array(
						"items_colors_id" => $insertItemsColor, 
						"sizes_id" => $sRows, 
						"date_added" => date("Y-m-d H:i:s"), 
						"added_by" => ID,
						"remarks" => "Updated through system"
					);
					$insertItemSize = $insert->items_size($itemSizeData);
					if(!is_numeric($insertItemSize)){
						$alert = "error";
						$message .= "Error in insert new items size at ".$x.": <br>";
						$message .= "Error: ".$insertItemSize;
					}
					
					if($alert == ""){
						$itemsStockData[] = array(
							"items_sizes_id" => $insertItemSize, 
							"quantity" => $availableStock, 
							"date_transaction" => date("Y-m-d H:i:s"), 
							"transact_by" => ID, 
							"date_added" => date("Y-m-d H:i:s"), 
							"added_by" => ID, 
							"remarks" => "from update item"
						);
						
						$itemsPriceData[] = array(
							"items_size_id" => $insertItemSize, 
							"price" => $itemPrice, 
							"date_transaction" => date("Y-m-d H:i:s"), 
							"transact_by" => ID, 
							"date_added" => date("Y-m-d H:i:s"), 
							"added_by" => ID, 
							"remarks" => "from update item"
						);
					}
				}
			}
		}
	}
	//exit;
	if($alert == ""){
		if(empty($itemsStockData)){
			$alert = "error";
			$message = "No Item Stock Found";
		}
	}
	
	if($alert == ""){
		if(empty($itemsPriceData)){
			$alert = "error";
			$message = "No Item Price Found";
		}
	}
	
	if($alert == ""){
		$insertItemStock = $insert->items_stock($itemsStockData);
		if(!is_numeric($insertItemStock)){
			$alert = "error";
			$message .= "Error in insert new items stock : <br>";
			$message .= "Error: ".$insertItemStock;
		}
	}
	
	if($alert == ""){
		$insertItemPrice = $insert->items_price($itemsPriceData);
		if(!is_numeric($insertItemPrice)){
			$alert = "error";
			$message .= "Error in insert new items price : <br>";
			$message .= "Error: ".$insertItemPrice;
		}
	}
	
	if($alert == ""){
		$alert = "success";
		$message = "Transcation Complete: Item Saved";
	}
	
	$redirect = base_url("pages/maintenance/".$page);
	$function->flash_message($alert, $message, $redirect);
?>