<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>{_tittle_}</title>
	<link rel="shortcut icon" href="<?php echo base_url().'_asset/images/favicon.ico'?>">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="bootstrap material admin template">
	<meta name="author" content="IPC">
	<?php $this->load->view('_include/include_css') ?>
	{_link_css_}
	<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/js/jquery.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/js/onloadloading.js' ?>"></script>
</head>
<body class="nav-md">
	<div class="container body">
		<div class="container body">
			<div class="main_container">
				<?php 
					if ($this->session->userdata('PHOTO') == null ) {
						$profile_img = base_url().'_asset/gentelella/images/img.jpg';
					} else {
						$profile_img = base_url('upload/profile/').$this->session->userdata('PHOTO');
					}
				?>
				<?php // navbar ?>
				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
						<div class="navbar nav_title" style="border: 0;">
							<a href="#" class="site_title">
								<span>PWMS</span>
								<small class="site_title">Port Waste Management System</small>
							</a>
							<div class="clearfix"></div>
							<?php // menu profile quick info ?>
							<div class="profile clearfix">
								<div class="profile_pic">
									<img src="<?php echo $profile_img ?>" alt="..." class="img-circle profile_img">
								</div>
								<div class="profile_info">
									<span>Welcome,</span>
									<h2><?php echo $this->session->userdata('NAME') ?></h2>
								</div>
								<div class="clearfix"></div>
							</div>
							<?php // menu profile quick info ?>

							<?php // sidebar menu ?>
							<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
								<div class="menu_section">
									<ul class="nav side-menu"></ul>
								</div>
							</div>
							<?php // sidebar menu ?>

						</div>
					</div>
				</div>
				<?php // navbar ?>

				<?php // top navigation ?>
				<div class="top_nav">
					<div class="nav_menu">
						<nav>
							<div class="nav toggle">
								<a id="menu_toggle"><i class="fa fa-bars"></i></a>
							</div>

							<ul class="nav navbar-nav navbar-right">
								<li class="">
									<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<img src="<?php echo $profile_img ?>" alt=""><?php echo $this->session->userdata('NAME') ?>
										<span class=" fa fa-angle-down"></span>
									</a>
									<ul class="dropdown-menu dropdown-usermenu pull-right">
										<li><a href="<?php echo site_url().'/profile' ?>"><i class="fa fa-user pull-right"></i> Profile</a></li>
										<li><a id="logout" href="<?php echo site_url().'/login/signout' ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
									</ul>
								</li>
								<?php /*<li id="notivication" role="presentation" class="dropdown">
									<a href="<?php echo site_url().'/order' ?>" class="info-number">
										<i class="fa fa-anchor"></i>
										<span class="badge bg-green"></span>
									</a>
								</li>*/ ?>
							</ul>
						</nav>
					</div>
				</div>
				<?php // top navigation ?>

				<?php // content page ?>
				<div class="right_col" role="main">
					<div class="">
					{_contents_}
					</div>
				</div>
				<?php // content page ?>

				<?php // footer ?>
				<footer>
					<div class="pull-right">
						© 2019 CREATED BY <a href="http://edi-indonesia.co.id/">PT. ELECTRONIC DATA INTERCHANGE INDONESIA</a>
					</div>
					<div class="clearfix"></div>
				</footer>
				<?php // footer ?>

			</div>
		</div>
	</div>
	
	<?php $this->load->view('_include/loading_animate') ?>
	<?php $this->load->view('_include/include_js') ?>
	<?php $this->load->view('_include/main_js') ?>
	{_link_js_}
</body>
</html>