<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>{_tittle_}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="bootstrap material admin template">
	<meta name="author" content="IPC">
	<?php $this->load->view('_include/include_css') ?>
	<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/js/jquery.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/js/onloadloading.js' ?>"></script>
	<style type="text/css">
		span.error{
			color: red;
		}
		body{
			background-position: top;
		}
		.login_wrapper{
			max-width: 400px;
		}
		.login_form, .registration_form{
			top: 20px;
			background-color: rgba(0,0,0,.6);
			padding: 20px;
		}
		.login_content{
			text-shadow: unset;
		}
		.login_content h1{
			letter-spacing: .3em;
		}
		.login_content form input[type=text], .login_content form input[type=email], .login_content form input[type=password]{
			box-shadow: unset;
		}
	</style>
</head>
<body class="login" style="background-image: url('<?php echo base_url().'_asset/images/signin_bg.jpg' ?>');">
	<div style="position: absolute; top: 0; width: 100%; height: 100vh; background-color: rgba(115,115,115,.4);"></div>
	<div>
		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<div id="response-send-login" class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="alert alert-info alert-dismissible fade in" role="alert"></div>
						</div>
					</div>
					<form action="<?php echo site_url().'/login/signin' ?>" method="POST" autocomplete="off">
						<h1>IPWMS</h1>
						<div>
							<span class="error username"></span>
							<input type="text" name="username" class="form-control" placeholder="Username" required>
						</div>
						<div>
							<span class="error password"></span>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<div>
							<button class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
						<div>
							<br>
							<label>© 2018. All RIGHT RESERVED. IPWMS</label>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
	<?php $this->load->view('_include/loading_animate') ?>
	<?php $this->load->view('_include/include_js') ?>
	<script type="text/javascript">
		$(function(){
			$('#response-send-login').hide();
			$('form span.error').hide();
			$(document).on('submit', 'form', function(){
				var url = $(this).attr('action');
				var data  = $(this).serializeArray();
				$.ajax({
					url: url,
					type: 'post',
					dataType: 'json',
					data: data,
					beforeSend: function() {
						$('#loading-page').show();
						$('form span.error').hide();
					},
					error: function(data){
						// location.reload();
					},
					success: function(data) {
						var msg = data.msg;
						$("#response-send-login .alert").html(msg);
						$("#response-send-login").show();
						if (data.response == true) {
							window.setTimeout(function() {
								location.reload();
							}, 250);
						}else{
							$('#loading-page').hide();
						}
					}
				});
				return false;
			});
		});
	</script>
</body>
</html>