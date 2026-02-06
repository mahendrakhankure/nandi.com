<?php 

// date_default_timezone_set('Asia/Calcutta');

defined('BASEPATH') OR exit('No direct script access allowed'); 

Class ManageKingbazarallresult_Model extends CI_Model{

 

	public function getkingbazarallresultdetails($con='',$result='',$limit,$offset){


		$sql = "SELECT king_bazar_result.bazar_name,king_bazar_result.id,king_bazar_result.result,king_bazar_result.result_date,king_bazar_result.announcer,king_bazar_result.status,king_bazar.bazar_name FROM king_bazar_result INNER JOIN king_bazar ON king_bazar_result.bazar_name = king_bazar.id";
		if($con!=''){
			$sql .= $con;
		}
		$sql .= " order by king_bazar_result.id desc";
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




  //       $sql = "SELECT * FROM `king_bazar_result` ORDER BY result_date DESC Limit $offset, $limit";

  //       $sql = $this->db->query($sql);

		// $row = $sql->result_array(); 

		// return $row;

	}

    

	public function num_rows()

	{

		$query = $this->db->select('*')->from('king_bazar_result')->get()->num_rows();

		return $query;

	}  



	public function getkingbazarallGame(){

        $sql = "SELECT * FROM `king_bazar` ";

        $sql = $this->db->query($sql);

		$row = $sql->result_array(); 

		return $row;

	}

	

	//   public function getkingbazartodayresultdetails(){

	// 	$query=$this->db->select('*')

	// 	                ->where('result_date',date('Y-m-d'))

	//                 	->order_by('result_date', 'desc')

	// 	              	->get('king_bazar_result');

	// 	        return $query->result();      

	// }



    

 //     public function get_count(){

 //         return $this->db->count_all("king_bazar_result");

 //     }

    

	// public function getkingbazarallresultId($bazar,$result_dates){

	// 	$query=$this->db->select('id,bazar,result_date')

	// 	                ->where(array('bazar'=>$bazar,'result_date'=>$result_dates))

	// 			        ->get('king_bazar_result');	

	// 	     return $query->row();

	// } 

    

	// public function insertbazars($bazar,$result_dates,$result,$status){

	// $data=array(

	// 		'bazar'=>$bazar,

	// 		'result_date'=>$result_dates,

	// 		'result'=>$result,

	// 		'status'=>$status

	// 	);

	// $sql_query=$this->db->insert('king_bazar_result',$data);

	// }

	

	

	// public function deletekingbazarallresult($gid){

	// 	$sql_query=$this->db->where('id', $gid)

 //                ->delete('king_bazar_result');

 //    }

	

	// public function updateuser($id,$result){

	// $data=array(

	// 		'result'=>$result

	// 	);

	// $sql_query=$this->db->update('king_bazar_result',$data,'id='.$id);

	// }

	

	// public function getmatkaallresultId($game_name){

	// 	$query=$this->db->select('id,game_name')

	// 	                ->where('game_name',$game_name)

	// 			        ->get('king_bazar_result');	

	// 	     return $query->row();

	// }



}