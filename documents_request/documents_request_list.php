<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
	</div>
	<div class = "card-body">
		<table id = "tbl_documents_request" class = "table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Action</th>
				<?php
					if($page == "manage_documents_request"){
					?>
						<th>Requested By</th>
						<th>Users Number</th>
						<th>Users Type</th>
					<?php
					}
				?>
					<th>Document Type</th>
					<th>Date Needed</th>
					<th>Purpose</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($documentsRequestList)){
					$count = 1;
					foreach($documentsRequestList as $dRows){
						$statusId = $dRows["status_id"];
					?>
						<tr>
							<td><?php
								echo $count;
							?></td>
							
							<td>
								<button 
										type = "button" 
										id = "btn_view_<?php echo $dRows["documents_request_id"];?>" 
										class = "btn btn-flat btn-block btn-info documents_request_action" 
										data-id = "<?php echo $dRows["documents_request_id"];?>" 
										data-action = "view">View</button>
							<?php
								if($page == "document_request" && $statusId == "19"){
								?>
									<button 
										type = "button" 
										id = "btn_cancel_<?php echo $dRows["documents_request_id"];?>" 
										class = "btn btn-flat btn-block btn-warning documents_request_action" 
										data-id = "<?php echo $dRows["documents_request_id"];?>" 
										data-action = "cancel">Cancel</button>
								<?php
								}
								
								if($page == "manage_documents_request"){
									$statusCanBeReject = array("19");
									if(in_array($statusId, $statusCanBeReject)){
									?>
										<button 
											type = "button" 
											id = "btn_reject_<?php echo $dRows["documents_request_id"];?>" 
											class = "btn btn-flat btn-block btn-danger documents_request_action" 
											data-id = "<?php echo $dRows["documents_request_id"];?>" 
											data-action = "reject">Reject</button>
									<?php
									}
									
									$statusCanBeApprove = array("19");
									if(in_array($statusId, $statusCanBeApprove)){
									?>
										<button 
											type = "button" 
											id = "btn_cancel_<?php echo $dRows["documents_request_id"];?>" 
											class = "btn btn-flat btn-block btn-primary documents_request_action" 
											data-id = "<?php echo $dRows["documents_request_id"];?>" 
											data-action = "approve">Approve</button>
									<?php
									}
									
									$statusCanBeClaim = array("19", "20");
									if(in_array($statusId, $statusCanBeClaim)){
									?>
										<button 
											type = "button" 
											id = "btn_cancel_<?php echo $dRows["documents_request_id"];?>" 
											class = "btn btn-flat btn-block btn-success documents_request_action" 
											data-id = "<?php echo $dRows["documents_request_id"];?>" 
											data-action = "claim">Claim</button>
									<?php
									}
								}
							?></td>
							
							<?php
								if($page == "manage_documents_request"){
								?>
									<td><?php
										echo $dRows["full_name"];
									?></td>
									<td><?php
										echo $dRows["users_number_display"];
									?></td>
									<td><?php
										echo $dRows["users_type_desc"];
									?></td>
								<?php
								}
							?>
				
							<td><?php
								echo $dRows["documents_requested_display"];
							?></td>
							
							<td><?php
								echo $dRows["date_need"];
							?></td>
							
							<td><?php
								echo $dRows["purpose"];
							?></td>
							
							<td><?php
								echo $dRows["status_desc"];
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