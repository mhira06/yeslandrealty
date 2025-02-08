<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Items Form</h3>
	</div>
	<form 
		name = "frm_items" 
		id = "frm_items" 
		action = "<?php echo base_url("action/save_items.php");?>" 
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
								name = "slt_items_type" 
								id = "slt_items_type" 
								class = "form-control select" 
								style = "width:100%">
							<?php
								if(!empty($itemsTypeList)){
									foreach($itemsTypeList as $itRows){
									?>
										<option value = "<?php echo $itRows["items_type_id"]?>"><?php
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
							<input 
								type = "text" 
								name = "txt_items_name" 
								id = "txt_items_name" 
								class = "form-control">
						</div>
					</div>
				</div>
			</div>
			
			<div class = "row">
				<input 
					type = "hidden" 
					name = "hdn_items_colors_count" 
					id = "hdn_items_colors_count" 
					value = "<?php echo $itemsColorCount; ?>">
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
						$itemsColorForm = root_url("pages/loads/load_items_color.php");
						include($itemsColorForm);
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