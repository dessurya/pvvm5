<div id="form_id_<?php if(isset($data)) { echo $data['EMPLOYE_ID']; } else { echo '0'; } ?>" class="col-md-6 col-sm-6 col-xs-6">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['NAME']; } else { echo 'Add'; } ?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?php
				/*
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Username</label>
							<input 
								name="username" 
								value="<?php if(isset($data)) { echo $data['USERNAME']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Username"
								required="">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Roll Type</label>
							<input 
								name="auth_type" 
								value="Vendor" 
								type="text" 
								class="form-control" 
								placeholder="Vendor"
								readonly="">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Password</label>
							<input 
								name="password" 
								value="somethingsecret"
								type="password" 
								class="form-control" 
								placeholder="somethingsecret"
								readonly="">
						</div>
					</div>
				</div>
				*/
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>NIPP</label>
							<input 
								name="nipp" 
								value="<?php if(isset($data)) { echo $data['NIPP']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter NIPP"
								required="">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Name</label>
							<input 
								name="name" 
								value="<?php if(isset($data)) { echo $data['NAME']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Name"
								required="">
						</div>
					</div>
					<div class="col-md-12">
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
					<div class="col-md-12">
						<div class="form-group">
							<label>Posisi</label>
							<input 
								name="posisi" 
								value="<?php if(isset($data)) { echo $data['POSISI']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Posisi"
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