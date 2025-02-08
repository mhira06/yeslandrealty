<?php
	$userStatus = isset($userDetails["employment_status_desc"]) ? $userDetails["employment_status_desc"] : ""; 
?>
<fieldset>
<h4>Personal Details</h4>
<form 
	class = "form-horizontal"
	name = "frm_users_personal_details" 
	id = "frm_users_personal_details" 
	action = "<?php echo base_url("action/save_users_personal_details.php")?>" 
	method = "POST"
	autocomplete = "off">
<?php
	$function->display_flash();
?>
	<div class = "row">
		<div class = "col-md-6">
			<div class = "form-group row">
				<label class="col-sm-4 col-form-label"><?php
					echo $statusTitle
				?> Status</label>
				<div class = "col-sm-8">
					<div class = "form-control"><?php
						echo $userStatus;
					?></div>
				</div>
			</div>
		</div>
		<div class = "col-md-6">
			<div class = "form-group row">
				<label class="col-sm-4 col-form-label">Position</label>
				<div class = "col-sm-8">
					<div class = "form-control"><?php
						echo $usersPosition;
					?></div>
				</div>
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-6">
			<div class = "form-group row">
				<label class="col-sm-4 col-form-label"><?php
					echo $dateHiredTitle;
				?></label>
				<div class = "col-sm-8">
					<div class = "form-control"><?php
						echo $usersDateHired;
					?></div>
				</div>
			</div>
		</div>
		
		</form>
		
	<?php
		if($usersType == "Employee"){
			$rateValue = isset($userDetails["rate_value"]) ? $userDetails["rate_value"] : ""; 
		?>
			<div class = "col-md-6">
				<div class = "form-group row">
					<label class="col-sm-4 col-form-label">Rate</label>
					<div class = "col-sm-8">
						<div class = "form-control"><?php
							echo $rateValue;
						?></div>
					</div>
				</div>
			</div>
		<?php
		}
	?>
	</div>
	<br><h4>Contact Number</h4>
<?php
	//$usersContactNumberList = $select->get_active_users_contact_number(ID);
	$usersContactNumberList = $select->get_active_users_contact_number_display(ID);
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
	<br><h4>Address</h4>
<?php
	$usersAddress = $select->get_active_users_address_display(ID);
	$addressList = $select->get_active_address_list();
	if(!empty($addressList)){
		foreach($addressList as $adRows){
			$addressCode = $adRows["address_type_code"];
			$selectedAddressValue = isset($usersAddress[$adRows["address_type_desc"]]) ? $usersAddress[$adRows["address_type_desc"]] : "";
			$selectedNumber = "";
			$selectedStreet = "";
			$selectedBarangay = ""; 
			$selectedCity = "";
			$selectedProvince = "";
			$selectedCountry = "";
			$selectedZipCode = "";
			if($selectedAddressValue != ""){
				list($selectedNumber,
					$selectedStreet, 
					$selectedBarangay, 
					$selectedCity, 
					$selectedProvince, 
					$selectedCountry, 
					$selectedZipCode) = explode("-x-", $selectedAddressValue);
			}
		?>
			<div class = "row">
				<div class = "col-sm-12">
					<div class = "form-group">
						<label class = "col-form-label"><?php
							echo $adRows["address_type_desc"];
						?></label>
						<div class = "address-input">
							<div class = "row">
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Number</label>
										<div class = "input col-sm-9 col-md-8">
											<input 
												type = "text" 
												name = "txt_users_number_<?php echo $addressCode;?>_address" 
												id = "txt_users_number_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Number"
												value = "<?php echo $selectedNumber; ?>">
										</div>
									</div>
								</div>
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Street</label>
										<div class = "input col-sm-9 col-md-8">
											<input 
												type = "text" 
												name = "txt_users_street_<?php echo $addressCode;?>_address" 
												id = "txt_users_street_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Street"
												value = "<?php echo $selectedStreet; ?>">
										</div>
									</div>
								</div>
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Brgy</label>
										<div class = "col-sm-9 col-md-8 input">
											<input 
												type = "text" 
												name = "txt_users_barangay_<?php echo $addressCode;?>_address" 
												id = "txt_users_barangay_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Barangay"
												value = "<?php echo $selectedBarangay; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class = "row">
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">City</label>
										<div class = "col-sm-9 col-md-8 input">
											<input 
												type = "text" 
												name = "txt_users_city_<?php echo $addressCode;?>_address" 
												id = "txt_users_city_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "City"
												value = "<?php echo $selectedCity; ?>">
										</div>
									</div>
								</div>
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Province</label>
										<div class = "col-sm-9 col-md-8 input">
											<input 
												type = "text" 
												name = "txt_users_province_<?php echo $addressCode;?>_address" 
												id = "txt_users_province_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Province"
												value = "<?php echo $selectedProvince; ?>">
										</div>
									</div>
								</div>
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Country</label>
										<div class = "col-sm-9 col-md-8 input">
											<input 
												type = "text" 
												name = "txt_users_country_<?php echo $addressCode;?>_address" 
												id = "txt_users_country_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Country"
												value = "<?php echo $selectedCountry; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class = "row">
								<div class = "col-sm-4">
									<div class = "form-group row">
										<label class = "col-sm-3 col-md-4 col-form-label">Zip code</label>
										<div class = "col-sm-9 col-md-8 input">
											<input 
												type = "text" 
												name = "txt_users_zip_code_<?php echo $addressCode;?>_address" 
												id = "txt_users_zip_code_<?php echo $addressCode;?>_address" 
												class = "form-control" 
												placeholder = "Zip Code"
												value = "<?php echo $selectedZipCode; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
?>
	<button 
		type = "submit" 
		id = "btn_save_personal_details" 
		class = "btn btn-success">Save</button>
</form>