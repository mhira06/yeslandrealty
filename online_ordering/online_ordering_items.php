<div class = "row">
<?php
	if(empty($itemsList)){
		$message = $select->generate->alert_message("warning", "No Item Found. Please search again.");
	?>
		<div class = "col-12"><?php
			echo $message;
		?></div>
	<?php
	}
	if(!empty($itemsList)){
		foreach($itemsList as $iRows){
			$image = $iRows["image"];
			$itemsImage = isset($iRows["image"]) && $iRows["image"] != "" ? $iRows["image"] : "assets/images/items/not_available.jpg";
			$itemsImageUrl = base_url($itemsImage);
		?>
			<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
				<div class="card card-default d-flex flex-fill">
					<div class="card-header text-muted border-bottom-0"><?php
						echo $iRows["items_type_desc"];
					?></div>
					<div class="card-body pt-0">
						<div class="row">
							<div class="col-7">
								<h2 class="lead">
									<b><?php
										echo $iRows["items_desc"];
									?></b>
								</h2>
								<p class="text-muted text-sm">
									<b>Colors: </b> <?php echo $iRows["colors_list"];?>
								</p>
								<p class="text-muted text-sm">
									<b>Sizes: </b> <?php echo $iRows["sizes_list"];?>
								</p>
							</div>
							<div class="col-5 text-center">
								<img src="<?php echo $itemsImageUrl; ?>" alt="Items Image" class="img-circle img-fluid">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
						<?php
							$orderUrl = "pages/display/online_ordering.php";
							$orderUrl .= "?action=order";
							$orderUrl .= "&id=".$iRows["items_id"];
						?>
							<a href="<?php echo base_url($orderUrl);?>" 
								class="btn btn-flat btn-primary">Order</a>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
?>
</div>