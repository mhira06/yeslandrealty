<?php
	$usersAddress = $selectedId != "" ? $select->get_active_users_address_display($selectedId) : array();
	//$function->echo_array($usersAddress);
?>
<h4>Address</h4>
<?php
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Number</label>
										<div class = "input col-9">
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Street</label>
										<div class = "input col-9">
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Barangay</label>
										<div class = "col-9 input">
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">City</label>
										<div class = "col-9 input">
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
							</div>
							<div class = "row">
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Province</label>
										<div class = "col-9 input">
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Country</label>
										<div class = "col-9 input">
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
								<div class = "col-sm-3">
									<div class = "form-group row">
										<label class = "col-3 col-form-label">Zip code</label>
										<div class = "col-9 input">
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