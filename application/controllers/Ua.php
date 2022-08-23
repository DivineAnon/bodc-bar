<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ua extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_ua', 'ua');
	}

	public function data($id_type_unit){
		$type_unit = '';
		if($id_type_unit == 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Ua '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $this->ua->get_egi($id_type_unit);
		$data['stanby'] = $this->ua->get_stanby($id_type_unit);
		$this->load->view('ua/V_ua', $data);
	}

	public function detail_ua($id_type_unit,$egi){
		$type_unit = '';
		if($id_type_unit === 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Ua '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $egi;
		$data['owner_name'] = '';
		$data['no_unit'] = $this->ua->get_detail_ua($egi, $id_type_unit);
		$data['stanby'] = $this->ua->get_stanby_egi($id_type_unit, $egi);
		$data['list_owner'] = $this->ua->get_list_owner();
//		echo "<pre>";
//		print_r($data['no_unit']);
//		echo "</pre>";die();
		$this->load->view('ua/V_detail_ua', $data);
	}

	public function search_data_ua_owner($id_type_unit,$egi,$owner){
		if($owner == 'ALL'){
			$this->detail_ua($id_type_unit,$egi);
		}else{
			$type_unit = '';
			if($id_type_unit === 1){
				$type_unit = 'Loader';
			}else{
				$type_unit = 'Hauler';
			}
			$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Ua '.$type_unit.' Owner '.str_replace('%20',' ',$owner);
			$data['head'] = $this->load->view('V_head',$this->global, TRUE);
			$data['header'] = $this->load->view('V_header','',TRUE);
			$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
			$data['footer'] = $this->load->view('V_footer','',TRUE);
			$data['script'] = $this->load->view('V_script','', TRUE);
			$data['type_unit'] = $type_unit;
			$data['id_type_unit'] = $id_type_unit;
			$data['egi'] = $egi;
			$data['owner_name'] = str_replace('%20',' ',$owner);
			$data['no_unit'] = $this->ua->get_detail_ua_owner($egi, $id_type_unit,str_replace('%20',' ',$owner));
			$data['stanby'] = $this->ua->get_stanby_egi_owner($id_type_unit, $egi,str_replace('%20',' ',$owner));
			$data['list_owner'] = $this->ua->get_list_owner();
//			echo "<pre>";
//			print_r($data['no_unit']);
//			echo "</pre>";die();
			$this->load->view('ua/V_detail_ua', $data);
		}
	}

	public function detail_ua_unit($type_unit,$cn_unit){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit '.$cn_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['no_unit'] = $cn_unit;
		$data['periode'] = '';
		$data['id_type_unit'] = $type_unit;
		$data['no_unit_tgl'] = $this->ua->get_no_unit_tgl($cn_unit);
		$data['detail_unit'] = $this->ua->get_detail_unit($cn_unit);
		$this->load->view('ua/V_detail_unit', $data);
	}

	public function detail_ua_unit_range($type_unit,$cn_unit,$start,$end){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit '.$cn_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['no_unit'] = $cn_unit;
		$data['periode'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['id_type_unit'] = $type_unit;
		$data['no_unit_tgl'] = $this->ua->get_no_unit_tgl_range($cn_unit, date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$data['detail_unit'] = $this->ua->get_detail_unit_range($cn_unit, date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$this->load->view('ua/V_detail_unit', $data);
	}
}
