<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Items Form</h3>
	</div>
	<form 
		name = "frm_update_items" 
		id = "frm_update_items" 
		action = "<?php echo base_url("action/save_items_details.php");?>" 
		method = "POST" 
		autocomplete = "off" 
		enctype="multipart/form-data">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "row">
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Item Type</label>
						<div class = "input">
							<select 
								name = "slt_update_items_type" 
								id = "slt_update_items_type" 
								class = "form-control select" 
								style = "width:100%">
								<option value = "">--Please select--</option>
							<?php
								if(!empty($itemsTypeList)){
									$selected = "";
									foreach($itemsTypeList as $itRows){
										$selected = $itRows["items_type_id"] == $selectedItemType ? "selected" : "";
									?>
										<option value = "<?php echo $itRows["items_type_id"]?>" <?php echo $selected; ?>><?php
											echo $itRows["items_type_desc"];
										?></option>
									<?php
									}
								}
								
							?>
							</select>
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Item Name</label>
						<div class = "input">
							<select 
								name = "slt_update_items" 
								id = "slt_update_items" 
								class = "form-control select" 
								style = "width:100%">
								<option value = "">--Please select--</option>
							<?php
								if(!empty($itemsList)){
									$selected = "";
									foreach($itemsList as $iRows){
										$selected = $iRows["items_id"] == $selectedItem ? "selected" : "";
									?>
										<option value = "<?php echo $iRows["items_id"]?>" <?php echo $selected; ?>><?php
											echo $iRows["items_desc"];
										?></option>
									<?php
									}
								}
								
							?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class = "row">
				<input 
					type = "hidden" 
					name = "hdn_items_colors_count" 
					id = "hdn_items_colors_count" 
					value = "<?php echo $totalItemColorCount; ?>">
				<div class = "col-md-12">
					<label class = "control-label">
						Color
						<button 
							type = "button" 
							name = "btn_add_items_color" 
							id = "btn_add_items_color" 
							class = "btn btn-flat btn-success">Add</button>
						<button 
							type = "button" 
							name = "btn_remove_items_color" 
							id = "btn_remove_items_color" 
							class = "btn btn-flat btn-danger">Remove</button>
					</label>
					<div id = "div_items_color">
					<?php
						if(!empty($itemsColorList)){
							//$function->echo_array($itemsColorList);
							$itemsColorCount = 1;
							foreach($itemsColorList as $icoRows){
								$itemsColorId = $icoRows["items_colors_id"];
								$selectedColor = $icoRows["colors_id"];
								$selectedImage = $icoRows["image"];
								$itemsSizeInput = $select->get_active_items_size_input($itemsColorId);
								$selectedSize = isset($itemsSizeInput["sizes_list"]) && $itemsSizeInput["sizes_list"] != "" ? explode(",", $itemsSizeInput["sizes_list"]) : array();
								$selectedItemSize = isset($itemsSizeInput["item_sizes_list"]) && $itemsSizeInput["item_sizes_list"] != "" ? explode(",", $itemsSizeInput["item_sizes_list"]) : array();
								$itemsSizeList = $select->generate->array_to_in($selectedItemSize);
								
								$itemStockCondition = "isi.items_size_id in ('".$itemsSizeList."')";
								$itemStockList = $select->get_active_items_stock_list("", $itemStockCondition);
								
								//$function->echo_array($itemStockList);
								$itemsColorForm = root_url("pages/loads/load_items_color.php");
								include($itemsColorForm);
								$itemsColorCount++;
							}
						}
						
					?>
					</div>
				</div>
			</div>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_submit" 
				class = "btn btn-flat btn-success">Submit</button>
			<a href = "<?php echo base_url("pages/maintenance/items.php");?>" 
				class = "btn btn-flat btn-danger">Back</a>
		</div>
	</form>
</div>
	