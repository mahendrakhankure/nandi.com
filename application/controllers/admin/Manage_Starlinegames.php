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

	    redirect('admin/login');

	}

	public function bazarTimeList(){
	    if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getStarlineBazarTimeData($postData);
		    echo json_encode($data);
		}else{
			// $this->load->view('admin/bazarList'); 
		    $this->load->model('ManageStarlinegames_Model');
		    $this->load->library('pagination');
		    $data['starlinegame'] = $this->ManageStarlinegames_Model->getstarlinegame();
		    
		    $this->load->view('admin/manage_starlinegames',$data);
		}
	}

	public function addStarlineGame($id=''){
		if ($id > 0 ) {
			$data['chartGameName'] = getRecordById('chart_game', 'id', $id);
			$data['chartGameTime'] = getAllcustomeRecordById('chart_time','game_name',$data['chartGameName']['game'],array('id','time'));
		}
		if ($_POST) {
			$addgamename = array(
				'game' => $_POST['game_name'], 
				'created' => date('Y-m-d H:i:s'), 
				'updated' => date('Y-m-d H:i:s') 
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('chart_game', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('chart_game', '', '', $addgamename);
			}
			$gameaddid = 1;
			if ($gameaddid > 0) {
				$gametimecount = count($_POST['gametime']);
				for ($i=0; $i < $gametimecount; $i++) { 
					$addgametime = array(
						'game_name' => $_POST['game_name'], 
						'time' => $_POST['gametime'][$i], 
						'created' => date('Y-m-d H:i:s'),
						'updated' => date('Y-m-d H:i:s')  
					);
					if ($_POST['timeid'][$i] > 0 ) {
						AddUpdateTable('chart_time', 'id', $_POST['timeid'][$i], $addgametime);
					}else{
						AddUpdateTable('chart_time', '', '', $addgametime);
					}
				}
				redirect('admin/Manage_Starlinegames');
			}
		}
		$this->load->view('admin/add_new_startline_game',$data);
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

	public function deleteGame($gameid=''){

		$chartgame = getRecordById('chart_game','id',$gameid);

		$returnval2 = deleteRecord('chart_time', 'game_name', $chartgame['game']);

		$returnval = deleteRecord('chart_game', 'id', $gameid);

		if ($returnval > 0 && $returnval2 >0 ) {

			redirect('admin/Manage_Starlinegames');

		}

	}

	public function starlineMarketBetRecords(){
		$this->load->model('Common_model');
		$List = $this->Common_model->getData('starline_bazar','','id, bazar_name','','','','','');
		$con1=' WHERE result_date="'.date('Y-m-d').'"';
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point,SUM(winning_in_rs) as win,COUNT(DISTINCT customer_id) as cid,SUM(commission) as com';
		// $feilds='COUNT(id) as id,SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid';
	    $arr['inP'] = $this->Common_model->getData('starline_bazar_game',$con1,$feilds,'','','One','','');
        $arr['inP']['ggr']=$arr['inP']['point']-$arr['inP']['win'];

		// $arr['arr']=[];
		$con=' INNER JOIN starline_bazar ON starline_bazar_game.bazar_name=starline_bazar.id WHERE starline_bazar_game.result_date="'.date('Y-m-d').'"';
		$feilds='starline_bazar.id as bazar_id,starline_bazar.bazar_name as bazarName,COUNT(starline_bazar_game.id) as id,SUM(starline_bazar_game.point_in_rs) as point,SUM(winning_in_rs) as win,SUM(point_in_rs-winning_in_rs) as ggr,COUNT(DISTINCT starline_bazar_game.customer_id) as player,SUM(commission) as com';
        // $feilds='starline_bazar.id as bazar_id,starline_bazar.bazar_name as bazarName,COUNT(starline_bazar_game.id) as id,SUM(starline_bazar_game.point) as point,SUM(winning_point) as win,SUM(point-winning_point) as ggr,COUNT(DISTINCT starline_bazar_game.customer_id) as player';
        $arr['arr'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','','','starline_bazar.bazar_name');
        // foreach ($List as $dataArray) {
        //     $con=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$dataArray['id'].'"';
        //     $bazarResult = $this->Common_model->getData('starline_bazar_game',$con,'COUNT(id) as id,SUM(point) as point','','','One','','');
        //     $bazarResult['bazar_id'] = $dataArray['id'];
        //     $bazarResult['bazarName'] = $dataArray['bazar_name'];
        //     array_push($arr['arr'],$bazarResult);
        // }
		$this->load->view('admin/starlineBetRecords',$arr);
	}

	public function starlineMarketTimeBetRecords($id,$name){
		$this->load->model('Common_model');
		$con=' WHERE bazar_name="'.$id.'"';
		$List = $this->Common_model->getData('starline_bazar_time',$con,'id, time','','','','','');
		$arr['arr']=[];
        $arr['bazarName'] = $name;
        foreach ($List as $dataArray) {
            $con=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$id.'" AND time="'.$dataArray['id'].'"';
			$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
			// $feilds='COUNT(id) as id,SUM(point) as point';
            $bazarResult = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            $bazarResult['time_id']=$dataArray['id'];
            $bazarResult['time']=$dataArray['time'];
            array_push($arr['arr'],$bazarResult);
        }
        $arr['bazar_id'] = $id;
		$this->load->view('admin/starlineTimeBetRecords',$arr);
	}

	public function starlineMarketTypeRecords($bazarId,$timeId,$name){
		$this->load->model('Common_model');
		$con=' WHERE status="A"';
		$List = $this->Common_model->getData('starline_game_type',$con,'id, game_name','','','','','');
		$arr['arr']=[];
        $arr['bazarName'] = $name;
        $arr['time_id']=$timeId;
        $arr['res']=$this->Common_model->getData('starline_bazar_result',' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazarId.'" AND time="'.$timeId.'"','result_patti,result_akda','','','One','','');
        foreach ($List as $dataArray) {
            $con=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name="'.$dataArray['id'].'"';
            $feilds='COUNT(id) as id,SUM(point_in_rs) as point';
			// $feilds='COUNT(id) as id,SUM(point) as point';
			$bazarResult = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            $bazarResult['game_name']=$dataArray['game_name'];
            $bazarResult['game_id']=$dataArray['id'];
            array_push($arr['arr'],$bazarResult);
        }
        $arr['bazar_id'] = $bazarId;
		$this->load->view('admin/starlineTypeRecords',$arr);
	}

	public function starlineMarketGameRecords($bazarId,$timeId,$gameId,$bazarName,$gameName){
        $arr['bazarName'] = $bazarName;
        $arr['gameName'] = $gameName;
        $arr['time_id']=$timeId;
        $arr['bazar_id'] = $bazarId;
        $arr['gameId'] = $gameId;
		$this->load->model('Common_model');
        $arr['res']=$this->Common_model->getData('starline_bazar_result',' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazarId.'" AND time="'.$timeId.'"','result_patti,result_akda','','','One','','');
		$arr['arr']=[];
		if($gameId=='2' || $gameId=='13' || $gameId=='25'){
			for($i=0; $i < 10; $i++) {
				$con=' WHERE bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name="'.$gameId.'" AND game="'.$i.'" AND result_date="'.date('Y-m-d').'"';
            	$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
				// $feilds='COUNT(id) as id,SUM(point) as point';
				$res = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            	$res['akda']=$i;
            	array_push($arr['arr'],$res);
			}
		}else {
			if($gameId=='1' || $gameId=='14' || $gameId=='26'){
				if($gameId=='1'){
					$ar = ['1','5','6','12'];
				}else if($gameId=='14'){
					$ar = ['14','17','18','23'];
				}else{
					$ar = ['26','30','31','35'];
				}
				$patti=getPanaList('SINGLEPATTI');
			}else if($gameId=='3' || $gameId=='15' || $gameId=='27'){
				$patti=getPanaList('DOUBLEPATTI');
				if($gameId=='3'){
					$ar = ['3','7','8','9'];
				}else if($gameId=='15'){
					$ar = ['15','19','20','21'];
				}else{
					$ar = ['27','32','33','34'];
				}
			}else if($gameId=='4' || $gameId=='16' || $gameId=='28'){
				$patti=getPanaList('TRIPLEPATTI');
				if($gameId=='4'){
					$ar = ['4','10','11'];
				}else if($gameId=='15'){
					$ar = ['16','22','24'];
				}else{
					$ar = ['28','29','36'];
				}
			}
			foreach($patti as $d) {
				$con=' WHERE bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name IN ("'.implode('","',$ar).'") AND game="'.$d.'" AND result_date="'.date('Y-m-d').'"';
            	$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
				$res = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            	$res['akda']=$d;	
            	array_push($arr['arr'],$res);
			}
		}
		$this->load->view('admin/starlineGameRecords',$arr);
	}

	public function rollBackResult($id=''){
		$this->load->model('Common_model');
		
		$con = " INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id INNER JOIN starline_bazar ON starline_bazar_result.bazar_name=starline_bazar.id WHERE starline_bazar_result.id='".$id."'"; 
		$feilds = 'starline_bazar.id as bazar_id,starline_bazar.bazar_name,starline_bazar_result.result_date,starline_bazar_result.id,starline_bazar_result.result_patti,starline_bazar_result.result_akda,starline_bazar_time.time,starline_bazar_time.id as time_id';
		$result = $this->Common_model->getData('starline_bazar_result',$con,$feilds,'','','One','','');
		
		if ($_POST) {
			
			$addgamename = array(
				'result_patti' => $_POST['result_patti'], 
				'result_akda' => $_POST['result_akda'], 
				'updated' => date('Y-m-d H:i:s') 
			);
			$gameaddid = AddUpdateTable('starline_bazar_result', 'id', $id, $addgamename);
			
			if ($gameaddid) {

	    		$con=" WHERE result_date='".$_POST['result_date']."' AND bazar_name='".$result['bazar_id']."' AND time='".$result['time_id']."'";
	    		$field['status']="P";
				$field['winning_point']="0";
				$field['commission']="0";
				$field['winning_in_rs']="0";
				$field['commission_in_rs']="0";
	    		$updateresultLose = updateAllLose('starline_bazar_game', $con, $field);

	    		/*--------------------- Setel Market Start --------------------------*/
	    		$con1=" INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='".$result['result_date']."' AND starline_bazar_game.bazar_name='".$result['bazar_id']."' AND time='".$result['time_id']."'";


	    		$arrLossPartner = $this->Common_model->getData('starline_bazar_game',$con1,'DISTINCT starline_bazar_game.partner_id,client.end_point_url','','','','','');
	    		foreach($arrLossPartner as $l){
	    			$con=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_id']."' AND time='".$result['time_id']."'";
	    			$arrLossBet = $this->Common_model->getData('starline_bazar_game',$con,'transaction_id,customer_id,status','','','','','');
	    			$arrReq['code']='901';
		    		$arrReq['arr']=json_encode($arrLossBet);
		    		$arrReq['market']='Starline Bazar';
					$arrReq['market_code']='401';
					// echo '<pre>';
					// print_r($arrReq);
					// die();
	    			$req = requestForClient($l['end_point_url'],$arrReq);
	    		}
				$this->session->set_flashdata('success', 'Result Rollback sucessfully!');
			}else{
				$this->session->set_flashdata('error', 'Something Went Wrong');
			}
			redirect('086a938697cd6feb6d062e6fd0c5c845');
		}
		$data['result']=$result;
		$this->load->view('admin/roll_back_starline',$data);
	}

	public function backBusinessStarline(){
		if($_POST){
			$this->load->model('Common_model');
			$d = explode(' - ',$_POST['dateRange']);
			// $List = $this->Common_model->getData('starline_bazar','','id, bazar_name','','','','','');
			// $arr['arr']=[];
			$arr['from'] = date('Y-m-d',strtotime($d[0]));
        	$arr['to'] = date('Y-m-d',strtotime($d[1]));
        	$con1=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'"';
			$feilds='COUNT(id) as id,SUM(point_in_rs) as point,SUM(winning_in_rs) as win,COUNT(DISTINCT customer_id) as cid,SUM(commission) as com';
			// $feilds='COUNT(id) as id,SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid';
	        $arr['inP'] = $this->Common_model->getData('starline_bazar_game',$con1,$feilds,'','','One','','');
        	$arr['inP']['ggr']=$arr['inP']['point']-$arr['inP']['win'];
	        

	        // foreach ($List as $dataArray) {
	        //     $con=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND bazar_name="'.$dataArray['id'].'"';
	        //     $bazarResult = $this->Common_model->getData('starline_bazar_game',$con,'COUNT(id) as id,SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid','','','One','','');
	        //     $bazarResult['bazar_id'] = $dataArray['id'];
	        //     $bazarResult['bazarName'] = $dataArray['bazar_name'];
	        //     $bazarResult['ggr'] = $bazarResult['point']-$bazarResult['win'];
	        //     array_push($arr['arr'],$bazarResult);
	        // }
	        $con=' INNER JOIN starline_bazar ON starline_bazar_game.bazar_name=starline_bazar.id WHERE starline_bazar_game.result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'"';
			$feilds='COUNT(DISTINCT customer_id) as cid,starline_bazar.id as bazar_id,starline_bazar.bazar_name as bazarName,COUNT(starline_bazar_game.id) as id,SUM(starline_bazar_game.point_in_rs) as point,SUM(starline_bazar_game.point_in_rs-starline_bazar_game.winning_in_rs) as ggr,SUM(starline_bazar_game.winning_in_rs) as win,SUM(commission) as com';
	        // $feilds='starline_bazar.id as bazar_id,starline_bazar.bazar_name as bazarName,COUNT(starline_bazar_game.id) as id,SUM(starline_bazar_game.point) as point,SUM(starline_bazar_game.point-starline_bazar_game.winning_point) as ggr,SUM(starline_bazar_game.winning_point) as win';
	        $arr['arr'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','','','starline_bazar.bazar_name');

			$this->load->view('admin/starlineBetRecordsBackBusiness',$arr);
		}else{
			$this->load->view('admin/backBusinessStarline');
		}
	}

	public function starlineMarketTimeBetRecordsBackBusiness($id,$name){
		$this->load->model('Common_model');
		$con=' WHERE bazar_name="'.$id.'"';
		$List = $this->Common_model->getData('starline_bazar_time',$con,'id, time','','','','','');
		$arr['arr']=[];
        $arr['bazarName'] = $name;
        $arr['from'] = $_GET['from'];
        $arr['to'] = $_GET['to'];
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id,SUM(point) as point';
        foreach ($List as $dataArray) {
            $con=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($_GET['from'])).'" AND "'.date('Y-m-d',strtotime($_GET['to'])).'" AND bazar_name="'.$id.'" AND time="'.$dataArray['id'].'"';
            $bazarResult = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            $bazarResult['time_id']=$dataArray['id'];
            $bazarResult['time']=$dataArray['time'];
            array_push($arr['arr'],$bazarResult);
        }
        $arr['bazar_id'] = $id;
		$this->load->view('admin/starlineTimeBetRecordsBackBusiness',$arr);
	}

	public function starlineMarketTypeRecordsBackBusiness($bazarId,$timeId,$name){
		$this->load->model('Common_model');
		$con=' WHERE status="A"';
		$List = $this->Common_model->getData('starline_game_type',$con,'id, game_name','','','','','');
		$arr['arr']=[];
        $arr['bazarName'] = $name;
        $arr['time_id']=$timeId;
        $arr['from'] = $_GET['from'];
        $arr['to'] = $_GET['to'];
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id,SUM(point) as point';
        foreach ($List as $dataArray) {
            $con=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($_GET['from'])).'" AND "'.date('Y-m-d',strtotime($_GET['to'])).'" AND bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name="'.$dataArray['id'].'"';
            $bazarResult = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            $bazarResult['game_name']=$dataArray['game_name'];
            $bazarResult['game_id']=$dataArray['id'];
            array_push($arr['arr'],$bazarResult);
        }
        $arr['bazar_id'] = $bazarId;
		$this->load->view('admin/starlineTypeRecordsBackBusiness',$arr);
	}

	public function starlineMarketGameRecordsBackBusiness($bazarId,$timeId,$gameId,$bazarName,$gameName){
        $arr['bazarName'] = $bazarName;
        $arr['gameName'] = $gameName;
        $arr['time_id']=$timeId;
        $arr['bazar_id'] = $bazarId;
        $arr['gameId'] = $gameId;

        $arr['from'] = $_GET['from'];
        $arr['to'] = $_GET['to'];
		$this->load->model('Common_model');
		$arr['arr']=[];
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id,SUM(point) as point';
		if($gameId=='2' || $gameId=='13' || $gameId=='25'){
			for($i=0; $i < 10; $i++) {
				$con=' WHERE bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name="'.$gameId.'" AND game="'.$i.'" AND result_date BETWEEN "'.date('Y-m-d',strtotime($_GET['from'])).'" AND "'.date('Y-m-d',strtotime($_GET['to'])).'"';
            	$res = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            	$res['akda']=$i;
            	array_push($arr['arr'],$res);
			}
		}else {
			if($gameId=='1' || $gameId=='14' || $gameId=='26'){
				if($gameId=='1'){
					$ar = ['1','5','6','12'];
				}else if($gameId=='14'){
					$ar = ['14','17','18','23'];
				}else{
					$ar = ['26','30','31','35'];
				}
				$patti=getPanaList('SINGLEPATTI');
			}else if($gameId=='3' || $gameId=='15' || $gameId=='27'){
				$patti=getPanaList('DOUBLEPATTI');
				if($gameId=='3'){
					$ar = ['3','7','8','9'];
				}else if($gameId=='15'){
					$ar = ['15','19','20','21'];
				}else{
					$ar = ['27','32','33','34'];
				}
			}else if($gameId=='4' || $gameId=='16' || $gameId=='28'){
				$patti=getPanaList('TRIPLEPATTI');
				if($gameId=='4'){
					$ar = ['4','10','11'];
				}else if($gameId=='15'){
					$ar = ['16','22','24'];
				}else{
					$ar = ['28','29','36'];
				}
			}
			foreach($patti as $d) {
				$con=' WHERE bazar_name="'.$bazarId.'" AND time="'.$timeId.'" AND game_name IN ("'.implode("','",$ar).'") AND game="'.$d.'" AND result_date BETWEEN "'.date('Y-m-d',strtotime($_GET['from'])).'" AND "'.date('Y-m-d',strtotime($_GET['to'])).'"';
            	$res = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
            	$res['akda']=$d;
            	
            	array_push($arr['arr'],$res);
			}
		}
		$this->load->view('admin/starlineGameRecordsBackBusiness',$arr);
	}


	public function starlineBetDetail(){
	    $postData = $this->input->post();
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getStarlineData($postData);
	    echo json_encode($data);
	}

	public function bazarList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getStarlineBazarData($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/bazarList'); 
		}
	}
	public function addNewBazar($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('starline_bazar','id',$id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'status' => "A",
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('starline_bazar', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('starline_bazar', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				redirect('7932304afa07498c9b2b9cd3954c33d7');
			}
		}
		$this->load->model('Common_model');
		$this->Common_model->getData('starline_bazar','','','','','','');
		$this->load->view('admin/addNewBazar',$data);
	}


	public function addNewBazarTime($id=''){
		if ($id > 0 ) {
			$this->load->model('ManageStarlinegames_Model');
			$con='WHERE starline_bazar_time.id="'.$id.'"';
			$data['chartGameName'] = $this->ManageStarlinegames_Model->getstarlinegame($con,'one');
		}
		if ($_POST) {
			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'status' => "A",
				'updated_by' => $_SESSION['adid']['id']
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
				redirect('0b1a4cf7c60a831e444002c6fdde6f8f');
			}
		}
		$this->load->model('Common_model');
		$data['bazarList']=$this->Common_model->getData('starline_bazar','','','','','','');
		$this->load->view('admin/add_new_startline_game',$data);
	}

	public function bhavList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getStarlineBazarBhavData($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$data['bazarList'] = $this->Common_model->getData('starline_bazar','','','','','','','');
			$data['gameList'] = $this->Common_model->getData('starline_game_type','','','','','','','');
			$this->load->view('admin/bhavList',$data);
		}
	}


	public function addNewBhav($id=''){
		$this->load->model('Common_model');
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('starline_bhav','id',$id);
		}
		if ($_POST) {
			$lstAct['entry_table'] = 'Starline Bazar Bhav';
        	$lstAct['supportId'] = $_SESSION['adid']['id'];
        	$lstAct['created'] = date('Y-m-d H:i:s');

			$conLst = ' INNER JOIN starline_bazar ON starline_bhav.bazar_name=starline_bazar.id INNER JOIN starline_game_type ON starline_bhav.game_name=starline_game_type.id WHERE starline_bhav.bazar_name="'.$_POST['bazar_name'].'" AND starline_bhav.game_name="'.$_POST['game_name'].'"';
			$feildsLst = 'starline_bhav.rate,starline_game_type.game_name,starline_bazar.bazar_name';

			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'],
				'game_name' => $_POST['game_name'],
				'rate' => $_POST['rate'], 
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('starline_bhav', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('starline_bhav', '', '', $addgamename);
			}
			$gameaddid = 1;
			if ($gameaddid > 0) {
				$lst = $this->Common_model->getData('starline_bhav',$conLst,$feildsLst,'','','One','','');
				$lstAct['detail'] = implode(', ',$lst);
        		AddUpdateTable('lastActivity','','',$lstAct);
				redirect('bc81603a6bb850328fa301e58be072ed');
			}
		}
		$data['bazarList'] = $this->Common_model->getData('starline_bazar','','','','','','','');
		$data['gameList'] = $this->Common_model->getData('starline_game_type','','','','','','','');
		$this->load->view('admin/addNewBhav',$data);
	}

	public function gameTypeList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getGameTypeList($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$data['bazarList'] = $this->Common_model->getData('starline_bazar','','','','','','','');
			$data['gameList'] = $this->Common_model->getData('starline_game_type','','','','','','','');
			$this->load->view('admin/gameTypeList',$data);
		}
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
				redirect('bc5b398327e1377d15fb309a07d92e8b');
			}
		}
		$this->load->model('Common_model');
	    $con = ' WHERE status="A"';
	    $data['bazarList'] = $this->Common_model->getData('starline_bazar',$con,'id,bazar_name','','','','');

		$this->load->view('admin/addNewGameType',$data);
	}
}