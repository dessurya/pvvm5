<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/vendors/fastclick/lib/fastclick.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/vendors/nprogress/nprogress.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'_asset/gentelella/js/custom.js' ?>"></script>

<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.buttons.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.nonblock.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.confirm.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.callbacks.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/pnotify/dist/pnotify.callbacks.js' ?>"></script>
<script src="<?php echo base_url().'/_asset/gentelella/vendors/Chart.js/dist/Chart.min.js' ?>"></script>

<?php if ( in_array($this->uri->segment(1), array('vendor', 'order', 'history')) ) { ?>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>

	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/iCheck/icheck.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/jQuery-autoComplete-master/jquery.auto-complete.js"></script>
<?php } if ( in_array($this->uri->segment(1), array('order', 'report')) ) { ?>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/moment/moment.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>/_asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<?php } ?>
