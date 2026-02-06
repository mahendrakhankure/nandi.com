<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Client_Model extends CI_Model {

	public function getData($table,$con='',$feild='',$limit='',$offset='',$result='',$orderby='',$groupby=''){
		if($table!='Admin'){
			$sql = "SELECT * FROM $table";
			if($feild!=''){
				$sql = "SELECT $feild FROM $table";
			}
			if($con!=''){
				$sql .= $con;
			}
			if($orderby!=''){
				$sql .= " order by ".$orderby;
			}
			if($groupby!=''){
				$sql .= " group by ".$groupby;
			}
	        if($offset!='' && $limit!=''){
				$sql .= " Limit $offset, $limit";
			}
			// echo $sql;die();
	        $res = $this->db->query($sql);
	        if($result==''){
				$row = $res->result_array(); 
	        }else{
				$row = $res->row_array(); 
	        }
			return $row;
		}
	}

}


