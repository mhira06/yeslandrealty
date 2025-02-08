<?php
	$usersContactNumberList = $selectedId != "" ? $select->get_active_users_contact_number_display($selectedId) : array();
	//$function->echo_array($usersContactNumberList);
?>
<h4>Contact Number</h4>
<?php
	$contactNumberList = $select->get_active_contact_numbers_list();
	if(!empty($contactNumberList)){
		foreach($contactNumberList as $cnRows){
			$contactCode = $cnRows["contact_number_type_code"];
			$contactNumberValue = isset($usersContactNumberList[$cnRows["contact_number_type_desc"]]) ? $usersContactNumberList[$cnRows["contact_number_type_desc"]] : "";
		?>
			<div class = "row">
				<div class = "col-sm-6">
					<div class = "form-group row">
						<label class = "col-sm-3 col-form-label"><?php
							echo $cnRows["contact_number_type_desc"];
						?></label>
						<div class = "col-sm-9">
							<input 
								type = "text" 
								name = "txt_users_<?php echo $contactCode;?>_number" 
								id = "txt_users_<?php echo $contactCode;?>_number" 
								class = "form-control" 
								placeholder = "<?php echo $cnRows["contact_number_type_desc"]; ?>"
								value = "<?php echo $contactNumberValue; ?>">
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
?>