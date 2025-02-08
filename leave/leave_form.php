<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Form</h3>
	</div>
	<form 
		name = "frm_request_leave" 
		id = "frm_request_leave" 
		method = "POST" 
		action = "<?php echo base_url("action/save_leave_request.php");?>">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "row">
				<div class = "col-sm-12">
					<div class = "form-group">
						<label class = "control-label">Leave Type</label>
						<div class = "input">
						<?php
							$leaveTypeList = $select->get_users_leave_credit_list(ID);
						?>
							<select 
								name = "slt_leave_type" 
								id = "slt_leave_type"
								class = "form-control select" 
								style = "width:100%">
								<option value = "">--Please select--</option>
							<?php
								if(!empty($leaveTypeList)){
									foreach($leaveTypeList as $lRows){
									?>
										<option value = "<?php echo $lRows["users_leave_credit_id"]?>"><?php
											echo $lRows["leave_type_desc"];
										?></option>
									<?php
									}
								}
							?>
							</select>
						</div>
					</div>
				</div>
				<div class = "col-sm-12">
					<div class = "form-group">
						<label class = "control-label">Date</label>
						<div class = "input">
							<input 
								type = "text" 
								name = "txt_leave_date" 
								id = "txt_leave_date" 
								class = "form-control range_date">
						</div>
					</div>
				</div>
				<div class = "col-sm-12">
					<div class = "form-group">
						<label class = "control-label">Reason</label>
						<div class = "input">
							<textarea 
								name = "txtarea_leave_reason"
								id = "txtarea_leave_reason"
								rows= "4" 
								class = "form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_save" 
				class = "btn btn-flat btn-primary">Save</button>
			<a href = "<?php echo base_url("pages/display/leave.php");?>" 
				class = "btn btn-flat btn-danger">Back</a>
		</div>
	</form>
</div>