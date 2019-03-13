<div class="x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($admin['NAMA']) ?><small>Admin</small></h2>
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
								value="<?php echo $admin['NAMA'] ?>" 
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
								value="<?php echo $admin['NPWP'] ?>" 
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
								value="<?php echo $admin['EMAIL'] ?>" 
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
								value="<?php echo $admin['NIPP'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Posisi</label>
							<input 
								readonly
								name="POSISI" 
								value="<?php echo $admin['POSISI'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Organisasi</label>
							<input 
								readonly
								name="ORGANISASI" 
								value="<?php echo $admin['ORGANISASI'] ?>" 
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
								value="<?php echo $admin['PHONE'] ?>" 
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
								value="<?php echo $admin['FLAG_ACTIVE'] ?>" 
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
								value="<?php echo $admin['LAST_LOGIN'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div id="actionshow" class="row">
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $admin['USER_ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
								<i class="fa fa-pencil"></i> Update
							</button>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $admin['USER_ID'] ?>" type="button" class="btn btn-success btn-block refreshshow">
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