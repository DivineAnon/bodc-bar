<?php
class M_dashboard extends CI_Model{

	public function get_last_date($year, $month){
		$sql = "SELECT DAY(tgl_aktifitas) AS day FROM `activity` WHERE YEAR(tgl_aktifitas) = ? AND MONTH(tgl_aktifitas) = ? ORDER BY id DESC LIMIT 1";
		$res = $this->db->query($sql, array($year,$month))->result();
		foreach ($res as $row){
			$day = $row->day;
			return $day;
		}
	}
	public function get_data_hauler($tgl,$type){
		$sql = "SELECT a.no_unit, a.id FROM activity a 
				JOIN unit_status c ON a.no_unit = c.no_unit AND a.tgl_aktifitas = c.tgl_aktifitas 
				WHERE a.tgl_aktifitas = ? AND loader = ?";
		$res = $this->db->query($sql, array($tgl, $type))->result();
		$data = array();
		if(!empty($res)){
			foreach ($res as $row){
				$no_unit = $row->no_unit;
				$id = $row->id;
				$data['no_unit'][] = $row->no_unit;
				$wsr_hauler = $this->get_detail_unit($id);
				if($wsr_hauler['response'] == 'avail'){
					$pa_hauler = (floatval($wsr_hauler['work']) + floatval($wsr_hauler['stanby']))/(floatval($wsr_hauler['work']) + floatval($wsr_hauler['stanby']) + floatval($wsr_hauler['repair']));
					$ua_hauler = floatval($wsr_hauler['work'])/(floatval($wsr_hauler['work']) + floatval($wsr_hauler['stanby']));;
					$prod_hauler = floatval($wsr_hauler['produksi'])/floatval($wsr_hauler['work']);
					if(floatval($pa_hauler) && intval($pa_hauler) != floatval($pa_hauler)){
						$data['pa_hauler'][] =  round($pa_hauler,2);
					}else{
						$data['pa_hauler'][] = $pa_hauler;
					}
					if(floatval($ua_hauler) && intval($ua_hauler) != floatval($ua_hauler)){
						$data['ua_hauler'][] =  round($ua_hauler,2);
					}else{
						$data['ua_hauler'][] = $ua_hauler;
					}
					if(floatval($prod_hauler) && intval($prod_hauler) != floatval($prod_hauler)){
						$data['prod_hauler'][] =  round($prod_hauler,2);
					}else{
						$data['prod_hauler'][] = $prod_hauler;
					}
					$data['response'] = 'avail';
				}else{
					$data['response'] = 'empty';
				}
			}
		}else{
			$data['response'] = 'empty';
		}
//		echo "<pre>";
//		print_r($data);
//		echo "</pre>";die();
		return $data;
	}

	public function get_data_loader($tgl, $type){
		$sql = "SELECT a.no_unit, a.id FROM activity a 
				JOIN unit_status c ON a.no_unit = c.no_unit AND a.tgl_aktifitas = c.tgl_aktifitas 
				WHERE a.tgl_aktifitas = ? AND loader = ?";
		$res = $this->db->query($sql, array($tgl, $type))->result();
		$data = array();
		if(!empty($res)){
			foreach ($res as $row){
				$no_unit = $row->no_unit;
				$id = $row->id;
				$data['no_unit'][] = $row->no_unit;
				$wsr_loader = $this->get_detail_unit($id);
				if($wsr_loader['response'] == 'avail'){
					$pa_loader = (floatval($wsr_loader['work']) + floatval($wsr_loader['stanby']))/(floatval($wsr_loader['work']) + floatval($wsr_loader['stanby']) + floatval($wsr_loader['repair']));
					$ua_loader = floatval($wsr_loader['work'])/(floatval($wsr_loader['work']) + floatval($wsr_loader['stanby']));;
					$prod_loader = floatval($wsr_loader['produksi'])/floatval($wsr_loader['work']);
					if(floatval($pa_loader) && intval($pa_loader) != floatval($pa_loader)){
						$data['pa_loader'][] =  round($pa_loader,2);
					}else{
						$data['pa_loader'][] = $pa_loader;
					}
					if(floatval($ua_loader) && intval($ua_loader) != floatval($ua_loader)){
						$data['ua_loader'][] =  round($ua_loader,2);
					}else{
						$data['ua_loader'][] = $ua_loader;
					}
					if(floatval($prod_loader) && intval($prod_loader) != floatval($prod_loader)){
						$data['prod_loader'][] =  round($prod_loader,2);
					}else{
						$data['prod_loader'][] = $prod_loader;
					}
					$data['response'] = 'avail';
				}else{
					$data['response'] = 'empty';
				}
			}
		}else{
			$data['response'] = 'empty';
		}
//		echo "<pre>";
//		print_r($data);
//		echo "</pre>";die();
		return $data;
	}

	public function get_detail_unit($id){
		$sql = "SELECT no_unit, tgl_aktifitas, total_ton FROM activity WHERE id = ?";
		$res = $this->db->query($sql, array($id))->result_array();
		$data = array();
		if(!empty($res)){
			$data['no_unit'] = $res[0]['no_unit'];
			$data['tgl_aktifitas'] = date('d F Y', strtotime($res[0]['tgl_aktifitas']));
			$stanby = 0;
			$repair = 0;
			$produksi = $res[0]['total_ton'];
			//get stanby status
			$sql2 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM stanby_status WHERE id_activity = ?";
			$res2 = $this->db->query($sql2, array($id))->result_array();
			$time_1 = 0;
			$time_2 = 0;
			$time_3 = 0;
			$time_4 = 0;
			if(!empty($res2)){
				$time_1 = $res2[0]['time_1'];
				$time_2 = $res2[0]['time_2'];
				$time_3 = $res2[0]['time_3'];
				$time_4 = $res2[0]['time_4'];
			}
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

			$total_seconds = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4);
			if(intval($total_seconds) !== 0){
				$stanby = number_format($total_seconds/3600,2);
			}
			//get breakdown status
			$sql3 = "SELECT id, TIMEDIFF(end_time_1, start_time_1) AS time_1, TIMEDIFF(end_time_2, start_time_2) AS time_2, TIMEDIFF(end_time_3, start_time_3) AS time_3, TIMEDIFF(end_time_4, start_time_4) AS time_4 FROM breakdown_status WHERE id_activity = ?";
			$res3 = $this->db->query($sql3, array($id))->result_array();
			$time_1 = 0;
			$time_2 = 0;
			$time_3 = 0;
			$time_4 = 0;
			if(!empty($res2)){
				$time_1 = $res3[0]['time_1'];
				$time_2 = $res3[0]['time_2'];
				$time_3 = $res3[0]['time_3'];
				$time_4 = $res3[0]['time_4'];
			}
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

			$total_seconds = intval($time_seconds_1) + intval($time_seconds_2) + intval($time_seconds_3) + intval($time_seconds_4);
			if(intval($total_seconds) !== 0){
				$repair = number_format($total_seconds/3600,2);
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
			$data['response'] = 'avail';
		}else{
			$data['response'] = 'empty';
		}
		return $data;
	}

	public function get_data_produksi($tgl,$mat){
		$sql2 = "SELECT no_unit, tgl_aktifitas FROM unit_status WHERE tgl_aktifitas = ?";
		$res2 = $this->db->query($sql2, array($tgl));
		$data2 = array();
		$total = 0;
		foreach ($res2->result() as $row2){
//			$data2['no_unit'][] = $row2->no_unit;
//			$data2['tgl_aktifitas'][] = $row2->tgl_aktifitas;

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
			 $total += $res3[0]['total'];
		}
		$data2['total'][] = $total;

//		echo "<pre>";
//		print_r($data);
//		echo "</pre>";die();
		return $data2;
	}

	public function get_data_stanby($year, $month){
		$sql = "SELECT kode, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(SELECT d.kode, TIMEDIFF(a.end_time_1, a.start_time_1) AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM stanby_status a JOIN activity b ON b.id = a.id_activity JOIN unit_status c ON c.no_unit = b.no_unit JOIN stanby d ON d.id = a.id_stanby 
                     WHERE YEAR(b.tgl_aktifitas) = ? AND MONTH(b.tgl_aktifitas) = ?
				) AS T GROUP BY kode ORDER BY times DESC";
		$res = $this->db->query($sql, array($year, $month));
		$data = array();

		foreach ($res->result() as $row){
			$data['kode'][] = $row->kode;
			$data['times'][] = $row->times;
		}

		if(!empty($data['kode'])){
			$sql3 = "SELECT * FROM stanby";
			$res3 = $this->db->query($sql3);

			foreach ($res3->result() as $row3){
				if(!in_array($row3->kode,$data['kode'])){
					$data['kode'][] = $row3->kode;
					$data['times'][] = '-';
				}
			}
		}else{
			$sql4 = "SELECT * FROM stanby LIMIT 10";
			$res4 = $this->db->query($sql4);

			foreach ($res4->result() as $row4){
				$data['kode'][] = $row4->kode;
				$data['times'][] = '-';
			}
		}

		return $data;
	}

	public function get_fuel_ratio($tgl,$id_type_unit){
		$sql = "SELECT a.*, b.nama FROM unit a JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON c.no_unit = a.no_unit 
				WHERE c.tgl_aktifitas = ? AND a.type_unit = ?";
		$res = $this->db->query($sql, array($tgl, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam 
					 FROM activity WHERE no_unit = ? AND tgl_aktifitas = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit, $tgl))->result();
			$total_fuel_ratio = 0;
			$total_ob = 0;
			$total_coal = 0;
			foreach ($res2 as $row2){
				$fuel = $row2->fuel;
				$jam = $row2->total_jam;
				$fuel_ratio = round($fuel);
				$total_fuel_ratio += $fuel_ratio;
			}
			$sql3 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = 3 THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = 3 THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = 3 THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = 3 THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = 3 THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = 3 THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = 3 THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = 3 THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = 3 THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = 3 THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = 3 THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = 3 THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = 3 THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = 3 THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = 3 THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = 3 THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = 3 THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = 3 THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = 3 THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = 3 THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = 3 THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = 3 THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = 3 THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = 3 THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res3 = $this->db->query($sql3, array($row->no_unit, $tgl))->result_array();
			$total_ob = $res3[0]['total'];
			$sql4 = "SELECT t.no_unit, SUM(mat_1_all+ mat_2_all + mat_3_all + mat_4_all + mat_5_all + mat_6_all + mat_7_all + mat_8_all + mat_9_all
					+ mat_10_all + mat_11_all + mat_12_all + mat_13_all + mat_14_all + mat_15_all  + mat_16_all + mat_17_all + mat_18_all + mat_19_all + mat_20_all + mat_21_all + mat_22_all + mat_23_all + mat_24_all) AS total FROM (
					SELECT a.no_unit,
					 SUM(CASE WHEN a.mat_1 = 4 THEN 1 ELSE 0 END) AS mat_1_all
					,SUM(CASE WHEN a.mat_2 = 4 THEN 1 ELSE 0 END) AS mat_2_all
					,SUM(CASE WHEN a.mat_3 = 4 THEN 1 ELSE 0 END) AS mat_3_all
					,SUM(CASE WHEN a.mat_4 = 4 THEN 1 ELSE 0 END) AS mat_4_all
					,SUM(CASE WHEN a.mat_5 = 4 THEN 1 ELSE 0 END) AS mat_5_all
					,SUM(CASE WHEN a.mat_6 = 4 THEN 1 ELSE 0 END) AS mat_6_all
					,SUM(CASE WHEN a.mat_7 = 4 THEN 1 ELSE 0 END) AS mat_7_all
					,SUM(CASE WHEN a.mat_8 = 4 THEN 1 ELSE 0 END) AS mat_8_all
					,SUM(CASE WHEN a.mat_9 = 4 THEN 1 ELSE 0 END) AS mat_9_all
					,SUM(CASE WHEN a.mat_10 = 4 THEN 1 ELSE 0 END) AS mat_10_all
					,SUM(CASE WHEN a.mat_11 = 4 THEN 1 ELSE 0 END) AS mat_11_all
					,SUM(CASE WHEN a.mat_12 = 4 THEN 1 ELSE 0 END) AS mat_12_all
					,SUM(CASE WHEN a.mat_13 = 4 THEN 1 ELSE 0 END) AS mat_13_all
					,SUM(CASE WHEN a.mat_14 = 4 THEN 1 ELSE 0 END) AS mat_14_all
					,SUM(CASE WHEN a.mat_15 = 4 THEN 1 ELSE 0 END) AS mat_15_all
					,SUM(CASE WHEN a.mat_16 = 4 THEN 1 ELSE 0 END) AS mat_16_all
					,SUM(CASE WHEN a.mat_17 = 4 THEN 1 ELSE 0 END) AS mat_17_all
					,SUM(CASE WHEN a.mat_18 = 4 THEN 1 ELSE 0 END) AS mat_18_all
					,SUM(CASE WHEN a.mat_19 = 4 THEN 1 ELSE 0 END) AS mat_19_all
					,SUM(CASE WHEN a.mat_20 = 4 THEN 1 ELSE 0 END) AS mat_20_all
					,SUM(CASE WHEN a.mat_21 = 4 THEN 1 ELSE 0 END) AS mat_21_all
					,SUM(CASE WHEN a.mat_22 = 4 THEN 1 ELSE 0 END) AS mat_22_all
					,SUM(CASE WHEN a.mat_23 = 4 THEN 1 ELSE 0 END) AS mat_23_all
					,SUM(CASE WHEN a.mat_24 = 4 THEN 1 ELSE 0 END) AS mat_24_all
					FROM ritasi a WHERE a.no_unit = ? AND a.tgl_aktifitas = ?
					)as t";
			$res4 = $this->db->query($sql4, array($row->no_unit, $tgl))->result_array();
			$total_coal = $res4[0]['total'];
			$total_produksi = (round($total_ob,2)* 5.5) + (0.7 * (round($total_coal,2))*20);
			if($total_produksi == 0){
				$data['fuel_ratio'][] = $total_fuel_ratio;
			}else{
				$data['fuel_ratio'][] = $total_fuel_ratio/$total_produksi;
			}
		}

		return $data;
	}

	public function get_breakdown($tgl){
		$sql = "SELECT breakdown_status, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(
				SELECT a.breakdown_status, TIMEDIFF(a.end_time_1, a.start_time_1) 
				AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, 
				TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM breakdown_status a JOIN activity b ON b.id = a.id_activity 
				WHERE b.tgl_aktifitas = ?
				) AS T GROUP BY breakdown_status";
		$res = $this->db->query($sql, array($tgl));
		$data = array();

		foreach ($res->result() as $row){
			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row->times);
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
			$data['seconds'][$row->breakdown_status] = $time_seconds;
		}
//		print_r($data);die();
		return $data;
	}

	public function get_data_stanby_range($start_date,$end_date){
		$sql = "SELECT kode, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(SELECT d.kode, TIMEDIFF(a.end_time_1, a.start_time_1) AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM stanby_status a JOIN activity b ON b.id = a.id_activity JOIN unit_status c ON c.no_unit = b.no_unit JOIN stanby d ON d.id = a.id_stanby 
                     WHERE b.tgl_aktifitas BETWEEN ? AND ?
				) AS T GROUP BY kode ORDER BY times DESC";
		$res = $this->db->query($sql, array($start_date, $end_date));
		$data = array();

		foreach ($res->result() as $row){
			$data['kode'][] = $row->kode;
			$data['times'][] = $row->times;
		}

		if(!empty($data['kode'])){
			$sql3 = "SELECT * FROM stanby";
			$res3 = $this->db->query($sql3);

			foreach ($res3->result() as $row3){
				if(!in_array($row3->kode,$data['kode'])){
					$data['kode'][] = $row3->kode;
					$data['times'][] = '-';
				}
			}
		}else{
			$sql4 = "SELECT * FROM stanby LIMIT 10";
			$res4 = $this->db->query($sql4);

			foreach ($res4->result() as $row4){
				$data['kode'][] = $row4->kode;
				$data['times'][] = '-';
			}
		}

		return $data;
	}

	public function get_detail_produksi($mat,$tgl){
		$sql = "SELECT * FROM (
				SELECT e.*, f.nama, a.tgl_aktifitas 
				FROM activity a 
				JOIN ritasi c ON a.no_unit = c.no_unit AND a.tgl_aktifitas = c.tgl_aktifitas 
				JOIN unit e ON e.no_unit = a.no_unit 
				JOIN type_unit f ON f.id = e.type_unit
				WHERE a.tgl_aktifitas = ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?
				) AS T WHERE tgl_aktifitas = ? ";
		$res = $this->db->query($sql, array($tgl,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat, $tgl));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
		}
		if(!empty($data['no_unit'])){
			$sql2 = "SELECT no_unit, tgl_aktifitas FROM unit_status WHERE no_unit IN ? AND tgl_aktifitas = ?";
			$res2 = $this->db->query($sql2, array($data['no_unit'],$tgl));
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
				$data['total'][] = $res3[0]['total'];
			}
		}
		return $data;
	}

	public function get_detail_produksi_range($mat,$start,$end){
		$sql = "SELECT * FROM (
				SELECT e.*, f.nama, a.tgl_aktifitas FROM activity a 
				JOIN ritasi c ON a.no_unit = c.no_unit AND a.tgl_aktifitas = c.tgl_aktifitas
				JOIN unit e ON e.no_unit = a.no_unit 
				JOIN type_unit f ON f.id = e.type_unit
				WHERE a.tgl_aktifitas BETWEEN ? AND ? AND c.mat_1 = ? OR c.mat_2 = ? OR c.mat_3 = ? OR c.mat_4 = ? OR c.mat_5 = ? OR c.mat_6 = ? OR c.mat_7 = ? 
				OR c.mat_8 = ? OR c.mat_9 = ? OR c.mat_10 = ? OR c.mat_11 = ? OR c.mat_12 = ? OR c.mat_13 = ? OR c.mat_14 = ? 
				OR c.mat_15 = ? OR c.mat_16 = ? OR c.mat_17 = ? OR c.mat_18 = ? OR c.mat_19 = ? OR c.mat_20 = ? OR c.mat_21 = ? 
				OR c.mat_22 = ? OR c.mat_23 = ? OR  c.mat_24 = ?
				) AS T WHERE tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($start, $end,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat,$mat, $start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
		}

		if(!empty($data['no_unit'])){
			$sql2 = "SELECT no_unit, tgl_aktifitas FROM unit_status WHERE no_unit IN ? AND tgl_aktifitas BETWEEN ? AND ?";
			$res2 = $this->db->query($sql2, array($data['no_unit'],$start, $end));
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
				$data['total'][] = $res3[0]['total'];
			}
		}

		return $data;
	}

	public function get_breakdown_search($id_type_unit, $start, $end){
		$sql2 = "SELECT breakdown_status, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(
				SELECT a.breakdown_status, TIMEDIFF(a.end_time_1, a.start_time_1) 
				AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, 
				TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM breakdown_status a 
				JOIN activity b ON b.id = a.id_activity 
				JOIN unit_status c ON c.no_unit = b.no_unit AND b.tgl_aktifitas = c.tgl_aktifitas 
				WHERE b.tgl_aktifitas BETWEEN ? AND ? AND c.loader = ?
				) AS T GROUP BY breakdown_status";
		$res2 = $this->db->query($sql2, array($start,$end, $id_type_unit));
		$data = array();
		$total_seconds = 0;
		foreach ($res2->result() as $row2){
			$data['breakdown_status'][$row2->breakdown_status] = $row2->times;

			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row2->times);
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
			$total_seconds += $time_seconds;
			$data['seconds'][$row2->breakdown_status] = $time_seconds;
		}
		$data['total_seconds'] = $total_seconds;
		return $data;
	}

	public function get_detail_pa($id_type_unit, $start,$end){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_type_unit, $start, $end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_breakdown_search_range($id_type_unit, $start,$end){
		$sql2 = "SELECT breakdown_status, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(
				SELECT a.breakdown_status, TIMEDIFF(a.end_time_1, a.start_time_1) 
				AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, 
				TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM breakdown_status a 
				JOIN activity b ON b.id = a.id_activity 
				JOIN unit_status c ON c.no_unit = b.no_unit AND b.tgl_aktifitas = c.tgl_aktifitas 
				WHERE b.tgl_aktifitas BETWEEN ? AND ? AND c.loader = ?
				) AS T GROUP BY breakdown_status";
		$res2 = $this->db->query($sql2, array($start,$end, $id_type_unit));
		$data = array();
		$total_seconds = 0;
		foreach ($res2->result() as $row2){
			$data['breakdown_status'][$row2->breakdown_status] = $row2->times;

			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row2->times);
			sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
			$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
			$total_seconds += $time_seconds;
			$data['seconds'][$row2->breakdown_status] = $time_seconds;
		}
		$data['total_seconds'] = $total_seconds;
		return $data;
	}

	public function get_detail_pa_range($id_type_unit, $start,$end){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_type_unit, $start, $end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_detail_ua($id_type_unit, $start,$end){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_type_unit, $start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_stanby_search($id_type_unit, $start,$end){
		$sql = "SELECT kode, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(SELECT d.kode, TIMEDIFF(a.end_time_1, a.start_time_1) AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM stanby_status a 
				JOIN activity b ON b.id = a.id_activity 
				JOIN unit_status c ON c.no_unit = b.no_unit 
				JOIN stanby d ON d.id = a.id_stanby 
				WHERE c.loader = ? AND b.tgl_aktifitas BETWEEN ? AND ?
				) AS T GROUP BY kode ORDER BY times DESC";
		$res = $this->db->query($sql, array($id_type_unit, $start, $end));
		$data = array();

		foreach ($res->result() as $row){
			$data['kode'][] = $row->kode;
			$data['times'][] = $row->times;

			$sql2 = "SELECT DISTINCT COUNT(b.no_unit) AS qty FROM stanby_status a 
					JOIN activity b ON b.id = a.id_activity 
					JOIN unit c ON c.no_unit = b.no_unit 
					JOIN stanby d ON d.id = a.id_stanby 
					WHERE d.kode = ? AND c.type_unit = ? AND b.tgl_aktifitas BETWEEN ? AND ?";
			$res2 = $this->db->query($sql2,array($row->kode, $id_type_unit, $start, $end))->result_array();
			$data['qty'][] = $res2[0]['qty'];
		}

		if(!empty($data['kode'])){
			$sql3 = "SELECT * FROM stanby";
			$res3 = $this->db->query($sql3);

			foreach ($res3->result() as $row3){
				if(!in_array($row3->kode,$data['kode'])){
					$data['kode'][] = $row3->kode;
					$data['times'][] = '-';
					$data['qty'][] = '-';
				}
			}
		}else{
			$sql4 = "SELECT * FROM stanby LIMIT 10";
			$res4 = $this->db->query($sql4);

			foreach ($res4->result() as $row4){
				$data['kode'][] = $row4->kode;
				$data['times'][] = '-';
				$data['qty'][] = '-';
			}
		}

		return $data;
	}

	public function get_detail_ua_range($id_type_unit, $start,$end){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_type_unit, $start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_stanby_search_range($id_type_unit, $start,$end){
		$sql = "SELECT kode, SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(SELECT d.kode, TIMEDIFF(a.end_time_1, a.start_time_1) AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
				FROM stanby_status a 
				JOIN activity b ON b.id = a.id_activity 
				JOIN unit_status c ON c.no_unit = b.no_unit 
				JOIN stanby d ON d.id = a.id_stanby 
				WHERE c.loader = ? AND b.tgl_aktifitas BETWEEN ? AND ? 
				) AS T GROUP BY kode ORDER BY times DESC";
		$res = $this->db->query($sql, array($id_type_unit, $start,$end));
		$data = array();

		foreach ($res->result() as $row){
			$data['kode'][] = $row->kode;
			$data['times'][] = $row->times;

			$sql2 = "SELECT DISTINCT COUNT(b.no_unit) AS qty FROM stanby_status a 
					JOIN activity b ON b.id = a.id_activity 
					JOIN unit c ON c.no_unit = b.no_unit 
					JOIN stanby d ON d.id = a.id_stanby 
					WHERE d.kode = ? AND c.type_unit = ? AND b.tgl_aktifitas BETWEEN ? AND ?";
			$res2 = $this->db->query($sql2,array($row->kode, $id_type_unit, $start, $end))->result_array();
			$data['qty'][] = $res2[0]['qty'];
		}

		if(!empty($data['kode'])){
			$sql3 = "SELECT * FROM stanby";
			$res3 = $this->db->query($sql3);

			foreach ($res3->result() as $row3){
				if(!in_array($row3->kode,$data['kode'])){
					$data['kode'][] = $row3->kode;
					$data['times'][] = '-';
					$data['qty'][] = '-';
				}
			}
		}else{
			$sql4 = "SELECT * FROM stanby LIMIT 10";
			$res4 = $this->db->query($sql4);

			foreach ($res4->result() as $row4){
				$data['kode'][] = $row4->kode;
				$data['times'][] = '-';
				$data['qty'][] = '-';
			}
		}

		return $data;
	}

	public function get_detail_prod($id_type_unit,$tgl){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas = ?";
		$res = $this->db->query($sql, array($id_type_unit, $tgl));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_detail_prod_range($id_type_unit,$start,$end){
		$sql = "SELECT a.no_unit, a.egi, a.type_unit, a.type, a.brand, a.owner, b.nama, d.id AS id_activity FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON a.no_unit = c.no_unit
				JOIN activity d ON a.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas 
				WHERE a.type_unit = ? AND c.tgl_aktifitas BETWEEN ? AND ?";
		$res = $this->db->query($sql, array($id_type_unit, $start,$end));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['id_activity'][] = $row->id_activity;
			$data['detail'][] = $this->get_detail_unit($row->id_activity);
		}
		return $data;
	}

	public function get_detail_fuel($id_type_unit, $tgl){
		$sql = "SELECT a.*, b.nama FROM unit a JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON c.no_unit = a.no_unit 
				WHERE c.tgl_aktifitas = ? AND a.type_unit = ?";
		$res = $this->db->query($sql, array($tgl, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;

			$sql2 = "SELECT fuel AS fuel, total_jm_opt AS total_jam 
					 FROM activity WHERE no_unit = ? AND tgl_aktifitas = ?";
			$res2 = $this->db->query($sql2, array($row->no_unit, $tgl))->result();
			$total_fuel_ratio = 0;
			foreach ($res2 as $row2){
				$fuel = $row2->fuel;
				$jam = $row2->total_jam;
				$fuel_ratio = round($fuel/$jam, 2);
				$total_fuel_ratio = $fuel_ratio;
			}
			$data['fuel_ratio'][] = round($total_fuel_ratio, 2);

		}
		return $data;
	}

	public function get_detail_fuel_range($id_type_unit, $start, $end){
		$sql = "SELECT a.*, b.nama, d.fuel AS fuel, d.total_jm_opt AS total_jam  FROM unit a 
				JOIN type_unit b ON b.id = a.type_unit 
				JOIN unit_status c ON c.no_unit = a.no_unit
				JOIN activity d ON c.no_unit = d.no_unit AND c.tgl_aktifitas = d.tgl_aktifitas
				WHERE c.tgl_aktifitas BETWEEN ? AND ? AND a.type_unit = ?";
		$res = $this->db->query($sql, array($start,$end, $id_type_unit));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['id_type_unit'][] = $row->type_unit;
			$data['type_unit'][] = $row->nama;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;

			$fuel = $row->fuel;
			$jam = $row->total_jam;
			$fuel_ratio = number_format($fuel/$jam, 2);
			$total_fuel_ratio = $fuel_ratio;
			$data['fuel_ratio'][] = number_format($total_fuel_ratio, 2);

		}
		return $data;
	}

	public function get_detail_breakdown_unit($breakdown, $tgl){
		$sql = "SELECT no_unit, egi, type, e.nama AS type_unit, brand, owner, breakdown_status,  SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(
                    SELECT d.*, a.breakdown_status, TIMEDIFF(a.end_time_1, a.start_time_1) 
                    AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, 
                    TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
                    FROM breakdown_status a JOIN activity b ON b.id = a.id_activity 
                    JOIN unit_status c ON c.no_unit = b.no_unit AND c.tgl_aktifitas = b.tgl_aktifitas
                    JOIN unit d ON b.no_unit = d.no_unit    
                    WHERE b.tgl_aktifitas = ? AND a.breakdown_status = ?
                ) AS T JOIN type_unit e ON e.id = type_unit GROUP BY no_unit";
		$res = $this->db->query($sql, array($tgl, $breakdown));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['type_unit'][] = $row->type_unit;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['breakdown_status'][] = $row->breakdown_status;
			$data['times'][] = $row->times;
		}
		return $data;
	}

	public function get_detail_breakdown_unit_range($breakdown,$start,$end){
		$sql = "SELECT no_unit, egi, type, e.nama AS type_unit, brand, owner, breakdown_status,  SEC_TO_TIME(SUM(TIME_TO_SEC(time_1)+TIME_TO_SEC(time_2)+TIME_TO_SEC(time_3)+TIME_TO_SEC(time_3))) AS times 
				FROM(
                    SELECT d.*, a.breakdown_status, TIMEDIFF(a.end_time_1, a.start_time_1) 
                    AS time_1, TIMEDIFF(a.end_time_2, a.start_time_2) AS time_2, 
                    TIMEDIFF(a.end_time_3, a.start_time_3) AS time_3, TIMEDIFF(a.end_time_4, a.start_time_4) AS time_4 
                    FROM breakdown_status a JOIN activity b ON b.id = a.id_activity 
                    JOIN unit_status c ON c.no_unit = b.no_unit AND c.tgl_aktifitas = b.tgl_aktifitas
                    JOIN unit d ON b.no_unit = d.no_unit    
                    WHERE b.tgl_aktifitas BETWEEN ? AND ? AND a.breakdown_status = ?
                ) AS T JOIN type_unit e ON e.id = type_unit";
		$res = $this->db->query($sql, array($start,$end, $breakdown));
		$data = array();
		foreach ($res->result() as $row){
			$data['no_unit'][] = $row->no_unit;
			$data['egi'][] = $row->egi;
			$data['type_unit'][] = $row->type_unit;
			$data['type'][] = $row->type;
			$data['brand'][] = $row->brand;
			$data['owner'][] = $row->owner;
			$data['breakdown_status'][] = $row->breakdown_status;
			$data['times'][] = $row->times;
		}

		if(in_array('',$data['no_unit'])){

		}else{
			return $data;
		}
	}

	public function get_data_plan($plan,$id_material,$id_type_unit,$month,$year){
		$sql = "SELECT target FROM plan 
				WHERE plan = ? AND id_material = ? AND id_type_unit = ?
				AND `month` = ? AND `year` = ?";
		$res = $this->db->query($sql,array($plan,$id_material,$id_type_unit,$month,$year))->result_array();
		$target = 0;
		if(!empty($res)){
			$day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
			$target = round($res[0]['target']/$day,2);
		}
		return $target;
	}
}
