<form 
	name = "frm_order_items" 
	id = "frm_order_items" 
	action = "<?php echo base_url("action/save_order.php"); ?>"
	method = "POST">
	<input 
		type = "hidden" 
		name = "hdn_items_id" 
		id = "hdn_items_id" 
		value = "<?php echo $selectedItems; ?>">
	<input 
		type = "hidden" 
		name = "hdn_items_stock_id" 
		id = "hdn_items_stock_id" 
		value = "">
	<input 
		type = "hidden" 
		name = "hdn_items_colors_id" 
		id = "hdn_items_colors_id" 
		value = "">
	<input 
		type = "hidden" 
		name = "hdn_items_sizes_id" 
		id = "hdn_items_sizes_id" 
		value = "">
	<input 
		type = "hidden" 
		name = "hdn_items_available_stock" 
		id = "hdn_items_available_stock" 
		value = "">
	<div class="card card-solid">
		<div class="card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class="row">
			
				<div class="col-12 col-sm-6">
					<h3 class="d-inline-block d-sm-none"><?php
						echo $itemsDetails["items_desc"];
					?></h3>
					<div class="col-12">
						<img id = "img_items" src="<?php echo $itemsImageUrl; ?>" class="product-image" alt="Items Image">
					</div>
				</div>
				<div class="col-12 col-sm-6">
					<h3 class="my-3"><?php
						echo $itemsDetails["items_desc"];
					?></h3>
					<p><?php
						echo $itemsDetails["items_type_desc"];
					?></p>
					<hr>
					<h4>Available Colors</h4>
					<div class="btn-group btn-group-toggle" data-toggle="buttons"><?php
						$availableColors = $itemsDetails["colors_value_list"];
						$availableColorsList = $availableColors != "" ? explode(",", $availableColors) : array();
						if(!empty($availableColorsList)){
							foreach($availableColorsList as $aRows){
								list($colorsDesc, $itemsColorId) = explode("-x-", $aRows);
							?>
								<label class="btn btn-default text-center color_label">
									<input 
										type="radio" 
										name="rdo_items_color_option" 
										id="rdo_items_color_option_<?php echo $itemsColorId; ?>" 
										value = "<?php echo $itemsColorId; ?>"
										class = "available_color"
										autocomplete="off" ><?php
											echo $colorsDesc
										?>
								</label>
							<?php
							}
						}
					?></div>
					<h4 class="mt-3">Size 
						<small>Please select one</small>
					</h4>
					<div id = "div_items_sizes">
					<?php
						$availableSizes = $itemsDetails["sizes_value_list_raw"];
						$availableItemsSize = root_url("pages/loads/available_items_sizes.php");
						include($availableItemsSize);
					?>
					</div>
					<h4 class="mt-3">
						Available Stock : 
						<span id = "spn_available"><?php 
							echo $itemsDetails["available_stock"]; 
						?></span>
					</h4>
					
					<div class="bg-gray py-2 px-3 mt-4">
						<h2 class="mb-0" id = "h_price">₱ <?php echo $itemsDetails["price"];?></h2>
					</div>
					<div class = "form-group">
						<h4 class="mt-3">Quantity : </h4>
						<div class = "input">
							<input 
								type = "text" 
								name = "txt_order_quantity" 
								id = "txt_order_quantity" 
								class = "form-control number_only"
								value = "1">
						</div>
					</div>
					<div class="mt-4">
						<button 
							type = "button" 
							class="btn btn-primary btn-lg btn-flat"
							id = "btn_add_to_cart">
							Add to Cart
						</button>

						<button 
							type = "submit" 
							class="btn btn-success btn-lg btn-flat"
							id = "btn_checkout">
							Checkout
						</button>
						
						<a href = "<?php echo base_url("pages/display/online_ordering.php"); ?>"
							class="btn btn-warning btn-lg btn-flat">
							Choose Another Item
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</form>
