<div class = "card card-default">
	<div class = "card-header">
		<h3 class = "card-title">List</h3>
		<div class = "card-tools">
			<button 
				name= "btn_item_delete" 
				id = "btn_item_delete" 
				class = "btn btn-flat btn-danger">Delete</button>
		</div>
	</div>
	<div class = "card-body">
		<table id = "tbl_items" class = "table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Action</th>
					<th>Item Description</th>
					<th>Stock</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($itemsStockList)){
					$count = 1;
					//$function->echo_array($itemsStockList);
					foreach($itemsStockList as $iRows){
					?>
						<tr>
							<td>
								<div class="form-check">
									<input
										class="form-check-input check_item" 
										type="checkbox" 
										value="<?php echo $iRows["items_size_id"]; ?>" 
										id="chk_item_<?php echo $iRows["items_size_id"]; ?>"
										name="chk_item_<?php echo $iRows["items_size_id"]; ?>"">
									<label class="form-check-label" for="chk_item_<?php echo $iRows["items_size_id"]; ?>"><?php
										echo $count;
									?></label>
								</div>
							</td>
							<td>
								<!--<button 
									type = "button" 
									id = "btn_update_stock_<?php echo $iRows["items_size_id"]?>" 
									class = "btn btn-primary btn-flat btn-block " 
									data-action = "update_stock" 
									data-size_id = "<?php echo $iRows["items_size_id"]?>">Update Stock</button>
								</button> 
								<button 
									type = "button" 
									id = "btn_update_stock_<?php echo $iRows["items_size_id"]?>" 
									class = "btn btn-info btn-flat btn-block " 
									data-action = "update_price" 
									data-size_id = "<?php echo $iRows["items_size_id"]?>">Update Price</button>
								</button> -->
								<button 
									type = "button" 
									id = "btn_update_items_<?php echo $iRows["items_size_id"]?>" 
									class = "btn btn-info btn-flat btn-block items_action" 
									data-action = "update_item" 
									data-items_size = "<?php echo $iRows["items_size_id"]?>">Update Item</button>
								</button>
							</td>
							<td><?php
								echo $iRows["items_display"];
							?></td>
							<td><?php
								echo $iRows["quantity"];
							?></td>
							<td><?php
								echo $iRows["price"];
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