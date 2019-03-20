<div class="col-md-12 col-sm-12 col-xs-12 x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($detailProfile['NAMA']) ?></h2>
		<div class="clearfix"></div>
	</div>
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
						<div class="x_content">
							<div class="row profile_details">
								<div class="col-md-3 col-sm-4 col-xs-12 well profile_view">
									<div class="row">
										<div class="col-sm-12">
											<div class="right col-xs-12 text-center">
												<img id="profile_picture" src="<?php if (is_null($detailProfile['PHOTO'])){ echo base_url().'_asset/gentelella/images/img.jpg'; } else {echo base_url('upload/profile/').$detailProfile['PHOTO'];} ?>" alt="" class="img-circle img-responsive" style="display: inline-block;">											</div>
											<div class="left col-xs-12 m-b-15">
												<form class="form-horizontal form-label-left" id="submit" method="post">
													<!-- <div class="form-group">
														<input type="file" name="file" class="btn btn-secondary">
													</div> -->
													<label class="btn btn-info btn-block" for="my-file-selector">
														<input id="my-file-selector" type="file" name="file" accept=".png,.jpg,.jpeg" style="display:none;">
														Choose Photo
													</label>
													<div class="form-group">
														<button class="btn btn-warning btn-block" id="btn_upload" type="submit">Upload</button>
													</div>
													<small class="muted">
														<!-- File Size: max 10.000.000 bytes (10 Mb)<br> -->
														File Extensiion : .JPG .JPEG .PNG
													</small>
												</form>	
												<!-- <h2><?php echo $detailProfile['NAMA'] ?></h2>
												<p><strong>NIPP : </strong><?php echo $detailProfile['NIPP'] ?></p>
												<ul class="list-unstyled">
													<li><i class="fa fa-phone"></i> <?php echo $detailProfile['PHONE'] ?> </li>
													<li><i class="fa fa-envelope-o"></i> <?php echo $detailProfile['EMAIL'] ?> </li>
												</ul> -->
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-9 col-sm-8 col-xs-12">
									<div class="row">
										<!-- <div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>USERNAME</label>
												<input 
												readonly
												name="username" 
												value="<?php echo $detailProfile['USERNAME'] ?>" 
												type="text" 
												class="form-control">
											</div>
										</div> -->
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>ROLE</label>
												<input 
												readonly
												name="ROLL" 
												value="<?php echo $detailProfile['ROLL'] ?>" 
												type="email" 
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
												<label>NIPP</label>
												<input 
												readonly
												name="nipp" 
												value="<?php echo $detailProfile['NIPP'] ?>" 
												type="text" 
												class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>PHONE</label>
												<input 
												readonly
												name="PHONE" 
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
												<label>POSISI</label>
												<input 
												readonly
												name="POSISI" 
												value="<?php echo $detailProfile['POSISI'] ?>" 
												type="email" 
												class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>ORGANISASI</label>
												<input 
												readonly
												name="ORGANISASI" 
												value="<?php echo $detailProfile['ORGANISASI'] ?>" 
												type="email" 
												class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>NPWP</label>
												<input 
												pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}.[0-9]{1}-[0-9]{3}.[0-9]{3}"
												title="format must be xx.xxx.xxx.x-xxx.xxx"
												readonly
												name="NPWP" 
												value="<?php echo $detailProfile['NPWP'] ?>" 
												type="text" 
												class="form-control">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label>CREATED DATE</label>
												<input 
												readonly
												name="CREATED_DATE" 
												value="<?php echo $detailProfile['CREATED_DATE'] ?>" 
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
										<div class="col-md-4">
											<div class="form-group">
												<button data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
													<i class="fa fa-pencil"></i> Update
												</button>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target=".bs-example-modal-sm">
													<i class="fa fa-lock"></i> Change Password
												</button>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<button data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block reload">
													<i class="fa fa-refresh"></i> Refresh Data
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
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">Change Password</h4>
			</div>
			<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Current Password</label>
								<input 
								name="password" 
								value="" 
								type="password" 
								class="form-control" 
								placeholder="Enter current Password"
								required="">
								<small>Enter current password</small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>New Password</label>
								<input 
								name="npassword" 
								value="" 
								type="password" 
								id="npassword"
								class="form-control" 
								placeholder="Enter New Password"
								required="">
								<small class="passmsg"></small>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Confirm New Password</label>
								<input 
								name="cnpassword" 
								value="" 
								type="password" 
								id="cnpassword"
								class="form-control" 
								placeholder="Confirm New Password"
								required="">
								<div class="cpassmsg">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success btn_submit"><i class="fa fa-floppy-o"></i> Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>