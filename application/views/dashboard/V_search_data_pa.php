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
				<h4 class="mb-2">Info Breakdown Status (<?php echo $type_unit;?>) Periode <?php echo $tgl;?></h4>
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
										<h4 class="">Data CN Unit (<?php echo $type_unit;?>) Periode (<?php echo $tgl;?>)</h4>
									</div>
									<div class="col-4">
										<button class="btn btn-primary" onclick="search()" style="float: right; margin-left: 5px;">Search</button>
										<input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" style="width: 35%;float: right; margin-left: 5px;">
										<input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" style="width: 35%; float:right;">
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
										<th>EGI</th>
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
											$egi = $no_unit['egi'][$i];
											$id_type_unit = $no_unit['id_type_unit'][$i];
											$type_unit = $no_unit['type_unit'][$i];
											$type = $no_unit['type'][$i];
											$brand = $no_unit['brand'][$i];
											$owner = $no_unit['owner'][$i];
											$id_activity = $no_unit['id_activity'][$i];
											?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $cn_unit;?></td>
												<td><?php echo $egi;?></td>
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
													<a href="#" onclick="detail('<?php echo $id_activity;?>')" class="btn btn-primary">
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
	$(document).ready(function(){
		flatpickr("#start_date", {
			allowInput: true,
			enableTime: false,
			// minDate: "today",
			time_24hr: false,
			dateFormat: "d-M-Y"
		});
		flatpickr("#end_date", {
			allowInput: true,
			enableTime: false,
			// minDate: "today",
			time_24hr: false,
			dateFormat: "d-M-Y"
		});
	});
	function search(){
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();

		// var start = new Date(start_date);
		// var end = new Date(end_date);

		if(start_date == '' || end_date == ''){
			swal({
				icon: 'warning',
				title: 'Failed, Because Incomplete Data',
				showConfirmButton: false,
				timer: 4000
			})
		}else if(moment(start_date).format("YYYY-MM-DD") > moment(end_date).format("YYYY-MM-DD")) {
			swal({
				icon: 'warning',
				title: 'Failed, Because End Date must be greater Start Date',
				showConfirmButton: false,
				timer: 4000
			})
		}else{
			window.location.href = '<?= base_url();?>Dashboard/search_data_pa_range/'+start_date+'/'+end_date+'/'+'<?= $type_unit;?>';
		}
	}
	function detail(id){
		$.ajax({
			type: "GET",
			url: '<?php echo base_url().'Data/get_data_unit_detail_per_tgl/';?>'+id,
			dataType: 'json',
			success: function(response){
				console.log(response);
				var work = response.work;
				var stanby = response.stanby;
				var repair = response.repair;
				$('#work').text('Work : '+response.work);
				$('#stanby').text('Stanby : '+response.stanby);
				$('#pa').text('PA : '+response.pa);
				$('#repair').text('Repair : '+response.repair);
				$('#title').text('CN Unit '+response.no_unit+' Tanggal '+response.tgl_aktifitas);
				var chart_pie = $('#chart_pie').get(0).getContext('2d');

				var data = {
					datasets: [{
						data: [work, stanby, repair],
						backgroundColor : ['#00a65a', '#f39c12', '#f56954'],

					}],

					// These labels appear in the legend and in the tooltips when hovering different arcs
					labels: [
						'Work',
						'Standby',
						'Repair'
					]
				};
				var myPieChart = new Chart(chart_pie, {
					type: 'doughnut',
					data: data,
					// options: options
				});

				$('#modal-xl').modal('show');
			},
			error: function (request, error) {
				swal({
					icon: 'warning',
					title: 'Failed, Because Incomplete Data',
					showConfirmButton: false,
					timer: 4000
				})
			},
		});
	}
</script>
<div class="modal fade" id="modal-xl">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="title"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
						<canvas id="chart_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
					<div class="col-6">
						<h4 id="work"></h4><br>
						<h4 id="stanby"></h4><br>
						<h4 id="repair"></h4><br>
						<h4 id="pa"></h4>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
</body>
</html>
