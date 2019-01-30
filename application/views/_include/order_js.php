<script type="text/javascript">
<?php if ($this->session->userdata('ROLL_ID') == 1) { ?>
	$(document).on('click', '#tab_open button#verifyvendor', function () {
		$(this).remove();
		var urlStore = $(this).data('action');
		var data = new Array();
		var dataPN = new Array();
		var dataStore = {};
		$('#tab_open .table-responsive table#orderwastedetail tbody tr').each(function(){
			var json = {};
			json['STATUS_ID'] = $(this).find('input[name=STATUS_ID]').val();
			json['PKK_ID'] = $(this).find('input[name=PKK_ID]').val();
			json['PKK_DET_ID'] = $(this).find('input[name=PKK_DET_ID]').val();
			json['WASTE_ID'] = $(this).find('input[name=WASTE_NAME]').data('id');
			json['WASTE_NAME'] = $(this).find('input[name=WASTE_NAME]').val();
			json['UM_ID'] = $(this).find('input[name=UM_NAME]').data('id');
			json['UM_NAME'] = $(this).find('input[name=UM_NAME]').val();
			json['WASTE_TYPE_NAME'] = $(this).find('input[name=WASTE_TYPE_NAME]').val();
			json['WASTE_TYPE_ID'] = $(this).find('input[name=WASTE_TYPE_NAME]').data('id');
			json['MAX_LOAD_QTY'] = $(this).find('input[name=MAX_LOAD_QTY]').val();
			json['KEEP_QTY'] = $(this).find('input[name=KEEP_QTY]').val();
			json['REQUEST_QTY'] = $(this).find('input[name=REQUEST_QTY]').val();
			json['TOTAL_QTY'] = $(this).find('input[name=TOTAL_QTY]').val();
			json['ACTUAL_REQUEST_QTY'] = $(this).find('input[name=ACTUAL_REQUEST_QTY]').val();
			json['VENDOR_ID'] = $(this).find('select[name=VENDOR_NAME]').data('id');
			json['VENDOR_NAME'] = $(this).find('select[name=VENDOR_NAME]').data('name');
			dataStore[$(this).find('input[name=PKK_DET_ID]').val()] = json;
			$(this).find('select[name=VENDOR_NAME]').attr('disabled', true);
		});
		data['url'] = urlStore;
	    data['input'] = dataStore;
	    data['type'] = 'verifyvendor';
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure save this data?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});
	
	$(document).on('change', '#tab_open .table-responsive table#orderwastedetail tbody tr.stid_101 select', function () {
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
		var selected = '#tab_open .table-responsive table#orderwastedetail tbody tr select';
    	$(selected).each(function(){
    		$(this).html('<option value="'+$(this).data('id')+'">'+$(this).data('name')+'</option>');
    	});
    	var select = '#tab_open .table-responsive table#orderwastedetail tbody tr.roid_1.stid_101 select';
    	select += ' ,#tab_open .table-responsive table#orderwastedetail tbody tr.roid_1.stid_102 select';
    	$(select).html(opt);
    	$(select).each(function(){
    		$(this).val($(this).data('id'));
    	});
    	$(select+'[disabled]').html('');
	}