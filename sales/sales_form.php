<div class = "card card-default">
	<form 
		name = "frm_add_sales" 
		id = "frm_add_sales" 
		action = "<?php echo base_url("action/".$formAction);?>" 
		method = "POST"
		autocomplete = "off">
		<input 
			type = "hidden" 
			name = "hdn_sales_id" 
			id = "hdn_sales_id" 
			value = "<?php echo $selectedSales; ?>">
		<div class = "card-header">
			<h3 class = "card-title">Sales Form</h3>
		</div>
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "row">
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Client</label>
						<div class = "input">
							<select 
								name = "slt_sales_client" 
								id = "slt_sales_client" 
								class = "form-control select" 
								style = "width:100%">
								<option value = "">--Please select--</option>
							<?php
								$selected = "";
								if(!empty($clientsList)){
									foreach($clientsList as $cRows){
										$selected = $cRows["clients_id"] == $selectedClient ? "selected" : "";
									?>
										<option value = "<?php echo $cRows["clients_id"];?>" <?php echo $selected; ?>><?php
											echo $cRows["full_name"];
										?></option>
									<?php
									}
								}
							?>
							</select>
						</div>
						<a href = "javascript:void(0)" id = "a_client" class = "btn btn-link">Add Client</a>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Project Name</label>
						<div class = "input">
							<input 
								type = "text"
								name = "txt_sales_project" 
								id = "txt_sales_project" 
								class = "form-control"
								value = "<?php echo $selectedProject; ?>">
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Location</label>
						<div class = "input">
							<input 
								type = "text"
								name = "txt_sales_location" 
								id = "txt_sales_location" 
								class = "form-control"
								value = "<?php echo $selectedLocation; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class = "row">
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Date Reservation</label>
						<div class = "input">
							<input 
								type = "text"
								name = "txt_sales_date_reservation"
								id = "txt_sales_date_reservation" 
								class = "form-control date"
								data-toggle = "datetimepicker" 
								data-target-input="nearest"
								value = "<?php echo $selectedDateReserve; ?>">
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Price</label>
						<div class = "input">
							<input 
								type = "text"
								name = "txt_sales_price" 
								id = "txt_sales_price" 
								class = "form-control"
								value = "<?php echo $selectedPrice; ?>">
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Quantity</label>
						<div class = "input">
							<input 
								type = "text"
								name = "txt_sales_quantity" 
								id = "txt_sales_quantity" 
								class = "form-control number_only"
								value = "<?php echo $selectedQuantity; ?>">
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Agent</label>
						<div class = "input">
							<select 
								name = "slt_sales_agent"
								id = "slt_sales_agent" 
								class = "form-control select" 
								style = "width:100%">
								<option value = "">--Please select--</option>
							<?php
								if(!empty($membersList)){
									$selected = "";
									foreach($membersList as $mRows){
										$selected = $mRows["users_id"] == $selectedAgent ? "selected" : "";
									?>
										<option value = "<?php echo $mRows["users_id"];?>" <?php echo $selected; ?>><?php
											echo $mRows["full_name"];
										?></option>
									<?php
									}
								}
							?>
							</select>
						</div>
					</div>
				</div>
			<?php
				if($pageAction == "update"){
				?>
					<div class = "col-md-4">
						<div class = "form-group">
							<label class = "control-label">Status</label>
							<div class = "input">
								<select 
									name = "slt_sales_status"
									id = "slt_sales_status" 
									class = "form-control select" 
									style = "width:100%">
									<option value = "">--Please select--</option>
								<?php
									if(!empty($statusList)){
										$selected = "";
										foreach($statusList as $staRows){
											$selected = $staRows["status_id"] == $selectedStatus ? "selected" : "";
										?>
											<option value = "<?php echo $staRows["status_id"];?>" <?php echo $selected; ?>><?php
												echo $staRows["status_desc"];
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
							<label class = "control-label">Remarks</label>
							<div class = "input">
								<textarea
									name = "txtarea_sales_remarks" 
									id = "txtarea_sales_remarks" 
									class = "form-control"
									rows = "4"></textarea>
							</div>
						</div>
					</div>
				<?php
				}
			?>
			</div>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_submit" 
				class = "btn btn-flat btn-success">Submit</button>
			<a href = "<?php echo base_url("pages/administration/manage_sales.php");?>" 
				class = "btn btn-flat btn-info">Back</a>
		</div>
	</form>
</div>