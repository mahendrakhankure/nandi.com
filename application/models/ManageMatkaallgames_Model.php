

<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 

Class ManageMatkaallgames_Model extends CI_Model{



    public function getmatkaallgamedetails($limit,$offset){
		$sql = "SELECT * FROM game_result ORDER BY id DESC Limit $offset, $limit";
        $sql = $this->db->query($sql);
		$row = $sql->result_array(); 
		return $row;
	}

	public function getMatkaResult($con='',$result='', $offset='', $limit=''){
		$sql = "SELECT regular_bazar.bazar_name,regular_bazar_result.id,regular_bazar_result.result_date,regular_bazar_result.open,regular_bazar_result.jodi,regular_bazar_result.close,regular_bazar_result.announcer FROM regular_bazar_result INNER JOIN regular_bazar ON regular_bazar_result.bazar_name = regular_bazar.id ";
		if($con!=''){
			$sql .= $con;
		}
		$sql .= " order by regular_bazar_result.id desc";
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

	public function num_rows($table)

	{

		$query = $this->db->select('*')->from($table)->get()->num_rows();

		return $query;

	}

	

	public function getmatkagameallGame(){

        $sql = "SELECT * FROM `regular_bazar` ";

        $sql = $this->db->query($sql);

		$row = $sql->result_array(); 

		return $row;

	}

    

	// public function insertgame($games,$starttime,$endtime,$count,$priority,$result){

	// $data=array(

	// 		'games'=>$games,

	// 		'start_time'=>$starttime,

	// 		'end_time'=>$endtime,

	// 		'count'=>$count,

	// 		'priority'=>$priority,

	// 		'result'=>$result

	// 	);

	// $sql_query=$this->db->insert('matkagames',$data);

	// }

	

	// public function getmatkagamedetail($gid){

	// 	$query=$this->db->select('games,start_time,end_time,count,priority,result,status')

 // 	              ->where('id',$gid)

 // 	              ->get('matkagames');

 // 	              return $query->row();

	// }

	

	// public function deletematkagame($gid){

	// 	$sql_query=$this->db->where('id', $gid)

 //                ->delete('matkagames');

 //    }

	

	// public function updateuser($id,$games,$starttime,$endtime,$count,$priority,$result,$status){

	// $data=array(

	//        	'games'=>$games,

	// 		'start_time'=>$starttime,

	// 		'end_time'=>$endtime,

	// 		'count'=>$count,

	// 		'priority'=>$priority,

	// 		'result'=>$result,

	// 		'status'=>$status

	// 	);

	// $sql_query=$this->db->update('matkagames',$data,'id='.$id);

	// }

	

	// public function getmatkagameId($game){

	// 	$query=$this->db->select('id,games')

	// 	                ->where('games',$game)

	// 			        ->get('matkagames');	

	// 	     return $query->row();

	// } 



}