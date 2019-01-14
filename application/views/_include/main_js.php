<script type="text/javascript">
	$(function(){
		callSidebarMenu();
		
		checkNotivication();
		setInterval(function(){
			checkNotivication();
		}, 30000); // 30 second

		$(document).on('click', 'a#logout', function(){
			var logouturl = $(this).attr('href');
			logout(logouturl);
			return false;
		});
	});

	function callSidebarMenu() {
		$.ajax({
			url: "<?PHP echo site_url().'/login/getMenu' ?>",
			type: 'post',
			dataType: 'json',
			beforeSend: function() {
				$('#loading-page').show();
			},
			success: function(data) {
				$('#sidebar-menu .menu_section .nav.side-menu').html(data.menu);
				init_sidebar(); // fungsi untuk mengaktifkan sidebar dengan catatan matikan dulu auto run di custom.js line 5011
				$('#loading-page').hide();
			}
		});
	}

	function checkNotivication() {
		$.ajax({
			url: "<?PHP echo site_url().'/login/checkNotivication' ?>",
			type: 'post',
			dataType: 'json',
			beforeSend: function() {
				// $('#loading-page').show();
			},
			success: function(data) {
				if (data.response == true) {
					var dataPN = new Array();
					dataPN['model'] = 'info';
		            dataPN['title'] = 'New Order';
		            dataPN['text'] = 'Halo, you got new order please check...';
		            dataPN['type'] = 'success';
		            showPNotify(dataPN);
					$('.top_nav .nav_menu nav ul.navbar-nav li#notivication a span').show().html(data.notif);
				}
			}
		});
	}

	function logout(url){
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			beforeSend: function() {
				$('#loading-page').show();
			},
			success: function(data) {
				location.reload();
			},
			error: function(data){
				location.reload();
			}
		});
	}

	function showPNotify(dataPN, dataAction=null){
        if (dataPN.model == "info") {
            new PNotify({
                title: dataPN.title,
                text: dataPN.text,
                type: dataPN.type,
                styling: 'bootstrap3',
                delay: 3000,
                buttons: {
                    closer: true
                }
            });
        }else if (dataPN.model == "confirm") {
            new PNotify({
                after_open: function(ui){
                	$(".true", ui.container).focus();
                },
                after_close: function(){
	            	$('div.ui-pnotify-modal-overlay').remove();
                },
                title: dataPN.title,
                text: dataPN.text,
                type: dataPN.type,
                hide:false,
                styling: 'bootstrap3',
                delay: 3000,
                addclass: 'stack-modal',
                stack:{
                	'dir1':'down',
                	'dir2':'right',
                	'modal' :true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                },
                confirm: {
                    confirm: true,
                    buttons:[
                    	{ text: 'Yes', addClass: 'true btn-primary', removeClass: 'btn-default'},
                    	{ text: 'No', addClass: 'false'}
                    ]
                },
            }).get().on('pnotify.confirm', function(){
                action(dataAction);
            });
        }
    }

	<?php if(in_array($this->uri->segment(1), array('vendor', 'order'))) {?>
	var urlDataTable = "<?php echo site_url().'/'.$this->uri->segment(1).'/getdata'; ?>";
	var urlForm = "<?php echo site_url().'/'.$this->uri->segment(1).'/callForm'; ?>";
	var urlDele = "<?php echo site_url().'/'.$this->uri->segment(1).'/delete'; ?>";
	<?php } ?>

	$(document).ready(function() {
		<?php if(in_array($this->uri->segment(1), array('vendor', 'order'))) {?>
		callForm(urlForm);

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

		var datatable = $('#datatable').DataTable({
			// fixedHeader: { header:true, footer:true },
            processing: true,
            // serverSide: true,
            serverSide: false,
            ajax: {"url": urlDataTable, "type": "POST"},
            aaSorting: [ [1,'desc'] ],
            columns: [
				<?php if($this->uri->segment(1) == 'vendor') {?>
				// {"data": "ID", "orderable": false},
				{"data": "CHECKBOX", "orderable": false},
				{"data": "USERNAME"},
				{"data": "NAME"},
				{"data": "EMAIL"},
				{"data": "PHONE"}
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
            drawCallback: function(){
                rebuildiCheck('dtable');
            }
			// rowCallback: function(row, data, iDisplayIndex) {
			// 	var info = this.fnPagingInfo();
			// 	var page = info.iPage;
			// 	var length = info.iLength;
			// 	var index = page * length + (iDisplayIndex + 1);
			// 	$('td:eq(0)', row).html(index);
			// }
        });

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

	    $(document).on('click', '#action a.formau', function(){
	        var url = urlForm;
	        var dataId = null;
	        var dataPN = new Array();
	        if ($(this).hasClass('update')) {
	            dataId = getDataId();
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

	    $(document).on('click', '#action a.delete', function(){
	    	var data = new Array();
	    	var dataPN = new Array();
	        var url = urlDele;
	        var dataId = getDataId();
	        if (dataId == null || dataId == "" || dataId == undefined) {
	        	dataPN['model'] = 'info';
		        dataPN['title'] = 'Sorry!';
		        dataPN['text'] = 'For delete, please checked Data!';
		        dataPN['type'] = 'error';
	            showPNotify(dataPN);
	        }else{
	            url += "?id="+dataId;
	            data['url'] = url;
		        data['input'] = null;
		        dataPN['model'] = 'confirm';
		        dataPN['title'] = 'Warning!';
		        dataPN['text'] = 'Are you sure to delete all checked data ?';
		        dataPN['type'] = 'error';
	            showPNotify(dataPN, data);
	        }
	        return false;
	    });

	    function dtableReload() {
	    	datatable.ajax.reload();
	    	// datatable.api().ajax.reload();
            $('input[type=checkbox].iCheckTrig.flat').prop('checked',false).iCheck('update');
	    }

	    function action(dataAction) {
	        $.ajax({
	            url: dataAction.url,
	            type: 'post',
	            dataType: 'json',
	            data: dataAction.input,
	            // processData:false,
	            // contentType:false,
	            beforeSend: function() {
	                $('#loading-page').show();
	            },
	            error: function(data) {
	                $('#loading-page').hide();
	            },
	            success: function(data) {
	                $('#loading-page').hide();
	                showPNotify('info', 'Success', data.msg, 'success');
	                if (data.type == "add") {
	                	callForm(urlForm);
	                }
	                dtableReload();
	            }
	        });
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
		<?php } ?>
	});
</script>