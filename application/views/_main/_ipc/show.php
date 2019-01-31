<div class="x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($ipc['NAME']) ?><small>Vendor</small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Name</label>
							<input 
								readonly
								name="NAME" 
								value="<?php echo $ipc['NAME'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NIPP</label>
							<input 
								readonly
								name="NIPP" 
								value="<?php echo $ipc['NIPP'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input 
								readonly
								name="EMAIL" 
								value="<?php echo $ipc['EMAIL'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>POSISI</label>
							<input 
								readonly
								name="POSISI" 
								value="<?php echo $ipc['POSISI'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Status</label>
							<input 
								readonly
								name="FLAG_ACTIVE" 
								value="<?php echo $ipc['FLAG_ACTIVE'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<!-- <div class="col-md-4">
						<div class="form-group">
							<label>Last Login</label>
							<input 
								readonly
								name="LAST_LOGIN" 
								value="<?php echo $ipc['LAST_LOGIN'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div> -->
					<!-- <div class="col-md-4">
						<div class="form-group">
							<label>Order In Progress</label>
							<input 
								readonly
								name="ORDERWORK" 
								value="<?php echo $orderinfo['ndone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div> -->
					<!-- <div class="col-md-4">
						<div class="form-group">
							<label>Order Done</label>
							<input 
								readonly
								name="ORDERDONE" 
								value="<?php echo $orderinfo['ydone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div> -->
					<!-- <div class="col-md-4">
						<div class="form-group">
							<label>All Of Order</label>
							<input 
								readonly
								name="ORDERALL" 
								value="<?php echo $orderinfo['ndone']+$orderinfo['ydone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div> -->
				</div>
				<div class="ln_solid"></div>
				<div id="actionshow" class="row">
					<!-- <div class="col-md-3">
						<div class="form-group">
							<a href="<?php echo site_url().'/order/index/'.$ipc['EMPLOYE_ID'].'/'.$ipc['NAME'] ?>/vendor" data-id="<?php echo $ipc['EMPLOYE_ID'] ?>" type="button" class="btn btn-success btn-block">
								<i class="fa fa-file-text-o"></i> Show Order
							</a>
						</div>
					</div> -->
					<div class="col-md-3">
						<div class="form-group">
							<a href="<?php echo site_url().'/history/index/'.$ipc['EMPLOYE_ID'].'/'.$ipc['NAME'] ?>/ipc" data-id="<?php echo $ipc['EMPLOYE_ID'] ?>" type="button" class="btn btn-success btn-block">
								<i class="fa fa-clock-o"></i> Show History
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button data-id="<?php echo $ipc['EMPLOYE_ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
								<i class="fa fa-pencil"></i> Update
							</button>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button data-id="<?php echo $ipc['EMPLOYE_ID'] ?>" type="button" class="btn btn-success btn-block refreshshow">
								<i class="fa fa-refresh"></i> Refresh Data
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->uri->segment(5); ?>