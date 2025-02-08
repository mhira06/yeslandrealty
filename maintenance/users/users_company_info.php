<h4>Company Info</h4>
<div class = "row">
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">User Type *</label>
			<div class = "col-sm-9">
			<?php
				$usersTypeList = $select->get_active_users_type_list();
				$disabled = $selectedId != "" ? "disabled = 'disabled'" : "";
			?>
				<select 
					name = "slt_users_type" 
					id = "slt_users_type" 
					class = "form-control select"
					style = "width:100%"
					<?php echo $disabled; ?>>>
					<option value = "">--Please--</option>
				<?php
					if(!empty($usersTypeList)){
						$selected = "";
						foreach($usersTypeList as $utRows){
							$selected = $selectedUserType == $utRows["users_type_id"] ? "selected" : "";
						?>
							<option value = "<?php echo $utRows["users_type_id"]; ?>" <?php echo $selected; ?>><?php
								echo $utRows["users_type_desc"];
							?></option>
						<?php
						}
					}
				?>
				</select>
				<input 
					type = "hidden" 
					name = "hdn_user_type" 
					id = "hdn_user_type" 
					value = "<?php echo $selectedUserType; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Users Number</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_number" 
					id = "txt_users_number" 
					class = "form-control" 
					placeholder = "Users Number" 
					disabled = "disabled"
					value = "<?php echo $selectedUserNumberDisplay; ?>">
				<input 
					type = "hidden" 
					name = "hdn_users_number" 
					id = "hdn_users_number" 
					value = "<?php echo $selectedUserNumber; ?>">
			</div>
		</div>
	</div>
</div>
<div id = "div_another_company_info">
<?php
	$usersCompanyDetails = root_url("pages/loads/users_company_details.php");
	include($usersCompanyDetails);
?>
</div>