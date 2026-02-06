<?php
	Class ClientData_Model extends CI_Model {
	 

    ///////////////////////////////////////====== Regular Bazar Start =======/////////////////////////////////////////////////////

        public function loadDataRB($tableName, $fields, $offset=0,  $record_per_page=5)	{

            $sql = "SELECT $tableName.id, $tableName.transaction_id,  $tableName.customer_id, regular_bazar.bazar_name, regular_game_type.game_name, $tableName.game_type, $tableName.result_date, $tableName.game, $tableName.point, $tableName.status FROM $tableName INNER JOIN regular_bazar ON $tableName.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON $tableName.game_name = regular_game_type.id";

		   
            $nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}
			if(!empty($nonEmptyFields))	{
				 
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}

					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }
					 else if($key == 'bazarName')	{
					 	$sql .= ' regular_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' regular_game_type.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'gameType') {
					 	$sql .= ' '.$tableName.'.game_type LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }

			     
			}
		   $sql .= ' ORDER BY '.$tableName.'.id DESC';
		   $sql .= " Limit $offset, $record_per_page";

		   

           $rr = $this->db->query($sql)->result_array();
           return $rr;
        }

		public function countRecordRB($tableName, $fields){
			$sql = "SELECT count('$tableName.id') as total  FROM $tableName INNER JOIN regular_bazar ON $tableName.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON $tableName.game_name = regular_game_type.id";
			 
			$nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}

			if(!empty($nonEmptyFields))	{
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}
					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }
					 else if($key == 'bazarName')	{
					 	$sql .= ' regular_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' regular_game_type.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'gameType') {
					 	$sql .= ' '.$tableName.'.game_type LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }
			}


			$rr = $this->db->query($sql)->result_array();
            return $rr[0]['total']; 

            return $rr;
		}

		public function loadDataSB($tableName, $fields, $offset=0,  $record_per_page=5)	{

            $sql = "SELECT $tableName.id, $tableName.transaction_id,  $tableName.customer_id, starline_bazar.bazar_name, starline_game_type.game_name, $tableName.result_date, $tableName.game, $tableName.point, $tableName.status FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON $tableName.game_name = starline_game_type.id";

		   
            $nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}
			if(!empty($nonEmptyFields))	{
				 
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}

					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }
					 else if($key == 'bazarName')	{
					 	$sql .= ' starline_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' starline_game_type.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }

			     
			}
			$sql .= ' ORDER BY '.$tableName.'.id DESC';
		   $sql .= " Limit $offset, $record_per_page";
           $rr = $this->db->query($sql)->result_array();
           return $rr;
        }

		public function countRecordSB($tableName, $fields){
			$sql = "SELECT count('$tableName.id') as total  FROM $tableName INNER JOIN starline_bazar ON $tableName.bazar_name = starline_bazar.id INNER JOIN starline_game_type ON $tableName.game_name = starline_game_type.id";
			 
			$nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}

			if(!empty($nonEmptyFields))	{
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}
					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }
					 else if($key == 'bazarName')	{
					 	$sql .= ' starline_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' starline_game_type.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'gameType') {
					 	$sql .= ' '.$tableName.'.game_type LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }
			}

			 
			$rr = $this->db->query($sql)->result_array();
            return $rr[0]['total']; 

            return $rr;
		}

		public function loadDataKB($tableName, $fields, $offset=0,  $record_per_page=5)	{

            $sql = "SELECT $tableName.id, $tableName.transaction_id,  $tableName.customer_id, king_bazar.bazar_name, $tableName.game_name, $tableName.result_date, $tableName.game, $tableName.point, $tableName.status FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";

            $nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}
			if(!empty($nonEmptyFields))	{
				 
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}
					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }
					 else if($key == 'bazarName')	{
					 	$sql .= ' king_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' '.$tableName.'.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }	     
			}

		   $sql .= ' ORDER BY '.$tableName.'.id DESC';
		   $sql .= " Limit $offset, $record_per_page";
           $rr = $this->db->query($sql)->result_array();
           return $rr;
        }

		public function countRecordKB($tableName, $fields){
			$sql = "SELECT count('$tableName.id') as total  FROM $tableName INNER JOIN king_bazar ON $tableName.bazar_name = king_bazar.id";
			 
			$nonEmptyFields = array();
			if(!empty($fields)){
				foreach ($fields as $key => $value) {
					if($fields[$key] != '' || $fields[$key] != null )	{
					 	$nonEmptyFields[$key] = $value;
					}	 
			    }
			}

			if(!empty($nonEmptyFields))	{
				$sql .= ' WHERE ';
				$flag = 0;
				foreach ($nonEmptyFields as $key => $value) {
					if($flag ==1)	{
						$sql .= ' AND ';
					}
					 if($key == 'transactionId') {
					 	$sql .= ' '.$tableName.'.transaction_id LIKE  "%'.$value.'%"';
					 }else if($key == 'customerId') {
					 	$sql .= ' '.$tableName.'.customer_id LIKE  "%'.$value.'%"';
					 }else if($key == 'bazarName')	{
					 	$sql .= ' king_bazar.bazar_name LIKE  "%'.$value.'%"';
					 }else if($key == 'gameName')	{
					 	$sql .= ' '.$tableName.'.game_name LIKE  "%'.$value.'%"';
					 }else if($key == 'resultDate') {
					 	$sql .= ' '.$tableName.'.result_date LIKE  "%'.$value.'%"';
					 }else if($key == 'status') {
					 	$sql .= ' '.$tableName.'.status LIKE  "%'.$value.'%"';
					 }
					 $flag = 1;
			    }
			}

			$rr = $this->db->query($sql)->result_array();
            return $rr[0]['total']; 

            return $rr;
		}





 ///////////////////////////////////////====== Bazar Names List Start =======//////////////////////////////////

	public function bazarNameList($tableName, $fieldName, $fieldValue)	{
            $sql = "SELECT DISTINCT $tableName.$fieldName FROM $tableName";
            $sql .=' WHERE '.$tableName.'.'.$fieldName.' LIKE  "%'.$fieldValue.'%"';
            $rr = $this->db->query($sql)->result_array();

            return $rr;
        }
	}

 
?>