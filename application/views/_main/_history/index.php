<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>HISTORY <?php echo strtoupper($this->uri->segment(3)) ?></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#tab_list" role="tab" data-toggle="tab" aria-expanded="true">List</a>
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
															<th>Description</th>
															<th>Status</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th></th>
															<th class="search">Date</th>
															<th class="search">Description</th>
															<th class="search autoComplete">Status</th>
														</tr>
													</tfoot>
													<tbody></tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>