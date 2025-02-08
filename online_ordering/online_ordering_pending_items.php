<form 
	name = "frm_order_items" 
	id = "frm_order_items" 
	action = "<?php echo base_url("action/submit_pending_order.php"); ?>"
	method = "POST">
	<div class = "card card-default">
		<div class = "card-body">
			<div class = "row">
				<div class = "col-12">
					<h4>Checkout</h4>
				<?php
					echo $function->display_flash();
					if(empty($pendingItemsList)){
						echo $function->generate->alert_message("warning", "No Pending Item to Submit");
					}
				?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>&nbsp;</th>
								<th class = "text-center">Qty</th>
								<th>Item</th>
								<th>Price</th>
								<th>Subtotal</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$totalQty = 0;
							$totalPrice = 0;
							if(!empty($pendingItemsList)){
								foreach($pendingItemsList as $pRows){
									$itemsOrderId = $pRows["items_orders_id"];
									$totalQty += $pRows["order_qty"];
									$totalPrice += $pRows["sub_total"];
								?>
									<tr>
										<td class = "text-center w-10">
											<button 
												type = "button" 
												id = "btn_remove_<?php echo $itemsOrderId; ?>"
												data-id = "<?php echo $itemsOrderId; ?>" 
												data-quantity = "<?php echo $pRows["order_qty"];?>"
												class = "btn btn-flat btn-danger remove_items">Remove</button>
										</td>
										<td class = "text-center w-25">
											<input 
												type = "text" 
												name = "txt_items_order_quantity_<?php echo $itemsOrderId; ?>" 
												id = "txt_items_order_quantity_<?php echo $itemsOrderId; ?>" 
												class = "form-control number_only order_quantity"
												data-order_id = "<?php echo $itemsOrderId; ?>"
												data-price = "<?php echo $pRows["price"]; ?>"
												value = "<?php echo $pRows["order_qty"];?>">
										</td>
										<td><?php
											echo $pRows["items_display"];
										?></td>
										<td><?php
											echo "₱ ".$pRows["price"];
										?></td>
										<td id = "td_sub_total_<?php echo $itemsOrderId; ?>"><?php
											echo "₱ ".$pRows["sub_total"];
										?></td>
									</tr>
								<?php
								}
							}
						?>
						</tbody>
					</table>
				</div>
				<div class = "col-md-6 offset-md-6">
					<p class = "lead">Total</p>
					<table class = "table">
						<tbody>
							<tr>
								<th class = "w-50">Quantity</th>
								<td id = "td_quantity"><?php
									echo $totalQty;
								?></td>
							</tr>
							<tr>
								<th class = "w-50">Price</th>
								<td id = "td_price">₱ <?php echo $totalPrice; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class = "card-footer">
		<?php
			if(!empty($pendingItemsList)){
			?>
				<button 
					type = "submit" 
					id = "btn_search" 
					class = "btn btn-flat btn-success">Submit</button>
			<?php
			}
		?>
			<a href = "<?php echo base_url("pages/display/online_ordering.php"); ?>" 
				class = "btn btn-flat btn-warning">Back in Ordering</a>
		</div>
	</div>
</form>