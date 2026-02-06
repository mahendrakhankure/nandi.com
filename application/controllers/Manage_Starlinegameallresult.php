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

Class Manage_Starlinegameallresult extends BaseController {



	function __construct(){

	    parent::__construct();

	    if(!$this->session->userdata('adid'))

	    redirect('login');

	}


	public function index(){
		 
		$tableName = 'starline_bazar_result';
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Starlinegameallresult');
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
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
		    $page = 1;
			$flag = 0;
		    $offset = 0; 
		} 
		$this->load->model('LoadData_Model');
		 
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordSLAL($tableName);
			 
			$this->data['tableName'] = $tableName;
			$this->data['controllerName'] = 'Manage_Starlinegameallresult';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['resultDate'] = $resultDate;
			$this->data['starlinegameslal'] = $this->LoadData_Model->loadDataSLAL($tableName, $bazarName, $resultDate, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			  
			$this->load->view('admin/manage_starlinegameallresult', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataSLAL($tableName, $bazarName, $resultDate, $offset, $record_per_page);  
			$this->loadPageSLAL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate); 	  
		}	 

	}


	public function AddStartLineResult($id=''){
		$this->load->model('ManageStarlinegameallresult_Model');
		$data['starlinegame'] = $this->ManageStarlinegameallresult_Model->getStarLineGame();
		if ($id > 0) {
			$data['onegamedata'] = getRecordById('starline_bazar_result', 'id', $id);
			$this->load->model('Common_model');
			$con=" WHERE id='".$data['onegamedata']['time']."'";
			$data['t'] = $this->Common_model->getData('starline_bazar_time',$con,'time','','','One','','');
		}
		if($_POST){
			$updateAddResult = array(
				'token' => transactionID(10,10), 
				'result_date' => $_POST['result_date'], 
				'bazar_name' => $_POST['bazar_name'], 
				'result_patti' => $_POST['patti'], 
				'result_akda' => $_POST['akda'], 
				'time' => $_POST['time'], 
				'announcer' => 1,
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$updateresultid = AddUpdateTable('starline_bazar_result', 'id', $id, $updateAddResult);
				$this->session->set_flashdata('success', 'Result Updated Successfully');
			}else{
				if(empty($data['onegamedata'])){
					$notifyResult['bazar_name']=$_POST['bazar_name'];
					$notifyResult['market']='spinTheWheel';
					$notifyResult['time']=$_POST['time'];
					$notifyResult['result_patti'] = $_POST['patti'];
					$notifyResult['result_akda'] = (string)$_POST['akda'];
					$notifyResult['akda']=$_POST['akda'];
					$note = notifyUserWithResult(json_encode($notifyResult));
					$updateresultid = AddUpdateTable('starline_bazar_result', '', '', $updateAddResult);
					$this->session->set_flashdata('success', 'Result Added Successfully');
				}else{
					$this->session->set_flashdata('error', 'Result Already Added');
				}
			}
			if ($updateresultid > 0) {
				$lstAct['entry_table'] = 'Starline Bazar Result';
				$lstAct['supportId'] = $_SESSION['adid']['id'];
				$lstAct['created'] = date('Y-m-d H:i:s');
				$conLst = ' INNER JOIN starline_bazar ON starline_bazar_result.bazar_name=starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id WHERE starline_bazar_result.bazar_name="'.$_POST['bazar_name'].'" AND starline_bazar_result.time="'.$_POST['time'].'" AND starline_bazar_result.result_date="'.$_POST['result_date'].'"';
				$feildsLst = 'starline_bazar_result.result_patti,starline_bazar_result.result_akda,starline_bazar_time.time,starline_bazar.bazar_name,starline_bazar_result.result_date';
				$lst = $this->Common_model->getData('starline_bazar_result',$conLst,$feildsLst,'','','One','','');
				
				$lstAct['detail'] = implode(', ',$lst);
				AddUpdateTable('lastActivity','','',$lstAct);

				$sR['resultdigit']=$updateAddResult['result_akda'];
				$sR['result']=$updateAddResult['result_patti'];
				$sR['bazar']=$updateAddResult['bazar_name'];
                $sR['date']=$updateAddResult['result_date'];
                $sR['time']=$updateAddResult['time']; 
                $url='https://channapoha.com/postdata/starlineresult';
				$res=sendResultDpboss($sR,$url);
				// redirect('Manage_Starlinegameallresult');

				$dnew['bazarId'] = (int)$_POST['bazar_name'];
				$dnew['timeId'] = (int)$_POST['time'];
				$dnew['resultDate'] = $_POST['result_date'];
				$dnew['patti']=(string)$_POST['patti'];
				$dnew['akda']=(string)$_POST['akda'];
				$dnew['marketCode'] = 401;
				// $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
				$url = config_item('resultsite_url');
				$res = sendResultDpbossNewProject(json_encode($dnew),$url);
				$addResData['response'] = $res;
				$addResData['client_id'] = 0;
				$addUpdate = AddUpdateTable('client_response', '', '', $addResData);
			}
			redirect('086a938697cd6feb6d062e6fd0c5c845');
		}
		$this->load->view('admin/add_starline_result',$data);
	}

	public function getTime(){
		$this->load->model('ManageStarlinegameallresult_Model');
		$con="WHERE bazar_name='".$_POST['id']."'";
		$time = $this->ManageStarlinegameallresult_Model->getStarLineTime($con);
		$json='<option value="">Select Bazar Name...</option>';

		foreach($time as $data){
			if($_POST['time']!='' && $data['id']==$_POST['time']){
				$json .= "<option value='".$data['id']."' selected>".$data['time']."</option>";
			}else{
				$json .= "<option value='".$data['id']."'>".$data['time']."</option>";
			}
		}
		die(json_encode($json));
	}



	public function deleteStarlineResult($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('table_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('Manage_Starlinegameallresult');

		}

	}


	public function loadPageSLAL($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate)	{
		$output = '';
		$record_per_page = 10;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Time</th>
			<th>Result Date</th>
			<th>Patti</th>
			<th>AKDA</th>
			<th>Wallet</th>
			<th class="text-center">Actions</th>
		</tr>';
		 
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				// <td>'.$d["time"].'</td>
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["bazar_time"].'</td>
					<td>'.$d["result_date"].'</td>
					<td>'.$d["result_patti"].'</td>
					<td>'.$d["result_akda"].'</td>
					<td>'.$d["wallet"].'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Starlinegameallresult/AddStartLineResult/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAL(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$current_page.'\')">Prev</span>';
				 }
				 
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSLAL('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\')">'.$i.'</span>';	  
  
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
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSLAL(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$result_date.'\',\''.$current_page.'\')">Next</span>';	
				 }
			}
		echo $output;	
		
	}

	public function searchResultSLAL()	{ 
		$output = '';
		$record_per_page = 10;
		$page = 1;
		$cnName = 'Manage_Starlinegameallresult';
		$cnMethod = 'searchResultSLAL';
		$tableName = $_POST['tableName'];
		$bazarName = $_POST['bazarName'];
		$resultDate = $_POST['resultDate'];
		$total_records = $_POST['total_records'];
	   if(isset($_POST['page']))	{
		   $page = $_POST['page'];
	   }
	   $offset =($page-1)*5;
	   $this->load->model('LoadData_Model');
	   if($offset == 0 || $page == 1)	{
			$total_records = $this->LoadData_Model->countRecordSLAL($tableName, $bazarName, $resultDate);
	   } 
	   $data = $this->LoadData_Model->loadDataSLAL($tableName, $bazarName, $resultDate, $offset, $record_per_page);
	   $total_pages = ceil($total_records/$record_per_page);
	    
	   $this->loadPageSLAL($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $resultDate);
    }
}

