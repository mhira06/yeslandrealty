<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Search</h3>
	</div>
	<form 
		name = "frm_search_online_ordering"
		id = "frm_search_online_ordering" 
		method = "POST" 
		action = "<?php echo base_url("action/search_online_ordering.php");?>">
	<?php
		echo $function->display_flash();
	?>
		<input 
			type = "hidden" 
			name = "hdn_search_action" 
			id = "hdn_search_action" 
			value = "<?php echo $action;?>">
		<div class = "card-body">
			<div class = "row">
				<?php
				switch($action){
					case "view_orders":
					case "manage_online_ordering":
					?>
						<div class = "col-md-4">
							<div class = "form-group">
								<label class = "control-label">Date Ordered</label>
								<div class = "input">
									<input 
										type = "text" 
										name = "txt_search_date_ordered" 
										id = "txt_search_date_ordered" 
										class = "form-control range_date"
										value = "<?php echo $defaultDate; ?>">
								</div>
							</div>
						</div>
					<?php
					break;
					default:
					?>
						<div class = "col-md-4">
							<div class = "form-group">
								<label class = "control-label">Type</label>
								<div class = "input">
								<?php
									$itemsTypeList = $select->get_active_items_type_list();
								?>
									<select 
										name = "slt_online_ordering_type[]" 
										id = "slt_online_ordering_type" 
										class = "form-control select" 
										style = "width:100%"
										multiple = "multiple">
									<?php
										if(!empty($itemsTypeList)){
											$selected = "";
											foreach($itemsTypeList as $iRows){
												$selected = in_array($iRows["items_type_id"], $selectedItemType) ? "selected" : "";
											?>
												<option value = "<?php echo $iRows["items_type_id"]; ?>" <?php echo $selected; ?>><?php
													echo $iRows["items_type_desc"];
												?></option>
											<?php
											}
										}
									?>
									<select>
								</div>
							</div>
						</div>
					<?php
					break;
				}
			?>
			</div>
		</div>
		
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_search" 
				class = "btn btn-flat btn-success">Search</button>
			<button 
				type = "button" 
				id = "btn_show_all" 
				class = "btn btn-flat btn-danger cancel_search_2"
				data-session = "<?php echo $pageAction; ?>">Show All</button>
		<?php
			if($action != "manage_online_ordering"){
			?>
				<a href = "<?php echo base_url("pages/display/online_ordering.php?action=invoice"); ?>"
					class = "btn btn-flat bg-warning">
					<i class = "fa fa-cart-plus"></i>
					Cart
					<span class = "badge bg-info"><?php
						echo $pendingCount;
					?></span>
				</a>
			<?php
			}
			if($action == "" || ($action != "manage_online_ordering" && $action != "view_orders")){
			?>
				<a href = "<?php echo base_url("pages/display/online_ordering.php?action=view_orders"); ?>" 
					class = "btn btn-flat btn-info">
					View Orders
				</a>
			<?php
			}
			
			if($action == "view_orders"){
			?>
				<a href = "<?php echo base_url("pages/display/online_ordering.php"); ?>" 
					class = "btn btn-flat btn-info">
					Go back in ordering
				</a>
			<?php
			}
		?>
		</div>
	</form>
</div>