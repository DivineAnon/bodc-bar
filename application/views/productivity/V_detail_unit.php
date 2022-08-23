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
								<h4>All Data CN Unit <?php echo $no_unit;?>
									(<?php if($detail_unit['response'] == 'avail'){
										echo $detail_unit['day'].' Day';
									}else{
										echo '0 Day';
									}?>)
								</h4>
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
											<h4>Work : <?php
												if(floatval($detail_unit['work']) && intval($detail_unit['work']) != floatval($detail_unit['work'])){
													echo number_format($detail_unit['work'],2);
												}else{
													echo $detail_unit['work'];
												};?>
											</h4><br>
											<h4>Stanby : <?php
												if(floatval($detail_unit['stanby']) && intval($detail_unit['stanby']) != floatval($detail_unit['stanby'])){
													echo number_format($detail_unit['stanby'],2);
												}else{
													echo $detail_unit['stanby'];
												};?>
											</h4><br>
											<h4>Repair : <?php
												if(floatval($detail_unit['repair']) && intval($detail_unit['repair']) != floatval($detail_unit['repair'])){
													echo number_format($detail_unit['repair'],2);
												}else{
													echo $detail_unit['repair'];
												};?>
											</h4><br>
											<h4>Productivity : <?php
												if(floatval($prod) && intval($prod) != floatval($prod)){
													echo number_format($prod,2);
												}else{
													echo $prod;
												};?>
											</h4>
											<?php
										}else{
											?>
											<h4>Work : 0</h4><br>
											<h4>Stanby : 0</h4><br>
											<h4>Repair : 0</h4><br>
											<h4>Productivity : 0</h4>
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
								<div class="row">
									<div class="col-8">
										<h4>Data CN Unit <?php echo $no_unit;?> <?php if($periode != ''){ echo 'Periode '.$periode;}else{echo 'Per Day';}?></h4>
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
										<th class="sorting_asc">No</th>
										<th>CN Unit</th>
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
				$('#work').text('Work : '+response.work);
				$('#stanby').text('Stanby : '+response.stanby);
				$('#prod').text('Productivity : '+response.prod);
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
	function search() {
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();

		// var start = new Date(start_date);
		// var end = new Date(end_date);

		if (start_date == '' || end_date == '') {
			swal({
				icon: 'warning',
				title: 'Failed, Because Incomplete Data',
				showConfirmButton: false,
				timer: 4000
			})
		} else if(moment(start_date).format("YYYY-MM-DD") > moment(end_date).format("YYYY-MM-DD")) {
			swal({
				icon: 'warning',
				title: 'Failed, Because End Date must be greater Start Date',
				showConfirmButton: false,
				timer: 4000
			})
		} else {
			window.location.href = '<?= base_url();?>Productivity/detail_productivity_unit_range/' + '<?php echo $id_type_unit;?>' + '/' + '<?php echo $no_unit;?>' + '/' + start_date + '/' + end_date;
		}
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
						<h4 id="prod"></h4>
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
