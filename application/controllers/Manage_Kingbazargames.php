<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

 

Class Manage_Kingbazargames extends BaseController {

	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('login');

	}



	public function index(){
		$tableName = 'king_bazar';
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Kingbazargames');
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
			$total_records = $this->LoadData_Model->countRecordKB($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Kingbazargames';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['status'] = $status;
			$this->data['kingbazargames'] = $this->LoadData_Model->loadDataKB($tableName, $bazarName, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/manage_kingbazargames', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataKB($tableName, $bazarName, $status, $offset, $record_per_page);
			 
			$this->loadPageKB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status); 	  
		}	 
	}




	public function addKingBazzarGame($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('king_bazar', 'id', $id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'], 
				'time' => $_POST['time'],
				'updated_by'=>$_SESSION['adid']['id']
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('king_bazar', 'id', $id, $addgamename);
			}else{
				$addgamename['status']="A";
				$gameaddid = AddUpdateTable('king_bazar', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				redirect('Manage_Kingbazargames');
			}
		}
		$this->load->view('admin/add_new_kingbazzar_game',$data);
	}


	 


	public function addNewKingBazarBhav($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('king_bazar_rate', 'id', $id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'], 
				'game_type' => $_POST['game_type'], 
				'rate' => $_POST['rate']
			);

			if ($id > 0) {
				$gameaddid = AddUpdateTable('king_bazar_rate', 'id', $id, $addgamename);
			}else{
				$addgamename['status']="A";
				$gameaddid = AddUpdateTable('king_bazar_rate', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				redirect('Manage_Kingbazargames/bazarBhavList');
			}
		}
		$this->load->model('Common_model');
		$data['bhavList'] = $this->Common_model->getData('king_bazar','','','','','','id desc','');
		// $data['bhavList'] = getAllRecord('king_bazar','','','','','');
		$this->load->view('admin/add_new_kingbazzar_bhav',$data);
	}

	public function deleteBazzarGame($gameid=''){

		$chartgame = deleteRecord('king_bazar','id',$gameid);

		if ($chartgame > 0) {

			redirect('Manage_Kingbazargames');

		}

	}



 	public function loadPageKB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status){
		$output = '';
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game</th>
			<th>Start Time</th>
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
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addKingBazzarGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\')">'.$i.'</span>';	  
  
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
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		
		echo $output;	
	}

	public function searchResultKB()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Kingbazargames';
		$cnMethod = 'searchResultKB';
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
			$total_records = $this->LoadData_Model->countRecordKB($tableName, $bazarName, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataKB($tableName, $bazarName, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageKB($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $status);
    }

    public function bazarBhavList(){

		$tableName = 'king_bazar_rate';
		$record_per_page = 10;
		$cnMethod = trim('bazarBhavList');
		$cnName = trim('Manage_Kingbazargames');
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
			$gameType = '';
		    $status = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordKBBL($tableName);
			 
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Kingbazargames';
			$this->data['controllerFunction'] = 'bazarBhavList';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['gameType'] = $gameType;
			$this->data['status'] = $status;
			$this->data['kingbazargames'] = $this->LoadData_Model->loadDataKBBL($tableName, $bazarName, $gameType, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/kingBazarBhavlist', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataKBBL($tableName, $bazarName, $gameType, $status, $offset, $record_per_page);
			$this->loadPageKBBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameType, $status); 	  
		}	 

	}

	public function loadPageKBBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameType, $status)	{
		$output = '';
		$record_per_page = 10;
		
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Type</th>
			<th>Bhav</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>';
					if($d["game_type"] == 1)	{
						$output .= '<td>First Digit(Ekai)</td>';
					}else if($d["game_type"] == 2)	{
						$output .= '<td>Second Digit(Haruf)</td>';
					}else if($d["game_type"] == 3)	{
						$output .= '<td>Jodi</td>';
					}
					$output .= '<td>'.$d["rate"].'</td>';
					$output .= '<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegames/addNewKingBazarBhav/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameType.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBBL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameType.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKBBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameType.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKBBL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameType.'\',\''.$status.'\')">'.$i.'</span>';	  
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
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBBL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameType.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		 
		echo $output;	
	}

	public function searchResultKBBL()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Kingbazargames';
		$cnMethod = 'searchResultKBBL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$gameType = $_POST['gameType'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordKBBL($tableName, $bazarName, $gameType, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataKBBL($tableName, $bazarName, $gameType, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	   $this->loadPageKBBL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameType, $status);
    }

}