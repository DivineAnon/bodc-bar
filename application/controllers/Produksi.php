<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if($this->session->userdata('username') == ''){
			redirect(base_url());
		}
		$this->load->model('M_produksi', 'produksi');
	}

	public function data($id_mat){
		$mat = '';
		if($id_mat == 3){
			$mat = 'OB';
		}else{
			$mat = 'COAL';
		}
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Produksi '.$mat;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['id_mat'] = $id_mat;
		$data['block'] = $this->produksi->get_block($id_mat);
		$this->load->view('produksi/V_produksi', $data);
	}

	public function detail_produksi($id_mat,$id_block){
		$mat = '';
		$qty = '';
		if($id_mat == 3){
			$mat = 'OB';
			$qty = 5.5;
		}else{
			$mat = 'COAL';
			$qty = 20;
		}
		$block_name = $this->produksi->get_block_name($id_block);
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Produksi '.$block_name[0]['nama'];
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['qty'] = $qty;
		$data['id_mat'] = $id_mat;
		$data['block_name'] = $block_name[0]['nama'];
		$data['owner_name'] = '';
		$data['id_block'] = $id_block;
		$data['no_unit'] = $this->produksi->get_detail_produksi($id_mat, $id_block);
		$data['list_owner'] = $this->produksi->get_list_owner();
		$this->load->view('produksi/V_detail_produksi', $data);
	}

	public function search_data_produksi_owner($id_mat,$id_block,$owner){
		if($owner == 'ALL'){
			$this->detail_produksi($id_mat,$id_block);
		}else{
			$mat = '';
			$qty = '';
			if($id_mat == 3){
				$mat = 'OB';
				$qty = 5.5;
			}else{
				$mat = 'COAL';
				$qty = 20;
			}
			$block_name = $this->produksi->get_block_name($id_block);
			$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Produksi '.$block_name[0]['nama'].' Owner '.$owner;
			$data['head'] = $this->load->view('V_head',$this->global, TRUE);
			$data['header'] = $this->load->view('V_header','',TRUE);
			$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
			$data['footer'] = $this->load->view('V_footer','',TRUE);
			$data['script'] = $this->load->view('V_script','', TRUE);
			$data['material'] = $mat;
			$data['qty'] = $qty;
			$data['id_mat'] = $id_mat;
			$data['block_name'] = $block_name[0]['nama'];
			$data['owner_name'] = str_replace('%20',' ',$owner);
			$data['id_block'] = $id_block;
			$data['no_unit'] = $this->produksi->get_detail_produksi_owner($id_mat, $id_block, str_replace('%20',' ',$owner));
			$data['list_owner'] = $this->produksi->get_list_owner();
//			echo $data['owner_name'];die();
			$this->load->view('produksi/V_detail_produksi', $data);
		}
	}

	public function detail_unit($id_mat, $id_block, $cn_unit){
		$mat = '';
		$qty = '';
		if($id_mat == 3){
			$mat = 'OB';
			$qty = 5.5;
		}else{
			$mat = 'COAL';
			$qty = 20;
		}
		$block_name = $this->produksi->get_block_name($id_block);
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Unit '.$cn_unit;
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['qty'] = $qty;
		$data['id_mat'] = $id_mat;
		$data['block_name'] = $block_name[0]['nama'];
		$data['periode'] = '';
		$data['id_block'] = $id_block;
		$data['cn_unit'] = $cn_unit;
		$data['no_unit'] = $this->produksi->get_detail_produksi_unit($cn_unit,$id_mat, $id_block);
		$this->load->view('produksi/V_detail_unit', $data);
	}

	public function detail_unit_range($id_mat, $id_block, $cn_unit, $start, $end){
		$mat = '';
		$qty = '';
		if($id_mat == 3){
			$mat = 'OB';
			$qty = 5.5;
		}else{
			$mat = 'COAL';
			$qty = 20;
		}
		$block_name = $this->produksi->get_block_name($id_block);
		$this->global['pageTitle'] = 'BODC-Dashboard : Data Detail Unit '.$cn_unit.' Periode '.date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['head'] = $this->load->view('V_head',$this->global, TRUE);
		$data['header'] = $this->load->view('V_header','',TRUE);
		$data['sidebar'] = $this->load->view('V_sidebar','',TRUE);
		$data['footer'] = $this->load->view('V_footer','',TRUE);
		$data['script'] = $this->load->view('V_script','', TRUE);
		$data['material'] = $mat;
		$data['qty'] = $qty;
		$data['id_mat'] = $id_mat;
		$data['block_name'] = $block_name[0]['nama'];
		$data['periode'] = date('d F Y',strtotime($start)).' s/d '.date('d F Y',strtotime($end));
		$data['id_block'] = $id_block;
		$data['cn_unit'] = $cn_unit;
		$data['no_unit'] = $this->produksi->get_detail_produksi_unit_range($cn_unit,$id_mat,$id_block,date('Y-m-d',strtotime($start)),date('Y-m-d',strtotime($end)));
		$this->load->view('produksi/V_detail_unit', $data);
	}
}
