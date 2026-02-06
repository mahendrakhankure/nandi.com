<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Kingbazarallresult (Manage_Kingbazarallresult)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_Kingbazarallresult extends BaseController {

    

	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('login');

	}



	// public function index(){
	//     $this->load->library('pagination');
	// 	$this->load->model('ManageKingbazarallresult_Model');
	//     $config["base_url"] = base_url() . "Manage_Kingbazarallresult/index/";
	//     $config["total_rows"] = $this->ManageKingbazarallresult_Model->num_rows();
	//     $config["per_page"] = 10;
	//     $config['cur_tag_open'] = '&nbsp;<a class="current">';
	//     $config['cur_tag_close'] = '</a>';
	//     $config['next_link'] = 'Next';
	//     $config['prev_link'] = 'Previous';
	//     $this->pagination->initialize($config);
	//     if($this->uri->segment(3)){
	// 		$page = $this->uri->segment(3);
	//     }else{ 
	// 		$page = 0; 
	//     }
	//     $this->data["kingbazarallresult"] = $this->ManageKingbazarallresult_Model->getkingbazarallresultdetails('','',$config["per_page"], $page);
	//     $this->load->view('admin/manage_kingbazarallresult',$this->data);
	// }


	public function index(){		 
		$tableName = 'king_bazar_result';
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Kingbazarallresult');
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$bazarName = $_POST['bazarName'];
		    $resultDate = $_POST['resultDate'];
		    $status = $_POST['status'];
			$page = $_POST['page'];
			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*10; 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$bazarName = '';
		    $resultDate = '';
		    $status = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');	 
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordKBAR($tableName); 
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Kingbazarallresult';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['resultDate'] = $resultDate;
			$this->data['status'] = $status;
			$this->data['kingbazarar'] = $this->LoadData_Model->loadDataKBAR($tableName, $bazarName, $resultDate, $status, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			  
			$this->load->view('admin/manage_kingbazarallresult', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataKBAR($tableName, $bazarName, $resultDate, $status, $offset, $record_per_page);
			// print_r($total_records.'<br/>');
			// print_r($tableData);
			// die();
			$this->loadPageKBAR($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate, $status); 	  
		}	 
	}




	public function AddKingBazarResult($id=''){
		$this->load->model('ManageKingbazarallresult_Model');
		$data['kingbazarallgame'] = $this->ManageKingbazarallresult_Model->getkingbazarallGame();
		if ($id > 0) {
			$data['onegamedata'] = getRecordById('king_bazar_result', 'id', $id);
		}
		if ($_POST) {
			$addResult = array(
				'bazar_name' => $_POST['bazar_name'], 
				'result' => $_POST['result'], 
				'result_date' => $_POST['result_date'], 
				'announcer' => 1, 
				'status' => "A",
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$updateresultid = AddUpdateTable('king_bazar_result', 'id', $id, $addResult);
			}else{
				if(!in_array($_POST['bazar_name'], ['3','8','10','13'])){
					
					$notifyResult['bazar_name']=$_GET['bazar_name'];
					$notifyResult['market']='jackpotroller';
					$notifyResult['result_patti'] = $nAK;
					$notifyResult['akda']=$my[$i];
					$note = notifyUserWithResult(json_encode($notifyResult));
					$addResult['token'] = transactionID(10,10).time();
					$updateresultid = AddUpdateTable('king_bazar_result', '', '', $addResult);
				}else{
					$addResult['token'] = transactionID(10,10).time();
					$updateresultid = AddUpdateTable('king_bazar_result', '', '', $addResult);
					// echo '<pre>';
					// print_r($this->db->last_query());
					// die();
				}
			}
			if ($updateresultid > 0) {
				$Common_model = $this->load->model('Common_model');
				$lstAct['entry_table'] = 'King Bazar Result';
				$lstAct['supportId'] = $_SESSION['adid']['id'];
				$lstAct['created'] = date('Y-m-d H:i:s');

				$conLst = ' INNER JOIN king_bazar ON king_bazar_result.bazar_name=king_bazar.id WHERE king_bazar_result.bazar_name="'.$_POST['bazar_name'].'" AND king_bazar_result.result_date="'.$_POST['result_date'].'"';
				$feildsLst = 'king_bazar_result.result,king_bazar.bazar_name,king_bazar_result.result_date';

				$lst = $this->Common_model->getData('king_bazar_result',$conLst,$feildsLst,'','','One','','');

				$lstAct['detail'] = implode(', ',$lst);
				AddUpdateTable('lastActivity','','',$lstAct);

                
                $sR['bazar']=$lst['bazar_name'];
				$sR['result']=$addResult['result'];
                $sR['result_date']=$_POST['result_date'];
                $url='https://channapoha.com/Postdata/kingbazarresult';
                sendResultDpboss($sR,$url);
				// redirect('Manage_Kingbazarallresult');
				$dnew['bazarId'] = (int)$_POST['bazar_name'];
				$dnew['resultDate'] = $_POST['result_date'];
				$dnew['result']=(string)$addResult['result'];
				$dnew['marketCode'] = 501;
				// $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
				$url = config_item('resultsite_url');
				$res = sendResultDpbossNewProject(json_encode($dnew),$url);
				$addResData['response'] = $res;
				$addResData['client_id'] = 0;
				$addUpdate = AddUpdateTable('client_response', '', '', $addResData);
			}
			redirect('721466737f6712c1f81542599265fd77');
		}
		$this->load->view('admin/add_king_bazzar_result',$data);
	}



	public function deleteBazzarResult($gameid=''){
		$chartgame = deleteRecord('king_bazar_result','id',$gameid);
		if ($chartgame > 0) {
			redirect('Manage_Kingbazarallresult');
		}
	}


	public function loadPageKBAR($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate, $status)	{
		$output = '';
		$record_per_page = 10;

		// print_r("Table Data is : ".$tableData);
		// die();

		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Result</th>
			<th>Result Date</th>
			<th>status</th>
			<th>Winners</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["result"].'</td>
					<td>'.$d["result_date"].'</td>
					<td>'.$d["status"].'</td>
					<td>'.$d["akda"].'</td>
					<td> </td>
					<td  class="text-center"><a href="'.base_url().'Manage_Kingbazarallresult/AddKingBazarResult/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBAR(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBAR(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$status.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKBAR('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$status.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKBAR('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$status.'\')">'.$i.'</span>';	  
  
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
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKBAR(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$status.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function searchResultKBAR()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Kingbazarallresult';
		$cnMethod = 'searchResultKBAR';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$resultDate = $_POST['resultDate'];
		$status = $_POST['status'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordKBAR($tableName, $bazarName, $resultDate, $status);
	   } 
	   $data = $this->LoadData_Model->loadDataKBAR($tableName, $bazarName, $resultDate, $status, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	    
	   $this->loadPageKBAR($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate, $status);
    }

}