<div class="col-md-3 col-sm-12 col-xs-12 profile_details">
	<div class="well profile_view">
		<div class="col-sm-12">
			<div class="right col-xs-12 text-center">
				<img src="<?php echo base_url('_asset/gentelella/images/img.jpg'); ?>" alt="" class="img-circle img-responsive" style="display: inline-block;">
			</div>
			<div class="left col-xs-12">
				<h2><?php echo $detailProfile['NAME'] ?></h2>
				<p><strong>NIPP : </strong> </i><?php echo $detailProfile['NIPP'] ?> </p>
				<ul class="list-unstyled">
					<li><i class="fa fa-building"></i> <?php echo $detailProfile['POSISI'] ?> </li>
					<li><i class="fa fa-phone"></i> <?php echo $detailProfile['ORGANISASI'] ?> </li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
	<div class="profile_img">
		<div id="crop-avatar">

			<img class="img-responsive avatar-view" src="<?php echo base_url('_asset/gentelella/images/img.jpg'); ?>" alt="Avatar" title="Change the avatar">
		</div>
	</div>
	<h3><?php echo $detailProfile['NAME'] ?></h3>
	<ul class="list-unstyled user_data">
		<li>
			<i class="fa fa-map-marker user-profile-icon"></i><?php echo $detailProfile['NIPP'] ?>
		</li>
		<li>
			<i class="fa fa-briefcase user-profile-icon"></i> <?php echo $detailProfile['POSISI'] ?>
		</li>
		<li class="m-top-xs">
			<i class="fa fa-external-link user-profile-icon"></i>
			<a href="http://www.kimlabs.com/profile/" target="_blank"><?php echo $detailProfile['ORGANISASI'] ?></a>
		</li>
	</ul>
	<br>
</div> -->
<div class="col-md-9 col-sm-12 col-xs-12">
	<h2>Recent Activities</h2>
	<div class="row">
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul class="nav nav-tabs bar_tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#tab_list" role="tab" data-toggle="tab" aria-expanded="true">List</a>
					</li>
					<li role="presentation" class="">
						<a href="#tab_open" role="tab" data-toggle="tab" aria-expanded="true">History : No Data</a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_list">
						<div class="x_panel">
							<div class="x_title">
								<h2>Data <small>Activity</small></h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table id="datatable" class="table table-striped table-bordered no-footer">
												<thead>
													<tr>
														<th>No</th>
														<th>Date</th>
														<th>On</th>
														<th>Activity</th>
														<th>User</th>
														<th>Roll</th>
													</tr>
												</thead>
												<tbody></tbody>
												<tfoot>
													<tr>
														<th></th>
														<th class="search">Date</th>
														<th class="search autoComplete">On</th>
														<th class="search">Activity</th>
														<th class="search autoComplete">User</th>
														<th class="search autoComplete">Roll</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in" id="tab_open">
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