<?php if(isset($data)) { ?>
<div id="form_id_<?php if(isset($data)) { echo $data['ID']; } else { echo '0'; } ?>" class="col-md-12 col-sm-12 col-xs-12">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['USERNAME']; } else { echo 'Add'; } ?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Username</label>
							<input 
								name="username" 
								value="<?php if(isset($data)) { echo $data['USERNAME']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter USERNAME"
								required=""
								readonly="">
						</div>
					</div>
					<div class="col-md-6">
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
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input 
								name="email" 
								value="<?php if(isset($data)) { echo $data['EMAIL']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Email"
								required="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Phone</label>
							<input 
								name="phone" 
								value="<?php if(isset($data)) { echo $data['PHONE']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Phone"
								required="">
						</div>
					</div>
					<!-- <div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input 
								name="password" 
								value="" 
								type="text" 
								class="form-control" 
								placeholder="Enter Password"
								required="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Password</label>
							<input 
								name="password" 
								value="" 
								type="text" 
								class="form-control" 
								placeholder="Enter Password"
								required="">
						</div>
					</div> -->
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>
<?php } else { ?>
<div class="x_panel">
	<div class="x_title">
		<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['NAME']; } else { echo 'Add'; } ?></small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-success">
					<ul class="fa-ul">
						<li>
							<i class="fa fa-info-circle fa-lg fa-li"></i> For open data please <code>Right Click On Row Of Table</code>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>