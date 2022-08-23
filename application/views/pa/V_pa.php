<!DOCTYPE html>
<html lang="en">
<?php echo $head;?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
	<!-- Navbar -->
	<?php echo $header;?>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<?php echo $sidebar;?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<h4 class="mb-2">Info Breakdown Status</h4>
				<div class="row">
					<div class="col-md-3 col-sm-6 col-12">
						<div class="info-box">
							<span class="info-box-icon bg-info">SCM</i></span>

							<div class="info-box-content">
								<h3>
									<?php
										$pres = '';
										if(!empty($breakdown['breakdown_status']['SCM'])){
											$pres = ($breakdown['seconds']['SCM'] / $breakdown['total_seconds']) * 100;
											echo $breakdown['breakdown_status']['SCM'];
										}else{
											echo 'Empty';
										}
									?>
								</h3>
								<h5 style="color: #17a2b8; margin-top: -10px;">
									<?php
									if($pres != ''){
										echo round($pres,2).'%';
									}
									?>
								</h5>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-12">
						<div class="info-box">
							<span class="info-box-icon bg-success">USM</i></span>

							<div class="info-box-content">
								<h3>
									<?php
									$pres = '';
									if(!empty($breakdown['breakdown_status']['USM'])){
										$pres = ($breakdown['seconds']['USM'] / $breakdown['total_seconds']) * 100;
										echo $breakdown['breakdown_status']['USM'];
									}else{
										echo 'Empty';
									}
									?>
								</h3>
								<h5 style="color: #28a745; margin-top: -10px;">
									<?php
									if($pres != ''){
										echo round($pres,2).'%';
									}
									?>
								</h5>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-12">
						<div class="info-box">
							<span class="info-box-icon bg-primary">TRM</i></span>

							<div class="info-box-content">
								<h3>
									<?php
									$pres = '';
									if(!empty($breakdown['breakdown_status']['TRM'])){
										$pres = ($breakdown['seconds']['TRM'] / $breakdown['total_seconds']) * 100;
										echo $breakdown['breakdown_status']['TRM'];
									}else{
										echo 'Empty';
									}
									?>
								</h3>
								<h5 style="color: #007bff; margin-top: -10px;">
									<?php
									if($pres != ''){
										echo round($pres,2).'%';
									}
									?>
								</h5>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-md-3 col-sm-6 col-12">
						<div class="info-box">
							<span class="info-box-icon bg-danger">ICM</i></span>

							<div class="info-box-content">
								<h3>
									<?php
									$pres = '';
									if(!empty($breakdown['breakdown_status']['ICM'])){
										$pres = ($breakdown['seconds']['ICM'] / $breakdown['total_seconds']) * 100;
										echo $breakdown['breakdown_status']['ICM'];
									}else{
										echo 'Empty';
									}
									?>
								</h3>
								<h5 style="color: #dc3545; margin-top: -10px;">
									<?php
										if($pres != ''){
											echo round($pres,2).'%';
										}
									?>
								</h5>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4 class="">All Data EGI (<?php echo $type_unit;?>)</h4>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
									<tr>
										<th>No</th>
										<th>EGI</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if(!empty($egi)){
										$no = 1;
										for ($i=0; $i < count($egi['egi']); $i++){
											$no_egi = $egi['egi'][$i];
											?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $no_egi;?></td>
												<td>
													<a href="<?php echo base_url().'Pa/detail_pa/'.$id_type_unit.'/'.$no_egi;?>" class="btn btn-primary">
														Detail
													</a>
												</td>
											</tr>
											<?php
											$no++;
										}
									}
									?>
									</tbody>
								</table>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->

					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<?php echo $footer;?>

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php echo $script;?>
<script>
	$(function () {
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
			order: [[ 1, "" ]] //column indexes is zero based
		});
	});
</script>
</body>
</html>
