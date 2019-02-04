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
						name="PKK_ID" 
						value="<?php echo $head['PKK_ID'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>No.Layanan</label>
					<input 
						readonly=""
						name="NO_LAYANAN" 
						value="<?php echo $head['NO_LAYANAN'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Agent</label>
					<input 
						readonly=""
						name="AGENT_NAME" 
						value="<?php echo $head['AGENT_NAME'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Pelabuhan</label>
					<input 
						readonly=""
						name="KODE_PELABUHAN" 
						value="<?php echo $head['KODE_PELABUHAN'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Created On</label>
					<input 
						readonly=""
						name="CREATED_DATE" 
						value="<?php echo $head['CREATED_DATE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Status</label>
					<input 
						readonly=""
						name="STATUS" 
						value="<?php echo $head['STATUS'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
		</div>
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
						<th>Waste</th>
						<th>Unit</th>
						<th>Type</th>
						<th>Max</th>
						<th>Keep</th>
						<th>Request</th>
						<th>Total</th>
						<th>Actual</th>
						<th>Vendor</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($detail as $list) { ?>
					<tr data-pdi="<?php echo $list['PKK_DET_ID'] ?>" class="<?php echo 'roid_'.$this->session->userdata('ROLL_ID').' stid_'.$head['STATUS_ID'] ?>">
						<td>
							<input type="hidden" name="STATUS_ID" value="<?php echo $list['STATUS_ID'] ?>">
							<input type="hidden" name="PKK_ID" value="<?php echo $list['PKK_ID'] ?>">
							<input type="hidden" name="PKK_DET_ID" value="<?php echo $list['PKK_DET_ID'] ?>">
							<input value="<?php echo $list['WASTE_NAME'] ?>" data-id="<?php echo $list['WASTE_ID'] ?>" type="text" name="WASTE_NAME" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'WASTE_NAME')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['UM_NAME'] ?>" data-id="<?php echo $list['UM_ID'] ?>" 
								type="text" 
								name="UM_NAME" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'UM_NAME')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['WASTE_TYPE_NAME'] ?>" 
								data-id="<?php echo $list['WASTE_TYPE_ID'] ?>" 
								type="text" 
								name="WASTE_TYPE_NAME" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'WASTE_TYPE_NAME')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['MAX_LOAD_QTY'] ?>" 
								type="text" 
								name="MAX_LOAD_QTY" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'MAX_LOAD_QTY')) ?>>
						</td>
						<td>
							<input 
							value="<?php echo $list['KEEP_QTY'] ?>" 
							type="text" name="KEEP_QTY" 
							class="form-control" 
							<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'KEEP_QTY')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['REQUEST_QTY'] ?>" 
								type="text" 
								name="REQUEST_QTY"
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'REQUEST_QTY')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['TOTAL_QTY'] ?>" 
								type="text" 
								name="TOTAL_QTY" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'TOTAL_QTY')) ?>>
						</td>
						<td>
							<input 
								value="<?php echo $list['ACTUAL_REQUEST_QTY'] ?>" 
								type="text" 
								name="ACTUAL_REQUEST_QTY" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'ACTUAL_REQUEST_QTY')) ?>>
						</td>
						<td>
							<select 
								name="VENDOR_NAME" 
								data-name="<?php echo $list['VENDOR_NAME'] ?>" 
								data-id="<?php echo $list['VENDOR_ID'] ?>" 
								class="form-control" 
								<?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array("type"=>'VENDOR_NAME', "REQUEST_QTY"=>$list['REQUEST_QTY'])) ?>>
							</select>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="ln_solid"></div>

		<?php if ((in_array($head['STATUS_ID'], array(101, 102))) and $this->session->userdata('ROLL_ID') == 4) { ?>
		<button 
			data-action="<?php echo site_url().'/order/tools/verifyvendor?pkk_id='.$head['PKK_ID'] ?>" 
			id="verifyvendor" 
			type="submit" 
			class="btn btn-success">Verify Vendor</button>
		<?php }else if ($head['STATUS_ID'] == 103 and $this->session->userdata('ROLL_ID') == 3) { ?>
		<button 
			data-action="<?php echo site_url().'/order/tools/saveact?pkk_id='.$head['PKK_ID'] ?>" 
			id="saveact" 
			type="submit" 
			class="btn btn-success">Save</button>
		<button 
			data-action="<?php echo site_url().'/order/tools/submact?pkk_id='.$head['PKK_ID'] ?>" 
			id="submact" 
			type="submit" 
			class="btn btn-success">Submit</button>
		<?php } ?>
		<button data-id="<?php echo $head['PKK_ID'] ?>" type="button" class="btn btn-success refreshshow">Refresh Data</button>
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
						name="NOMOR_DOKUMEN" 
						value="<?php echo $head['NOMOR_DOKUMEN'] ?>" 
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
							<td><?php echo $list['CDATE'] ?></td>
							<td><?php echo $list['USERDETAIL'] ?></td>
							<td><?php echo $list['ACTION_TYPE'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>