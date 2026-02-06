<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Kingbazargames (Manage_Kingbazargames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_Kingbazargames extends BaseController {
	function __construct(){
	    parent::__construct();
	    if(! $this->session->userdata('adid'))
	    redirect('admin/login');
	}



	public function index(){
		// $this->load->model('ManageKingbazar_Model');
		// $this->load->library('pagination');
		// $data['kingbazargame'] = $this->ManageKingbazar_Model->getkingbazardetails();
		// print_r($data['kingbazargame']);
		// die();
		// $this->load->view('admin/manage_kingbazargames',$data);
		 
	}


	public function addKingBazzarGame($id=''){
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('king_bazar', 'id', $id);
		}
		if ($_POST) {
			$addgamename = array(
				'bazar' => $_POST['bazar_name'], 
				'time' => $_POST['bazar_time'], 
				'status' => 'Active', 
				'created' => date('Y-m-d H:i:s'), 
				'updated' => date('Y-m-d H:i:s') 
			);
			if ($id > 0) {
				$gameaddid = AddUpdateTable('king_bazar', 'id', $id, $addgamename);
			}else{
				$gameaddid = AddUpdateTable('king_bazar', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				redirect('admin/Manage_Kingbazargames');
			}
		}
		$this->load->view('admin/add_new_kingbazzar_game',$data);
	}

	public function deleteBazzarGame($gameid=''){
		$chartgame = deleteRecord('king_bazar','id',$gameid);
		if ($chartgame > 0) {
			redirect('admin/Manage_Kingbazargames');
		}
	}

	public function BazarList(){
	    $this->load->model('Common_model');
	    $con = ' WHERE status="A"';
	    $bazar = $this->Common_model->getData('king_bazar',$con,'id,bazar_name,time','','','','time ASC','');
	    $gm=["8","10","3","13"];
		$con11 = ' WHERE bazar_name NOT IN ('.implode(',', $gm).') AND result_date="'.date('Y-m-d').'"';
		$feilds='COUNT(id) as id, SUM(point_in_rs) as point,SUM(winning_in_rs) as win,COUNT(DISTINCT customer_id) as cid,SUM(commission) as com';
		// $feilds='COUNT(id) as id, SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid';
	    $this->data['inP']=$this->Common_model->getData('king_bazar_game',$con11,$feilds,'','','One','','');

	    $con22 = ' WHERE bazar_name IN ('.implode(',', $gm).') AND result_date="'.date('Y-m-d').'"';
	    $this->data['outP']=$this->Common_model->getData('king_bazar_game',$con22,$feilds,'','','One','','');

	    // $this->data['arr']=[];
	    $this->data['bazarId']=$bazar['id'];
	    // foreach($bazar as $d){
	    // 	$con1 = ' WHERE bazar_name="'.$d['id'].'" AND result_date="'.date('Y-m-d').'"';
	    // 	$dt=$this->Common_model->getData('king_bazar_game',$con1,'COUNT(id) as id, SUM(point) as point','','','One','','');
	    // 	$dt['bazarId']=$d['id'];
	    // 	$dt['bazar_name']=$d['bazar_name'];
	    // 	$dt['time']=$d['time'];
	    // 	array_push($this->data['arr'],$dt);
	    // }
	    $con = ' INNER JOIN king_bazar ON king_bazar_game.bazar_name=king_bazar.id WHERE king_bazar_game.result_date="'.date('Y-m-d').'"';
	    // $feilds='COUNT(king_bazar_game.id) as id, SUM(king_bazar_game.point) as point,SUM(king_bazar_game.winning_point) as win,COUNT(DISTINCT king_bazar_game.customer_id) as cid,king_bazar.time as time,king_bazar.bazar_name as bazar_name,king_bazar.id as bazarId,SUM(point-winning_point) as ggr';
	    $feilds='COUNT(king_bazar_game.id) as id, SUM(king_bazar_game.point_in_rs) as point,SUM(king_bazar_game.winning_in_rs) as win,COUNT(DISTINCT king_bazar_game.customer_id) as cid,king_bazar.time as time,king_bazar.bazar_name as bazar_name,king_bazar.id as bazarId,SUM(point_in_rs-winning_in_rs) as ggr,SUM(commission) as com';
	    $nD=$this->Common_model->getData('king_bazar_game',$con,$feilds,'','','','king_bazar.sequence ASC','king_bazar.id');
	    $aD=array_column($nD, 'bazarId');
	    $this->data['arr']=[];
	    foreach($bazar as $d){
	    	if(in_array($d['id'], $aD)){
	    		$a=array_search($d['id'], $aD);
		    	array_push($this->data['arr'],$nD[$a]);
	    	}else{
		    	$dt['id']=0;
		    	$dt['point']=0;
		    	$dt['bazarId']=$d['id'];
		    	$dt['bazar_name']=$d['bazar_name'];
		    	$dt['time']=$d['time'];
		    	array_push($this->data['arr'],$dt);
	    	}
	    }
	    $this->load->view('admin/kingBazarList',$this->data);
	}

	public function kingGameTypeList($id,$bazarName){
	    $this->load->model('Common_model');
		$feilds='COUNT(id) as id, SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id, SUM(point) as point';
		$this->data['first']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="1" AND result_date="'.date('Y-m-d').'"',$feilds,'','','One','','');
		$this->data['second']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="2" AND result_date="'.date('Y-m-d').'"',$feilds,'','','One','','');
		$this->data['jodi']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="3" AND result_date="'.date('Y-m-d').'"',$feilds,'','','One','','');

		$this->data['res']=$this->Common_model->getData('king_bazar_result',' WHERE bazar_name="'.$id.'" AND result_date="'.date('Y-m-d').'"','result','','','One','','');

		$this->data['bazarName']=$bazarName;
		$this->data['bazarId']=$id;
		$this->load->view('admin/kingGameTypeList',$this->data);
	}

	public function kingGameRecord($bazarId,$gameId,$bazarName){
	    $this->load->model('Common_model');
	    if($gameId=='3'){
	    	$l=100;
	    	$this->data['gameName']="Jodi";
	    }else{
	    	$l=10;
	    	if($gameId=='1'){
	    		$this->data['gameName']="First Digit";
	    	}else{
	    		$this->data['gameName']="Second Digit";
	    	}
	    }
	    $this->data['gameId']=$gameId;
	    $this->data['bazarId']=$bazarId;
	    $this->data['bazarName']=$bazarName;

	    $this->data['arr']=[];
	    for($i=0;$i<$l;$i++){
	    	if($this->data['gameName']=="Jodi"){
	    		$g = sprintf("%02d", $i);
	    	}else{
	    		$g = $i;
	    	}
	    	$con=' WHERE bazar_name="'.$bazarId.'" AND game_name="'.$gameId.'" AND game="'.$g.'" AND result_date="'.date('Y-m-d').'"';
			$feilds='COUNT(id) as id, SUM(point_in_rs) as point';
			// $feilds='COUNT(id) as id, SUM(point) as point';
			$res=$this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');
			$res['akda']=$g;
	    	array_push($this->data['arr'],$res);
	    }
	    $con1=' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'"';
	    $this->data['res']=$this->Common_model->getData('king_bazar_result',$con1,'result','','','One','','');
	    
		$this->load->view('admin/kingGameRecord',$this->data);
	}

	public function rollBackResult($id=''){
		$this->load->model('Common_model');
		
		$con = " INNER JOIN king_bazar ON king_bazar_result.bazar_name=king_bazar.id WHERE king_bazar_result.id='".$id."'";
		$feilds = 'king_bazar.bazar_name,king_bazar.id as bazar_id,king_bazar_result.result_date,king_bazar_result.id,king_bazar_result.result';
		$result = $this->Common_model->getData('king_bazar_result',$con,$feilds,'','','One','','');

		if ($_POST) {
			$addgamename = array(
				'result' => $_POST['result_patti'],
				'created' => date('Y-m-d H:i:s') 
			);
			$gameaddid = AddUpdateTable('king_bazar_result', 'id', $id, $addgamename);
			if ($gameaddid) {
				$con=" WHERE result_date='".$result['result_date']."' AND bazar_name='".$result['bazar_id']."'";
				
	    		$field['status']="P";
				$field['winning_point']="0";
				$field['commission']="0";
				$field['winning_in_rs']="0";
				$field['commission_in_rs']="0";
	    		$updateresultLose = updateAllLose('king_bazar_game', $con, $field);
	    		
	    		/*--------------------- Setel Market Loss Start --------------------------*/
	    		$con1=" INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.result_date='".$result['result_date']."' AND king_bazar_game.bazar_name='".$result['bazar_id']."'";


	    		$arrLossPartner = $this->Common_model->getData('king_bazar_game',$con1,'DISTINCT king_bazar_game.partner_id,client.end_point_url','','','','','');

	    		foreach($arrLossPartner as $l){
	    			$con2=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_id']."'";
	    			$arrLossBet = $this->Common_model->getData('king_bazar_game',$con2,'transaction_id,customer_id,status','','','','','');
	    			$arrReq['code']='901';
		    		$arrReq['arr']=json_encode($arrLossBet);
		    		$arrReq['market']='King Bazar';
					$arrReq['market_code']='501';
	    			$req = requestForClient($l['end_point_url'],$arrReq);
	    		}
				$this->session->set_flashdata('success', 'Result Rollback sucessfully!');
				redirect('721466737f6712c1f81542599265fd77');
			}else{
				$this->session->set_flashdata('error', 'Something Went Wrong');
			}
		}
		$data['result']=$result;
		$this->load->view('admin/roll_back_king',$data);
	}

	public function backBusinessKing(){
		if($_POST){
		    $this->load->model('Common_model');
		    $dback = explode(' - ',$_POST['dateRange']);
		    $con = ' WHERE status="A"';
		    $bazar = $this->Common_model->getData('king_bazar',$con,'id,bazar_name,time','','','','sequence asc','');
		    $this->data['arr']=[];
		    $this->data['bazarId']=$bazar['id'];
		    $this->data['from']=date('Y-m-d',strtotime($dback[0]));
			$this->data['to']=date('Y-m-d',strtotime($dback[1]));

			$gm=["8","10","3","13"];
			// $feilds='COUNT(id) as id,SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid';
			$feilds='COUNT(id) as id,SUM(point_in_rs) as point,SUM(winning_in_rs) as win,COUNT(DISTINCT customer_id) as cid,SUM(commission) as com';
			$con11 = ' WHERE bazar_name NOT IN ('.implode(',', $gm).') AND result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    $this->data['inP']=$this->Common_model->getData('king_bazar_game',$con11,$feilds,'','','One','','');

		    $con22 = ' WHERE bazar_name IN ('.implode(',', $gm).') AND result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    $this->data['outP']=$this->Common_model->getData('king_bazar_game',$con22,$feilds,'','','One','','');

			$con33 = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    $this->data['cUni']=$this->Common_model->getData('king_bazar_game',$con33,'count(DISTINCT customer_id) as cUni','','','One','','');
		    // foreach($bazar as $d){
		    // 	$con1 = ' WHERE bazar_name="'.$d['id'].'" AND result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    // 	$dt=$this->Common_model->getData('king_bazar_game',$con1,'COUNT(id) as id, SUM(point) as point,SUM(point) as point,SUM(winning_point) as win,COUNT(DISTINCT customer_id) as cid','','','One','','');
		    // 	$dt['bazarId']=$d['id'];
		    // 	$dt['bazar_name']=$d['bazar_name'];
		    // 	$dt['ggr']=$dt['point']-$dt['win'];
		    // 	$dt['time']=$d['time'];
		    // 	array_push($this->data['arr'],$dt);
		    // }
		    $con = ' INNER JOIN king_bazar ON king_bazar_game.bazar_name=king_bazar.id WHERE king_bazar_game.result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    $feilds='COUNT(king_bazar_game.id) as id, SUM(king_bazar_game.point_in_rs) as point,SUM(king_bazar_game.winning_in_rs) as win,COUNT(DISTINCT king_bazar_game.customer_id) as cid,king_bazar.time as time,king_bazar.bazar_name as bazar_name,king_bazar.id as bazarId,SUM(commission) as com';
		    // $feilds='COUNT(king_bazar_game.id) as id, SUM(king_bazar_game.point) as point,SUM(king_bazar_game.winning_point) as win,COUNT(DISTINCT king_bazar_game.customer_id) as cid,king_bazar.time as time,king_bazar.bazar_name as bazar_name,king_bazar.id as bazarId';
		    $nD=$this->Common_model->getData('king_bazar_game',$con,$feilds,'','','','king_bazar.sequence ASC','king_bazar.id');
		    $aD=array_column($nD, 'bazarId');
		    $this->data['arr']=[];
		    foreach($bazar as $d){
		    	if(in_array($d['id'], $aD)){
		    		$a=array_search($d['id'], $aD);
			    	array_push($this->data['arr'],$nD[$a]);
		    	}else{
			    	$dt['id']=0;
			    	$dt['point']=0;
			    	$dt['bazarId']=$d['id'];
			    	$dt['bazar_name']=$d['bazar_name'];
			    	$dt['time']=$d['time'];
			    	array_push($this->data['arr'],$dt);
		    	}
		    }
		    $this->load->view('admin/kingBazarListBackBusiness',$this->data);
		}else{
		    $this->load->view('admin/backBusinessKing');
		}
	}
	public function kingGameTypeListBackBusiness($id,$bazarName){
	    $this->load->model('Common_model');
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id,SUM(point) as point';
		$this->data['first']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="1" AND result_date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'"',$feilds,'','','One','','');

		$this->data['second']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="2" AND result_date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'"',$feilds,'','','One','','');

		$this->data['jodi']=$this->Common_model->getData('king_bazar_game',' WHERE bazar_name="'.$id.'" AND game_name="3" AND result_date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'"',$feilds,'','','One','','');
		$this->data['bazarName']=$bazarName;
		$this->data['bazarId']=$id;
		$this->data['from']=$_GET['from'];
		$this->data['to']=$_GET['to'];
		$this->load->view('admin/kingGameTypeListBackBusiness',$this->data);
	}

	public function kingGameRecordBackBusiness($bazarId,$gameId,$bazarName){
	    $this->load->model('Common_model');
	    if($gameId=='3'){
	    	$l=100;
	    	$this->data['gameName']="Jodi";
	    }else{
	    	$l=10;
	    	if($gameId=='1'){
	    		$this->data['gameName']="First Digit";
	    	}else{
	    		$this->data['gameName']="Second Digit";
	    	}
	    }
	    $this->data['gameId']=$gameId;
	    $this->data['bazarId']=$bazarId;
	    $this->data['bazarName']=$bazarName;
	    $this->data['from']=$_GET['from'];
		$this->data['to']=$_GET['to'];
	    $this->data['arr']=[];
		$feilds='COUNT(id) as id,SUM(point_in_rs) as point';
		// $feilds='COUNT(id) as id,SUM(point) as point';
	    for($i=0;$i<$l;$i++){
	    	if($this->data['gameName']=="Jodi"){
	    		$g = sprintf("%02d", $i);
	    	}else{
	    		$g = $i;
	    	}
	    	$con=' WHERE bazar_name="'.$bazarId.'" AND game_name="'.$gameId.'" AND game="'.$g.'" AND result_date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'"';

			$res=$this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');
			$res['akda']=$g;
	    	array_push($this->data['arr'],$res);
	    }
		$this->load->view('admin/kingGameRecordBackBusiness',$this->data);
	}

	public function bazarRateList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getKingBazarBhavData($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$con = ' WHERE status="A"';
			$data['bazar'] = $this->Common_model->getData('king_bazar',$con,'id,bazar_name','','','','','');
			$this->load->view('admin/king_bazar_rate',$data);
		}
	}

	public function addNewBazarRate($id=''){
		$this->load->model('Common_model');
		if ($id > 0 ) {
			$data['onegamedata'] = getRecordById('king_bazar_rate', 'id', $id);
		}
		if ($_POST) {

			$lstAct['entry_table'] = 'King Bazar Bhav';
        	$lstAct['supportId'] = $_SESSION['adid']['id'];
        	$lstAct['created'] = date('Y-m-d H:i:s');

        	$conLst = ' INNER JOIN king_bazar ON king_bazar_rate.bazar_name=king_bazar.id WHERE king_bazar_rate.bazar_name="'.$_POST['bazar_name'].'" AND king_bazar_rate.game_type="'.$_POST['game_type'].'"';
			$feildsLst = 'king_bazar_rate.rate,king_bazar_rate.game_type,king_bazar.bazar_name';

			$addgamename = array(
				'bazar_name' => $_POST['bazar_name'], 
				'game_type' => $_POST['game_type'], 
				'rate' => $_POST['rate'],
				'updated_by' => $_SESSION['adid']['id']
			);

			if ($id > 0) {
				$gameaddid = AddUpdateTable('king_bazar_rate', 'id', $id, $addgamename);
			}else{
				$addgamename['status']="A";
				$gameaddid = AddUpdateTable('king_bazar_rate', '', '', $addgamename);
			}
			if ($gameaddid > 0) {
				$lst = $this->Common_model->getData('king_bazar_rate',$conLst,$feildsLst,'','','One','','');
				if($lst['game_type']=='1'){
					$lst['game_type']='First Digit(Ekai)';
				}else if($lst['game_type']=='2'){
					$lst['game_type']='Second Digit(Haruf)';
				}else{
					$lst['game_type']='Jodi';
				}
				$lstAct['detail'] = implode(', ',$lst);
        		AddUpdateTable('lastActivity','','',$lstAct);

				redirect('239ef3437609e5a9ae1795724cfcbe92');
			}
		}
		
		$data['bhavList'] = $this->Common_model->getData('king_bazar','','','','','','id desc','');
		// $data['bhavList'] = getAllRecord('king_bazar','','','','','');
		$this->load->view('admin/add_new_kingbazzar_bhav',$data);
	}
}