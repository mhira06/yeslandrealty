<h4>Personal Information</h4>
<div class = "row">
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">First Name *</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_first_name" 
					id = "txt_users_first_name" 
					class = "form-control" 
					placeholder = "First Name" 
					value = "<?php echo $selectedFirstName; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Last Name *</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_last_name" 
					id = "txt_users_last_name" 
					class = "form-control" 
					placeholder = "Last Name"
					value = "<?php echo $selectedLastName; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Middle Name</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_middle_name" 
					id = "txt_users_middle_name" 
					class = "form-control" 
					placeholder = "Middle Name"
					value = "<?php echo $selectedMiddleName; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Suffix</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_suffix" 
					id = "txt_users_suffix" 
					class = "form-control" 
					placeholder = "Suffix"
					value = "<?php echo $selectedSuffix; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Birthday *</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_birthday" 
					id = "txt_users_birthday" 
					class = "form-control date" 
					data-toggle = "datetimepicker" 
					data-target-input="nearest"
					placeholder = "Birthday"
					value = "<?php echo $selectedBirthday; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Age</label>
			<div class = "col-sm-9">
				<input 
					type = "text" 
					name = "txt_users_age" 
					id = "txt_users_age" 
					class = "form-control" 
					placeholder = "Age" 
					disabled = "disable"
					value = "<?php echo $selectedAge; ?>">
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Picture</label>
			<div class = "col-sm-9">
				<div class = "input-group">
					<div class = "custom-file">
						<input 
							type = "file" 
							name = "fle_users_picture" 
							id = "fle_users_picture" 
							class = "custom-file-input"
							accept = "image/*">
						<input 
							type = "hidden" 
							name = "hdn_users_picture"
							id = "hdn_users_picture" 
							value = "<?php echo $selectedPicture; ?>">
						<label class = "custom-file-label" for = "fle_users_picture">Choose file</label>
					</div>
				</div>
			<?php
				if($selectedPicture != ""){
					$usersPictures = base_url($selectedPicture);
				?>
					<ul class = "mailbox-attachments d-flex align-items-stretch clearfix">
						<li>
							<span class = "mailbox-attachment-icon has-img">
								<img 
									src = "<?php echo $usersPictures; ?>" 
									alt = "Users Picture">
							</span>
						</li>
					</ul>
				<?php
				}
			?>
			</div>
		</div>
	</div>
	<div class = "col-sm-6">
		<div class = "form-group row">
			<label class = "col-sm-3 col-form-label">Signature</label>
			<div class = "col-sm-9">
				<div class = "input-group">
					<div class = "custom-file">
						<input 
							type = "file" 
							name = "fle_users_signature" 
							id = "fle_users_signature" 
							class = "custom-file-input"
							accept = "image/*">
						<input 
							type = "hidden" 
							name = "hdn_users_signature"
							id = "hdn_users_signature" 
							value = "<?php echo $selectedSignature; ?>">
						<label class = "custom-file-label" for = "fle_users_signature">Choose file</label>
					</div>
				</div>
			<?php
				if($selectedSignature != ""){
					$usersSignature = base_url($selectedSignature);
				?>
					<ul class = "mailbox-attachments d-flex align-items-stretch clearfix">
						<li>
							<span class = "mailbox-attachment-icon has-img">
								<img 
									src = "<?php echo $usersSignature; ?>" 
									alt = "Users Signature">
							</span>
						</li>
					</ul>
					
				<?php
				}
			?>
			</div>
		</div>
	</div>
</div>