<?php
	$titleDescColspan = $selectedAction == "manage_sales" ? 7 : 6;
?>
<table border = "1">
	<thead>
		<tr>
			<th colspan = "2">
			<?php
				if($source == "pdf"){
				?>
					<img src = "<?php echo base_url("assets/images/logos/yes.jpg"); ?>" style = "width:100px">
				<?php
				}
			?>
				
			</th>
			<th colspan = "<?php echo $titleDescColspan; ?>">
				Sales Report
			</th>
		</tr>
		<tr>
			<th>No</th>
			<th>Reservation Date</th>
		<?php
			if($selectedAction == "manage_sales"){
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
			?>
				<tr>
					<td><?php
						echo $count;
					?></td>
					<td><?php
						echo $sRows["date_reserve"];
					?></td>
				<?php
					if($selectedAction == "manage_sales"){
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