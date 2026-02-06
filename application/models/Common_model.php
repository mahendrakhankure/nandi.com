<?php
	// require APPPATH . '/helpers/MCrypt.php';

	Class Common_model extends CI_Model {
		public function getData($table,$con='',$feild='',$limit='',$offset='',$result='',$orderby='',$groupby=''){
			$sql = "SELECT * FROM $table";
			if($feild!=''){
				$sql = "SELECT $feild FROM $table";
			}
			if($con!=''){
				$sql .= $con;
			}
			if($groupby!=''){
				$sql .= " group by ".$groupby;
			}
			if($orderby!=''){
				$sql .= " order by ".$orderby;
			}
			
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

		// public function getDataTest($table,$con='',$feild='',$limit='', $offset='', $result='',$orderby='',$groupby=''){
		// 	$sql = "SELECT * FROM $table";
		// 	if($feild!=''){
		// 		$sql = "SELECT $feild FROM $table";
		// 	}
		// 	if($con!=''){
		// 		$sql .= $con;
		// 	}
		// 	if($groupby!=''){
		// 		$sql .= " group by ".$groupby;
		// 	}
		// 	if($orderby!=''){
		// 		$sql .= " order by ".$orderby;
		// 	}
			
	    //     if($offset!='' && $limit!=''){
		// 		$sql .= " Limit $offset, $limit";
		// 	} 
			 
	    //     $res = $this->db->query($sql);
	    //     if($result==''){
		// 		$row = $res->result_array(); 
	    //     }else{
		// 		$row = $res->row_array(); 
	    //     }
			 
		// 	return $row;
		// }

		public function getDataForTest($table,$con='',$feild='',$limit='',$offset='',$result='',$orderby='',$groupby=''){
			$sql = "SELECT * FROM $table";
			
			if($feild!=''){
				$sql = "SELECT $feild FROM $table";
			}
			if($con!=''){
				$sql .= $con;
			}
			
			if($groupby!=''){
				$sql .= " group by ".$groupby;
			}
			if($orderby!=''){
				$sql .= " order by ".$orderby;
			}
	        if($offset!='' && $limit!=''){
				$sql .= " Limit $offset, $limit";
			}
			
			// echo $sql;
			// die();
	        $res = $this->db->query($sql);
			// echo '<pre>';
			// print_r($res);
			// die();
	        if($result==''){
				if($res !== FALSE && $res->num_rows() > 0){
					$row = $res->result_array();
				}else{
					$row = [];
				} 
	        }else{
				if($res !== FALSE && $res->num_rows() > 0){
					$row = $res->row_array(); 
				}else{
					$row = [];
				}
	        }
			return $row;
		}

		function getRegularData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];
		      $result_date = $postData['result_date'];
		      $to_date = $postData['to_date'];
		      $type = $postData['type'];
		      $game = $postData['game'];
		      $status = $postData['status'];
		      $risk = $postData['risk'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (regular_bazar_games. like '%".$searchValue."%' or 
		                regular_bazar_games. like '%".$searchValue."%' or 
		                regular_bazar_games. like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " regular_bazar_games.transaction_id='".$transaction_id."' ";
		      }
		      if($risk != ''){
		          $search_arr[] = " regular_bazar_games.point>'".$risk."' ";
		      }
		      if($partner_id != ''){
		      	  $search_arr[] = " regular_bazar_games.partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		      	  if($partner_id=='2'){
		      	  	$iv = '8368871eeb9b975b';
					$td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
					mcrypt_generic_init($td, 'cd075230fea33f24', $iv);
					$encrypted = mcrypt_generic($td, $customer_id);
					mcrypt_generic_deinit($td);
	  				mcrypt_module_close($td);

		          	$search_arr[] = " regular_bazar_games.customer_id='".bin2hex($encrypted)."' ";
		      	  }else{
		          	$search_arr[] = " regular_bazar_games.customer_id like '%".$customer_id."%' ";
		      	  }
		          	
		      }
		      if($game != ''){
		      	  $search_arr[] = " regular_bazar_games.game='".$game."' ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " regular_bazar_games.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " regular_bazar_games.game_name='".$game_name."' ";
		      }
		      if($to_date != ''){
		          $search_arr[] = " regular_bazar_games.result_date BETWEEN '".$result_date."' AND '".$to_date."' ";
		      }else if($result_date != ''){
				  $date = explode(' - ', $result_date);
				  $search_arr[] = " regular_bazar_games.result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		        //   $search_arr[] = " regular_bazar_games.result_date='".$result_date."' ";
		      }
		      if($type != ''){
		          $search_arr[] = " regular_bazar_games.game_type='".$type."' ";
		      }
		      if($status != ''){
		          $search_arr[] = " regular_bazar_games.status='".$status."' ";
		      }
			  
		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('regular_bazar_games')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_bazar_games')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'regular_bazar_games.point_in_rs,regular_bazar_games.winning_in_rs,regular_bazar_games.currency_code,regular_bazar_games.exchange_rate,regular_bazar_games.created,regular_bazar_games.point,regular_bazar_games.commission,regular_bazar_games.winning_point,regular_bazar_games.status,regular_bazar_games.game,regular_bazar_games.game_type,regular_bazar_games.result_date,regular_bazar_games.transaction_id,regular_bazar_games.partner_id,regular_bazar_games.customer_id,regular_bazar.bazar_name,regular_bazar_games.bazar_name as bazar_id,regular_game_type.game_name,regular_bazar_games.game_name as game_id';

			  $sql = "SELECT ".$feilds." FROM regular_bazar_games";
			  $sql .= " INNER JOIN regular_bazar ON regular_bazar_games.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_games.game_name = regular_game_type.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      $sr = $postData['start']+1;

			  $prt = "SELECT id,client_name FROM client";
			  $resPrt = $this->db->query($prt);
			  $resPrt1 = $resPrt->result_array();
			 
			  $nR = [];
			  foreach($resPrt1 as $pR){
				$nR[$pR['id']] = $pR['client_name'];
			  }
			
		      foreach($records as $record ){
			      if($record['partner_id']=='2'){
			      	$code = '';
					for ($i = 0; $i < strlen($record['customer_id']); $i += 2) {
						$code .= chr(hexdec(substr($record['customer_id'], $i, 2)));
					}
					$iv = '8368871eeb9b975b';
					$td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
					mcrypt_generic_init($td, 'cd075230fea33f24', $iv);
					$decrypted = mdecrypt_generic($td, $code);
					mcrypt_generic_deinit($td);
					mcrypt_module_close($td);
        	  		$newId = utf8_encode(trim($decrypted));
			      }else{
        	  		$newId = $record['customer_id'];
			      }

		          $data[] = array( 
		              "sr"=>$sr,
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$record['partner_id'],
					  "partner_name"=>$nR[$record['partner_id']],
		              // "customer_id"=>$record['customer_id'],
		              "customer_id"=>$newId,
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$record['game_name'],
		              "commission"=>$record['commission'],
		              "winning_in_rs"=>$record['winning_in_rs'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "game_type"=>$record['game_type'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "created"=>$record['created'],
		              "point_in_rs"=>$record['point_in_rs'],
		              "winning_point"=>$record['winning_point'],
		              "currency_code"=>$record['currency_code'],
		              "exchange_rate"=>$record['exchange_rate']
		          ); 
		          $sr++;
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

	  	function getStarlineData($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];
		      $game_time = $postData['game_time'];
		      $result_date = $postData['result_date'];
		      $to_date = $postData['to_date'];
		      $game = $postData['game'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (starline_bazar_game.transaction_id like '%".$searchValue."%' or 
		                starline_bazar_game.partner_id like '%".$searchValue."%' or 
		                starline_bazar_game.customer_id like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " starline_bazar_game.transaction_id='".$transaction_id."' ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " starline_bazar_game.partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " starline_bazar_game.customer_id like '%".$customer_id."%' ";
		      }

		      if($bazar_name != ''){
		          $search_arr[] = " starline_bazar_game.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " starline_bazar_game.game_name='".$game_name."' ";
		      }
		      if($game_time != ''){
		          $search_arr[] = " starline_bazar_game.time='".$game_time."' ";
		      }
		      if($to_date != ''){
		          $search_arr[] = " starline_bazar_game.result_date BETWEEN '".$result_date."' AND '".$to_date."' ";
		      }else if($result_date != ''){
				$date = explode(' - ', $result_date);
				$search_arr[] = " starline_bazar_game.result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		        //   $search_arr[] = " starline_bazar_game.result_date='".$result_date."' ";
		      }
		      if($game != ''){
		          $search_arr[] = " starline_bazar_game.game='".$game."' ";
		      }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(*) as allcount');
		      $records = $this->db->get('starline_bazar_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(*) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bazar_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'starline_bazar_game.currency_code,starline_bazar_game.exchange_rate,starline_bazar_game.created,starline_bazar_game.point,starline_bazar_game.point_in_rs,starline_bazar_game.commission,starline_bazar_game.winning_point,starline_bazar_game.winning_in_rs,starline_bazar_game.status,starline_bazar_game.game,starline_game_type.game_name,starline_bazar_game.game_name as game_id,starline_bazar_game.result_date,starline_bazar_game.transaction_id,starline_bazar_game.partner_id,starline_bazar_game.customer_id,starline_bazar.bazar_name,starline_bazar_game.bazar_name as bazar_id,starline_game_type.game_name,starline_bazar_game.game_name as game_id,starline_bazar_time.time';

			  $sql = "SELECT ".$feilds." FROM starline_bazar_game";
			  $sql .= " INNER JOIN starline_bazar ON starline_bazar_game.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON starline_bazar_game.game_name = starline_game_type.id INNER JOIN starline_bazar_time ON starline_bazar_game.time = starline_bazar_time.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

		      $res = $this->db->query($sql);
			  $records = $res->result_array();

			  $prt = "SELECT id,client_name FROM client";
			  $resPrt = $this->db->query($prt);
			  $resPrt1 = $resPrt->result_array();
			 
			  $nR = [];
			  foreach($resPrt1 as $pR){
				$nR[$pR['id']] = $pR['client_name'];
			  }


		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record ){
		          $data[] = array( 
		              "sr"=>$sr,
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$record['partner_id'],
					  "partner_name"=>$nR[$record['partner_id']],
		              "customer_id"=>$record['customer_id'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$record['game_name'],
		              "time"=>$record['time'],
		              "commission"=>$record['commission'],
		              "winning_point"=>$record['winning_point'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "time"=>$record['time'],
		              "created"=>$record['created'],
		              "point_in_rs"=>$record['point_in_rs'],
		              "winning_in_rs"=>$record['winning_in_rs'],
		              "currency_code"=>$record['currency_code'],
		              "exchange_rate"=>$record['exchange_rate']
		          ); 
		          $sr++;
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

	  	function getKingData($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];
		      $result_date = $postData['result_date'];
		      $to_date = $postData['to_date'];
		      $game = $postData['game'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (king_bazar_game.transaction_id like '%".$searchValue."%' or 
		                king_bazar_game.partner_id like '%".$searchValue."%' or 
		                king_bazar_game.customer_id like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " king_bazar_game.transaction_id='".$transaction_id."' ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " king_bazar_game.partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " king_bazar_game.customer_id like '%".$customer_id."%' ";
		      }

		      if($bazar_name != ''){
		          $search_arr[] = " king_bazar_game.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " king_bazar_game.game_name='".$game_name."' ";
		      }
		      if($to_date != ''){
		          $search_arr[] = " king_bazar_game.result_date BETWEEN '".$result_date."' AND '".$to_date."' ";
		      }else if($result_date != ''){
				$date = explode(' - ', $result_date);
				$search_arr[] = " king_bazar_game.result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		        //   $search_arr[] = " king_bazar_game.result_date='".date("Y-m-d", strtotime($result_date))."' ";
		      }
		      if($game != ''){
		          $search_arr[] = " king_bazar_game.game='".$game."' ";
		      }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('king_bazar_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('king_bazar_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'king_bazar_game.exchange_rate,king_bazar_game.currency_code,king_bazar_game.point_in_rs,king_bazar_game.winning_in_rs,king_bazar_game.created,king_bazar_game.game_name,king_bazar_game.point,king_bazar_game.commission,king_bazar_game.winning_point,king_bazar_game.status,king_bazar_game.game,king_bazar_game.result_date,king_bazar_game.transaction_id,king_bazar_game.partner_id,king_bazar_game.customer_id,king_bazar.bazar_name,king_bazar_game.bazar_name as bazar_id';
			  
			  $sql = "SELECT ".$feilds." FROM king_bazar_game";
			  $sql .= " INNER JOIN king_bazar ON king_bazar_game.bazar_name = king_bazar.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;

			  $prt = "SELECT id,client_name FROM client";
			  $resPrt = $this->db->query($prt);
			  $resPrt1 = $resPrt->result_array();
			 
			  $nR = [];
			  foreach($resPrt1 as $pR){
				$nR[$pR['id']] = $pR['client_name'];
			  }

		      foreach($records as $record){
		         	if($record['game_name']==1){
		         		$game_name = 'FIRST DIGIT(EKAI)';
		         	}else if($record['game_name']==2){
		         		$game_name = 'FIRST DIGIT(HARUF)';
		         	}else{
		         		$game_name = 'JODI';
		         	}
		          $data[] = array( 
		              "sr"=>$sr,
		              "transaction_id"=>$record['transaction_id'],
					  "partner_name"=>$nR[$record['partner_id']],
		              "partner_id"=>$record['partner_id'],
		              "customer_id"=>$record['customer_id'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$game_name,
		              "commission"=>$record['commission'],
		              "winning_point"=>$record['winning_point'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "created"=>$record['created'],
		              "point_in_rs"=>$record['point_in_rs'],
		              "winning_in_rs"=>$record['winning_in_rs'],
		              "currency_code"=>$record['currency_code'],
		              "exchange_rate"=>$record['exchange_rate']
		          ); 
		          $sr++;
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

	  	function getWorliData($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $game_name = $postData['game_name'];
		      $result_date = $postData['result_date'];
		      $round_id = $postData['round_id'];
			  $status = $postData['status'];
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (transaction_id like '%".$searchValue."%' or 
		                partner_id like '%".$searchValue."%' or 
		                customer_id like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " transaction_id='".$transaction_id."' ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_id like '%".$customer_id."%' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }
		      if($result_date != ''){
		          $search_arr[] = " result_date='".$result_date."' ";
		      }
		      if($round_id != ''){
		          $search_arr[] = " round_id='".$round_id."' ";
		      }
			  if($status != ''){
				$search_arr[] = " status='".$status."' ";
			  }
			  
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('warli_users_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('warli_users_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'point_in_rs,winning_in_rs,currency_code,exchange_rate,created,game_name,point,commission,winning_point,status,game,result_date,transaction_id,partner_id,customer_id,round_id';

			  $sql = "SELECT ".$feilds." FROM warli_users_game";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		         	if($record['game_name']==1){
		         		$game_name = 'FIRST DIGIT(EKAI)';
		         	}else if($record['game_name']==2){
		         		$game_name = 'FIRST DIGIT(HARUF)';
		         	}else{
		         		$game_name = 'JODI';
		         	}
		          $data[] = array( 
		              "sr"=>$sr,
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$record['partner_id'],
		              "customer_id"=>$record['customer_id'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$game_name,
		              "commission"=>$record['commission'],
		              "winning_point"=>$record['winning_point'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "created"=>$record['created'],
		              "round_id"=>$record['round_id'],
		              "point_in_rs"=>$record['point_in_rs'], 
		              "winning_in_rs"=>$record['winning_in_rs'],
		              "currency_code"=>$record['currency_code'],
		              "exchange_rate"=>$record['exchange_rate']
		          ); 
		          $sr++;
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
	  	function getRedTableData($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $game_name = $postData['game_name'];
		      $result_date = $postData['result_date'];
		      $round_id = $postData['round_id'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (transaction_id like '%".$searchValue."%' or 
		                partner_id like '%".$searchValue."%' or 
		                customer_id like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " transaction_id='".$transaction_id."' ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_id like '%".$customer_id."%' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }
		      if($result_date != ''){
		          $search_arr[] = " result_date='".$result_date."' ";
		      }
		      if($round_id != ''){
		          $search_arr[] = " round_id='".$round_id."' ";
		      }
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('redTable_users_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('redTable_users_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'round_id,created,game_name,point,commission,winning_point,status,game,result_date,transaction_id,partner_id,customer_id';

			  $sql = "SELECT ".$feilds." FROM redTable_users_game";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		         	if($record['game_name']==1){
		         		$game_name = 'FIRST DIGIT(EKAI)';
		         	}else if($record['game_name']==2){
		         		$game_name = 'FIRST DIGIT(HARUF)';
		         	}else{
		         		$game_name = 'JODI';
		         	}
		          $data[] = array( 
		              "sr"=>$sr,
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$record['partner_id'],
		              "customer_id"=>$record['customer_id'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$game_name,
		              "commission"=>$record['commission'],
		              "winning_point"=>$record['winning_point'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "created"=>$record['created'],
					  "round_id"=>$record['round_id'],
		          ); 
		          $sr++;
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
	  	function getGoldenTableData($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $game_name = $postData['game_name'];
		      $result_date = $postData['result_date'];
		      $round_id = $postData['round_id'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (transaction_id like '%".$searchValue."%' or 
		                partner_id like '%".$searchValue."%' or 
		                customer_id like'%".$searchValue."%' ) ";
		      }
		      if($transaction_id != ''){
		          $search_arr[] = " transaction_id='".$transaction_id."' ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_id like '%".$customer_id."%' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }
		      if($result_date != ''){
		          $search_arr[] = " result_date='".$result_date."' ";
		      }
		      if($round_id != ''){
		          $search_arr[] = " round_id='".$round_id."' ";
		      }
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('goldenTable_users_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('goldenTable_users_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'created,game_name,point,commission,winning_point,status,game,result_date,transaction_id,partner_id,customer_id';

			  $sql = "SELECT ".$feilds." FROM goldenTable_users_game";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();

		      foreach($records as $record){
		         	if($record['game_name']==1){
		         		$game_name = 'FIRST DIGIT(EKAI)';
		         	}else if($record['game_name']==2){
		         		$game_name = 'FIRST DIGIT(HARUF)';
		         	}else{
		         		$game_name = 'JODI';
		         	}
		          $data[] = array( 
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$record['partner_id'],
		              "customer_id"=>$record['customer_id'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$game_name,
		              "commission"=>$record['commission'],
		              "winning_point"=>$record['winning_point'],
		              "status"=>$record['status'],
		              "game"=>$record['game'],
		              "result_date"=>$record['result_date'],
		              "point"=>$record['point'],
		              "created"=>$record['created'],
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

	  	function getRegularDataResult($postData=null){

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
		      $transaction_id = $postData['transaction_id'];
		      $status = $postData['status'];
		      $bazarDate = $postData['bazarDate'];
		      $bazar_name = $postData['bazar_name'];
		      $token_open = $postData['token_open'];
		      $token_close = $postData['token_close'];
		      $result_date = $postData['result_date'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";

		      if($status != ''){
		          $search_arr[] = " regular_bazar_result.status='".$status."' ";
		      }

			  if($bazarDate != ''){
		          	$search_arr[] = " regular_bazar_result.result_date='".$bazarDate."' ";
		      }else{
		      		$search_arr[] = " regular_bazar_result.result_date <= '".date('Y-m-d')."' ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " regular_bazar_result.bazar_name='".$bazar_name."' ";
		      }

		      if($token_open != ''){
		          $search_arr[] = " regular_bazar_result.token_open='".$token_open."' ";
		      }
		      if($token_close != ''){
		          $search_arr[] = " regular_bazar_result.token_close='".$token_close."' ";
		      }

		      if($result_date != ''){
		          $search_arr[] = " regular_bazar_result.result_date='".$result_date."' ";
		      }
		      // $search_arr[] = " regular_bazar_result.status='A' and regular_bazar_result.open!='' ";
		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('regular_bazar_result')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_bazar_result')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'regular_bazar_result.id,regular_bazar_result.created,regular_bazar_result.open,regular_bazar_result.jodi,regular_bazar_result.close,regular_bazar_result.status,regular_bazar_result.result_date,regular_bazar.bazar_name,regular_bazar_result.bazar_name as bazar_id,regular_bazar_result.token_open,regular_bazar_result.token_close';

			  $sql = "SELECT ".$feilds." FROM regular_bazar_result";
			  $sql .= " INNER JOIN regular_bazar ON regular_bazar_result.bazar_name = regular_bazar.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record ){
					if($record['status']=='A'){
						$o = getWinnersOpen($record['id']);
						if(!empty($record['close'])){
							$c = getWinnersClose($record['id']);
						}else{
							$c = '';
						}
					}else{
						$o = '';
		      			$c = '';
					}
		      		
		      		$oPeN = '';
		      		$cLoSe = '';
		      		// echo $c;die();
		      		if(empty($o) && !empty($record['open'])){
		      			$con = ' WHERE bazar_name="'.$record['bazar_id'].'" AND result_date="'.$record['result_date'].'" AND status="P" AND game_type="Open"';
		      			$oP = $this->getData('regular_bazar_games',$con,'id','','','','','');
		      			if($oP){
			      			$o=array_column($oP, 'id');
			      			$oPeN = "<span id='".$record['id']."' class='btn btn-info' onclick='updatePending(".json_encode($o).','.$record['id'].",0)'>".count($o)."</span>";
		      			}
		      		}else if(!empty($o) && !empty($record['open'])){
		      			$oPeN = "<span id='".$record['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($o).','.$record['id'].")'>".count($o)."</span>";
		      		}
		      		if(empty($c) && !empty($record['close'])){
		      			$con = ' WHERE bazar_name="'.$record['bazar_id'].'" AND result_date="'.$record['result_date'].'" AND status="P" AND game_type!="Open"';
		      			$cP = $this->getData('regular_bazar_games',$con,'id','','','','','');
		      			if($cP){
			      			$c=array_column($cP, 'id');
			      			$cLoSe = "<span class='btn btn-info ".$record['id']."' onclick='updatePending(".json_encode($c).','.$record['id'].",1)'>".count($c)."</span>";
		      			}
		      		}else if(!empty($c) && !empty($record['close'])){
		      			$cLoSe = "<span id='".$record['id'].$record['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($c).','.$record['id'].$record['id'].")'>".count($c)."</span>";
		      		}
		          $data[] = array( 
		              "sr"=>$sr,
		              "token_open"=>$record['token_open'],
		              "token_close"=>$record['token_close'],
		              "id"=>$record['id'],
		              "bazar_name"=>$record['bazar_name'],
		              "open"=>$record['open'],
		              "jodi"=>$record['jodi'],
		              "close"=>$record['close'],
		              "result_date"=>$record['result_date'],
		              "status"=>$record['status'],
		              "openWin"=>$oPeN,
		              "closeWin"=>$cLoSe
		          );
		          $sr++; 
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

	  	function getKingDataResult($postData=null){

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
		      $bazarDate = $postData['bazarDate'];
		      $bazar_name = $postData['bazar_name'];
		      $status = $postData['status'];
		      $token = $postData['token'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";

		      if($bazar_name != ''){
		          $search_arr[] = " king_bazar_result.bazar_name='".$bazar_name."' ";
		      }
		      if($bazarDate != ''){
		          $search_arr[] = " king_bazar_result.result_date='".$bazarDate."' ";
		      }else{
		      		$search_arr[] = " king_bazar_result.result_date <= '".date('Y-m-d')."' ";
		      }
		      if($status != ''){
		          $search_arr[] = " king_bazar_result.status='".$status."' ";
		      }
		      if($token != ''){
		          $search_arr[] = " king_bazar_result.token='".$token."' ";
		      }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('king_bazar_result')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('king_bazar_result')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'king_bazar_result.created,king_bazar_result.status,king_bazar_result.result_date,king_bazar_result.result,king_bazar.bazar_name,king_bazar.id as bazar_id,king_bazar_result.id as result_id,king_bazar_result.token';

			  $sql = "SELECT ".$feilds." FROM king_bazar_result";
			  $sql .= " INNER JOIN king_bazar ON king_bazar_result.bazar_name = king_bazar.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		         	if($record['game_name']==1){
		         		$game_name = 'FIRST DIGIT(EKAI)';
		         	}else if($record['game_name']==2){
		         		$game_name = 'FIRST DIGIT(HARUF)';
		         	}else{
		         		$game_name = 'JODI';
		         	}
		         	 
		         	$o = getWinnersKing($record['result_id']);
		         	if(empty($o)){
		         		$op = checkPending('king_bazar_game',$record['bazar_id'],$record['result_date'],'');
		         		if(!empty($op)){
		         			$o=array_column($op, 'id');
		         			$win = 	"<span id='".$record['result_id']."' class='btn btn-info' onclick='updateLoseBet(".'"king_bazar_game"'.",".json_encode($o).",".$record['result_id'].")'>".count($o)."</span>";
		         		}else{
		         			$win = "";
		         		}
		         	}else{
		         		$win = 	"<span id='".$record['result_id']."' class='btn btn-success' onclick='updateWalletKing(".json_encode($o).','.$record['result_id'].")'>".count($o)."</span>";
		         	}
		          $data[] = array( 
		              "id"=>$record['result_id'],
		              "sr"=>$sr,
		              "token"=>$record['token'],
		              "bazar_name"=>$record['bazar_name'],
		              "bazar_id"=>$record['bazar_id'],
		              "result_id"=>$record['result_id'],
		              "result"=>$record['result'],
		              "status"=>$record['status'],
		              "result_date"=>$record['result_date'],
		              "created"=>$record['created'],
		              "openWin"=>$win
		          ); 
		          $sr++;
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

	  	function getStarlineDataResult($postData=null){

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
		      $bazar_name = $postData['bazar_name'];
		      $bazarDate = $postData['bazarDate'];
		      $game_time = $postData['game_time'];
		      $token = $postData['token'];
		      $result_date = $postData['result_date'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($bazar_name != ''){
		          $search_arr[] = " starline_bazar_result.bazar_name='".$bazar_name."' ";
		      }
		      if($bazarDate != ''){
		          $search_arr[] = " starline_bazar_result.result_date='".$bazarDate."' ";
		      }else{
		      		$search_arr[] = " starline_bazar_result.result_date <= '".date('Y-m-d')."' ";
		      }
		      if($game_time != ''){
		          $search_arr[] = " starline_bazar_result.time='".$game_time."' ";
		      }
		      if($token != ''){
		          $search_arr[] = " starline_bazar_result.token='".$token."' ";
		      }

		      if($result_date != ''){
		          $search_arr[] = " starline_bazar_result.result_date='".$result_date."' ";
		      }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(*) as allcount');
		      $records = $this->db->get('starline_bazar_result')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(*) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bazar_result')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'starline_bazar_result.status,starline_bazar_result.result_date,starline_bazar_result.result_patti,starline_bazar_result.result_akda,starline_bazar_result.id as result_id,starline_bazar.bazar_name,starline_bazar.id as bazar_id,starline_bazar_time.time,starline_bazar_time.id as time_id,starline_bazar_result.token';

			  $sql = "SELECT ".$feilds." FROM starline_bazar_result";
			  $sql .= " INNER JOIN starline_bazar ON starline_bazar_result.bazar_name = starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_result.time = starline_bazar_time.id";
			  // echo $sql;die();
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
              //echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
              
		      $data = array();
		      $sr = $postData['start']+1;
			  
		      foreach($records as $record ){
		      		$o = getWinnersStar($record['result_id']);
					// if($record['token']=='7J9BI7l7BSj5YRjEUTbWUSF7D'){
					// 	echo '<pre>';print_r($record);die();
					// }
		      		if(empty($o)){
						$con = ' AND time="'.$record['time_id'].'"';
						$op = checkPending('starline_bazar_game',$record['bazar_id'],$record['result_date'],$con);
						// if($record['result_date']=='2024-07-29' && $record['bazar_id']=='3' && $record['time_id']=='57'){
						// 	die(json_encode($op));
						// }
						if(!empty($op)){
		         			$o=array_column($op, 'id');
		         			$oW = 	"<span id='".$record['result_id']."' class='btn btn-info' onclick='updateLoseBet(".'"starline_bazar_game"'.",".json_encode($o).",".$record['result_id'].")'>".count($o)."</span>";
		         		}else{
		         			$oW = "";
		         		}
		         	}else{
		         		$a = empty($o) ? "" : "<span id='".$games['id']."' class='btn btn-success' onclick='updateWalletStar(".json_encode($o).','.$record['result_id'].")'>".count($o);
		         		$oW = '<span id="'.$record['result_id'].'">'.$a.'</span></span>';
		         	}

		          $data[] = array( 
		              "sr"=>$sr,
		              "token"=>$record['token'],
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$record['game_name'],
		              "result_id"=>$record['result_id'],
		              "time"=>$record['time'],
		              "status"=>$record['status'],
		              "patti"=>$record['result_patti'],
		              "result_date"=>$record['result_date'],
		              "akda"=>$record['result_akda'],
		              "time"=>$record['time'],
		              "openWin"=>$oW,
		              "created"=>$record['created']
		          ); 
		          $sr++;
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


	  	function getCustomerRateData($postData=null){

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
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $status = $postData['status'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($partner_id != ''){
		          $search_arr[] = " client.id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_rate.customer_id='".$customer_id."' ";
		      }
		      if($status != ''){
		          $search_arr[] = " customer_rate.status='".$status."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(customer_rate.id) as allcount');
		      $records = $this->db->get('customer_rate')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(customer_rate.id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('customer_rate')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds= 'customer_rate.customer_id,customer_rate.id,customer_rate.status,customer_rate.rate,client.username,customer.name,customer.mobile';

			  $sql = "SELECT ".$feilds." FROM customer_rate";
			  $sql .= " INNER JOIN client ON customer_rate.partner_id=client.id";
			  $sql .= " LEFT JOIN customer ON customer_rate.customer_id=customer.customer_id";
			//   $sql .= " INNER JOIN customer ON customer_rate.customer_id=customer.customer_id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			//   echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
			  $sr = $postData['start']+1;
		      $data = array();
		      foreach($records as $record){
		          $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "username"=>$record['username'],
		              "customer_id"=>$record['customer_id'],
		              "name"=>$record['name'],
		              "mobile"=>$record['mobile'],
		              "rate"=>$record['rate'],
		              "status"=>$record['status'],
		          ); 
		          $sr++;
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


	  	function getInstantWorliBhav($postData=null){

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
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('warli_bhav')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('warli_bhav')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM warli_bhav";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		              "sr"=>$sr,
		              "game_name"=>$record['game_name'],
		              "bhav"=>$record['bhav'],
		              "id"=>$record['id'],
		              "status"=>$record['status']
		          ); 
		          $sr++;
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

	  	// function getInstantWorliResultList($postData=null){

		//       $response = array();
		//       ## Read value
		//       $draw = $postData['draw'];
		//       $start = $postData['start'];
		//       $rowperpage = $postData['length']; // Rows display per page
		//       $columnIndex = $postData['order'][0]['column']; // Column index
		//       $columnName = $postData['columns'][$columnIndex]['data']; // Column name
		//       $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		//       $searchValue = $postData['search']['value']; // Search value

		//       // Custom search filter 
		//       $id = $postData['id'];
		//       $status = $postData['status'];
		//       $result_date = $postData['result_date'];
		//       $game_id = $postData['game_id'];

		//       ## Search 
		//       $search_arr = array();
		//       $searchQuery = "";
		//       if($id != ''){
		//           $search_arr[] = " id='".$id."' ";
		//       }
		//       if($status != ''){
		//           $search_arr[] = " status='".$status."' ";
		//       }
		//       if($result_date != ''){
		//           $search_arr[] = " result_date='".$result_date."' ";
		//       }
		//       if($game_id != ''){
		//           $search_arr[] = " gameId='".$game_id."' ";
		//       }

		//       if(count($search_arr) > 0){
		//           $searchQuery = implode(" and ",$search_arr);
		//       }

		//       ## Total number of records without filtering
		//       $this->db->select('count(id) as allcount');
		//       $records = $this->db->get('warli_result')->result();
		//       $totalRecords = $records[0]->allcount;

		//       ## Total number of record with filtering
		//       $this->db->select('count(id) as allcount');
		//       if($searchQuery != '')
		//       $this->db->where($searchQuery);
		//       $records = $this->db->get('warli_result')->result();
		//       // echo $this->db->last_query();die();
		//       $totalRecordwithFilter = $records[0]->allcount;

		//       ## Fetch records
		      
		// 	  $sql = "SELECT * FROM warli_result";
		// 	  if(!empty($searchQuery)){
		// 	  	$sql .= " WHERE ".$searchQuery;
		// 	  }
		// 	  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		//       $sql .= " Limit $start, $rowperpage";

		// 	  // echo $sql;die();
		//       $res = $this->db->query($sql);
		// 	  $records = $res->result_array();

		//       $data = array();
		//       $sr = $postData['start']+1;
		//       foreach($records as $record){
		//           $data[] = array( 
		//               "sr"=>$sr,
		//               "gameId"=>$record['gameId'],
		//               "result_date"=>$record['result_date'],
		//               "id"=>$record['id'],
		//               "status"=>$record['status'],
		//               "patti_result"=>$record['patti_result'],
		//               "akda_result"=>$record['akda_result'],
		//           ); 
		//           $sr++;
		//       }

		//       ## Response
		//       $response = array(
		//           "draw" => intval($draw),
		//           "iTotalRecords" => $totalRecords,
		//           "iTotalDisplayRecords" => $totalRecordwithFilter,
		//           "aaData" => $data
		//       );

		//       return $response; 
	  	// }
		
		  function getInstantWorliResultList($postData=null){

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
			$result_date = $postData['result_date'];
			$game_id = $postData['game_id'];

			## Search 
			$search_arr = array();
			  $search_arr1 = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " warli_result.id='".$id."' ";
				  $search_arr1[] = " warli_result.id='".$id."' ";
		      }
		      if($status != ''){
		          $search_arr[] = " warli_result.status='".$status."' ";
				  $search_arr1[] = " warli_result.status='".$status."' ";
		      }
		      if($result_date != ''){
		          $search_arr[] = " warli_result.result_date='".$result_date."' ";
				  $search_arr1[] = " warli_users_game.result_date='".$result_date."' ";
		      }
		      if($game_id != ''){
		          $search_arr[] = " warli_result.gameId='".$game_id."' ";
				  $search_arr1[] = " warli_result.gameId='".$game_id."' ";
		      }

			 
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
				  $searchQuery1 = implode(" and ",$search_arr1);
		      }

		   
			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}

			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('warli_result')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			$records = $this->db->get('warli_result')->result();
			// echo $this->db->last_query();die();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			
			$sql = "SELECT warli_result.*, SUM(warli_users_game.winning_point) as win, SUM(warli_users_game.point) as amt FROM warli_result";
			$sql .= " INNER JOIN warli_users_game ON warli_result.gameId = warli_users_game.round_id";
			// $tSql = "SELECT SUM(warli_users_game.winning_point) as tWin, SUM(warli_users_game.point) as tAmt FROM warli_users_game";
			// $tSql .= " INNER JOIN warli_result ON warli_users_game.round_id = warli_result.gameId";
		  //   $search_arr[] = " warli_users_game.round_id = warli_result.gameId ";
			if(!empty($searchQuery1)){
				$sql .= " WHERE ".$searchQuery1." AND warli_users_game.round_id = warli_result.gameId ";
				// $tSql .= " WHERE ".$searchQuery." AND warli_result.gameId = warli_users_game.round_id ";
			}
			$sql .= " GROUP BY gameId";
			$sql .= " order by ".$columnName." ".$columnSortOrder;
			  
			$sql .= " Limit $start, $rowperpage";
			// echo $sql;die();
			$res = $this->db->query($sql);
			$records = $res->result_array();

			// $tRes = $this->db->query($tSql);
			// $tRecords = $tRes->result();

			$data = array();
		    // echo '<pre>';
		    // print_r($records);
		    // die();
			$sr = $postData['start']+1;
			foreach($records as $record){
				$data[] = array( 
					  "sr"=>$sr,
					"gameId"=>$record['gameId'],
					"result_date"=>$record['result_date'],
					"id"=>$record['id'],
					"status"=>$record['status'],
					"patti_result"=>$record['patti_result'],
					"akda_result"=>$record['akda_result'],
					"amt"=>$record['amt'],
					"win"=>$record['win'],
					"created"=>$record['created'],
				); 
			}

			## Response
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordwithFilter,
				"aaData" => $data,
				// "tR" => $tRecords
			);

			return $response; 
		}

	  	function getRedTableResultList($postData=null){

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

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('redTable_result')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('redTable_result')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM redTable_result";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "gameId"=>$record['gameId'],
		              "result_date"=>$record['result_date'],
		              "status"=>$record['status'],
		              "patti_result"=>$record['patti_result'],
		              "akda_result"=>$record['akda_result'],
		          ); 
		          $sr++;
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

	  	function getGoldenTableResultList($postData=null){

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

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('goldenTable_result')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('goldenTable_result')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM goldenTable_result";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      // echo '<pre>';
		      // print_r($records);
		      // die();
		      foreach($records as $record){
		          $data[] = array( 
		              "gameId"=>$record['gameId'],
		              "result_date"=>$record['result_date'],
		              "id"=>$record['id'],
		              "status"=>$record['status'],
		              "patti_result"=>$record['patti_result'],
		              "akda_result"=>$record['akda_result'],
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

	  	function getRedTableBhav($postData=null){

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
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('redTable_rate')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('redTable_rate')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM redTable_rate";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "game_name"=>$record['game_name'],
		              "bhav"=>$record['rate'],
		              "status"=>$record['status']
		          ); 
		          $sr++;
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

	  	function getGoldenTableBhav($postData=null){

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
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$game_name."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('goldenTable_rate')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('goldenTable_rate')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM goldenTable_rate";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      // echo '<pre>';
		      // print_r($records);
		      // die();
		      foreach($records as $record){
		          $data[] = array( 
		              "game_name"=>$record['game_name'],
		              "bhav"=>$record['rate'],
		              "id"=>$record['id'],
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

	  	function getHolidayData($postData=null){

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
			$massage = $postData['massage'];
			$market_type = $postData['market_type'];
			$bazar_name = $postData['bazar_name'];
			$date = $postData['date'];

			## Search 
			$search_arr = array();
			$searchQuery = "";

			if($searchValue != ''){
				$search_arr[] = " (massage like '%".$searchValue."%' or market_type like '%".$searchValue."%' or bazar_name like '%".$searchValue."%' or date like'%".$searchValue."%')";
			}
			
			if($massage != ''){
				$search_arr[] = " massage='".$massage."' ";
			}
			if($market_type != ''){
				$search_arr[] = " market_type='".$market_type."' ";
			}
			if($bazar_name != ''){
				$search_arr[] = " bazar_name='".$bazar_name."' ";
			}
			if($date != ''){
				$search_arr[] = " date='".$date."' ";
			}

			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}
			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('market_holidays')->result();
			$totalRecords = $records[0]->allcount;
			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			$records = $this->db->get('market_holidays')->result();
			// echo $this->db->last_query();die();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			$feilds= 'id,massage,market_type,bazar_name,date';
			$sql = "SELECT ".$feilds." FROM market_holidays";
			if(!empty($searchQuery)){
				$sql .= " WHERE ".$searchQuery;
				
			}
			$sql .= " order by ".$columnName." ".$columnSortOrder;
			$sql .= " Limit $start, $rowperpage";
			
			 
			 
			$res = $this->db->query($sql);
		
			$records = $res->result_array();
			$sr = $postData['start']+1;
			$data = array();
			foreach($records as $record){
				$data[] = array( 
					"id"=>$record['id'],
					"sr"=>$sr,
					"massage"=>$record['massage'],
					"market_type"=>$record['market_type'],
					"bazar_name"=>$record['bazar_name'],
					"date"=>$record['date'],
				); 
				$sr++;
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

		function getRegularBazarData($postData=null){
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
		      $bazar_name = $postData['bazar_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " bazar_name='".$bazar_name."' ";
		      }


		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('regular_bazar')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_bazar')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM regular_bazar";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr = $postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		              "sr"=>$sr,
		              "id"=>$record['id'],
		              "bazar_name"=>$record['bazar_name'],
		              "open_time"=>$record['open_time'],
		              "close_time"=>$record['close_time'],
		              "days"=>$record['days'],
		              "sequence"=>$record['sequence'],
		              "icon_status"=>$record['icon_status'],
		              "icon_status1"=>$record['icon_status1'],
		              "status"=>$record['status']
		          ); 
		          $sr++;
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

	  	function getRegularBazarRateData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (regular_bazar_rate. like '%".$searchValue."%' or 
		                regular_bazar_rate. like '%".$searchValue."%' or 
		                regular_bazar_rate. like'%".$searchValue."%' ) ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " regular_bazar_rate.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " regular_bazar_rate.game_name='".$game_name."' ";
		      }

		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('regular_bazar_rate')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_bazar_rate')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'regular_bazar_rate.id,regular_bazar_rate.commission,regular_bazar_rate.bazar_name as bazar_id,regular_bazar_rate.game_name as game_id,regular_bazar_rate.rate,regular_bazar.bazar_name,regular_game_type.game_name';

			  $sql = "SELECT ".$feilds." FROM regular_bazar_rate";
			  $sql .= " INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_rate.game_name = regular_game_type.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      $sr = $postData['start']+1;

		      foreach($records as $record ){
			      $data[] = array( 
		              "sr"=>$sr,
		              "commission"=>$record['commission'],
		              "bazar_name"=>$record['bazar_name'],
		              "bazar_id"=>$record['bazar_id'],
		              "game_id"=>$record['game_id'],
		              "game_name"=>$record['game_name'],
		              "rate"=>$record['rate'],
		              "id"=>$record['id']
		          ); 
		          $sr++;
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

	  	function getRegularGameTypeData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (regular_game_type. like '%".$searchValue."%' or 
		                regular_game_type. like '%".$searchValue."%' or 
		                regular_game_type. like'%".$searchValue."%' ) ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " regular_game_type.game_name='".$game_name."' ";
		      }

		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('regular_game_type')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_game_type')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'id,game_name,sequence,status';

			  $sql = "SELECT ".$feilds." FROM regular_game_type";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      
		      $sr = $postData['start']+1;
		      foreach($records as $record ){
			      $data[] = array( 
		              "sr"=>$sr,
		              "status"=>$record['status'],
		              "game_name"=>$record['game_name'],
		              "sequence"=>$record['sequence'],
		              "id"=>$record['id']
		          ); 
		          $sr++;
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

	  	function getStarlineBazarData($postData=null){
			  $response = array();
		      ## Read value
		      $draw = $postData['draw'];
		      $start = $postData['start'];
		      $rowperpage = $postData['length']; // Rows display per page
		      $columnIndex = $postData['order'][0]['column']; // Column index
		      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
		      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		      $searchValue = $postData['search']['value']; // Search value

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('starline_bazar')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bazar')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM starline_bazar";
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
		              "bazar_name"=>$record['bazar_name'],
		              "status"=>$record['status'],
		              "icon_status"=>$record['icon_status'],
		              "icon_status1"=>$record['icon_status1'],
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

	  	function getStarlineBazarTimeData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (starline_bazar_time. like '%".$searchValue."%' or 
		                starline_bazar_time. like '%".$searchValue."%' or 
		                starline_bazar_time. like'%".$searchValue."%' ) ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " starline_bazar_time.game_name='".$game_name."' ";
		      }

		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('starline_bazar_time')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bazar_time')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'starline_bazar_time.id,starline_bazar.bazar_name,starline_bazar_time.time,starline_bazar_time.status';

			  $sql = "SELECT ".$feilds." FROM starline_bazar_time";
			  $sql .= " INNER JOIN starline_bazar ON starline_bazar_time.bazar_name = starline_bazar.id";

			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      
		      $sr = $postData['start']+1;
		      foreach($records as $record ){
			      $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "bazar_name"=>$record['bazar_name'],
		              "time"=>$record['time'],
		              "status"=>$record['status'],
		          );
		          $sr++; 
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


	  	function getStarlineBazarBhavData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (starline_bhav. like '%".$searchValue."%' or 
		                starline_bhav. like '%".$searchValue."%' or 
		                starline_bhav. like'%".$searchValue."%' ) ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " starline_bhav.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " starline_bhav.game_name='".$game_name."' ";
		      }

		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('starline_bhav')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bhav')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'starline_bhav.id,starline_bazar.bazar_name as bazar_id,starline_bhav.game_name as game_id,starline_bazar.bazar_name,starline_game_type.game_name,starline_bhav.rate';

			  $sql = "SELECT ".$feilds." FROM starline_bhav";
			  $sql .= " INNER JOIN starline_bazar ON starline_bhav.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON starline_bhav.game_name = starline_game_type.id";

			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      
		      $sr = $postData['start']+1;
		      foreach($records as $record ){
			      $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "bazar_name"=>$record['bazar_name'],
		              "game_name"=>$record['game_name'],
		              "bhav"=>$record['rate'],
		          ); 
		          $sr++;
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

	  	function getKingBazarBhavData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
		      $game_name = $postData['game_name'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (king_bazar_rate. like '%".$searchValue."%' or 
		                king_bazar_rate. like '%".$searchValue."%' or 
		                king_bazar_rate. like'%".$searchValue."%' ) ";
		      }
		      if($bazar_name != ''){
		          $search_arr[] = " king_bazar_rate.bazar_name='".$bazar_name."' ";
		      }
		      if($game_name != ''){
		          $search_arr[] = " king_bazar_rate.game_type='".$game_name."' ";
		      }

		      if(count($search_arr) > 0){

		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('king_bazar_rate')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('king_bazar_rate')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'king_bazar_rate.id,king_bazar.bazar_name,king_bazar_rate.rate,king_bazar_rate.game_type';

			  $sql = "SELECT ".$feilds." FROM king_bazar_rate";
			  $sql .= " INNER JOIN king_bazar ON king_bazar_rate.bazar_name = king_bazar.id";

			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
		      $data = array();
		      $sr = $postData['start']+1;

		      foreach($records as $record ){
		      	if($record['game_type']=="1"){
		      		$type="First Digit(Ekai)";
		      	}else if($record['game_type']=="2"){
		      		$type="Second Digit(Haruf)";
		      	}else{
		      		$type="Jodi";
		      	}
			      $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "bazar_name"=>$record['bazar_name'],
		              "game_type"=>$type,
		              "bhav"=>$record['rate'],
		          ); 
		          $sr++;
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

	  	function getRegularCustomerData($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
		      $client = $postData['client'];
			  $bazar = $postData['bazar'];
			  $result_date = $postData['result_date'];
		      $date = explode(' - ', $result_date);
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($bazar_name != ''){
		          $search_arr[] = " bazar_name IN (".implode(',', $bazar_name).") ";
		      }
		      
			  if($client != ''){
				$search_arr[] = " partner_id IN (".implode(',', $client).") ";
			  }

		      if($result_date != ''){
		          $search_arr[] = " result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		      }
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get('regular_bazar_games')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT customer_id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('regular_bazar_games')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'DISTINCT customer_id,partner_id';

			  $sql = "SELECT ".$feilds." FROM regular_bazar_games";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
		      
		      $data = array();
		      $gM = array();
		      $gM[0]=" AND game_name IN (5)";
		      $gM[1]=" AND game_name IN (1,7,12,15,33,32,31,30,28,18,19,20,24,29,24)";
			  $gM[2]=" AND game_name IN (2,46,13,36,41,34,43,39)";
		 	  $gM[3]=" AND game_name IN (4,47,45,42,35,48)";
			  $gM[4]=" AND game_name IN (6,10,11,14,17,22,23)";
			  
		      foreach($records as $record ){
		      	  $feilds = "SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com";
				  $con = " WHERE result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' AND customer_id='".$record['customer_id']."'";
				  if($bazar_name != ''){
			          $con .= " AND bazar_name IN (".implode(',', $bazar_name).") ";
			      }
				  $arr=[];
				  $bet=0;
				  $win=0;
				  $com=0;
		      	  foreach($gM as $g){
				  	$sql = "SELECT ".$feilds." FROM regular_bazar_games ".$con.$g;
	        	  	$res = $this->db->query($sql);
				  	$records = $res->result_array();
				  	
				  	array_push($arr, $records[0]);
				  	$bet+=$records[0]['point']?$records[0]['point']:0;
					$win+=$records[0]['win']?$records[0]['win']:0;
					$com+=$records[0]['com']?$records[0]['com']:0;
		      	  }

		      	  $to = $bet - $win;
		      	  $sA = $arr[0]['point']?$arr[0]['point']:0;
		      	  $sP = $arr[1]['point']?$arr[1]['point']:0;
		      	  $dP = $arr[2]['point']?$arr[2]['point']:0;
		      	  $tP = $arr[3]['point']?$arr[3]['point']:0;
		      	  $jodi = $arr[4]['point']?$arr[4]['point']:0;
		          $data[] = array( 
		              "customer_id"=>$record['customer_id'],
		              "sAkda"=>$sA,
		              "sPatti"=>$sP,
		              "dPatti"=>$dP,
		              "tPatti"=>$tP,
		              "jodi"=>$jodi,
		              "bet"=>$bet,
		              "win"=>round($win),
		              "com"=>round($com),
		              "total"=>round($to)
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

	  	function getRegularCustomerDataStar($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
			  $client = $postData['client'];
		      $result_date = $postData['result_date'];
		      $date = explode(' - ', $result_date);
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($bazar_name != ''){
		          $search_arr[] = " bazar_name IN (".implode(',', $bazar_name).") ";
		      }
		      if($client != ''){
				$search_arr[] = " partner_id IN (".implode(',', $client).") ";
			  }
		      if($result_date != ''){
		          $search_arr[] = " result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		      }
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get('starline_bazar_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT customer_id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('starline_bazar_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'DISTINCT customer_id,partner_id';

			  $sql = "SELECT ".$feilds." FROM starline_bazar_game";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		   	  // echo '<pre>';
			  // print_r($sql);
			  // die();
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
		      
		      $data = array();
		      $gM = array();

		      $gM[0]=" AND game_name IN ('2')";
		      $gM[1]=" AND game_name IN ('1','5','6','12')";
			  $gM[2]=" AND game_name IN ('3','7','8','9')";
		 	  $gM[3]=" AND game_name IN ('4','10','11')";

		      foreach($records as $record ){
		      	  $feilds = "SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com";
				  $con = " WHERE result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' AND customer_id='".$record['customer_id']."'";
				  if($bazar_name != ''){
			          $con .= " AND bazar_name IN (".implode(',', $bazar_name).") ";
			      }
				  $arr=[];
				  $bet=0;
				  $win=0;
				  $com=0;
		      	  foreach($gM as $g){

				  	$sql = "SELECT ".$feilds." FROM starline_bazar_game ".$con.$g;
	        	  	$res = $this->db->query($sql);
				  	$records = $res->result_array();
				  	// if($record['customer_id']=='67a4647306214d91aa46ef9e6b7d5700'){
			    //   	  	echo '<pre>';
			    //   	  	print_r($sql);
			    //   	}	
		      	  
				  	array_push($arr, $records[0]);
				  	$bet+=$records[0]['point']?$records[0]['point']:0;
					$win+=$records[0]['win']?$records[0]['win']:0;
					$com+=$records[0]['com']?$records[0]['com']:0;
		      	  }
		      	  // if($record['customer_id']=='67a4647306214d91aa46ef9e6b7d5700'){
		      	  // 	die();
		      	  // }
		      	  $to = $bet - $win;
		      	  $sA = $arr[0]['point']?$arr[0]['point']:0;
		      	  $sP = $arr[1]['point']?$arr[1]['point']:0;
		      	  $dP = $arr[2]['point']?$arr[2]['point']:0;
		      	  $tP = $arr[3]['point']?$arr[3]['point']:0;
		          $data[] = array( 
		              "customer_id"=>$record['customer_id'],
		              "sAkda"=>$sA,
		              "sPatti"=>$sP,
		              "dPatti"=>$dP,
		              "tPatti"=>$tP,
		              "bet"=>$bet,
		              "win"=>round($win),
		              "com"=>round($com),
		              "total"=>round($to)
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

	  	function getRegularCustomerDataKing($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $bazar_name = $postData['bazar_name'];
		      $result_date = $postData['result_date'];
			  $client = $postData['client'];
		      $date = explode(' - ', $result_date);
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($bazar_name != ''){
		          $search_arr[] = " bazar_name IN (".implode(',', $bazar_name).") ";
		      }
		      if($client != ''){
				$search_arr[] = " partner_id IN (".implode(',', $client).") ";
			  }
		      if($result_date != ''){
		          $search_arr[] = " result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		      }
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get('king_bazar_game')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT customer_id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('king_bazar_game')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'DISTINCT customer_id,partner_id';

			  $sql = "SELECT ".$feilds." FROM king_bazar_game";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		   	  // echo '<pre>';
			  // print_r($sql);
			  // die();
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
		      
		      $data = array();
		      $gM = array();
		      $gM[0]=" AND game_name IN (1)";
		      $gM[1]=" AND game_name IN (2)";
			  $gM[2]=" AND game_name IN (3)";

		      foreach($records as $record ){
		      	  $feilds = "SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com";
				  $con = " WHERE result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' AND customer_id='".$record['customer_id']."'";
				  if($bazar_name != ''){
			          $con .= " AND bazar_name IN (".implode(',', $bazar_name).") ";
			      }
				  $arr=[];
				  $bet=0;
				  $win=0;
				  $com=0;
		      	  foreach($gM as $g){
				  	$sql = "SELECT ".$feilds." FROM king_bazar_game ".$con.$g;
	        	  	$res = $this->db->query($sql);
				  	$records = $res->result_array();

				  	array_push($arr, $records[0]);
				  	$bet+=$records[0]['point']?$records[0]['point']:0;
					$win+=$records[0]['win']?$records[0]['win']:0;
					$com+=$records[0]['com']?$records[0]['com']:0;
		      	  }
		      	  $to = $bet - $win;
		      	  $sA = $arr[0]['point']?$arr[0]['point']:0;
		      	  $sP = $arr[1]['point']?$arr[1]['point']:0;
		      	  $dP = $arr[2]['point']?$arr[2]['point']:0;
		          $data[] = array( 
		              "customer_id"=>$record['customer_id'],
		              "sAkda"=>$sA,
		              "sPatti"=>$sP,
		              "dPatti"=>$dP,
		              "bet"=>$bet,
		              "win"=>round($win),
		              "com"=>round($com),
		              "total"=>round($to)
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

	  	function getRegularCustomerDataWorli($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $mar = $postData['mar'];
			  $client = $postData['client'];
		      $result_date = $postData['result_date'];
		      $date = explode(' - ', $result_date);
		      ## Search 
		      	if($_POST['mar']=='4'){
					$table = 'warli_users_game';
				}else if($_POST['mar']=='5'){
					$table = 'redTable_users_game';
				}else if($_POST['mar']=='6'){
					$table = 'goldenTable_users_game';
				}
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($result_date != ''){
		          $search_arr[] = " result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
		      }
		      if($client != ''){
				$search_arr[] = " partner_id IN (".implode(',', $client).") ";
			  }
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get($table)->result();

		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT customer_id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get($table)->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'DISTINCT customer_id,partner_id';

			  $sql = "SELECT ".$feilds." FROM ".$table;
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		   	  
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
		      
		      $data = array();
		      $gM = array();
		      $gM[0]=" AND game_name IN (1)";
		      $gM[1]=" AND game_name IN (2)";
			  $gM[2]=" AND game_name IN (3)";
			  $gM[2]=" AND game_name IN (4)";

		      foreach($records as $record ){
		      	  $feilds = "SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com";
				  $con = " WHERE result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' AND customer_id='".$record['customer_id']."'";
				  if($bazar_name != ''){
			          $con .= " AND bazar_name IN (".implode(',', $bazar_name).") ";
			      }
				  $arr=[];
				  $bet=0;
				  $win=0;
				  $com=0;
		      	  foreach($gM as $g){
				  	$sql = "SELECT ".$feilds." FROM ".$table." ".$con.$g;
	        	  	$res = $this->db->query($sql);
				  	$records = $res->result_array();
				  	
				  	array_push($arr, $records[0]);
				  	$bet+=$records[0]['point']?$records[0]['point']:0;
					$win+=$records[0]['win']?$records[0]['win']:0;
					$com+=$records[0]['com']?$records[0]['com']:0;
		      	  }
		      	  $to = $bet - $win;
		      	  $sA = $arr[0]['point']?$arr[0]['point']:0;
		      	  $sP = $arr[1]['point']?$arr[1]['point']:0;
		      	  $dP = $arr[2]['point']?$arr[2]['point']:0;
		      	  $tP = $arr[3]['point']?$arr[3]['point']:0;
		          $data[] = array( 
		              "customer_id"=>$record['customer_id'],
		              "sAkda"=>$sA,
		              "sPatti"=>$sP,
		              "dPatti"=>$dP,
		              "tPatti"=>$tP,
		              "bet"=>$bet,
		              "win"=>round($win),
		              "com"=>round($com),
		              "total"=>round($to)
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

	  	function getGameTypeList($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $game_name = $postData['game_name'];
		      $status = $postData['status'];
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($game_name != ''){
		          $search_arr[] = " game_name='".$postData['game_name']."' ";
		      }

		      if($status != ''){
		          $search_arr[] = " status='".$postData['status']."' ";
		      }
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get("starline_game_type")->result();

		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get("starline_game_type")->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'id,game_name,priority,status,updated_by';

			  $sql = "SELECT ".$feilds." FROM starline_game_type";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		   	  
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
			  $sr = $postData['start']+1;
		      foreach($records as $record ){
		      	  $data[] = array( 
		              "id"=>$record['id'],
		              "sr"=>$sr,
		              "game_name"=>$record['game_name'],
		              "priority"=>$record['priority'],
		              "status"=>$record['status'],
		              "updated_by"=>$record['updated_by'],
		          ); 
		          $sr++;
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

	  	function lastActivity($postData=null){
			  // $mcrypt = new MCrypt();
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
		      $ent = $postData['ent'];
			  $emp = $postData['emp'];
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      
		      if($ent != ''){
		          $search_arr[] = " entry_table='".$ent."' ";
		      }

			  if($emp != ''){
				$search_arr[] = " supportId='".$emp."' ";
			  }
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      $records = $this->db->get("lastActivity")->result();

		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(DISTINCT id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get("lastActivity")->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      $feilds = 'lastActivity.id,lastActivity.detail,lastActivity.created,lastActivity.entry_table,admin.name as supportName';

			  $sql = "SELECT ".$feilds." FROM lastActivity";
			  $sql .= " INNER JOIN admin ON lastActivity.supportId = admin.id";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		   	  
		      $res = $this->db->query($sql);
		      
			  $records = $res->result_array();
			  $sr = $postData['start']+1;
			  $data=[];
		      foreach($records as $record ){
		      	  $data[] = array( 
		              "sr"=>$sr,
		              "id"=>$record['id'],
		              "supportName"=>$record['supportName'],
		              "detail"=>$record['detail'],
		              "created"=>$record['created'],
		              "entry_table"=>$record['entry_table'],
		          );
		          $sr++; 
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

	  	function getCustomerData($postData=null){

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
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $name = $postData['name'];
		      $app = $postData['app'];
		      $email = $postData['email'];
		      $ud = $postData['ud'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (partner_id like '%".$searchValue."%' or 
		                customer_id like'%".$searchValue."%' ) ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_id like '%".$customer_id."%' ";
		      }
		      if($name != ''){
		          $search_arr[] = " name='".$name."' ";
		      }
		      if($app != ''){
		          $search_arr[] = " app='".$app."' ";
		      }
		      if($email != ''){
		          $search_arr[] = " email='".$email."' ";
		      }

		      if($ud != ''){
		      	  $sql1='SELECT DISTINCT customer_id as id FROM customer_rate';
			      $res = $this->db->query($sql1);
		          $id = $res->result();
		          $nId=array_column($id,'id');
		          if($ud=='D'){
		          	$search_arr[] = " customer_id IN ('".implode("','", $nId)."') ";
		          }else{
		          	$search_arr[] = " customer_id NOT IN ('".implode("','", $nId)."') ";
		          }
		      }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('customer')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('customer')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'created,customer_id,name,mobile,state,city,email,app,signup_date,status';

			  $sql = "SELECT ".$feilds." FROM customer";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";
		      // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      $sr=$postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		              "id"=>$sr,
		              "customer_id"=>$record['customer_id'],
		              "name"=>$record['name'],
		              "mobile"=>$record['mobile'],
		              "state"=>$record['state'],
		              "city"=>$record['city'],
		              "email"=>$record['email'],
		              "app"=>$record['app'],
		              "status"=>$record['status'],
		              "signup_date"=>$record['signup_date'],
		          ); 
		          $sr++;
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

	  	function getTodaysPlayerData($postData=null){
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
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $name = $postData['name'];
		      $app = $postData['app'];
		      $email = $postData['email'];
		      $mobile = $postData['mobile'];
		      $marketType = $postData['marketType'];

		      ## Search 

		      $search_arr = array();
		      $searchQuery = "";
		      if($searchValue != ''){
		          $search_arr[] = " (partner_id like '%".$searchValue."%' or 
		                customer_id like'%".$searchValue."%' ) ";
		      }
		      if($partner_id != ''){
		          $search_arr[] = " partner_id='".$partner_id."' ";
		      }
		      if($customer_id != ''){
		          $search_arr[] = " customer_id like '%".$customer_id."%' ";
		      }
		      if($name != ''){
		          $search_arr[] = " name='".$name."' ";
		      }
		      if($app != ''){
		          $search_arr[] = " app='".$app."' ";
		      }
		      if($mobile != ''){
				$search_arr[] = " mobile='".$mobile."' ";
			  }
		      $con='result_date="'.date('Y-m-d').'"';
		      $sql='SELECT DISTINCT customer_id as id FROM ';
		      $sql1=' WHERE result_date="'.date('Y-m-d').'"';
		      
		      $rg = [];
		      $st = [];
		      $kg = [];
		      $wo = [];
			  if($marketType=='' || $marketType=='Regular'){
				$res = $this->db->query($sql.'regular_bazar_games'.$sql1);
				$id = $res->result();
				$rg = array_column($id,'id');
			  }

			  if($marketType=='' || $marketType=='Starline'){
				$res1 = $this->db->query($sql.'starline_bazar_game'.$sql1);
				$id1 = $res1->result();
				$st = array_column($id1,'id');
			  }

			  if($marketType=='' || $marketType=='King Bazar'){
				$res2 = $this->db->query($sql.'king_bazar_game'.$sql1);
				$id2 = $res2->result();
				$kg = array_column($id2,'id');
			  }

			  if($marketType=='' || $marketType=='Worli Day'){
				$res3 = $this->db->query($sql.'warli_users_game'.$sql1);
				$id3 = $res3->result();
				$wo = array_column($id3,'id');
			  }
		      

		      $uId=array_merge($rg, $st, $kg, $wo);
		      
		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }
		      if($uId != ''){
		          $this->db->group_start();
				  $nR = array_chunk($uId,25);
				  foreach($nR as $ids){
					  $this->db->or_where_in('customer_id', $ids);
				  }
				  $this->db->group_end();
		      }
		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('customer')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		  	  if($uId != ''){
		          $this->db->group_start();
				  $nR = array_chunk($uId,25);
				  foreach($nR as $ids){
					  $this->db->or_where_in('customer_id', $ids);
				  }
				  $this->db->group_end();
		      }
		      $records = $this->db->get('customer')->result();
		      $totalRecordwithFilter = $records[0]->allcount;

		      $feilds = 'created,customer_id,name,mobile,state,city,email,app,signup_date,status';

			  // $sql = "SELECT ".$feilds." FROM customer";
			  // if(!empty($searchQuery)){
			  // 	$sql .= " WHERE ".$searchQuery." AND";
			  // }
			  // if($uId != ''){
		   //    	  $nR = array_chunk($uId,25);
		   //    	  $i=0;
				 //  foreach($nR as $ids){
				 //  	if($i==0){
				 //  	  if(!empty($searchQuery)){
					//   	$sql .= " customer_id IN ('".implode("','", $ids)."') ";
				 //  	  }else{
					//   	$sql .= " WHERE customer_id IN ('".implode("','", $ids)."') ";
				 //  	  }
				 //  	}else{
					//   $sql .= " OR customer_id IN ('".implode("','", $ids)."') ";
				 //  	}
				 //  	$i++;
				 //  }
		   //    }
			  // $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		   //    $sql .= " Limit $start, $rowperpage";
		   //    echo $sql;die();
		   //    $res = $this->db->query($sql);
			  // $records = $res->result_array();
		      $this->db->select($feilds);
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		  	  if($uId != ''){
		          $this->db->group_start();
				  $nR = array_chunk($uId,25);
				  foreach($nR as $ids){
					  $this->db->or_where_in('customer_id', $ids);
				  }
				  $this->db->group_end();
		      }
		      $this->db->order_by($columnName,$columnSortOrder);
			  $this->db->limit($rowperpage,$start);
		      $records = $this->db->get('customer')->result();

		      $data = array();
		      $sr=$postData['start']+1;
		      foreach($records as $record){
		          $data[] = array( 
		          	  "id"=>$sr,
		              "customer_id"=>$record->customer_id,
		              "name"=>$record->name,
		              "mobile"=>$record->mobile,
		              "state"=>$record->state,
		              "city"=>$record->city,
		              "email"=>$record->email,
		              "app"=>$record->app,
		              "status"=>$record->status,
		              "signup_date"=>$record->signup_date,
		          ); 
		          $sr++;
		      }

		      // foreach($records as $record){
		      //     $data[] = array( 
		      //         "customer_id"=>$record['customer_id'],
		      //         "name"=>$record['name'],
		      //         "mobile"=>$record['mobile'],
		      //         "state"=>$record['state'],
		      //         "city"=>$record['city'],
		      //         "email"=>$record['email'],
		      //         "app"=>$record['app'],
		      //         "status"=>$record['status'],
		      //         "signup_date"=>$record['signup_date'],
		      //     ); 
		      // }

		      ## Response
		      $response = array(
		          "draw" => intval($draw),
		          "iTotalRecords" => $totalRecords,
		          "iTotalDisplayRecords" => $totalRecordwithFilter,
		          "aaData" => $data
		      );
		      return $response; 
	  	}

		function cuttingRecord($postData=null){
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
			$bazarName = $postData['bazarName'];
			$resultDate = $postData['resultDate'];
			$type = $postData['type'];
			$adminId = $postData['adminId'];
			
			## Search 

			$search_arr = array();
			$searchQuery = "";
			if($adminId != ''){
				$search_arr[] = " adminId='".$adminId."' ";
			}
			if($bazarName != ''){
				$search_arr[] = " bazarName='".$bazarName."' ";
			}
			if($resultDate != ''){
				$search_arr[] = " resultDate='".$resultDate."' ";
			}
			if($type != ''){
				$search_arr[] = " type='".$type."' ";
			}
			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}
			
			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('cutting')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			
			$records = $this->db->get('cutting')->result();
			$totalRecordwithFilter = $records[0]->allcount;


			$feilds = 'regular_bazar.bazar_name as bazarName,cutting.cuttingData,cutting.resultDate,cutting.cuttingPercentage,cutting.adminId,cutting.id,cutting.type,cutting.updated,cutting.resultDate,admin.name as adminId';

			$sql = "SELECT ".$feilds." FROM cutting";
			$sql .= " INNER JOIN regular_bazar ON cutting.bazarName = regular_bazar.id INNER JOIN admin ON cutting.adminId = admin.id";

			if(!empty($searchQuery))
				$sql .= " WHERE ".$searchQuery;

			if(!empty($columnName) && !empty($columnSortOrder))
				$sql .= " order by cutting.".$columnName." ".$columnSortOrder;
			
			$sql .= " Limit $start, $rowperpage";
			//    echo $sql;die();
			$res = $this->db->query($sql);
			$records = $res->result_array();

			$data = array();
			foreach($records as $record){
				
				$data[] = array( 
					"id"=>$record['id'],
					"bazarName"=>$record['bazarName'],
					"cuttingPercentage"=>$record['cuttingPercentage'],
					"resultDate"=>$record['resultDate'],
					"adminId"=>$record['adminId'],
					"type"=>$record['type'],
					"cuttingData"=>$record['cuttingData'],
					"updated"=>$record['updated']
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

		function getVideoStrimingData($postData=null){
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
			$patti = $postData['patti'];
			$link = $postData['link'];
			$updated = $postData['updated'];
			
			## Search 

			$search_arr = array();
			$searchQuery = "";
			if($searchValue != ''){
				$search_arr[] = " (patti like '%".$searchValue."%' or 
					  link like'%".$searchValue."%' ) ";
			}
			if($id != ''){
				$search_arr[] = " id='".$id."' ";
			}
			if($patti != ''){
				$search_arr[] = " patti='".$patti."' ";
			}
			if($link != ''){
				$search_arr[] = " link='".$link."' ";
			}
			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}
			
			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('buffer_video_list')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			
			$records = $this->db->get('buffer_video_list')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			$this->db->select('*');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			
			$this->db->order_by($columnName,$columnSortOrder);
			$this->db->limit($rowperpage,$start);
			
			$records = $this->db->get('buffer_video_list')->result();
			// die($this->db->last_query());
			$data = array();
			foreach($records as $record){
				$data[] = array( 
					"id"=>$record->id,
					"link"=>$record->link,
					"patti"=>$record->patti,
					"updated"=>$record->updated
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


		function getWinnerList($postData=null){
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
			$result_date = $postData['dateRange'];
			## Search 

			$search_arr = array();
			$searchQuery = "";
			if($searchValue != ''){
				$search_arr[] = " (patti like '%".$searchValue."%' or 
					  link like'%".$searchValue."%' ) ";
			}
			
			if($result_date != ''){
				$date = explode(' - ', $result_date);
				$search_arr[] = " result_date BETWEEN '".date('Y-m-d',strtotime($date[0]))."' AND '".date('Y-m-d',strtotime($date[1]))."' ";
			}
			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}
			
			## Total number of records without filtering
			$this->db->select('count(distinct customer_id) as allcount');
			$records = $this->db->get('warli_users_game')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(distinct customer_id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			
			$records = $this->db->get('warli_users_game')->result();
			$totalRecordwithFilter = $records[0]->allcount;


			$feilds = 'SUM(point) as bet_amount,SUM(round(winning_point)) as winning_point,round(SUM(point)-SUM(winning_point)) as pnl,name,mobile,state';

			$sql = "SELECT ".$feilds." FROM warli_users_game";
			$sql .= " INNER JOIN customer ON warli_users_game.customer_id = customer.customer_id";
			
			if(!empty($searchQuery)){
				$sql .= " WHERE ".$searchQuery;
			}
			$sql .= " group by customer.customer_id";
			
			$sql .= " order by pnl ".$columnSortOrder;
			
			$sql .= " Limit $start, $rowperpage";
			   
			$res = $this->db->query($sql);
			// die($sql);
			$records = $res->result_array();
			
			
			$data = array();
			foreach($records as $record){
				$data[] = array( 
					"bet_amount"=>$record['bet_amount'],
					"winning_point"=>$record['winning_point'],
					"pnl"=>$record['pnl'],
					"name"=>$record['name'],
					"mobile"=>$record['mobile'],
					"state"=>$record['state'],
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

		function getRegularRiskData($postData=null){
			// $mcrypt = new MCrypt();
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
			$bazar_name = $postData['bazar_name'];
			$result_date = $postData['result_date'];
			$risk = $postData['risk'];

			## Search 
			$search_arr = array();
			$searchQuery = "";
			
			if($bazar_name != ''){
				$search_arr[] = " regular_bazar_games.bazar_name='".$bazar_name."' ";
			}if($result_date != ''){
				$search_arr[] = " regular_bazar_games.result_date='".$result_date."' ";
			}
			if($risk != ''){
				$search_arr[] = " regular_bazar_games.game_type<'".$risk."' ";
			}
			
			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}

			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('regular_bazar_games')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			$records = $this->db->get('regular_bazar_games')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			$sql = "SELECT * FROM regular_bazar_games";
			if(!empty($searchQuery)){
				$sql .= " WHERE ".$searchQuery;
			}
			$sql .= " order by ".$columnName." ".$columnSortOrder;
			  
			$sql .= " Limit $start, $rowperpage";
			echo $sql;die();
			$res = $this->db->query($sql);
			$records = $res->result_array();
			$data = array();
			$sr = $postData['start']+1;

			foreach($records as $record ){
				if($record['partner_id']=='2'){
					$code = '';
				  for ($i = 0; $i < strlen($record['customer_id']); $i += 2) {
					  $code .= chr(hexdec(substr($record['customer_id'], $i, 2)));
				  }
				  $iv = '8368871eeb9b975b';
				  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
				  mcrypt_generic_init($td, 'cd075230fea33f24', $iv);
				  $decrypted = mdecrypt_generic($td, $code);
				  mcrypt_generic_deinit($td);
				  mcrypt_module_close($td);
					$newId = utf8_encode(trim($decrypted));
				}else{
					$newId = $record['customer_id'];
				}
				$data[] = array( 
					"sr"=>$sr,
					"transaction_id"=>$record['transaction_id'],
					"partner_id"=>$record['partner_id'],
					// "customer_id"=>$record['customer_id'],
					"customer_id"=>$newId,
					"bazar_name"=>$record['bazar_name'],
					"game_name"=>$record['game_name'],
					"commission"=>$record['commission'],
					"winning_point"=>$record['winning_point'],
					"status"=>$record['status'],
					"game"=>$record['game'],
					"game_type"=>$record['game_type'],
					"result_date"=>$record['result_date'],
					"point"=>$record['point'],
					"created"=>$record['created']
				); 
				$sr++;
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

		function getStarlineRiskData($postData=null){

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
			$transaction_id = $postData['transaction_id'];
			$partner_id = $postData['partner_id'];
			$customer_id = $postData['customer_id'];
			$bazar_name = $postData['bazar_name'];
			$game_name = $postData['game_name'];
			$game_time = $postData['game_time'];
			$result_date = $postData['result_date'];
			$to_date = $postData['to_date'];
			$game = $postData['game'];

			## Search 
			$search_arr = array();
			$searchQuery = "";
			if($searchValue != ''){
				$search_arr[] = " (starline_bazar_game.transaction_id like '%".$searchValue."%' or 
					  starline_bazar_game.partner_id like '%".$searchValue."%' or 
					  starline_bazar_game.customer_id like'%".$searchValue."%' ) ";
			}
			if($transaction_id != ''){
				$search_arr[] = " starline_bazar_game.transaction_id='".$transaction_id."' ";
			}
			if($partner_id != ''){
				$search_arr[] = " starline_bazar_game.partner_id='".$partner_id."' ";
			}
			if($customer_id != ''){
				$search_arr[] = " starline_bazar_game.customer_id like '%".$customer_id."%' ";
			}

			if($bazar_name != ''){
				$search_arr[] = " starline_bazar_game.bazar_name='".$bazar_name."' ";
			}
			if($game_name != ''){
				$search_arr[] = " starline_bazar_game.game_name='".$game_name."' ";
			}
			if($game_time != ''){
				$search_arr[] = " starline_bazar_game.time='".$game_time."' ";
			}
			if($to_date != ''){
				$search_arr[] = " starline_bazar_game.result_date BETWEEN '".$result_date."' AND '".$to_date."' ";
			}else if($result_date != ''){
				$search_arr[] = " starline_bazar_game.result_date='".$result_date."' ";
			}
			if($game != ''){
				$search_arr[] = " starline_bazar_game.game='".$game."' ";
			}

			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}

			## Total number of records without filtering
			$this->db->select('count(*) as allcount');
			$records = $this->db->get('starline_bazar_game')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(*) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			$records = $this->db->get('starline_bazar_game')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			## Fetch records
			$feilds = 'starline_bazar_game.created,starline_bazar_game.point,starline_bazar_game.commission,starline_bazar_game.winning_point,starline_bazar_game.status,starline_bazar_game.game,starline_game_type.game_name,starline_bazar_game.game_name as game_id,starline_bazar_game.result_date,starline_bazar_game.transaction_id,starline_bazar_game.partner_id,starline_bazar_game.customer_id,starline_bazar.bazar_name,starline_bazar_game.bazar_name as bazar_id,starline_game_type.game_name,starline_bazar_game.game_name as game_id,starline_bazar_time.time';

			$sql = "SELECT ".$feilds." FROM starline_bazar_game";
			$sql .= " INNER JOIN starline_bazar ON starline_bazar_game.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON starline_bazar_game.game_name = starline_game_type.id INNER JOIN starline_bazar_time ON starline_bazar_game.time = starline_bazar_time.id";
			if(!empty($searchQuery)){
				$sql .= " WHERE ".$searchQuery;
			}
			$sql .= " order by ".$columnName." ".$columnSortOrder;
			  
			$sql .= " Limit $start, $rowperpage";

			$res = $this->db->query($sql);
			$records = $res->result_array();

			$data = array();
			$sr = $postData['start']+1;
			foreach($records as $record ){
				$data[] = array( 
					"sr"=>$sr,
					"transaction_id"=>$record['transaction_id'],
					"partner_id"=>$record['partner_id'],
					"customer_id"=>$record['customer_id'],
					"bazar_name"=>$record['bazar_name'],
					"game_name"=>$record['game_name'],
					"time"=>$record['time'],
					"commission"=>$record['commission'],
					"winning_point"=>$record['winning_point'],
					"status"=>$record['status'],
					"game"=>$record['game'],
					"result_date"=>$record['result_date'],
					"point"=>$record['point'],
					"time"=>$record['time'],
					"created"=>$record['created']
				); 
				$sr++;
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

		function getKingRiskData($postData=null){

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
			$transaction_id = $postData['transaction_id'];
			$partner_id = $postData['partner_id'];
			$customer_id = $postData['customer_id'];
			$bazar_name = $postData['bazar_name'];
			$game_name = $postData['game_name'];
			$result_date = $postData['result_date'];
			$to_date = $postData['to_date'];
			$game = $postData['game'];

			## Search 
			$search_arr = array();
			$searchQuery = "";
			if($searchValue != ''){
				$search_arr[] = " (king_bazar_game.transaction_id like '%".$searchValue."%' or 
					  king_bazar_game.partner_id like '%".$searchValue."%' or 
					  king_bazar_game.customer_id like'%".$searchValue."%' ) ";
			}
			if($transaction_id != ''){
				$search_arr[] = " king_bazar_game.transaction_id='".$transaction_id."' ";
			}
			if($partner_id != ''){
				$search_arr[] = " king_bazar_game.partner_id='".$partner_id."' ";
			}
			if($customer_id != ''){
				$search_arr[] = " king_bazar_game.customer_id like '%".$customer_id."%' ";
			}

			if($bazar_name != ''){
				$search_arr[] = " king_bazar_game.bazar_name='".$bazar_name."' ";
			}
			if($game_name != ''){
				$search_arr[] = " king_bazar_game.game_name='".$game_name."' ";
			}
			if($to_date != ''){
				$search_arr[] = " king_bazar_game.result_date BETWEEN '".$result_date."' AND '".$to_date."' ";
			}else if($result_date != ''){
				$search_arr[] = " king_bazar_game.result_date='".date("Y-m-d", strtotime($result_date))."' ";
			}
			if($game != ''){
				$search_arr[] = " king_bazar_game.game='".$game."' ";
			}

			if(count($search_arr) > 0){
				$searchQuery = implode(" and ",$search_arr);
			}

			## Total number of records without filtering
			$this->db->select('count(id) as allcount');
			$records = $this->db->get('king_bazar_game')->result();
			$totalRecords = $records[0]->allcount;

			## Total number of record with filtering
			$this->db->select('count(id) as allcount');
			if($searchQuery != '')
			$this->db->where($searchQuery);
			$records = $this->db->get('king_bazar_game')->result();
			$totalRecordwithFilter = $records[0]->allcount;

			$feilds = 'king_bazar_game.created,king_bazar_game.game_name,king_bazar_game.point,king_bazar_game.commission,king_bazar_game.winning_point,king_bazar_game.status,king_bazar_game.game,king_bazar_game.result_date,king_bazar_game.transaction_id,king_bazar_game.partner_id,king_bazar_game.customer_id,king_bazar.bazar_name,king_bazar_game.bazar_name as bazar_id';

			$sql = "SELECT ".$feilds." FROM king_bazar_game";
			$sql .= " INNER JOIN king_bazar ON king_bazar_game.bazar_name = king_bazar.id";
			if(!empty($searchQuery)){
				$sql .= " WHERE ".$searchQuery;
			}
			$sql .= " order by ".$columnName." ".$columnSortOrder;
			  
			$sql .= " Limit $start, $rowperpage";
			// echo $sql;die();
			$res = $this->db->query($sql);
			$records = $res->result_array();

			$data = array();
			$sr = $postData['start']+1;
			foreach($records as $record){
				   if($record['game_name']==1){
					   $game_name = 'FIRST DIGIT(EKAI)';
				   }else if($record['game_name']==2){
					   $game_name = 'FIRST DIGIT(HARUF)';
				   }else{
					   $game_name = 'JODI';
				   }
				$data[] = array( 
					"sr"=>$sr,
					"transaction_id"=>$record['transaction_id'],
					"partner_id"=>$record['partner_id'],
					"customer_id"=>$record['customer_id'],
					"bazar_name"=>$record['bazar_name'],
					"game_name"=>$game_name,
					"commission"=>$record['commission'],
					"winning_point"=>$record['winning_point'],
					"status"=>$record['status'],
					"game"=>$record['game'],
					"result_date"=>$record['result_date'],
					"point"=>$record['point'],
					"created"=>$record['created'],
				); 
				$sr++;
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

		function crezyMarkaResultList($postData=null){
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
		      $result_date = $postData['result_date'];
		      $round_id = $postData['round_id'];

		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."' ";
		      }
		      if($status != ''){
		          $status[] = " status='".$status."' ";
		      }
		      if($round_id != ''){
		          $search_arr[] = " round_id='".$round_id."' ";
		      }
			  if($result_date != ''){
				$search_arr[] = " result_date='".$result_date."' ";
			  }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('crezyMatkaResult')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('crezyMatkaResult')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM crezyMatkaResult";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();

		      $data = array();
		      foreach($records as $record){
				$bFeild = 'SUM(point_in_rs) as point,COUNT(id) as id, COUNT(DISTINCT customer_id) as player,SUM(commission_in_rs) as com,SUM(winning_in_rs) as win';
				$this->db->select($bFeild);
				$this->db->where(" round_id='".$record['round_id']."' ");
				$ggrDetail = $this->db->get('crezyMatkaGame')->result();
				$d = $ggrDetail[0];
		          $data[] = array( 
		              "result_date"=>$record['result_date'],
		              "round_id"=>$record['round_id'],
		              "id"=>$record['id'],
		              "akda"=>$record['akda'],
		              "status"=>$record['status'],
		              "bhav"=>$record['bhav'],
		              "updated"=>$record['updated'],
		              "betPoint"=>$d->point!=null?$d->point:0,
		              "totalBet"=>$d->id!=null?$d->id:0,
		              "totalPlayer"=>$d->player!=null?$d->player:0,
		              "totalWin"=>$d->win!=null?$d->win:0,
		              "totalCom"=>$d->com!=null?$d->com:0,
		          ); 
				  
				// die(json_encode($data));
		          $sr++;
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

		function crezyMarkaGameList($postData=null){
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
		      $result_date = $postData['result_date'];
		      $round_id = $postData['round_id'];
		      $partner_id = $postData['partner_id'];
		      $customer_id = $postData['customer_id'];
		      $transaction_id = $postData['transaction_id'];
			  
		      ## Search 
		      $search_arr = array();
		      $searchQuery = "";
		      if($id != ''){
		          $search_arr[] = " id='".$id."'";
		      }
		      if($status != ''){
		          $search_arr[] = " status='".$status."'";
		      }
		      if($round_id != ''){
		          $search_arr[] = " round_id='".$round_id."'";
		      }
			  if($result_date != ''){
				$search_arr[] = " result_date='".$result_date."'";
			  }
			  if($partner_id != ''){
				$search_arr[] = " partner_id='".$partner_id."'";
			  }
			  if($customer_id != ''){
				$search_arr[] = " customer_id='".$customer_id."'";
			  }
			  if($transaction_id != ''){
				$search_arr[] = " transaction_id='".$transaction_id."'";
			  }

		      if(count($search_arr) > 0){
		          $searchQuery = implode(" and ",$search_arr);
		      }

		      ## Total number of records without filtering
		      $this->db->select('count(id) as allcount');
		      $records = $this->db->get('crezyMatkaGame')->result();
		      $totalRecords = $records[0]->allcount;

		      ## Total number of record with filtering
		      $this->db->select('count(id) as allcount');
		      if($searchQuery != '')
		      $this->db->where($searchQuery);
		      $records = $this->db->get('crezyMatkaGame')->result();
		      // echo $this->db->last_query();die();
		      $totalRecordwithFilter = $records[0]->allcount;

		      ## Fetch records
		      
			  $sql = "SELECT * FROM crezyMatkaGame";
			  if(!empty($searchQuery)){
			  	$sql .= " WHERE ".$searchQuery;
			  }
			  $sql .= " order by ".$columnName." ".$columnSortOrder;
				
		      $sql .= " Limit $start, $rowperpage";

			  // echo $sql;die();
		      $res = $this->db->query($sql);
			  $records = $res->result_array();
			  $d = $this->db->query("SELECT id,client_name FROM client");
			  $s = $d->result_array();
			  $cR = array();
				foreach ($s as $k){
					$cR[$k['id']] = $k['client_name'];
				}
		      $data = array();
		      foreach($records as $record){
				  $pn = $cR[$record['partner_id']];
				  	if($record['partner_id']=='2'){
						$code = '';
					for ($i = 0; $i < strlen($record['customer_id']); $i += 2) {
						$code .= chr(hexdec(substr($record['customer_id'], $i, 2)));
					}
					$iv = '8368871eeb9b975b';
					$td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
					mcrypt_generic_init($td, 'cd075230fea33f24', $iv);
					$decrypted = mdecrypt_generic($td, $code);
					mcrypt_generic_deinit($td);
					mcrypt_module_close($td);
						$newId = utf8_encode(trim($decrypted));
					}else{
						$newId = $record['customer_id'];
					}
		          $data[] = array( 
		              "transaction_id"=>$record['transaction_id'],
		              "partner_id"=>$pn,
		              "id"=>$record['id'],
		              "customer_id"=>$newId,
		              "round_id"=>$record['round_id'],
		              "customerName"=>$record['customerName'],
		              "result_date"=>$record['result_date'],
		              "point_in_rs"=>$record['point_in_rs'],
		              "game"=>$record['game'],
		              "status"=>$record['status'],
		              "bhav"=>$record['bhav'],
		              "winning_in_rs"=>$record['winning_in_rs'],
		              "commission_in_rs"=>$record['commission_in_rs'],
		              "currency_code"=>$record['currency_code'],
		              "exchange_rate"=>$record['exchange_rate'],
		              "updated"=>$record['updated'],
		          ); 
		          $sr++;
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