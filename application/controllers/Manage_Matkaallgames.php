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

class Manage_Matkaallgames extends BaseController{



	function __construct(){

	    parent::__construct();

	    // if(! $this->session->userdata('adid'))

	    // redirect('login');

	}

	 

	 

	public function index(){
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Matkaallgames');
		  
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
		    $bazarDate = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		} 

		if($flag == 0){
			$tableName = 'regular_bazar_result';
		}
		$this->load->model('LoadData_Model');
		if($flag == 0)	{
			$total_records = $this->LoadData_Model->countRecordMAG($tableName);
			$this->data['tableName'] = 'regular_bazar_result';
			$this->data['controllerName'] = 'Manage_Matkaallgames';
			$this->data['controllerFunction'] = 'index';
			$this->data['total_records'] = $total_records; 
			$this->data['bazarName'] = $bazarName;
			$this->data['bazarDate'] = $bazarDate;
			$this->data['matkaallgame'] = $this->LoadData_Model->loadDataMAG($tableName, $bazarName, $bazarDate, $offset=0, $record_per_page); 
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/manage_matkaallgames', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataMAG($tableName, $bazarName, $bazarDate, $offset, $record_per_page);
			$this->loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $bazarDate); 
			  
		}	 
	}


	public function AddAllGameResult($id=''){
		if($_SESSION){
			$this->load->model('ManageMatkaallgames_Model');
			$data['matkaallgame'] = $this->ManageMatkaallgames_Model->getmatkagameallGame();
			if ($id > 0) {
				$data['onegamedata'] = getRecordById('regular_bazar_result', 'id', $id);
			}
			if ($_POST) {
				$this->load->model('Common_model');
				$addResult = array(
					'bazar_name' => $_POST['bazar_name'], 
					'open' => $_POST['open'], 
					'jodi' => $_POST['jodi'],
					'updated_by' => $_SESSION['adid']['id']
				);
				$dnew['open'] = (string)$_POST['open'];
				$dnew['jodi'] = (string)$_POST['jodi'];
				$notifyResult['bazarID'] = $_POST['bazar_name'];
				if ($id > 0) {
					$addResult['close']= $_POST['close'];
					$updateresultid = AddUpdateTable('regular_bazar_result', 'id', $id, $addResult);
					$wU = 'Close';
					$notifyResult['result']=$_POST['open'].'-'.$_POST['jodi'].'-'.$_POST['close'];
					$sR['close_result']=$addResult['close'];
					$dnew['close'] = (string)$_POST['close'];
				}else{
					$bazarCon = " WHERE bazar_name='".$_POST['bazar_name']."' AND result_date='".$_POST['result_date']."'";
					$lastResult = $this->Common_model->getData('regular_bazar_result',$bazarCon,'','','','One','','');
					if($lastResult){
						$this->session->set_flashdata('error', 'Result Allready Added!');
						redirect('/Manage_Matkaallgames/AddAllGameResult');
					}else{
						$addResult['created']= date('Y-m-d H:i:s');
						$addResult['announcer']= '1';
						$addResult['status']= "A";
						$addResult['result_date']= $_POST['result_date'];
						$addResult['token_open']=transactionID(10,10);
						$addResult['token_close']=transactionID(11,11);
						$updateresultid = AddUpdateTable('regular_bazar_result', '', '', $addResult);
						$wU = 'Open';
						$notifyResult['result']=$_POST['open'].'-'.$_POST['jodi'];
						$sR['close_result']='';
						$dnew['close']=NULL;
					}
				}
				if ($updateresultid > 0) {
					$lstAct['entry_table'] = 'Regular Bazar Result';
					$lstAct['supportId'] = $_SESSION['adid']['id'];
					$lstAct['created'] = date('Y-m-d H:i:s');

					$conLst = ' INNER JOIN regular_bazar ON regular_bazar_result.bazar_name=regular_bazar.id WHERE regular_bazar_result.bazar_name="'.$_POST['bazar_name'].'" AND regular_bazar_result.result_date="'.$_POST['result_date'].'"';
					$feildsLst = 'regular_bazar_result.open,regular_bazar_result.jodi,regular_bazar_result.close,regular_bazar.bazar_name,regular_bazar_result.result_date';
					$lst = $this->Common_model->getData('regular_bazar_result',$conLst,$feildsLst,'','','One','','');
					
					$lstAct['detail'] = implode(', ',$lst);
					AddUpdateTable('lastActivity','','',$lstAct);
					
					$notifyResult['market']='Regular';
					$notifyResult['type']=$wU;
					
					$notifyResult['url']='9a27a7e97c16a7b3ac6382d21205357f/'.$_POST['bazar_name'];
					notifyUserWithResult(json_encode($notifyResult));

					$sR['open_result']=$addResult['open'];
					$sR['jodi_result']=$addResult['jodi'];
					
					$sR['bazar_name']=$_POST['bazar_name'];
					$sR['result_date']=$_POST['result_date'];
					$url='https://channapoha.com/postdata';
					$res=sendResultDpboss($sR,$url);
					responseLog($res);
					// echo '<pre>';
					// print_r($res);
					// die();
					$dnew['bazarId'] = (int)$sR['bazar_name'];
					$dnew['resultDate'] = $sR['result_date'];
					$dnew['marketCode'] = 301;
					// $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
					$url = config_item('resultsite_url');
					$res = sendResultDpbossNewProject(json_encode($dnew),$url);
					
					$addResData['response'] = $res;
					$addResData['client_id'] = 0;
					$addUpdate = AddUpdateTable('client_response', '', '', $addResData);


					// send alert to admin start
					$message = "*Game Result - {$lst['bazar_name']} ({$wU}) - {$_POST['result_date']} Result : {$notifyResult['result']} Added By {$_SESSION['adid']['name']}*\n\n";
					// $sendTo = ['sir','khemal','golu','harsh'];
            		$sendTo = ['+447366180310','8208684855','9608010101'];
					foreach($sendTo as $to){
						$res = sendWhatsApp($message,$to);
					}
					// send alert to admin end
					redirect('f2356c74eddd4a15682b144eaacb3071');
					// redirect('Manage_Matkaallgames');
				}
			}
			$this->load->view('admin/add_allgame_result',$data);
		}else{
			redirect('admin/login');
		}
	}

	public function deleteGame($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('regular_bazar_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('Manage_Matkaallgames');

		}

	}

	public function updateWallet(){
		$this->load->model('Common_model');
		$this->load->model('ManageMatkaallgames_Model');
		if(isset($_POST)){
			foreach($_POST as $data){
	        	$bet = $this->Common_model->getData('regular_bazar_games',' WHERE id="'.$data.'"','partner_id,customer_id,bazar_name,game_name,result_date,point','','','One','','');
	        	$rate = $this->Common_model->getData('regular_bazar_rate',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_name="'.$bet['game_name'].'"','rate','','','One','','');
				$addResult['commission'] = (2 / 100) * $bet['point']*$rate['rate'];
				$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];
				$addResult['status']= 'W';
				$updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addResult);
			}
			$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."'";
			$field['status']="L";
			$updateresultLose = updateAllLose('regular_bazar_games', $con, $field);
			$arr=[
				'status'=>200,
				'message'=>'Wallet Updated Successfully!'
			];
		}else{
			$arr=[
				'status'=>400,
				'message'=>'Somthing Went Wrong'
			];
		}
		die(json_encode($arr));
	}


	public function searchResult()	{ 
		 
		 $output = '';
		 $record_per_page = 10;
		 $page = 1;
		 $cnName = 'Manage_Matkaallgames';
		 $cnMethod = 'searchResult';
		 $tableName = $_POST['tableName'];
		 $bazarName = $_POST['bazarName'];
		 $bazarDate = $_POST['bazarDate'];
		 $total_records = $_POST['total_records'];
		 if(isset($_POST['page']))	{
			$page = $_POST['page'];
		 }
		 
		 $offset =($page-1)*5;
		 $this->load->model('LoadData_Model');
		 if($offset == 0 || $page == 1)	{
			 $total_records = $this->LoadData_Model->countRecordMAG($tableName, $bazarName, $bazarDate);
		 } 
		 $data = $this->LoadData_Model->loadDataMAG($tableName, $bazarName, $bazarDate, $offset, $record_per_page); 
		 // echo '<pre>';print_r($data);die();
		 $total_pages = ceil($total_records/$record_per_page);
		 $this->loadPage($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $bazarDate);
	}

	public function loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $bazarDate)	{
		$output = '';
		$record_per_page = 10;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Bazar Name</th>
			<th>Open</th>
			<th>Jodi</th>
			<th>Close</th>
			<th>Result Date</th>
			<th>Open</th>
			<th>Close</th>
			<th class="text-center">Actions</th>
		</tr>';
		//Replaced $tableData by $this->data['matkagame']
		// echo '<pre>';print_r($tableData);die();
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				if(!empty($d["open"])){
					$o = getWinnersOpen($d['id']);
					$op = '';
					if(!empty($o)){
	                    $op = "<span id='".$d['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($o).','.$d['id'].")'>".count($o)."</span>";
	                }else{
	                    $p = checkPending("regular_bazar_games",$d['bazar_id'],$d['result_date']," AND game_type = 'Open'");
	                    if(!empty($p)){
	                        $op = "<span id='".$d['id']."' class='btn btn-success' onclick='updatePending(".json_encode($p).','.$d['id'].")'>".count($p)."</span>";
	                    }
	                }
				}

				// $op = empty($o) ? "" : "<span id='".$d['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($o).','.$d['id'].")'>".count($o)."</span>";
				if($d["close"]){
					$c = getWinnersClose($d['id']); 
					$cp = '';
					if(!empty($c)){
	                    $cp = "<span id='".$d['id'].$d['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($c).','.$d['id'].$d['id'].")'>".count($c)."</span>";
	                }else{
	                    $p = checkPending("regular_bazar_games",$d['bazar_id'],$d['result_date']," AND (game_type = 'Close' || game_type = 'Jodi')");
	                    if(!empty($p)){
	                        $cp = "<span id='".$d['id'].$d['id']."' class='btn btn-success' onclick='updatePending(".json_encode($p).','.$d['id'].$d['id'].")'>".count($p)."</span>";
	                    }
	                }
				}
				// $cp = empty($c) ? "" : "<span id='".$d['id'].$d['id']."' class='btn btn-success' onclick='updateWallet(".json_encode($c).','.$d['id'].")'>".count($c)."</span>";
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["open"].'</td>
					<td>'.$d["jodi"].'</td>
					<td>'.$d["close"].'</td>
					<td>'.$d["result_date"].'</td>
					<td>'.$op.'</td>
					<td>'.$cp.'</td>
					<td  class="text-center"><a href="'.base_url().'Manage_Matkaallgames/AddAllGameResult/'.$d["id"].'"><i class="fa fa-pencil"></i></a></td>
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
			//	$lowest = $page;
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMAG(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$bazarDate.'\',\''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMAG(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$bazarDate.'\',\''.$current_page.'\')">Prev</span>';
				 }
				// $output .=	'<span id="prev" style="cursor: pointer; margin: 0px 10px;" onClick="loadpage(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$gameName.'\',\''.$gameMode.'\')">Prev</span>'; 	  
			}
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMAG('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$bazarDate.'\')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if($total_pages >= $page)	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageMAG('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$bazarDate.'\')">'.$i.'</span>';	  
  
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
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextMAG(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\',\''.$bazarName.'\',\''.$bazarDate.'\',\''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		
		echo $output;	
		
	}

	public function updateLossBet(){
		$this->load->model('Common_model');
		$this->load->model('ManageMatkaallgames_Model');
		if(isset($_POST)){
			$con=" WHERE game_type='".$_POST['type']."' AND result_date='".$_POST['result_date']."' AND status='P' AND bazar_name='".$_POST['bazar_name']."'";
			$field['status']="L";
			$updateresultLose = updateAllLose('regular_bazar_games', $con, $field);
			$arr=[
				'status'=>200,
				'message'=>'Wallet Updated Successfully!'
			];
		}else{
			$arr=[
				'status'=>400,
				'message'=>'Somthing Went Wrong'
			];
		}
		die(json_encode($arr));
	}


	public function allRegularBetList(){
		$record_per_page = 10;
		$cnMethod = trim('index');
		$cnName = trim('Manage_Matkaallgames');
		  
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
		    $bazarDate = '';
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		} 
		if($flag == 0){
			$tableName = 'regular_bazar_games';
		}
		$this->load->model('LoadData_Model');
		$this->load->model('Common_model');
		if($flag == 0)	{
			$tr = $this->Common_model->getData('regular_bazar_games','','COUNT(id)','','One','','');
			
			$this->data['tableName'] = 'regular_bazar_games';
			$this->data['controllerName'] = 'Manage_Matkaallgames';
			$this->data['controllerFunction'] = 'allRegularBetList';
			$this->data['total_records'] = $tr[0]['COUNT(id)']; 
			$this->data['bazarName'] = $bazarName;
			$this->data['bazarDate'] = $bazarDate;

			$feilds = "regular_bazar_games.transaction_id,regular_bazar_games.customer_id, regular_bazar_games.id, regular_bazar_games.bazar_name as bazar_id, regular_bazar.bazar_name, regular_bazar_games.result_date, regular_bazar_games.game, regular_bazar_games.point, regular_bazar_games.status, regular_bazar_games.winning_point, regular_game_type.game_name, regular_game_type.id as game_id";

			$con .= " INNER JOIN regular_bazar ON regular_bazar_games.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_games.game_name = regular_game_type.id";
		
		    $con .= " ORDER BY regular_bazar_games.id DESC";
		    $con .= " Limit $offset, $record_per_page";

			$this->data['matkaallgame'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,10,$offset,'','');
			// echo 'working<pre>';print_r($this->data['matkaallgame']);die();
		}
		$total_pages = ceil($total_records/$record_per_page);
		 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages;
			$this->load->view('admin/allRegularBetList', $this->data);
		}else {
			$tableData = $this->LoadData_Model->loadDataMAG($tableName, $bazarName, $bazarDate, $offset, $record_per_page);
			$this->loadPage($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $bazarName, $bazarDate); 
			  
		}	 
	}


	public function testSocketForResult(){
		$notifyResult['market']='Regular';
        $notifyResult['type']='Open';
        $notifyResult['result']='123'.'-'.'6';
        
        $notifyResult['url']='9a27a7e97c16a7b3ac6382d21205357f/'.'4';
        echo json_encode($notifyResult);
	}

	public function spinTheWheelTest(){
		// echo '<pre>';
		// $CI = get_instance();
		// $CI->load->model('Common_model');
		// $CI->load->model('ManageMatkaallgames_Model');
		// $d = ['885470'];
		// $lC = 0;
		// $fbC = 0;
		// $com = $CI->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
		// $clinetC = array();
		// foreach ($com as $c) {
		// 	$clinetC[$c['client_id']] = $c['commission'];
		// }
		// $cCR = $CI->Common_model->getData('client', '', 'id,currancy_rate', '', '', '', '', '');
		// $cR = array();
		// foreach ($cCR as $ek) {
		// 	$cR[$ek['id']] = $ek['currancy_rate'];
		// }
		// foreach ($d as $data) {
			
		// 	$bet = $CI->Common_model->getData('king_bazar_game', ' WHERE id="' . $data . '"', 'exchange_rate,transaction_id,bazar_name,game_name,result_date,point,partner_id', '', '', 'One', '', '');
			
		// 	$commission = $clinetC[$bet['partner_id']];
		// 	print_r($commission);
		// 	$rate = $CI->Common_model->getData('king_bazar_rate', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_type="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');


		// 	$addResult['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
		// 	$addResult['winning_point'] = ($bet['point'] * $rate['rate']) - $addResult['commission'];
		// 	$addResult['winning_in_rs'] = $addResult['winning_point'] * (double)$bet['exchange_rate'];
		// 	$addResult['commission_in_rs'] = $addResult['commission'] * (double)$bet['exchange_rate'];

		// 	$addResult['status'] = 'W';
		// 	die(json_encode($addResult));
		// 	// $updateresultid = AddUpdateTable('king_bazar_game', 'id', $data, $addResult);
		// }
		$this->load->model('Common_model');
		$arr = ['50','51','52','53','54','55','56','57','58','59','60','61']; // for market 3
		$arr = ['1','3','4','5','6','7','8','9','37']; // for market 1
		$result = $this->getStarlineResultByPercentageTest('3','53');
		echo '<pre>';
		print_r($result);
		die();
		echo '<pre>';
		foreach($arr as $a){
			$result = $this->getStarlineResultByPercentageTest($_GET['bazar_name'],$a);
			print_r($result);
		}
		
		$result = $this->getStarlineResultByPercentageTest('3','55');
		print_r($result);
		die();
	}
	public function spinTheWheel(){
		
		$this->load->model('Common_model');
		$notifyResult['bazar_name']=$_GET['bazar_name'];
		if($_GET['type'] == 'king'){

			$conLst = ' WHERE id="'.$_GET['bazar_name'].'"';
			$feildsLst = 'bazar_name';
			$lst = $this->Common_model->getData('king_bazar',$conLst,$feildsLst,'','','One','','');
			$sR['bazar']=$lst['bazar_name'];

			$notifyResult['market']='jackpotroller';
			$t = 1;
			// $con = ' WHERE bazar_name="'.$_GET['bazar_name'].'" AND result_date="2024-07-30"';
			$con = ' WHERE bazar_name="'.$_GET['bazar_name'].'" AND result_date="'.date('Y-m-d').'"';
			$table = 'king_bazar_result';
			$feild = 'id,result';
			$patti = getJodi();
		}else if($_GET['type'] == 'starline'){
			$notifyResult['market']='spinTheWheel';
			$notifyResult['time']=$_GET['time'];
			$t = 2;
			$con = ' WHERE bazar_name="'.$_GET['bazar_name'].'" AND result_date="'.date('Y-m-d').'" AND time="'.$_GET['time'].'"';
			$table = 'starline_bazar_result';
			$feild = 'id,result_patti';
			$patti = getPana();
			$sR['bazar']=$_GET['bazar_name'];
			$sR['time']=$_GET['time']; 
			$d = $this->Common_model->getData('starline_bazar_time',' WHERE id="'.$_GET['time'].'"','time','','','one','','');
			$sR['tm'] = $d['time'];
		}
		if($_GET['type'] == 'king'){
			// $nAK = $patti[rand(0,count($patti))];
			$newNak = $this->getKingBazarResultByPercentage($_GET['bazar_name']);
			$nAK = $newNak['game'];
			$my = $nAK;
		}else{
			$givenTime = $d['time'];
			$currentTime = date('H:i:s'); // Current server time

			if (strtotime($currentTime) <= strtotime($givenTime)) {
				exit('Not allowed yet. Please wait until the given time.');
			}
			// $s = [rand(0,9), rand(0,9), rand(0,9)];
			$result = $this->getStarlineResultByPercentage($_GET['bazar_name'],$_GET['time']);
			$s = $result['game'];
			sort($s, SORT_STRING);
			$k=$s[0].$s[1].$s[2];
			if($s[0]==0&$s[1]==0){
				$k = $s[2].$s[1].$s[0];
			}else if($s[0]==0){
				$k = $s[1].$s[2].$s[0];
			}
			$nAK = $k;
			$my = str_shuffle($nAK);
		}
		
		
		if($_GET['type'] == 'king'){
			$addResult = array(
				'bazar_name' => $_GET['bazar_name'], 
				'result_date' => date('Y-m-d'), 
				'status' => 'A', 
				'announcer' => '1',
				'token' => transactionID(25,25).time(),
				'result'=> $nAK,
				'updated_by'=> 0
			);
		}else{
			$addResult = array(
				'bazar_name' => $_GET['bazar_name'], 
				'time' => $_GET['time'], 
				'result_date' => date('Y-m-d'), 
				'status' => 'A', 
				'announcer' => '1',
				'token' => transactionID(25,25).time(),
				'result_patti'=> $nAK,
				'updated_by'=> 0
			);
		}
		
		for ($i=0; $i <= $t; $i++) {
			if($i==$t){
				$notifyResult['result_patti'] = $nAK;
				if($_GET['type'] == 'king'){
					$sR['result_date']=date('Y-m-d');
					$url='https://channapoha.com/Postdata/kingbazarresult';

					$dnew['bazarId'] = (int)$_GET['bazar_name'];
					$dnew['resultDate'] = date('Y-m-d');
					$dnew['result']=(string)$nAK;
					$dnew['marketCode'] = 501;
				}else{
					$akda = $my[0]+$my[1]+$my[2];
					if($akda > 9){
						$quotient = intdiv($akda, 10);
						$addResult['result_akda']=(string)($akda - (10 * $quotient));
						$notifyResult['result_akda'] = (string)$addResult['result_akda'];
					}else{
						$addResult['result_akda']=(string)$akda;
						$notifyResult['result_akda']=(string)$akda;
					}
					$sR['date']=date('Y-m-d');
					$sR['resultdigit']=$notifyResult['result_akda'];
					$url='https://channapoha.com/postdata/starlineresult';

					$dnew['bazarId'] = (int)$_GET['bazar_name'];
					$dnew['timeId'] = (int)$_GET['time'];
					$dnew['resultDate'] = date('Y-m-d');
					$dnew['patti']=(string)$nAK;
					$dnew['akda']=(string)$notifyResult['result_akda'];
					$dnew['marketCode'] = 401;
				}
				$d = $this->Common_model->getData($table,$con,$feild,'','','one','','');
				if($d){
					die(json_encode(['status'=>401,'massage'=>'Already Updated']));
				}
				$updateresultid = AddUpdateTable($table, '', '', $addResult);
				$sR['result']=$nAK;
				
				$res=sendResultDpboss($sR,$url);
				$addResData['response'] = $res;
				$addResData['client_id'] = 1;
				$addUpdate = AddUpdateTable('client_response', '', '', $addResData);

				// $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
				$url = config_item('resultsite_url');
				$res = sendResultDpbossNewProject(json_encode($dnew),$url);
				$addResData['response'] = $res;
				$addResData['client_id'] = 0;
				$addUpdate = AddUpdateTable('client_response', '', '', $addResData);
			}
			
			$notifyResult['akda']=$my[$i];
			$note = notifyUserWithResult(json_encode($notifyResult));
			sleep(12); // this should halt for 11 seconds for every loop
		}
		$d = $this->Common_model->getData($table,$con,$feild,'','','one','','');
		
		$id = $d['id'];
		if($_GET['type'] == 'king'){
			$data = getWinnersKing($id);
			if(empty($data)){
				$dL['ids'] = $this->Common_model->getData('king_bazar_game',$con,'id','','','','','');
				$dL['res'] = $d;
				$wallet = updatePendingKing($dL);
			}else{
				$wallet = updateWalletKing($data);
			}
		}else{
			$data = getWinnersStar($id);
			if(empty($data)){
				$dL['ids'] = $this->Common_model->getData('starline_bazar_game',$con,'id','','','','','');
				$dL['res'] = $d;
				$wallet = updatePendingStar($dL);
			}else{
				$wallet = updateWalletStar($data);
			}
		}
		die(json_encode(['status'=>200,'massage'=>'Result Updated Successfully!']));
	}


	public function getStarlineResultByPercentageTest($bazarId,$time){
        if(isset($bazarId)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('starline_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            
            // $con = " WHERE result_date='2025-06-30' AND bazar_name='".$bazarId."' AND time='".$time."'";
            $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."' AND time='".$time."'";
            $conPatti = $con;
            $allPatti = getPana();
            
            $akda=getVariationPatti('SingleAkda');
            
            $feild = "SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('starline_bazar_game',$con." AND (game > 99 OR game='000')","SUM(point_in_rs) as point,COUNT(DISTINCT customer_id) as customer",'','','One','','');
            
            $con .= " AND game IN ('".implode("','",$akda)."')";
            $ak = $this->Common_model->getData('starline_bazar_game',$con,$feild,'','','','game asc','game');
			
			// die(json_encode($this->db->last_query()));
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
			if(empty($ak)){
				$ak = [['game'=>0],['game'=>1],['game'=>2],['game'=>3],['game'=>4],['game'=>5],['game'=>6],['game'=>7],['game'=>8],['game'=>9]];
				// $ak = [0,1,2,3,4,5,6,7,8,9];
			}
            foreach($ak as $k){
				if(!isset($k['game'])){
					$k['game'] = $k;
				}
                $p = getAllPattiByDigit($k['game']);
				
                $tr = $k['game'].$k['game'].$k['game'];
                array_push($p,$tr);
                $patti = $this->Common_model->getData('starline_bazar_game',$conPatti." AND game IN ('".implode("','",$p)."')",'SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer','','','','game asc','game');
                $arrPatti[$k['game']] = $patti;

                foreach($patti as $e){
                    array_push($newArrPatti,$e);
                }
            }
			
            $totalBet = $sum+$pattiBet['point'];
            $profit =  (($totalBet/100)*$per['per']);
            
            $i = 0;
            $jArr = [];
            $pArr = [];
            foreach($newArrPatti as $n){
                $akSum = 0;
                $digits = str_split((string) abs($n['game']));
                foreach ($digits as $digit) {
                    $akSum += $digit;
                }
                if($akSum>9){
                    $myAk = str_split($akSum);
                    $akSum = $myAk[1];
                }
                $panaType = checkPanaType($n['game']);
                if($panaType === 'SP'){
                    $parrRate = 140;
                }else if($panaType === 'DP'){
                    $parrRate = 280;
                }else if($panaType === 'TP'){
                    $parrRate = 800;
                }
                $m['customer'] = $ak[$akSum]['customer']+$n['customer'];
                $m['game']=$n['game'];
                $m['akdaPoint'] = $ak[$akSum]['point'];
                $m['pattiPoint'] = $n['point'];
                $m['win'] = ($n['point']*$parrRate)+($ak[$akSum]['point']*9.7);
                $m['prof'] = $totalBet-$m['win'];
                array_push($pArr,$m);
                $i++;
            }
           
            $result=array_diff($allPatti,array_column($pArr, 'game'));
            
			
            if(!empty($result)){
                foreach($result as $balPatti){
                    $panaType = checkPanaType($balPatti);
                    if($panaType === 'SP'){
                        $parrRate = 140;
                    }else if($panaType === 'DP'){
                        $parrRate = 280;
                    }else if($panaType === 'TP'){
                        $parrRate = 800;
                    }
                    $akSum = 0;
                    $digits = str_split((string) abs($balPatti));
                    
                    foreach ($digits as $digit) {
                        $akSum += $digit;
                    }

                    if($akSum>9){
                        $myAk = str_split($akSum);
                        $akSum = $myAk[1];
                    }
                    
                    $m['customer'] = $ak[$akSum]['customer'];
                    $m['pattiPoint'] = 0;
                    $m['game'] = $balPatti;
                    // $jd = $arr[$akda][$akSum];
					// print_r($ak[$akSum]['point']);
					// echo '<br>';
                    $m['akdaPoint'] = $ak[$akSum]['point'];
                    $m['win'] = ($ak[$akSum]['point']*9.7);
                    $m['prof'] = $totalBet-$m['win'];
                    array_push($pArr,$m);
                }
            }
			// print_r($ak);
			// die();
            $key = 'prof';
            usort($pArr, function ($a, $b) use ($key) {
                return $b[$key] <=> $a[$key];
            });
			
			$sp = [];
			$dp = [];
			$tp = [];
			foreach ($pArr as $item) {
				$game = (string)$item['game']; // Convert to string to check digits
				if ($game === '' || !ctype_digit($game)) continue; // Skip empty or non-numeric game values
				$digits = str_split($game);
				if (count($digits) === count(array_unique($digits))) {
					$sp[] = $item;
				}else  if (count(array_unique($digits)) === 1) {
					$dp[] = $item;
				}else{
					$tp[] = $item;
				}
			}
			
            $resultPatti = $this->findProfitableArray($sp, 'prof', $profit);
            if(!$resultPatti){
                $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
            }
            // die(json_encode($resultPatti));
			if($profit=='0'){
				$resultPatti = $pArr[array_rand($pArr)];
			}
            return $resultPatti;
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
    }


	public function getStarlineResultByPercentage($bazarId,$time){
        if(isset($bazarId)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('starline_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            
            $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."' AND time='".$time."'";
            $conPatti = $con;
            $allPatti = getPana();
            
            $akda=getVariationPatti('SingleAkda');
            
           
            $feild = "SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('starline_bazar_game',$con." AND (game > 99 OR game='000')","SUM(point_in_rs) as point,COUNT(DISTINCT customer_id) as customer",'','','One','','');
            
            $con .= " AND game IN ('".implode("','",$akda)."')";
            $ak = $this->Common_model->getData('starline_bazar_game',$con,$feild,'','','','game asc','game');
            
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
			if(empty($ak)){
				// $ak = $akda;
				$ak = [['game'=>0],['game'=>1],['game'=>2],['game'=>3],['game'=>4],['game'=>5],['game'=>6],['game'=>7],['game'=>8],['game'=>9]];
				// $ak = [0,0,0,0,0,0,0,0,0,0];
			}
            foreach($ak as $k){
				if(!$k['game']){
					$k['game'] = $k;
				}
                $p = getAllPattiByDigit($k['game']);
                $tr = $k['game'].$k['game'].$k['game'];
                array_push($p,$tr);
                $patti = $this->Common_model->getData('starline_bazar_game',$conPatti." AND game IN ('".implode("','",$p)."')",'SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer','','','','game asc','game');
                $arrPatti[$k['game']] = $patti;
                foreach($patti as $e){
                    array_push($newArrPatti,$e);
                }
            }
            $totalBet = $sum+$pattiBet['point'];
            $profit =  (($totalBet/100)*$per['per']);
            
            $i = 0;
            $jArr = [];
            $pArr = [];
            foreach($newArrPatti as $n){
                $akSum = 0;
                $digits = str_split((string) abs($n['game']));
                foreach ($digits as $digit) {
                    $akSum += $digit;
                }
                if($akSum>9){
                    $myAk = str_split($akSum);
                    $akSum = $myAk[1];
                }
                $panaType = checkPanaType($n['game']);
                if($panaType === 'SP'){
                    $parrRate = 140;
                }else if($panaType === 'DP'){
                    $parrRate = 280;
                }else if($panaType === 'TP'){
                    $parrRate = 800;
                }
                $m['customer'] = $ak[$akSum]['customer']+$n['customer'];
                $m['game']=$n['game'];
                $m['akdaPoint'] = $ak[$akSum]['point'];
                $m['pattiPoint'] = $n['point'];
                $m['win'] = ($n['point']*$parrRate)+($ak[$akSum]['point']*9.7);
                $m['prof'] = $totalBet-$m['win'];
                array_push($pArr,$m);
                $i++;
            }
            
            $result=array_diff($allPatti,array_column($pArr, 'game'));
            
            if(!empty($result)){
                foreach($result as $balPatti){
                    $panaType = checkPanaType($balPatti);
                    if($panaType === 'SP'){
                        $parrRate = 140;
                    }else if($panaType === 'DP'){
                        $parrRate = 280;
                    }else if($panaType === 'TP'){
                        $parrRate = 800;
                    }
                    $akSum = 0;
                    $digits = str_split((string) abs($balPatti));
                    
                    foreach ($digits as $digit) {
                        $akSum += $digit;
                    }

                    if($akSum>9){
                        $myAk = str_split($akSum);
                        $akSum = $myAk[1];
                    }
                    
                    $m['customer'] = $ak[$akSum]['customer'];
                    $m['pattiPoint'] = 0;
                    $m['game'] = $balPatti;
                    // $jd = $arr[$akda][$akSum];
                    $m['akdaPoint'] = $ak[$akSum]['point'];
                    $m['win'] = ($ak[$akSum]['point']*9.7);
                    $m['prof'] = $totalBet-$m['win'];
                    array_push($pArr,$m);
                }
            }
            $key = 'prof';
            usort($pArr, function ($a, $b) use ($key) {
                return $b[$key] <=> $a[$key];
            });

			$sp = [];
			$dp = [];
			$tp = [];
			foreach ($pArr as $item) {
				$game = (string)$item['game']; // Convert to string to check digits
				if ($game === '' || !ctype_digit($game)) continue; // Skip empty or non-numeric game values
				$digits = str_split($game);
				if (count($digits) === count(array_unique($digits))) {
					$sp[] = $item;
				}else  if (count(array_unique($digits)) === 1) {
					$dp[] = $item;
				}else{
					$tp[] = $item;
				}
			}


			
            // $resultPatti = $this->findProfitableArray($sp, 'prof', $profit);
			// if(!$resultPatti){
			// 	$resultPatti = $this->findProfitableArray($dp, 'prof', $profit);
            // }
			// if(!$resultPatti){
            //     $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
            // }
            $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
            if(!$resultPatti){
                $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
            }
			if($profit=='0'){
				$resultPatti = $pArr[array_rand($pArr)];
			}
            // die(json_encode($resultPatti));
            return $resultPatti;
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
    }

	public function getKingBazarResultByPercentage($bazarId){
        if(isset($bazarId)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('king_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."'";
            $feild = "SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('king_bazar_game',$con,"SUM(point_in_rs) as point,COUNT(DISTINCT customer_id) as customer",'','','One','','');
            $ak = $this->Common_model->getData('king_bazar_game',$con." AND game > 9",$feild,'','','','game asc','game');
            $akR = $this->Common_model->getData('king_bazar_game',$con." AND game < 9 AND game_name=1",$feild,'','','','game asc','game');
            $akL = $this->Common_model->getData('king_bazar_game',$con." AND game < 9 AND game_name=2",$feild,'','','','game asc','game');
            $rate = $this->Common_model->getData('king_bazar_rate'," WHERE bazar_name='".$bazarId."'",'','','','','','');
            $rt = [];
            foreach($rate as $k){
                $rt[$k['game_type']] = $k['rate']; 
            }
            $result=array_diff(getJodiForKingBazar(),array_column($ak, 'game'));
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $colAk = array_column($ak, 'game');
            $colAkR = array_column($akR, 'game');
            $colAkL = array_column($akL, 'game');
            for($i=0;$i<100;$i++){
                $z['point'] = 0;
                $z['customer'] = 0;
                $z['win'] = 0;
                $z['prof'] = 0;
                $s = ''.$i;
                if($i < 10){
                    $s = '0'.$i;
                }
                $z['game'] = $s;
                if(in_array($s,$colAk)){
                    foreach($ak as $a){
                        if($s==$a['game']){
                            $z['win'] += $a['point']*$rt['3'];
                            $z['point'] += $a['point'];
                            $z['customer'] += $a['customer'];
                        }
                    }
                }
                if(in_array($s[0],$colAkR)){
                    foreach($akR as $ar){
                        if($s[0]==$ar['game']){
                            $z['win'] += $ar['point']*$rt['1'];
                            $z['point'] += $ar['point'];
                            $z['customer'] += $ar['customer'];
                        }
                    }
                }
                if(in_array($s[1],$colAkL)){
                    foreach($akR as $ar){
                        if($s[1]==$ar['game']){
                            $z['win'] += $ar['point']*$rt['2'];
                            $z['point'] += $ar['point'];
                            $z['customer'] += $ar['customer'];
                        }
                    }
                }
                $z['prof'] = $pattiBet['point'] - $z['win'];
                array_push($arr,$z);
            }
            $totalBet = $pattiBet['point'];
            $profit =  (($totalBet/100)*$per['profit']);
            $key = 'prof';
            usort($arr, function ($a, $b) use ($key) {
                return $b[$key] <=> $a[$key];
            });
            $resultPatti = $this->findProfitableArray($arr, 'prof', $profit);
            if(!$resultPatti){
                $resultPatti = $this->findClosestArray($arr, 'prof', $profit);
            }
            // die(json_encode($resultPatti));
            return $resultPatti;
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
    }


	public function getDashboardData(){
		$this->load->model('Common_model');
		$con=' WHERE result_date="'.date('Y-m-d', strtotime(' -1 day')).'" AND status NOT IN ("V","P")';
		
		$con1 = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Home')";
		$con2 = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='InHome')";
		$con3 = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Out')";
		$feilds='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, SUM(commission) as com, COUNT(DISTINCT customer_id) as player';
		$rHome = $this->Common_model->getData('regular_bazar_games',$con1,$feilds,'','','One','','');
		// echo '<pre>';
		// print_r($rHome);
		// die();
		$rInHome = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','One','','');
		$rOut = $this->Common_model->getData('regular_bazar_games',$con3,$feilds,'','','One','','');
		
		$star = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
		$king = $this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');

		$worliDay = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','One','','');
		$worliNight = $this->Common_model->getData('redTable_users_game',$con,$feilds,'','','One','','');
		// $data['goldenTable'] = $this->Common_model->getData('goldenTable_users_game',$con,$feilds,'','','One','',''); //we close the golden table
        
		$a['rHomeBet']=$rHome['id'];
		$a['rInHomeBet']=$rInHome['id'];
		$a['rOutBet']=$rOut['id'];

		$a['rHomeAmount']=$rHome['point'];
		$a['rInHomeAmount']=$rInHome['point'];
		$a['rOutAmount']=$rOut['point'];

		$a['rHomeWin']=$rHome['win'];
		$a['rInHomeWin']=$rInHome['win'];
		$a['rOutWin']=$rOut['win'];

		$a['rHomeCommission']=$rHome['com'];
		$a['rInHomeCommission']=$rInHome['com'];
		$a['rOutCommission']=$rOut['com'];

		
		$a['starlineBet']=$star['id'];
		$a['starlineAmount']=$star['point'];
		$a['starlineWin']=$star['win'];
		$a['starlineCommission']=$star['com'];

		$a['kingBazarBet']=$king['id'];
		$a['kingBazarAmount']=$king['point'];
		$a['kingBazarWin']=$king['win'];
		$a['kingBazarCommission']=$king['com'];

		$a['worliDayBet']=$worliDay['id'];
		$a['worliDayAmount']=$worliDay['point'];
		$a['worliDayWin']=$worliDay['win'];
		$a['worliDayCommission']=$worliDay['com'];

		$a['worliNightBet']=$worliNight['id'];
		$a['worliNightAmount']=$worliNight['point'];
		$a['worliNightWin']=$worliNight['win'];
		$a['worliNightCommission']=$worliNight['com'];
		$a['dateOfPnl']=date('Y-m-d', strtotime(' -1 day'));
		try {
			$g = AddUpdateTable('dashboardBKP', '', '', $a);
		}catch(Exception $e) {
			responseLog($e->getMessage());
		}
		die();
	}
	public function findClosestArray($multiArray, $columnKey, $targetValue) {
        $closestArray = null;
        $closestDiff = PHP_INT_MAX;
        foreach ($multiArray as $array) {
            if (isset($array[$columnKey])) {
                $diff = abs($array[$columnKey] - $targetValue);
                if ($diff < $closestDiff) {
                    $closestDiff = $diff;
                    $closestArray = $array;
                }
            }
        }
        return $closestArray;
    }

    public function findProfitableArray($multiArray, $columnKey, $targetValue) {
        $profitableArray = [];
        $cust = 0;
        foreach ($multiArray as $array) {
            if (isset($array[$columnKey])) {
                if ($array[$columnKey] > $targetValue) {
                    $panaType = checkPanaType($array['game']);
                    if(($cust < $array['customer'] || $cust == 0) && $panaType != 'TP'){
                        $cust = $array['customer'];
                        // array_push($profitableArray,$array);
                        $profitableArray = $array;
                    }
                }
            }
        }
        return $profitableArray;
    }
}