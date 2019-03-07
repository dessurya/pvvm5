<script type="text/javascript">
	$(document).ready(function () {
		$("#npassword, #cnpassword").keyup(checkPasswordMatch);
		$('.btn_submit').prop('disabled', true);
	});

	$(document).ready(function(){
		$('#submit').submit(function(e){
			e.preventDefault(); 
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
                // location.reload();
            },
            success: function(data) {
            	// $('#profile_picture').html(data.new_image);
                // $('#loading-page').hide();
                // alert("Upload Image Successful.");
				actionResponse(data);
				// console.log(data);
           //  	if (data.msg !== null && data.msg !== "" && data.msg !== undefined) {
           //  		console.log(data.msg);
	          //       dataPN['model'] = 'info';
			        // dataPN['title'] = 'Success';
			        // dataPN['text'] = data.msg;
			        // dataPN['type'] = 'success';
			        // if(data.title !== null && data.title !== "" && data.title !== undefined){
           //  			dataPN['title'] = data.title;	
           //  		}
           //  		if(data.type !== null && data.type !== "" && data.type !== undefined){
           //  			dataPN['type'] = data.type;	
           //  		}
	          //       showPNotify(dataPN);
           //  	}
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
