<script type="text/javascript">
	$(function(){
		callSidebarMenu();
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

		var urisegment1 = "<?php echo $this->uri->segment(1) ?>";
		var urlTools = "<?php echo site_url().'/' ?>"+urisegment1+"/tools";

		$(document).on('click', 'a#logout', function(){
			var logouturl = $(this).attr('href');
			logout(logouturl);
			return false;
		});

		$(document).on('keypress keyup blur', 'input.number', function (event) {    
			$(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) { event.preventDefault(); }
		});

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

		function action(dataAction) {
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
	                actionResponse(data);
	            }
	        });
	    }

	    function actionResponse(data) {
	    	var dataPN = new Array();
	    	$('#loading-page').hide();
        	if (data.response == true && data.msg !== null && data.msg !== "" && data.msg !== undefined) {
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
            if (data.type == "add") {
            	if (data.response == true) {
	            	callForm(urlForm);
            	}else if (data.response == false) {
            		dataPN['model'] = 'info';
			        dataPN['title'] = 'Error';
			        dataPN['text'] = data.msg;
			        dataPN['type'] = 'error';
	                showPNotify(dataPN);
            	}
            }else if(data.type == "orderrecalldetail"){
            	openDetailData(data.url);
            }else if(data.type == "info"){
            	$(data.info).each(function(index, value){
            		var timeadd = index*2000;
            		window.setTimeout(function() {
                		dataPN['model'] = 'info';
				        dataPN['title'] = 'Info';
				        dataPN['text'] = value;
				        dataPN['type'] = 'info';
		                showPNotify(dataPN);
	                }, timeadd);
            	});
            } else if (data.type == "getreport"){
            	$('#total_order').html(data.order);
            	$('#total_vendor').html(data.vendor);
            	$('#total_request_qty').html(data.request_qty);
            	$('#total_act_request_qty').html(data.act_request_qty);
            }
            if (data.reload == true) {
                dtableReload();
            }
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

		<?php 
		if( in_array($this->uri->segment(1), array('vendor', 'order', 'ipc', 'history', 'profile'))){
			echo substr($this->load->view('_include/datatble_js.php', '', true), 31 );
		}
		if( in_array($this->uri->segment(1), array('order'))){
			echo substr($this->load->view('_include/order_js.php', '', true), 31 );
		}
		if( in_array($this->uri->segment(1), array('report', 'dashboard'))){
			echo substr($this->load->view('_include/report_js.php', '', true), 31 );
		}
		if( in_array($this->uri->segment(1), array('order', 'history'))){
			echo substr($this->load->view('_include/datatble_daterange_js.php', '', true), 31 );
		}
		if( in_array($this->uri->segment(1), array('profile'))){
			echo substr($this->load->view('_include/profile_js.php', '', true), 31 );
		}
		?>
    });
</script>