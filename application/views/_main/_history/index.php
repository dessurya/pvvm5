<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>HISTORY <?php echo strtoupper($this->uri->segment(4)) ?></h2>
				<div class="clearfix"></div>
			</div>
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
									<h2>Data <small>History</small></h2>
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
</div>