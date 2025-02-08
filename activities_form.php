<div class = "card card-default">
	<form 
		name = "frm_activities" 
		id = "frm_activities" 
		method = "POST" 
		action = "<?php echo base_url("action/save_activities.php");?>" 
		autocomplete = "off">
		<div class = "card-header">
			<h3 class = "card-title">Form</h3>
		</div>
		<input 
			type = "hidden" 
			name = "hdn_activities_id" 
			id = "hdn_activities_id" 
			value = "<?php echo $selectedId; ?>">
		<input 
			type = "hidden" 
			name = "hdn_activities_action" 
			id = "hdn_activities_action" 
			value = "<?php echo $selectedAction; ?>">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "form-group">
				<label class = "control-label">Title</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_activities_title" 
						id = "txt_activities_title" 
						class = "form-control"
						value = "<?php echo $selectedTitle; ?>">
				</div>
			</div>
			
			<div class = "form-group">
				<label class = "control-label">Description</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_activities_desc" 
						id = "txt_activities_desc" 
						class = "form-control" 
						value = "<?php echo $selectedDesc; ?>">
				</div>
			</div>
			
			<div class = "form-group">
				<label class = "control-label">Location</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_activities_location" 
						id = "txt_activities_location" 
						class = "form-control"
						value = "<?php echo $selectedLocation; ?>">
				</div>
			</div>
			
			<div class = "form-group">
				<label class = "control-label">Date</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_activities_dates" 
						id = "txt_activities_dates" 
						class = "form-control range_date"
						value = "<?php echo $defaultDate; ?>">
				</div>
			</div>
			<div class = "form-group">
				<label class = "control-label">Target Attendees</label>
				<div class = "input">
				<?php
					$positionList = $select->get_active_positions_list();
				?>
					<select 
						name = "slt_activities_attendees[]" 
						id = "slt_activities_attendees" 
						class = "form-control select"
						style = "width:100%"
						multiple = "multiple">
					<?php
						$selected = "";
						foreach($positionList as $pRows){
							$selected = in_array($pRows["positions_id"], $selectedTargetAttendees) ? "selected" : "";
						?>
							<option value = "<?php echo $pRows["positions_id"]; ?>" <?php echo $selected; ?>><?php
								echo $pRows["positions_desc"];
							?></option>
						<?php
						}
					?>
					</select>
				</div>
			</div>
			<div class = "form-group">
				<label class = "control-label">Registration End</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_activities_date_end" 
						id = "txt_activities_date_end" 
						class = "form-control date" 
						value = "<?php echo $selectedDateRegistrationEnd; ?>"
						data-toggle = "datetimepicker" 
						data-target-input="nearest">
				</div>
			</div>
		<?php
			if($selectedId != ""){
			?>
				<div class = "form-group">
					<label class = "control-label">Status</label>
					<div class = "input">
					<?php
						$statusList = $select->get_activities_status();
					?>
						<select 
							name = "slt_activities_status" 
							id = "slt_activities_status" 
							class = "form-control select"
							style = "width:100%">
						<?php
							$selected = "";
							foreach($statusList as $sRows){
								$selected = $sRows["status_id"] == $selectedStatus ? "selected" : "";
							?>
								<option value = "<?php echo $sRows["status_id"]; ?>" <?php echo $selected; ?>><?php
									echo $sRows["status_desc"];
								?></option>
							<?php
							}
						?>
						</select>
					</div>
				</div>
				<div class = "form-group">
					<label class = "control-label">Remarks</label>
					<div class = "input">
						<textarea 
							name = "txtarea_activities_remarks" 
							id = "txtarea_activities_remarks" 
							class = "form-control"
							rows = "4"><?php
								echo $selectedRemarks;
							?></textarea>
					</div>
				</div>
			<?php
			}
		?>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_save" 
				class = "btn btn-flat btn-success">Save</button>
		<?php
			if($selectedId != ""){
			?>
				<a href = "<?php echo base_url("pages/administration/manage_activities.php");?>" 
					class = "btn btn-flat btn-primary">Create Activities</a>
				<a href = "<?php echo base_url("pages/administration/manage_activities.php?id=".$selectedId."&action=results");?>" 
					class = "btn btn-flat btn-warning">View Result</a>
			<?php
			}
		?>
		</div>
	</form>
</div>