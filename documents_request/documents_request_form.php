<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Form</h3>
	</div>
	<form 
		name = "frm_documents_request" 
		id = "frm_documents_request" 
		method = "POST" 
		action = "<?php echo base_url("action/save_documents_request.php");?>">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
		?>
			<div class = "form-group">
				<label class = "control-label">Document Type</label>
				<div class = "input">
				<?php
					$documentTypeRequestList = $select->get_active_documents_type_list();
				?>
					<select 
						name = "slt_documents_request_document_type" 
						id = "slt_documents_request_document_type" 
						class = "form-control select" 
						style = "width : 100%">
						<option value = "">--Please select--</option>
					<?php
						if(!empty($documentTypeRequestList)){
							foreach($documentTypeRequestList as $dRows){
							?>
								<option value = "<?php echo $dRows["documents_type_id"]; ?>"><?php
									echo $dRows["documents_type_desc"];
								?></option>
							<?php
							}
						}
					?>
					</select>
				</div>
			</div>
			<div class = "form-group">
				<label class = "control-label">Other Document</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_documents_request_other_document" 
						id = "txt_documents_request_other_document" 
						class = "form-control">
				</div>
			</div>
			
			<div class = "form-group">
				<label class = "control-label">Date Need</label>
				<div class = "input">
					<input 
						type = "text" 
						name = "txt_documents_request_date_need" 
						id = "txt_documents_request_date_need" 
						class = "form-control date"
						data-toggle = "datetimepicker" 
						data-target-input="nearest">
				</div>
			</div>
			
			<div class = "form-group">
				<label class = "control-label">Purpose</label>
				<div class = "input">
					<textarea 
						name = "txtarea_document_request_purpose" 
						id = "txtarea_document_request_purpose" 
						class = "form-control"
						rows = "4"></textarea>
				</div>
			</div>
		</div>
		<div class = "card-footer">
			<button 
				type = "submit" 
				id = "btn_submit" 
				class = "btn btn-flat btn-success">Submit</button>
		</div>
	</form>
	
</div>