<?php
	$selectedStartDate = date("Y-m-01");
	$selectedEndDate = date("Y-m-d");
?>
<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Search Form</h3>
	</div>
	<form 
		name = "frm_search_leave" 
		id = "frm_search_leave" 
		method = "POST"
		action = "<?php echo base_url("action/search_leave.php");?>">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "row">
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Date Start</label>
						<div class = "input">
							<input 
								name = "txt_search_leave_date_start" 
								id = "txt_search_leave_date_start" 
								class = "form-control date" 
								value = "<?php echo $selectedStartDate; ?>"
								data-toggle = "datetimepicker" 
								data-target-input="nearest">
						</div>
					</div>
				</div>
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Date End</label>
						<div class = "input">
							<input 
								name = "txt_search_leave_date_end" 
								id = "txt_search_leave_date_end" 
								class = "form-control date" 
								value = "<?php echo $selectedEndDate; ?>"
								data-toggle = "datetimepicker" 
								data-target-input="nearest">
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
				class = "btn btn-flat btn-danger cancel_search"
				data-page = "<?php echo $page; ?>">Cancel</button>
			<a 
				class = "btn btn-flat btn-info" 
				href = "<?php echo base_url("pages/display/leave.php?action=add");?>">Request Leave</a>
		</div>
	</form>
</div>