<script>
	var base_url = "<?php echo base_url();?>";
	var today = moment().format('L');
	
	var loading = "<div class = 'progress'>";
	loading += "<div class = 'progress-bar progress-bar-primary progress-bar-striped active' role = 'progressbar' aria-valuenow = '100' aria-valuemin = '0' aria-valuemin = '100' style = 'width: 100%'>";
	loading += "<span class = 'sr-only'>100% Complete (Success)</span>";
	loading += "</div>"
	loading += "</div>";
	function get_date(date, format){
		dateFormat = format || "L";
		response = moment(date, "L").format(dateFormat);
		
		return response;
	}
	function alert_message(message, type){
		response  = "<div class = 'alert alert-"+type+"'>";
		response += "	<button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'> ";
		response += "		&times;";
		response += "	</button>";
		response += message;
		response += "</div>";
		
		return response;
	}
	
	$(function () {
		$('.range_date').daterangepicker()
		
		$(".date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$(".select").select2({
			theme: 'bootstrap4'
		});
		
		$(".cancel_search").on("click", function(){
			page = $(this).attr("data-page");
			pageLocation = $(this).attr("data-page_url");
			url = base_url;
			url += "/action";
			url += "/cancel_search.php";
			url += "?page=" + page;
			url += "&location=" + pageLocation;
			location.href = url;
		});
		
		$(".cancel_search_2").on("click", function(){
			session = $(this).attr("data-session");
			$.ajax({
				method : "POST", 
				url : base_url + "/action/cancel_search_2.php",
				data : {
					session : session
				}, 
				dataType : "JSON", 
				success : function(response){
					location.reload();
				}, 
				error : function(xhr){
					$.alert({
						title : "ERROR", 
						content : xhr.responseText, 
						type : 'red'
					})
				}
			})
		});
		
		//$(".number_only").keypress(function (e) {
		$(document).on("keypress", ".number_only", function (e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	});
</script>