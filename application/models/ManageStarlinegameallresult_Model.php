<?php

Class ManageStarlinegameallresult_Model extends CI_Model{

  

	public function getstarlinegameallresultdetails($con='',$result='',$limit,$offset){
		$sql = "SELECT starline_bazar_time.time,starline_bazar.bazar_name,starline_bazar_result.id,starline_bazar_result.result_date,starline_bazar_result.announcer,starline_bazar_result.result_patti,starline_bazar_result.result_akda FROM starline_bazar_result INNER JOIN starline_bazar ON starline_bazar_result.bazar_name = starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_result.time = starline_bazar_time.id ";
		if($con!=''){
			$sql .= $con;
		}
		$sql .= " ORDER BY starline_bazar_result.result_date DESC";
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

    

	public function num_rows()
	{
		$query = $this->db->select('*')->from('regular_bazar_result')->get()->num_rows();
		return $query;
	} 



	public function getStarLineGame(){

        $sql = "SELECT * FROM `starline_bazar` ";

        $sql = $this->db->query($sql);

		$row = $sql->result_array(); 

		return $row;

	}


	public function getStarLineTime($con=''){

        $sql = "SELECT time,id FROM `starline_bazar_time` ";
        if($con!=''){
        	$sql .= $con;
        }
        $res = $this->db->query($sql);

		$row = $res->result_array(); 

		return $row;

	}



// 	  public function getstarlinetodayresultdetails(){

// 		$query=$this->db->select('*')

// 		                ->where('result_date',date('Y-m-d'))

// 	                	->order_by('result_date', 'desc')

// 		              	->get('starline_games_result');

// 		        return $query->result();

// 	}





//      public function get_count(){

//          return $this->db->count_all("starline_games_result");

//      }



// 	public function getstarlinegameallresultdetail($rid){

// 		$query=$this->db->select('*')

//  	              ->where('id',$rid)

//  	              ->get('starline_games_result');

//  	              return $query->row();

// 	}



// 	public function insertbazars($game,$result_dates){

// 	$data=array(

// 			'game'=>$game,

// 			'result_date'=>$result_dates

// 		);

// 	$sql_query=$this->db->insert('starline_games_result',$data);

//   $insert_id = $this->db->insert_id();

// 	return $insert_id;

//      // $this->db->insert_batch('starline_games_result', $data);

// 	}



//   public function insertstarlinebazarresult($id, $key ,$result){

//     $data=array(

//        $key=>$result

//      );

// 	//$sql_query=$this->db->insert('starline_games_result',$data);

//    $sql_query=$this->db->update('starline_games_result',$data,'id='.$id);

// 	}





// 	public function deletestarlinegameallresult($gid){

// 		$sql_query=$this->db->where('id', $gid)

//                 ->delete('starline_games_result');

//     }



// 	// public function updateuser($id,$result){

// 	// $data=array(

// 	// 		'result'=>$result

// 	// 	);

// 	// $sql_query=$this->db->update('starline_games_result',$data,'id='.$id);

// 	// }



//   public function updatestarlinegame($id,$game){

// $data=array(

//         'game'=>$game

//   );

//     $sql_query=$this->db->update('starline_games_result',$data,'id='.$id);

// }



// 	public function getstarlinegameallresultId($game,$result_date){

// 		$query=$this->db->select('id,game,result_date')

// 		                ->where(array('game'=>$game,'result_date'=>$result_date))

// 				        ->get('starline_games_result');

// 		     return $query->row();

// 	}



}

