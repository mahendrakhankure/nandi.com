<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

Class ManageMatkagames_Model extends CI_Model{

    public function getmatkagamedetails($table,$limit='',$offset='',$orderby='',$asds='',$feilds='',$con='',$result=''){
		$sql = "SELECT $feilds FROM $table";
		if($con!=''){
			$sql .= $con;
		}
		if($orderby!='' && $asds!=''){
			$sql .= " order by $orderby $asds";
		}
        if($offset>=0 && $limit!=''){
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

    
	public function num_rows($table)

	{

		$query = $this->db->select('*')->from($table)->get()->num_rows();

		return $query;

	}


	public function getmatkaratedetails($con='',$result='',$limit='',$offset=''){


		$sql = "SELECT regular_bazar_rate.id,regular_bazar_rate.rate,regular_bazar_rate.commission,regular_bazar.bazar_name,regular_game_type.game_name FROM regular_bazar_rate INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_rate.game_name";
		if($con!=''){
			$sql .= $con;
		}
		$sql .= " order by regular_bazar_rate.id desc";
        // if($offset!='' && $limit!=''){
			$sql .= " Limit $offset, $limit";
		// }
		// echo $sql;die();
        $res = $this->db->query($sql);
        if($result==''){
			$row = $res->result_array(); 
        }else{
			$row = $res->row_array(); 
        }
		return $row;
	}
	 
	public function searchData($tableName='', $con='',  $offset=0,  $record_per_page='')	{
		 
		$sql = "SELECT * FROM $tableName";
		$sql .= $con;
		 if($record_per_page != '')	{
			$sql .= " Limit $offset, $record_per_page";
		 }
        $rr = $this->db->query($sql)->result_array();
		return $rr;
	}

}