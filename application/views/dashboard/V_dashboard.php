<!DOCTYPE html>
<html lang="en">
<?php echo $head;?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

	<!-- Navbar -->
	<?php echo $header;?>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<?php echo $sidebar;?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-7">
						<h1 class="m-0">Dashboard</h1>
					</div>
					<div class="col-5">
						<button class="btn btn-primary" onclick="search()" style="float: right; margin-left: 5px;">Search</button>
						<input type="text" class="form-control" value="<?php echo $end_date;?>" name="end_date" id="end_date" placeholder="End Date" style="width: 25%;float: right; margin-left: 5px;">
						<input type="text" class="form-control" value="<?php echo $start_date;?>" name="start_date" id="start_date" placeholder="Start Date" style="width: 25%; float:right;">
					</div>
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Main row -->
				<div class="row">
					<section class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data Produksi (OB & Coal)
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="produksi"></div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section class="col-lg-6 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data PA Loader
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="pa_loader"></div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section class="col-lg-6 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data PA Hauler
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="pa_hauler"></div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section class="col-lg-6 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data UA Loader
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="ua_loader"></div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section class="col-lg-6 col-md-12 col-sm-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data UA Hauler
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="ua_hauler"></div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data Productivity (Loader & Hauler)
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="prod"></div>
									</div>
								</div>
							</div>
					</section>
					<section class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data Fuel Ratio (Loader & Hauler)
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="fuel"></div>
									</div>
								</div>
							</div>
					</section>
					<section class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data Top 10 Problem UA (Loader & Hauler)
								</h3>
								<div class="card-body table-responsive">
									<div class="tab-content p-0">
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
					</section>
					<section class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fas fa-chart-bar mr-1"></i>
									Data Breakdown Status (Loader & Hauler)
								</h3>
								<div class="card-body">
									<div class="tab-content p-0">
										<div id="breakdown"></div>
									</div>
								</div>
							</div>
					</section>
				</div>
				<!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
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

	Highcharts.chart('produksi', {
		chart: {
			type: 'area'
		},
		title: {
			text: 'Data Plan (<?php echo round(array_sum($produksi_ob_plan),2) + round(array_sum($produksi_coal_plan),2);?>) & Actual (<?php echo round(array_sum($produksi_ob),2) + round(array_sum($produksi_coal),2);?>)',
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: <?php echo json_encode($day);?>,
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Total Produksi'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			},
			series: {
				cursor: 'pointer',
				point: {
					events: {
						click: function (event) {
							var name = event.point.series.name;
							// console.log(name);
							if(name == 'OB (Plan)' || name == 'Coal (Plan)') {
								// alert('masuk');
							}else{
								window.location.href = '<?= base_url();?>Dashboard/search_data_produksi/'+event.point.category+'/'+name.replace("(Actual)","");
							}
						}
					}
				},
				marker: {
					lineWidth: 1
				}
			}
		},
		series: [
		{
			name: 'OB (Plan)',
			data: <?php echo json_encode($produksi_ob_plan);?>
		}, {
			name: 'Coal (Plan)',
			data: <?php echo json_encode($produksi_coal_plan);?>
		}, {
			name: 'OB (Actual)',
			data: <?php echo json_encode($produksi_ob);?>

		}, {
			name: 'Coal (Actual)',
			data: <?php echo json_encode($produksi_coal);?>

		}]
	});

	Highcharts.chart('prod', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Data Plan (<?php echo round(array_sum($prod_loader_plan),2) + round(array_sum($prod_hauler_plan),2);?>) & Actual (<?php echo round(array_sum($prod_loader),2) + round(array_sum($prod_hauler),2);?>)',
		},
		xAxis: {
			categories: <?php echo json_encode($day);?>,
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			}
		},
		yAxis: {
			title: {
				text: 'Total CN Unit'
			},
			labels: {
				formatter: function () {
					return this.value;
				}
			}
		},
		tooltip: {
			split: true,
			valueSuffix: ''
		},
		plotOptions: {
			area: {
				stacking: 'normal',
				lineColor: '#666666',
				lineWidth: 1,
				marker: {
					lineWidth: 1,
					lineColor: '#666666'
				}
			},
			series: {
				cursor: 'pointer',
				point: {
					events: {
						click: function (event) {
							var name = event.point.series.name;
							if(name == 'Loader (Plan)' || name == 'Hauler (Plan)'){

							}else{
								window.location.href = '<?= base_url();?>Dashboard/search_data_prod/'+event.point.category+'/'+name.replace("(Actual)","");
							}
						}
					}
				},
				marker: {
					lineWidth: 1
				}
			}
		},
		series: [
		{
			name: 'Loader (Plan)',
			data: <?php echo json_encode($prod_loader_plan);?>
		}, {
			name: 'Hauler (Plan)',
			data: <?php echo json_encode($prod_hauler_plan);?>
		}, {
			name: 'Loader (Actual)',
			data: <?php echo json_encode($prod_loader);?>
		}, {
			name: 'Hauler (Actual)',
			data: <?php echo json_encode($prod_hauler);?>
		}]
	});

	Highcharts.chart('fuel', {
		chart: {
			type: 'area'
		},
		title: {
			text: 'Data Plan (<?php echo round(array_sum($fuel_loader_plan),2) + round(array_sum($fuel_hauler_plan),2);?>) & Actual (<?php echo round(array_sum($fuel_loader),2) + round(array_sum($fuel_hauler),2);?>)',
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: <?php echo json_encode($day);?>,
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Total Fuel Ratio (lt/bcm)'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.1f} lt/bcm</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			},
			series: {
				cursor: 'pointer',
				point: {
					events: {
						click: function (event) {
							var name = event.point.series.name;
							window.location.href = '<?= base_url();?>Dashboard/search_data_fuel_ratio/'+event.point.category+'/'+name.replace("(Actual)","");
						}
					}
				},
				marker: {
					lineWidth: 1
				}
			}
		},
		series: [
		{
			name: 'Loader (Plan)',
			data: <?php echo json_encode($fuel_loader_plan);?>
		},{
			name: 'Hauler (Plan)',
			data: <?php echo json_encode($fuel_hauler_plan);?>
		},{
			name: 'Loader (Actual)',
			data: <?php echo json_encode($fuel_loader);?>
		},{
			name: 'Hauler (Actual)',
			data: <?php echo json_encode($fuel_hauler);?>
		}]
	});

	Highcharts.chart('breakdown', {
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: <?php echo json_encode($day);?>
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Total Hours'
			},
			stackLabels: {
				enabled: true,
				style: {
					fontWeight: 'bold',
					color: ( // theme
							Highcharts.defaultOptions.title.style &&
							Highcharts.defaultOptions.title.style.color
					) || 'gray'
				}
			}
		},
		legend: {
			align: 'right',
			x: -30,
			verticalAlign: 'top',
			y: 25,
			floating: true,
			backgroundColor:
					Highcharts.defaultOptions.legend.backgroundColor || 'white',
			borderColor: '#CCC',
			borderWidth: 1,
			shadow: false
		},
		tooltip: {
			headerFormat: '<b>{point.x}</b><br/>',
			pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
		},
		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {
					enabled: true
				},
				cursor: 'pointer',
				point: {
					events: {
						click: function() {
							window.location.href = '<?= base_url();?>Dashboard/search_data_breakdown/'+event.point.category+'/'+event.point.series.name;
						}
					}
				}
			}
		},
		series: [{
			name: 'SCM',
			data: <?php echo json_encode($SCM);?>
		}, {
			name: 'USM',
			data: <?php echo json_encode($USM);?>
		}, {
			name: 'TRM',
			data: <?php echo json_encode($TRM);?>
		}, {
			name: 'ICM',
			data: <?php echo json_encode($ICM);?>
		}]
	});

	function search(){
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();

		// var start = new Date(start_date);
		// var end = new Date(end_date);

		// var start = moment(start_date,"DD/MM/YYYY");
		// var end = moment(end_date,"DD/MM/YYYY");
		// console.log(start);



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
			window.location.href = '<?= base_url();?>Dashboard/search_data/'+start_date+'/'+end_date;
		}
	}

</script>
<script>
	//pa
	am4core.ready(function() {

// Themes begin
		am4core.useTheme(am4themes_animated);
// Themes end

// create chart
		var chart = am4core.create("pa_loader", am4charts.GaugeChart);
		chart.innerRadius = am4core.percent(82);

		/**
		 * Normal axis
		 */

		var axis = chart.xAxes.push(new am4charts.ValueAxis());
		axis.min = 0;
		axis.max = 100;
		axis.strictMinMax = true;
		axis.renderer.radius = am4core.percent(80);
		axis.renderer.inside = true;
		axis.renderer.line.strokeOpacity = 1;
		axis.renderer.ticks.template.disabled = false
		axis.renderer.ticks.template.strokeOpacity = 1;
		axis.renderer.ticks.template.length = 10;
		axis.renderer.grid.template.disabled = true;
		axis.renderer.labels.template.radius = 40;
		axis.renderer.labels.template.adapter.add("text", function(text) {
			return text ;
		})

		/**
		 * Axis for ranges
		 */

		var colorSet = new am4core.ColorSet();

		var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
		axis2.min = 0;
		axis2.max = 100;
		axis2.strictMinMax = true;
		axis2.renderer.labels.template.disabled = true;
		axis2.renderer.ticks.template.disabled = true;
		axis2.renderer.grid.template.disabled = true;

		var range0 = axis2.axisRanges.create();
		range0.value = 0;
		range0.endValue = 50;
		range0.axisFill.fillOpacity = 1;
		range0.axisFill.fill = colorSet.getIndex(0);

		var range1 = axis2.axisRanges.create();
		range1.value = 50;
		range1.endValue = 100;
		range1.axisFill.fillOpacity = 1;
		range1.axisFill.fill = colorSet.getIndex(2);

		/**
		 * Label
		 */

		var label = chart.radarContainer.createChild(am4core.Label);
		label.isMeasured = false;
		label.fontSize = 45;
		label.x = am4core.percent(50);
		label.y = am4core.percent(100);
		label.horizontalCenter = "middle";
		label.verticalCenter = "bottom";
		label.text = "50%";


		/**
		 * Hand
		 */

		var hand = chart.hands.push(new am4charts.ClockHand());
		hand.axis = axis2;
		hand.innerRadius = am4core.percent(20);
		hand.startWidth = 10;
		hand.pin.disabled = true;
		hand.value = 50;

		hand.events.on("propertychanged", function(ev) {
			range0.endValue = ev.target.value;
			range1.value = ev.target.value;
			label.text = axis2.positionToValue(hand.currentPosition).toFixed(1)+' %';
			axis2.invalidate();
		});

		var value = <?php echo json_encode($pa_loader2);?>;
		var animation = new am4core.Animation(hand, {
			property: "value",
			to: value
		}, 1000, am4core.ease.cubicOut).start();

		// Add chart title
		var title = chart.titles.create();
		title.text = "Data Plan (<?php echo json_encode($pa_loader_plan2);?>) & Actual (<?php echo json_encode($pa_loader2);?>)";
		title.fontSize = 25;
		// title.marginBottom = -150;

		var button = chart.chartContainer.createChild(am4core.Button);
		button.label.text = "Detail";
		button.padding(5, 5, 5, 5);
		button.width = 80;
		button.align = "center";
		button.marginRight = 15;
		button.events.on("hit", function() {
			window.location.href = "<?php echo base_url().'Dashboard/search_data_pa/'.$start_date.'/'.$end_date.'/Loader';?>";
		});
	}); // end am4core.ready()

	am4core.ready(function() {

// Themes begin
		am4core.useTheme(am4themes_animated);
// Themes end

// create chart
		var chart = am4core.create("pa_hauler", am4charts.GaugeChart);
		chart.innerRadius = am4core.percent(82);

		/**
		 * Normal axis
		 */

		var axis = chart.xAxes.push(new am4charts.ValueAxis());
		axis.min = 0;
		axis.max = 100;
		axis.strictMinMax = true;
		axis.renderer.radius = am4core.percent(80);
		axis.renderer.inside = true;
		axis.renderer.line.strokeOpacity = 1;
		axis.renderer.ticks.template.disabled = false
		axis.renderer.ticks.template.strokeOpacity = 1;
		axis.renderer.ticks.template.length = 10;
		axis.renderer.grid.template.disabled = true;
		axis.renderer.labels.template.radius = 40;
		axis.renderer.labels.template.adapter.add("text", function(text) {
			return text ;
		})

		/**
		 * Axis for ranges
		 */

		var colorSet = new am4core.ColorSet();

		var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
		axis2.min = 0;
		axis2.max = 100;
		axis2.strictMinMax = true;
		axis2.renderer.labels.template.disabled = true;
		axis2.renderer.ticks.template.disabled = true;
		axis2.renderer.grid.template.disabled = true;

		var range0 = axis2.axisRanges.create();
		range0.value = 0;
		range0.endValue = 50;
		range0.axisFill.fillOpacity = 1;
		range0.axisFill.fill = colorSet.getIndex(0);

		var range1 = axis2.axisRanges.create();
		range1.value = 50;
		range1.endValue = 100;
		range1.axisFill.fillOpacity = 1;
		range1.axisFill.fill = colorSet.getIndex(2);

		/**
		 * Label
		 */

		var label = chart.radarContainer.createChild(am4core.Label);
		label.isMeasured = false;
		label.fontSize = 45;
		label.x = am4core.percent(50);
		label.y = am4core.percent(100);
		label.horizontalCenter = "middle";
		label.verticalCenter = "bottom";
		label.text = "50%";


		/**
		 * Hand
		 */

		var hand = chart.hands.push(new am4charts.ClockHand());
		hand.axis = axis2;
		hand.innerRadius = am4core.percent(20);
		hand.startWidth = 10;
		hand.pin.disabled = true;
		hand.value = 50;

		hand.events.on("propertychanged", function(ev) {
			range0.endValue = ev.target.value;
			range1.value = ev.target.value;
			label.text = axis2.positionToValue(hand.currentPosition).toFixed(1)+' %';
			axis2.invalidate();
		});

		var value = <?php echo json_encode($pa_hauler2);?>;
		var animation = new am4core.Animation(hand, {
			property: "value",
			to: value
		}, 1000, am4core.ease.cubicOut).start();

		// Add chart title
		var title = chart.titles.create();
		title.text = "Data Plan (<?php echo json_encode($pa_hauler_plan2);?>) & Actual (<?php echo json_encode($pa_hauler2);?>)";
		title.fontSize = 25;

		var button = chart.chartContainer.createChild(am4core.Button);
		button.label.text = "Detail";
		button.padding(5, 5, 5, 5);
		button.width = 80;
		button.align = "center";
		button.marginRight = 15;
		button.events.on("hit", function() {
			window.location.href = "<?php echo base_url().'Dashboard/search_data_pa/'.$start_date.'/'.$end_date.'/Hauler';?>";
		});
		// title.marginBottom = -150;
	}); // end am4core.ready()

	//ua
	am4core.ready(function() {

// Themes begin
		am4core.useTheme(am4themes_material);
// Themes end

// create chart
		var chart = am4core.create("ua_loader", am4charts.GaugeChart);
		chart.innerRadius = am4core.percent(82);

		/**
		 * Normal axis
		 */

		var axis = chart.xAxes.push(new am4charts.ValueAxis());
		axis.min = 0;
		axis.max = 100;
		axis.strictMinMax = true;
		axis.renderer.radius = am4core.percent(80);
		axis.renderer.inside = true;
		axis.renderer.line.strokeOpacity = 1;
		axis.renderer.ticks.template.disabled = false
		axis.renderer.ticks.template.strokeOpacity = 1;
		axis.renderer.ticks.template.length = 10;
		axis.renderer.grid.template.disabled = true;
		axis.renderer.labels.template.radius = 40;
		axis.renderer.labels.template.adapter.add("text", function(text) {
			return text ;
		})

		/**
		 * Axis for ranges
		 */

		var colorSet = new am4core.ColorSet();

		var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
		axis2.min = 0;
		axis2.max = 100;
		axis2.strictMinMax = true;
		axis2.renderer.labels.template.disabled = true;
		axis2.renderer.ticks.template.disabled = true;
		axis2.renderer.grid.template.disabled = true;

		var range0 = axis2.axisRanges.create();
		range0.value = 0;
		range0.endValue = 50;
		range0.axisFill.fillOpacity = 1;
		range0.axisFill.fill = colorSet.getIndex(0);

		var range1 = axis2.axisRanges.create();
		range1.value = 50;
		range1.endValue = 100;
		range1.axisFill.fillOpacity = 1;
		range1.axisFill.fill = colorSet.getIndex(2);

		/**
		 * Label
		 */

		var label = chart.radarContainer.createChild(am4core.Label);
		label.isMeasured = false;
		label.fontSize = 45;
		label.x = am4core.percent(50);
		label.y = am4core.percent(100);
		label.horizontalCenter = "middle";
		label.verticalCenter = "bottom";
		label.text = "50%";


		/**
		 * Hand
		 */

		var hand = chart.hands.push(new am4charts.ClockHand());
		hand.axis = axis2;
		hand.innerRadius = am4core.percent(20);
		hand.startWidth = 10;
		hand.pin.disabled = true;
		hand.value = 50;

		hand.events.on("propertychanged", function(ev) {
			range0.endValue = ev.target.value;
			range1.value = ev.target.value;
			label.text = axis2.positionToValue(hand.currentPosition).toFixed(1)+' %';
			axis2.invalidate();
		});

		var value = <?php echo json_encode($ua_loader2);?>;
		var animation = new am4core.Animation(hand, {
			property: "value",
			to: value
		}, 1000, am4core.ease.cubicOut).start();

		// Add chart title
		var title = chart.titles.create();
		title.text = "Data Plan (<?php echo json_encode($ua_loader_plan2);?>) & Actual (<?php echo json_encode($ua_loader2);?>)";
		title.fontSize = 25;

		var button = chart.chartContainer.createChild(am4core.Button);
		button.label.text = "Detail";
		button.padding(5, 5, 5, 5);
		button.width = 80;
		button.align = "center";
		button.marginRight = 15;
		button.events.on("hit", function() {
			window.location.href = "<?php echo base_url().'Dashboard/search_data_ua/'.$start_date.'/'.$end_date.'/Loader';?>";
		});
		// title.marginBottom = -150;
	}); // end am4core.ready()

	am4core.ready(function() {

// Themes begin
		am4core.useTheme(am4themes_material);
// Themes end

// create chart
		var chart = am4core.create("ua_hauler", am4charts.GaugeChart);
		chart.innerRadius = am4core.percent(82);

		/**
		 * Normal axis
		 */

		var axis = chart.xAxes.push(new am4charts.ValueAxis());
		axis.min = 0;
		axis.max = 100;
		axis.strictMinMax = true;
		axis.renderer.radius = am4core.percent(80);
		axis.renderer.inside = true;
		axis.renderer.line.strokeOpacity = 1;
		axis.renderer.ticks.template.disabled = false
		axis.renderer.ticks.template.strokeOpacity = 1;
		axis.renderer.ticks.template.length = 10;
		axis.renderer.grid.template.disabled = true;
		axis.renderer.labels.template.radius = 40;
		axis.renderer.labels.template.adapter.add("text", function(text) {
			return text ;
		})

		/**
		 * Axis for ranges
		 */

		var colorSet = new am4core.ColorSet();

		var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
		axis2.min = 0;
		axis2.max = 100;
		axis2.strictMinMax = true;
		axis2.renderer.labels.template.disabled = true;
		axis2.renderer.ticks.template.disabled = true;
		axis2.renderer.grid.template.disabled = true;

		var range0 = axis2.axisRanges.create();
		range0.value = 0;
		range0.endValue = 50;
		range0.axisFill.fillOpacity = 1;
		range0.axisFill.fill = colorSet.getIndex(0);

		var range1 = axis2.axisRanges.create();
		range1.value = 50;
		range1.endValue = 100;
		range1.axisFill.fillOpacity = 1;
		range1.axisFill.fill = colorSet.getIndex(2);

		/**
		 * Label
		 */

		var label = chart.radarContainer.createChild(am4core.Label);
		label.isMeasured = false;
		label.fontSize = 45;
		label.x = am4core.percent(50);
		label.y = am4core.percent(100);
		label.horizontalCenter = "middle";
		label.verticalCenter = "bottom";
		label.text = "50%";


		/**
		 * Hand
		 */

		var hand = chart.hands.push(new am4charts.ClockHand());
		hand.axis = axis2;
		hand.innerRadius = am4core.percent(20);
		hand.startWidth = 10;
		hand.pin.disabled = true;
		hand.value = 50;

		hand.events.on("propertychanged", function(ev) {
			range0.endValue = ev.target.value;
			range1.value = ev.target.value;
			label.text = axis2.positionToValue(hand.currentPosition).toFixed(1)+' %';
			axis2.invalidate();
		});

		var value = <?php echo json_encode($ua_hauler2);?>;
		var animation = new am4core.Animation(hand, {
			property: "value",
			to: value
		}, 1000, am4core.ease.cubicOut).start();

		// Add chart title
		var title = chart.titles.create();
		title.text = "Data Plan (<?php echo json_encode($ua_hauler_plan2);?>) & Actual (<?php echo json_encode($ua_hauler2);?>)";
		title.fontSize = 25;

		var button = chart.chartContainer.createChild(am4core.Button);
		button.label.text = "Detail";
		button.padding(5, 5, 5, 5);
		button.width = 80;
		button.align = "center";
		button.marginRight = 15;
		button.events.on("hit", function() {
			window.location.href = "<?php echo base_url().'Dashboard/search_data_ua/'.$start_date.'/'.$end_date.'/Hauler';?>";
		});
		// title.marginBottom = -150;
	}); // end am4core.ready()
</script>
</body>
</html>
