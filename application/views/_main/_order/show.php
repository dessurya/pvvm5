<div class="x_panel">
	<div class="x_title">
		<h2>Order Waste</h2>
		<div id="action" class="nav navbar-right panel_toolbox">
			<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success refreshshow"><i class="fa fa-refresh"></i> Refresh Data</button>
			<?php if($this->session->userdata('ROLL_ID') == 3 and $head['ORDER_ID'] == null) { ?>
					<button 
					id="pickupordersubmit"
					data-action="<?php echo site_url().'/order/tools/pickupordersubmit?warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>" 
					type="button" 
					class="btn btn-info"
					><i class="fa fa-download"></i> Get This Order</button>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>No. PKK</label>
					<input 
						readonly=""
						name="PKK_NO" 
						value="<?php echo $head['PKK_NO'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>No. Layanan</label>
					<input 
						readonly=""
						name="LAYANAN_NO" 
						value="<?php echo $head['LAYANAN_NO'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Tanggal Warta Kapal</label>
					<input 
						readonly=""
						name="WARTA_KAPAL_DATE" 
						value="<?php echo $head['WARTA_KAPAL_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Tanggal Pick Up Order</label>
					<input 
						readonly=""
						name="ORDER_DATE" 
						value="<?php echo $head['ORDER_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Tanggal Tongkang Pick Up</label>
					<input 
						<?php if($this->session->userdata('ROLL_ID') != 3 or $head['ORDER_ID'] != null) echo 'readonly=""'; ?>
						name="TONGKANG_PICKUP_DATE" 
						value="<?php echo $head['TONGKANG_PICKUP_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Tanggal Trucking Pick Up</label>
					<input 
						<?php if($this->session->userdata('ROLL_ID') != 3 or $head['ORDER_ID'] != null) echo 'readonly=""'; ?>
						name="TRUCKING_PICKUP_DATE" 
						value="<?php echo $head['TRUCKING_PICKUP_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Agent</label>
					<input 
						readonly=""
						name="PERUSAHAAN_NAMA" 
						value="<?php echo $head['PERUSAHAAN_NAMA'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Kapal</label>
					<input 
						readonly=""
						name="KAPAL_NAMA" 
						value="<?php echo $head['KAPAL_NAMA'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Pelabuhan</label>
					<input 
						readonly=""
						name="PELABUHAN_KODE" 
						value="<?php echo $head['PELABUHAN_KODE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Vendor</label>
					<input type="hidden" name="VENDOR_ID" value="<?php echo $head['VENDOR_ID'] ?>">
					<input 
						readonly=""
						name="VENDOR_NAMA" 
						value="<?php echo $head['VENDOR_NAMA'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Approved</label>
					<input type="hidden" name="VENDOR_ID" value="<?php echo $head['VENDOR_ID'] ?>">
					<input 
						readonly=""
						name="VENDOR_NAMA" 
						value="<?php echo $head['VENDOR_NAMA'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Status</label>
					<input type="hidden" name="STATUS_ID" value="<?php echo $head['STATUS_ID'] ?>">
					<input 
						readonly=""
						name="STATUS_NAMA" 
						value="<?php echo $head['STATUS_NAMA'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
		</div>
		<div class="ln_solid"></div>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2 style="width: 30%;">Order Waste Detail</h2>
		<div id="action" class="nav navbar-right panel_toolbox">
			<b> STATUS :  &nbsp;</b>
			<?php 
				if ($head['STATUS_ID'] == 4) {
					$btn_color = ' btn-success';
				}else if ($head['STATUS_ID'] == 3) {
					$btn_color = ' btn-success';
				} else if ($head['STATUS_ID'] == 2) {
					$btn_color = ' btn-warning';
				} else if ($head['STATUS_ID'] == 1) {
					$btn_color = ' btn-primary';
				} else if ($head['STATUS_ID'] == 0) {
					$btn_color = ' btn-danger';
				}
				if ($head['STATUS_ID'] >= 1) {
					foreach ($all_status as $key => $value) {
			?>
			<button 
				type="button" 
				class="btn btn-round <?php if ($head['STATUS_ID'] == $value['STATUS_ID']) {
					echo $btn_color;
				} ?>"
			>
				<i><?php echo $value['STATUS']; ?> </i>
			</button>
			<?php 
					}
				} else { 
			?>
			<button type="button" class="btn btn-round <?php echo $btn_color ?>">
				<i><?php echo $head['STATUS_NAMA'] ?></i>
			</button>
			<?php 
				} 
			?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="table-responsive">
			<table id="orderwastedetail" class="table table-striped table-bordered no-footer">
				<thead>
					<tr>
						<th>Type</th>
						<th>Waste</th>
						<th width="80px">UM</th>
						<th width="80px">Max</th>
						<th width="80px">Request</th>
						<th width="80px">Actual Tongkang</th>
						<th width="80px">Actual Trucking</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($detail as $list) { ?>
					<tr data-dwi="<?php echo $list['DET_WARTA_KAPAL_IN_ID'] ?>">
						<td>
							<input 
								readonly="" tabindex="-1"
								type="text" name="TYPE" class="form-control"
								value="<?php echo $list['TYPE_NAME'] ?>" 
								data-id="<?php echo $list['WASTE_ID'] ?>"
								>
						</td>
						<td>
							<input 
								readonly="" tabindex="-1"
								type="text" name="WASTE" class="form-control" 
								value="<?php echo $list['WASTE_NAME'] ?>" 
								data-id="<?php echo $list['WASTE_ID'] ?>"
								>
						</td>
						<td>
							<input 
								readonly="" tabindex="-1"
								type="text" name="WASTE" class="form-control" 
								value="<?php echo $list['UM_NAME'] ?>" 
								data-id="<?php echo $list['UM_ID'] ?>"
								>
						</td>
						<td>
							<input 
								readonly="" tabindex="-1"
								type="text" name="MAX" class="form-control"
								value="<?php echo $list['MAX_LOAD_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								readonly="" tabindex="-1"
								type="text" name="REQUEST" class="form-control" 
								value="<?php echo $list['REQUEST_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								<?php if($this->session->userdata('ROLL_ID') != 3 or $head['ORDER_ID'] == null or $head['STATUS_ID'] == 3 or $head['STATUS_ID'] == 2) echo 'readonly="" tabindex="-1"'; ?>
								type="text" name="TONGKANG" class="form-control number" 
								value="<?php echo $list['TONGKANG_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								<?php if($this->session->userdata('ROLL_ID') != 3 or $head['ORDER_ID'] == null or $head['STATUS_ID'] == 3 or $head['STATUS_ID'] == 1 or $head['STATUS_ID'] == 0) echo 'readonly="" tabindex="-1"'; ?>
								type="text" name="TRUCKING" class="form-control number" 
								value="<?php echo $list['TRUCKING_QTY'] ?>"
								>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div id="lampiran-tongkang" class="x_panel">
					<div class="x_title">
						<h2>Lampiran Actual Tongkang</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php if (count($attachment_tongkang) > 0) {
							foreach ($attachment_tongkang as $list) { ?>
							<a href="<?php echo base_url().$list['FILE_LOCATION'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file-<?php echo $list['FILE_TYPE'] ?>-o"></i> <?php echo $list['FILE_NAME'] ?></a>&nbsp;
						<?php } } else{ ?>
						<span>No Data Found</span>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div id="lampiran-trucking" class="x_panel">
					<div class="x_title">
						<h2>Lampiran Actual Trucking</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php if (count($attachment_trucking) > 0) {
							foreach ($attachment_trucking as $list) { ?>
							<a href="<?php echo base_url().$list['FILE_LOCATION'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-file-<?php echo $list['FILE_TYPE'] ?>-o"></i> <?php echo $list['FILE_NAME'] ?></a>&nbsp;
						<?php } } else{ ?>
						<span>No Data Found</span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php if($head['STATUS_ID'] == 3 and (isset($approve) and $approve == true) ) { ?>
		<div class="x_panel">
			<div class="x_title">
				<h2>Command</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
		        <textarea class="form-control" name="command"></textarea>
			</div>
		</div>

		<?php } if($this->session->userdata('ROLL_ID') == 3 and $head['ORDER_ID'] != null and $head['STATUS_ID'] != 3) { ?>
		<div class="ln_solid"></div>
		<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success refreshshow"><i class="fa fa-refresh"></i> Refresh Data</button>
		<div class="pull-right">
			<button 
				id="openupdok"
				data-id="<?php echo $head['WARTA_KAPAL_IN_ID']; ?>"
				data-status="<?php echo $head['STATUS_ID']; ?>"
				class="btn btn-info"
				data-toggle='modal' 
		      	data-target='.modal-add'>
				<i class="fa fa-file-text-o"></i> Upload Document
			</button>
			<button 
			data-action="<?php echo site_url().'/order/tools/store?type=save&warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>" 
			type="submit" 
			class="btn btn-warning storedata saveact"><i class="fa fa-floppy-o"></i> Save</button>
			<button 
			data-action="<?php echo site_url().'/order/tools/store?type=submit&warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>" 
			type="submit" 
			class="btn btn-success storedata submact"><i class="fa fa-send-o"></i> Submit</button>
		</div>
		<?php } if($head['STATUS_ID'] == 3 and (isset($approve) and $approve == true) ) { ?>
		<div class="ln_solid"></div>
		<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success refreshshow"><i class="fa fa-refresh"></i> Refresh Data</button>
		<div class="pull-right">
			<button 
			data-action="<?php echo site_url().'/approve/tools/revised?warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>"
			type="submit" 
			class="btn btn-danger storedata revised"><i class="fa fa-ban"></i> Revised</button>
			<button 
			data-action="<?php echo site_url().'/approve/tools/approved?warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>"
			type="submit" 
			class="btn btn-success storedata approved"><i class="fa fa-check-square-o"></i> Approved</button>
		</div>
		<?php } ?>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>Last Waste Pick Up</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="col-md-3">
				<div class="form-group">
					<label>Tanggal</label>
					<input 
						readonly=""
						name="TANGGAL_BONGKAR_TERAKHIR" 
						value="<?php echo $head['TANGGAL_BONGKAR_TERAKHIR'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Pelabuhan</label>
					<input 
						readonly=""
						name="PELABUHAN_BONGKAR_TERAKHIR" 
						value="<?php echo $head['PELABUHAN_BONGKAR_TERAKHIR'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Nomor Dokumen</label>
					<input 
						readonly=""
						name="DOKUMEN_NO" 
						value="<?php echo $head['DOKUMEN_NO'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Sumber</label>
					<input 
						readonly=""
						name="SUMBER_LIMBAH" 
						value="<?php echo $head['SUMBER_LIMBAH'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>Order Waste History</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="table-responsive">
			<table id="orderwastedetail" class="table table-striped table-bordered no-footer">
				<thead>
					<tr>
						<th>Date</th>
						<th>Activity</th>
						<th>Command</th>
						<th>By</th>
					</tr>
				</thead>
				<tbody style="max-height: 350px; overflow-y: auto;">
					<?php 
					if (count($history) == 0) {
						echo "<tr><td colspan='4'>No Data</td></tr>";
					}
					else{
					foreach ($history as $list) { 
					?>
						<tr>
							<td><?php echo $list['CREATED_DATE'] ?></td>
							<td><?php echo strtoupper($list['ACTION_TYPE']) ?></td>
							<td><?php echo $list['DESCRIPTION'] ?></td>
							<td><?php echo $list['NAMA'] ?></td>
						</tr>
					<?php } } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
