<?php 
// echo "<pre>";
// var_dump($detailProfile); 
// echo "</pre>";
// echo "<br>";
// echo "<pre>";
// var_dump($this->session->userdata());
// echo "</pre>";
?>
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
							<div class="x_title">
								<h2><?php echo strtoupper($detailProfile['NAMA']) ?><small>Vendor</small></h2>
								<div class="clearfix"></div>
							</div>
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
													<p><strong>NIPP : </strong><?php echo $detailProfile['NIPP'] ?></p>
													<ul class="list-unstyled">
														<li><i class="fa fa-phone"></i> <?php echo $detailProfile['PHONE'] ?> </li>
														<li><i class="fa fa-envelope-o"></i> <?php echo $detailProfile['EMAIL'] ?> </li>
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
													name="username" 
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
													readonly
													name="NPWP" 
													value="<?php echo $detailProfile['NPWP'] ?>" 
													type="email" 
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
											<div class="col-md-3">
												<div class="form-group">
													<button data-id="<?php echo $detailProfile['ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
														<i class="fa fa-pencil"></i> Update
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