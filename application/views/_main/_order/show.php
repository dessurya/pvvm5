<?php 
	function attr($status, $roll_id, $data){
		$default_red = array(
			'WASTE_NAME',
			'UM_NAME',
			'MAX_QTY',
			'LOAD_QTY',
			'REQUEST_QTY'
		);
		if (in_array($data['type'], $default_red)) {
			return 'disabled';
		}else if ($data['type'] == 'VENDOR_NAME' and ($status != 11 or $roll_id == 3 or ($status == 11 and $data['REQUEST_QTY'] == 0))) {
			return 'disabled';
		}else if ($data['type'] == 'ACTUAL_QTY' and $status != 16) {
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
					<label>Ship</label>
					<input 
						readonly=""
						name="SHIP_TYPE" 
						value="<?php echo $head['SHIP_TYPE'] ?>" 
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
						<th width="20%">Waste</th>
						<th width="10%">Unit</th>
						<th width="10%">Max</th>
						<th width="10%">Load</th>
						<th width="10%">Request</th>
						<th width="10%">Actual</th>
						<th width="20%">Vendor</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($detail as $list) { ?>
					<tr data-pdi="<?php echo $list['PKK_DET_ID'] ?>" class="<?php echo 'roid_'.$this->session->userdata('ROLL_ID').' stid_'.$head['STATUS_ID'] ?>">
						<td>
							<input type="hidden" name="PKK_ID" value="<?php echo $list['PKK_ID'] ?>">
							<input type="hidden" name="PKK_DET_ID" value="<?php echo $list['PKK_DET_ID'] ?>">
							<input value="<?php echo $list['WASTE_NAME'] ?>" data-id="<?php echo $list['WASTE_ID'] ?>" type="text" name="WASTE_NAME" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'WASTE_NAME')) ?>>
						</td>
						<td>
							<input value="<?php echo $list['UM_NAME'] ?>" data-id="<?php echo $list['UM_ID'] ?>" type="text" name="UM_NAME" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'UM_NAME')) ?>>
						</td>
						<td>
							<input value="<?php echo $list['MAX_QTY'] ?>" type="text" name="MAX_QTY" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'MAX_QTY')) ?>>
						</td>
						<td>
							<input value="<?php echo $list['LOAD_QTY'] ?>" type="text" name="LOAD_QTY" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'LOAD_QTY')) ?>>
						</td>
						<td>
							<input value="<?php echo $list['REQUEST_QTY'] ?>" type="text" name="REQUEST_QTY" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'REQUEST_QTY')) ?>>
						</td>
						<td>
							<input value="<?php echo $list['ACTUAL_QTY'] ?>" type="text" name="ACTUAL_QTY" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array('type'=>'ACTUAL_QTY')) ?>>
						</td>
						<td>
							<select name="VENDOR_NAME" data-name="<?php echo $list['VENDOR_NAME'] ?>" data-id="<?php echo $list['VENDOR_ID'] ?>" class="form-control" <?php echo attr($head['STATUS_ID'], $this->session->userdata('ROLL_ID'), array("type"=>'VENDOR_NAME', "REQUEST_QTY"=>$list['REQUEST_QTY'])) ?>>
							</select>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="ln_solid"></div>

		<?php if ($head['STATUS_ID'] == 11 and $this->session->userdata('ROLL_ID') == 1) { ?>
		<button id="verifyvendor" type="submit" class="btn btn-success">Verify Vendor</button>
		<?php } ?>

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
							<td><?php echo $list['ROLL'].'/'.$list['USERNAME'] ?></td>
							<td><?php echo $list['ACTION_TYPE'] ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>