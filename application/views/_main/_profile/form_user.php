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
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>USERNAME</label>
							<input 
							readonly
							name="username" 
							value="<?php echo $data['USERNAME'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>ROLL</label>
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
							value="<?php echo $data['NAME'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>NIPP</label>
							<input 
							name="nipp" 
							value="<?php echo $data['NIPP'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>PHONE</label>
							<input 
							name="phone" 
							value="<?php echo $data['PHONE'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>EMAIL</label>
							<input 
							name="email" 
							value="<?php echo $data['EMAIL'] ?>" 
							type="email" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>POSISI</label>
							<input 
							name="posisi" 
							value="<?php echo $data['POSISI'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>ORGANISASI</label>
							<input 
							name="organisasi" 
							value="<?php echo $data['ORGANISASI'] ?>" 
							type="text" 
							class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="form-group">
							<label>NPWP</label>
							<input 
							name="npwp" 
							value="<?php echo $data['NPWP'] ?>" 
							type="text" 
							class="form-control">
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
			<h2>Form <small><?php if(isset($data)) { echo 'Update '.$data['USERNAME']; } else { echo 'Add'; } ?></small></h2>
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