<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $tittle; ?></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#tab_list" role="tab" data-toggle="tab" aria-expanded="true">List</a>
						</li>
						<li role="presentation" class="">
							<a href="#tab_open" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $tittle; ?> : No Data</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_list">
							<div class="x_panel">
								<div class="x_title">
									<h2>Data <small><?php echo $tittle; ?></small></h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="datatable" class="table table-striped table-bordered no-footer">
													<thead>
														<tr>
															<?php if ($tittle == 'Order List') { ?>
															<th>No</th>
															<th><input class="iCheckTrig flat" type="checkbox"></th>
															<th>Created Date</th>
															<th>PKK</th>
															<th>No Layanan</th>
															<th>Status</th>
															<th>Pelabuhan</th>
															<?php } else if($tittle == 'sdassadsad') { ?>
															<?php } ?>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<?php if ($tittle == 'Order List') { ?>
															<th></th>
															<th></th>
															<th class="search">Created Date</th>
															<th class="search">PKK</th>
															<th class="search">No Layanan</th>
															<th class="search autoComplete">Status</th>
															<th class="search autoComplete">Pelabuhan</th>
															<?php } else if($tittle == 'sdassadsad') { ?>
															<?php } ?>
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
						<div role="tabpanel" class="tab-pane fade in" id="tab_open">
							<div class="alert alert-success">
								<ul class="fa-ul">
									<li>
										<i class="fa fa-info-circle fa-lg fa-li"></i> For open data please <code>Double Click On Row Of Table</code>
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