<script type="text/javascript">
	$('button.reload').click(function() {
		location.reload();
	});

	$(document).ready(function () {
		$("#npassword, #cnpassword").keyup(checkPasswordMatch);
		$('.btn_submit').prop('disabled', true);
	});

	$(document).ready(function(){
		$('#submit').submit(function(e){
			e.preventDefault(); //RELOAD OR NOT
			$.ajax({
	            url: '<?php echo site_url();?>/profile/do_upload',
	            type: 'post',
	            data: new FormData(this),
	            processData:false,
	            contentType:false,
	            cache:false,
	            beforeSend: function(data) {
	                $('#loading-page').show();
	            },
	            error: function(data) {
	                $('#loading-page').hide();
	            },
	            success: function(data) {
					actionResponse(data);
					// location.reload();
	            }
        	});
		});
	});

	function checkPasswordMatch() {
		var password = $("#npassword").val();
		var confirmPassword = $("#cnpassword").val();
		var strPass = $("#npassword").val();

		if (strPass.length > 7 ) {
			if (confirmPassword.length < 1 ){
				$(".cpassmsg").html("Confirm your new password");
			}else if (password != confirmPassword){
				$(".cpassmsg").html("Password do not match!");
				$('.btn_submit').prop('disabled', true);
			} else {	
				$(".cpassmsg").html("Password match.");
				$('.btn_submit').prop('disabled', false);
			}
			$(".passmsg").html("Nice!");
		} else {
			$('.btn_submit').prop('disabled', true);
			$(".passmsg").html("Minimum 8 character.");
		}
	}
