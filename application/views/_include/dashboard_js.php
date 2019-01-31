<script type="text/javascript">
	$(function(){
	    getDetailDashboard();
		function getDetailDashboard() {
			$.ajax({
				url: "<?PHP echo site_url().'/dashboard/getDetailDashboard' ?>",
				type: 'post',
				dataType: 'json',
				beforeSend: function() {
					$('#loading-page').show();
				},
				success: function(data) {
					$('#total_order').html(data.order);
					$('#total_vendor').html(data.vendor);
					$('#total_request_qty').html(data.request_qty);
					$('#total_act_request_qty').html(data.act_request_qty);
					$('#loading-page').hide();
				}
			});
		}
    });
