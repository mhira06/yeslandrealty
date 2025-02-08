<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
	<?php
		if($page == "leave"){
		?>
			<div class = "card-tools">
				<button 
					type = "button" 
					name = "btn_cancel_leave" 
					id = "btn_cancel_leave" 
					class = "btn btn-flat btn-warning">Cancel</button> 
				<button 
					type = "button" 
					name = "btn_submit_pending" 
					id = "btn_submit_pending" 
					class = "btn btn-flat btn-primary">Submit Pending</button> 
			</div>
		<?php
		}
	?>
	</div>
	<div class = "card-body">
		<table class = "table table-bordered" id = "tbl_leave_list">
			<thead>
				<tr>
					<th>No</th>
					<th>Action</th>
					<th>Leave Type</th>
					<th>Credits</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
				
				if(!empty($leaveTransactionList)){
					$count = 1;
					foreach($leaveTransactionList as $lRows){
						$leaveTransactionId = $lRows["leave_transaction_id"];
						$statusId = $lRows["status_id"];
						$bgClass = "";
						if($page == "leave"){
							switch($statusId){
								case "2": //cancelled
									$bgClass = "bg-info";
								break;
								
								case "3": //approved
									$bgClass = "bg-success";
								break;
								
								case "4": //disapprove
									$bgClass = "bg-danger";
								break;
								
								case "5": //cancelled
									$bgClass = "bg-warning";
								break;
							}
						}
						
						$class = $bgClass != "" ? "class = '".$bgClass."'" : "";
					?>
						<tr <?php echo $class; ?>>
							<td>
								<div class="form-check">
								<?php
									if($statusId == "1"){
									?>
										<input
											class="form-check-input check_leave" 
											type="checkbox" 
											value="<?php echo $leaveTransactionId; ?>" 
											id="chk_leave_<?php echo $leaveTransactionId; ?>"
											name="chk_leave_<?php echo $leaveTransactionId; ?>"
											data-status = "<?php echo $statusId; ?>">
									<?php
									}
								?>
									<label class="form-check-label" for="chk_leave_<?php echo $leaveTransactionId; ?>"><?php
										echo $count;
									?></label>
								</div>
							</td>
							<td>
							<?php
								switch($page){
									case "leave":
									?>
										<button 
											type = "button" 
											id = "btn_view_<?php echo $leaveTransactionId; ?>" 
											class = "btn btn-flat btn-info leave_action border-white"
											data-action = "view" 
											data-id = "<?php echo $leaveTransactionId; ?>">View</button>
									<?php
									break;
									
									case "manage_leave":
									?>
										<button 
											type = "button" 
											id = "btn_view_<?php echo $leaveTransactionId; ?>" 
											class = "btn btn-flat btn-primary leave_action border-white"
											data-action = "approve" 
											data-id = "<?php echo $leaveTransactionId; ?>">Approve</button>
									<?php
									break;
								}
							?>
							
							</td>
							<td><?php 
								echo $lRows["leave_type_desc"];
							?></td>
							<td><?php 
								echo $lRows["credit"];
							?></td>
							<td><?php 
								echo $lRows["start_date"];
							?></td>
							<td><?php 
								echo $lRows["end_date"];
							?></td>
							<td><?php 
								echo $lRows["status_desc"];
							?></td>
						</tr>
					<?php
						$count++;
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>