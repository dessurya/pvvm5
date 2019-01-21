<div class="x_panel">
	<div class="x_title">
		<h2><?php echo strtoupper($vendor['NAME']) ?><small>Vendor</small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Name</label>
							<input 
								readonly
								name="NAME" 
								value="<?php echo $vendor['NAME'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Username</label>
							<input 
								readonly
								name="USERNAME" 
								value="<?php echo $vendor['USERNAME'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input 
								readonly
								name="EMAIL" 
								value="<?php echo $vendor['EMAIL'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Phone</label>
							<input 
								readonly
								name="PHONE" 
								value="<?php echo $vendor['PHONE'] ?>" 
								type="text" 
								class="form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>