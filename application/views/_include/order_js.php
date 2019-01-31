<script type="text/javascript">
<?php if ($this->session->userdata('ROLL_ID') == 1) { ?>
	$(document).on('click', '#tab_open button#verifyvendor', function () {
		var data = new Array();
		data['url'] = $(this).data('action');
	    data['input'] = getdetailval();
	    data['type'] = 'verifyvendor';
		var dataPN = new Array();
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure save this data?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});
<?php } else if ($this->session->userdata('ROLL_ID') == 3) { ?>
	$(document).on('click', '#tab_open button#saveact', function () {
		var data = new Array();
		data['url'] = $(this).data('action');
	    data['input'] = getdetailval();
	    data['type'] = 'saveact';
		var dataPN = new Array();
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure save this data?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});
	$(document).on('click', '#tab_open button#submact', function () {
		var data = new Array();
		data['url'] = $(this).data('action');
	    data['input'] = getdetailval();
	    data['type'] = 'submact';
		var dataPN = new Array();
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure submit this data?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});
<?php } ?>

	function getdetailval() {
		var dataStore = {};
		$('#tab_open .table-responsive table#orderwastedetail tbody tr').each(function(){
			var json = {};
			if ($(this).data('pdi') == undefined) {
				return false;
			}
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
			json['VENDOR_ID'] = $(this).find('select[name=VENDOR_NAME]').find(':selected').val();
			json['VENDOR_NAME'] = $(this).find('select[name=VENDOR_NAME]').find(':selected').text();
			dataStore[$(this).find('input[name=PKK_DET_ID]').val()] = json;
		});
		return dataStore;
	}

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
    	$('#tab_open #orderwastedetail tbody tr.roid_1 select').each(function(){
    		$(this).html('<option value="'+$(this).data('id')+'">'+$(this).data('name')+'</option>');
    	});
    	$('#tab_open #orderwastedetail tbody tr select').html(opt);
    	$('#tab_open #orderwastedetail tbody tr select').each(function(){
    		$(this).val($(this).data('id'));
    	});
    	$('#tab_open #orderwastedetail tbody tr.roid_1 select.stid_101[disabled],#tab_open #orderwastedetail tbody tr.roid_1 select.stid_102[disabled]').html('');
	}