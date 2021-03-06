<!-- <?php print_r($this->session->userdata);  ?> -->
<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>IPC</h2>
				<div id="action" class="nav navbar-right panel_toolbox">
                    <div class="btn-group">
                    	<button type="button" class="btn btn-sm btn-success">
                    		<i class="fa fa-wrench"></i> Tools
                    	</button>
                    	<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                    		<span class="caret" style="color: white"></span>
                    	</button>
                    	<ul class="dropdown-menu" role="menu">
                    		<li>
                    			<a class="add formau" href="#">
		                            <i class="fa fa-plus"></i> Add
                    			</a>
                    		</li>
                    		<li>
                    			<a class="update formau" href="#">
                    				<i class="fa fa-pencil"></i> Update
                    			</a>
                    		</li>
                    		<li>
                    			<a class="actived tools" href="#">
                    				<i class="fa fa-check"></i> Actived
                    			</a>
                    		</li>
                    		<li>
                    			<a class="deactived tools" href="#">
		                            <i class="fa fa-ban"></i> Deactived
                    			</a>
                    		</li>
                    		<li>
                    			<a class="delete tools" href="#">
                    				<i class="fa fa-trash-o"></i> Delete
                    			</a>
                    		</li>

                    	</ul>
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
									<h2>Data <small>IPC</small></h2>
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
															<th><input class="iCheckTrig flat" type="checkbox"></th>
															<th>NIPP</th>
															<th>Name</th>
															<th>Email</th>
															<th>Posisi</th>
															<th>Status</th>
															<th>Last Login</th>
														</tr>
													</thead>
													<tbody></tbody>
													<tfoot>
														<tr>
															<th></th>
															<th><input class="iCheckTrig flat" type="checkbox"></th>
															<th class="search">NIPP</th>
															<th class="search">Name</th>
															<th class="search">Email</th>
															<th class="search autoComplete">Posisi</th>
															<th class="search autoComplete">Status</th>
															<th class="search">Last Login</th>

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