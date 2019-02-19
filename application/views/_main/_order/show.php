<?php 
	function attr($status, $roll_id, $data){
		$default_dis = array(
			'WASTE_TYPE_NAME',
			'WASTE_NAME',
			'UM_NAME',
			'MAX_LOAD_QTY',
			'KEEP_QTY',
			'REQUEST_QTY',
			'TOTAL_QTY'
		);
		if (in_array($data['type'], $default_dis)) {
			return 'disabled';
		}else if ($data['type'] == 'VENDOR_NAME' and (!in_array($status, array(101, 102)) or $roll_id != 4 or $data['REQUEST_QTY'] == 0)) {
			return 'disabled';
		}else if ($data['type'] == 'ACTUAL_REQUEST_QTY' and ($roll_id != 3 or $status != 103)) {
			return 'disabled';
		}
	}
?>
<div class="x_panel">
	<div class="x_title">
		<h2>Order Waste</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>No.PKK</label>
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
					<label>No.Layanan</label>
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
			<div class="col-md-4">
				<div class="form-group">
					<label>Tanggal Tongkang Pick Up</label>
					<input 
						<?php if($this->session->userdata('ROLL_ID') == 1 and $head['ORDER_ID'] != null) echo 'readonly=""'; ?>
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
						<?php if($this->session->userdata('ROLL_ID') == 1 and $head['ORDER_ID'] != null) echo 'readonly=""'; ?>
						name="TRUCKING_PICKUP_DATE" 
						value="<?php echo $head['TRUCKING_PICKUP_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
		</div>

		<div class="ln_solid"></div>
		<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success pickupordersubmit">Get This Order</button>
		<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success refreshshow">Refresh Data</button>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>Order Waste Detail</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="table-responsive">
			<table id="orderwastedetail" class="table table-striped table-bordered no-footer">
				<thead>
					<tr>
						<th>Type</th>
						<th>Waste</th>
						<th width="80px">Max</th>
						<th width="80px">Request</th>
						<th width="80px">Actual Tongkang</th>
						<th width="80px">Actual Trucking</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($detail as $list) { ?>
					<tr data-dwi="<?php echo $list['DET_WARTA_IN_ID'] ?>">
						<td>
							<input 
								readonly=""
								type="text" name="TYPE" class="form-control"
								value="<?php echo $list['TYPE_NAME'] ?>" 
								data-id="<?php echo $list['WASTE_ID'] ?>"
								>
						</td>
						<td>
							<input 
								readonly=""
								type="text" name="WASTE" class="form-control" 
								value="<?php echo $list['WASTE_NAME'] ?>" 
								data-id="<?php echo $list['WASTE_ID'] ?>"
								>
						</td>
						<td>
							<input 
								readonly=""
								type="text" name="MAX" class="form-control"
								value="<?php echo $list['MAX_LOAD_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								readonly=""
								type="text" name="REQUEST" class="form-control" 
								value="<?php echo $list['REQUEST_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								<?php if($this->session->userdata('ROLL_ID') == 1 or $head['ORDER_ID'] == null) echo 'readonly=""'; ?>
								type="text" name="TONGKANG" class="form-control" 
								value="<?php echo $list['TONGKANG_QTY'] ?>"
								>
						</td>
						<td>
							<input 
								<?php if($this->session->userdata('ROLL_ID') == 1 or $head['ORDER_ID'] == null) echo 'readonly=""'; ?>
								type="text" name="TRUCKING" class="form-control" 
								value="<?php echo $list['TRUCKING_QTY'] ?>"
								>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<?php if($head['ORDER_ID'] != null) { ?>
		<div class="ln_solid"></div>
		<?php if($this->session->userdata('ROLL_ID') != 1 and $head['ORDER_ID'] != null) { ?>
		<button 
			data-action="<?php echo site_url().'/order/tools/saveact?warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>" 
			id="saveact" 
			type="submit" 
			class="btn btn-success">Save</button>
		<button 
			data-action="<?php echo site_url().'/order/tools/submact?warta_kapal_in_id='.$head['WARTA_KAPAL_IN_ID'] ?>" 
			id="submact" 
			type="submit" 
			class="btn btn-success">Submit</button>
		<?php } ?>
		<button data-id="<?php echo $head['WARTA_KAPAL_IN_ID'] ?>" type="button" class="btn btn-success refreshshow">Refresh Data</button>
		<?php } ?>
	</div>
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>Last Waste Pick Up</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="col-md-4">
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
			<div class="col-md-4">
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
			<div class="col-md-4">
				<div class="form-group">
					<label>Nomer Dokument</label>
					<input 
						readonly=""
						name="DOKUMEN_NO" 
						value="<?php echo $head['DOKUMEN_NO'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
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
						<th>By</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($history as $list) { ?>
						<tr>
							<td><?php echo $list['CREATED_DATE'] ?></td>
							<td><?php echo $list['NAMA'] ?></td>
							<td><?php echo $list['ACTION_TYPE'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
