<?php
	$rootFolder = $_SERVER['DOCUMENT_ROOT']."/ylr_portal";
	include($rootFolder."/classes/functions.php");
	$function = new Functions();
	$generate = new Generate();
	
	$alert = "";
	$message = "";
	$searchCondition = "";
	$sessionArray = array();
	
	$redirectPage = "pages/maintenance/items.php";
	$sessionName = "items";
	
	$selectedItemType = $function->post("slt_items_type");
	$selectedItem = $function->post("slt_item_names");
	$selectedColor = $function->post("slt_items_color");
	$selectedSize = $function->post("slt_items_size");
	
	
	if($selectedItemType != "" && !empty($selectedItemType)){
		$itemTypeList = $generate->array_to_in($selectedItemType);
		$itemTypeCondition = "it.items_type_id in ('".$itemTypeList."')";
		$searchCondition .= ($searchCondition != "" ? " and " : "").$itemTypeCondition;
		$sessionArray += array(
			"items_type" => $selectedItemType
		);
	}
	
	if($selectedItem != "" && !empty($selectedItem)){
		$itemsList = $generate->array_to_in($selectedItemType);
		$itemsCondition = "i.items_id in ('".$itemsList."')";
		$searchCondition .=  ($searchCondition != "" ? " and " : "").$itemsCondition;
		$sessionArray += array(
			"items" => $selectedItem
		);
	}
	
	if($selectedColor != "" && !empty($selectedColor)){
		$colorsList = $generate->array_to_in($selectedColor);
		$colorsCondition = "co.colors_id in ('".$colorsList."')";
		$searchCondition .=  ($searchCondition != "" ? " and " : "").$colorsCondition;
		$sessionArray += array(
			"colors" => $selectedColor
		);
	}
	
	if($selectedSize != "" && !empty($selectedSize)){
		$sizesList = $generate->array_to_in($selectedSize);
		$sizesCondition = "si.sizes_id in ('".$sizesList."')";
		$searchCondition .=  ($searchCondition != "" ? " and " : "").$sizesCondition;
		$sessionArray += array(
			"sizes" => $selectedSize
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