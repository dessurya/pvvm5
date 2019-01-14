<style type="text/css">
	table#datatable tbody{
		max-height: 555px;
		overflow-y: auto;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>VENDOR</h2>
				<div id="action" class="nav navbar-right panel_toolbox">
                    <div class="btn-group">
                        <a class="add formau btn btn-success btn-sm" href="">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="update formau btn btn-success btn-sm" href="">
                            <i class="fa fa-pencil"></i> Update
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="actived tools btn btn-success btn-sm" href="">
                            <i class="fa fa-check"></i> Actived
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="deactived tools btn btn-success btn-sm" href="">
                            <i class="fa fa-ban"></i> Deactived
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="delete tools btn btn-success btn-sm" href="">
                            <i class="fa fa-trash-o"></i> Delete
                        </a>
                    </div>
                </div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#tab_list" role="tab" data-toggle="tab" aria-expanded="true">List</a>
						</li>
						<li role="presentation" class="">
							<a href="#tab_form" role="tab" data-toggle="tab" aria-expanded="true">Form</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_list">
							<div class="x_panel">
								<div class="x_title">
									<h2>Data <small>Vendor</small></h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="datatable" class="table table-striped table-bordered no-footer">
													<thead>
														<tr>
															<!-- <th>No</th> -->
															<th><input class="iCheckTrig flat" type="checkbox"></th>
															<th>Username</th>
															<th>Name</th>
															<th>Email</th>
															<th>Phone</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody></tbody>
													<tfoot>
														<tr>
															<!-- <th></th> -->
															<th><input class="iCheckTrig flat" type="checkbox"></th>
															<th class="search">Username</th>
															<th class="search">Name</th>
															<th class="search">Email</th>
															<th class="search">Phone</th>
															<th class="search autoComplete">Status</th>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade in" id="tab_form"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>