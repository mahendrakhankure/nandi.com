<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

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

	    if(! $this->session->userdata('adid'))

	    redirect('login');

	}

 		public function pageCall($cnFunction, $tableName, $fields, $totalRecords, $currentPage, $offset){
		$this->load->model('LoadData_Model');
		if($offset == 0 && $cnFunction != 'searchResult')	{
			$totalRecords = $this->LoadData_Model->countRecord($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['cnFunction'] = $cnFunction;
			$this->data['total_records'] = $totalRecords; 
			$this->data['mydata'] = $this->LoadData_Model->loadData($tableName, $offset);
			if($cnFunction == 'index')	{
				$this->load->view('admin/testing', $this->data);
			}else if($cnFunction == 'bazarRateList')	{
				$this->load->view('admin/regular_bazar_rate', $this->data);
			}else if($cnFunction == 'GameTypeList')	{
				$this->load->view('admin/regular_game_type', $this->data);
			}else if($cnFunction == 'AllotBazarGamesList')	{
				$this->load->view('admin/AllotBazarGamesList', $this->data);
			}
			 
		}else {
			$tableData = $this->LoadData_Model->loadData($tableName, $fields, $offset);
			$this->loadTable($cnFunction, $tableData, $tableName, $totalPages, $currentPage, $fields); 
			  
		}	 
 	}
	 
	// public function loadTable($cnFunction, $tableData, $tableName, $totalRecords, $currentPage, $fields)	{
	//  	$recordPerPage = 10;
	//  	$totalPages = ceil($totalRecords/$recordPerPage);
	// 	$output = '';
		 
	// 	$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
	// 	<tr>
	// 	<th>SR#</th>';

	// 	if($tableName == 'regular_bazar')	{
	// 		$output .= '
	// 			<th>Game</th>
	// 			<th>Start Time</th>
	// 			<th>End TIme</th>
	// 			<th>Priority</th>
	// 			<th>Days In Week</th>
	// 			<th>Result Mode</th>';
	// 	}
	// 	$output .=  '<th class="text-center">Actions</th>
	// 	</tr>';
		 
	// 	if($tableData){ 
	// 		static $sr = 1;
	// 		foreach($tableData as $d){
	// 			$output .= '<tr>
	// 				<td>'.$sr.'</td>';
	// 			if($tableName == 'regular_bazar')	{
	// 				$output .= '<td>'.$d["bazar_name"].'</td>
	// 				<td>'.$d["open_time"].'</td>
	// 				<td>'.$d["close_time"].'</td>
	// 				<td>'.$d["sequence"].'</td>
	// 				<td>'.$d["days"].'</td>
	// 				<td>'.$d["status"].'</td>
	// 				<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGame/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>';
	// 			}
	// 			$output .= '</tr>';
	// 			$sr++;
	// 		}
	// 	}
	// 	$output .='</table> </div>';
		 
	// 	$output .= '<div class="box-footer clearfix" id="pagination">
	//     <ul class="pagination pull-right">';
		 
	// 	if($totalPages>1)	{
	// 		if($totalPages <=10 && $currentPage > 1 )	{
	// 			$prev = 1;
	// 			$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$prev.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">Previous</span>';
	// 			for($i = $currentPage; $i<=$totalPages; $i++) {
	// 				$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$i.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">'.$i.'</span>';	   
	// 			}
	// 		}else if($totalPages <=10 && $currentPage = 1 )	{
	// 			 for($i = $currentPage; $i<=$totalPages; $i++) {
	// 				$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$i.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">'.$i.'</span>';	   
	// 			 }
	// 		}else if(($totalPages > 10) && ($currentPage+9 < $totalPages))	{
	// 			$prev = $currentPage-10;
	// 			$next = $currentPage+9;
	// 			$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$prev.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">Previous</span>';
	// 			for($i = $currentPage; $i<=$currentPage+9; $i++) {
	// 				$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$i.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">'.$i.'</span>';	   
	// 			}
	// 			$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$next.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">Previous</span>';
	// 		}else {
	// 			$prev = $currentPage-10;
	// 			$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$prev.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">Previous</span>';
	// 			for($i = $currentPage; $i<=$totalPages; $i++) {
	// 				$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadTable('.$i.','.$total_records.',\''.$cnFunction.'\',\''.$tableName.'\',\''.$fields.'\')">'.$i.'</span>';	   
	// 			}
	// 		}

	// 		echo $output;		
	// 	}
	// }

	// public function searchRecords()	{ 
	// 	 $output = '';  
	// 	 $cnFunction = $_POST['cnFunction'];
	// 	 $tableName = $_POST['tableName'];
	// 	 $totalRecords = $_POST['totalRecords'];
	// 	 $currentPage = $_POST['currentPage'];
	// 	 $fields = $_POST['fields'];
	// 	 $offset =($CurrentPage-1)*5;
	// 	 $this->load->model('LoadData_Model');
	// 	 if($currentPage == 1)	{
	// 		 $total_records = $this->LoadData_Model->countRecords($tableName, $fields);
	// 	 } 
	// 	 $data = $this->LoadData_Model->loadData($tableName, $fields, $offset); 
	// 	 $this->pageCall($cnFunction, $tableName, $fields, $totalRecords, $currentPage, $offset);
	// }



	public function index(){
		$tableName = 'regular_bazar';
		$cnFunction =  'index';
		// $fields = array();
		// if(isset($_POST['page'])){
		// 	$currentPage = $_POST['page'];
		// 	$offset =($currentPage-1)*10;
		// }else {
		// 	$currentPage = 1;
		// 	$offset = 0;
		// }
		// if(isset($_POST['total_records'])){
		// 	$total_records = $_POST['total_records'];
		// }else {
		// 	$total_records = 0;
		// }
		// $this->pageCall($cnFunction, $tableName, $fields,  $total_records, $currentPage, $offset);

		 


 
		$record_per_page = 10;
		$cnName = trim('Manage_Matkagames');
		$cnMethod = trim('index');


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
		
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;

			$this->load->view('admin/manage_matkagames', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataMG($tableName, $gameName, $gameMode, $offset, $record_per_page);
			$this->loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $gameMode); 
			  
		}	 
	}

	 
	public function addNewGame($gameid=''){

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
        $this->form_validation->set_rules('days', 'Days', 'required');
        $this->form_validation->set_rules('sequence', 'Priority', 'required');
        $this->form_validation->set_rules('status', 'Result Mode', 'required');

        
        if ($_POST)  { 
         	if ($gameid > 0 && ($this->form_validation->run() != FALSE || $this->form_validation->run() =='') ) {
				$addnewGame = array(
					'bazar_name' => $_POST['bazar_name'] , 
					'open_time' => $_POST['open_time'] , 
					'close_time' => $_POST['close_time'] , 
					'days' => implode(",", $_POST['days']) , 
					'sequence' => $_POST['sequence'] , 
					'status' => $_POST['status']
				);
				AddUpdateTable('regular_bazar','id',$gameid,$addnewGame);
				redirect('Manage_Matkagames');
			}else{
				$addnewGame = array(
					'bazar_name' => $_POST['bazar_name'] ,
					'open_time' => $_POST['open_time'] , 
					'close_time' => $_POST['close_time'] ,
					'days' => implode(",", $_POST['days']) , 
					'sequence' => $_POST['sequence'] , 
					'status' => $_POST['status'] 
				);
				$gameid = AddUpdateTable('regular_bazar','','',$addnewGame);

				if ($gameid > 0) {
					$data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
				}
            	$this->load->view('admin/add_new_game',$data);		
			}

        } 
        else { 
        	 
        	if ($gameid > 0) {
				$data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
			}
            $this->load->view('admin/add_new_game',$data); 
        } 

		 
	}

	// public function addNewGame($gameid=''){

		 
	// 	if ($_POST) {
	// 		if ($gameid) {

	// 			$addnewGame = array(
	// 				'bazar_name' => $_POST['bazar_name'] , 
	// 				'open_time' => $_POST['open_time'] , 
	// 				'close_time' => $_POST['close_time'] , 
	// 				'days' => implode(",", $_POST['days']) , 
	// 				'sequence' => $_POST['sequence'] , 
	// 				'status' => $_POST['status']
	// 			);
	// 			AddUpdateTable('regular_bazar','id',$gameid,$addnewGame);
	// 		}else{
	// 			$addnewGame = array(
	// 				'bazar_name' => $_POST['bazar_name'] ,
	// 				'open_time' => $_POST['open_time'] , 
	// 				'close_time' => $_POST['close_time'] ,
	// 				'days' => implode(",", $_POST['days']) , 
	// 				'sequence' => $_POST['sequence'] , 
	// 				'status' => $_POST['status'] 
	// 			);
	// 			$gameid = AddUpdateTable('regular_bazar','','',$addnewGame);
	// 		}
	// 		if ($gameid > 0) {
	// 			redirect('Manage_Matkagames');
	// 		}
	// 	}
	// 	if ($gameid > 0) {
	// 		$data['onegamedata'] = getRecordById('regular_bazar','id',$gameid);
	// 	}
	// 	$this->load->view('admin/add_new_game',$data);
	// }

	public function deleteGame($gameid='',$table){

		$returnval = deleteRecord($table, 'id', $gameid);

		if ($returnval > 0) {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}


	public function addNewBazarRate($gameid=''){
		$this->load->model('ManageMatkagames_Model');
		if ($_POST) {
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
				redirect('Manage_Matkagames/bazarRateList');
			}
		}
		if ($gameid > 0) {
			$data['onegamedata'] = getRecordById('regular_bazar_rate','id',$gameid);
		}
		$data["matkaallBazar"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_bazar",'','','id','desc','id,bazar_name ','','');
		$data["matkaallGame"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_game_type",'','','id','desc','id,game_name ','','');
		$this->load->view('admin/add_regular_bazar_rate',$data);
	}


	 


	public function addNewGameType($gameid=''){
		$this->load->model('ManageMatkagames_Model');
		 
		if ($_POST) {
			if ($gameid) {
				$_POST['status']="A";
				AddUpdateTable('regular_game_type','id',$gameid,$_POST);
			}else{
				$gameid = AddUpdateTable('regular_game_type','','',$_POST);
			}
			if ($gameid > 0) {
				redirect('Manage_Matkagames/GameTypeList');
			}
		}
		if ($gameid > 0) {
			$data['onegamedata'] = getRecordById('regular_game_type','id',$gameid);
		}
		$this->load->view('admin/add_regular_game_type',$data);
	}


     

    public function allotNewBazarGames($gameid=''){
		$this->load->model('ManageMatkagames_Model');
		if ($_POST) {
			if ($gameid) {
				$_POST['status']="A";
				AddUpdateTable('allot_regular_bazar_game','id',$gameid,$_POST);
			}else{
				$gameid = AddUpdateTable('allot_regular_bazar_game','','',$_POST);
			}
			if ($gameid > 0) {
				redirect('Manage_Matkagames/AllotBazarGamesList');
			}
		}
		if ($gameid > 0) {
			$data['onegamedata'] = getRecordById('allot_regular_bazar_game','id',$gameid);
		}
		$data["bazar"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_bazar",'', '','sequence','asc','* ','','');
		$data["game_type"] = $this->ManageMatkagames_Model->getmatkagamedetails("regular_game_type",'', '','sequence','asc','* ','','');
		$this->load->view('admin/allotNewBazarGames',$data);
	}


	public function searchResult()	{ 
		 $output = '';
		 $record_per_page = 10;
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
		$record_per_page = 10;
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
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMG(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		// }
		echo $output;		
	}

	public function bazarRateList(){
		$tableName = "regular_bazar_rate";
		$record_per_page = 10;
		$cnMethod = trim('bazarRateList');
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
			$total_records = $this->LoadData_Model->countRecordMGBL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Matkagames';
			$this->data['controllerFunction'] = 'bazarRateList';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['gameName'] = $gameName;
			$this->data['matkagamebl'] = $this->LoadData_Model->loadDataMGBL($tableName, $bazarName, $gameName, $offset=0, $record_per_page); 
		}
		 
		$total_pages = ceil($total_records/$record_per_page);
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/regular_bazar_rate', $this->data);
		}else { 
		 
			$tableData = $this->LoadData_Model->loadDataMGBL($tableName, $bazarName, $gameName, $offset, $record_per_page);
			$this->loadPageBL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $gameName);   
		}	 
	}
	public function searchResultBL()	{ 
		$output = '';
		$record_per_page = 10;
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
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Commission</th>
			<th>Rate</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["commission"].'</td>
					<td>'.$d["rate"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewBazarRate/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGBL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function GameTypeList(){
		$tableName = "regular_game_type";
		$record_per_page = 10;
		$cnMethod = trim('GameTypeList');
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
			$total_records = $this->LoadData_Model->countRecordMGGTL($tableName);
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Matkagames';
			$this->data['controllerFunction'] = 'GameTypeList';
			$this->data['total_records'] = $total_records; 
			$this->data['gameName'] = $gameName;
			$this->data['status'] = $status;
			$this->data['matkagamegtl'] = $this->LoadData_Model->loadDataMGGTL($tableName, $gameName, $status, $offset=0, $record_per_page); 
		}
		 
		$total_pages = ceil($total_records/$record_per_page);
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/regular_game_type', $this->data);
		}else { 
			 
			$tableData = $this->LoadData_Model->loadDataMGGTL($tableName, $gameName, $status, $offset, $record_per_page);
			$this->loadPageGTL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $gameName, $status);   
		}
	}

	public function searchResultGTL()	{ 
		$output = '';
		$record_per_page = 10;
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
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Game Name</th>
			<th>Sequence</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["sequence"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/addNewGameType/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGGTL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
	}

	public function AllotBazarGamesList(){
		$tableName = "allot_regular_bazar_game";
		$record_per_page = 10;
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
		$record_per_page = 10;
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
		$record_per_page = 10;
		 
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Sequence</th>
			<th>Status</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["sequence"].'</td>
					<td>'.$d["status"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkagames/allotNewBazarGames/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMGABGL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$gameName.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}
}