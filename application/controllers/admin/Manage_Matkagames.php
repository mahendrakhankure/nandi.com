<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

require APPPATH . '/helpers/MCrypt.php';


/**

 * Class : Manage_Matkagames (Manage_Matkagames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class Manage_Matkagames extends BaseController{



	function __construct(){

	    parent::__construct();

	    // if(! $this->session->userdata('adid'))

	    // redirect('admin/login');

	}


	// public function index(){

	//     $this->load->model('ManageMatkagames_Model');

	//      $this->load->library('pagination');

	//     $data['matkagame'] = $this->ManageMatkagames_Model->getmatkagamedetails();

	//     $this->load->view('admin/manage_matkagames',$data);

	// }

	public function index(){
		$tableName = 'regular_bazar';

		$record_per_page = 5;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Matkagames');
		  
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$page = $_POST['page'];
		 
			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
				 print_r("Well done. ");
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*5;
				 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$gameName = '';
		    $gameMode = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0;
			 
		} 
		 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordMG($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Matkagames';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['gameName'] = $gameName;
			$this->data['gameMode'] = $gameMode;
			$this->data['matkagame'] = $this->LoadData_Model->loadDataMG($tableName, $gameName, $gameMode, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 echo '<pre>';
			print_r($this->data);
			die();
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			
			$this->load->view('admin/manage_matkagames', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataMG($tableName, $gameName, $gameMode, $offset, $record_per_page);
			$this->loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $gameMode); 
			  
		}	 
	}
 

	public function searchResult()	{ 
		 $output = '';
		 $record_per_page = 5;
		 $page = 1;
		 $cnName = 'Manage_Matkagames';
		 $cnMethod = 'searchResult';
		 $tableName = $_POST['tableName'];
		 $gameName = $_POST['gameName'];
		 $gameMode = $_POST['gameMode'];
		 $total_records = $_POST['total_records'];
		if(isset($_POST['page']))	{
			$page = $_POST['page'];
		}
		
		$offset =($page-1)*5;
		$this->load->model('LoadData_Model');
		if($offset == 0 || $page == 1)	{
			 $total_records = $this->LoadData_Model->countRecordMG($tableName, $gameName, $gameMode);
		} 
		 
		$data = $this->LoadData_Model->loadDataMG($tableName, $gameName, $gameMode, $offset, $record_per_page);
		 
		$total_pages = ceil($total_records/$record_per_page);
		$this->loadPage($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $gameMode);
	}

	public function loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $gameMode)	{
		$output = '';
		$record_per_page = 5;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game</th>
			<th>Start Time</th>
			<th>End TIme</th>
			<th>Priority</th>
			<th>Days In Week</th>
			<th>Result Mode</th>
			<th class="text-center">Actions</th>
		</tr>';
		//Replaced $tableData by $this->data['matkagame']
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["open_time"].'</td>
					<td>'.$d["close_time"].'</td>
					<td>'.$d["sequence"].'</td>
					<td>'.$d["days"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';
		 
		 
		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
			if($page>1)	{
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMG(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMG(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMG('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMG('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">'.$i.'</span>';	  
  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				//$highest = $page_loaded-1;
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				// $output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="loadpage(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">Next</span>';	
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMG(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		// }
		echo $output;	
		
	}



	public function addNewGame($gameid=''){

			if ($_POST) {
				if ($gameid) {

					$addnewGame = array(

						'games' => $_POST['game_name'] , 

						'start_time' => $_POST['start_time'] , 

						'end_time' => $_POST['end_time'] , 

						'count' => $_POST['game_in_week'] , 

						'priority' => $_POST['priority'] , 

						'result' => $_POST['result_mode'] , 

						// 'created' => date('Y-m-d H:i:s') , 

						'updated' => date('Y-m-d H:i:s') 

					);



					$gameid = AddUpdateTable('games','id',$gameid,$addnewGame);

				}else{

					$addnewGame = array(

						'games' => $_POST['game_name'] , 

						'start_time' => $_POST['start_time'] , 

						'end_time' => $_POST['end_time'] , 

						'count' => $_POST['game_in_week'] , 

						'priority' => $_POST['priority'] , 

						'result' => $_POST['result_mode'] , 

						'created' => date('Y-m-d H:i:s') , 

						'updated' => date('Y-m-d H:i:s') 

					);



					$gameid = AddUpdateTable('games','','',$addnewGame);

				}

					

				if ($gameid > 0) {

					redirect('admin/Manage_Matkagames');

				}

			}



			if ($gameid > 0) {
				$data['onegamedata'] = getRecordById('games','id',$gameid);

			}
		$this->load->view('admin/add_new_game',$data);

	}


	public function deleteGame($gameid=''){

		$returnval = deleteRecord('games', 'id', $gameid);

		if ($returnval > 0) {

			redirect('admin/Manage_Matkagames');

		}

	}
	public function searchResultBL()	{ 
		$output = '';
		$record_per_page = 5;
		$page = 1;
		$cnName = 'Manage_Matkagames';
		$cnMethod = 'searchResultBL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$gameName = $_POST['gameName'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordMGBL($tableName, $bazarName, $gameName);	
	   } 
	   $data = $this->LoadData_Model->loadDataMGBL($tableName, $bazarName, $gameName, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageBL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName);
   	}
	public function loadPageBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName)	{
		$output = '';
		$record_per_page = 5;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Commission</th>
			<th>Rate</th>
			<th class="text-center">Actions</th>
		</tr>';
		//Replaced $tableData by $this->data['matkagame']
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["commission"].'</td>
					<td>'.$d["rate"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
			if($page>1)	{
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 }	 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\')">'.$i.'</span>';
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				//$highest = $page_loaded-1;
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				// $output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="loadpage(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">Next</span>';	
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGBL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}
	public function searchResultGTL()	{ 
		$output = '';
		$record_per_page = 5;
		$page = 1;
		$cnName = 'Manage_Matkagames';
		$cnMethod = 'searchResultGTL';
		$tableName = $_POST['tableName'];
		$gameName = $_POST['gameName'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordMGGTL($tableName, $gameName, $status);	
	   } 
	   $data = $this->LoadData_Model->loadDataMGGTL($tableName, $gameName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageGTL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status);
   	}
	public function loadPageGTL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status)	{
		$output = '';
		$record_per_page = 5;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game Name</th>
			<th>Sequence</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		//Replaced $tableData by $this->data['matkagame']
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["sequence"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
			if($page>1)	{
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGGTL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					print_r("I am called");
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGGTL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }	 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGGTL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGGTL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\')">'.$i.'</span>';
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				//$highest = $page_loaded-1;
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				// $output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="loadpage(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">Next</span>';	
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGGTL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function AllotBazarGamesList(){
		$tableName = "allot_regular_bazar_game";
		$record_per_page = 5;
		$cnMethod = trim('AllotBazarGamesList');
		$cnName = trim('Manage_Matkagames');
		 
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$page = $_POST['page'];
			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*5;
				 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$bazarName = '';
		    $gameName = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		} 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordMGABGL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Matkagames';
			$this->data['controllerFunction'] = 'AllotBazarGamesList';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['gameName'] = $gameName;
			$this->data['status'] = $status;
			$this->data['matkagameabgl'] = $this->LoadData_Model->loadDataMGABGL($tableName,$bazarName, $gameName, $status, $offset=0, $record_per_page); 
		}
		 
		$total_pages = ceil($total_records/$record_per_page);
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/AllotBazarGamesList', $this->data);
		}else { 	 
			$tableData = $this->LoadData_Model->loadDataMGABGL($tableName,$bazarName, $gameName, $status, $offset, $record_per_page);
			$this->loadPageABGL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName, $status);   
		}
    }

	public function searchResultABGL()	{ 
		$output = '';
		$record_per_page = 5;
		$page = 1;
		$cnName = 'Manage_Matkagames';
		$cnMethod = 'searchResultABGL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$gameName = $_POST['gameName'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordMGABGL($tableName, $bazarName, $gameName, $status);
			print_r($total_pages);
		} 
	   $data = $this->LoadData_Model->loadDataMGABGL($tableName, $bazarName, $gameName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageABGL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName, $status);
   	}
	public function loadPageABGL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName, $status)	{
		$output = '';
		$record_per_page = 5;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Sequence</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		//Replaced $tableData by $this->data['matkagame']
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["sequence"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
			if($page>1)	{
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGABGL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					 
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGABGL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }	 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGABGL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMGABGL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\')">'.$i.'</span>';
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				//$highest = $page_loaded-1;
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				// $output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="loadpage(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">Next</span>';	
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGABGL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}



	public function regularMarketBetList(){
		$Common_model = $this->load->model('Common_model');
		$this->data['clientAll']=$this->Common_model->getData('client',' WHERE status="A"','id,client_name','','','','','');
		$this->data['bazarAll']=$this->Common_model->getData('regular_bazar',' WHERE status="A"','id,bazar_name','','','','open_time ASC','');
		$this->data['gamesAll']=$this->Common_model->getData('regular_game_type',' WHERE status="A"','id,game_name','','','','sequence ASC','');
		$this->load->view('admin/regularMarketBetList', $this->data);
	}

	public function dataRegular(){
		$postData = $this->input->post();
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getRegularData($postData);
	    echo json_encode($data);
	}

	public function starlineMarketBetRecords(){
		$Common_model = $this->load->model('Common_model');
		$this->data['clientAll']=$this->Common_model->getData('client',' WHERE status="A"','id,client_name','','','','','');
		$this->data['bazarAll']=$this->Common_model->getData('starline_bazar',' WHERE status="A"','id,bazar_name','','','','id ASC','');
		$this->data['gamesAll']=$this->Common_model->getData('starline_game_type',' WHERE status="A"','id,game_name','','','','priority ASC','');
		$this->data['timeAll']=$this->Common_model->getData('starline_bazar_time',' WHERE status="A"','id,time','','','','time ASC','');
		$this->load->view('admin/starlineMarketBetRecords', $this->data);
	}

	public function dataStarline(){
		$postData = $this->input->post();
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getStarlineData($postData);
	    echo json_encode($data);
	}

	public function kingMarketBetRecords(){
		$Common_model = $this->load->model('Common_model');
		$this->data['clientAll']=$this->Common_model->getData('client',' WHERE status="A"','id,client_name','','','','','');
		$this->data['bazarAll']=$this->Common_model->getData('king_bazar',' WHERE status="A"','id,bazar_name','','','','time ASC','');
		$this->load->view('admin/kingMarketBetRecords', $this->data);
	}

	public function dataKing(){
		$postData = $this->input->post();
		$postData['order'][0]['column']=8;
		$postData['order'][0]['dir']='desc';
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getKingData($postData);
	    echo json_encode($data);
	}


	public function voidBet(){
		$Common_model = $this->load->model('Common_model');
		$addResult['status']='V';
		$addResult['winning_in_rs']='0';
		$addResult['commission_in_rs']='0';
		$addResult['winning_point']='0';
		$addResult['commission']='0';
		$addResult['updated_by']=$_SESSION['adid']['id'];
		if(isset($_POST['data'])){
			$i=0;
			foreach ($_POST['data'] as $Id) {
				
				$trId = $Id['transaction_id'];
				$addUpdate = AddUpdateTable($_POST['table'], 'transaction_id', $trId, $addResult);
				// echo "<pre>".$trId;
				// print_r($addResult);
				// die();
				if($addUpdate){
					$tbl = $_POST['table'].'.partner_id=client.id ';
					$c1 = ' WHERE '.$_POST['table'].'.transaction_id="'.$trId.'"';
					$con = ' INNER JOIN client ON '.$tbl.$c1;
					
					$c=$this->Common_model->getData($_POST['table'],$con,'client.end_point_url','','','One','','');
					
					$customerId=$this->Common_model->getData($_POST['table'],' WHERE transaction_id="'.$trId.'"','customer_id','','','One','','');
					// $_POST['data']['customer_id'] = '';
					
					// array_push($_POST['data'][$i]['customer_id'], $customerId);
					$_POST['data'][$i] += ['customer_id' => $customerId['customer_id']];
					
					$arr['data']=$_POST['data'];
					$cArr['arr'] = json_encode($arr);
		            $cArr['code']='801';
		            if($_POST['table']=='regular_bazar_games'){
			          $tbl='Regular Bazar';
					  $cArr['market_code']='301';
			        }else if($_POST['table']=='king_bazar_game'){
			          $tbl='King Bazar';
					  $cArr['market_code']='501';
			        }else if($_POST['table']=='starline_bazar_game'){
			          $tbl='Starline Bazar';
					  $cArr['market_code']='401';
			        }else if($_POST['table']=='instant_worli_game' || $_POST['table']=='warli_users_game'){
			          $tbl='Instant Worli';
					  $cArr['market_code']='701';
			        }
		            $cArr['market']=$tbl;
					
		            $void = requestForClient($c['end_point_url'],$cArr);
					// echo "<pre>123";
					// print_r($void);
					// die();
		            $i++;
				}
			}
		}else if(isset($_POST['market'])){

			if($_POST['table']=='regular_bazar_games'){
	          $tbl='regular_bazar_result';
	          if($_POST['marketType']=='Open' || $_POST['marketType']=='open'){
	          	$ty = " AND game_type='Open'";
	          }else if($_POST['marketType']=='Close' || $_POST['marketType']=='close'){
	          	$ty = " AND game_type!='Open'";
	          }else if($_POST['marketType']=='Both' || $_POST['marketType']=='both'){
	          	$ty = "";
	          }
	          $mar = 'Regular Bazar';
			  $cArr['market_code']='301';
	        }else if($_POST['table']=='king_bazar_game'){
	          $tbl='king_bazar_result';
	          $mar = 'King Bazar';
			  $cArr['market_code']='501';
	        }else if($_POST['table']=='starline_bazar_game'){
	          $mar = 'Starline Bazar';
	          $tbl='starline_bazar_result';
			  $cArr['market_code']='401';
	        }else if($_POST['table']=='instant_worli_game' || $_POST['table']=='warli_users_game'){
	          $mar = 'Instant Worli';
	          $tbl='Instant Worli';
			  $cArr['market_code']='701';
	        }
	        $bazarResult = $this->Common_model->getData($tbl,' WHERE id="'.$_POST['bazar_id'].'"','','','','One','','');
	        $addR['status'] = 'V';
	        $updateR = AddUpdateTable($_POST['table'], 'transaction_id', $trId, $addR);
	        if($_POST['table']=='regular_bazar_games'){
	        	$con1=" WHERE result_date='".$bazarResult['result_date']."' AND status!='V' AND bazar_name='".$bazarResult['bazar_name']."'".$type;
	        }else{
	        	$con1=" WHERE result_date='".$bazarResult['result_date']."' AND status!='V' AND bazar_name='".$bazarResult['bazar_name']."'";
	        }
	        $bets = $this->Common_model->getData($_POST['table'],$con1,'transaction_id,customer_id','','','','','');

	       
			foreach ($bets as $Id) {
				$trId = $Id['transaction_id'];
				$addUpdate = AddUpdateTable($_POST['table'], 'transaction_id', $trId, $addResult);
			}
			$arrLossPartner = $this->Common_model->getData('client','','id,end_point_url','','','','','');
		        
            foreach($arrLossPartner as $l){
                if($_POST['table']=='regular_bazar_games'){
		        	$con2=" WHERE result_date='".$bazarResult['result_date']."' AND bazar_name='".$bazarResult['bazar_name']."' AND partner_id='".$l['id']."'".$type;
		        }else{
		        	$con2=" WHERE result_date='".$bazarResult['result_date']."' AND bazar_name='".$bazarResult['bazar_name']."' AND partner_id='".$l['id']."'";
		        }
				$c['data']=$this->Common_model->getData($_POST['table'],$con2,'transaction_id,customer_id','','','','','');

				if(!empty($c['data'])){
					$arr['data']=$c['data'];
					$cArr['arr'] = json_encode($arr);
		            $cArr['code']='801';
		            $cArr['market']=$mar;
		            $void = requestForClient($l['end_point_url'],$cArr);
				}
            }	
		}
		die(json_encode(['status'=>200,'massage'=>'Bet Void Successfully.']));
	}

	public function worliMarketBetRecords(){
		$this->load->view('admin/worliMarketBetRecords');
	}

	public function dataWorli(){
		$postData = $this->input->post();
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getWorliData($postData);
	    echo json_encode($data);
	}

	public function regularMarketResultRecords(){
		$Common_model = $this->load->model('Common_model');
		$this->data['bazarAll']=$this->Common_model->getData('regular_bazar',' WHERE status="A"','id,bazar_name','','','','open_time ASC','');
		$this->load->view('admin/regularMarketResultRecords', $this->data);
	}

	public function dataRegularResult(){
		$postData = $this->input->post();
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getRegularDataResult($postData);
	    echo json_encode($data);
	}

	public function kingMarketResultRecords(){
		$Common_model = $this->load->model('Common_model');
		$this->data['bazarAll']=$this->Common_model->getData('king_bazar',' WHERE status="A"','id,bazar_name','','','','time ASC','');
		$this->load->view('admin/kingMarketResultRecords', $this->data);
	}

	public function dataKingResult(){
		$postData = $this->input->post();
		$postData['order'][0]['column']=4;
		$postData['order'][0]['dir']='desc';
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getKingDataResult($postData);
	    echo json_encode($data);
	}

	public function starlineMarketResultRecords(){
		$Common_model = $this->load->model('Common_model');
		$this->data['bazarAll']=$this->Common_model->getData('starline_bazar',' WHERE status="A"','id,bazar_name','','','','id ASC','');
		$this->data['gamesAll']=$this->Common_model->getData('starline_game_type',' WHERE status="A"','id,game_name','','','','priority ASC','');
		$this->data['timeAll']=$this->Common_model->getData('starline_bazar_time',' WHERE status="A"','id,time','','','','time ASC','');
		$this->load->view('admin/starlineMarketResultRecords', $this->data);
	}

	public function dataStarlineResult(){
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getStarlineDataResult($postData);
	    echo json_encode($data);
	}



	public function getStrimingResult(){
        if($_POST){
        	if(empty($_POST['token'])){
        		$this->session->set_flashdata('error', 'Please Select The Token');
        		redirect('f4993364a3d838b4174d4a40bd82604f');
        	}
			$getResult = getStrimingResult($_POST['token']);
			
			$res = json_decode($getResult);
			if($res){
	    		$this->load->model('Common_model');
				if($_POST['market']=='regular' && $getResult){
		    		if($_POST['optradio']=='Open'){
		    			$con = ' WHERE token_open="'.$_POST['token'].'"';
						$data = $this->Common_model->getData('regular_bazar_result',$con,'id','','','One','','');
						$a=$res->result.'';
						$ak=(int)$a[0]+(int)$a[1]+(int)$a[2];
						
						if($ak>9){
							$akda=abs($ak % 10);
						}else{
							$akda=$ak;
						}
						$arr['open']=$res->result;
						$arr['jodi']=$akda;
		    		}else if($_POST['optradio']=='Close'){
		    			$con = ' WHERE token_close="'.$_POST['token'].'"';
						$data = $this->Common_model->getData('regular_bazar_result',$con,'id,jodi','','','One','','');
						$a=$res->result.'';
						$ak=(int)$a[0]+(int)$a[1]+(int)$a[2];
						if($ak>9){
							$akda=abs($ak % 10);
						}else{
							$akda=$ak;
						}
						$arr['close']=$res->result;
						$arr['jodi']=$data['jodi'].$akda;
		    		}
		    		$table = 'regular_bazar_result';
					// echo '<pre>';
					// print_r($data);
					// print_r($arr);
					// die();
	        	}else if($_POST['market']=='starline' && $getResult){
	        		$con = ' WHERE token="'.$_POST['token'].'"';
					$data = $this->Common_model->getData('starline_bazar_result',$con,'id','','','One','','');
					$a=$res->result.'';
					$ak=$a[0]+$a[1]+$a[2];
					
					if($ak>9){
						$akda=abs($ak % 10);
					}else{
						$akda=$ak;
					}
					$arr['result_patti']=$res->result;
					$arr['result_akda']=$akda;
					$table = 'starline_bazar_result';
	        	}else if($_POST['market']=='king' && $getResult){
	        		$con = ' WHERE token="'.$_POST['token'].'"';
					$data = $this->Common_model->getData('king_bazar_result',$con,'id','','','One','','');
					$arr['result']=$res->result;
					$table = 'king_bazar_result';
	        	}
				$arr['status']='A';
	        	$gameaddid = AddUpdateTable($table, 'id', $data['id'], $arr);
	        	if($gameaddid){
	        		$this->session->set_flashdata('success', 'Result Added Successfully!');
        			redirect('f4993364a3d838b4174d4a40bd82604f');
	        	}
			}else{
				$this->session->set_flashdata('error', 'Result Not Available');
        		redirect('f4993364a3d838b4174d4a40bd82604f');
			}
        }
	    $this->load->view('admin/getStrimingResult');

	}
	public function instantWorliBhavList(){
	    $this->load->view('admin/instantWorliBhav');
	}
	public function instantWorliBhavData(){
	    $postData = $this->input->post();
	    $postData['length']='25';
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getInstantWorliBhav($postData);
	    echo json_encode($data);
	}
	    
	public function updateWorliBhav(){
	    if($_POST){
	    	$arr['bhav']=$_POST['bhav'];
			$arr['updated_by'] = $_SESSION['adid']['id'];
	    	$bhav = AddUpdateTable('warli_bhav', 'id', $_POST['id'], $arr);
	    	if($bhav){
	    		$this->load->model('Common_model');
	    		$lstAct['entry_table'] = 'Instant Worli Bhav';
				$lstAct['supportId'] = $_SESSION['adid']['id'];
				$lstAct['created'] = date('Y-m-d H:i:s');
				$conLst=' WHERE id="'.$_POST['id'].'"';
				$feildsLst='bhav,game_name';
				$lst = $this->Common_model->getData('warli_bhav',$conLst,$feildsLst,'','','One','','');
				$lstAct['detail'] = implode(', ',$lst);
				AddUpdateTable('lastActivity','','',$lstAct);
	    		die(json_encode(['status'=>200,'massage'=>'Bhav Updated Successfully!']));
	    	}else{
	    		die(json_encode(['status'=>400,'massage'=>'Somthing Went Wrong!']));
	    	}
	    }
	}

	public function instantWorliResultList(){
		if($this->input->post()){
			$postData = $this->input->post();
		    $postData['order'][0]['column']=1;
			$postData['order'][0]['dir']='desc';
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getInstantWorliResultList($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/instantWorliResultList');
		}
	}



	public function resetalmentBets(){
        if($_POST){

        	if(empty($_POST['token'])){
        		$this->session->set_flashdata('error', 'Please Select The Token');
        		redirect('70fed1623f9897a31ac8a6e50023cc58');
        	}
        	$this->load->model('Common_model');
			if($_POST['market']=='regular'){
	    		if($_POST['optradio']=='Open'){
	    			$type=" AND game_type='Open'";
	    			$con = ' WHERE token_open="'.$_POST['token'].'"';
					$data = $this->Common_model->getData('regular_bazar_result',$con,'id,result_date,bazar_name','','','One','','');
	    		}else if($_POST['optradio']=='Close'){
	    			$type=" AND game_type!='Open'";
	    			$con = ' WHERE token_close="'.$_POST['token'].'"';
					$data = $this->Common_model->getData('regular_bazar_result',$con,'id,result_date,bazar_name','','','One','','');
	    		}
	    		$table = 'regular_bazar_games';
	    		$arrReq['market']='Regular Bazar';
				$arrReq['market_code']='301';
        	}else if($_POST['market']=='starline'){
        		$con = ' INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id WHERE token="'.$_POST['token'].'"';
				$data = $this->Common_model->getData('starline_bazar_result',$con,'starline_bazar_result.id,starline_bazar_result.result_date,starline_bazar_time.time as timeId,starline_bazar_result.bazar_name,starline_bazar_result.time as t','','','One','','');
				$table = 'starline_bazar_game';
	    		$arrReq['market']='Starline Bazar';
	    		$type=" AND time='".$data['t']."'";
				$arrReq['market_code']='401';
        	}else if($_POST['market']=='king'){
        		$con = ' WHERE token="'.$_POST['token'].'"';
				$data = $this->Common_model->getData('king_bazar_result',$con,'id,result_date,bazar_name','','','One','','');
				$table = 'king_bazar_game';
	    		$arrReq['market']='King Bazar';
	    		$type="";
				$arrReq['market_code']='501';
        	}
        	if($data){
                $arrLoss = $this->Common_model->getData('client',' WHERE status="A"','end_point_url,id','','','','','');
                foreach($arrLoss as $l){
                    $con=" WHERE result_date='".$data['result_date']."' AND partner_id='".$l['id']."' AND bazar_name='".$data['bazar_name']."'".$type;
                    if($l['id']=='2'){
	                    $con.=" AND status='W'";
                        $arrReq['result_date']=$data['result_date'];
                        $arrReq['bazar_id']=$data['bazar_name'];
                    	if($_POST['market']=='regular'){
	                        $arrReq['type']=$type;
	                    }else if($_POST['market']=='starline'){
                            $arrReq['time']=$data['timeId'];
	                    }
                    }else{
                    	$con.=" AND status!='P'";
                    }
                    $arrLossBet = $this->Common_model->getData($table,$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
                    $arrReq['code']='601';
                    $arrReq['rec']=json_encode($arrLossBet);
            //         if($l['id']=='2'){
            //         	echo '<pre>';
			        	// print_r($arrReq);
			        	// die();
            //         }
                    $req = requestForClient($l['end_point_url'],$arrReq);
                }
	        	if($gameaddid){
	        		$this->session->set_flashdata('success', 'Result Added Successfully!');
        			redirect('70fed1623f9897a31ac8a6e50023cc58');
	        	}
			}else{
				$this->session->set_flashdata('error', 'Result Not Available');
        		redirect('70fed1623f9897a31ac8a6e50023cc58');
			}
        }
	    $this->load->view('admin/resetalmentBets');

	}


	public function bazarBackBusiness(){
		$Common_model = $this->load->model('Common_model');
		if($_POST){
			$arr=[];
			$arr['sAkda']['point'] = 0;
			$arr['sAkda']['id'] = 0;
			$arr['sAkda']['win'] = 0;
			$arr['sAkda']['com'] = 0;

			$arr['spatti']['point'] = 0;
			$arr['spatti']['id'] = 0;
			$arr['spatti']['win'] = 0;
			$arr['spatti']['com'] = 0;

			$arr['dpatti']['point'] = 0;
			$arr['dpatti']['id'] = 0;
			$arr['dpatti']['win'] = 0;
			$arr['dpatti']['com'] = 0;

			$arr['tpatti']['point'] = 0;
			$arr['tpatti']['id'] = 0;
			$arr['tpatti']['win'] = 0;
			$arr['tpatti']['com'] = 0;

			$arr['jodi']['point'] = 0;
			$arr['jodi']['id'] = 0;
			$arr['jodi']['win'] = 0;
			$arr['jodi']['com'] = 0;

			
			$date = explode(' - ', $_POST['date']);
			if(!empty($_POST['bazar'])){
				$bazar = ' AND bazar_name IN ('.implode(",", $_POST['bazar']).')';
			}else{
				$bazar = '';
			}

			if(!empty($_POST['client'])){
				$bazar .= ' AND partner_id IN ('.implode(",", $_POST['client']).')';
			}

			if($_POST['mar']=='1'){
				// $feilds = 'SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com,game_name';
				$feilds = 'SUM(point_in_rs) as point,COUNT(id) as id,SUM(winning_in_rs) as win, SUM(commission_in_rs) as com,game_name';
				$con = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" AND "'.date('Y-m-d',strtotime($date[1])).'"'.$bazar;
				$b=$this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','','game_name');
				$at = array_column($b, 'game_name');
				$sP=["1","7","12","15","16","18","19","20","24","25","26","27","28","29","30","31","32","33"];
				$dP=["2","13","34","36","39","40","41","43","46"];
				$tP=["4","35","42","45","47","48"];
				$jP=["6","10","11","14","17","22","23"];
				$sangam=["50","51"];
				foreach ($at as $t) {
		        	$k = array_search($t, $at);
		        	if($t=='5'){
		        		$arr['sAkda']['point'] += $b[$k]['point'];
						$arr['sAkda']['id'] += $b[$k]['id'];
						$arr['sAkda']['win'] += $b[$k]['win'];
						$arr['sAkda']['com'] += $b[$k]['com'];
					}else if(in_array($t, $sP)){
						$arr['spatti']['point'] += $b[$k]['point'];
						$arr['spatti']['id'] += $b[$k]['id'];
						$arr['spatti']['win'] += $b[$k]['win'];
						$arr['spatti']['com'] += $b[$k]['com'];
					}else if(in_array($t, $dP)){
						$arr['dpatti']['point'] += $b[$k]['point'];
						$arr['dpatti']['id'] += $b[$k]['id'];
						$arr['dpatti']['win'] += $b[$k]['win'];
						$arr['dpatti']['com'] += $b[$k]['com'];
					}else if(in_array($t, $tP)){
						$arr['tpatti']['point'] += $b[$k]['point'];
						$arr['tpatti']['id'] += $b[$k]['id'];
						$arr['tpatti']['win'] += $b[$k]['win'];
						$arr['tpatti']['com'] += $b[$k]['com'];
					}else if(in_array($t, $jP)){
						$arr['jodi']['point'] += $b[$k]['point'];
						$arr['jodi']['id'] += $b[$k]['id'];
						$arr['jodi']['win'] += $b[$k]['win'];
						$arr['jodi']['com'] += $b[$k]['com'];
					}else if(in_array($t, $sangam)){
						$arr['sangam']['point'] += $b[$k]['point'];
						$arr['sangam']['id'] += $b[$k]['id'];
						$arr['sangam']['win'] += $b[$k]['win'];
						$arr['sangam']['com'] += $b[$k]['com'];
					}
		        }
				die(json_encode($arr));
			}else if($_POST['mar']=='2'){
				$feilds = 'SUM(point_in_rs) as point,COUNT(id) as id,SUM(winning_in_rs) as win, SUM(commission_in_rs) as com,game_name';
				// $feilds = 'SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com,game_name';
				$con = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" AND "'.date('Y-m-d',strtotime($date[1])).'"'.$bazar;
				$b=$this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','','','game_name');
				$at = array_column($b, 'game_name');
				$sP=["1","5","6","12"];
				$dP=["3","7","8","9"];
				$tP=["4","10","11"];
				foreach ($at as $t) {
		        	$k = array_search($t, $at);
		        	if($t=='2'){
		        		$arr['sAkda']['point'] += $b[$k]['point'];
						$arr['sAkda']['id'] += $b[$k]['id'];
						$arr['sAkda']['win'] += $b[$k]['win'];
						$arr['sAkda']['com'] += $b[$k]['com'];
					}else if(in_array($t, $sP)){
						$arr['spatti']['point'] += $b[$k]['point'];
						$arr['spatti']['id'] += $b[$k]['id'];
						$arr['spatti']['win'] += $b[$k]['win'];
						$arr['spatti']['com'] += $b[$k]['com'];
					}else if(in_array($t, $dP)){
						$arr['dpatti']['point'] += $b[$k]['point'];
						$arr['dpatti']['id'] += $b[$k]['id'];
						$arr['dpatti']['win'] += $b[$k]['win'];
						$arr['dpatti']['com'] += $b[$k]['com'];
					}else if(in_array($t, $tP)){
						$arr['tpatti']['point'] += $b[$k]['point'];
						$arr['tpatti']['id'] += $b[$k]['id'];
						$arr['tpatti']['win'] += $b[$k]['win'];
						$arr['tpatti']['com'] += $b[$k]['com'];
					}
		        }
				die(json_encode($arr));
			}else if($_POST['mar']=='3'){

				$arr['dAkda']['point'] = 0;
				$arr['dAkda']['id'] = 0;
				$arr['dAkda']['win'] = 0;
				$arr['dAkda']['com'] = 0;
				$feilds = 'SUM(point_in_rs) as point,COUNT(id) as id,SUM(winning_in_rs) as win, SUM(commission_in_rs) as com,game_name';
				// $feilds = 'SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com,game_name';
				$con = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" AND "'.date('Y-m-d',strtotime($date[1])).'"'.$bazar;
				$b=$this->Common_model->getData('king_bazar_game',$con,$feilds,'','','','','game_name');
				$at = array_column($b, 'game_name');
				foreach ($at as $t) {
		        	$k = array_search($t, $at);
		        	if($t=='1'){
		        		$arr['sAkda']['point'] += $b[$k]['point'];
						$arr['sAkda']['id'] += $b[$k]['id'];
						$arr['sAkda']['win'] += $b[$k]['win'];
						$arr['sAkda']['com'] += $b[$k]['com'];
					}else if($t=='2'){
						$arr['dAkda']['point'] += $b[$k]['point'];
						$arr['dAkda']['id'] += $b[$k]['id'];
						$arr['dAkda']['win'] += $b[$k]['win'];
						$arr['dAkda']['com'] += $b[$k]['com'];
					}else if($t=='3'){
						$arr['jodi']['point'] += $b[$k]['point'];
						$arr['jodi']['id'] += $b[$k]['id'];
						$arr['jodi']['win'] += $b[$k]['win'];
						$arr['jodi']['com'] += $b[$k]['com'];
					}
		        }
				die(json_encode($arr));
			}else if($_POST['mar']=='4' || $_POST['mar']=='5' || $_POST['mar']=='6'){

				$arr['dAkda']['point'] = 0;
				$arr['dAkda']['id'] = 0;
				$arr['dAkda']['win'] = 0;
				$arr['dAkda']['com'] = 0;
				if($_POST['mar']=='4'){
					$table = 'warli_users_game';
				}else if($_POST['mar']=='5'){
					$table = 'redTable_users_game';
				}else if($_POST['mar']=='6'){
					$table = 'goldenTable_users_game';
				}
				$feilds = 'SUM(point_in_rs) as point,COUNT(id) as id,SUM(winning_in_rs) as win, SUM(commission_in_rs) as com,game_name';
				// $feilds = 'SUM(point) as point,COUNT(id) as id,SUM(winning_point) as win, SUM(commission) as com,game_name';
				$con = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" AND "'.date('Y-m-d',strtotime($date[1])).'"'.$bazar;
				$b=$this->Common_model->getData($table,$con,$feilds,'','','','','game_name');
				// die(json_encode($b));
				$at = array_column($b, 'game_name');
				foreach ($at as $t) {
					$k = array_search($t, $at);
		        	if($t=='4'){
		        		$arr['sAkda']['point'] += $b[$k]['point'];
						$arr['sAkda']['id'] += $b[$k]['id'];
						$arr['sAkda']['win'] += $b[$k]['win'];
						$arr['sAkda']['com'] += $b[$k]['com'];
					}else if($t=='1'){
						$arr['spatti']['point'] += $b[$k]['point'];
						$arr['spatti']['id'] += $b[$k]['id'];
						$arr['spatti']['win'] += $b[$k]['win'];
						$arr['spatti']['com'] += $b[$k]['com'];
					}else if($t=='2'){
						$arr['dpatti']['point'] += $b[$k]['point'];
						$arr['dpatti']['id'] += $b[$k]['id'];
						$arr['dpatti']['win'] += $b[$k]['win'];
						$arr['dpatti']['com'] += $b[$k]['com'];
					}else if($t=='3'){
						$arr['tpatti']['point'] += $b[$k]['point'];
						$arr['tpatti']['id'] += $b[$k]['id'];
						$arr['tpatti']['win'] += $b[$k]['win'];
						$arr['tpatti']['com'] += $b[$k]['com'];
					}
		        }
				die(json_encode($arr));
			}
		}else{
			$this->data['regularBazar']=$this->Common_model->getData('regular_bazar',' WHERE status="A"','id,bazar_name','','','','sequence ASC','');
			$this->data['starlineBazar']=$this->Common_model->getData('starline_bazar',' WHERE status="A"','id,bazar_name','','','','','');
			$this->data['kingBazar']=$this->Common_model->getData('king_bazar',' WHERE status="A"','id,bazar_name','','','','sequence ASC','');
		    $this->data['client']=$this->Common_model->getData('client',' WHERE status="A"','id,client_name','','','','id ASC','');
		    $this->load->view('admin/bazarBackBusiness',$this->data);
		}
	}

	public function riskPlayer(){
		$Common_model = $this->load->model('Common_model');
		if($_POST){
			$postData = $this->input->post();
			if($_POST['mar']=='1'){
				$data = $this->Common_model->getRegularRiskData($postData);
			}else if($_POST['mar']=='2'){
				$data = $this->Common_model->getRegularRiskData($postData);
			}else if($_POST['mar']=='3'){
				$data = $this->Common_model->getRegularRiskData($postData);
			}
			die(json_encode($data));
		}else{
			$this->data['regularBazar']=$this->Common_model->getData('regular_bazar',' WHERE status="A"','id,bazar_name','','','','sequence ASC','');
			$this->data['starlineBazar']=$this->Common_model->getData('starline_bazar',' WHERE status="A"','id,bazar_name','','','','','');
			$this->data['kingBazar']=$this->Common_model->getData('king_bazar',' WHERE status="A"','id,bazar_name','','','','sequence ASC','');
		    $this->load->view('admin/riskPlayer',$this->data);
		}
	}
	public function bazarBackBusinessByCustomer(){
		$Common_model = $this->load->model('Common_model');
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
	    $data = $this->Common_model->getRegularCustomerData($postData);
	    echo json_encode($data);
	}

	public function bazarBackBusinessByCustomerStar(){
		$Common_model = $this->load->model('Common_model');
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
	    $data = $this->Common_model->getRegularCustomerDataStar($postData);
	    echo json_encode($data);
	}

	public function bazarBackBusinessByCustomerKing(){
		$Common_model = $this->load->model('Common_model');
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
	    $data = $this->Common_model->getRegularCustomerDataKing($postData);
	    echo json_encode($data);
	}

	public function bazarBackBusinessByCustomerWorli(){
		$Common_model = $this->load->model('Common_model');
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
	    $data = $this->Common_model->getRegularCustomerDataWorli($postData);
	    echo json_encode($data);
	}

	public function regularBazarList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getRegularBazarData($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/manage_matkagames', $this->data); 
		}
	}

	public function addNewBazar($gameid=''){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
        'bazar_name', 'BazarName',
        'required|is_unique[regular_bazar.bazar_name]',
        array(
                'required'      => 'Bazar name must not empty',
                'is_unique'     => 'Bazar name already exist'
        )
        );
        $this->form_validation->set_rules('open_time', 'OpenTime', 'required');
        $this->form_validation->set_rules('close_time', 'CloseTime', 'required');
        $this->form_validation->set_rules('days', 'Days', 'required');
        // $this->form_validation->set_rules('days', 'Days', 'required');
        $this->form_validation->set_rules('sequence', 'Priority', 'required');
        $this->form_validation->set_rules('status', 'Result Mode', 'required');
        $this->form_validation->set_rules('bazar_type', 'Bazar Type', 'required');

        if ($_POST)  { 
        	$lstAct['entry_table'] = 'Regular Bazar';
        	$lstAct['supportId'] = $_SESSION['adid']['id'];
        	$lstAct['created'] = date('Y-m-d H:i:s');
			if(!empty($_FILES["delar_image"]["name"])){
				$temp = explode(".", $_FILES["delar_image"]["name"]);
				$newfilename = transactionID(10,10) . '.' . end($temp);
				$file = move_uploaded_file($_FILES["delar_image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/assets/bazar_image/".$newfilename);
			}
			// echo '<pre>';
			// print_r($_FILES);
			// die();
         	if ($gameid > 0 && ($this->form_validation->run() != FALSE || $this->form_validation->run() =='') ) {
				$addnewGame = array(
					'bazar_type' => $_POST['bazar_type'] ,
					'bazar_name' => $_POST['bazar_name'] , 
					'open_time' => $_POST['open_time'] , 
					'close_time' => $_POST['close_time'] , 
					'days' => implode(",", $_POST['days']) , 
					'sequence' => $_POST['sequence'] , 
					'status' => $_POST['status'],
					'updated_by'=>$_SESSION['adid']['id'],
					'profit'=>$_POST['profit'],
					'cutAk'=>$_POST['cutAk'],
					'cutJodi'=>$_POST['cutJodi'],
					'cutSp'=>$_POST['cutSp'],
					'cutDp'=>$_POST['cutDp'],
					'cutTp'=>$_POST['cutTp']
				);
				if($newfilename){
					$addnewGame['bazar_image'] = "assets/bazar_image/".$newfilename;
				}
				$lstAct['detail'] = implode(', ',$addnewGame);
        		AddUpdateTable('lastActivity','','',$lstAct);

				AddUpdateTable('regular_bazar','id',$gameid,$addnewGame);
				redirect('a429d046df97a54547ae9f9b523bb904');
			}else{
				$addnewGame = array(
					'bazar_type' => $_POST['bazar_type'] ,
					'bazar_name' => $_POST['bazar_name'] ,
					'open_time' => $_POST['open_time'] , 
					'close_time' => $_POST['close_time'] ,
					'days' => implode(",", $_POST['days']) , 
					'sequence' => $_POST['sequence'] , 
					'status' => $_POST['status'],
					'updated_by'=>$_SESSION['adid']['id'],
					'profit'=>$_POST['profit'],
					'cutAk'=>$_POST['cutAk'],
					'cutJodi'=>$_POST['cutJodi'],
					'cutSp'=>$_POST['cutSp'],
					'cutDp'=>$_POST['cutDp'],
					'cutTp'=>$_POST['cutTp']
				);
				if($newfilename){
					$addnewGame['bazar_image'] = "assets/bazar_image/".$newfilename;
				}
				
				$gameid = AddUpdateTable('regular_bazar','','',$addnewGame);
        		$lstAct['detail'] = implode(', ',$addnewGame);
        		AddUpdateTable('lastActivity','','',$lstAct);
				if ($gameid > 0) {
					$data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
				}
            	$this->load->view('admin/add_new_game',$data);		
			}

        } 
        else { 
        	if ($gameid > 0) {
				$data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
			}else{
				$data['onegamedata']['id'] = 0;
			}
            $this->load->view('admin/add_new_game',$data); 
        } 
	}

	public function bazarRateList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getRegularBazarRateData($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$con = ' WHERE status="A"';
			$data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name','','','','','');
			$data['type'] = $this->Common_model->getData('regular_game_type',$con,'id,game_name','','','','','');
			$this->load->view('admin/regular_bazar_rate',$data);
		}
	}
	public function addNewBazarRate($gameid=''){
		$this->load->model('ManageMatkagames_Model');
		if ($_POST) {
			$_POST['updated_by'] = $_SESSION['adid']['id'];
			$lstAct['entry_table'] = 'Regular Bazar Bhav';
        	$lstAct['supportId'] = $_SESSION['adid']['id'];
        	$lstAct['created'] = date('Y-m-d H:i:s');

			$conLst = ' INNER JOIN regular_bazar ON regular_bazar_rate.bazar_name=regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_rate.game_name=regular_game_type.id WHERE regular_bazar_rate.bazar_name="'.$_POST['bazar_name'].'" AND regular_bazar_rate.game_name="'.$_POST['game_name'].'"';
			$feildsLst = 'regular_bazar_rate.rate,regular_game_type.game_name,regular_bazar.bazar_name';
			if ($gameid) {
				AddUpdateTable('regular_bazar_rate','id',$gameid,$_POST);
			}else{
				$rec=$this->ManageMatkagames_Model->getmatkagamedetails("regular_bazar_rate",'','','','','id',' WHERE bazar_name="'.$_POST['bazar_name'].'" AND game_name="'.$_POST['game_name'].'"','One');
				if(!$rec){
					$gameid = AddUpdateTable('regular_bazar_rate','','',$_POST);
					$this->session->set_flashdata('success', 'Rate Added sucessfully!');
				}else{
					$this->session->set_flashdata('error', 'Rate Already Added');
				}
			}
			if ($gameid > 0) {
				$lst = $this->ManageMatkagames_Model->getmatkagamedetails("regular_bazar_rate",'','','','',$feildsLst,$conLst,'One');
				$lstAct['detail'] = implode(', ',$lst);
        		AddUpdateTable('lastActivity','','',$lstAct);
				redirect('ac947e65b4985f0215ded1582c2ef6cd');
			}
		}
		if ($gameid > 0) {
			$data['onegamedata'] = getRecordById('regular_bazar_rate','id',$gameid);
		}
		$data["matkaallBazar"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_bazar",'','','id','desc','id,bazar_name ','','');
		$data["matkaallGame"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_game_type",'','','id','desc','id,game_name ','','');
		$this->load->view('admin/add_regular_bazar_rate',$data);
	}

	public function GameTypeList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getRegularGameTypeData($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$con = ' WHERE status="A"';
			$data['type'] = $this->Common_model->getData('regular_game_type',$con,'id,game_name','','','','','');
			$this->load->view('admin/regular_game_type', $data);
		}
	}

	public function addNewGameType($gameid=''){
		$this->load->model('ManageMatkagames_Model');
		 
		if ($_POST) {
			$_POST['updated_by'] = $_SESSION['adid']['id'];
			if ($gameid > 0) {
				$_POST['status']="A";
				AddUpdateTable('regular_game_type','id',$gameid,$_POST);
			}else{
				$gameid = AddUpdateTable('regular_game_type','','',$_POST);
			}
			if ($gameid > 0) {
				redirect('495422a2a9c4fef025803d9180abc03b');
			}
		}
		if ($gameid > 0) {
			$data['onegamedata'] = getRecordById('regular_game_type','id',$gameid);
		}
		$this->load->view('admin/add_regular_game_type',$data);
	}


	public function worliRoundStatment(){
		$this->load->model('Common_model');
        $data['bhav'] = $this->Common_model->getData('warli_bhav','','game_name,bhav','','','','','');
		$data['status'] = $this->Common_model->getData('buffer',' WHERE id="1"','status','','','one','','');
		$this->load->view('admin/worliRoundStatment',$data);
	}

	public function blueTableRoundStatment(){
		$this->load->model('Common_model');
        $data['bhav'] = $this->Common_model->getData('redTable_rate','','game_name,rate as bhav','','','','','');
		$data['status'] = $this->Common_model->getData('buffer',' WHERE id="5"','status','','','one','','');
		$this->load->view('admin/blueTableRoundStatment',$data);
	}
	
	public function changePassword(){
        if($_POST){
	    	$this->load->model('Common_model');
        	$con = ' WHERE email="'.$_SESSION['adid']['email'].'" AND password="'.md5($_POST['old']).'"';
			$user = $this->Common_model->getData('admin',$con,'','','','One','','');
			if($_POST['confirm']!=$_POST['new']){
				$this->session->set_flashdata('error', 'new password and cunfirm password not matched!');
        		redirect('de42a3f3870e91622ccb9c71af924f19');
			}
			if(md5($_POST['old'])==$user['password']){
				$arr['password']=md5($_POST['new']);
	        	$gameaddid = AddUpdateTable('admin', 'id', $user['id'], $arr);
	        	if($gameaddid){
	        		$this->session->set_flashdata('success', 'Password Changed Successfully!');
        			redirect($_SERVER['HTTP_REFERER']);
	        	}
			}else{
				$this->session->set_flashdata('error', 'old passwork is not matched!');
        		redirect('de42a3f3870e91622ccb9c71af924f19');
			}
        }
	    $this->load->view('admin/changePassword');

	}


	public function lastActivity(){
		if($this->input->post()){
			$postData = $this->input->post();
			$postData['order'][0]['column']=4;
			$postData['order'][0]['dir']='desc';
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->lastActivity($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/lastActivity', $data);
		}
	}


	public function blrWorli(){
		$notifyResult['market']='ForBuffer';
        $notifyResult['status']=$_POST['status'];
        if($_POST['status']=='0'){
        	$bArr['status']=0;
        	AddUpdateTable('buffer','id','1',$bArr);  
        }else{
        	$bArr['status']=1;
			$bArr['bazar']=0;
			$bArr['vUrl']='';
        	AddUpdateTable('buffer','id','1',$bArr);  
        }
        notifyUserWithResult(json_encode($notifyResult));
	}

	public function addWorliResult(){
		
		$this->load->model('Common_model');
		$buf = $this->Common_model->getData('buffer',' WHERE id="1"','status','','','One','','');
		if($buf['status']=='1'){
			$arr=['status'=>201,'massage'=>'Buffer Not On.'];
			die(json_encode($arr));
		}
		// echo '<pre>';
		// print_r($_POST);
		// die();
		$ak=(string)$_POST['res'];
        $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

        if($akda>9){
            $a=(string)$akda;
            $akda=$a[1];
        }
        $patti = $data->CardScore;
        $betArr['result_date'] = date('Y-m-d');
        $betArr['tableId'] = 'Matka-1';
        $betArr['gameId'] = $_POST['GameId'];
        $betArr['patti_result'] = $ak;
        $betArr['akda_result'] = $akda;
        $betArr['status'] = 'A';

        $res=AddUpdateTable('warli_result','','',$betArr);
        
        $lstAct['entry_table'] = 'Worli Buffer';
		$lstAct['supportId'] = $_SESSION['adid']['id'];
		$lstAct['created'] = date('Y-m-d H:i:s');
		$lstAct['detail'] = $akda.', '.$ak.', '.$_POST['GameId'];
		AddUpdateTable('lastActivity','','',$lstAct);

        /*---------------- For Responce And Process Start ----------------*/
        if($res){
            $arr=['status'=>200,'massage'=>'Betting Start Now.'];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
        }
        ob_start();
        echo json_encode($arr);
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("Connection: close");
        ob_end_flush();
        ob_flush();
        flush();
        $notifyResult['market']='Worli';
        $notifyResult['url']='4ad7b357b4a728f18d6e27dea29a071e';
        notifyUserWithResult(json_encode($notifyResult));
        /*---------------- For Responce And Process End ----------------*/
        
        $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$_POST['GameId'].'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
        $lC=0;
		$fbC=0;
		$oC=0;
		$com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
		foreach($com as $c){
			if($c['client_id']=='2'){
				$lC=$c['commission'];
			}else if($c['client_id']=='4'){
				$fbC=$c['commission'];
			}else{
				$oC=$c['commission'];
			}
		}

		$cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
		$cR = array();
		foreach ($cCR as $d){
			$cR[$d['id']] = $d['currancy_rate'];
		}

		foreach ($bets as $b) {
			$rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$b['customer_id'].'" AND partner_id="'.$b['partner_id'].'"','rate','','','One','','');       
        
			if($bet['partner_id']=='2'){
				$commission=$lC;
			}else if($bet['partner_id']=='4'){
				$commission=$fbC;
			}else{
				$commission=$oC;
			}
            if($b['game_name']=='4'){
                if($b['game']==$akda){
                    $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
                    $bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
					$bArr['winning_in_rs']=0;
                    $bArr['commission_in_rs']=0;
                    $bArr['status']='L';
                }
            }else{
                if($b['game']==$patti){
                    $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
					$bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
					$bArr['winning_in_rs']=0;
                    $bArr['commission_in_rs']=0;
                    $bArr['status']='L';
                }
            }
            $res1=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);  
        }
        $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
        foreach($arrLoss as $l){
            $con=" WHERE partner_id='".$l['id']."' AND round_id='".$_POST['GameId']."'";
            if($l['id']=='2'){
                $con.=' AND status="W"';
                $arrReq['dataRes']=$data->GameId;
            }
            $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$_POST['GameId'].'"','transaction_id,status,winning_point,commission','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Instant Worli';
			// if($l['id']=="4"){
			//     responseLog($arrReq);
			// }
            $req = requestForClient($l['end_point_url'],$arrReq);
            responseLog([$l['end_point_url'], $arrReq]);
        }
        if($res&&$res1){
            $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
        }
        $notifyMeW['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
        $notifyMeL['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
        $notifyResult['resultStatus']=$notifyMeW['userList'];
        notifyUserWithResult(json_encode($notifyResult));
        requestForBalance(json_encode($notifyMeW));
        requestForBalance(json_encode($notifyMeL));
        die(json_encode($arr));
	}

	public function blrRegular(){
		$notifyResult['market']='BufferForRegular';
        $notifyResult['status']=$_POST['status'];
		$notifyResult['bazar_id']=$_POST['bazar'];
		$bArr['id']=$_POST['id'];
        if($_POST['status']=='0'){
			$this->load->model('Common_model');

			$con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$_POST['bazar']."'";
			$token = $this->Common_model->getData('regular_bazar_result',$con,'id','','','One','','');
			if($token){
				if($_POST['type']=='Open'){
					$tArr['token_open']=time();
				}else{
					$tArr['token_close']=time();
				}
				$res = AddUpdateTable('regular_bazar_result','id',$token['id'],$tArr); 
			}else{
				die(json_encode(['status'=>400,'massage'=>'record not avilable']));
			}

			$buf = $this->Common_model->getData('buffer',' WHERE id="4"','vUrl','','','One','','');
			$bArr['startTime']=date('Y-m-d H:i:s');
			$bArr['bazar']=$_POST['bazar'];
			$notifyResult['startTime']=$bArr['startTime'];
			$notifyResult['vUrl']=$buf['vUrl'];
        	$bArr['status']=0;
        	$res = AddUpdateTable('buffer','id',$bArr['id'],$bArr);  
        }else{
        	$bArr['status']=1;
        	$res = AddUpdateTable('buffer','id',$bArr['id'],$bArr);  
        }
		notifyUserWithResult(json_encode($notifyResult));
		die(json_encode(['status'=>200,'massage'=>$res]));
	}

	public function blrRegularNew(){
		$notifyResult['market']='BufferForRegular';
        $notifyResult['status']=$_POST['status'];
		$notifyResult['bazar_id']=$_POST['bazar'];
		$bArr['id']=$_POST['id'];
        if($_POST['status']=='0'){
			$this->load->model('Common_model');
			$buf = $this->Common_model->getData('buffer',' WHERE id="4"','vUrl,status','','','One','','');
			$con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$_POST['bazar']."'";
			$token = $this->Common_model->getData('regular_bazar_result',$con,'id','','','One','','');
			if($buf['status']=='0'){
				die(json_encode(['status'=>401,'massage'=>'Buffer is already on']));
			}
			if($token){
				if($_POST['type']=='Open'){
					$tArr['token_open']=time();
				}else{
					$tArr['token_close']=time();
				}
				$res = AddUpdateTable('regular_bazar_result','id',$token['id'],$tArr); 
			}else{
				$tArr['token_open']=time();
				$tArr['token_close']=time();
				$tArr['bazar_name'] = $_POST['bazar'];
				$tArr['result_date'] = date('Y-m-d');
				$tArr['status'] = "I";
				
				$res = AddUpdateTable('regular_bazar_result','','',$tArr); 
				// die(json_encode(['status'=>400,'massage'=>'record not avilable']));
			}

			
			$bArr['startTime']=date('Y-m-d H:i:s');
			$bArr['bazar']=$_POST['bazar'];
			$notifyResult['startTime']=$bArr['startTime'];
			$notifyResult['vUrl']=$buf['vUrl'];
        	$bArr['status']=0;
			$bArr['patti']=$_POST['bPatti'];
			$bArr['type']=$_POST['type'];
        	$res = AddUpdateTable('buffer','id',$bArr['id'],$bArr);  
        }else{
        	$bArr['status']=1;
			$bArr['vUrl']='';
			$bArr['patti']='';
			$bArr['type']='';
			$bArr['bazar']='0';
        	$res = AddUpdateTable('buffer','id',$bArr['id'],$bArr);  
        }
		notifyUserWithResult(json_encode($notifyResult));
		die(json_encode(['status'=>200,'massage'=>$res]));
	}

	public function setPatti(){
		$this->load->model('Common_model');
		$buf = $this->Common_model->getData('buffer_video_list',' WHERE patti="'.$_POST['bPatti'].'"','link','','','One','','');
		
		if($buf){
			$bArr['vUrl']=$buf['link'];
			// die(json_encode($buf['link']));
			$res = AddUpdateTable('buffer','id',$_POST['id'],$bArr);
			if($res){
				$r = [
					'status'=>200,
					'massage'=>'patti updated!'
				];
			}else{
				$r = [
					'status'=>400,
					'massage'=>'Something went wrong!'
				];
			}
		}else{
			$r = [
				'status'=>400,
				'massage'=>'Video Not Available!'
			];
		}
		
		die(json_encode($r));
	}
	
	public function setPattiNew(){
		$this->load->model('Common_model');
		// $buf = $this->Common_model->getData('buffer_video_list',' WHERE patti="'.$_POST['bPatti'].'"','link','','','One','','');
		$buf = $this->Common_model->getData('dealerVideos',' WHERE patti LIKE "'.$_POST['bPatti'].'%" AND status="A"','','','','','','');
		
		if($buf){
			$bArr['patti']=$_POST['bPatti'];
			$res = AddUpdateTable('buffer','id',$_POST['id'],$bArr);
			if($res){
				$r = [
					'status'=>200,
					'massage'=>'patti updated!',
					'data'=>$buf
				];
			}else{
				$r = [
					'status'=>400,
					'massage'=>'patti not updated!'
				];
			}
		}else{
			$r = [
				'status'=>400,
				'massage'=>'Video Not Available!'
			];
		}
		
		die(json_encode($r));
	}

	public function setVideo(){
		$this->load->model('Common_model');
		$bArr['vUrl']=$_POST['link'];
		$bArr['bazar']=$_POST['marketId'];
		$buf = $this->Common_model->getData('buffer',' WHERE id="4"','','','','One','','');
		// if(empty($buf['vUrl'])){
		// 	$res = AddUpdateTable('buffer','id','4',$bArr); 
		// }
		$res = AddUpdateTable('buffer','id','4',$bArr);
		if($res){
			$r = [
				'status'=>200,
				'massage'=>'patti updated!'
			];
		}else{
			$r = [
				'status'=>400,
				'massage'=>'Something went wrong!'
			];
		}
		
		die(json_encode($r));
	}

	public function addRegularResult(){
		
		$this->load->model('Common_model');
		
		$buf = $this->Common_model->getData('buffer',' WHERE id="4"','status','','','One','','');
		if($buf['status']=='1'){
			$arr=['status'=>201,'message'=>'Buffer Not On.'];
			die(json_encode($arr));
		}
		// die($_POST);
		$a=$_POST['res'];
		$ak=(int)$a[0]+(int)$a[1]+(int)$a[2];
		if($ak>9){
			$akda=abs($ak % 10);
		}else{
			$akda=$ak;
		}
		// $this->load->model('Common_model');
		
		if($_POST['type']=='Close'){
			$con = ' WHERE bazar_name="'.$_POST['bazar'].'" AND result_date="'.date("Y-m-d").'" AND status="A"';
			$bazarResult = $this->Common_model->getData('regular_bazar_result',$con,'id,open,jodi,close','','','One','','');
			
			$addResult['close'] = $_POST['res'];
			$addResult['jodi'] = $bazarResult['jodi'].$akda;
			$addResult['token_close'] = time();
			$wU='Close';

			$sR['open_result'] = $bazarResult['open'];
			$sR['close_result']=$addResult['close'];
			$sR['jodi_result']=$addResult['jodi'];
			$isResult = $bazarResult['close'];
		}else if($_POST['type']=='Open'){
			$bazarResult = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$_POST['bazar'].'" AND status="I" AND result_date="'.date("Y-m-d").'"','id,open','','','One','','');
			$addResult['open'] = $_POST['res'];
			$addResult['jodi'] = $akda;
			$addResult['status'] = 'A';
			$addResult['token_open'] = time();
			$wU='Open';

			$sR['open_result']=$addResult['open'];
			$sR['jodi_result']=$addResult['jodi'];
			$sR['close_result']='';
			$isResult = $bazarResult['open'];
		}else{
			die([
				'status'=>402,
				'message'=>'Invalid Token'
			]);
		}
		
		if(!empty($isResult)){
			$arr=[
				'status'=>402,
				'message'=>'Result Already Decleare!'
			];
			die(json_encode($arr));
		}else if(empty($bazarResult)){
			$arr=[
				'status'=>402,
				'message'=>'Invalid Token'
			];
			die(json_encode($arr));
		}else {
			if($_SESSION){
				$addResult['updated_by']=$_SESSION['adid']['id'];
			}
			$addUpdate = AddUpdateTable('regular_bazar_result', 'id', $bazarResult['id'], $addResult);
			if($addUpdate){
				$arr=[
					'status'=>200,
					'message'=>'Result Updated Successfully!'
				];
				$sendTo = ['+380947126066','8208684855','9608010101','9421544444','9730291547'];
				// $sendTo = ['9730291547'];
				$bazarResult = $this->Common_model->getData('regular_bazar',' WHERE id="'.$_POST['bazar'].'"','','','','One','','');
				$dT=date('Y-m-d');
				$rE=$sR['open_result'].'-'.$sR['jodi_result'].'-'.$sR['close_result'];
				$message = "*Used Buffer to add Game Result - {$bazarResult['bazar_name']} ({$_POST['type']}) - {$dT} Result : {$rE} Added By {$_SESSION['adid']['name']}*\n\n";
					
				foreach($sendTo as $to){
					$res = sendWhatsApp($message,$to);
				}
			}else{
				$arr=[
					'status'=>201,
					'message'=>'Result Not Updated Successfully!'
				];
			}
			ob_start();
			echo json_encode($arr);
			$size = ob_get_length();
			header("Content-Encoding: none");
			header("Content-Length: {$size}");
			header("Connection: close");
			ob_end_flush();
			ob_flush();
			flush();
			/*------------------------ Update Wallet Start -------------------------*/
			// if($wU=='Close'){
			// 	$win = getWinnersClose($bazarResult['id']);
			// }else{
			// 	$win = getWinnersOpen($bazarResult['id']);
			// }
			// if(!empty($win)){
			// 	$type='';
			// 	 $com = $this->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
			// 	$clinetC = array();
			// 	foreach ($com as $c) {
			// 		$clinetC[$c['client_id']] = $c['commission'];
			// 	}

			// 	$cRate = $this->Common_model->getData('customer_rate','','customer_id,partner_id,rate','','','','','');
				

			// 	$rate = $this->Common_model->getData('regular_bazar_rate', ' WHERE bazar_name="' . $bazarId . '"', 'rate,game_name', '', '', '', '', '');
			// 	$rT = array();
			// 	foreach ($rate as $d) {
			// 		$rT[$d['game_name']] = $d['rate'];
			// 	}
				
			// 	foreach($win as $data){
			// 		$bet = $this->Common_model->getData('regular_bazar_games',' WHERE id="'.$data.'"','exchange_rate,partner_id,customer_id,bazar_name,game_name,result_date,point,game_type','','','One','','');
			// 		$rate['rate'] = $rT[$bet['game_name']];

			// 		foreach($cRate as $cNR){
			// 			if($cNR['customer_id']==$bet['customer_id'] && $cNR['partner_id']==$bet['partner_id']){
			// 				$rOC=$cNR['rate'];
			// 			}else{
			// 				$rOC=false;
			// 			}
			// 		}
			// 		$com = $clinetC[$bet['partner_id']];
			// 		if($rOC){
			// 			$win = ($bet['point']*$rate['rate']) * ((100-$rOC['rate']) / 100);
			// 			$addRes['commission'] = ($com / 100) * $win;
			// 			$addRes['winning_point'] = $win - $addRes['commission'];
			// 		}else{
			// 			$addRes['commission'] = ($com / 100) * $bet['point']*$rate['rate'];
			// 			$addRes['winning_point'] = ($bet['point']*$rate['rate'])-$addRes['commission'];
			// 		}

			// 		$addRes['status']= 'W';
			// 		$addRes['winning_in_rs']=$addRes['winning_point']*(double)$bet['exchange_rate'];
            //         $addRes['commission_in_rs']=$addRes['commission']*(double)$bet['exchange_rate'];

			// 		$updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addRes);
			// 		if(empty($type)){
			// 			if($bet['game_type']=='Open'){
			// 				$type=' AND game_type="Open"';
			// 			}else{
			// 				$type=' AND game_type!="Open"';
			// 			}
			// 		}
			// 		// array_push($notifyMe, $bet['customer_id']);
			// 	}
			// }

			// $con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."'".$type;
			// $field['status']="L";
			// $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);

			/*--------------------- Setel Market Start --------------------------*/
			// $con1=" INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.result_date='".$bet['result_date']."' AND regular_bazar_games.bazar_name='".$bet['bazar_name']."'".$type;


			// $arrLoss = $this->Common_model->getData('regular_bazar_games',$con1,'DISTINCT regular_bazar_games.partner_id,client.end_point_url','','','','','');
			// foreach($arrLoss as $l){
			// 	$con=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."'".$type;
			// 	if($l['partner_id']=='2' || $l['partner_id']=='5'){
			// 		$con.=' AND status="W"';
			// 		$arrReq['result_date']=$bet['result_date'];
			// 		$arrReq['bazar_id']=$bet['bazar_name'];
			// 		$arrReq['type']=$type;
			// 	}
			// 	$arrLossBet = $this->Common_model->getData('regular_bazar_games',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
			// 	$arrReq['code']='601';
			// 	$arrReq['rec']=json_encode($arrLossBet);
			// 	$arrReq['market']='Regular Bazar';
			// 	$arrReq['market_code']='301';
			// 	$req = requestForClient($l['end_point_url'],$arrReq);
			// }
			// $arr=[
			// 	'status'=>200,
			// 	'message'=>'Wallet Updated Successfully!'
			// ];
			/*--------------------- Setel Market End --------------------------*/
			/*--------------------- notifyMe Start --------------------------*/
			$con1=" WHERE result_date='".$bet['result_date']."' AND bazar_name='".$bet['bazar_name']."'".$type;
			$notifyMeW['userList'] = $this->Common_model->getData('regular_bazar_games',$con1.' AND status="W"','customer_id as id,status,commission','','','','','');

			$notifyResult['market']='Regular';
			$notifyResult['type']=$wU;
			if($wU=='Open'){
				$notifyResult['result']=$_POST['result'].'-'.$akda;
			}else{
				$notifyResult['result']=$akda.'-'.$_POST['result'];
			}
			$notifyResult['url']='9a27a7e97c16a7b3ac6382d21205357f/'.$bet['bazar_name'];
			requestForBalance(json_encode($notifyMeW));
			notifyUserWithResult(json_encode($notifyResult));
			/*--------------------- notifyMe End --------------------------*/
			/*--------------------- send Result to dpboss Start --------------------------*/
			$con2 = " WHERE id='".$bazarResult['bazar_name']."'";
			$sendRes = $this->Common_model->getData('regular_bazar',$con2,'bazar_name','','','One','','');
				
			$sR['bazar_name']=$bet['bazar_name'];
			$sR['result_date']=$bet['result_date'];
			$url='https://channapoha.com/postdata';
			sendResultDpboss($sR,$url);
			/*--------------------- send Result to dpboss End --------------------------*/
		/*------------------------ Update Wallet End -------------------------*/
		}
	}

	public function addStrimingVideo($id=''){
		if ($_POST) {
			$configVideo['upload_path'] = 'assets/gallery/videos'; # check path is correct
			$configVideo['max_size'] = '102400';
			$configVideo['allowed_types'] = 'mp4'; # add video extenstion on here
			$configVideo['overwrite'] = FALSE;
			$configVideo['remove_spaces'] = TRUE;
			$video_name = substr(md5(uniqid(mt_rand(), true)), 0, 8);
			$configVideo['file_name'] = $video_name.time();

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);

			$addResult = array(
				'patti' => $_POST['patti'],
				'updated' => date('Y-m-d H:i:s'),
				'link' => 'assets/gallery/videos/'.$configVideo['file_name'].'.mp4'
			);
			if ($id > 0) {
				$updateresultid = AddUpdateTable('buffer_video_list', 'id', $id, $addResult);
			}else{
				$updateresultid = AddUpdateTable('buffer_video_list', '', '', $addResult);
			}
			if ($updateresultid > 0 && $this->upload->do_upload('video_file')) {
				$this->session->set_flashdata('success', 'Video Has been Uploaded');
			}else{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}
			redirect('29c84e979cf8e713d94bf77a3cdba080');
		}else{
			$this->load->model('ManageMatkaallgames_Model');
			$data['matkaallgame'] = $this->ManageMatkaallgames_Model->getmatkagameallGame();
			if ($id > 0) {
				$data['onegamedata'] = getRecordById('regular_bazar_result', 'id', $id);
			}
			$this->load->view('admin/addStrimingVideo',$data);
		}
	}

	public function videoStrimingList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getVideoStrimingData($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/videoStrimingList');
		}
	}


	// -----------------------------------------------

	public function blrBlueTable(){
		$notifyResult['market']='ForBufferBlueTable';
        $notifyResult['status']=$_POST['status'];
        if($_POST['status']=='0'){
        	$bArr['status']=0;
        	AddUpdateTable('buffer','id','5',$bArr);  
        }else{
        	$bArr['status']=1;
        	AddUpdateTable('buffer','id','5',$bArr);  
        }
        notifyUserWithResult(json_encode($notifyResult));
	}

	public function addBlueTableResult(){
		
		$this->load->model('Common_model');
		$buf = $this->Common_model->getData('buffer',' WHERE id="5"','status','','','One','','');
		if($buf['status']=='1'){
			$arr=['status'=>201,'massage'=>'Buffer Not On.'];
			die(json_encode($arr));
		}
		// echo '<pre>';
		// print_r($_POST);
		// die();
		$ak=(string)$_POST['res'];
        $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

        if($akda>9){
            $a=(string)$akda;
            $akda=$a[1];
        }
        $patti = $data->CardScore;
        $betArr['result_date'] = date('Y-m-d');
        $betArr['tableId'] = 'Matka-1';
        $betArr['gameId'] = $_POST['GameId'];
        $betArr['patti_result'] = $ak;
        $betArr['akda_result'] = $akda;
        $betArr['status'] = 'A';

        $res=AddUpdateTable('redTable_result','','',$betArr);
        
        $lstAct['entry_table'] = 'Blue Table Buffer';
		$lstAct['supportId'] = $_SESSION['adid']['id'];
		$lstAct['created'] = date('Y-m-d H:i:s');
		$lstAct['detail'] = $akda.', '.$ak.', '.$_POST['GameId'];
		AddUpdateTable('lastActivity','','',$lstAct);

        /*---------------- For Responce And Process Start ----------------*/
        if($res){
            $arr=['status'=>200,'massage'=>'Betting Start Now.'];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
        }
        ob_start();
        echo json_encode($arr);
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("Connection: close");
        ob_end_flush();
        ob_flush();
        flush();
        $notifyResult['market']='blueTable';
        $notifyResult['url']='61e244a8b1f70b8dc67e4014eb9bc963';
        notifyUserWithResult(json_encode($notifyResult));
        /*---------------- For Responce And Process End ----------------*/
        
        $bets = $this->Common_model->getData('redTable_users_game',' WHERE status="P" AND round_id="'.$_POST['GameId'].'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
        $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');       
        $lC=0;
		$fbC=0;
		$oC=0;
		$com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
		foreach($com as $c){
			if($c['client_id']=='2'){
				$lC=$c['commission'];
			}else if($c['client_id']=='4'){
				$fbC=$c['commission'];
			}else{
				$oC=$c['commission'];
			}
		}
		$cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
		$cR = array();
		foreach ($cCR as $d){
			$cR[$d['id']] = $d['currancy_rate'];
		}

		foreach ($bets as $b) {
			if($b['partner_id']=='2'){
				$commission=$lC;
			}else if($b['partner_id']=='4'){
				$commission=$fbC;
			}else{
				$commission=$oC;
			}
            if($b['game_name']=='4'){
                if($b['game']==$akda){
                    $bhav = $this->Common_model->getData('redTable_rate',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
                    $bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
                    $bArr['status']='L';
                }
            }else{
                if($b['game']==$patti){
                    $bhav = $this->Common_model->getData('redTable_rate',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
					$bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
                    $bArr['status']='L';
                }
            }
            $res1=AddUpdateTable('redTable_users_game','transaction_id',$b['transaction_id'],$bArr);  
        }
        $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
        foreach($arrLoss as $l){
            $con=" WHERE partner_id='".$l['id']."' AND round_id='".$_POST['GameId']."'";
            if($l['id']=='2'){
                $con.=' AND status="W"';
                $arrReq['dataRes']=$data->GameId;
            }
            $arrLossBet = $this->Common_model->getData('redTable_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$_POST['GameId'].'"','transaction_id,status,winning_point,commission,customer_id','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Red Table';
            $req = requestForClient($l['end_point_url'],$arrReq);
        }
        if($res&&$res1){
            $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
        }
        $notifyMeW['userList'] = $this->Common_model->getData('redTable_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
        $notifyMeL['userList'] = $this->Common_model->getData('redTable_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
        $notifyResult['resultStatus']=$notifyMeW['userList'];
        notifyUserWithResult(json_encode($notifyResult));
        requestForBalance(json_encode($notifyMeW));
        requestForBalance(json_encode($notifyMeL));
        die(json_encode($arr));
	}


	public function getWorliRoundBets(){
		$this->load->model('Common_model');
		$mcrypt = new MCrypt();
		if($_POST['market']=='worli'){
			$table='warli_users_game';
		}else if($_POST['market']=='blueTable'){
			$table='redTable_users_game';
		}
        
        $con2 = " WHERE round_id='".$_POST['id']."' AND status!='V'";
		$res = $this->Common_model->getData($table,$con2,'','','','','','');
		if($res){
			$data = array();
			foreach($res as $record){
				$data[] = array( 
						"transaction_id"=>$record['transaction_id'],
						"partner_id"=>$record['partner_id'],
						"id"=>$record['id'],
						"customer_id"=>$record['partner_id']==2?$mcrypt->decrypt($record['customer_id']):$record['customer_id'],
						"game"=>$record['game'],
						"point"=>$record['point'],
						"winning_point"=>$record['winning_point'],
						"commission"=>$record['commission'],
						"status"=>$record['status'],
				); 
			}
		}else{
			$data = [];
		}
		die(json_encode($data));
	}

	public function topPlayers(){
		$this->load->model('Common_model');
		$mcrypt = new MCrypt();
		if($_POST['market']=='worli'){
			$table='warli_users_game';
		}else if($_POST['market']=='blueTable'){
			$table='redTable_users_game';
		}
        $feilds = "SUM(winning_point) as win,customer_id,partner_id,SUM(point) as amt, (SUM(point) - SUM(winning_point)) as ggr";
        $con2 = " WHERE result_date='".$_POST['date']."' AND status!='V'";
		$res = $this->Common_model->getData($table,$con2,$feilds,'20','0','','ggr ASC','customer_id');
		if($res){
			$data = array();
			foreach($res as $record){
				$data[] = array( 
						"win"=>$record['win'],
						"amt"=>$record['amt'],
						"customer_id"=>$record['partner_id']==2?$mcrypt->decrypt($record['customer_id']):$record['customer_id'],
						"partner_id"=>$record['partner_id'],
						"ggr"=>$record['ggr'],
				); 
			}
		}else{
			$data = [];
		}
		die(json_encode($data));
	}

	public function analysis(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->model('Common_model');
			$feilds = "SUM(winning_in_rs) as win,SUM(point_in_rs) as amt, (SUM(point_in_rs)-SUM(winning_in_rs)) as ggr, result_date as date ";
			// $feilds = "SUM(winning_point) as win,SUM(point) as amt, (SUM(point)-SUM(winning_point)) as ggr, result_date as date ";
			if($_POST['type']=='worli'){
				$con2 = " WHERE result_date > '".date('Y-m-d',strtotime("-7 days"))."' AND status NOT IN ('V','P')";
				$res = $this->Common_model->getData('warli_users_game',$con2,$feilds,'','','','result_date ASC','result_date');
				die(json_encode($res));
			}else if($_POST['type']=='all'){
				if($_POST['date']=='1'){
					$_POST['date']=date('Y-m-d',strtotime("-7 days"));
				}
				$con2 = " WHERE result_date > '".$_POST['date']."' AND status NOT IN ('V','P')";
				$worli = $this->Common_model->getData('warli_users_game',$con2,$feilds,'','','','result_date ASC','result_date');
				// echo die(json_encode($worli));
				$star = $this->Common_model->getData('starline_bazar_game',$con2,$feilds,'','','','result_date ASC','result_date');
				// echo die(json_encode($star));
				$reg = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','','result_date ASC','result_date');
				// echo die(json_encode($reg));
				$king = $this->Common_model->getData('king_bazar_game',$con2,$feilds,'','','','result_date ASC','result_date');
				// echo die(json_encode($king));
				$blueTable = $this->Common_model->getData('redTable_users_game',$con2,$feilds,'','','','result_date ASC','result_date');
				$res = [
					"worli"=>$worli,
					"star"=>$star,
					"king"=>$king,
					"reg"=>$reg,
					"blueTable"=>$blueTable
				];
				die(json_encode($res));
			}else if($_POST['type']=='regular'){
				$con2 = " WHERE result_date > '".date('Y-m-d',strtotime("-7 days"))."' AND status NOT IN ('V','P')";
				$res = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','','result_date ASC','result_date');
				die(json_encode($res));
			}else if($_POST['type']=='starline'){
				$con2 = " WHERE result_date > '".date('Y-m-d',strtotime("-7 days"))."' AND status NOT IN ('V','P')";
				$res = $this->Common_model->getData('starline_bazar_game',$con2,$feilds,'','','','result_date ASC','result_date');
				die(json_encode($res));
			}else if($_POST['type']=='king'){
				$con2 = " WHERE result_date > '".date('Y-m-d',strtotime("-7 days"))."' AND status NOT IN ('V','P')";
				$res = $this->Common_model->getData('king_bazar_game',$con2,$feilds,'','','','result_date ASC','result_date');
				die(json_encode($res));
			}else if($_POST['type']=='MarketShear'){
				// die(json_encode($_POST));
				if($_POST['date']=='1'){
					$date=date('Y-m-d');
					$con2 = " WHERE result_date='".$date."' AND status NOT IN ('V','P')";
				}else{
					$date = explode(" - ",$_POST['date']);
					$con2 = " WHERE result_date BETWEEN '".date("Y-m-d", strtotime($date[0]))."' AND '".date("Y-m-d", strtotime($date[1]))."' AND status NOT IN ('V','P')";
				}
				$feilds = "(SUM(point_in_rs)-SUM(winning_in_rs)) as ggr";
				// $feilds = "(SUM(point)-SUM(winning_point)) as ggr";
				$worli = $this->Common_model->getData('warli_users_game',$con2,$feilds,'','','One','','');
				$star = $this->Common_model->getData('starline_bazar_game',$con2,$feilds,'','','One','','');
				$reg = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','One','','');
				$king = $this->Common_model->getData('king_bazar_game',$con2,$feilds,'','','One','','');
				$blueTable = $this->Common_model->getData('redTable_users_game',$con2,$feilds,'','','One','','');
				$res = [
					"worli"=>$worli,
					"star"=>$star,
					"king"=>$king,
					"reg"=>$reg,
					"blueTable"=>$blueTable
				];
				die(json_encode($res));
			}
		}
		$this->load->view('admin/analysis');
	}

	public function ClientList(){
        $this->load->library('pagination');
        $this->load->model('Common_model');
        $this->load->model('ManageMatkagames_Model');
        $config["base_url"] = base_url() . "Manage_Globles/client/";
        $config["total_rows"] = $this->ManageMatkagames_Model->num_rows('a_r_point');
        $config["per_page"] = 10;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{ 
            $page = 0; 
        }
        $this->data["clients"] = $this->Common_model->getData('client','','',$config["per_page"], $page,'','id desc','');
        $this->load->view('admin/ClientList',$this->data);
    }


	public function worliRoundResult(){
		$this->load->model('Common_model');
		$data['round'] = $this->Common_model->getData('worli_timer',' WHERE id="1"','round,status,roundId','','','one','','');
		$this->load->view('admin/worliRoundResult',$data);
	}

	public function changeWorliRoundStatus(){
		if($_POST['round']==1){
			$addRound['round'] = '1';
			$addRound['roundId'] = '22'.(string)time();
			$addRound['cTime']=date('Y-m-d H:i:s');
			
			$id = $addRound['roundId'];
			$msg = 'New Round Start Now.';
		}else{
			$addRound['round'] = '0';
			$id = '0';
			$msg = 'Round Stop For Result.';
		}
		$gameid = AddUpdateTable('worli_timer','id','1',$addRound);
		if($gameid){
			die(json_encode(['status'=>200,'msg'=>$msg,'roundId'=>$id]));
		}else{
			die(json_encode(['status'=>400,'msg'=>"Somthing went wrong."]));
		}
	}
	public function addWorliResultByAdmin(){
		
		$this->load->model('Common_model');
		$ak=(string)$_POST['res'];
        $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

        if($akda>9){
            $a=(string)$akda;
            $akda=$a[1];
        }
        $patti = $ak;
        $betArr['result_date'] = date('Y-m-d');
        $betArr['tableId'] = 'Matka-1';
        $betArr['gameId'] = $_POST['GameId'];
        $betArr['patti_result'] = $ak;
        $betArr['akda_result'] = $akda;
        $betArr['status'] = 'A';
		
		// die(json_encode($betArr));
        $res=AddUpdateTable('warli_result','','',$betArr);
        
        $lstAct['entry_table'] = 'Worli Buffer';
		$lstAct['supportId'] = $_SESSION['adid']['id'];
		$lstAct['created'] = date('Y-m-d H:i:s');
		$lstAct['detail'] = $akda.', '.$ak.', '.$_POST['GameId'];
		AddUpdateTable('lastActivity','','',$lstAct);

		$addRound['round'] = '1';
		$addRound['roundId'] = '22'.(string)time();
		$addRound['cTime']=date('Y-m-d H:i:s');
		
		$gameid = AddUpdateTable('worli_timer','id','1',$addRound);

        /*---------------- For Responce And Process Start ----------------*/
        if($res){
            $arr=['status'=>200,'massage'=>'Betting Start Now.','roundId'=>$addRound['roundId']];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
        }
        ob_start();
        echo json_encode($arr);
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("Connection: close");
        ob_end_flush();
        ob_flush();
        flush();


		$notifyResult['market']='Worli';
		$notifyResult['patti']=$ak;
		$notifyResult['akda']=$akda;
		$notifyResult['rResult']='SP'; //SP DP TP
		$notifyResult['url']='4ad7b357b4a728f18d6e27dea29a071e';
		notifyUserWithResult(json_encode($notifyResult));



		$notifyResult1['market']='WorliNewRound';
        $notifyResult1['roundId']=$addRound['roundId'];
        notifyUserWithResult(json_encode($notifyResult1));
        // $notifyResult['market']='Worli';
        // $notifyResult['url']='4ad7b357b4a728f18d6e27dea29a071e';
        // notifyUserWithResult(json_encode($notifyResult));
        /*---------------- For Responce And Process End ----------------*/
        
        $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$_POST['GameId'].'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
        $lC=0;
		$fbC=0;
		$oC=0;
		$com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');

		$comR = array();
		foreach ($com as $d){
			$comR[$d['client_id']] = $d['commission'];
		}

		// foreach($com as $c){
		// 	if($c['client_id']=='2'){
		// 		$lC=$c['commission'];
		// 	}else if($c['client_id']=='4'){
		// 		$fbC=$c['commission'];
		// 	}else{
		// 		$oC=$c['commission'];
		// 	}
		// }

		$cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
		$cR = array();
		foreach ($cCR as $d){
			$cR[$d['id']] = $d['currancy_rate'];
		}

		foreach ($bets as $b) {
			$rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$b['customer_id'].'" AND partner_id="'.$b['partner_id'].'"','rate','','','One','','');       
			// if($b['partner_id']=='2'){
			// 	$commission=$lC;
			// }else if($b['partner_id']=='4'){
			// 	$commission=$fbC;
			// }else{
			// 	$commission=$oC;
			// }
			
			if($comR[$b['partner_id']]){
				$commission = $comR[$b['partner_id']];
			}else{
				$commission = 2;
			}
			
            if($b['game_name']=='4'){
                if($b['game']==$akda){
                    $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
                    $bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
                    $bArr['status']='L';
					$bArr['winning_in_rs']=0;
                    $bArr['commission_in_rs']=0;
                }
            }else{
                if($b['game']==$patti){
                    $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                    if($rOC){
                        $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                        $bArr['commission'] = ($commission / 100) * $win;
                        $bArr['winning_point'] = $win - $addRes['commission'];
                    }else{
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                    }
					$bArr['status']='W';
					$bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                    $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                }else{
                    $bArr['commission']=0;
                    $bArr['winning_point']=0;
                    $bArr['status']='L';
					$bArr['winning_in_rs']=0;
                    $bArr['commission_in_rs']=0;
                }
            }
            $res1=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);  
        }
        $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
        foreach($arrLoss as $l){
            $con=" WHERE partner_id='".$l['id']."' AND round_id='".$_POST['GameId']."'";
            if($l['id']=='2'){
                $con.=' AND status="W"';
                $arrReq['dataRes']=$data->GameId;
            }
            $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$_POST['GameId'].'"','transaction_id,status,winning_point,commission,customer_id','','','','','');
            $arrReq['code']='601';
			$arrReq['market_code']='701';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Instant Worli';
			// if($l['id']=="4"){
			//     responseLog($arrReq);
			// }
            $req = requestForClient($l['end_point_url'],$arrReq);
        }
        if($res&&$res1){
            $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
        }else{
            $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
        }
        $notifyMeW['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
        $notifyMeL['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['GameId'].'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
        $notifyResult['resultStatus']=$notifyMeW['userList'];
        notifyUserWithResult(json_encode($notifyResult));
        requestForBalance(json_encode($notifyMeW));
        requestForBalance(json_encode($notifyMeL));
        die(json_encode($arr));
	}
	 
	public function refreshPage(){
		$notifyResult['market']='refresh';
        notifyUserWithResult(json_encode($notifyResult));
		die(json_encode(['status'=>200,'massage'=>'Page Refresh']));
	}
	
	public function selectCuttingMarketData(){
        $this->load->model('Common_model');
        $data['bazar']=$this->Common_model->getData('regular_bazar',' WHERE status="A" AND bazar_type!="Home"','','','','','','');
        $this->load->view('admin/sendMarketDataWhatsApp',$data);
    }
}