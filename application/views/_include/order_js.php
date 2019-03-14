<script type="text/javascript">
	function calldattime(elm) {	
		var date = new Date();
		date.setDate(date.getDate() - 1);
		if (!$(elm).is('[readonly]')) {
			$(elm).datetimepicker({
				minDate: date,
				format:'DD/MM/YYYY',
		        ignoreReadonly: true,
		        allowInputToggle: true
		    }).on('keypress', function () {
		    	return false;
		    });
		}
	}

	$(document).on('click', '#tab_open button#pickupordersubmit', function () {
		var tongkangdate = $('input[name=TONGKANG_PICKUP_DATE]').val();
		var truckingdate = $('input[name=TRUCKING_PICKUP_DATE]').val();
		var input = {};
		input['PKK_NO'] = $('input[name=PKK_NO]').val();
		input['TONGKANG_PICKUP_DATE'] = tongkangdate;
		input['TRUCKING_PICKUP_DATE'] = truckingdate;
		var dataPN = new Array();
		if (tongkangdate == '' && truckingdate == '') {
			dataPN['model'] = 'info';
		    dataPN['title'] = 'Error';
		    dataPN['text'] = 'Required Tanggal Tongkang Pick Up and Tanggal Trucking Pick Up';
		    dataPN['type'] = 'error';
		    showPNotify(dataPN);
		    return false;
		}
		if (tongkangdate > truckingdate) {
			dataPN['model'] = 'info';
		    dataPN['title'] = 'Error';
		    dataPN['text'] = 'Tanggal Trucking Pick Up Must Higher Than Tanggal Tongkang Pick Up';
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
			json['DET_WARTA_KAPAL_IN_ID'] = $(this).data('dwi');
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
		var send = true;
		var sid = $('input[name=STATUS_ID]').val();
	    $.each(data['input'], function(){
	    	if(this.TONGKANG_QTY == "" && sid == 1){
	    		console.log(this.TONGKANG_QTY);
	    		send = false;
	    		dataPN['model'] = 'info';
			    dataPN['title'] = 'Error';
			    dataPN['text'] = 'Required Tongkang '+this.WASTE_NAME+' Actual Quantity';
			    dataPN['type'] = 'error';
			    showPNotify(dataPN);
	    	}
	    	if (this.TRUCKING_QTY == "" && sid == 2) {
	    		console.log(this.TRUCKING_QTY);
	    		send = false;
	    		dataPN['model'] = 'info';
			    dataPN['title'] = 'Error';
			    dataPN['text'] = 'Required Trucking '+this.WASTE_NAME+' Actual Quantity';
			    dataPN['type'] = 'error';
			    showPNotify(dataPN);
	    	}
	    });
	    if (send == true) {
		    dataPN['model'] = 'confirm';
		    dataPN['title'] = 'Warning';
		    dataPN['text'] = text;
		    dataPN['type'] = 'warning';
		    showPNotify(dataPN, data);
	    }
	    return false;
	});