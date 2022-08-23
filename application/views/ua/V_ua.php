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
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header border-0">
								<h4 class="">Top 10 Problem UA</h4>
							</div>
							<div class="card-body table-responsive p-0">
								<div class="row">
									<div class="col-6">
										<table class="table table-striped table-valign-middle">
											<thead>
											<tr>
												<th>No</th>
												<th>Problem</th>
<!--												<th>Qty</th>-->
												<th>Hours</th>
											</tr>
											</thead>
											<tbody>
											<?php
												$no = 1;
												if(!empty($stanby['kode'])){
													for ($i=0; $i < 5; $i++){
													?>
													<tr>
														<td><?php echo $no;?></td>
														<td><?php echo $stanby['kode'][$i];?></td>
<!--														<td>--><?php //echo $stanby['qty'][$i];?><!--</td>-->
														<td><?php echo $stanby['times'][$i];?></td>
													</tr>
													<?php
														$no++;
													}
												}
											?>
											</tbody>
										</table>
									</div>
									<div class="col-6">
										<table class="table table-striped table-valign-middle">
											<thead>
											<tr>
												<th>No</th>
												<th>Problem</th>
<!--												<th>Qty</th>-->
												<th>Hours</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if(!empty($stanby['kode'])){
												for ($j=5; $j < 10; $j++){
													?>
													<tr>
														<td><?php echo $no;?></td>
														<td><?php echo $stanby['kode'][$j];?></td>
<!--														<td>--><?php //echo $stanby['qty'][$j];?><!--</td>-->
														<td><?php echo $stanby['times'][$j];?></td>
													</tr>
													<?php
													$no++;
												}
											}
											?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
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
													<a href="<?php echo base_url().'Ua/detail_ua/'.$id_type_unit.'/'.$no_egi;?>" class="btn btn-primary">
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
