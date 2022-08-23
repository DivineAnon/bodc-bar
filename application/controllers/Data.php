<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_data', 'data');
	}

	public function index(){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit';
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['unit'] = $this->data->get_no_unit();
		$this->load->view('V_data_unit', $data);
	}

	public function detail_no_unit($no_unit){
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Unit '.$no_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['no_unit'] = $no_unit;
		$data['no_unit_tgl'] = $this->data->get_no_unit_tgl($no_unit);
		$data['detail_unit'] = $this->data->get_detail_unit($no_unit);
		$this->load->view('V_detail_no_unit', $data);
	}

	public function get_data_unit_detail_per_tgl($id){
		$data = $this->data->get_data_unit_detail_per_tgl($id);
		echo json_encode($data);
	}
}
