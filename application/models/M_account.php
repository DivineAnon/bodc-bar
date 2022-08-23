<?php
class M_account extends CI_Model{

	function sign_in_process($data){
		$sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
		$res = $this->db->query($sql, $data);
		return $res->result_array();
	}
}
