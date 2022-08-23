<?php
class M_fuel_ratio extends CI_Model{

	public function get_egi($id_type_unit){
		$sql = "SELECT DISTINCT egi FROM unit WHERE type_unit = ?";
		$res = $this->db->query($sql, array($id_type_unit));
		$data = array();

		foreach ($res->result() as $row){
			$data['egi'][] = $row->egi;
		}
		return $data;
	}

	public function get_detail_fuel_ratio($egi, $id_type_unit){
		$sql = "SELECT a.*, b.nama FROM unit a JOIN type_unit b ON b.id = a.type_unit JOIN unit_status c ON c.no_unit = a.no_unit WHERE a.egi = ? AND a.type_unit = ? GROUP BY a.no_unit";
		$res = $this->db->query($sql, array($egi, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;

			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam FROM activity WHERE no_unit = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit))->result();
			$total_fuel_ratio = 0;
			foreach ($res2 as $row2){
				$fuel = $row2->fuel;
				$jam = $row2->total_jam;
				$fuel_ratio = number_format($fuel/$jam, 2);
				$total_fuel_ratio += $fuel_ratio;
			}
			$data['fuel_ratio'][] = number_format($total_fuel_ratio, 2);

		}

		return $data;
	}

	public function get_list_owner(){
		$sql = "SELECT DISTINCT owner FROM unit";
		$res = $this->db->query($sql);
		$data = array();
		foreach ($res->result() as $row){
			$data['owner'][] = $row->owner;
		}
		return $data;
	}

	public function get_detail_fuel_ratio_owner($egi,$id_type_unit,$owner){
		$sql = "SELECT a.*, b.nama FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit JOIN unit_status c ON c.no_unit = a.no_unit 
				WHERE a.egi = ? AND a.type_unit = ? AND a.owner = ? GROUP BY a.no_unit";
		$res = $this->db->query($sql, array($egi, $id_type_unit, $owner));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;

			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam FROM activity WHERE no_unit = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit))->result();
			$total_fuel_ratio = 0;
			foreach ($res2 as $row2){
				$fuel = $row2->fuel;
				$jam = $row2->total_jam;
				$fuel_ratio = number_format($fuel/$jam, 2);
				$total_fuel_ratio += $fuel_ratio;
			}
			$data['fuel_ratio'][] = number_format($total_fuel_ratio, 2);

		}

		return $data;
	}

	public function get_detail_fuel_ratio_unit($cn_unit,$id_type_unit){
		$sql = "SELECT a.*, b.nama, c.tgl_aktifitas FROM unit a JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON c.no_unit = a.no_unit 
				WHERE a.no_unit = ? AND a.type_unit = ? ORDER BY c.tgl_aktifitas DESC";
		$res = $this->db->query($sql, array($cn_unit, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;

			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam FROM activity WHERE no_unit = ? AND tgl_aktifitas = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit, $row->tgl_aktifitas))->result_array();
			if($res2[0]['fuel'] != NULL && $res2[0]['total_jam'] != NULL){
				$data['fuel_ratio'][] = number_format($res2[0]['fuel']/$res2[0]['total_jam'], 2);
			}else{
				$data['fuel_ratio'][] = 'empty';
			}
		}

		return $data;
	}

	public function get_detail_fuel_ratio_unit_range($cn_unit,$id_type_unit,$start,$end){
		$sql = "SELECT a.*, b.nama, c.tgl_aktifitas FROM unit a JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON c.no_unit = a.no_unit 
				WHERE a.no_unit = ? AND a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ? ORDER BY c.tgl_aktifitas DESC";
		$res = $this->db->query($sql, array($cn_unit, $id_type_unit, $start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;

			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam FROM activity WHERE no_unit = ? AND tgl_aktifitas = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit, $row->tgl_aktifitas))->result_array();
			if($res2[0]['fuel'] != NULL && $res2[0]['total_jam'] != NULL){
				$data['fuel_ratio'][] = number_format($res2[0]['fuel']/$res2[0]['total_jam'], 2);
			}else{
				$data['fuel_ratio'][] = 'empty';
			}
		}

		return $data;
	}
}
