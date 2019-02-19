<div class="col-md-12 col-sm-12 col-xs-12">
	<h2>Profile</h2>
	<div class="row">
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul class="nav nav-tabs bar_tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#tab_list" role="tab" data-toggle="tab" aria-expanded="true">Detail</a>
					</li>
					<li role="presentation" class="">
						<a href="#tab_form" role="tab" data-toggle="tab" aria-expanded="true">Form</a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_list">
						<div class="x_panel">
							<!-- <div class="x_title">
								<h2><?php echo strtoupper($detailProfile['NAMA']) ?><small>Vendor</small></h2>
								<div class="clearfix"></div>
							</div> -->
							<div class="x_content">
								<div class="row">
									<div class="col-md-3 col-sm-4 col-xs-12 profile_details">
										<div class="well profile_view">
											<div class="col-sm-12">
												<div class="right col-xs-12 text-center">
													<img src="<?php echo base_url('_asset/gentelella/images/img.jpg'); ?>" alt="" class="img-circle img-responsive" style="display: inline-block;">
												</div>
												<div class="left col-xs-12">
													<h2><?php echo $detailProfile['NAMA'] ?></h2>
													<p><strong>PHONE : </strong> </i><?php echo $detailProfile['PHONE'] ?> </p>
													<ul class="list-unstyled">
														<li><i class="fa fa-building"></i> <?php echo $detailProfile['EMAIL'] ?> </li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-9 col-sm-8 col-xs-12">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>USERNAME</label>
													<input 
													readonly
													name="USERNAME" 
													value="<?php echo $detailProfile['USERNAME'] ?>" 
													type="text" 
													class="form-control">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>ROLL</label>
													<input 
													readonly
													name="ROLL" 
													value="<?php echo $detailProfile['ROLL'] ?>" 
													type="text" 
													class="form-control">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>NAMA</label>
													<input 
													readonly
													name="NAMA" 
													value="<?php echo $detailProfile['NAMA'] ?>" 
													type="text" 
													class="form-control">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>PHONE</label>
													<input 
													readonly
													name="phone" 
													value="<?php echo $detailProfile['PHONE'] ?>" 
													type="text" 
													class="form-control">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>EMAIL</label>
													<input 
													readonly
													name="EMAIL" 
													value="<?php echo $detailProfile['EMAIL'] ?>" 
													type="email" 
													class="form-control">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label>STATUS</label>
													<input 
													readonly
													name="FLAG_ACTIVE" 
													value="<?php echo $detailProfile['FLAG_ACTIVE'] ?>" 
													type="text" 
													class="form-control">
												</div>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div id="actionshow" class="row">
											<div class="col-md-3">
												<div class="form-group">
													<button data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
														<i class="fa fa-pencil"></i> Update
													</button>
												</div>
											</div>
											<!-- <div class="col-md-3">
												<div class="form-group">
													<button data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block cpass">
														<i class="fa fa-lock"></i> Change Password
													</button>
												</div>
											</div> -->
											<div class="col-md-3">
												<div class="form-group">
													<!-- <a href="<?php echo site_url().'/profile/changepass/'.$detailProfile['ID'] ?>" data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block">
														<i class="fa fa-lock"></i> Change Password
													</a> -->
													<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target=".bs-example-modal-sm">
														<i class="fa fa-lock"></i> Change Password
													</button>
												</div>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in" id="tab_form">
						<div class="alert alert-success">
							<ul class="fa-ul">
								<li>
									<i class="fa fa-info-circle fa-lg fa-li"></i> For open data please <code>Right Click On Row Of Table</code>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">Change Password</h4>
			</div>
			<div class="modal-body">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Old Password</label>
									<input 
									name="password" 
									value="" 
									type="text" 
									class="form-control" 
									placeholder="Enter Old Password"
									required="">
									<small>Masukkan password anda.</small>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>New Password</label>
									<input 
									name="npassword" 
									value="" 
									type="text" 
									class="form-control" 
									placeholder="Enter New Password"
									required="">
									<small>Minimum 6 karakter.</small>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Confirm New Password</label>
									<input 
									name="cnpassword" 
									value="" 
									type="text" 
									class="form-control" 
									placeholder="Confirm New Password"
									required="">
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group" style="float:right;">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Submit</button>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
</div>