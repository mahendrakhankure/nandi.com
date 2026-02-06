<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

Class ManageKingbazar_Model extends CI_Model{

	public function getkingbazardetails(){

        $sql = "SELECT * FROM king_bazar";

        $sql = $this->db->query($sql);

		$row = $sql->result_array(); 

		return $row;

	}

	public function getbazarbhav($limit='',$offset='',$con='',$result=''){

		$sql = "SELECT king_bazar.bazar_name,king_bazar_rate.rate,king_bazar_rate.id,king_bazar_rate.status,king_bazar_rate.game_type FROM king_bazar_rate INNER JOIN king_bazar ON  king_bazar_rate.bazar_name = king_bazar.id";
		if($con!=''){
			$sql .= $con;
		}
		if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		}
		$sql .= " order by king_bazar_rate.id desc";
		$res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}

}