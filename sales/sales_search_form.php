<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">Search Form <?php echo ($summaryDesc != "" ? "(".$summaryDesc.")" : "");?></h3>
	</div>
	<form 
		name = "frm_sales_search" 
		id = "frm_sales_search" 
		action = "<?php echo base_url("action/search_sales.php");?>" 
		method = "POST">
		<input
			type = "hidden" 
			name = "hdn_sales_action"
			id = "hdn_sales_action" 
			value = "<?php echo $pageAction; ?>">
		<div class = "card-body">
		<?php
			echo $function->display_flash();
			//$function->echo_array($session);
		?>
			<div class = "row">
				<div class = "col-md-4">
					<div class = "form-group">
						<label class = "control-label">Date Reserve</label>
						<div class = "input">
							<input 
								type = "text" 
								name = "txt_sales_date_reserve" 
								id = "txt_sales_date_reserve" 
								class = "form-control range_date"
								value = "<?php echo $defaultDate; ?>">
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
				id = "btn_cancel_search" 
				class = "btn btn-flat btn-danger cancel_search_2"
				data-session = "<?php echo $pageAction; ?>">Cancel</button>
			<button 
				type = "button" 
				id = "btn_download" 
				class = "btn btn-flat btn-warning">Download</button>
		<?php
			if($page == "manage_sales"){
			?>
				<a href = "<?php echo base_url("pages/administration/manage_sales.php?action=add_sales");?>"
					class = "btn btn-flat btn-primary">Add Sales</a>
				<!--<button 
				type = "button" 
				id = "btn_import" 
				class = "btn btn-flat btn-info">Import</button>-->
			<?php
			}
		?>
		</div>
	</form>
</div>