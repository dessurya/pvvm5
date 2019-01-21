<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo strtoupper($NAME) ?> VENDOR</h2>
				<div id="action" class="nav navbar-right panel_toolbox">
					<div class="btn-group">
						<a class="btn btn-sm btn-success" href="<?php echo site_url().'/vendor' ?>">
                    		<i class="fa fa-reply"></i> Go To List
                    	</a>
					</div>
					<div class="btn-group">
						<button type="button" class="info tools btn btn-sm btn-success">
                    		<i class="fa fa-info-circle"></i> Info
                    	</button>
					</div>
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
							<a href="#tab_detail" role="tab" data-toggle="tab" aria-expanded="true">Detail</a>
						</li>
						<li role="presentation" class="">
							<a href="#tab_form" role="tab" data-toggle="tab" aria-expanded="true">Form</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_detail">
							<div class="x_panel">
								<div class="x_title">
									<h2>Data Detail<small>Vendor</small></h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											
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