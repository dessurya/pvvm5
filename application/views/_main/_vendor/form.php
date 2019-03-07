<div id="form_id_<?php if(isset($data)) { echo $data['VENDOR_ID']; } else { echo '0'; } ?>" class="col-md-6 col-sm-6 col-xs-6">
	<form action="<?php echo $route ?>" class="form-horizontal form-label-left store" method="post">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['NAMA']; } else { echo 'Add'; } ?></small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-12">
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
					<div class="col-md-12">
						<div class="form-group">
							<label>NPWP</label>
							<input 
								pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}.[0-9]{1}-[0-9]{3}.[0-9]{3}"
								title="format must be xx.xxx.xxx.x-xxx.xxx"
								name="npwp" 
								value="<?php if(isset($data)) { echo $data['NPWP']; } ?>" 
								type="text" 
								class="form-control" 
								placeholder="Enter NPWP"
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