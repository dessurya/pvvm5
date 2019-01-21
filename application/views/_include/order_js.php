<script type="text/javascript">
<?php if ($this->session->userdata('ROLL_ID') == 1) { ?>
	$(document).on('click', '#tab_open button#verifyvendor', function () {
		var datadetail = new Array();
		$('#tab_open .table-responsive table#orderwastedetail tbody tr').each(function(){
			var input = new Array();
			input['WASTE_ID'] = $(this).find('input[name=WASTE_NAME]').data('id');
			input['WASTE_NAME'] = $(this).find('input[name=WASTE_NAME]').val();
			input['UM_ID'] = $(this).find('input[name=UM_NAME]').data('id');
			input['UM_NAME'] = $(this).find('input[name=UM_NAME]').val();
			input['MAX_QTY'] = $(this).find('input[name=MAX_QTY]').val();
			input['LOAD_QTY'] = $(this).find('input[name=LOAD_QTY]').val();
			input['REQUEST_QTY'] = $(this).find('input[name=REQUEST_QTY]').val();
			input['ACTUAL_QTY'] = $(this).find('input[name=ACTUAL_QTY]').val();
			input['VENDOR_ID'] = $(this).find('select[name=VENDOR_NAME]').data('id');
			input['VENDOR_NAME'] = $(this).find('select[name=VENDOR_NAME]').data('name');
			$(this).find('select[name=VENDOR_NAME]').attr('disabled', true);
			datadetail.push(input);
			console.log(input);
		});
		console.log(datadetail);
	});
	
	$(document).on('change', '#tab_open .table-responsive table#orderwastedetail tbody tr.stid_11 select', function () {
		$(this).data('id', $(this).find(":selected").val()).data('name', $(this).find(":selected").text());
	});
<?php } ?>


	function callVendor() {
		$.ajax({
            url: '<?php echo site_url()."/vendor/getdata/autoComplate" ?>',
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
	            $('#loading-page').show();
	        },
	        error: function(data) {
	            $('#loading-page').hide();
	            location.reload();
	        },
            success: function(data) {
            	var option = "";
            	$.map( data, function(key, val){ 
            		option += '<option value="'+key.VENDOR_ID+'">'+key.VENDOR_NAME+'</option>';
            	});
            	setVendor(option);
            	$('#loading-page').hide();
            }
        });
	}

	function setVendor(opt) {
		console.log(opt);
		var selected = '#tab_open .table-responsive table#orderwastedetail tbody tr select';
    	$(selected).each(function(){
    		$(this).html('<option value="'+$(this).data('id')+'">'+$(this).data('name')+'</option>');
    	});
    	var select = '#tab_open .table-responsive table#orderwastedetail tbody tr.roid_1.stid_11 select';
    	$(select).html(opt);
    	$(select).each(function(){
    		$(this).val($(this).data('id'));
    	});
    	$(select+'[disabled]').html('');
	}