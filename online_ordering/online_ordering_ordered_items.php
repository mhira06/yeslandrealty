<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
	</div>
	<div class = "card-body">
		<table id = "tbl_ordered_items" class = "table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Action</th>
				<?php
					if($action == "manage_online_ordering"){
					?>
						<th>User Type</th>
						<th>User ID</th>
						<th>Name</th>
					<?php
					}
				?>
					<th>Item</th>
					<th>Quantity</th>
					<th>Date Ordered</th>
					<th>Price</th>
					<th>Sub Total</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($orderedItemsList)){
					$count = 1;
					foreach($orderedItemsList as $oRows){
						$statusId = $oRows["status_id"];
					?>
						<tr>
							<td><?php
								echo $count;
							?></td>
							<td>
								<button 
									type = "button" 
									id = "btn_view_<?php echo $oRows["items_orders_id"];?>"
									data-id = "<?php echo $oRows["items_orders_id"];?>"
									data-action = "view_history"
									class = "btn btn-block btn-flat btn-info view_history">View</button>
									
							<?php
								if($statusId == "15" ){
									if($action != "manage_online_ordering"){
									?>
										<button 
											type = "button" 
											id = "btn_cancel_<?php echo $oRows["items_orders_id"];?>"
											data-id = "<?php echo $oRows["items_orders_id"];?>"
											data-quantity = "<?php echo $oRows["order_qty"];?>"
											data-action = "cancel" 
											class = "btn btn-block btn-flat btn-warning cancel_order">Cancel</button>
									<?php
									}
									if($action == "manage_online_ordering"){
									?>
										<button 
											type = "button" 
											id = "btn_disapprove_<?php echo $oRows["items_orders_id"];?>"
											data-id = "<?php echo $oRows["items_orders_id"];?>"
											data-quantity = "<?php echo $oRows["order_qty"];?>" 
											data-action = "disapprove" 
											class = "btn btn-block btn-flat btn-danger online_ordering_action">Disapprove</button>
											
										<button 
											type = "button" 
											id = "btn_ready_<?php echo $oRows["items_orders_id"];?>"
											data-id = "<?php echo $oRows["items_orders_id"];?>"
											data-quantity = "<?php echo $oRows["order_qty"];?>" 
											data-action = "ready_for_pick" 
											class = "btn btn-block btn-flat btn-primary online_ordering_action">Ready for Pickup</button>
									<?php
									}
								}
								$canbeClaimedStatus = array(14, 15);
								if(in_array($statusId, $canbeClaimedStatus) && $action == "manage_online_ordering"){
								?>
									<button 
										type = "button" 
										id = "btn_claim_<?php echo $oRows["items_orders_id"];?>"
										data-id = "<?php echo $oRows["items_orders_id"];?>"
										data-quantity = "<?php echo $oRows["order_qty"];?>" 
										data-action = "claimed" 
										class = "btn btn-block btn-flat btn-success online_ordering_action">Claim</button>
								<?php
								}
							?>
							</td>
						<?php
							if($action == "manage_online_ordering"){
							?>
								<td><?php
									echo $oRows["users_type_desc"];
								?></td>
								<td><?php
									echo $oRows["users_number_display"];
								?></td>
								<td><?php
									echo $oRows["full_name"];
								?></td>
							<?php
							}
						?>
							<td><?php
								echo $oRows["items_display"];
							?></td>
							<td><?php
								echo $oRows["order_qty"];
							?></td>
							<td><?php
								echo $oRows["date_ordered"];
							?></td>
							<td><?php
								echo "₱ ".$oRows["price"];
							?></td>
							<td><?php
								echo "₱ ".$oRows["sub_total"];
							?></td>
							<td><?php
								echo $oRows["status_desc"];
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