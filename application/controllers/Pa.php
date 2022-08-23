<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pa extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_pa', 'pa');
	}

	public function data($id_type_unit){
		$type_unit = '';
		if($id_type_unit == 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Pa '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $this->pa->get_egi($id_type_unit);
		$data['breakdown'] = $this->pa->get_breakdown($id_type_unit);
		$this->load->view('pa/V_pa', $data);
	}

	public function detail_pa($id_type_unit,$egi){
		$type_unit = '';
		if($id_type_unit === 1){
			$type_unit = 'Loader';
		}else{
			$type_unit = 'Hauler';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Pa '.$type_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['type_unit'] = $type_unit;
		$data['id_type_unit'] = $id_type_unit;
		$data['egi'] = $egi;
		$data['owner_name'] = '';
		$data['no_unit'] = $this->pa->get_detail_pa($egi, $id_type_unit);
		$data['breakdown'] = $this->pa->get_breakdown_egi($egi,$id_type_unit);
		$data['list_owner'] = $this->pa->get_list_owner();
		$this->load->view('pa/V_detail_pa', $data);
	}

	public function search_data_pa_owner($id_type_unit,$egi,$owner){
		if($owner == 'ALL'){
			$this->detail_pa($id_type_unit,$egi);
		}else{
			$type_unit = '';
			if($id_type_unit === 1){
				$type_unit = 'Loader';
			}else{
				$type_unit = 'Hauler';
			}
			$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Pa '.$type_unit.' Owner '.str_replace('%20',' ',$owner);
			$data['head'] = $this->load->view('V_head',$this->global, TRUE);
			$data['header'] = $this->load->view('V_header','',TRUE);
			$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
			$data['footer'] = $this->load->view('V_footer','',TRUE);
			$data['script'] = $this->load->view('V_script','', TRUE);
			$data['type_unit'] = $type_unit;
			$data['id_type_unit'] = $id_type_unit;
			$data['egi'] = $egi;
			$data['owner_name'] = str_replace('%20',' ',$owner);
			$data['no_unit'] = $this->pa->get_detail_pa_owner($egi, $id_type_unit,str_replace('%20',' ',$owner));
			$data['breakdown'] = $this->pa->get_breakdown_egi_owner($egi,$id_type_unit,str_replace('%20',' ',$owner));
			$data['list_owner'] = $this->pa->get_list_owner();
			$this->load->view('pa/V_detail_pa', $data);
		}
	}

	public function detail_pa_unit($type_unit,$cn_unit){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit '.$cn_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['no_unit'] = $cn_unit;
		$data['periode'] = '';
		$data['id_type_unit'] = $type_unit;
		$data['no_unit_tgl'] = $this->pa->get_no_unit_tgl($cn_unit);
		$data['detail_unit'] = $this->pa->get_detail_unit($cn_unit);
		$this->load->view('pa/V_detail_unit', $data);
	}

	public function detail_pa_unit_range($type_unit,$cn_unit, $start,$end){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit '.$cn_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['no_unit'] = $cn_unit;
		$data['periode'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['id_type_unit'] = $type_unit;
		$data['no_unit_tgl'] = $this->pa->get_no_unit_tgl_range($cn_unit, date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$data['detail_unit'] = $this->pa->get_detail_unit_range($cn_unit,date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$this->load->view('pa/V_detail_unit', $data);
	}
}
