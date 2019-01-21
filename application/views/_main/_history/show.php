<div class="x_panel">
	<div class="x_title">
		<h2>History : <?php echo $head['CREATED_DATE'] ?></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Date</label>
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
					<label>On</label>
					<input 
						readonly=""
						name="TABLE_NAME" 
						value="<?php echo $head['TABLE_NAME'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Username</label>
					<input 
						readonly=""
						name="USERNAME" 
						value="<?php echo $head['USERNAME'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Name</label>
					<input 
						readonly=""
						name="" 
						value="<?php echo $detail['DETAILAUTH']['NAME'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Roll</label>
					<input 
						readonly=""
						name="ROLL" 
						value="<?php echo $head['ROLL'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Activity</label>
					<input 
						readonly=""
						name="ACTION_TYPE" 
						value="<?php echo $head['ACTION_TYPE'] ?>" 
						type="text" 
						class="form-control">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Description</label>
					<textarea 
						readonly="" 
						name="DESCRIPTION" 
						class="form-control"
						rows="5"
					><?php echo $head['DESCRIPTION'] ?></textarea> 
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Data</label>
					<textarea 
						readonly="" 
						name="JSON" 
						class="form-control"
						rows="5"
					><?php echo $head['JSON'] ?></textarea> 
				</div>
			</div>
		</div>
	</div>
</div>