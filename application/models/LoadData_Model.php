<?php
	Class LoadData_Model extends CI_Model {
		public function getData($table,$con='',$feild='',$limit='',$offset='',$result='',$orderby='',$groupby=''){
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
	        $res = $this->db->query($sql);
	        if($result==''){
				$row = $res->result_array(); 
	        }else{
				$row = $res->row_array(); 
	        }
			return $row;
		}

///////////////////////////////////////====== Matka Games Start =======/////////////////////////////////////////////////////

        public function loadDataMG($tableName='', $gameName='', $gameMode='', $offset=0,  $record_per_page=10)	{
            $sql = "SELECT * FROM $tableName";
			if($gameName != '' && $gameMode == '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$gameName.'%"';
		   }else if($gameName == '' && $gameMode != '')	{
			   $sql .= ' WHERE status = "'.$gameMode.'"';
		   }else if($gameName != '' && $gameMode != '')	{
			   $sql .= ' WHERE bazar_name LIKE "%'.$gameName.'%" AND status = "'.$gameMode.'"';
		   }
		   $sql .= " Limit $offset, $record_per_page";
         
            $rr = $this->db->query($sql)->result_array();
            return $rr;
        }

		public function countRecordMG($tableName, $gameName='', $gameMode=''){
			$sql = "SELECT count('id') as total FROM $tableName";
			if($gameName != '' && $gameMode == '')	{
				 $sql .= ' WHERE bazar_name LIKE "%'.$gameName.'%"';
			}else if($gameName == '' && $gameMode != '')	{
				$sql .= ' WHERE status = "'.$gameMode.'"';
			}else if($gameName != '' && $gameMode != '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$gameName.'%" AND status = "'.$gameMode.'"';
			}
			$rr = $this->db->query($sql)->result_array();
            return $rr[0]['total'];  
		}

 
///////////////////////////////////////====== Matka Games All Games Start =======/////////////////////////////////////////////////////

		public function loadDataMAG($tableName='', $bazarName='', $bazarDate='', $offset=0,  $record_per_page=10)	{
            $sql = "SELECT $tableName.id, $tableName.bazar_name as bazar_id, regular_bazar.bazar_name, $tableName.open, $tableName.jodi, $tableName.close, $tableName.result_date FROM $tableName";
			$sql .= " INNER JOIN regular_bazar ON regular_bazar_result.bazar_name = regular_bazar.id";
			if($bazarName != '' && $bazarDate == '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';
		   }else if($bazarName == '' && $bazarDate != '')	{
			   $sql .= ' WHERE result_date = "'.$bazarDate.'"';
		   }else if($bazarName != '' && $bazarDate != '')	{
			   $sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND result_date = "'.$bazarDate.'"';
			   
		   } 
		   $sql .= " ORDER BY $tableName.id DESC";
		   $sql .= " Limit $offset, $record_per_page";
           $rr = $this->db->query($sql)->result_array();

            return $rr;
        }
		public function countRecordMAG($tableName, $bazarName='', $bazarDate=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			$sql .= " INNER JOIN regular_bazar ON regular_bazar_result.bazar_name = regular_bazar.id";
			if($bazarName != '' && $bazarDate == '')	{
				 $sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $bazarDate != '')	{
				$sql .= ' WHERE result_date = "'.$bazarDate.'"';
			}else if($bazarName != '' && $bazarDate != '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND result_date = "'.$bazarDate.'"';
			}
			// echo $sql;die();
			// $rr = $this->db->query($sql)->result_array();
   //          return $rr[0]['total'];  
		}

///////////////////////////////////////====== Matka Games Bazar List Start =======/////////////////////////////////////////////////////

		public function loadDataMGBL($tableName='', $bazarName='', $gameName='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT regular_bazar_rate.id,regular_bazar_rate.rate,regular_bazar_rate.commission,regular_bazar.bazar_name,regular_game_type.game_name FROM regular_bazar_rate INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_rate.game_name";
			if($bazarName != '' && $gameName == '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameName != '')	{
					$sql .= ' WHERE regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}else if($bazarName != '' && $gameName != '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}
			$sql .= " Limit $offset, $record_per_page";
				$rr = $this->db->query($sql)->result_array();
				return $rr;
		}
		public function countRecordMGBL($tableName, $bazarName='', $gameName=''){
				$sql = "SELECT count('id') as total FROM $tableName";
				if($bazarName != '' && $gameName == '')	{
					$sql .= ' INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name = regular_bazar.id WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameName != '')	{
					$sql .= ' INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_rate.game_name WHERE regular_game_type.game_name LIKE "%'.$gameName.'%"';
					
			}else if($bazarName != '' && $gameName != '')	{
				$sql .= ' INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_rate.game_name WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}
				
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Matka Games Game Type List Start =======/////////////////////////////////////////////////////

		public function loadDataMGGTL($tableName='', $gameName='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT id, game_name, sequence, status FROM $tableName";
			if($gameName != '' && $status == '')	{
				$sql .= ' WHERE game_name LIKE "%'.$gameName.'%"';
			}else if($gameName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';		 
			}else if($gameName != '' && $status != '')	{
				$sql .= ' WHERE game_name LIKE "%'.$gameName.'%" AND status = "'.$status.'"';  
			}
			$sql .= " Limit $offset, $record_per_page";
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}
		public function countRecordMGGTL($tableName, $gameName='', $status=''){
			$sql = "SELECT count('id') as total FROM $tableName";
			if($gameName != '' && $status == '')	{
				$sql .= ' WHERE game_name LIKE "%'.$gameName.'%"';
			}else if($gameName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';
			}else if($gameName != '' && $status != '')	{
				$sql .= ' WHERE game_name LIKE "%'.$gameName.'%" AND status = "'.$status.'"';
			}
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Matka Games Allot Bazar Games List Start =======/////////////////////////////////////////////////////

		public function loadDataMGABGL($tableName='', $bazarName='', $gameName='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT $tableName.id, regular_bazar.bazar_name, regular_game_type.game_name, $tableName.sequence, $tableName.status FROM $tableName INNER JOIN regular_bazar ON $tableName.bazar_name = regular_bazar.id  INNER JOIN regular_game_type ON $tableName.game_name = regular_game_type.id";
			$flag = 0;
			if($bazarName != '' && $gameName == '' && $status == '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			} else if($bazarName == '' && $gameName != '' && $status == '')	{ 
				$sql .= ' WHERE regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}else if($bazarName == '' && $gameName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';		 
			}else if($bazarName != '' && $gameName != '' && $status == '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}
			else if($bazarName != '' && $gameName == '' && $status != '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';  
			}else if($bazarName == '' && $gameName != '' && $status != '')	{
				$sql .= ' WHERE regular_game_type.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';  
			}else if($bazarName != '' && $gameName != '' && $status != '')	{
				$sql .= ' WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';   
			}
			
			$sql .= " Limit $offset, $record_per_page";
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}
		public function countRecordMGABGL($tableName, $bazarName='',  $gameName='', $status=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			if($bazarName != '' && $gameName == '' && $status == '')	{	
				$sql .= ' INNER JOIN regular_bazar ON '.$tableName.'.bazar_name = regular_bazar.id WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%"';	 
			} else if($bazarName == '' && $gameName != '' && $status == '')	{	
				$sql .= ' INNER JOIN regular_game_type ON '.$tableName.'.game_name = regular_game_type.id WHERE regular_game_type.game_name LIKE "%'.$gameName.'%"';
			}else if($bazarName == '' && $gameName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';		  
			}else if($bazarName != '' && $gameName != '' && $status == '')	{
				$sql .= ' INNER JOIN regular_bazar ON '.$tableName.'.bazar_name = regular_bazar.id  INNER JOIN regular_game_type ON '.$tableName.'.game_name = regular_game_type.id WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name = "%'.$gameName.'%"';  
			}else if($bazarName != '' && $gameName == '' && $status != '')	{	
				$sql .= ' INNER JOIN regular_bazar ON '.$tableName.'.bazar_name = regular_bazar.id WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';  
			}else if($bazarName == '' && $gameName != '' && $status != '')	{	
				$sql .= ' INNER JOIN regular_game_type ON '.$tableName.'.game_name = regular_game_type.id WHERE regular_game_type.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';  
			}else if($bazarName != '' && $gameName != '' && $status != '')	{
				$sql .= ' INNER JOIN regular_bazar ON '.$tableName.'.bazar_name = regular_bazar.id  INNER JOIN regular_game_type ON '.$tableName.'.game_name = regular_game_type.id WHERE regular_bazar.bazar_name LIKE "%'.$bazarName.'%" AND regular_game_type.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';  
			} 
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}
///////////////////////////////////////====== Starline Games (All Bazar Time) Start =======/////////////////////////////////////////////////////

		public function loadDataSL($tableName='', $bazarName='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT $tableName.id, starline_bazar.bazar_name, $tableName.time, $tableName.status FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id";
			if($bazarName != '' && $status == '')	{ 
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
				 
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';
				 
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
				 
			}
			$sql .= " Limit $offset, $record_per_page";
				$rr = $this->db->query($sql)->result_array();
				return $rr;
		}

		public function countRecordSL($tableName, $bazarName='', $status=''){
			$sql = "SELECT count('id') as total FROM $tableName";
			if($bazarName != '' && $status == '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
			}
			$rr = $this->db->query($sql)->result_array();
			 
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Starline Games Bazar List Start =======/////////////////////////////////////////////////////

		public function loadDataSLBL($tableName='', $bazarName='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT id, bazar_name, status FROM $tableName";
			if($bazarName != '' && $status == '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%" AND status = "'.$status.'"';
			}
			$sql .= " Limit $offset, $record_per_page";
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}

		public function countRecordSLBL($tableName, $bazarName='', $status=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			if($bazarName != '' && $status == '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%" AND status = "'.$status.'"';
			}
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Starline Games All Bhav Start =======/////////////////////////////////////////////////////

		public function loadDataSLAB($tableName='', $bazarName='', $gameName='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT $tableName.id, starline_bazar.bazar_name, starline_game_type.game_name, $tableName.rate FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON $tableName.game_name = starline_game_type.id";
			if($bazarName != '' && $gameName == '')	{
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameName != '')	{
				$sql .= ' WHERE starline_game_type.game_name LIKE "%'.$gameName.'%"';
			}else if($bazarName != '' && $gameName != '')	{
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND starline_game_type.game_name LIKE "%'.$gameName.'%"';
			}
			$sql .= " Limit $offset, $record_per_page";
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}
 
		public function countRecordSLAB($tableName, $bazarName='', $gameName=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			if($bazarName != '' && $gameName == '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameName != '')	{
				$sql .= ' INNER JOIN starline_game_type ON '.$tableName.'.game_name = starline_game_type.id WHERE starline_game_type.game_name LIKE "%'.$gameName.'%"';
			}else if($bazarName != '' && $gameName != '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON '.$tableName.'.game_name = starline_game_type.id WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND starline_game_type.game_name LIKE "%'.$gameName.'%"';
			}
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Starline Games All Result Start =======/////////////////////////////////////////////////////

		public function loadDataSLAL($tableName='', $bazarName='', $resultDate='', $offset=0,  $record_per_page=10)	{
			
			$sql = "SELECT $tableName.id, starline_bazar.bazar_name, $tableName.time, starline_bazar_time.time as bazar_time, $tableName.result_date, $tableName.result_patti, $tableName.result_akda FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_time.id = $tableName.time";
			if($bazarName != '' && $resultDate == '')	{
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $resultDate != '')	{
				$sql .= ' WHERE '.$tableName.'.result_date = "'.$resultDate.'"';
			}else if($bazarName != '' && $resultDate != '')	{
				$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = "'.$resultDate.'"';
			}
			$sql .= " ORDER BY $tableName.id DESC";
			$sql .= " Limit $offset, $record_per_page";

			// echo $sql;die();
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}

		// public function loadDataSLAL($tableName='', $bazarName='', $resultDate='', $offset=0,  $record_per_page=10)	{
			
		// 	$sql = "SELECT $tableName.id, starline_bazar.bazar_name, $tableName.time, $tableName.result_date, $tableName.result_patti, $tableName.result_akda FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id";
		// 	if($bazarName != '' && $resultDate == '')	{
		// 		$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
		// 	}else if($bazarName == '' && $resultDate != '')	{
		// 		$sql .= ' WHERE '.$tableName.'.result_date = "'.$resultDate.'"';
		// 	}else if($bazarName != '' && $resultDate != '')	{
		// 		$sql .= ' WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = "'.$resultDate.'"';
		// 	}
		// 	$sql .= " ORDER BY $tableName.id DESC";
		// 	$sql .= " Limit $offset, $record_per_page";

			// echo $sql;die();
		// 	$rr = $this->db->query($sql)->result_array();
		// 	return $rr;
		// }

		public function countRecordSLAL($tableName, $bazarName='', $resultDate=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			if($bazarName != '' && $resultDate == '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $resultDate != '')	{
				$sql .= ' WHERE '.$tableName.'.result_date = "'.$resultDate.'"';
			}else if($bazarName != '' && $resultDate != '')	{
				$sql .= ' INNER JOIN starline_bazar ON '.$tableName.'.bazar_name = starline_bazar.id  WHERE starline_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = "'.$resultDate.'"';
			}
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== Starline Games Game Type List Start =======/////////////////////////////////////////////////////

		public function loadDataSLGTL($tableName='', $gameName='', $status='', $offset=0,  $record_per_page=10)	{ 
			$sql = "SELECT $tableName.id, $tableName.game_name, $tableName.priority, $tableName.status FROM $tableName";
			 
			 
			if($gameName != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.game_name Like "%'.$gameName.'%"';
			}else if($gameName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';
			}else if($gameName != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';
			} 
			$sql .= " Limit $offset, $record_per_page";
			  
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}

		public function countRecordSLGTL($tableName,  $gameName='', $status=''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName";
			if($gameName != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.game_name Like "%'.$gameName.'%"';
			}else if($gameName == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status = "'.$status.'"';
			}else if($gameName != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.game_name LIKE "%'.$gameName.'%" AND '.$tableName.'.status = "'.$status.'"';
			} 

			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total']; 
			// $rr = $this->db->query($sql)->result_array();
			// return $rr[0]['total'];  
		}

///////////////////////////////////////====== King Bazar Games Start =======/////////////////////////////////////////////////////

		public function loadDataKB($tableName='', $bazarName='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT id, bazar_name, time, status FROM $tableName";
			if($bazarName != '' && $status == '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%" AND status = "'.$status.'"';
			}
			$sql .= " Limit $offset, $record_per_page";
		
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}

		public function countRecordKB($tableName, $bazarName ='', $status =''){
			$sql = "SELECT count('id') as total FROM $tableName";
			if($bazarName != '' && $status == '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $status != '')	{
				$sql .= ' WHERE status = "'.$status.'"';
			}else if($bazarName != '' && $status != '')	{
				$sql .= ' WHERE bazar_name LIKE "%'.$bazarName.'%" AND status = "'.$status.'"';
			}
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

///////////////////////////////////////====== King Bazar Games Start =======/////////////////////////////////////////////////////

		public function loadDataKBBL($tableName='', $bazarName='', $gameType='', $status='', $offset=0,  $record_per_page=10)	{
			$sql = "SELECT $tableName.id, king_bazar.bazar_name, $tableName.game_type, $tableName.rate, $tableName.status FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";
			if($bazarName != '' && $gameType == '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameType != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.game_type = "'.$gameType.'"';
			}else if($bazarName == '' && $gameType == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status  = "'.$status.'"';
			}else if($bazarName != '' && $gameType != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.game_type = "'.$gameType.'"';
			}else if($bazarName != '' &&  $gameType == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
			}else if($bazarName == '' &&  $gameType != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'game_type = "'.$gameType.'" AND status = "'.$status.'"';
			}else if($bazarName != '' &&  $gameType != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.game_type = '.$gameType.' AND '.$tableName.'.status = "'.$status.'"';
			}
			$sql .= " Limit $offset, $record_per_page";
			// print_r($sql);
			// die();
			$rr = $this->db->query($sql)->result_array();
			return $rr;
		}

		public function countRecordKBBL($tableName, $bazarName ='', $gameType='', $status =''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";
			if($bazarName != '' && $gameType == '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $gameType != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.game_type = "'.$gameType.'"';
			}else if($bazarName == '' && $gameType == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status  = "'.$status.'"';
			}else if($bazarName != '' && $gameType != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.game_type = "'.$gameType.'"';
			}else if($bazarName != '' &&  $gameType == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
			}else if($bazarName == '' &&  $gameType != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'game_type = "'.$gameType.'" AND status = "'.$status.'"';
			}else if($bazarName != '' &&  $gameType != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.game_type = '.$gameType.' AND '.$tableName.'.status = "'.$status.'"';
			}
			 
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

	 

	///////////////////////////////////====== King Bazar All Result Start =======////////////////////////////////////////////

		public function loadDataKBAR($tableName='', $bazarName='', $resultDate='', $status='', $offset=0,  $record_per_page=10)	{
				 
			$sql = "SELECT $tableName.id, king_bazar.bazar_name, $tableName.result, $tableName.result_date, $tableName.status FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";
			if($bazarName != '' && $resultDate == '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%"';
				print_r("Only bazarname");
			}else if($bazarName == '' && $resultDate != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.result_date = "'.$resultDate.'"';
				print_r("Only resultdate");
			}else if($bazarName == '' && $resultDate == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status  = "'.$status.'"';
				print_r("Only status");
			}else if($bazarName != '' && $resultDate != '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = "'.$resultDate.'"';
				print_r("bazarname and resultdate");
			}else if($bazarName != '' &&  $resultDate == '' && $status != '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
				print_r("bazarname and status");
			}else if($bazarName == '' &&  $resultDate != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'result_date = "'.$resultDate.'" AND status = "'.$status.'"';
				print_r("resultdate and status");
			}else if($bazarName != '' &&  $resultDate != '' && $status != '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date == '.$resultDate.' AND '.$tableName.'.status = "'.$status.'"';
				print_r("bazarname, resultdate and status");
			}
			$sql .= " Limit $offset, $record_per_page";
			$rr = $this->db->query($sql)->result_array();
			// print_r("<pre>");
			// print_r("Data is ".$rr);
			// print_r("</pre>");
			// die();
			return $rr;
		}

		public function countRecordKBAR($tableName, $bazarName ='', $gameType='', $status =''){
			$sql = "SELECT count('$tableName.id') as total FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";
			 
			 if($bazarName != '' && $resultDate == '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%"';
			}else if($bazarName == '' && $resultDate != '' && $status == '')	{
				$sql .= ' WHERE '.$tableName.'.result_date = "'.$resultDate.'"';
			}else if($bazarName == '' && $resultDate == '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'.status  = "'.$status.'"';
			}else if($bazarName != '' && $resultDate != '' && $status == '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = "'.$resultDate.'"';
			}else if($bazarName != '' &&  $resultDate == '' && $status != '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.status = "'.$status.'"';
			}else if($bazarName == '' &&  $resultDate != '' && $status != '')	{
				$sql .= ' WHERE '.$tableName.'result_date = "'.$resultDate.'" AND status = "'.$status.'"';
			}else if($bazarName != '' &&  $resultDate != '' && $status != '')	{
				$sql .= ' WHERE king_bazar.bazar_name LIKE "%'.$bazarName.'%" AND '.$tableName.'.result_date = '.$resultDate.' AND '.$tableName.'.status = "'.$status.'"';
			}
			 
			$rr = $this->db->query($sql)->result_array();
			return $rr[0]['total'];  
		}

	}

 



?>