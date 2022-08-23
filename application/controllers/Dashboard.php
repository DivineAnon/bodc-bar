<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_dashboard', 'dashboard');
	}

	public function index(){
		date_default_timezone_set('Asia/Jakarta');
		$this->global['pageTitle'] = 'BODC-Dashboard : Dashboard';
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['start_date'] = '';
		$data['end_date'] = '';
		$data['year'] = date('Y');
		$data['month'] = date('n');
		$month = $data['month'];
		$year = $data['year'];
		$last_date = $this->dashboard->get_last_date(date('Y'),date('n'));
		if($last_date == ''){
			$last_date = 31;
		}
		$end_day = 0;
		for($d=1; $d<=$last_date; $d++) {
			$end_day++;
			$time=mktime(12, 0, 0, $month, $d, $year);
			if (date('m', $time)==$month){
				$data['day'][]=date('d-m-Y', $time);
				//actual
				$wsr_hauler = $this->dashboard->get_data_hauler(date('Y-m-d', $time), 2);
				$wsr_loader = $this->dashboard->get_data_loader(date('Y-m-d', $time), 1);
				$produksi_ob = $this->dashboard->get_data_produksi(date('Y-m-d', $time), 3);
				$produksi_coal = $this->dashboard->get_data_produksi(date('Y-m-d', $time), 4);
				$fuel_hauler = $this->dashboard->get_fuel_ratio(date('Y-m-d', $time), 2);
				$fuel_loader =  $this->dashboard->get_fuel_ratio(date('Y-m-d', $time), 1);
				$breakdown = $this->dashboard->get_breakdown(date('Y-m-d', $time));
				//plan

				$plan_produksi_ob = $this->dashboard->get_data_plan(1,3,0,$data['month'],$data['year']);
				$plan_produksi_coal = $this->dashboard->get_data_plan(1,4,0,$data['month'],$data['year']);
				$plan_pa_hauler = $this->dashboard->get_data_plan(2,0,2,$data['month'],$data['year']);
				$plan_pa_loader = $this->dashboard->get_data_plan(2,0,1,$data['month'],$data['year']);
				$plan_ua_hauler= $this->dashboard->get_data_plan(3,0,2,$data['month'],$data['year']);
				$plan_ua_loader = $this->dashboard->get_data_plan(3,0,1,$data['month'],$data['year']);
				$plan_prod_hauler = $this->dashboard->get_data_plan(4,0,2,$data['month'],$data['year']);
				$plan_prod_loader = $this->dashboard->get_data_plan(4,0,1,$data['month'],$data['year']);
				$plan_fuel_hauler = $this->dashboard->get_data_plan(5,0,2,$data['month'],$data['year']);
				$plan_fuel_loader = $this->dashboard->get_data_plan(5,0,1,$data['month'],$data['year']);
				if($wsr_hauler['response'] == 'avail'){
					//actual
					$data['pa_hauler'][] = array_sum($wsr_hauler['pa_hauler']);
					$data['ua_hauler'][] = array_sum($wsr_hauler['ua_hauler']);
					$data['prod_hauler'][] = array_sum($wsr_hauler['prod_hauler']);

					//plan
					$data['pa_hauler_plan'][] = $plan_pa_hauler;
					$data['ua_hauler_plan'][] = $plan_ua_hauler;
					$data['prod_hauler_plan'][] = $plan_prod_hauler;
				}else{
					$data['pa_hauler'][] = 0;
					$data['ua_hauler'][] = 0;
					$data['prod_hauler'][] = 0;
					//plan
					$data['pa_hauler_plan'][] = $plan_pa_hauler;
					$data['ua_hauler_plan'][] = $plan_ua_hauler;
					$data['prod_hauler_plan'][] = $plan_prod_hauler;
				}
				if($wsr_loader['response'] == 'avail'){
					//actual
					$data['pa_loader'][] = array_sum($wsr_loader['pa_loader']);
					$data['ua_loader'][] = array_sum($wsr_loader['ua_loader']);
					$data['prod_loader'][] = array_sum($wsr_loader['prod_loader']);
					//plan
					$data['pa_loader_plan'][] = $plan_pa_loader;
					$data['ua_loader_plan'][] = $plan_ua_loader;
					$data['prod_loader_plan'][] = $plan_prod_loader;
				}else{
					$data['pa_loader'][] = 0;
					$data['ua_loader'][] = 0;
					$data['prod_loader'][] = 0;
					//plan
					$data['pa_loader_plan'][] = $plan_pa_loader;
					$data['ua_loader_plan'][] = $plan_ua_loader;
					$data['prod_loader_plan'][] = $plan_prod_loader;
				}

				if(!empty($produksi_ob)){
					//actual
					$data['produksi_ob'][] = array_sum($produksi_ob['total']) * 5.5;
					//plan
					$data['produksi_ob_plan'][] = $plan_produksi_ob;
				}else{
					$data['produksi_ob'][] = 0;
					//plan
					$data['produksi_ob_plan'][] = $plan_produksi_ob;
				}
				if(!empty($produksi_coal)){
					//actual
					$data['produksi_coal'][] = array_sum($produksi_coal['total']) * 20;
					//plan
					$data['produksi_coal_plan'][] = $plan_produksi_coal;
				}else{
					$data['produksi_coal'][] = 0;
					//plan
					$data['produksi_coal_plan'][] = $plan_produksi_coal;
				}

				if(!empty($fuel_hauler)){
					//actual
					$data['fuel_hauler'][] = array_sum($fuel_hauler['fuel_ratio']);
					//plan
					$data['fuel_hauler_plan'][] = $plan_fuel_hauler;
				}else{
					$data['fuel_hauler'][] = 0;
					//plan
					$data['fuel_hauler_plan'][] = $plan_fuel_hauler;
				}
				if(!empty($fuel_loader)){
					//actual
					$data['fuel_loader'][] = array_sum($fuel_loader['fuel_ratio']);

					//plan
					$data['fuel_loader_plan'][] = $plan_fuel_loader;
				}else{
					$data['fuel_loader'][] = 0;
					//plan
					$data['fuel_loader_plan'][] = $plan_fuel_loader;
				}
				if(!empty($breakdown)){
					if(!empty($breakdown['seconds']['SCM'])){
						$data['SCM'][] = round($breakdown['seconds']['SCM']/3600,2);
					}else{
						$data['SCM'][] = 0;
					}
					if(!empty($breakdown['seconds']['USM'])){;
						$data['USM'][] = round($breakdown['seconds']['USM']/3600);
					}else{
						$data['USM'][] = 0;
					}
					if(!empty($breakdown['seconds']['TRM'])){
						$data['TRM'][] = round($breakdown['seconds']['TRM']/3600);
					}else{
						$data['TRM'][] = 0;
					}
					if(!empty($breakdown['seconds']['ICM'])){
						$data['ICM'][] = round($breakdown['seconds']['ICM']/3600);
					}else{
						$data['ICM'][] = 0;
					}
				}else{
					$data['SCM'][] = 0;
					$data['USM'][] = 0;
					$data['TRM'][] = 0;
					$data['ICM'][] = 0;
				}
			}
		}
		$data['pa_loader2'] = round(array_sum($data['pa_loader']),2);
		$data['pa_hauler2'] = round(array_sum($data['pa_hauler']),2);
		$data['pa_loader_plan2'] = intval(array_sum($data['pa_loader_plan']));
		$data['pa_hauler_plan2'] = intval(array_sum($data['pa_hauler_plan']));

		if($data['pa_loader2'] != 0 && $data['pa_loader_plan2'] != 0){
			$data['pa_loader2'] = round(($data['pa_loader2'] / $data['pa_loader_plan2']) * 100,2);
		}
		if($data['pa_hauler2'] != 0 && $data['pa_hauler_plan2'] != 0){
			$data['pa_hauler2'] = round(($data['pa_hauler2'] / $data['pa_hauler_plan2']) * 100,2);
		}

		$data['ua_loader2'] = round(array_sum($data['ua_loader']),2);
		$data['ua_hauler2'] = round(array_sum($data['ua_hauler']),2);
		$data['ua_loader_plan2'] = intval(array_sum($data['ua_loader_plan']));
		$data['ua_hauler_plan2'] = intval(array_sum($data['ua_hauler_plan']));

		if($data['ua_loader2'] != 0 && $data['ua_loader_plan2'] != 0){
			$data['ua_loader2'] = round(($data['ua_loader2'] / $data['ua_loader_plan2']) * 100,2);
		}
		if($data['ua_hauler2'] != 0 && $data['ua_hauler_plan2'] != 0){
			$data['ua_hauler2'] = round(($data['ua_hauler2'] / $data['ua_hauler_plan2']) * 100,2);
		}

		$data['stanby'] = $this->dashboard->get_data_stanby(date('Y'), date('n'));

		$data['start_date'] = date('d-M-Y',strtotime($data['day'][0]));
		$end_day = intval(count($data['day'])) - 1;
		$data['end_date'] = date('d-M-Y',strtotime($data['day'][$end_day]));
		// echo "<pre>";
		// print_r($data['day']);
		// echo "</pre>";die();
		$this->load->view('dashboard/V_dashboard', $data);
	}

	public function search_data($start_date, $end_date){
		date_default_timezone_set('Asia/Jakarta');
		$this->global['pageTitle'] = 'BODC-Dashboard : Dashboard';
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;

		$start = date('Y-m-d',strtotime($start_date));
		$end = date('Y-m-d',strtotime($end_date));
		$data['stanby'] = $this->dashboard->get_data_stanby_range($start,$end);
		$end = new DateTime($end);
		$end = $end->modify( '+1 day' );
		$begin = new DateTime($start);
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		foreach ($period as $dt) {
			$data['day'][] =  $dt->format("d-m-Y");
			$tgl = $dt->format("Y-m-d");
			$month = $dt->format("n");
			$year = $dt->format("Y");
			$wsr_hauler = $this->dashboard->get_data_hauler($tgl, 2);
			$wsr_loader = $this->dashboard->get_data_loader($tgl, 1);
			$produksi_ob = $this->dashboard->get_data_produksi($tgl, 3);
			$produksi_coal = $this->dashboard->get_data_produksi($tgl, 4);
			$fuel_hauler = $this->dashboard->get_fuel_ratio($tgl, 2);
			$fuel_loader =  $this->dashboard->get_fuel_ratio($tgl, 1);
			$breakdown = $this->dashboard->get_breakdown($tgl);

			//plan

			$plan_produksi_ob = $this->dashboard->get_data_plan(1,3,0,$month,$year);
			$plan_produksi_coal = $this->dashboard->get_data_plan(1,4,0,$month,$year);
			$plan_pa_hauler = $this->dashboard->get_data_plan(2,0,2,$month,$year);
			$plan_pa_loader = $this->dashboard->get_data_plan(2,0,1,$month,$year);
			$plan_ua_hauler= $this->dashboard->get_data_plan(3,0,2,$month,$year);
			$plan_ua_loader = $this->dashboard->get_data_plan(3,0,1,$month,$year);
			$plan_prod_hauler = $this->dashboard->get_data_plan(4,0,2,$month,$year);
			$plan_prod_loader = $this->dashboard->get_data_plan(4,0,1,$month,$year);
			$plan_fuel_hauler = $this->dashboard->get_data_plan(5,0,2,$month,$year);
			$plan_fuel_loader = $this->dashboard->get_data_plan(5,0,1,$month,$year);

			if($wsr_hauler['response'] == 'avail'){
				$data['pa_hauler'][] = array_sum($wsr_hauler['pa_hauler']);
				$data['ua_hauler'][] = array_sum($wsr_hauler['ua_hauler']);
				$data['prod_hauler'][] = array_sum($wsr_hauler['prod_hauler']);
				//plan
				$data['pa_hauler_plan'][] = $plan_pa_hauler;
				$data['ua_hauler_plan'][] = $plan_ua_hauler;
				$data['prod_hauler_plan'][] = $plan_prod_hauler;
			}else{
				$data['pa_hauler'][] = 0;
				$data['ua_hauler'][] = 0;
				$data['prod_hauler'][] = 0;
				//plan
				$data['pa_hauler_plan'][] = $plan_pa_hauler;
				$data['ua_hauler_plan'][] = $plan_ua_hauler;
				$data['prod_hauler_plan'][] = $plan_prod_hauler;
			}
			if($wsr_loader['response'] == 'avail'){
				$data['pa_loader'][] = array_sum($wsr_loader['pa_loader']);
				$data['ua_loader'][] = array_sum($wsr_loader['ua_loader']);
				$data['prod_loader'][] = array_sum($wsr_loader['prod_loader']);
				//plan
				$data['pa_loader_plan'][] = $plan_pa_loader;
				$data['ua_loader_plan'][] = $plan_ua_loader;
				$data['prod_loader_plan'][] = $plan_prod_loader;
			}else{
				$data['pa_loader'][] = 0;
				$data['ua_loader'][] = 0;
				$data['prod_loader'][] = 0;
				//plan
				$data['pa_loader_plan'][] = $plan_pa_loader;
				$data['ua_loader_plan'][] = $plan_ua_loader;
				$data['prod_loader_plan'][] = $plan_prod_loader;
			}

			if(!empty($produksi_ob)){
				$data['produksi_ob'][] = array_sum($produksi_ob['total']) * 5.5;
				//plan
				$data['produksi_ob_plan'][] = $plan_produksi_ob;
			}else{
				$data['produksi_ob'][] = 0;
				//plan
				$data['produksi_ob_plan'][] = $plan_produksi_ob;
			}
			if(!empty($produksi_coal)){
				$data['produksi_coal'][] = array_sum($produksi_coal['total']) * 20;
				//plan
				$data['produksi_coal_plan'][] = $plan_produksi_coal;
			}else{
				$data['produksi_coal'][] = 0;
				//plan
				$data['produksi_coal_plan'][] = $plan_produksi_coal;
			}

			if(!empty($fuel_hauler)){
				$data['fuel_hauler'][] = array_sum($fuel_hauler['fuel_ratio']);
				//plan
				$data['fuel_hauler_plan'][] = $plan_fuel_hauler;
			}else{
				$data['fuel_hauler'][] = 0;
				//plan
				$data['fuel_hauler_plan'][] = $plan_fuel_hauler;
			}
			if(!empty($fuel_loader)){
				$total_produksi = (round(array_sum($produksi_ob['total']),2)* 5.5) + (0.7 * (round(array_sum($produksi_coal['total']),2))*20);
				if($total_produksi != 0){
					$data['fuel_loader'][] = array_sum($fuel_loader['fuel_ratio'])/$total_produksi;
				}else{
					$data['fuel_loader'][] = array_sum($fuel_loader['fuel_ratio']);
				}
				//plan
				$data['fuel_loader_plan'][] = $plan_fuel_loader;
			}else{
				$data['fuel_loader'][] = 0;
				//plan
				$data['fuel_loader_plan'][] = $plan_fuel_loader;
			}
			if(!empty($breakdown)){
				if(!empty($breakdown['seconds']['SCM'])){
					$data['SCM'][] = round($breakdown['seconds']['SCM']/3600,2);
				}else{
					$data['SCM'][] = 0;
				}
				if(!empty($breakdown['seconds']['USM'])){;
					$data['USM'][] = round($breakdown['seconds']['USM']/3600,2);
				}else{
					$data['USM'][] = 0;
				}
				if(!empty($breakdown['seconds']['TRM'])){
					$data['TRM'][] = round($breakdown['seconds']['TRM']/3600,2);
				}else{
					$data['TRM'][] = 0;
				}
				if(!empty($breakdown['seconds']['ICM'])){
					$data['ICM'][] = round($breakdown['seconds']['ICM']/3600,2);
				}else{
					$data['ICM'][] = 0;
				}
			}else{
				$data['SCM'][] = 0;
				$data['USM'][] = 0;
				$data['TRM'][] = 0;
				$data['ICM'][] = 0;
			}
		}
		$data['pa_loader2'] = round(array_sum($data['pa_loader']),2);
		$data['pa_hauler2'] = round(array_sum($data['pa_hauler']),2);
		$data['pa_loader_plan2'] = intval(array_sum($data['pa_loader_plan']));
		$data['pa_hauler_plan2'] = intval(array_sum($data['pa_hauler_plan']));

		if($data['pa_loader2'] != 0 && $data['pa_loader_plan2'] != 0){
			$data['pa_loader2'] = round(($data['pa_loader2'] / $data['pa_loader_plan2']) * 100,2);
		}
		if($data['pa_hauler2'] != 0 && $data['pa_hauler_plan2'] != 0){
			$data['pa_hauler2'] = round(($data['pa_hauler2'] / $data['pa_hauler_plan2']) * 100,2);
		}

		$data['ua_loader2'] = round(array_sum($data['ua_loader']),2);
		$data['ua_hauler2'] = round(array_sum($data['ua_hauler']),2);
		$data['ua_loader_plan2'] = intval(array_sum($data['ua_loader_plan']));
		$data['ua_hauler_plan2'] = intval(array_sum($data['ua_hauler_plan']));

		if($data['ua_loader2'] != 0 && $data['ua_loader_plan2'] != 0){
			$data['ua_loader2'] = round(($data['ua_loader2'] / $data['ua_loader_plan2']) * 100,2);
		}
		if($data['ua_hauler2'] != 0 && $data['ua_hauler_plan2'] != 0){
			$data['ua_hauler2'] = round(($data['ua_hauler2'] / $data['ua_hauler_plan2']) * 100,2);
		}

		$this->load->view('dashboard/V_dashboard', $data);
	}

	public function search_data_produksi($tgl,$mat){
		$id_mat = '';
		$qty = '';
		if($mat == 'OB'){
			$id_mat = 3;
			$qty = 5.5;
		}else{
			$id_mat = 4;
			$qty = 20;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Produksi '.$mat.' Periode '.date('d F Y', strtotime($tgl));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['qty'] = $qty;
		$data['tgl'] = date('d F Y',strtotime($tgl));
		$data['id_mat'] = $id_mat;
		$data['no_unit'] = $this->dashboard->get_detail_produksi($id_mat, date('Y-m-d', strtotime($tgl)));
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();
		$this->load->view('dashboard/V_search_data_produksi', $data);
	}

	public function search_data_produksi_range($start,$end,$mat){
		$id_mat = '';
		$qty = '';
		if($mat == 'OB'){
			$id_mat = 3;
			$qty = 5.5;
		}else{
			$id_mat = 4;
			$qty = 20;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Produksi '.$mat.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['qty'] = $qty;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['id_mat'] = $id_mat;
		$data['no_unit'] = $this->dashboard->get_detail_produksi_range($id_mat, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();
		$this->load->view('dashboard/V_search_data_produksi', $data);
	}

	public function search_data_pa($start,$end,$type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data PA '.$type_unit.' Periode '.date('d F Y', strtotime($start)).' s/d '.date('d F Y', strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_pa($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$data['breakdown'] = $this->dashboard->get_breakdown_search($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$this->load->view('dashboard/V_search_data_pa', $data);
	}

	public function search_data_pa_range($start,$end,$type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data PA '.$type_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_pa_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$data['breakdown'] = $this->dashboard->get_breakdown_search_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();
		$this->load->view('dashboard/V_search_data_pa', $data);
	}

	public function search_data_ua($start,$end, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data UA '.$type_unit.' Periode '.date('d F Y', strtotime($start)).' s/d '.date('Y-m-d', strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_ua($id_type_unit, date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end)));
		$data['stanby'] = $this->dashboard->get_stanby_search($id_type_unit, date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end)));
		$this->load->view('dashboard/V_search_data_ua', $data);
	}

	public function search_data_ua_range($start, $end, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data UA '.$type_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_ua_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$data['stanby'] = $this->dashboard->get_stanby_search_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();
		$this->load->view('dashboard/V_search_data_ua', $data);
	}

	public function search_data_prod($tgl, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Productivity '.$type_unit.' Periode '.date('d F Y', strtotime($tgl));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($tgl));
		$data['no_unit'] = $this->dashboard->get_detail_prod($id_type_unit, date('Y-m-d', strtotime($tgl)));
		$this->load->view('dashboard/V_search_data_prod', $data);
	}

	public function search_data_prod_range($start,$end, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Productivity '.$type_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_prod_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$this->load->view('dashboard/V_search_data_prod', $data);
	}

	public function search_data_fuel_ratio($tgl, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Fuel Ratio '.$type_unit.' Periode '.date('d F Y', strtotime($tgl));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($tgl));
		$data['no_unit'] = $this->dashboard->get_detail_fuel($id_type_unit, date('Y-m-d', strtotime($tgl)));
		$this->load->view('dashboard/V_search_data_fuel', $data);
	}

	public function search_data_fuel_ratio_range($start,$end, $type_unit){
		$id_type_unit = '';
		if($type_unit == 'Loader'){
			$id_type_unit = 1;
		}else{
			$id_type_unit = 2;
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Fuel Ratio '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_fuel_range($id_type_unit, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
		$this->load->view('dashboard/V_search_data_fuel', $data);
	}

	public function search_data_breakdown($tgl, $breakdown){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Breakdown '.$breakdown.' Periode'.date('d F Y', strtotime($tgl));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['breakdown'] = $breakdown;
		$data['tgl'] = $tgl;
		$data['no_unit'] = $this->dashboard->get_detail_breakdown_unit($breakdown, date('Y-m-d', strtotime($tgl)));
		$this->load->view('dashboard/V_search_data_breakdown', $data);
	}

	public function search_data_breakdown_range($start, $end, $breakdown){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Breakdown '.$breakdown.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['breakdown'] = $breakdown;
		$data['tgl'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['no_unit'] = $this->dashboard->get_detail_breakdown_unit_range($breakdown, date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end)));
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();

		$this->load->view('dashboard/V_search_data_breakdown', $data);
	}
}
