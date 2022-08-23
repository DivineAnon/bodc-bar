<?php
class M_productivity extends CI_Model{

	public function get_egi($id_type_unit){
		$sql = "SELECT DISTINCT egi FROM unit WHERE type_unit = ?";
		$res = $this->db->query($sql, array($id_type_unit));
		$data = array();

		foreach ($res->result() as $row){
			$data['egi'][] = $row->egi;
		}
		return $data;
	}

	public function get_detail_productivity($egi, $id_type_unit){
		$sql = "SELECT a.*, b.nama FROM unit a JOIN type_unit b ON b.id = a.type_unit JOIN unit_status c ON a.no_unit = c.no_unit WHERE egi = ? AND type_unit = ? GROUP BY a.no_unit";
		$res = $this->db->query($sql, array($egi, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['detail'][] = $this->get_detail_unit($row->no_unit);
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

	public function get_detail_productivity_owner($egi, $id_type_unit, $owner){
		$sql = "SELECT a.*, b.nama 
				FROM unit a JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit 
				WHERE egi = ? AND type_unit = ? AND owner = ? GROUP BY a.no_unit";
		$res = $this->db->query($sql, array($egi, $id_type_unit, $owner));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['detail'][] = $this->get_detail_unit($row->no_unit);
		}

		return $data;
	}

	public function get_no_unit_tgl($no_unit){
		$sql = "SELECT id, no_unit, tgl_aktifitas FROM activity WHERE no_unit = ? ORDER BY tgl_aktifitas DESC";
		$res = $this->db->query($sql, array($no_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['id'][] = $row->id;
			$data['no_unit'][] = $row->no_unit;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;
		}
		return $data;
	}

	public function get_detail_unit($no_unit){
		$sql = "SELECT id, tgl_aktifitas, total_ton FROM activity WHERE no_unit = ?";
		$res = $this->db->query($sql, array($no_unit))->result();
		$data = array();
		if(!empty($res)){
			$produksi = 0;
			$stanby = array();
			$repair = array();
			foreach ($res as $row){
				$id = $row->id;
				$tgl_aktifitas = $row->tgl_aktifitas;
				$total_ton = $row->total_ton;
				//total produksi
				$produksi = floatval($produksi) + floatval($total_ton);
				//get standy unit per n
				$sql2 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM stanby_status WHERE id_activity = ?";
				$res2 = $this->db->query($sql2, array($id))->result();
				if(!empty($res2)){
					$total_seconds = 0;
					foreach ($res2 as $row2){
						$time_1 = $row2->time_1;
						$time_2 = $row2->time_2;
						$time_3 = $row2->time_3;
						$time_4 = $row2->time_4;
						//convert time_1 to seconds
						$time_1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_1);
						sscanf($time_1, "%d:%d:%d", $hours_1, $minutes_1, $seconds_1);
						$time_seconds_1 = $hours_1 * 3600 + $minutes_1 * 60 + $seconds_1;
						//convert time_2 to seconds
						$time_2 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_2);
						sscanf($time_2, "%d:%d:%d", $hours_2, $minutes_2, $seconds_2);
						$time_seconds_2 = $hours_2 * 3600 + $minutes_2 * 60 + $seconds_2;
						//convert time_1 to seconds
						$time_3 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_3);
						sscanf($time_3, "%d:%d:%d", $hours_3, $minutes_3, $seconds_3);
						$time_seconds_3 = $hours_3 * 3600 + $minutes_3 * 60 + $seconds_3;
						//convert time_1 to seconds
						$time_4 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_4);
						sscanf($time_4, "%d:%d:%d", $hours_4, $minutes_4, $seconds_4);
						$time_seconds_4 = $hours_4 * 3600 + $minutes_4 * 60 + $seconds_4;

						$total_seconds = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4) + intval($total_seconds);
					}
					//echo number_format($total_seconds/3600,2);die();
					if($total_seconds !== '0' || $total_seconds !== 0){
						$stanby[] = number_format($total_seconds/3600,2);
					}else{
						$stanby[] = 0;
					}
				}
				//get repair unit per n
				$sql3 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM breakdown_status WHERE id_activity = ?";
				$res3 = $this->db->query($sql3, array($id))->result();
				if(!empty($res3)){
					$total_repair = 0;
					foreach ($res3 as $row3){
						$time_1 = $row3->time_1;
						$time_2 = $row3->time_2;
						$time_3 = $row3->time_3;
						$time_4 = $row3->time_4;
						//convert time_1 to seconds
						$time_1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_1);
						sscanf($time_1, "%d:%d:%d", $hours_1, $minutes_1, $seconds_1);
						$time_seconds_1 = $hours_1 * 3600 + $minutes_1 * 60 + $seconds_1;
						//convert time_2 to seconds
						$time_2 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_2);
						sscanf($time_2, "%d:%d:%d", $hours_2, $minutes_2, $seconds_2);
						$time_seconds_2 = $hours_2 * 3600 + $minutes_2 * 60 + $seconds_2;
						//convert time_1 to seconds
						$time_3 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_3);
						sscanf($time_3, "%d:%d:%d", $hours_3, $minutes_3, $seconds_3);
						$time_seconds_3 = $hours_3 * 3600 + $minutes_3 * 60 + $seconds_3;
						//convert time_1 to seconds
						$time_4 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_4);
						sscanf($time_4, "%d:%d:%d", $hours_4, $minutes_4, $seconds_4);
						$time_seconds_4 = $hours_4 * 3600 + $minutes_4 * 60 + $seconds_4;

						$total_repair = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4) + intval($total_repair);
					}
					if($total_repair !== '0' || $total_repair !== 0){
						$repair[] = number_format($total_repair/3600,2);
					}else{
						$repair[] = 0;
					}
				}
			}
			$data['response'] = 'avail';
			$data['stanby'] = array_sum($stanby);
			$data['repair']= array_sum($repair);
			$data['produksi'] = $produksi;
			$work = count($res) * 24;
			$data['work'] = floatval($work) - floatval($data['stanby']) - floatval($data['repair']);
			$data['day'] = count($res);
		}else{
			$data['response'] = 'empty';
		}
		return $data;
	}

	public function get_no_unit_tgl_range($no_unit,$start,$end){
		$sql = "SELECT id, no_unit, tgl_aktifitas 
				FROM activity WHERE no_unit = ? AND tgl_aktifitas BETWEEN ? AND ? ORDER BY tgl_aktifitas DESC";
		$res = $this->db->query($sql, array($no_unit,$start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['id'][] = $row->id;
			$data['no_unit'][] = $row->no_unit;
			$data['tgl_aktifitas'][] = $row->tgl_aktifitas;
		}
		return $data;
	}

	public function get_detail_unit_range($no_unit,$start,$end){
		$sql = "SELECT id, tgl_aktifitas, total_ton FROM activity WHERE no_unit = ? AND tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($no_unit,$start,$end))->result();
		$data = array();
		if(!empty($res)){
			$produksi = 0;
			$stanby = array();
			$repair = array();
			foreach ($res as $row){
				$id = $row->id;
				$tgl_aktifitas = $row->tgl_aktifitas;
				$total_ton = $row->total_ton;
				//total produksi
				$produksi = floatval($produksi) + floatval($total_ton);
				//get standy unit per n
				$sql2 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM stanby_status WHERE id_activity = ?";
				$res2 = $this->db->query($sql2, array($id))->result();
				if(!empty($res2)){
					$total_seconds = 0;
					foreach ($res2 as $row2){
						$time_1 = $row2->time_1;
						$time_2 = $row2->time_2;
						$time_3 = $row2->time_3;
						$time_4 = $row2->time_4;
						//convert time_1 to seconds
						$time_1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_1);
						sscanf($time_1, "%d:%d:%d", $hours_1, $minutes_1, $seconds_1);
						$time_seconds_1 = $hours_1 * 3600 + $minutes_1 * 60 + $seconds_1;
						//convert time_2 to seconds
						$time_2 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_2);
						sscanf($time_2, "%d:%d:%d", $hours_2, $minutes_2, $seconds_2);
						$time_seconds_2 = $hours_2 * 3600 + $minutes_2 * 60 + $seconds_2;
						//convert time_1 to seconds
						$time_3 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_3);
						sscanf($time_3, "%d:%d:%d", $hours_3, $minutes_3, $seconds_3);
						$time_seconds_3 = $hours_3 * 3600 + $minutes_3 * 60 + $seconds_3;
						//convert time_1 to seconds
						$time_4 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_4);
						sscanf($time_4, "%d:%d:%d", $hours_4, $minutes_4, $seconds_4);
						$time_seconds_4 = $hours_4 * 3600 + $minutes_4 * 60 + $seconds_4;

						$total_seconds = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4) + intval($total_seconds);
					}
					//echo number_format($total_seconds/3600,2);die();
					if($total_seconds !== '0' || $total_seconds !== 0){
						$stanby[] = number_format($total_seconds/3600,2);
					}else{
						$stanby[] = 0;
					}
				}
				//get repair unit per n
				$sql3 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM breakdown_status WHERE id_activity = ?";
				$res3 = $this->db->query($sql3, array($id))->result();
				if(!empty($res3)){
					$total_repair = 0;
					foreach ($res3 as $row3){
						$time_1 = $row3->time_1;
						$time_2 = $row3->time_2;
						$time_3 = $row3->time_3;
						$time_4 = $row3->time_4;
						//convert time_1 to seconds
						$time_1 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_1);
						sscanf($time_1, "%d:%d:%d", $hours_1, $minutes_1, $seconds_1);
						$time_seconds_1 = $hours_1 * 3600 + $minutes_1 * 60 + $seconds_1;
						//convert time_2 to seconds
						$time_2 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_2);
						sscanf($time_2, "%d:%d:%d", $hours_2, $minutes_2, $seconds_2);
						$time_seconds_2 = $hours_2 * 3600 + $minutes_2 * 60 + $seconds_2;
						//convert time_1 to seconds
						$time_3 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_3);
						sscanf($time_3, "%d:%d:%d", $hours_3, $minutes_3, $seconds_3);
						$time_seconds_3 = $hours_3 * 3600 + $minutes_3 * 60 + $seconds_3;
						//convert time_1 to seconds
						$time_4 = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time_4);
						sscanf($time_4, "%d:%d:%d", $hours_4, $minutes_4, $seconds_4);
						$time_seconds_4 = $hours_4 * 3600 + $minutes_4 * 60 + $seconds_4;

						$total_repair = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4) + intval($total_repair);
					}
					if($total_repair !== '0' || $total_repair !== 0){
						$repair[] = number_format($total_repair/3600,2);
					}else{
						$repair[] = 0;
					}
				}
			}
			$data['response'] = 'avail';
			$data['stanby'] = array_sum($stanby);
			$data['repair']= array_sum($repair);
			$data['produksi'] = $produksi;
			$work = count($res) * 24;
			$data['work'] = floatval($work) - floatval($data['stanby']) - floatval($data['repair']);
			$data['day'] = count($res);
		}else{
			$data['response'] = 'empty';
		}
		return $data;
	}
}
