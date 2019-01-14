<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul class="nav nav-tabs bar_tabs right" role="tablist">
						<li role="presentation" class="">
							<a href="#tab_dashboard" role="tab" data-toggle="tab" aria-expanded="true">Dashboard</a>
						</li>
						<li role="presentation" class="active">
							<a href="#tab_profile" role="tab" data-toggle="tab" aria-expanded="true">Prfile</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_profile">
							<h2>Detail</h2>
							<div class="col-md-4">
								
							</div>
							<div class="col-md-8">
								<table class="table">
									<tr>
										<th>Nama</th>
										<td><?php echo $detailProfile['NAME'] ?></td>
									</tr>
									<tr>
										<th>Email</th>
										<td><?php echo $detailProfile['EMAIL'] ?></td>
									</tr>
									
								</table>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade in" id="tab_dashboard">
							Dashborad 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>