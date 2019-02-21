<script type="text/javascript">

	init_daterangepicker();
	$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
		// console.log(picker.startDate.format('D/M/Y') + " -- " + picker.endDate.format('D/M/Y'));
		$('#reportrange, #reportrange span').css('background', '#26b99a').css('color', 'white');
		$('#datatable').DataTable().destroy();
		callDatatable(picker.startDate.format('D/M/Y'), picker.endDate.format('D/M/Y'));
	});
	$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
		$('#reportrange, #reportrange span').css('background', '#fff').css('color', '#73879c');
		$('#reportrange span').html('Filter Date');
		$('#datatable').DataTable().destroy();
		callDatatable();
	});

	function calldattime(elm) {	
		if (!$(elm).is('[readonly]')) {
			$(elm).datetimepicker({
				minDate: new Date(),
				format:'DD/MM/YYYY',
		        ignoreReadonly: true,
		        allowInputToggle: true
		    }).on('keypress', function () {
		    	return false;
		    });
		}
	}

	$(document).on('click', '#tab_open button#pickupordersubmit', function () {
		var input = {};
		input['PKK_NO'] = $('input[name=PKK_NO]').val();
		input['TONGKANG_PICKUP_DATE'] = $('input[name=TONGKANG_PICKUP_DATE]').val();
		input['TRUCKING_PICKUP_DATE'] = $('input[name=TRUCKING_PICKUP_DATE]').val();
		if ($('input[name=TONGKANG_PICKUP_DATE]').val() == '' && $('input[name=TRUCKING_PICKUP_DATE]').val() == '') {
			var dataPN = new Array();
			dataPN['model'] = 'info';
		    dataPN['title'] = 'Error';
		    dataPN['text'] = 'Required Tanggal Tongkang Pick Up and Tanggal Trucking Pick Up';
		    dataPN['type'] = 'error';
		    showPNotify(dataPN);
		    return false;
		}
		var data = new Array();
		data['url'] = $(this).data('action');
	    data['input'] = input;
	    data['type'] = 'pickupordersubmit';
		var dataPN = new Array();
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure pick up this order?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});

	function getdetailval() {
		var dataStore = {};
		$('#tab_open .table-responsive table#orderwastedetail tbody tr').each(function(){
			var json = {};
			if ($(this).data('dwi') == undefined) {
				return false;
			}
			json['DET_WARTA_IN_ID'] = $(this).data('dwi');
			json['WASTE_NAME'] = $(this).find('input[name=WASTE]').val();
			json['WASTE_ID'] = $(this).find('input[name=WASTE]').data('id');
			json['TONGKANG_QTY'] = $(this).find('input[name=TONGKANG]').val();
			json['TRUCKING_QTY'] = $(this).find('input[name=TRUCKING]').val();
			dataStore[$(this).data('dwi')] = json;
		});
		return dataStore;
	}

	$(document).on('click', '#tab_open button.storedata', function () {
		if ($(this).hasClass('saveact')) { 
			var text = "Are you sure to save this data?"; 
			var type ="save";
		} else if ($(this).hasClass('submact')) {
			var text = "Are you sure to submit this data?"; 
			var type ="submit";
		}
		var data = new Array();
		data['url'] = $(this).data('action');
	    data['input'] = getdetailval();
	    data['type'] = type;
		var dataPN = new Array();
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = text;
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});

	$(document).on('keypress keyup blur', '.number', function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) { event.preventDefault(); }
	});