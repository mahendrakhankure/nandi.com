<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

Class ManageStarlinegames_Model extends CI_Model{



    public function getstarlinegame($con='',$result=''){
		$sql = "SELECT starline_bazar_time.time,starline_bazar_time.id,starline_bazar.bazar_name, starline_bazar.id as bazar_id FROM starline_bazar_time INNER JOIN starline_bazar ON  starline_bazar_time.bazar_name = starline_bazar.id ";
		if($con!=''){
			$sql .= $con;
		}
		$sql .= " order by time desc";
        $res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}

	public function getstarlinetime($limit='',$offset='',$con,$result){
		$sql = "SELECT starline_bazar_time.time,starline_bazar_time.id,starline_bazar_time.status,starline_bazar.bazar_name FROM starline_bazar_time INNER JOIN starline_bazar ON  starline_bazar_time.bazar_name = starline_bazar.id ";
		if($con!=''){
			$sql .= $con;
		}
		if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		}
		$sql .= " order by time desc";
        $res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}

	public function getstarlinebhav($limit='',$offset='',$con='',$result=''){

		$sql = "SELECT starline_bhav.rate,starline_bazar.bazar_name,starline_game_type.game_name,starline_bhav.id FROM starline_bhav INNER JOIN starline_bazar ON  starline_bazar.id = starline_bhav.bazar_name INNER JOIN starline_game_type ON  starline_bhav.game_name = starline_game_type.id";
		if($con!=''){
			$sql .= $con;
		}
		if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		}
		$sql .= " order by starline_bhav.id desc";
		$res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}

	public function getstarlinegametype($limit='',$offset='',$con='',$result=''){

		$sql = "SELECT starline_bazar.bazar_name,starline_game_type.game_name,starline_game_type.id,starline_game_type.priority,starline_game_type.status FROM starline_game_type INNER JOIN starline_bazar ON  starline_game_type.bazar_name = starline_bazar.id";
		if($con!=''){
			$sql .= $con;
		}
		if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		}
		$sql .= " order by starline_game_type.id desc";
		$res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}

	public function getstarlinedetails($table,$limit='',$offset='',$orderby='',$asds='',$feilds='',$con='',$result=''){

		$sql = "SELECT $feilds FROM $table";
        if($con!=''){
			$sql .= $con;
		}
		$sql .= " order by $orderby $asds";
        if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		}
        $res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;

	}
    

}