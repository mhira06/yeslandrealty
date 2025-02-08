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
	$page = "items.php?action=add_item";
	$itemId = "";
	$itemTypeCode = "";
	//$function->echo_array($_POST);
	//exit;
	$selectedItemType = $function->post("slt_items_type");
	$selectedItemName = $function->post("txt_items_name");
	$selectedItemsColorCount = $function->post("hdn_items_colors_count");
	
	if($selectedItemName == ""){
		$alert = "error";
		$message = "No Item Name";
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
			$message = "No Item Type Found. Please contact administrator";
		}
	}
	
	if($alert == ""){
		for($x = 1; $x <= $selectedItemsColorCount; $x++){
			$selectedItemSize = $function->post("slt_items_sizes_".$x);
			if(empty($selectedItemSize)){
				$alert = "error";
				$message .= "No Item Size selected for the row ".$x." <br>";
			}
		}
	}
	
	if($alert == ""){
		$itemCondition = "items_type_id = '".$selectedItemType."' 
							and items_desc like '%".$selectedItemName."%'";
		$itemDetails = $select->get_active_items_details("", $itemCondition);
		if(!empty($itemDetails)){
			$itemId = $itemDetails["items_id"];
		}
	}
	
	if($alert == ""){
		if($itemId ==""){
			$itemCode = strtolower($selectedItemName);
			$itemCode = str_replace(" ", "_", $itemCode);
			$itemData = array(
				"items_type_id" => $selectedItemType, 
				"items_code" => $itemCode, 
				"items_desc" => $selectedItemName, 
				"date_added" => date("Y-m-d H:i:s"), 
				"added_by" => ID,
				"remarks" => "Added through system"
			);
			$insertItem = $insert->items($itemData);
			if(!is_numeric($insertItem)){
				$alert = "error";
				$message = "Error in inserting new Item: <br>";
				$message .= "Error: ".$insertItem;
			}
			else{
				$itemId = $insertItem;
			}
		}
	}
	
	if($alert == ""){
		$itemsStockData = array();
		$itemsPriceData = array();
		for($x = 1; $x <= $selectedItemsColorCount; $x++){
			$selectedColor = $function->post("slt_items_color_".$x);
			$selectedItemSize = $function->post("slt_items_sizes_".$x);
			
			$itemsImage = "";
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
			
			$itemsColorData = array(
				"items_id" => $itemId, 
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
						"remarks" => "Added through system"
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
							"remarks" => "from insert new item"
						);
						
						$itemsPriceData[] = array(
							"items_size_id" => $insertItemSize, 
							"price" => $itemPrice, 
							"date_transaction" => date("Y-m-d H:i:s"), 
							"transact_by" => ID, 
							"date_added" => date("Y-m-d H:i:s"), 
							"added_by" => ID, 
							"remarks" => "from insert new item"
						);
					}
				}
			}
		}
	}
	
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