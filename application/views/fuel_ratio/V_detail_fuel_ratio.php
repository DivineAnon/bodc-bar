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
										<th>Total Fuel Ratio</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php
									if(!empty($no_unit)){
										$no = 1;
										for ($i=0; $i < count($no_unit['no_unit']); $i++){
											$cn_unit = $no_unit['no_unit'][$i];
											$id_type_unit = $no_unit['id_type_unit'][$i];
											$type_unit = $no_unit['type_unit'][$i];
											$type = $no_unit['type'][$i];
											$brand = $no_unit['brand'][$i];
											$owner = $no_unit['owner'][$i];
											$fuel_ratio = $no_unit['fuel_ratio'][$i];
											?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $cn_unit;?></td>
												<td><?php echo $type_unit;?></td>
												<td><?php echo $type;?></td>
												<td><?php echo $brand;?></td>
												<td><?php echo $owner;?></td>
												<td><?php echo $fuel_ratio;?></td>
												<td>
													<a href="<?php echo base_url().'Fuel_ratio/detail_unit/'.$id_type_unit.'/'.$cn_unit;?>" class="btn btn-primary">
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
			window.location.href = '<?= base_url();?>Fuel_ratio/search_data_fuel_ratio_owner/'+'<?php echo $id_type_unit;?>'+'/'+'<?= $egi;?>'+'/'+owner;
		}
	}
</script>
</body>
</html>
