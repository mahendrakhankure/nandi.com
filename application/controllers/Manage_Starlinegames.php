<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';



/**

 * Class : Manage_Starlinegames (Manage_Starlinegames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class Manage_Starlinegames extends BaseController{



	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('login');

	}


	public function index(){
		// echo '<pre>working';
	 //    print_r();
	 //    die();
		$tableName = 'starline_bazar_time';
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Starlinegames');
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
		    $status = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordSL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Starlinegames';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['status'] = $status;
			$this->data['starlinegame'] = $this->LoadData_Model->loadDataSL($tableName, $bazarName, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/manage_starlinegames', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataSL($tableName, $bazarName, $status, $offset, $record_per_page);
			 
			$this->loadPageSL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status); 	  
		}	 
	}
	
	public function addStarlineGame($id=''){
		if ($id > 0 ) {
			$this->load->model('ManageStarlinegames_Model');
			$con='WHERE starline_bazar_time.id="'.$id.'"';
			$data['chartGameName'] = $this->ManageStarlinegames_Model->getstarlinegame($con,'one');
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'status' => "A", 
			);
			if ($id > 0) {
				$addgamename['time']=$_POST['gametime'][0];
				$gameaddid = AddUpdateTable('starline_bazar_time', 'id', $id, $addgamename);
			}else{
				foreach($_POST['gametime'] as $t){
					$addgamename['time']=$t;
					$gameaddid = AddUpdateTable('starline_bazar_time', '', '', $addgamename);
				}
			}
			$gameaddid = 1;
			if ($gameaddid > 0) {
				redirect('Manage_Starlinegames');
			}
		}
		$this->load->model('Common_model');
		$data['bazarList']=$this->Common_model->getData('starline_bazar','','','','','','');
		// $data['bazarList'] = getAllRecord('starline_bazar','','','','','');
		$this->load->view('admin/add_new_startline_game',$data);
	}

	public function addNewBhav($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('starline_bhav','id',$id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'game_name' => $_POST['game_name'],
				'rate' => $_POST['rate'], 
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('starline_bhav', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('starline_bhav', '', '', $addgamename);
			}
			$gameaddid = 1;
			if ($gameaddid > 0) {
				redirect('Manage_Starlinegames/bhavList');
			}
		}
		$this->load->model('Common_model');
		$data['bazarList'] = $this->Common_model->getData('starline_bazar','','id,bazar_name','','','','','');
		$data['gameList'] = $this->Common_model->getData('starline_game_type','','id,game_name','','','','','');
		$this->load->view('admin/addNewBhav',$data);
	}


	public function addNewGameType($id=''){

		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('starline_game_type','id',$id);
			 
		}
		if ($_POST) {
			$addgamename = array(
				// 'bazar_name' => $_POST['bazar_name'],
				'game_name' => $_POST['game_name'],
				'priority' => $_POST['priority'], 
				'status' => "A", 
				'updated_by' => $_SESSION['adid']['id']
			);
			 
			if ($id > 0) {
				$gameaddid = AddUpdateTable('starline_game_type', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('starline_game_type', '', '', $addgamename);
			}
			$gameaddid = 1;
			if ($gameaddid > 0) {
				redirect('Manage_Starlinegames/gameTypeList');
			}
		}
		$this->load->model('Common_model');
	    $con = ' WHERE status="A"';
	    $data['bazarList'] = $this->Common_model->getData('starline_bazar',$con,'id,bazar_name','','','','');

		$this->load->view('admin/addNewGameType',$data);
	}

	public function addNewBazar($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('starline_bazar','id',$id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'status' => "A", 
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('starline_bazar', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('starline_bazar', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				redirect('Manage_Starlinegames/bazarList');
			}
		}
		$this->load->model('Common_model');
		$this->Common_model->getData('starline_bazar','','','','','','');
		$this->load->view('admin/addNewBazar',$data);
	}


	public function removeTimefromTable(){

		$deleteTime = deleteRecord('chart_time','id',$_POST['removeid']);

		if ($deleteTime > 0) {

			$jsonreturn['successmsg'] = 'deleted';

		}else{

			$jsonreturn['successmsg'] = 'error';

		}

		echo json_encode($jsonreturn);exit;

	}

	public function deleteGame($gameid='',$table){
		$returnval = deleteRecord($table, 'id', $gameid);
		if ($returnval > 0) {
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	public function loadPageSL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status)	{
		$output = '';
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game</th>
			<th>Game Time</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["time"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addStarlineGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	  
  
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
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		// }
		echo $output;	
	}

	public function searchResultSL()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Starlinegames';
		$cnMethod = 'searchResultSL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordSL($tableName, $bazarName, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataSL($tableName, $bazarName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageSL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status);
   	}


   	public function bhavList(){

		$tableName = 'starline_bhav';
		$record_per_page = 10;
		$cnMethod = trim('bhavList');
		$cnName = trim('Manage_Starlinegames');
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
			$total_records = $this->LoadData_Model->countRecordSLAB($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Starlinegames';
			$this->data['controllerFunction'] = 'bhavList';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['gameName'] = $gameName;
			$this->data['starlinegameslab'] = $this->LoadData_Model->loadDataSLAB($tableName, $bazarName, $gameName, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages; 
			$this->load->view('admin/bhavList', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataSLAB($tableName, $bazarName, $gameName, $offset, $record_per_page);
			$this->loadPageSLAB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName); 	  
		}
	}

	public function loadPageSLAB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName)	{
		$output = '';
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Bhav</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["rate"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addNewBhav/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\')">'.$i.'</span>';	  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function searchResultSLAB()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Starlinegames';
		$cnMethod = 'searchResultSLAB';
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
		    // print_r($total_records);
			// die();
			$total_records = $this->LoadData_Model->countRecordSLAB($tableName, $bazarName, $gameName);
			 
	   } 
	   $data = $this->LoadData_Model->loadDataSLAB($tableName, $bazarName, $gameName, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageSLAB($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName);
    }

    public function gameTypeList(){

		$tableName = 'starline_game_type';
		$record_per_page = 10;
		$cnMethod = trim('gameTypeList');
		$cnName = trim('Manage_Starlinegames');
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
			$gameName = '';
		    $status = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordSLGTL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Starlinegames';
			$this->data['controllerFunction'] = 'gameTypeList';
			$this->data['total_records'] = $total_records; 
			$this->data['gameName'] = $gameName;
			$this->data['status'] = $status;
			$this->data['starlinegameslgtl'] = $this->LoadData_Model->loadDataSLGTL($tableName,  $gameName, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			 
			$this->load->view('admin/gameTypeList', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataSLGTL($tableName, $gameName, $status, $offset, $record_per_page);
			 
			$this->loadPageSLGTL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status); 	  
		}	 

	}

	public function loadPageSLGTL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status)	{
		$output = '';
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game Name</th>
			<th>Priority</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["priority"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addNewGameType/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\')">'.$i.'</span>';	  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function searchResultSLGTL()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Starlinegames';
		$cnMethod = 'searchResultSLGTL';
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
			$total_records = $this->LoadData_Model->countRecordSLGTL($tableName, $gameName, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataSLGTL($tableName, $gameName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageSLGTL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status);
    }

  	public function bazarList(){

		$tableName = 'starline_bazar';
		$record_per_page = 10;
		$cnMethod = trim('bazarList');
		$cnName = trim('Manage_Starlinegames');
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
		    $status = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordSLBL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Starlinegames';
			$this->data['controllerFunction'] = 'bazarList';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['status'] = $status;
			$this->data['starlinegamebl'] = $this->LoadData_Model->loadDataSLBL($tableName, $bazarName, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/bazarList', $this->data);
		}else {
			 
			$tableData = $this->LoadData_Model->loadDataSLBL($tableName, $bazarName, $status, $offset, $record_per_page);
			$this->loadPageSLBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status); 	  
		}	 
	}

	public function loadPageSLBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status)	{
		$output = '';
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addNewBazar/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	  
  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLBL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function searchResultSLBL()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Starlinegames';
		$cnMethod = 'searchResultSLBL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordSLBL($tableName, $bazarName, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataSLBL($tableName, $bazarName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageSLBL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status);
    }

}