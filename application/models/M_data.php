<?php
class M_data extends CI_Model{

	public function get_no_unit(){
		$sql = "SELECT DISTINCT no_unit FROM activity ORDER BY id DESC";
		$res = $this->db->query($sql);
//		print_r($res);die();
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
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

	public function get_data_unit_detail_per_tgl($id){
		$sql = "SELECT no_unit, tgl_aktifitas, total_ton FROM activity WHERE id = ?";
		$res = $this->db->query($sql, array($id))->result_array();
		$data = array();
		$data['no_unit'] = $res[0]['no_unit'];
		$data['tgl_aktifitas'] = date('d F Y', strtotime($res[0]['tgl_aktifitas']));
		$stanby = 0;
		$repair = 0;
		$produksi = $res[0]['total_ton'];
		//get stanby status
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
			if(intval($total_seconds) !== 0){
				$stanby = round($total_seconds/3600,2);
			}
		}
		//get breakdown status
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

			if(intval($total_repair) !== 0){
				$repair = round($total_repair/3600,2);
			}
		}
		$work = floatval(24) - floatval($stanby) - floatval($repair);

		$pa = (floatval($work) + floatval($stanby))/(floatval($work)+floatval($stanby)+floatval($repair));
		$ua = floatval($work)/(floatval($work)+floatval($stanby));
		$prod = floatval($produksi)/floatval($work);
		if(floatval($pa) && intval($pa) != floatval($pa)){
			$data['pa'] = number_format($pa, 2);
		}else{
			$data['pa'] = $pa;
		}
		if(floatval($ua) && intval($ua) != floatval($ua)){
			$data['ua'] = number_format($ua, 2);
		}else{
			$data['ua'] = $ua;
		}
		if(floatval($prod) && intval($prod) != floatval($prod)){
			$data['prod'] = number_format($prod, 2);
		}else{
			$data['prod'] = $prod;
		}
		if(floatval($produksi) && intval($produksi) != floatval($produksi)){
			$data['produksi'] = number_format($produksi,2);
		}else{
			$data['produksi'] = $produksi;
		}
		$data['work'] = $work;
		$data['stanby'] = $stanby;
		$data['repair'] = $repair;

		return $data;
	}
}
