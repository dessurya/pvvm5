<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="row">
				<div class="x_title">
					<h2 style="width: 30%;">Report</h2>
					<div id="action" class="nav navbar-right panel_toolbox">
						<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
							<span></span> <b class="caret"></b>
						</div>
						<div id="btn-export" class="pull-right"></div>
						
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="custom-search col-lg-8 col-lg-offset-2">
				<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<!-- <label>Agent</label>
					<select id="agent" name="agent" class="form-control">
						<option value=""></option>
						<?php foreach ($list_agent as $key ) { ?>
							<option value="<?php echo $key['NAMA_PERUSAHAAN'] ?>"><?php echo $key['NAMA_PERUSAHAAN'] ?></option>
						<?php } ?>
					</select> -->
					<label>Nama Agent</label>
					<select name="kapal" class="form-control agent" id="agent">
					</select>
				</div>
				<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<!-- <label>Kapal</label>
					<select id="kapal" name="kapal" class="form-control">
						<option value=""></option>
						<?php foreach ($list_kapal as $key ) { ?>
							<option value="<?php echo $key['NAMA_KAPAL'] ?>"><?php echo $key['NAMA_KAPAL'] ?></option>
						<?php } ?>
					</select> -->
					<label>Nama Kapal</label>
					<select name="kapal" class="form-control kapal" id="kapal">
					</select>
				</div>
			</div>
			<br>
			<div class="x_judul">
				<h2 style="width: 30%;">Order Summary</h2>	
			</div>
			<div class="row top_tiles">
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="tile-stats">
						<div class="icon"><i class="fa fa-clipboard"></i></div>
						<div id="total_order" class="count">-</div>
						<h3>Total Order</h3>
						<!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="tile-stats">
						<div class="icon"><i class="fa fa-file-o"></i></div>
						<div id="new_order" class="count">-</div>
						<h3>New Order</h3>
						<!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="tile-stats">
						<div class="icon"><i class="fa fa-exchange"></i></div>
						<div id="order_on_progress" class="count">-</div>
						<h3>On Progress</h3>
						<!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="tile-stats">
						<div class="icon"><i class="fa fa-check-square-o"></i></div>
						<div id="done_order" class="count">-</div>
						<h3>Done</h3>
						<!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
					</div>
				</div>
			</div>
			<br>
			<div class="x_judul">
				<h2 style="width: 30%;">Waste Summary</h2>	
			</div>
			<div id="viewdetail" class="table-responsive">
				<div class="alert alert-success">
					<ul class="fa-ul">
						<li>
							<i class="fa fa-info-circle fa-lg fa-li"></i> For open data please <code>Select the date</code>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
