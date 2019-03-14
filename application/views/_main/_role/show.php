<div class="x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($role[0]['AUTH_TYPE_NAME']) ?><small>Role</small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Role Name</label>
							<input 
								readonly
								name="NAME" 
								value="<?php echo $role[0]['AUTH_TYPE_NAME'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>List Menu</label>
							<div class="checkbox">
								<?php 
								// echo "<pre>";
								// var_dump($role);
								// echo "</pre>";
									foreach( $detail as $key => $r) {?>
								<!-- <button 
									data-value="<?php echo $r['MENU_ID'] ?>" 
									type="button" 
									class="rolecheck btn <?php echo $r['AUTH_TYPE_ID'] == null ? 'btn-default' : 'btn-success' ?>"
									><i class="fa <?php echo $r['AUTH_TYPE_ID'] == null ? 'fa-square-o' : 'fa-check-square-o' ?>"></i> <?php echo $r['TITLE_MENU'] ?>
								</button> -->
								<!-- <br> -->
								<div class="checkbox checkbox-success">
			                        <input 
			                        id="checkbox<?php echo $r['MENU_ID']?>" 
			                        type="checkbox"
			                        <?php echo $r['AUTH_TYPE_ID'] == null ? '' : 'checked' ?>
			                        disabled
			                        >
			                        <label for="checkbox<?php echo $r['MENU_ID']?>">
			                        	<?php echo $r['TITLE_MENU'] ?>
			                        </label>
			                    </div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div id="actionshow" class="row">
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $role[0]['AUTH_TYPE_ID'] ?>" type="button" class="btn btn-success btn-block updateshow">
								<i class="fa fa-pencil"></i> Update
							</button>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<button data-id="<?php echo $role[0]['AUTH_TYPE_ID'] ?>" type="button" class="btn btn-success btn-block refreshshow">
								<i class="fa fa-refresh"></i> Refresh Data
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="x_panel">
	<div class="x_title">
		<h2>History</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="table-responsive">
			<table class="table table-striped table-bordered no-footer">
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
</div> -->