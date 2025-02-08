<h4>Change Password</h4>
<form 
	name = "frm_change_password" 
	id = "frm_change_password" 
	class = "form-horizontal"
	method = "POST" 
	action = "<?php echo base_url("action/save_password.php");?>"
	autocomplete = "off">
	<div id = "div_result"></div>
	<div class = "form-group row">
		<label class="col-sm-2 col-form-label">Old Password</label>
		<div class = "col-sm-10">
			<input 
				type="password" 
				class="form-control" 
				id="txt_old_password" 
				name = "txt_old_password"
				placeholder="Old Password">
		</div>
	</div>
	<div class = "form-group row">
		<label class="col-sm-2 col-form-label">New Password</label>
		<div class = "col-sm-10">
			<input 
				type="password" 
				class="form-control" 
				id="txt_new_password" 
				name = "txt_new_password"
				placeholder="New Password">
		</div>
	</div>
	<div class = "form-group row">
		<label class="col-sm-2 col-form-label">Confirm New Password</label>
		<div class = "col-sm-10">
			<input 
				type="password" 
				class="form-control" 
				id="txt_confirm_password" 
				name = "txt_confirm_password"
				placeholder="Confirm New Password">
		</div>
	</div>
	<button 
		type = "submit" 
		id = "btn_save" 
		class = "btn btn-success">Save</button>
</form>