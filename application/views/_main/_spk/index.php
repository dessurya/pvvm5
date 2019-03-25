<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $tittle; echo isset($showNama) ? ' '.$showNama : ''; ?></h2>
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
									<div id="action" class="nav navbar-right panel_toolbox">
										<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
											<span></span> <b class="caret"></b>
				                        </div>
				                    </div>
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
															<!-- <th>Order Date</th> -->
															<?php if ($tittle == 'SPK') { ?>
															<th>Pick Up Date</th>
															<?php } ?>
															<th>PKK</th>
															<!-- <th>No Layanan</th> -->
															<!-- <th>Agent</th> -->
															<!-- <th>Kapal</th> -->
															<!-- <th>Pelabuhan</th> -->
															<?php if ($tittle == 'SPK') { ?>
															<th>Vendor</th>
															<th>Status</th>
															<th>SPK</th>
															<?php } ?>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th></th>
															<!-- <th></th> -->
															<?php if ($tittle == 'SPK') { ?>
															<th></th>
															<?php } ?>
															<th class="search">PKK</th>
															<!-- <th class="search">No Layanan</th> -->
															<!-- <th class="search">Agent</th> -->
															<!-- <th class="search">Kapal</th> -->
															<!-- <th class="search autoComplete">Pelabuhan</th> -->
															<?php if ($tittle == 'SPK') { ?>
															<th class="search">Vendor</th>
															<th></th>
															<th></th>
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
