<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Search Form</h3>
	</div>
	<form 
		name = "frm_items_search" 
		id = "frm_items_search" 
		method = "POST" 
		action = "<?php echo base_url("action/search_items.php");?>"
		autocomplete = "off">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "row">
				<div class = "col-md-3">
					<div class = "form-group">
						<label class = "control-label">Item Type</label>
						<div class = "input">
							<select 
								name = "slt_items_type[]" 
								id = "slt_items_type" 
								class = "form-control select" 
								multiple = "multiple"
								style = "width:100%">
							<?php
								if(!empty($itemsTypeList)){
									$selected = "";
									foreach($itemsTypeList as $itRows){
										$selected = in_array($itRows["items_type_id"], $selectedItemsType) ? "selected" : "";
									?>
										<option value = "<?php echo $itRows["items_type_id"]; ?>" <?php echo $selected; ?>><?php
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
				<div class = "col-md-3">
					<div class = "form-group">
						<label class = "control-label">Item Name</label>
						<div class = "input">
							<select 
								name = "slt_item_names[]" 
								id = "slt_item_names" 
								class = "form-control select" 
								multiple = "multiple"
								style = "width:100%">
							<?php
								if(!empty($itemsList)){
									$selected = "";
									foreach($itemsList as $iRows){
										$selected = in_array($iRows["items_id"], $selectedItems) ? "selected" : "";
									?>
										<option value = "<?php echo $iRows["items_id"]; ?>" <?php echo $selected; ?>><?php
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
				<div class = "col-md-3">
					<div class = "form-group">
						<label class = "control-label">
							Color 
							
						</label>
						<div class = "input">
							<select 
								name = "slt_items_color[]" 
								id = "slt_items_color" 
								class = "form-control select" 
								multiple = "multiple"
								style = "width:100%">
							<?php
								if(!empty($colorList)){
									$selected = "";
									foreach($colorList as $cRows){
										$selected = in_array($cRows["colors_id"], $selectedColors) ? "selected" : "";
									?>
										<option value = "<?php echo $cRows["colors_id"]; ?>" <?php echo $selected; ?>><?php
											echo $cRows["colors_desc"];
										?></option>
									<?php
									}
								}
							?>
							</select>
						</div>
					</div>
				</div>
				<div class = "col-md-3">
					<div class = "form-group">
						<label class = "control-label">Size</label>
						<div class = "input">
							<select 
								name = "slt_items_size[]" 
								id = "slt_items_size" 
								class = "form-control select" 
								multiple = "multiple"
								style = "width:100%">
							<?php
								if(!empty($sizesList)){
									$selected = "";
									foreach($sizesList as $sRows){
										$selected = in_array($sRows["sizes_id"], $selectedSize) ? "selected" : "";
									?>
										<option value = "<?php echo $sRows["sizes_id"]; ?>" <?php echo $selected; ?>><?php
											echo $sRows["sizes_desc"];
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
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_search" 
				class = "btn btn-flat btn-success">Search</button>
			<button 
				type = "button" 
				id = "btn_cancel" 
				class = "btn btn-flat btn-danger cancel_search_2"
				data-session = "items">Show All</button>
			<a href = "<?php echo base_url("pages/maintenance/items.php?action=add_item");?>" class = "btn btn-flat btn-primary">Add Item</a>
			<a href = "<?php echo base_url("pages/maintenance/items.php?action=update_items");?>" class = "btn btn-flat btn-info">Update Item Color & Size</a>
		</div>
	</form>
	
</div>