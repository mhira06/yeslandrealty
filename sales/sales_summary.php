<div class = "row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-maroon <?php echo $dailyClass; ?>">
			<div class="inner">
			<h3><?php
				echo $dailySummaryCount;
			?></h3>

			<p>Daily Sales</p>
			</div>
			<div class="icon">
				<i class="fas fa-chart-line"></i>
			</div>
			<a href="javascript:void(0)" class="small-box-footer view_sales" data-summary = "daily">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-maroon <?php echo $monthlyClass; ?>">
			<div class="inner">
			<h3><?php
				echo $monthlySummaryCount;
			?></h3>

			<p>Monthly Sales</p>
			</div>
			<div class="icon">
				<i class="fas fa-chart-line"></i>
			</div>
			<a href="javascript:void(0)" class="small-box-footer view_sales" data-summary = "monthly">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-maroon <?php echo $yearlyClass; ?>">
			<div class="inner">
			<h3><?php
				echo $yearlySummaryCount;
			?></h3>

			<p>Yearly Sales</p>
			</div>
			<div class="icon">
				<i class="fas fa-chart-bar"></i>
			</div>
			<a href="javascript:void(0)" class="small-box-footer view_sales" data-summary = "yearly">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>