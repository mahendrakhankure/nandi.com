<?php
	// require APPPATH . '/helpers/MCrypt.php';

	Class ManageVideos_Model extends CI_Model {
		function videoList($postData=null){
			$response = array();
		      ## Read value
		      $draw = $postData['draw'];
		      $start = $postData['start'];
		      $rowperpage = $postData['length']; // Rows display per page
		      $columnIndex = $postData['order'][0]['column']; // Column index
		      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
		      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		      $searchValue = $postData['search']['value']; // Search value

		      // Custom search filter 
		      $id = $postData['id'];
		      $status = $postData['status'];
		      $patti = $postData['patti'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $search_arr[] = " status='".$status."' ";
		      }
		      if($patti != ''){
		          $search_arr[] = " patti='".$patti."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('dealerVideos')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('dealerVideos')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM dealerVideos";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      foreach($records as $record){
		          $data[] = array( 
		              "id"=>$record['id'],
		              "patti"=>$record['patti'],
		              "dealer"=>$record['dealer'],
		              "updated"=>$record['updated'],
		              "status"=>$record['status']
		          ); 
		      }

		      ## Response
		      $response = array(
		          "draw" => intval($draw),
		          "iTotalRecords" => $totalRecords,
		          "iTotalDisplayRecords" => $totalRecordwithFilter,
		          "aaData" => $data
		      );

		      return $response;  
		}
    }
?>