<script type="text/javascript">
	var urlDataTable = "<?php echo site_url().'/' ?>"+urisegment1+"/getdata";
	<?php if(in_array($this->uri->segment(1), array('order', 'report'))) {?>
		urlDataTable += "<?php echo '/'.$this->uri->segment(3) ?>";
	<?php if($this->uri->segment(3) == 'list' and $this->uri->segment(4) == 'for') {?>
		urlDataTable += "<?php echo '/'.$this->uri->segment(4).'/'.$this->uri->segment(5) ?>";
	<?php } ?>
	<?php } ?>
	var urlForm = "<?php echo site_url().'/' ?>"+urisegment1+"/callForm";

	<?php if (in_array($this->uri->segment(1), array('vendor','ipc','profile', 'admin', 'role'))) {?>
		callForm(urlForm);
	<?php }?>

	var datatable;

	callDatatable();

	function callDatatable(mindate = null, maxdate = null) {
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		datatable = $('#datatable').DataTable({
			// fixedHeader: { header:true, footer:true },
		    processing: true,
		    serverSide: true,
		    // serverSide: false,
		    ajax: {
		    	"url": urlDataTable, 
		    	"type": "POST", 
		    	"data":{ startDate:mindate, endDate:maxdate }
		    },
		    <?php  if(in_array($this->uri->segment(1), array('order', 'report'))) { ?>
			    aaSorting: [ [1,'desc'] ],
			<?php } else if(in_array($this->uri->segment(1), array('vendor'))) {?>
			    aaSorting: [ [3,'asc'] ],
			<?php } else if($this->uri->segment(1) == 'history') {?>
			    aaSorting: [ [1,'asc'] ],
			<?php }?>
		    columns: [
				<?php  if(in_array($this->uri->segment(1), array('order', 'report')) and $this->uri->segment(3) == 'pickup') { ?>
				{name: "NO", data: "ID", orderable: false, searchable:false},
				{name: "WARTA_KAPAL_IN_DATE", data: "WARTA_KAPAL_IN_DATE"},
				{name: "PKK_NO", data: "PKK_NO"},
				{name: "NO_LAYANAN", data: "NO_LAYANAN"},
				{name: "NAMA_PERUSAHAAN", data: "NAMA_PERUSAHAAN"},
				{name: "NAMA_KAPAL", data: "NAMA_KAPAL"},
				{name: "KODE_PELABUHAN", data: "KODE_PELABUHAN"}
				<?php } else if(in_array($this->uri->segment(1), array('order', 'report')) and $this->uri->segment(3) == 'list') { ?>
				{name: "NO", data: "ID", orderable: false, searchable:false},
				{name: "WARTA_KAPAL_IN_DATE", data: "WARTA_KAPAL_IN_DATE"},
				{name: "ORDER_DATE", data: "ORDER_DATE"},
				{name: "PKK_NO", data: "PKK_NO"},
				{name: "NO_LAYANAN", data: "NO_LAYANAN"},
				{name: "NAMA_PERUSAHAAN", data: "NAMA_PERUSAHAAN"},
				{name: "KODE_PELABUHAN", data: "KODE_PELABUHAN"},
				{name: "VENDOR_NAMA", data: "VENDOR_NAMA"},
				{name: "STATUS", data: function(data) { //name
					if(data.STATUS == null){ return 'AVAILABLE'; }
					else{ return data.STATUS; }
				}}
				<?php } else if(in_array($this->uri->segment(1), array('vendor'))) {?>
				{name: "NO", data: "VENDOR_ID", orderable: false, searchable:false},
				{name: "CHECKBOX", data: "CHECKBOX", orderable: false, class: "not", searchable:false},
				{name: "NAMA", data: "NAMA"},
				{name: "EMAIL", data: "EMAIL"},
				{name: "PHONE", data: "PHONE"},
				{name: "NPWP", data: function(data) {
					return data.NPWP.replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})(\d{3})/,"$1.$2.$3.$4-$5.$6");
				}},
				{name: "FLAG_ACTIVE", data: "FLAG_ACTIVE"}
				<?php } else if(in_array($this->uri->segment(1), array('role'))) {?>
				{name: "NO", data: "AUTH_TYPE_ID", orderable: false, searchable:false},
				{name: "CHECKBOX", data: "CHECKBOX", orderable: false, class: "not", searchable:false},
				{name: "AUTH TYPE NAME", data: "AUTH_TYPE_NAME"},
				<?php } else if($this->uri->segment(1) == 'admin') {?>
				{name: "NO", data: "ADMIN_ID", orderable: false, searchable:false},
				{name: "CHECKBOX", data: "CHECKBOX", orderable: false, class: "not", searchable:false},
				{name: "AUTH_TYPE_NAME", data: "AUTH_TYPE_NAME"},
				{name: "NAMA", data: "NAMA"},
				{name: "EMAIL", data: "EMAIL"},
				{name: "PHONE", data: "PHONE"},
				{name: "NIPP", data: "NIPP"},
				{name: "NPWP", data: function(data) {
					return data.NPWP.replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})(\d{3})/,"$1.$2.$3.$4-$5.$6");
				}},
				{name: "FLAG_ACTIVE", data: "FLAG_ACTIVE"}
				<?php } else if($this->uri->segment(1) == 'history') {?>
				{name: "NO", data: "BATCH_ID", orderable: false, searchable:false},
				{name: "CREATED_DATE", data: "CREATED_DATE"},
				{name: "PKK_NO", data: "PKK_NO"},
				{name: "DESCRIPTION", data: "DESCRIPTION"},
				{name: "STATUS", data: "STATUS"}
				<?php }?>
		    ],
		    initComplete: function () {
				var api = this.api();
		        api.columns().every(function () {
		            var column = this;
		            if ($(column.footer()).hasClass('search')) {
		                var input = $('<input type="text" class="form-control" placeholder="Search '+$(column.footer()).text()+'" />');
		                input.appendTo( $(column.footer()).empty() ).on('change', function (keypress) {
		                    if (column.search() !== this.value) {
		                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
		                        column.search(val ? val : '', true, false).draw();
		                    }
		                });
		                if ($(column.footer()).hasClass('autoComplete')){
		                    input.autoComplete({
		                    	minChars: 1,
		                    	source: function(term, suggest){
		                    		term = term.toLowerCase();
		                    		var setChoices = $.map( column.data().unique().sort(), function(v){ return v === "" ? null : v; });
		                    		var choices = setChoices;
		                    		var suggestions = [];
		                    		for (i=0;i<choices.length;i++)
		                    			if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
		                    		suggest(suggestions);
		                    	}
		                    });
		                }
		            }else{
		            	// console.log(false);
		            }
		        });
		    },
		    drawCallback: function(row){
		        rebuildiCheck('dtable');
		    },
			rowCallback: function(row, data, iDisplayIndex) {
				var info = this.fnPagingInfo();
				var page = info.iPage;
				var length = info.iLength;
				var index = page * length + (iDisplayIndex + 1);
				<?php if($this->uri->segment(1) == 'vendor') { ?>
				$(row).attr('id', data.VENDOR_ID);
				<?php } else if($this->uri->segment(1) == 'admin') { ?>
				$(row).attr('id', data.ADMIN_ID);
				<?php } else if(in_array($this->uri->segment(1), array('order', 'report'))) { ?>
				$(row).attr('id', data.ID);
				<?php } else if(in_array($this->uri->segment(1), array('role'))) { ?>
				$(row).attr('id', data.AUTH_TYPE_ID);
				<?php } ?>
				$('td:eq(0)', row).html(index);
			}
		});
	}

	$(document).on('ifChanged', 'input.iCheckTrig', function(){
	    if ($(this).is(':checked')) {
	        $('input[type=checkbox].iCheckTrig.flat, input[type=checkbox].flat.dtable')
	        	.prop('checked',true)
	        	.iCheck('update');
	    }
	    else{
	        $('input[type=checkbox].iCheckTrig.flat, input[type=checkbox].flat.dtable')
	        	.prop('checked',false)
	        	.iCheck('update');
	    }
	});

	$(document).on('click', '#action a.formau, #actionshow button.updateshow', function(){
	    var url = urlForm;
	    var dataId = null;
	    var dataPN = new Array();
	    if ($(this).hasClass('update')) {
	        dataId = getDataId();
	    }else if ($(this).hasClass('updateshow')) {
	    	dataId = $(this).data('id')
	    }
	    if (dataId !== null && dataId !== "" && dataId !== undefined) {
	        url += "?id="+dataId;
	        dataPN['model'] = 'info';
	        dataPN['title'] = 'Info';
	        dataPN['text'] = 'Open form update data <?php echo $this->uri->segment(1) ?>';
	        dataPN['type'] = 'info';
	        showPNotify(dataPN);
	    }
	    else{
	    	dataPN['model'] = 'info';
	        dataPN['title'] = 'Info';
	        dataPN['text'] = 'Open form add data <?php echo $this->uri->segment(1) ?>';
	        dataPN['type'] = 'info';
	        showPNotify(dataPN);
	    }
	    callForm(url);
	    $('ul.nav-tabs.bar_tabs a[href=#tab_form]').tab('show');
	    return false;
	});

	$(document).on('submit', 'form.store', function(){
	    var data = new Array();
	    var dataPN = new Array();
	    var urlStore   = $(this).attr('action');
	    var dataStore  = $(this).serializeArray(); // digunakan jika hanya mengirim form tanpa file
	    // var dataStore  = new FormData($(this)[0]); // digunakan untuk mengirim form dengan file
	    data['url'] = urlStore;
	    data['input'] = dataStore;
	    dataPN['model'] = 'confirm';
	    dataPN['title'] = 'Warning';
	    dataPN['text'] = 'Are you sure save this data?';
	    dataPN['type'] = 'warning';
	    showPNotify(dataPN, data);
	    return false;
	});
	
	$(document).on('dblclick', '#datatable tbody tr td', function(){
		if(!$(this).hasClass('not')){
			var idshow = $(this).closest('tr').attr('id');
			var url = '<?php echo site_url().'/'.$this->uri->segment(1).'/show/' ?>'+idshow;
			openDetailData(url);
		}
		return false;
	});

	$(document).on('click', 'button.refreshshow', function(){
		var url = '<?php echo site_url().'/'.$this->uri->segment(1).'/show/' ?>'+$(this).data('id');
		openDetailData(url);
		return false;
	});

	$(document).on('click', '#action a.tools', function(){
		var data = new Array();
		var dataPN = new Array();
	    var url = urlTools;
	    var dataId = getDataId();
	    if ($(this).hasClass('delete')) { var action = 'delete' }
	    else if ($(this).hasClass('deactived')) { var action = 'deactived' }
	    else if($(this).hasClass('actived')) { var action = 'actived' }
	    else if($(this).hasClass('reset')) { var action = 'reset_password' }
	    if (dataId == null || dataId == "" || dataId == undefined) {
	    	dataPN['model'] = 'info';
	        dataPN['title'] = 'Sorry!';
	        dataPN['text'] = 'For '+action+', please checked Data!';
	        dataPN['type'] = 'error';
	        showPNotify(dataPN);
	    }else{
	        url += "?id="+dataId+"&action="+action;
	        data['url'] = url;
	        data['input'] = null;
	        dataPN['model'] = 'confirm';
	        dataPN['title'] = 'Warning!';
	        dataPN['text'] = 'Are you sure to '+action+' all checked data ?';
	        dataPN['type'] = 'error';
	        showPNotify(dataPN, data);
	    }
	    return false;
	});

	function openDetailData(url){
	    $.ajax({
	        url: url,
	        type: 'get',
	        dataType: 'json',
	        beforeSend: function() {
	            $('#loading-page').show();
	        },
	        error: function(data) {
	            $('#loading-page').hide();
	            // location.reload();
	        },
	        success: function(data) {
	            $('.x_content .tab-content #tab_open').html(data.result);
				$('ul.nav-tabs li.tab_open').show();
	        	$('ul.nav-tabs.bar_tabs a[href=#tab_open]').tab('show').html(data.name);
	        	<?php if( in_array($this->uri->segment(1), array('order', 'report')) ){ ?>
				calldattime('input[name=TONGKANG_PICKUP_DATE]');
				calldattime('input[name=TRUCKING_PICKUP_DATE]');
				<?php } ?>
				<?php if( in_array($this->uri->segment(1), array('vendor', 'admin', 'profile'))){ ?>
	            $('input.maskNPWP').each(function(){
	            	var value = $(this).val();
					$(this).val(maskNPWP(value));
	            });
		        <?php } ?>
	            $('#loading-page').hide();
	            dtableReload();
	        }
	    });
	}

	function dtableReload() {
		datatable.ajax.reload();
		// datatable.api().ajax.reload();
	    $('input[type=checkbox].iCheckTrig.flat').prop('checked',false).iCheck('update');
	}

	function callForm(urlForm){
	    $.ajax({
	        url: urlForm,
	        type: 'get',
	        dataType: 'json',
	        beforeSend: function() {
	            $('#loading-page').show();
	        },
	        error: function(data) {
	            $('#loading-page').hide();
	        },
	        success: function(data) {
	            $('.x_content .tab-content #tab_form').html(data.result);
	            $('#loading-page').hide();
	            <?php if( in_array($this->uri->segment(1), array('vendor', 'admin', 'profile'))){ ?>
	            $('input.maskNPWP').each(function(){
	            	var value = $(this).val();
					$(this).val(maskNPWP(value));
	            });
		        <?php } ?>
	        }
	    });
	}

	function getDataId(){
	    var idData = "";
	    $('table tbody input[type=checkbox].flat.dtable:checked').each(function(){
	        idData += $(this).val()+'^';
	    });
	    var getLength = idData.length-1;
	    return idData.substr(0, getLength);
	}

	function rebuildiCheck(classBuild){
	    $('input[type="checkbox"].'+classBuild).iCheck({
	        checkboxClass: 'icheckbox_flat-green'
	    });
	}