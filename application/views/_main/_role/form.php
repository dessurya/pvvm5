<div id="form_id_<?php if(isset($role)) { echo $role[0]['AUTH_TYPE_ID']; } else { echo '0'; } ?>" class="col-md-6 col-sm-6 col-xs-6">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form <small><?php if(isset($role)) { echo 'Update '. $role[0]['AUTH_TYPE_NAME']; } else { echo 'Add'; } ?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Role Name</label>
							<input 
								name="auth_type_name" 
								value="<?php if(isset($role)){ echo $role[0]['AUTH_TYPE_NAME']; } ?>"
								type="text" 
								class="form-control" 
								placeholder="Enter Nama"
								required=""
							>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>List Menu</label>
							<div class="checkbox">
								<?php 
								if (isset($detail)) {
								// echo "<pre>";
								// var_dump($detail);
								// echo "</pre>";
									foreach( $detail as $key => $r) {?>
									<!-- <button 
										data-value="<?php echo $r['MENU_ID'] ?>" 
										type="button" 
										class="rolecheck btn <?php echo $r['AUTH_TYPE_ID'] == null ? 'btn-default' : 'btn-success' ?>"
										><i class="fa <?php echo $r['AUTH_TYPE_ID'] == null ? 'fa-square-o' : 'fa-check-square-o' ?>"></i> <?php echo $r['TITLE_MENU'] ?>
									</button> -->
								<div class="checkbox checkbox-success">
			                        <input 
			                        id="checkbox<?php echo $r['MENU_ID'] == null ? '' :  $r['MENU_ID'] ?>"
			                        name="menu_picked[]" value="<?php echo $r['MENU_ID'] ?>"	
			                        type="checkbox"
			                        <?php echo $r['AUTH_TYPE_ID'] == null ? '' : 'checked' ?>
			                        >
			                        <label for="checkbox<?php echo $r['MENU_ID']?>">
			                        	<?php echo $r['TITLE_MENU'] ?>
			                        </label>
			                    </div>
								<?php 
									}
								} else { 
									foreach ($list_menu as $key => $lm) {
								?>
								<div class="checkbox checkbox-success">
			                        <input 
			                        id="checkbox<?php echo $lm['MENU_ID'] == null ? '' :  $lm['MENU_ID'] ?>"
			                        name="menu_picked[]" value="<?php echo $lm['MENU_ID'] ?>"
			                        type="checkbox">
			                        <label for="checkbox<?php echo $lm['MENU_ID']?>">
			                        	<?php echo $lm['TITLE_MENU'] ?>
			                        </label>
			                    </div>
								<?php 
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>