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
				<div class="row mb-3">
					<div class="col-12">

						<div class="card">
							<div class="card-header">
								<h3>All Data No Unit <?php echo $no_unit;?>
									(<?php if($detail_unit['response'] == 'avail'){
										echo $detail_unit['day'].' Day';
									}else{
										echo '0 Day';
									}?>)
								</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<?php
											if($detail_unit['response'] == 'avail'){
										?>
												<canvas id="chart_all_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
										<?php
											}else{
										?>
										<h4>No Data</h4>
										<?php
											}
										?>
									</div>
									<div class="col-6">
										<?php
											if($detail_unit['response'] == 'avail'){
												$pa = (floatval($detail_unit['work']) + floatval($detail_unit['stanby']))/(floatval($detail_unit['work']) + floatval($detail_unit['stanby']) + floatval($detail_unit['repair']));
												$ua = floatval($detail_unit['work'])/(floatval($detail_unit['work']) + floatval($detail_unit['stanby']));
												$prod = floatval($detail_unit['produksi'])/floatval($detail_unit['work']);
										?>
											<h4>PA : <?php
												if(floatval($pa) && intval($pa) != floatval($pa)){
													echo number_format($pa,2);
												}else{
													echo $pa;
												};?>
											</h4><br>
											<h4>UA : <?php
												if(floatval($ua) && intval($ua) != floatval($ua)){
													echo number_format($ua,2);
												}else{
													echo $ua;
												};?>
											</h4><br>
											<h4>Productivity : <?php
												if(floatval($prod) && intval($prod) != floatval($prod)){
													echo number_format($prod,2);
												}else{
													echo $prod;
												};?>
											</h4><br>
											<h4>Produksi : <?php
												if(floatval($detail_unit['produksi']) && intval($detail_unit['produksi']) != floatval($detail_unit['produksi'])){
													echo number_format($detail_unit['produksi'],2).' Ton';
												}else{
													echo $detail_unit['produksi'].' Ton';
												};?>
											</h4>
										<?php
											}else{
										?>
											<h4>PA : 0</h4><br>
											<h4>UA : 0</h4><br>
											<h4>Productivity : 0</h4><br>
											<h4>Produksi : 0</h4>
										<?php
											}
										?>
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
								<h3>Data No Unit <?php echo $no_unit;?> Per Day</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
									<tr>
										<th>No</th>
										<th>No Unit</th>
										<th>Date Activity</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
										<?php
											if(!empty($no_unit_tgl)){
												$no = 1;
												for ($i=0; $i < count($no_unit_tgl['id']); $i++){
													$id = $no_unit_tgl['id'][$i];
													$no_unit2 = $no_unit_tgl['no_unit'][$i];
													$tgl_aktifitas = $no_unit_tgl['tgl_aktifitas'][$i];
												?>
												<tr>
													<td><?php echo $no;?></td>
													<td><?php echo $no_unit2;?></td>
													<td><?php echo date('d F Y', strtotime($tgl_aktifitas));?></td>
													<td>
														<a href="#" onclick="detail('<?php echo $id;?>')" class="btn btn-primary">
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
			"autoWidth": false,
			"responsive": true,
			order: [[ 1, "" ]] //column indexes is zero based
		});
	});
</script>
<?php
	if($detail_unit['response'] == 'avail' ){
?>
<script>
	var chart_all_pie = $('#chart_all_pie').get(0).getContext('2d');

	var data_all = {
		datasets: [{
			data: [<?php echo $detail_unit['work'];?>, <?php echo $detail_unit['stanby'];?>, <?php echo $detail_unit['repair'];?>],
			backgroundColor : ['#00a65a', '#f39c12', '#f56954'],

		}],

		// These labels appear in the legend and in the tooltips when hovering different arcs
		labels: [
			'Work',
			'Standby',
			'Repair'
		]
	};
	var myPieChart = new Chart(chart_all_pie, {
		type: 'doughnut',
		data: data_all,
		// options: options
	});
</script>
<?php
	}
?>

<script>
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
				$('#pa').text('PA : '+response.pa);
				$('#ua').text('UA : '+response.ua);
				$('#prod').text('Productivity : '+response.prod);
				$('#produksi').text('Produksi : '+response.produksi);
				$('#title').text('No Unit '+response.no_unit+' Tanggal '+response.tgl_aktifitas);
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
						<h4 id="pa"></h4><br>
						<h4 id="ua"></h4><br>
						<h4 id="prod"></h4><br>
						<h4 id="produksi"></h4>
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
