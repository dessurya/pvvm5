<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/vendors/font-awesome/css/font-awesome.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/vendors/nprogress/nprogress.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/vendors/animate.css/animate.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/css/custom.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'_asset/gentelella/css/public.css' ?>">

<link href="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.css' ?>" rel="stylesheet">
<link href="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.buttons.css' ?>" rel="stylesheet">
<link href="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.nonblock.css' ?>" rel="stylesheet">

<?php if ( in_array($this->uri->segment(1), array('vendor', 'order', 'history', 'admin', 'role')) ) { ?>
	<link href="<?php echo base_url(); ?>/_asset/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/_asset/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/_asset/jQuery-autoComplete-master/jquery.auto-complete.css" rel="stylesheet">
<?php } if (in_array($this->uri->segment(1), array('order', 'history', 'report'))) { ?>
	<link href="<?php echo base_url(); ?>/_asset/gentelella/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	
	<link href="<?php echo base_url(); ?>/_asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<style type="text/css">
		#orderwastedetail input,
		#orderwastedetail select{
			padding: 3px;
		}
		#orderwastedetail input[name="WASTE_NAME"],
		#orderwastedetail input[name="WASTE_TYPE_NAME"]{
			width: 140px;
		}
		#orderwastedetail input[name="UM_NAME"]{
			width: 65px;
		}
		#orderwastedetail input[name="MAX_LOAD_QTY"],
		#orderwastedetail input[name="KEEP_QTY"],
		#orderwastedetail input[name="REQUEST_QTY"],
		#orderwastedetail input[name="TOTAL_QTY"],
		#orderwastedetail input[name="ACTUAL_REQUEST_QTY"]{
			text-align: right;
			width: 50px;
		}
		#orderwastedetail select[name="VENDOR_NAME"]{
			width: 180px;
		}
	</style>
<?php } if (in_array($this->uri->segment(1), array('role'))) { ?>
	<link href="<?php echo base_url().'/_asset/gentelella/css/checkbox.css' ?>" rel="stylesheet">
<?php } ?>

<style type="text/css">
	small.site_title{
		font-size: 10pt;
		line-height: 20px;
	}
	table#datatable tr{
		cursor: pointer;
	}
	table#datatable tfoot { display: table-header-group; }
	table#datatable tfoot input { margin: 0; }
	.profile_details .profile_view {
		/*background: #f5f7fa;*/
	}
	.m-b-15{
		margin-bottom: 15px;
	}
	.x_judul{
		border-bottom: 2px solid #E6E9ED;
		padding: 1px 5px 6px;
		margin-bottom: 10px;
	}
	.dataTables_wrapper .dataTables_filter{
		display: none;
	}
</style>