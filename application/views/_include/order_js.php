<script type="text/javascript">
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

	$(document).on('click', '#tab_open button.storedata', function () {
		var dataPN = new Array();
		var send = true;
		var sid = $('input[name=STATUS_ID]').val();
		var data = new Array();
	    data['url'] = $(this).data('action');

		if ($(this).hasClass('saveact')) { 
		    data['input'] = getdetailval();
			var text = "Are you sure to save this data?"; 
			var type ="save";
			send = checkinputqty(data['input'],sid);
		} else if ($(this).hasClass('submact')) {
			data['input'] = getdetailval();
			var text = "Are you sure to submit this data?"; 
			var type ="submit";
			send = checkinputqty(data['input'],sid);
			if (send == true) {
				send = validateDoc(sid);
			}
		} else if ($(this).hasClass('approved')) {
			var text = "Are you sure to approved this data?"; 
			var type ="approved";
			var input = {};
			input['command'] = $("textarea[name=command]").val();
			data['input'] = input;
		} else if ($(this).hasClass('revised')) {
			var text = "Are you sure to revised this data? And send back this document to vendor?";
			var type ="revised";
			var input = {};
			input['command'] = $("textarea[name=command]").val();
			data['input'] = input;
			if (input['command'] == null || input['command'] == "") {
				dataPN['model'] = 'info';
			    dataPN['title'] = 'Error';
			    dataPN['text'] = 'Required notes!';
			    dataPN['type'] = 'error';
			    showPNotify(dataPN);
	    		return false;
			}
		}
	    data['type'] = type;

	    if (send == true) {
		    dataPN['model'] = 'confirm';
		    dataPN['title'] = 'Warning';
		    dataPN['text'] = text;
		    dataPN['type'] = 'warning';
		    showPNotify(dataPN, data);
	    }
	    return false;
	});

	Dropzone.options.myDropzone = {
      maxFilesize  : 5.25, //mb
      timeout: 5000,
      // addRemoveLinks: true,
	  autoProcessQueue: true,
      acceptedFiles: ".jpeg,.jpg,.png,.pdf",
      init: function(){
      	var _this = this;
      	$(document).on("click","button#openupdok", function() {
      		$('form#my-dropzone input[name=id]').val($(this).data('id'));
      		$('form#my-dropzone input[name=status]').val($(this).data('status'));
			_this.removeAllFiles();
		});
      },
      error: function(file, response){
        var dataPN = new Array();
        dataPN['model'] = 'info';
        dataPN['title'] = 'Fail';
        dataPN['type'] = 'error';
	    dataPN['text'] = response;
	    showPNotify(dataPN);
      },
      success: function(file, response){
      	var dataPN = new Array();
    	dataPN['model'] = 'info';
        dataPN['title'] = 'Success';
        dataPN['type'] = 'success';
	    dataPN['text'] = 'Success Upload Your Attachment';
	    showPNotify(dataPN);
        if (response.status == 1 || response.status == 0) {
		    $('#lampiran-tongkang .x_content').append(response.append);
		    $('#lampiran-tongkang .x_content span').remove();
        }else if (response.status == 2) {
		    $('#lampiran-trucking .x_content').append(response.append);
		    $('#lampiran-trucking .x_content span').remove();
        }
      }
    };

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

	function checkinputqty(data, sid) {
		$back = true;
		var dataPN = new Array();
		dataPN['model'] = 'info';
	    dataPN['title'] = 'Error';
	    dataPN['type'] = 'error';
		$.each(data, function(){
	    	if(this.TONGKANG_QTY == "" && (sid == 1 || sid == 0)){
			    dataPN['text'] = 'Required Tongkang '+this.WASTE_NAME+' Actual Quantity';
			    showPNotify(dataPN);
	    		$back = false;
	    	}
	    	if (this.TRUCKING_QTY == "" && sid == 2) {
			    dataPN['text'] = 'Required Trucking '+this.WASTE_NAME+' Actual Quantity';
			    showPNotify(dataPN);
			    $back = false;
	    	}
	    });
	    return $back;
	}

	function validateDoc(sid) {
		var dataPN = new Array();
		dataPN['model'] = 'info';
	    dataPN['title'] = 'Error';
	    dataPN['type'] = 'error';
		if (sid == 1 || sid == 0) {
			if ($('#lampiran-tongkang .x_content span').html() == "No Data Found") {
				dataPN['text'] = 'Required Attachment Tongkang';
				showPNotify(dataPN);
				return false;
			}else{
				return true;
			}
		}else if (sid == 2){
			if ($('#lampiran-trucking .x_content span').html() == "No Data Found") {
				dataPN['text'] = 'Required Attachment Trucking';
				showPNotify(dataPN);
				return false;
			}else{
				return true;
			}
		}
	}