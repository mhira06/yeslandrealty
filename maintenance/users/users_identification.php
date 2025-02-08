<?php
	$usersGovernmentList = $selectedId != "" ? $select->get_active_users_government_id($selectedId)  : array();
?>
<h4>Government ID</h4>
<?php
	$governmentIdList = $select->get_active_government_id();
	if(!empty($governmentIdList)){
		foreach($governmentIdList as $govRows){
			$govIdCode = $govRows["identification_code"];
			$govIdDesc = $govRows["identification_desc"];
			$govIdValue = isset($usersGovernmentList[$govIdDesc]) ? $usersGovernmentList[$govIdDesc] : "";
		?>
			<div class = "row">
				<div class = "col-sm-6">
					<div class = "form-group row">
						<label class = "col-sm-3 col-form-label"><?php
							echo $govRows["identification_desc"];
						?></label>
						<div class = "col-sm-9">
							<input 
								type = "text" 
								name = "txt_users_<?php echo $govIdCode;?>_number" 
								id = "txt_users_<?php echo $govIdCode;?>_number" 
								class = "form-control" 
								placeholder = "<?php echo $govRows["identification_desc"]; ?>" 
								value = "<?php echo $govIdValue; ?>">
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
	$usersProfessionalIdList = $selectedId != "" ? $select->get_active_users_professional_id($selectedId) : array();
	//$function->echo_array($usersProfessionalIdList);
?>
<h4>Professional ID</h4>
<?php
	$professionalIdList = $select->get_active_professional_id();
	if(!empty($professionalIdList)){
		foreach($professionalIdList as $proRows){
			$proIdCode = $proRows["identification_code"];
			$proIdName = $proRows["identification_desc"];
			$proIdValue = isset($usersProfessionalIdList[$proIdName]) ? $usersProfessionalIdList[$proIdName] : "";
		?>
			<div class = "row">
				<div class = "col-sm-6">
					<div class = "form-group row">
						<label class = "col-sm-3 col-form-label"><?php
							echo $proRows["identification_desc"];
						?></label>
						<div class = "col-sm-9">
							<input 
								type = "text" 
								name = "txt_users_<?php echo $proIdCode;?>_number" 
								id = "txt_users_<?php echo $proIdCode;?>_number" 
								class = "form-control" 
								placeholder = "<?php echo $proRows["identification_desc"]; ?>"
								value = "<?php echo $proIdValue; ?>">
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
?>