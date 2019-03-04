<script type="text/javascript">

	function init_daterangepicker() {

		if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }
	
		var cb = function(start, end, label) {
		  $('#reportrange span').html(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'));
		};

		var optionSet1 = {
		  startDate: moment().subtract(29, 'days'),
		  endDate: moment(),
		  minDate: '01/01/2019',
		  showDropdowns: true,
		  showWeekNumbers: true,
		  timePicker: false,
		  timePickerIncrement: 1,
		  timePicker12Hour: true,
		  ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		  },
		  opens: 'left',
		  buttonClasses: ['btn btn-default'],
		  applyClass: 'btn-small btn-primary',
		  cancelClass: 'btn-small',
		  format: 'DD/MM/YYYY',
		  separator: ' to ',
		  locale: {
			applyLabel: 'Submit',
			cancelLabel: 'Clear',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom',
			daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			firstDay: 1
		  }
		};
		
		$('#reportrange span').html('Filter Date');
		// $('#reportrange span').html(moment().subtract(29, 'days').format('D/M/YYYY') + ' - ' + moment().format('D/M/YYYY'));
		$('#reportrange').daterangepicker(optionSet1, cb);
		$('#options1').click(function() {
		  $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
		});
		$('#options2').click(function() {
		  $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
		});
		$('#destroy').click(function() {
		  $('#reportrange').data('daterangepicker').remove();
		});
	}

	function get_report(sdate, edate){
		var input = {};
		input['sdate'] = sdate;
		input['edate'] = edate;
		// console.log(input);
		var data = new Array();
		data['url'] = "<?PHP echo site_url().'/report/getReport' ?>";
	    data['input'] = input;
	    data['type'] = 'getreport';
		get_detail_report(data);
	}


	init_daterangepicker();
	$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
		// console.log(picker.startDate.format('D/M/Y') + " -- " + picker.endDate.format('D/M/Y'));
		$('#reportrange, #reportrange span').css('background', '#26b99a').css('color', 'white');
		$('#datatable').DataTable().destroy();
		get_report(picker.startDate.format('D/M/Y'), picker.endDate.format('D/M/Y'));
	});
	$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
		$('#reportrange, #reportrange span').css('background', '#fff').css('color', '#73879c');
		$('#reportrange span').html('Filter Date');
		$('#total_order, #new_order, #order_on_progress, #done_order').html('-');
		$('#btn-export').html('');
		$('tbody').html('<tr><td colspan="4" class="text-center">NO DATA</td></tr>');
	});

	function get_detail_report(dataAction) {
		var dataPN = new Array();
        $.ajax({
            url: dataAction.url,
            type: 'post',
            dataType: 'json',
            data: dataAction.input,
            // processData:false,
            // contentType:false,
            beforeSend: function(data) {
                $('#loading-page').show();
            },
            error: function(data) {
                $('#loading-page').hide();
                // location.reload();
            },
            success: function(data) {
            	$('#total_order').html(data.total_order);
				$('#new_order').html(data.new_order);
				$('#order_on_progress').html(data.order_on_progress);
				$('#done_order').html(data.done_order);
				$('#viewdetail').html(data.waste_report);
				$('#btn-export').html(data.btn_export);
				
                $('#loading-page').hide();
            	if (data.msg !== null && data.msg !== "" && data.msg !== undefined) {
	                dataPN['model'] = 'info';
			        dataPN['title'] = 'Success';
			        dataPN['text'] = data.msg;
			        dataPN['type'] = 'success';
			        if(data.title !== null && data.title !== "" && data.title !== undefined){
            			dataPN['title'] = data.title;	
            		}
            		if(data.type !== null && data.type !== "" && data.type !== undefined){
            			dataPN['type'] = data.type;	
            		}
	                showPNotify(dataPN);
            	}
            }
        });
    }