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
				<h4 class="mb-2">Info Breakdown Status (EGI <?php echo $egi;?>) <?php if($owner_name !='') echo ' Owner ('.$owner_name.')';?></h4>
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
								<div class="row">
									<div class="col-8">
										<h4 class="">Data CN Unit EGI (<?php echo $egi;?>) <?php if($owner_name !='') echo ' Owner ('.$owner_name.')';?></h4>
									</div>
									<div class="col-4">
										<button class="btn btn-primary" onclick="search()" style="float: right;">Search</button>
										<select class="form-control" name="owner" id="owner" style="float: right;width: 60%;">
											<option value="ALL" <?php if($owner_name == 'ALL') echo 'selected';?>>ALL</option>
											<?php
											if(!empty($list_owner)){
												for($a=0; $a < count($list_owner['owner']);$a++){
													$owner = $list_owner['owner'][$a];
													?>
													<option value="<?php echo $owner;?>" <?php if($owner_name == $owner) echo 'selected';?>><?php echo $owner;?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
									<tr>
										<th>No</th>
										<th>CN Unit</th>
										<th>Type Unit</th>
										<th>Type</th>
										<th>Brand</th>
										<th>Owner</th>
										<th>Total PA</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if(!empty($no_unit)){
										$no = 1;
										for ($i=0; $i < count($no_unit['no_unit']); $i++){
											$cn_unit = $no_unit['no_unit'][$i];
											$type_unit = $no_unit['type_unit'][$i];
											$type = $no_unit['type'][$i];
											$brand = $no_unit['brand'][$i];
											$owner = $no_unit['owner'][$i];
											?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $cn_unit;?></td>
												<td><?php echo $type_unit;?></td>
												<td><?php echo $type;?></td>
												<td><?php echo $brand;?></td>
												<td><?php echo $owner;?></td>
												<?php
												if($no_unit['detail'][$i]['response'] == 'avail'){
													$produksi = $no_unit['detail'][$i]['produksi'];
													$work = $no_unit['detail'][$i]['work'];
													$stanby = $no_unit['detail'][$i]['stanby'];
													$repair = $no_unit['detail'][$i]['repair'];
													$pa = (floatval($work + floatval($stanby))/(floatval($work) + floatval($stanby) + floatval($repair)));
													?>
													<td>
														<?php
														if(floatval($pa) && intval($pa) != floatval($pa)){
															echo number_format($pa,2);
														}else{
															echo $pa;
														};?>
													</td>
													<?php
												}else{
													?>
													<td>Empty</td>
													<?php
												}
												?>
												<td>
													<a href="<?php echo base_url().'Pa/detail_pa_unit/'.$id_type_unit.'/'.$cn_unit;?>" class="btn btn-primary">
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
			// order: [[ 1, "" ]] //column indexes is zero based
		});
	});
	$('#owner').select2({
		placeholder:"Select owner",
		allowClear: true
	});
	function search(){
		var owner = $('#owner').val();
		if(owner == ''){
			swal({
				icon: 'warning',
				title: 'Failed, Because Incomplete Data',
				showConfirmButton: false,
				timer: 4000
			})
		}else{
			window.location.href = '<?= base_url();?>Pa/search_data_pa_owner/'+'<?php echo $id_type_unit;?>'+'/'+'<?= $egi;?>'+'/'+owner;
		}
	}
</script>
</body>
</html>
