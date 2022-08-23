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
							<div class="card-header">
								<div class="row">
									<div class="col-8">
										<h4 class="">Data CN Unit Periode (<?php echo $tgl;?>)</h4>
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
										<th><?php echo $material;?></th>
										<th>Total <?php echo $material;?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									if(!empty($no_unit)){
										$no = 1;
										for ($i=0; $i < count($no_unit['no_unit']); $i++){
											$cn_unit = $no_unit['no_unit'][$i];
											$egi = $no_unit['egi'][$i];
											$type_unit = $no_unit['type_unit'][$i];
											$type = $no_unit['type'][$i];
											$brand = $no_unit['brand'][$i];
											$owner = $no_unit['owner'][$i];
											$total = $no_unit['total'][$i];
											?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $cn_unit;?></td>
												<td><?php echo $egi;?></td>
												<td><?php echo $type_unit;?></td>
												<td><?php echo $type;?></td>
												<td><?php echo $brand;?></td>
												<td><?php echo $owner;?></td>
												<td><?php echo $total;?></td>
												<td><?php echo $total * $qty;?></td>
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
			window.location.href = '<?= base_url();?>Dashboard/search_data_produksi_range/'+start_date+'/'+end_date+'/'+'<?= $material;?>';
		}
	}
</script>
</body>
</html>
