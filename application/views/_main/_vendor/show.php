<div class="x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($vendor['NAMA']) ?><small>Vendor</small></h2>
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
								value="<?php echo $vendor['NAMA'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NPWP</label>
							<input 
								readonly
								name="NPWP" 
								value="<?php echo $vendor['NPWP'] ?>" 
								type="text" 
								class="form-control maskNPWP">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input 
								readonly
								name="EMAIL" 
								value="<?php echo $vendor['EMAIL'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Phone</label>
							<input 
								readonly
								name="PHONE" 
								value="<?php echo $vendor['PHONE'] ?>" 
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
								value="<?php echo $vendor['FLAG_ACTIVE'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Last Login</label>
							<input 
								readonly
								name="LAST_LOGIN" 
								value="<?php echo $vendor['LAST_LOGIN'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Order In Progress</label>
							<input 
								readonly
								name="ORDERWORK" 
								value="<?php echo $orderinfo['ndone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Order Done</label>
							<input 
								readonly
								name="ORDERDONE" 
								value="<?php echo $orderinfo['ydone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>All Of Order</label>
							<input 
								readonly
								name="ORDERALL" 
								value="<?php echo $orderinfo['ndone']+$orderinfo['ydone'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div id="actionshow" class="row">
					<div class="col-md-4">
						<div class="form-group">
							<a href="<?php echo site_url().'/order/index/list/for/'.$vendor['VENDOR_ID'].'/'.$vendor['NAMA'] ?>/vendor" data-id="<?php echo $vendor['VENDOR_ID'] ?>" type="button" class="btn btn-success btn-block">
								<i class="fa fa-file-text-o"></i> Show Order
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $vendor['VENDOR_ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
								<i class="fa fa-pencil"></i> Update
							</button>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $vendor['VENDOR_ID'] ?>" type="button" class="btn btn-success btn-block refreshshow">
								<i class="fa fa-refresh"></i> Refresh Data
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>History</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="table-responsive">
			<table class="table table-striped table-bordered no-footer">
				<thead>
					<tr>
						<th>Date</th>
						<th>By</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($history as $list) { ?>
					<tr>
						<td><?php echo $list['CREATED_DATE'] ?></td>
						<td><?php echo $list['NAMA'] ?></td>
						<td><?php echo $list['ACTION_TYPE'] ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>