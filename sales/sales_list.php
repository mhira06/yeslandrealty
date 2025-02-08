<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
	</div>
	<div class = "card-body">
		<table id = "tbl_sales" class = "table table-bordered">
			<thead>
				<tr>
					<th>No</th>
				<?php
					if($page == "manage_sales"){
					?>
						<th>Action</th>
					<?php
					}
				?>
					<th>Reservation Date</th>
				<?php
					if($page == "manage_sales"){
					?>
						<th>Sales Person</th>
					<?php
					}
				?>
					<th>Client Name</th>
					<th>Project Name</th>
					<th>Location</th>
					<th>Net Selling Price</th>
					<th>Unit</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($salesList)){
					$count = 1;
					foreach($salesList as $sRows){
						$statusId = $sRows["status_id"];
						$bgClass = "";
						if($statusId == "11"){
							$bgClass = "bg-warning";
						}
						
						$trClass = $bgClass != "" ? "class = '".$bgClass."'" : "";
						
					?>
						<tr <?php echo $trClass; ?>>
							<td><?php
								echo $count;
							?></td>
						<?php
							if($page == "manage_sales"){
							?>
								<td>
									<a href = "<?php echo base_url("pages/administration/manage_sales.php?action=update&id=".$sRows["sales_id"]);?>" 
										class = "btn btn-flat btn-info btn-block">Update</a>
								<?php
									if($statusId == "10"){
									?>
										<button 
											type = "button" 
											id = "btn_cancel_<?php echo $sRows["sales_id"];?>" 
											class = "btn btn-flat btn-block btn-warning sales_action" 
											data-id = "<?php echo $sRows["sales_id"]; ?>"
											data-action = "cancel">Cancel</button>
									<?php
									}
								?>
								</td>
							<?php
							}
						?>
							<td><?php
								echo $sRows["date_reserve"];
							?></td>
						<?php
							if($page == "manage_sales"){
							?>
								<td><?php
									echo $sRows["transact_full_name"];
								?></td>
							<?php
							}
						?>
							<td><?php
								echo $sRows["clients_full_name"];
							?></td>
							<td><?php
								echo $sRows["project_name"];
							?></td>
							<td><?php
								echo $sRows["location"];
							?></td>
							<td><?php
								echo $sRows["price"];
							?></td>
							<td><?php
								echo $sRows["quantity"];
							?></td>
							<td><?php
								echo $sRows["status_desc"];
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