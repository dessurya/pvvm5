<div id="form_id_<?php if(isset($data)) { echo $data['AUTH_ID']; } else { echo '0'; } ?>" class="col-md-12">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['NAMA']; } else { echo 'Add'; } ?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Role</label>
							<select
								name="role" 
								class="form-control" 
								placeholder="Select Role"
								required="">
								<?php foreach ($role as $list) {?>
									<option 
										value="<?php echo $list['AUTH_TYPE_ID'] ?>" 
										<?php if(isset($data) and $list['AUTH_TYPE_ID'] == $data['AUTH_TYPE_ID']) { echo "selected"; } ?>>
										<?php echo $list['AUTH_TYPE_NAME']; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Nama</label>
							<input 
								name="name" 
								value="<?php if(isset($data)) { echo $data['NAMA']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Nama"
								required="">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NIPP</label>
							<input 
								name="nipp"
								value="<?php if(isset($data)) { echo $data['NIPP']; } ?>"
								type="text" 
								class="form-control number" 
								placeholder="Enter NIPP">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NPWP</label>
							<input 
								name="npwp" 
								value="<?php if(isset($data)) { echo $data['NPWP']; } ?>"
								type="text" 
								class="form-control number" 
								placeholder="Enter NPWP"
								required="">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input 
								name="email" 
								value="<?php if(isset($data)) { echo $data['EMAIL']; } ?>" 
								type="email" 
								class="form-control" 
								placeholder="Enter Email"
								required="">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Posisi</label>
							<input 
								name="posisi" 
								value="<?php if(isset($data)) { echo $data['POSISI']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Posisi">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Organisasi</label>
							<input 
								name="organisasi" 
								value="<?php if(isset($data)) { echo $data['ORGANISASI']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Organisasi">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Phone</label>
							<input 
								name="phone" 
								value="<?php if(isset($data)) { echo $data['PHONE']; } ?>" 
								type="text" 
								class="form-control number" 
								placeholder="Enter Phone"
								required="">
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