<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fuel_ratio extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_fuel_ratio', 'fuel_ratio');
	}

	public function data($id_type_unit){
		$type_unit = '';
		if($id_type_unit == 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Fuel Ratio '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $this->fuel_ratio->get_egi($id_type_unit);
		$this->load->view('fuel_ratio/V_fuel_ratio', $data);
	}

	public function detail_fuel_ratio($id_type_unit,$egi){
		$type_unit = '';
		if($id_type_unit === 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Fuel Ratio '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $egi;
		$data['owner_name'] = '';
		$data['list_owner'] = $this->fuel_ratio->get_list_owner();
		$data['no_unit'] = $this->fuel_ratio->get_detail_fuel_ratio($egi, $id_type_unit);
		$this->load->view('fuel_ratio/V_detail_fuel_ratio', $data);
	}

	public function search_data_fuel_ratio_owner($id_type_unit,$egi,$owner){
		if($owner == 'ALL'){
			$this->detail_fuel_ratio($id_type_unit,$egi);
		}else{
			$type_unit = '';
			if($id_type_unit === 1){
				$type_unit = 'Loader';
			}else{
				$type_unit = 'Hauler';
			}
			$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Fuel Ratio '.$type_unit.' Owner '.str_replace('%20',' ',$owner);
			$data['head'] = $this->load->view('V_head',$this->global, TRUE);
			$data['header'] = $this->load->view('V_header','',TRUE);
			$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
			$data['footer'] = $this->load->view('V_footer','',TRUE);
			$data['script'] = $this->load->view('V_script','', TRUE);
			$data['type_unit'] = $type_unit;
			$data['id_type_unit'] = $id_type_unit;
			$data['egi'] = $egi;
			$data['owner_name'] = str_replace('%20',' ',$owner);
			$data['list_owner'] = $this->fuel_ratio->get_list_owner();
			$data['no_unit'] = $this->fuel_ratio->get_detail_fuel_ratio_owner($egi, $id_type_unit,str_replace('%20',' ',$owner));
			$this->load->view('fuel_ratio/V_detail_fuel_ratio', $data);
		}
	}

	public function detail_unit($id_type_unit,$cn_unit){
		$type_unit = '';
		if($id_type_unit === 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Unit '.$cn_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['id_type_unit'] = $id_type_unit;
		$data['periode'] = '';
		$data['cn_unit'] = $cn_unit;
		$data['no_unit'] = $this->fuel_ratio->get_detail_fuel_ratio_unit($cn_unit, $id_type_unit);
		$this->load->view('fuel_ratio/V_detail_unit', $data);
	}

	public function detail_fuel_ratio_unit_range($id_type_unit,$cn_unit,$start,$end){
		$type_unit = '';
		if($id_type_unit === 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Unit '.$cn_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['id_type_unit'] = $id_type_unit;
		$data['periode'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['cn_unit'] = $cn_unit;
		$data['no_unit'] = $this->fuel_ratio->get_detail_fuel_ratio_unit_range($cn_unit,$id_type_unit, date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$this->load->view('fuel_ratio/V_detail_unit', $data);
	}
}
