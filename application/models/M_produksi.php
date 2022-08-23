<?php
class M_produksi extends CI_Model{

	public function get_block($mat){
		$sql = "SELECT DISTINCT d.id, d.nama FROM activity a JOIN unit_status b ON b.no_unit = a.no_unit JOIN ritasi c ON c.no_unit = a.no_unit
				JOIN block d ON d.id = b.dumping_area 
				WHERE c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?";
		$res = $this->db->query($sql, array($mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat));
		$data = array();
		foreach ($res->result() as $row){
			$data['id_block'][] = $row->id;
			$data['block'][] = $row->nama;
		}
//		echo "<pre>";
//		print_r($data);
//		echo "</pre>";die();
		return $data;
	}

	public function get_block_name($id_block){
		$sql = "SELECT nama FROM block WHERE id = ?";
		$res = $this->db->query($sql, array($id_block));
		return $res->result_array();
	}

	public function get_detail_produksi($mat, $id_block){
		$sql = "SELECT DISTINCT e.*, f.nama FROM activity a JOIN unit_status b ON b.no_unit = a.no_unit JOIN ritasi c ON c.no_unit = a.no_unit
				JOIN block d ON d.id = b.dumping_area JOIN unit e ON e.no_unit = b.no_unit JOIN type_unit f ON f.id = e.type_unit
				WHERE b.dumping_area = ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?";
		$res = $this->db->query($sql, array($id_block,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
		}

		$sql2 = "SELECT no_unit, tgl_aktifitas FROM unit_status WHERE no_unit IN ? AND dumping_area = ?";
		$res2 = $this->db->query($sql2, array($data['no_unit'],$id_block));
		$data2 = array();
		foreach ($res2->result() as $row2){
			$data2['no_unit'][] = $row2->no_unit;
			$data2['tgl_aktifitas'][] = $row2->tgl_aktifitas;

			$sql3 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = ? THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = ? THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = ? THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = ? THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = ? THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = ? THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = ? THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = ? THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = ? THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = ? THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = ? THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = ? THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = ? THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = ? THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = ? THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = ? THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = ? THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = ? THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = ? THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = ? THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = ? THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = ? THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = ? THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = ? THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res3 = $this->db->query($sql3, array($mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$row2->no_unit,$row2->tgl_aktifitas))->result_array();
			$data['total'][$row2->no_unit][] = $res3[0]['total'];
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

	public function get_detail_produksi_owner($mat, $id_block, $owner){
		$sql = "SELECT DISTINCT e.*, f.nama FROM activity a JOIN unit_status b ON b.no_unit = a.no_unit JOIN ritasi c ON c.no_unit = a.no_unit
				JOIN block d ON d.id = b.dumping_area JOIN unit e ON e.no_unit = b.no_unit JOIN type_unit f ON f.id = e.type_unit
				WHERE b.dumping_area = ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?";
		$res = $this->db->query($sql, array($id_block,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat));
		$data = array();
		foreach ($res->result() as $row){
			if($row->owner == $owner){
				$data['no_unit'][] = $row->no_unit;
				$data['type_unit'][] = $row->nama;
				$data['type'][] = $row->type;
				$data['brand'][] = $row->brand;
				$data['owner'][] = $row->owner;
			}
		}

		$sql2 = "SELECT no_unit, tgl_aktifitas FROM unit_status WHERE no_unit IN ? AND dumping_area = ?";
		$res2 = $this->db->query($sql2, array($data['no_unit'],$id_block));
		$data2 = array();
		foreach ($res2->result() as $row2){
			$data2['no_unit'][] = $row2->no_unit;
			$data2['tgl_aktifitas'][] = $row2->tgl_aktifitas;

			$sql3 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = ? THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = ? THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = ? THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = ? THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = ? THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = ? THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = ? THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = ? THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = ? THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = ? THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = ? THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = ? THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = ? THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = ? THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = ? THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = ? THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = ? THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = ? THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = ? THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = ? THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = ? THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = ? THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = ? THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = ? THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res3 = $this->db->query($sql3, array($mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$row2->no_unit,$row2->tgl_aktifitas))->result_array();
			$data['total'][$row2->no_unit][] = $res3[0]['total'];
		}
		return $data;
	}

	public function get_detail_produksi_unit($cn_unit,$mat, $id_block){
		$sql = "SELECT * FROM (
				SELECT b.no_unit, f.nama, c.tgl_aktifitas FROM unit_status b JOIN ritasi c ON c.no_unit = b.no_unit AND c.tgl_aktifitas = b.tgl_aktifitas
				JOIN type_unit f ON f.id = b.loader
				WHERE b.dumping_area = ? AND b.no_unit = ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?	
				) AS T WHERE T.no_unit = ?";
		$res = $this->db->query($sql, array($id_block,$cn_unit,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$cn_unit));
//		echo "<pre>";
//		print_r($res->result());
//		echo "</pre>";die();
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['type_unit'][] = $row->nama;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;
			$sql3 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = ? THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = ? THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = ? THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = ? THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = ? THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = ? THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = ? THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = ? THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = ? THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = ? THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = ? THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = ? THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = ? THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = ? THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = ? THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = ? THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = ? THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = ? THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = ? THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = ? THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = ? THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = ? THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = ? THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = ? THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res3 = $this->db->query($sql3, array($mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$row->no_unit,$row->tgl_aktifitas))->result_array();
			$data['total'][] = $res3[0]['total'];
		}

		return $data;
	}

	public function get_detail_produksi_unit_range($cn_unit,$mat,$id_block,$start,$end){
		$sql = "SELECT * FROM (
				SELECT b.no_unit, f.nama, c.tgl_aktifitas FROM unit_status b JOIN ritasi c ON c.no_unit = b.no_unit AND c.tgl_aktifitas = b.tgl_aktifitas
				JOIN type_unit f ON f.id = b.loader
				WHERE b.dumping_area = ? AND b.no_unit = ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?	
				) AS T WHERE T.no_unit = ? AND T.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_block,$cn_unit,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$cn_unit,$start,$end));
//		echo "<pre>";
//		print_r($res->result());
//		echo "</pre>";die();
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['type_unit'][] = $row->nama;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;
			$sql3 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = ? THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = ? THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = ? THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = ? THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = ? THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = ? THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = ? THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = ? THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = ? THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = ? THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = ? THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = ? THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = ? THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = ? THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = ? THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = ? THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = ? THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = ? THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = ? THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = ? THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = ? THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = ? THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = ? THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = ? THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res3 = $this->db->query($sql3, array($mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$row->no_unit,$row->tgl_aktifitas))->result_array();
			$data['total'][] = $res3[0]['total'];
		}

		return $data;
	}
}
