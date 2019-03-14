<?php if(isset($data)) { ?>
<div id="form_id_<?php if(isset($data)) { echo $data['ID']; } else { echo '0'; } ?>" class="col-md-12 col-sm-12 col-xs-12">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Update</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>USERNAME</label>
							<input 
								name="username" 
								value="<?php echo $data['USERNAME'] ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter USERNAME"
								required=""
								readonly="">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label>ROLE</label>
								<input 
								readonly
								name="roll" 
								value="<?php echo $data['ROLL'] ?>" 
								type="email" 
								class="form-control">
							</div>
						</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>NAMA</label>
							<input 
								name="name" 
								value="<?php echo $data['NAMA'] ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Name"
								required="">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Phone</label>
							<input 
								name="phone" 
								value="<?php echo $data['PHONE'] ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Phone"
								required="">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Email</label>
							<input 
								name="email" 
								value="<?php echo $data['EMAIL'] ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter Email"
								required="">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>NPWP</label>
							<input 
								pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}.[0-9]{1}-[0-9]{3}.[0-9]{3}"
								title="format must be xx.xxx.xxx.x-xxx.xxx"
								name="npwp" 
								value="<?php echo $data['NPWP'] ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter NPWP"
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
<?php } else { ?>
<div class="x_panel">
	<div class="x_title">
		<h2>Update</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="alert alert-success">
					<ul class="fa-ul">
						<li>
							<i class="fa fa-info-circle fa-lg fa-li"></i> For update data please <code>Click Update Button</code>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>