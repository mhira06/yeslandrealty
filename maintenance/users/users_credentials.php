<h4>Login Credentials</h4>
<div class = "row">
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Login Type *</label>
			<div class = "col-sm-9">
			<?php
				$loginTypeList = $select->get_active_login_type_list();
			?>
				<select 
					name = "slt_users_login_type" 
					id = "slt_users_login_type" 
					class = "form-control select" 
					style = "width: 100%">
					<option value = "">--Please select--</option>
				<?php
					if(!empty($loginTypeList)){
						$selected = "";
						foreach($loginTypeList as $ltRows){
							$selected = $ltRows["login_type_id"] == $selectedLoginType ? "selected" : "";
						?>
							<option value = "<?php echo $ltRows["login_type_id"]; ?>" <?php echo $selected; ?>><?php
								echo $ltRows["login_type_desc"];
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
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Username</label>
			<div class = "col-sm-9">
				<input 
					type = "text"
					name = "txt_users_name" 
					id = "txt_users_name" 
					class = "form-control" 
					placeholder = "Username"
					disabled = "disabled"
					value = "<?php echo $selectedUserNumberDisplay; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Password *</label>
			<div class = "col-sm-9">
				<input 
					type = "password"
					name = "txt_users_password" 
					id = "txt_users_password" 
					class = "form-control" 
					placeholder = "Password">
			</div>
		</div>
	</div>
</div>