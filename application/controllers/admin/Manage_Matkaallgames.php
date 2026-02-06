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

class Manage_Matkaallgames extends BaseController{



	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('admin/login');

	}

//Class Manage_Matkagames extends CI_Controller {

    





	// public function index(){

	//     $this->load->model('ManageMatkaallgames_Model');

	//      $this->load->library('pagination');

	//     $data['matkagame'] = $this->ManageMatkaallgames_Model->getmatkaallgamedetails();

	//     $this->load->view('admin/manage_matkaallgames',$data);

	// }







    public function index(){

	    $this->load->model('ManageMatkaallgames_Model');

	    $this->load->library('pagination');

	    $data['matkagameallresult'] = $this->ManageMatkaallgames_Model->getmatkaallgamedetails();



	    $config['total_rows'] = count($data['matkagameallresult']);

	    $config['per_page'] = 10;

		$config['num_links'] = 20;      

		$config['page_query_string'] = TRUE;

		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

	    $this->load->view('admin/manage_matkaallgames',$data);

	}






	// 14-11-2022
 //    public function AddAllGameResult($id=''){
	// 	$this->load->model('ManageMatkaallgames_Model');
	// 	$data['matkaallgame'] = $this->ManageMatkaallgames_Model->getmatkagameallGame();
	// 	if ($id > 0) {
	// 		$data['onegamedata'] = getRecordById('game_result', 'id', $id);
	// 	}
	// 	if ($_POST) {
			
	// 		$addResult = array(
	// 			'game_name' => $_POST['game_name'], 
	// 			'result' => $_POST['result'], 
	// 			'result_date' => $_POST['result_date'], 
	// 			'highlight' => $_POST['result_mode'],
	// 			'priority' => $_POST['1'], 
	// 			'created' => date('Y-m-d H:i:s'), 
	// 			'updated' => date('Y-m-d H:i:s'), 
	// 		);
	// 		if ($id > 0) {
	// 			$updateresultid = AddUpdateTable('game_result', 'id', $id, $addResult);
	// 		}else{
				
	// 			$con=' WHERE game_name="'.$_POST['game_name'].'" AND result_date="'.$_POST['result_date'].'"';
	// 			$checkResult=$this->Common_model->getData('regular_bazar_result',$con,'id','','','One','','');
	// 			if(empty($checkResult)){
	// 				$updateresultid = AddUpdateTable('game_result', '', '', $addResult);
	// 			}else{
	// 				$updateresultid=0;
	// 			}
	// 		}
	// 		if ($updateresultid > 0) {
	// 			redirect('admin/Manage_Matkaallgames');
	// 		}
	// 	}
	// 	$this->load->view('admin/add_allgame_result',$data);
	// }

	public function AddAllGameResult($id=''){
		
		$this->load->model('ManageMatkaallgames_Model');
		$data['matkaallgame'] = $this->ManageMatkaallgames_Model->getmatkagameallGame();
		if ($id > 0) {
			$data['onegamedata'] = getRecordById('regular_bazar_result', 'id', $id);
		}
		if ($_POST) {
			$addResult = array(
				'bazar_name' => $_POST['bazar_name'], 
				'open' => $_POST['open'], 
				'jodi' => $_POST['jodi'],
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$addResult['close']= $_POST['close'];
				$updateresultid = AddUpdateTable('regular_bazar_result', 'id', $id, $addResult);
				$wU = 'Close';
				$notifyResult['result']=$akda.'-'.$_POST['result'];
				$sR['close_result']=$addResult['close'];
			}else{
				$addResult['created']= date('Y-m-d H:i:s');
				$addResult['announcer']= '1';
				$addResult['status']= "A";
				$addResult['result_date']= $_POST['result_date'];
				$addResult['token_open']=transactionID(10,10);
				$addResult['token_close']=transactionID(11,11);
				$updateresultid = AddUpdateTable('regular_bazar_result', '', '', $addResult);
				$wU = 'Open';
				$notifyResult['result']=$_POST['result'].'-'.$akda;
				$sR['close_result']='';
			}
			if ($updateresultid > 0) {

				$this->load->model('Common_model');
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
                $url='https://channapoha.com/Postdata';
                $res=sendResultDpboss($sR,$url);
                
				redirect('f2356c74eddd4a15682b144eaacb3071');
				// redirect('Manage_Matkaallgames');
			}
		}
		$this->load->view('admin/add_allgame_result',$data);
	}



	public function deleteGame($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('game_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('admin/Manage_Matkaallgames');

		}

	}




	public function updateWallet(){
		$this->load->model('Common_model');
		$this->load->model('ManageMatkaallgames_Model');
		// echo '<pre>';
		// print_r(json_encode($_POST));
		// die();
		if(isset($_POST)){
			$type='';
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

			foreach($_POST as $data){
	        	$bet = $this->Common_model->getData('regular_bazar_games',' WHERE id="'.$data.'"','exchange_rate,partner_id,customer_id,bazar_name,game_name,result_date,point,game_type','','','One','','');
	        	$rate = $this->Common_model->getData('regular_bazar_rate',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_name="'.$bet['game_name'].'"','rate','','','One','','');
	        	if($bet['partner_id']=='2'){
					$commission=$lC;
				}else if($bet['partner_id']=='4'){
					$commission=$fbC;
				}else{
					$commission=$oC;
				}
				$addResult['commission'] = ($commission / 100) * $bet['point']*$rate['rate'];
				$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];
				
				$addResult['winning_in_rs']=$addResult['winning_point']*(double)$bet['exchange_rate'];
                $addResult['commission_in_rs']=$addResult['commission']*(double)$bet['exchange_rate'];

				$addResult['status']= 'W';
				$updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addResult);
				if(empty($type)){
					if($bet['game_type']=='Open'){
						$type=' AND game_type="Open"';
					}else{
						$type=' AND game_type!="Open"';
					}
				}
			}
    		
			$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."'".$type;
			$field['status']="L";
			$updateresultLose = updateAllLose('regular_bazar_games', $con, $field);

			/*--------------------- Setel Market Start --------------------------*/
    		$con1=" INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.result_date='".$bet['result_date']."' AND regular_bazar_games.bazar_name='".$bet['bazar_name']."'".$type;


    		$arrLoss = $this->Common_model->getData('regular_bazar_games',$con1,'DISTINCT regular_bazar_games.partner_id,client.end_point_url','','','','','');
    		$multiUrl = [];
			$multiData = [];
			$multiI = 0;
			foreach($arrLoss as $l){
    			$con=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."'".$type;
    			if($l['partner_id']=='2' || $l['partner_id']=='5' || $l['partner_id']=='7'){
                    $con.=' AND status="W"';
                    $arrReq['result_date']=$bet['result_date'];
                    $arrReq['bazar_id']=$bet['bazar_name'];
                    $arrReq['type']=$type;
                }
    			$arrLossBet = $this->Common_model->getData('regular_bazar_games',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
    			$arrReq['code']='601';
	    		$arrReq['rec']=json_encode($arrLossBet);
	    		$arrReq['market']='Regular Bazar';
				$arrReq['market_code']='301';
	    		
    			// $req = requestForClient($l['end_point_url'],$arrReq);
				// set log after request
				
				$multiUrl[$multiI]=$l['end_point_url'];
				$multiData[$multiI]=$arrReq;
				$multiI++;
			}
			responseLog($multiData);
			$req = requestForMultiClient($multiUrl,$multiData);
			responseLog($req);
			responseLog($multiUrl);
    		/*--------------------- Setel Market End --------------------------*/

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


	public function regularMarketBetRecords(){
		$this->load->model('Common_model');
		// $flds='COUNT(id) as id, SUM(point) as point, SUM(winning_point) as win, COUNT(DISTINCT customer_id) as cid';
		$flds='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, COUNT(DISTINCT customer_id) as cid';
		// $con1=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("P","V") AND bazar_name IN ("3","4","5","6","7","10","12","14","16","17","18","20","21","22","26","27","28","68","69","70","73")';
        $con1=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="Home")';
        $arr['inP'] = $this->Common_model->getData('regular_bazar_games',$con1,$flds,'','','One','','');
		
        $con2=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="Out")';
        // $con2=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("P","V") AND bazar_name IN ("9","13","15","23","24","25")';
        $arr['outP'] = $this->Common_model->getData('regular_bazar_games',$con2,$flds,'','','One','','');
		
		
		$con3=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="InHome")';
		// $con3=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN("P","V") AND bazar_name IN ("8","11","19")';
        $arr['inH'] = $this->Common_model->getData('regular_bazar_games',$con3,$flds,'','','One','','');
		
		$con=' INNER JOIN regular_bazar ON regular_bazar_games.bazar_name=regular_bazar.id WHERE regular_bazar_games.result_date="'.date('Y-m-d').'" AND regular_bazar_games.status!="V"';
		// $feilds = 'COUNT(regular_bazar_games.id) as id,SUM(regular_bazar_games.point) as point,COUNT(DISTINCT regular_bazar_games.customer_id) as cid,regular_bazar.bazar_name,regular_bazar.id as bazar_id,regular_bazar.open_time as oTime,regular_bazar.close_time as cTime,SUM(winning_point) as win,SUM(point-winning_point) as ggr';
		$feilds = 'COUNT(regular_bazar_games.id) as id,SUM(regular_bazar_games.point_in_rs) as point,COUNT(DISTINCT regular_bazar_games.customer_id) as cid,regular_bazar.bazar_name,regular_bazar.id as bazar_id,regular_bazar.open_time as oTime,regular_bazar.close_time as cTime,SUM(winning_in_rs) as win,SUM(point_in_rs-winning_in_rs) as ggr,SUM(commission) as com';

        $arr['arr'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','regular_bazar.sequence asc','regular_bazar_games.bazar_name');
        $con4 = $con." AND regular_bazar_games.status='P'";
		$x = $this->Common_model->getData('regular_bazar_games',$con4,'SUM(point_in_rs) as p, regular_bazar_games.bazar_name','','','','regular_bazar.sequence asc','regular_bazar_games.bazar_name');
        $arr['arr1'] = array_column($x, 'p', 'bazar_name');

		$con5 = " WHERE status='W' AND result_date='".date('Y-m-d')."'";
		$data = $this->Common_model->getData('regular_bazar_games',$con5,'COUNT(DISTINCT customer_id) as k,bazar_name','','','','','bazar_name');
        
		$arr['arr2'] = [];
		foreach($data as $d){
			$arr['arr2'][$d['bazar_name']] = $d['k']; // 'id' as key, 'name' as value
		}
		// echo '<pre>';
		// print_r(array_column($arr['arr1'], 'bazar_name', 'p'));
		// die();
		// $arr['res'] = $this->Common_model->getData('regular_bazar_result',' WHERE result_date="'.date('Y-m-d').'"','open,jodi,close','','','','','');
		$this->load->view('admin/regularBetRecords',$arr);
	}

	public function regularMarketPendingBetRecords(){
		$data = json_decode(file_get_contents("php://input"), true);
		if(isset($data)){
			$this->load->model('Common_model');
			// $con1=' WHERE status IN ("P","V") AND bazar_name IN ("3","4","5","6","7","10","12","14","16","17","18","20","21","22","26","27","28","68","69","70","73")';
			// $con2=' WHERE status IN ("P","V") AND bazar_name IN ("9","13","15","23","24","25")';
			// $con3=' WHERE status IN ("P","V") AND bazar_name IN ("8","11","19")';

			
			$con1=' WHERE status IN ("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="Home")';
			$con2=' WHERE status IN ("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="Out")';
			$con3=' WHERE status IN ("P","V") AND bazar_name IN (select id from regular_bazar where bazar_type="InHome")';

			if($data->date==0){
				$con1.=' AND result_date="'.date('Y-m-d').'"';
				$con2.=' AND result_date="'.date('Y-m-d').'"';
				$con3.=' AND result_date="'.date('Y-m-d').'"';
			}else{
				$d=explode(" / ",$data->date);
				$con1.=' AND result_date BETWEEN "'.$d[0].'" AND "'.$d[1].'"';
				$con2.=' AND result_date BETWEEN "'.$d[0].'" AND "'.$d[1].'"';
				$con3.=' AND result_date BETWEEN "'.$d[0].'" AND "'.$d[1].'"';
			}
			$flds='COUNT(id) as id, SUM(point_in_rs) as point,COUNT(DISTINCT customer_id) as cid';
			$arr['inP'] = $this->Common_model->getData('regular_bazar_games',$con1,$flds,'','','One','','');
			$arr['outP'] = $this->Common_model->getData('regular_bazar_games',$con2,$flds,'','','One','','');
			$arr['inH'] = $this->Common_model->getData('regular_bazar_games',$con3,$flds,'','','One','','');
			die(json_encode(['status'=>301,'data'=>$arr]));
		}else{
			die(json_encode(['status'=>301,'message'=>'Please provide valid data']));
		}
	}

	public function regularTypeRecords($id,$name){
		$this->load->model('Common_model');
		$List = $this->Common_model->getData('regular_game_type','','id, game_name','','','','sequence ASC','');
		$arr['arr']=[];
		$arr['res'] = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$id.'" AND result_date="'.date('Y-m-d').'"','open,jodi,close','','','One','','');
        $arr['bazar_name'] = $name;
        $arr['bazar_id'] = $id;
        
        $con=' INNER JOIN regular_game_type ON regular_bazar_games.game_name=regular_game_type.id WHERE regular_bazar_games.result_date="'.date('Y-m-d').'" AND regular_bazar_games.bazar_name="'.$id.'" AND regular_bazar_games.status!="V"';

		// $feilds = 'COUNT(regular_bazar_games.id) as count_id,SUM(regular_bazar_games.point) as point,regular_game_type.game_name,regular_game_type.id as game_id';
		$feilds = 'COUNT(regular_bazar_games.id) as count_id,SUM(regular_bazar_games.point_in_rs) as point,regular_game_type.game_name,regular_game_type.id as game_id';

        $arr['arr'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','regular_game_type.sequence asc','regular_bazar_games.game_name');

        $at = array_column($arr['arr'], 'game_id');
        foreach ($List as $dataArray) {
        	if(!in_array($dataArray['id'], $at)){
	            $bazarResult['game_name'] = $dataArray['game_name'];
	            $bazarResult['game_id'] = $dataArray['id'];
	            array_push($arr['arr'],$bazarResult);
        	}
        }
		$this->load->view('admin/regularTypeRecords',$arr);
	}


	public function tabsData(){
		$this->load->model('Common_model');
		$result = $this->Common_model->getData('regular_bazar_result',' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$_POST['id'].'"','','','','One','','');
			
		if($_POST['name']=='JODI'){
			$gameName=["6","10","11","14","17","22","23","JODI EVEN ODD"];
			$arr=[];
			$con = ' WHERE game_name IN ("'.implode('","',$gameName).'") AND result_date="'.date('Y-m-d').'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			// $feilds='COUNT(id) as count, SUM(point) as point, game as akda';
			$feilds='COUNT(id) as count, SUM(point_in_rs) as point, game as akda';
	        $res = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','game asc','game');
			$at = array_column($res, 'akda');
			
					
	        for($i=0;$i<100;$i++) {
	        	$game = sprintf("%02d", $i);
	        	if(!in_array($i, $at)){
		            $bazarResult['count'] = '0';
		            $bazarResult['point'] = '0';
		            $bazarResult['akda'] = $game;
		            array_push($arr,$bazarResult);
	        	}else{
	        		$ik = array_search($i, $at);
	        		array_push($arr,$res[$ik]);
	        	}
	        }
	        $nArr = array_chunk($arr,10);
		}else{
			// if($_POST['name']=='SINGLEPATTI'){
			// 	$gameName=["1","7","12","15","33","32","31","30","28","18","19","20","24","29","24"];
			// }else if($_POST['name']=='DOUBLEPATTI'){
			// 	$gameName=["2","46","13","36","41","34","43","39"];
			// }else if($_POST['name']=='TRIPLEPATTI'){
			// 	$gameName=["4","47","45","42","35","48"];
			// }
			if($_POST['name']=='SINGLEPATTI'){
				$gameName=getVariationPatti('SinglePatti');
			}else if($_POST['name']=='DOUBLEPATTI'){
				$gameName=getVariationPatti('DoublePatti');
			}else if($_POST['name']=='TRIPLEPATTI'){
				$gameName=getVariationPatti('TriplePatti');
			}
			$patti = getPanaListAdmin($_POST['name']);
			$arr=[];
			$arr1=[];
			$con = ' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			$sangam = $this->Common_model->getData('regular_bazar_games',$con.' AND game_type="FULL SANGAM"','game,point','','','','game asc','game');
            $sOpen = [];
			$sClose = [];
			foreach($sangam as $m){
				$a = explode("-",$m['game']);
				$sOpen[$a[0]] += $m['point'];
				if(isset($result['open']) && $result['open']!='' && $a[0]==$result['open']){
					$sClose[$a[1]] += $m['point'];
				}
			}
			
			$con .= ' AND game IN ("'.implode('","',$gameName).'")';
			// $con = ' WHERE game_name IN ("'.implode('","',$gameName).'") AND result_date="'.date('Y-m-d').'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			// $feilds='COUNT(id) as count, SUM(point) as point, game as akda';
			$feilds='COUNT(id) as count, SUM(point_in_rs) as point, game as akda';
            $res = $this->Common_model->getData('regular_bazar_games',$con.' AND game_type="Open"',$feilds,'','','','game asc','game');
            $res1 = $this->Common_model->getData('regular_bazar_games',$con.' AND game_type="Close"',$feilds,'','','','game asc','game');
            $at = array_column($res, 'akda');
            $at1 = array_column($res1, 'akda');
         
            foreach($patti as $nP){
				foreach ($nP as $p) {
					if(!in_array($p, $at)){
						$bR['fSangam'] = '0';
			            $bR['count'] = '';
			            $bR['point'] = '0';
			            $bR['akda'] = $p;
						if($sOpen[$p] > 0){
							$bR['point'] += $sOpen[$p];
							$bR['fSangam'] = 1;
						}
			            array_push($arr,$bR);
		        	}else{
		        		$k = array_search($p, $at);
						$res[$k]['fSangam'] = 0;
						if($sOpen[$p] > 0){
							$res[$k]['point'] += $sOpen[$p];
							$res[$k]['fSangam'] = 1;
						}
		        		array_push($arr,$res[$k]);
		        	}

		        	if(!in_array($p, $at1)){
						$bR1['fSangam'] = '0';
			            $bR1['count'] = '';
			            $bR1['point'] = '0';
			            $bR1['akda'] = $p;
						if($sClose[$p] > 0){
							$bR1['point'] += $sClose[$p];
							$bR1['fSangam'] = 1;
						}
			            array_push($arr1,$bR1);
		        	}else{
		        		$ik = array_search($p, $at1);
						if($sClose[$p] > 0){
							$res1[$ik]['point'] += ($sClose[$p]*150);
							$res1[$ik]['fSangam'] = 1;
						}
		        		array_push($arr1,$res1[$ik]);
		        	}
				}
			}
			
			if($_POST['name']=='SINGLEPATTI'){
				$nr = array_chunk($arr,12);
				$nr1 = array_chunk($arr1,12);
			}else if($_POST['name']=='DOUBLEPATTI'){
				$nr = array_chunk($arr,9);
				$nr1 = array_chunk($arr1,9);
			}else if($_POST['name']=='TRIPLEPATTI'){
				$nr = array_chunk($arr,10);
				$nr1 = array_chunk($arr1,10);
			}
			$nArr = [$nr,$nr1];
		}
		
		// $rD = $this->Common_model->getData('regular_bazar',' WHERE id="'.$_POST['id'].'"','bazar_type','','','one','','');
		
		array_push($nArr,$rD['bazar_type']);
		die(json_encode($nArr));
	}

	public function tabsDataBackBusiness(){
		$this->load->model('Common_model');
		if($_POST['name']=='JODI'){
			$gameName=["6","10","11","14","17","22","23","JODI EVEN ODD"];
			$arr=[];
			$con = ' WHERE game_name IN ("'.implode('","',$gameName).'") AND result_date BETWEEN "'.$_POST['from'].'" AND "'.$_POST['to'].'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			// $feilds='COUNT(id) as count, SUM(point) as point, game as akda';
			$feilds='COUNT(id) as count, SUM(point_in_rs) as point, (SUM(winning_in_rs)+SUM(commission_in_rs)) as win, game as akda';
	        $res = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','game asc','game');
			$at = array_column($res, 'akda');
			
	        for($i=0;$i<100;$i++) {
	        	$game = sprintf("%02d", $i);
	        	if(!in_array($i, $at)){
		            $bazarResult['count'] = '0';
		            $bazarResult['point'] = '0';
		            $bazarResult['akda'] = $game;
		            array_push($arr,$bazarResult);
	        	}else{
	        		$ik = array_search($i, $at);
	        		array_push($arr,$res[$ik]);
	        	}
	        }
	        $nArr = array_chunk($arr,10);
		}else{
			// if($_POST['name']=='SINGLEPATTI'){
			// 	$gameName=["1","7","12","15","33","32","31","30","28","18","19","20","24","29","24"];
			// }else if($_POST['name']=='DOUBLEPATTI'){
			// 	$gameName=["2","46","13","36","41","34","43","39"];
			// }else if($_POST['name']=='TRIPLEPATTI'){
			// 	$gameName=["4","47","45","42","35","48"];
			// }
			if($_POST['name']=='SINGLEPATTI'){
				$gameName=getVariationPatti('SinglePatti');
			}else if($_POST['name']=='DOUBLEPATTI'){
				$gameName=getVariationPatti('DoublePatti');
			}else if($_POST['name']=='TRIPLEPATTI'){
				$gameName=getVariationPatti('TriplePatti');
			}
			$patti = getPanaListAdmin($_POST['name']);
			$arr=[];
			$arr1=[];
			$con = ' WHERE game IN ("'.implode('","',$gameName).'") AND result_date BETWEEN "'.$_POST['from'].'" AND "'.$_POST['to'].'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			// $con = ' WHERE game_name IN ("'.implode('","',$gameName).'") AND result_date="'.date('Y-m-d').'" AND bazar_name="'.$_POST['id'].'" AND regular_bazar_games.status!="V"';
			// $feilds='COUNT(id) as count, SUM(point) as point, game as akda';
			$feilds='COUNT(id) as count, SUM(point_in_rs) as point, (SUM(winning_in_rs)+SUM(commission_in_rs)) as win, game as akda';
            $res = $this->Common_model->getData('regular_bazar_games',$con.' AND game_type="Open"',$feilds,'','','','game asc','game');
            $res1 = $this->Common_model->getData('regular_bazar_games',$con.' AND game_type="Close"',$feilds,'','','','game asc','game');
            $at = array_column($res, 'akda');
            $at1 = array_column($res1, 'akda');
         
            foreach($patti as $nP){
				foreach ($nP as $p) {
					if(!in_array($p, $at)){
			            $bR['count'] = '';
			            $bR['point'] = '0';
			            $bR['akda'] = $p;
			            array_push($arr,$bR);
			            
		        	}else{
		        		$k = array_search($p, $at);
		        		array_push($arr,$res[$k]);
		        	}

		        	if(!in_array($p, $at1)){
			            $bR1['count'] = '';
			            $bR1['point'] = '0';
			            $bR1['akda'] = $p;
			            array_push($arr1,$bR1);
		        	}else{
		        		$ik = array_search($p, $at1);
		        		array_push($arr1,$res1[$ik]);
		        	}
				}
			}
			if($_POST['name']=='SINGLEPATTI'){
				$nr = array_chunk($arr,12);
				$nr1 = array_chunk($arr1,12);
			}else if($_POST['name']=='DOUBLEPATTI'){
				$nr = array_chunk($arr,9);
				$nr1 = array_chunk($arr1,9);
			}else if($_POST['name']=='TRIPLEPATTI'){
				$nr = array_chunk($arr,10);
				$nr1 = array_chunk($arr1,10);
			}
			$nArr = [$nr,$nr1];
		}
		
		// $rD = $this->Common_model->getData('regular_bazar',' WHERE id="'.$_POST['id'].'"','bazar_type','','','one','','');
		
		array_push($nArr,$rD['bazar_type']);
		die(json_encode($nArr));
	}
	public function regularGameRecords($bazarId,$gameId){
		$this->load->model('Common_model');
		$List = $this->Common_model->getData('regular_game_type','','id, game_name','','','','','');
		$arr['arr']=[];
        foreach ($List as $dataArray) {
            $con = ' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$id.'" AND game_name="'.$dataArray['id'].'"';
            $bazarResult = $this->Common_model->getData('regular_bazar_games',$con,'COUNT(id) as count_id,SUM(point) as point','','','One','','');

            $bazarResult['bazar_id'] = $id;
            $bazarResult['bazar_name'] = $name;
            $bazarResult['game_name'] = $dataArray['game_name'];
            $bazarResult['game_id'] = $dataArray['id'];
            array_push($arr['arr'],$bazarResult);
        }
		$this->load->view('admin/regularBetRecords',$arr);
	}


	public function pnlBetween(){
		$this->load->model('Common_model');
		if($_POST){
			$d=explode(" - ",$_POST['date']);
			$con=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'"';
			if(!empty($_POST['clientName'])){
				$con .= ' AND partner_id="'.$_POST['clientName'].'"';
			}
			
			if(!empty($_POST['bazarName'])){
				$con .= ' AND bazar_name="'.$_POST['bazarName'].'"';
			}
			$feilds='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, SUM(commission_in_rs) as com';
			// $feilds='COUNT(id) as id, SUM(point) as point, SUM(winning_point) as win';
			$data['regular'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
			$data['crazyWheel'] = $this->Common_model->getData('crezyMatkaGame',$con,$feilds,'','','One','','');

			$data['star'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
			$data['king'] = $this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');
			$data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','One','','');
			// echo '<pre>';
			// print_r($data);
			// die();
			
			$rI=0;
			$rB=0;
			$rW=0;

			$sI=0;
			$sB=0;
			$sW=0;

			$kI=0;
			$kB=0;
			$kW=0;

			$rI+=(int)$data['regular']['id'];
			$rB+=(int)$data['regular']['point'];
			$rW+=(int)$data['regular']['win'];
			$rC+=(int)$data['regular']['com'];

			$sI+=(int)$data['star']['id'];
			$sB+=(int)$data['star']['point'];
			$sW+=(int)$data['star']['win'];
			$sC+=(int)$data['star']['com'];

			$kI+=(int)$data['king']['id'];
			$kB+=(int)$data['king']['point'];
			$kW+=(int)$data['king']['win'];
			$kC+=(int)$data['king']['com'];

			$wI=(int)$data['worli']['id'];
			$wB=(int)$data['worli']['point'];
			$wW=(int)$data['worli']['win'];
			$wC=(int)$data['worli']['com'];

			$cWI+=(int)$data['crazyWheel']['id'];
			$cWB+=(int)$data['crazyWheel']['point'];
			$cWW+=(int)$data['crazyWheel']['win'];
			$cWC+=(int)$data['crazyWheel']['com'];
			// $tCW=$rC+$sC+$kC+$wC+$rTC;
			// $gTI=(int)$data['goldenTable']['id'];
			// $gTB=(int)$data['goldenTable']['point'];
			// $gTW=(int)$data['goldenTable']['win'];

			$tI=$rI+$sI+$kI+$wI+$cWI;
			$tB=$rB+$sB+$kB+$wB+$cWB;
			$tW=$rW+$sW+$kW+$wW+$cWW;
			$tC=$rC+$sC+$kC+$wC+$cWC;

			$wGI=$wI;
			$wGB=$wB;
			$wGW=$wW;
			$wGC=$wC;
			$wGggr = $wGB-$wGW;

			$rG=$rB-$rW;
			$sG=$sB-$sW;
			$kG=$kB-$kW;
			$wG=$wB-$wW;
			$cWG=$cWB-$cWW;
			$ggr=(int)$tB-(int)$tW; 



			/*-------------------- Striming Bazar P&L Start -----------------------*/
				// $con1 = $con." AND bazar_name NOT IN ('".implode("','",['8','9','11','13','15','19','23','24','25'])."')";
				$con1 = $con." AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type='Home' AND status='A')";
				$data['sRegular'] = $this->Common_model->getData('regular_bazar_games',$con1,$feilds,'','','One','','');
				$srI=0;
				$srB=0;
				$srW=0;

				$srI+=(int)$data['sRegular']['id'];
				$srB+=(int)$data['sRegular']['point'];
				$srW+=(int)$data['sRegular']['win'];
				$srC+=(int)$data['sRegular']['com'];

				$srG=$srB-$srW;
				
				// $con2 = $con." AND bazar_name IN ('".implode("','",['9','13','15','23','24','25'])."')";
				$con2 = $con." AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type='Out' AND status='A')";
				$data['regularOut'] = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','One','','');
				$oGI = (int)$data['regularOut']['id'];
				$oGB = (int)$data['regularOut']['point'];
				$oGW = (int)$data['regularOut']['win'];
				$oGC = (int)$data['regularOut']['com'];
				$oGG = $oGB-$oGW;

				$con3 = $con." AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type='InHome' AND status='A')";
				$data['regularInHome'] = $this->Common_model->getData('regular_bazar_games',$con3,$feilds,'','','One','','');
				$iHI = (int)$data['regularInHome']['id'];
				$iHB = (int)$data['regularInHome']['point'];
				$iHW = (int)$data['regularInHome']['win'];
				$iHC = (int)$data['regularInHome']['com'];
				$iHG = $iHB-$iHW;
			/*-------------------- Striming Bazar P&L End -----------------------*/
			$dome = '<div class="row">
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h4 class="text-center">All Regular Bets</h4>Bets : <span class="bets">'.$rI.'</span><br>
									Points : <span class="bets">'.$rB.'</span><br>
									Winning : <span class="bets">'.$rW.'</span><br>
									Commission : <span class="bets">'.$rC.'</span><br>
									GGR : <span class="bets">'.$rG.'</span><br>
									GGR+Commission : <span class="bets">'.($rG+$rC).'</span>
								</div>
								<div class="icon"><i class="ion ion-bag"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-green">
								<div class="inner">
									<h4 class="text-center">All Starline Bets</h4>Bets : <span class="bets">'.$sI.'</span><br>
									Points : <span class="bets">'.$sB.'</span><br>
									Winning : <span class="bets">'.$sW.'</span><br>
									Commission : <span class="bets">'.$sC.'</span><br>
									GGR : <span class="bets">'.$sG.'</span><br>
									GGR+Commission : <span class="bets">'.($sG+$sC).'</span>
								</div>
								<div class="icon"><i class="ion ion-stats-bars"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-yellow">
								<div class="inner">
									<h4 class="text-center">All King Bets</h4>
									Bets : <span class="bets">'.$kI.'</span><br>
									Points : <span class="bets">'.$kB.'</span><br>
									Winning : <span class="bets">'.$kW.'</span><br>
									Commission : <span class="bets">'.$kC.'</span><br>
									GGR : <span class="bets">'.$kG.'</span><br>
									GGR+Commission : <span class="bets">'.($kG+$kC).'</span>
								</div>
								<div class="icon"><i class="ion ion-person-add"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-yellow">
								<div class="inner">
									<h4 class="text-center">Instant Worli Day Bets</h4>
									Bets : <span class="bets">'.$wI.'</span><br>
									Points : <span class="bets">'.$wB.'</span><br>
									Winning : <span class="bets">'.$wW.'</span><br>
									Commission : <span class="bets">'.$wC.'</span><br>
									GGR : <span class="bets">'.$wG.'</span><br>
									GGR+Commission : <span class="bets">'.($wG+$wC).'</span>
								</div>
								<div class="icon"><i class="ion ion-person-add"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-teal-active">
								<div class="inner">
									<h4 class="text-center">Crazy Wheel Bets</h4>
									Bets : <span class="bets">'.$cWI.'</span><br>
									Points : <span class="bets">'.$cWB.'</span><br>
									Winning : <span class="bets">'.$cWW.'</span><br>
									Commission : <span class="bets">'.$cWC.'</span><br>
									GGR : <span class="bets">'.$cWG.'</span><br>
									GGR+Commission : <span class="bets">'.($cWG+$cWC).'</span>
								</div>
								<div class="icon"><i class="ion ion-android-restaurant"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-red">
								<div class="inner">
									<h4 class="text-center">All Instant Worli GGR</h4>Total : <span class="bets">'.$wGI.'</span><br>
									Points : <span class="bets">'.$wGB.'</span><br>
									Winning : <span class="bets">'.$wGW.'</span><br>
									Commission : <span class="bets">'.$wGC.'</span><br>
									GGR : <span class="bets">'.$wGggr.'</span><br>
									GGR+Commission : <span class="bets">'.($wGggr+$wGC).'</span>
								</div>
								<div class="icon"><i class="ion ion-pie-graph"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h4 class="text-center">Regular In Bets</h4>Bets : <span class="bets">'.$srI.'</span><br>
									Points : <span class="bets">'.$srB.'</span><br>
									Winning : <span class="bets">'.$srW.'</span><br>
									Commission : <span class="bets">'.$srC.'</span><br>
									GGR : <span class="bets">'.$srG.'</span><br>
									GGR+Commission : <span class="bets">'.($srG+$srC).'</span>
								</div>
								<div class="icon"><i class="ion ion-bag"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h4 class="text-center">Regular InHome Bets</h4>Bets : <span class="bets">'.$iHI.'</span><br>
									Points : <span class="bets">'.$iHB.'</span><br>
									Winning : <span class="bets">'.$iHW.'</span><br>
									Commission : <span class="bets">'.$iHC.'</span><br>
									GGR : <span class="bets">'.$iHG.'</span><br>
									GGR+Commission : <span class="bets">'.($iHG+$iHC).'</span>
								</div>
								<div class="icon"><i class="ion ion-bag"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h4 class="text-center">Regular Out Bets</h4>Bets : <span class="bets">'.$oGI.'</span><br>
									Points : <span class="bets">'.$oGB.'</span><br>
									Winning : <span class="bets">'.$oGW.'</span><br>
									Commission : <span class="bets">'.$oGC.'</span><br>
									GGR : <span class="bets">'.$oGG.'</span><br>
									GGR+Commission : <span class="bets">'.($oGG+$oGC).'</span>
								</div>
								<div class="icon"><i class="ion ion-bag"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-xs-6">
							<div class="small-box bg-red">
								<div class="inner">
									<h4 class="text-center">
									All Market GGR</h4>Total : <span class="bets">'.$tI.'</span><br>
									Points : <span class="bets">'.$tB.'</span><br>
									Winning : <span class="bets">'.$tW.'</span><br>
									Commission : <span class="bets">'.$tC.'</span><br>
									GGR : <span class="bets">'.$ggr.'</span><br>
									GGR+Commission : <span class="bets">'.($ggr+$tC).'</span>
								</div>
								<div class="icon"><i class="ion ion-pie-graph"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>';
			die($dome);
			// <div class="col-lg-4 col-md-4 col-xs-6">
			// 	<div class="small-box bg-yellow">
			// 		<div class="inner">
			// 			<h4 class="text-center">Instant Worli Night Bets</h4>
			// 			Bets : <span class="bets">'.$rTI.'</span><br>
			// 			Points : <span class="bets">'.$rTB.'</span><br>
			// 			Winning : <span class="bets">'.$rTW.'</span><br>
			// 			Commission : <span class="bets">'.$rTC.'</span><br>
			// 			GGR : <span class="bets">'.$rTG.'</span><br>
			// 			GGR+Commission : <span class="bets">'.($rTG+$rTC).'</span>
			// 		</div>
			// 		<div class="icon"><i class="ion ion-person-add"></i></div>
			// 		<a href="#" class="small-box-footer">
			// 			More info
			// 			<i class="fa fa-arrow-circle-right"></i>
			// 		</a>
			// 	</div>
			// </div>
		}else{
			$feilds='id, client_name';
			$con=' WHERE status="A"';
			$this->data['client'] = $this->Common_model->getData('client',$con,$feilds,'','','','','');
			// $feilds1='id, bazar_name';
			// $con=' WHERE status="A"';
			// $this->data['bazar'] = $this->Common_model->getData('regular_bazar','',$feilds1,'','','','','');

			$this->load->view('admin/pnlBetween',$this->data);
		}
	}

	public function updatePending(){
		$data = $_POST;
		$conMy=' WHERE id IN ("'.implode('","',$data['ids']).'")';
		$fieldMy['status']="L";

		$con1=' INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.id IN ("'.implode('","',$data['ids']).'")';
		$this->load->model('Common_model');
		$arrLoss = $this->Common_model->getData('regular_bazar_games',$con1,'DISTINCT regular_bazar_games.partner_id,client.end_point_url','','','','','');
		if($data['type']=='0'){
			$type=' AND game_type="Open"';
		}else{
			$type=' AND game_type!="Open"';
		}
		$result = $this->Common_model->getData('regular_bazar_result',' WHERE id="'.$data['res'].'"','','','','One','','');
		$con=" WHERE result_date='".$result['result_date']."' AND bazar_name='".$result['bazar_name']."' AND status='P'".$type;
		$updateresultLose = updateAllLose('regular_bazar_games', $con, $fieldMy);
		$multiUrl = [];
		$multiData = [];
		$multiI = 0;
        foreach($arrLoss as $l){
            $con=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_name']."' AND status='L'".$type;
            if($l['partner_id']=='2' || $l['partner_id']=='5' || $l['partner_id']=='7'){
				$con.=' AND status="W"';
				$arrReq['result_date']=$result['result_date'];
				$arrReq['bazar_id']=$result['bazar_name'];
				$arrReq['type']=$type;
			}
			$arrLossBet = $this->Common_model->getData('regular_bazar_games',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Regular Bazar';
			$arrReq['market_code']='301';
            // requestForClient($l['end_point_url'],$arrReq);
			$multiUrl[$multiI]=$l['end_point_url'];
			$multiData[$multiI]=$arrReq;
			$multiI++;
        }
		$req = requestForMultiClient($multiUrl,$multiData);
		responseLog($req);
		responseLog($multiUrl);
		die(json_encode(['status'=>200,'massage'=>'Bets Updated.']));
	}


	public function rollBackResult($id=''){
		$this->load->model('Common_model');
		
		$con = " INNER JOIN regular_bazar ON regular_bazar_result.bazar_name=regular_bazar.id WHERE regular_bazar_result.id='".$id."'";
		$feilds = 'regular_bazar.id as bazar_id,regular_bazar.bazar_name,regular_bazar_result.result_date,regular_bazar_result.id,regular_bazar_result.open,regular_bazar_result.jodi,regular_bazar_result.close';
		$result = $this->Common_model->getData('regular_bazar_result',$con,$feilds,'','','One','','');
		
		if ($_POST) {
			
			if($_POST['game_type']=='Open'){
				$type = " AND game_type='Open'";
				$addResult = array(
					'open' => $_POST['open'], 
					'jodi' => $_POST['jodi'], 
					'updated' => date('Y-m-d H:i:s'), 
				);
			}else{
				$type = " AND game_type!='Open'";
				$addResult = array( 
					'close' => $_POST['open'], 
					'jodi' => $result['jodi'].$_POST['jodi'], 
					'updated' => date('Y-m-d H:i:s'), 
				);
			}

			$bazarResult = AddUpdateTable('regular_bazar_result', 'id', $id, $addResult);
			
        	if($bazarResult){
        		$con=" WHERE result_date='".$result['result_date']."' AND bazar_name='".$result['bazar_id']."'".$type;
                $field['status']="P";
				$field['winning_point']="0";
				$field['commission']="0";

				$field['winning_in_rs']="0";
				$field['commission_in_rs']="0";
                $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);
				
                /*------------------------ Update Wallet Start -------------------------*/
                $arrLoss = $this->Common_model->getData('client',' WHERE status="A"','id as partner_id,end_point_url','','','','','');
                $multiUrl = [];
				$multiData = [];
				$multiI = 0;
				foreach($arrLoss as $l){
                	$con=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_id']."'".$type;
                    $arrLossBet = $this->Common_model->getData('regular_bazar_games',$con,'transaction_id,customer_id,status','','','','','');
                    $arrReq['code']='901';
					$arrReq['arr']=json_encode($arrLossBet);
                    $arrReq['market']='Regular Bazar';
					$arrReq['market_code']='301';
                    // $req = requestForClient($l['end_point_url'],$arrReq);
					$multiUrl[$multiI]=$l['end_point_url'];
					$multiData[$multiI]=$arrReq;
					$multiI++;
				}
				$req = requestForMultiClient($multiUrl,$multiData);
				responseLog($req);
				responseLog($multiUrl);
                $this->session->set_flashdata('success', 'Result Rollback sucessfully!');
                redirect('f2356c74eddd4a15682b144eaacb3071');
                
        	}else{
        		$this->session->set_flashdata('error', 'Something Went Wrong');
        	}
        }
        $data['result']=$result;
		$this->load->view('admin/roll_back_result',$data);
	}


	public function regularBetsDetail($bazarId,$gameId,$gameType,$gameName){
		$this->load->model('Common_model');
		
		$con = " WHERE bazar_name='".$bazarId."' AND result_date='".date('Y-m-d')."'";
		$feilds = 'id,open,jodi,close';

		$data['gameName'] = $gameName;
		$data['bazar'] = $bazarId;
		$data['game'] = $gameId;
		$data['result'] = $this->Common_model->getData('regular_bazar_result',$con,$feilds,'','','One','','');
		if($gameType=='1'){
			$data['type'] = 'Open';
		}else if($gameType=='2'){
			$data['type'] = 'Close';
		}else{
			$data['type'] = 'Jodi';
		}
		$this->load->view('admin/regularBetsDetail',$data);
	}

	public function regularBetsListGameType(){
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getRegularData($postData);
	    echo json_encode($data);
	}


	public function addCustomerRate($id=''){
		$mcrypt = new MCrypt();
		$Common_model = $this->load->model('Common_model');
		if ($id > 0) {
			$data['rate'] = getRecordById('customer_rate', 'id', $id);
		}
		if ($_POST) {
			
			$cid = $_POST['client_name']=='2'?$mcrypt->encrypt($_POST['customer_id']):$_POST['customer_id'];
			
			$this->load->model('Common_model');
			$conLst=' WHERE partner_id="'.$_POST['client_name'].'" AND customer_id="'.$cid.'"';
			$lstU = $this->Common_model->getData('customer_rate',$conLst,'','','','One','','');
			
			if(empty($lstU)){
				
				$addResult = array(
					'partner_id' => $_POST['client_name'], 
					'customer_id' => $cid, 
					'rate' => $_POST['rate'], 
					'status' => "A",
					'created' => date('Y-m-d H:i:s'), 
				);
				
				if ($id > 0) {
					$updateresultid = AddUpdateTable('customer_rate', 'id', $id, $addResult);
				}else{
					$con=' WHERE customer_id="'.$mcrypt->decrypt($addResult['customer_id']).'"';
					$checkResult=$this->Common_model->getData('customer_rate',$con,'id','','','One','','');
					
					if(empty($checkResult)){
						$updateresultid = AddUpdateTable('customer_rate', '', '', $addResult);
					}else{
						$updateresultid=0;
					}
				}
				if ($updateresultid > 0) {
					$this->load->model('Common_model');
		    		$lstAct['entry_table'] = 'Customer Bhav';
					$lstAct['supportId'] = $_SESSION['adid']['id'];
					$lstAct['created'] = date('Y-m-d H:i:s');
					$feildsLst='rate,customer_id';
					$lst = $this->Common_model->getData('customer_rate',$conLst,$feildsLst,'','','One','','');
					$lstAct['detail'] = implode(', ',$lst);
					AddUpdateTable('lastActivity','','',$lstAct);
					redirect('e2392d2c34003606d9478ac36e766e34');
				}
			}else{
				$this->session->set_flashdata('error', 'Already Added!');
				redirect('e2392d2c34003606d9478ac36e766e34');
			}
		}
		$con=' WHERE status="A"';
		$data['client'] = $this->Common_model->getData('client',$con,'id,client_name','','','','','');
		$this->load->view('admin/addCustomerRate',$data);
	}

	public function listCustomerRate(){
		$Common_model = $this->load->model('Common_model');
		$con=' WHERE status="A"';
		$data['client'] = $this->Common_model->getData('client',$con,'id,client_name','','','','','');
		$this->load->view('admin/listCustomerRate',$data);
	}
	public function customerRateData(){
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getCustomerRateData($postData);
	    echo json_encode($data);
	}



	public function backBusiness(){
		if($_POST){
			
			$d = explode(' - ',$_POST['dateRange']);
					
			$this->load->model('Common_model');
			$List = $this->Common_model->getData('regular_bazar',' WHERE status="A"','id, bazar_name,open_time,close_time','','','','sequence ASC','');
			$arr=[];
			$from=date('Y-m-d',strtotime($d[0]));
			$to=date('Y-m-d',strtotime($d[1]));
			$feilds='COUNT(id) as id,SUM(point_in_rs) as point,SUM(winning_in_rs) as win,SUM(commission_in_rs) as com,COUNT(DISTINCT customer_id) as cid';
			$con1=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND regular_bazar_games.status NOT IN ("P","V") AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type="Home" AND status="A")';
	        // echo '<pre>';
			// print_r($con1);
			// die();
			$inP = $this->Common_model->getData('regular_bazar_games',$con1,$feilds,'','','One','','');

	        $con2=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND regular_bazar_games.status NOT IN ("P","V") AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type="Out" AND status="A")';
	        $outP = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','One','','');
	        
			$con3=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND regular_bazar_games.status NOT IN ("P","V") AND bazar_name IN (SELECT id FROM regular_bazar WHERE bazar_type="InHome" AND status="A")';
	        $inH = $this->Common_model->getData('regular_bazar_games',$con3,$feilds,'','','One','','');
	        
			$con=' INNER JOIN regular_bazar ON regular_bazar_games.bazar_name=regular_bazar.id WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND regular_bazar_games.status NOT IN ("P","V")';
			$feilds = 'COUNT(regular_bazar_games.id) as id,SUM(regular_bazar_games.point_in_rs) as point,COUNT(DISTINCT regular_bazar_games.customer_id) as cid,regular_bazar.bazar_name,regular_bazar.id as bazar_id,regular_bazar.open_time as oTime,regular_bazar.close_time as cTime,SUM(winning_in_rs) as win,SUM(point_in_rs-winning_in_rs) as ggr,SUM(commission) as com';
			$arr = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','regular_bazar.sequence asc','regular_bazar_games.bazar_name');

			$con4=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND regular_bazar_games.status NOT IN ("P","V")';
	        $cUni = $this->Common_model->getData('regular_bazar_games',$con4,'COUNT(DISTINCT customer_id) as cUni','','','One','','');
			
			$data = '<section class="content-header">
				<h1>
					<i class="fa fa-users"></i> Regular Bazar
				</h1>
				</section>
				<section>
					<div class="container-fluid">
						<div class="row">
							<div class="12">
								<table class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th>Sr.</th>
											<th>Players</th>
											<th>Bets</th>
											<th>Betting Amount</th>
											<th>Win</th>
											<th>Commission</th>
											<th>GGR</th>
											<th>Commission+GGR</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>IN</td>
											<td>
												'.$inP['cid'].'
											</td>
											<td>
												'.$inP['id'].'
											</td>
											<td>
												'.round($inP['point']).'
											</td>
											<td>
												'.round($inP['win']).'
											</td>
											<td>
												'.round($inP['com']).'
											</td>
											';
											$gIn=round($inP['point']-$inP['win']);
											if($gIn>0){
												$data .= '<td class="s">'.$gIn.'</td>';
											}else{
												$data .= '<td class="d">'.$gIn.'</td>';
											}
											if(($gIn+$inP['com'])>0){
												$data .= '<td class="s">'.($gIn+$inP['com']).'</td>';
											}else{
												$data .= '<td class="d">'.($gIn+$inP['com']).'</td>';
											}
									
									$data .='</tr>
										<tr>
											<td>IN Home</td>
											<td>
												'.$inH['cid'].'
											</td>
											<td>
												'.$inH['id'].'
											</td>
											<td>
												'.round($inH['point']).'
											</td>
											<td>
												'.round($inH['win']).'
											</td>
											<td>
												'.round($inH['com']).'
											</td>';
											
												$gIn=round($inH['point']-$inH['win']);
												if($gIn>0){
													$data .= '<td class="s">'.$gIn.'</td>';
												}else{
													$data .= '<td class="d">'.$gIn.'</td>';
												}
												if(($gIn+$inH['com'])>0){
													$data .= '<td class="s">'.($gIn+$inH['com']).'</td>';
												}else{
													$data .= '<td class="d">'.($gIn+$inH['com']).'</td>';
												}
										
									$data .= '</tr>
										<tr>
											<td>Out</td>
											<td>
												'.$outP['cid'].'
											</td>
											<td>
												'.$outP['id'].'
											</td>
											<td>
												'.round($outP['point']).'
											</td>
											<td>
												'.round($outP['win']).'
											</td>
											<td>
												'.round($outP['com']).'
											</td>';
											
												$gOut=round($outP['point']-$outP['win']);
												if($gOut>0){
													$data .= '<td class="s">'.$gOut.'</td>';
												}else{
													$data .= '<td class="d">'.$gOut.'</td>';
												}
												if(($gOut+$outP['com'])>0){
													$data .= '<td class="s">'.($gOut+$outP['com']).'</td>';
												}else{
													$data .= '<td class="d">'.($gOut+$outP['com']).'</td>';
												}
										
									$data .= '</tr>
										<tr style="background-color: pink;">
											<td>Total</td>
											<td>
												'.($inP['cid']+$outP['cid']+$inH['cid']).'('.$cUni['cUni'].')
											</td>
											<td>
												'.($inP['id']+$outP['id']+$inH['id']).'
											</td>
											<td>
												'.round($inP['point']+$outP['point']+$inH['point']).'
											</td>
											<td>
												'.round($inP['win']+$outP['win']+$inH['win']).'
											</td>
											<td>
												'.round($inP['com']+$outP['com']+$inH['com']).'
											</td>';
											
												$gIn=round($inP['point']-$inP['win'])+round($outP['point']-$outP['win'])+round($inH['point']-$inH['win']);
												if($gIn>0){
													$data .=  '<td style="color: green;">'.$gIn.'</td>';
												}else{
													$data .=  '<td style="color: red;">'.$gIn.'</td>';
												}
												$tCom = ($inP['com']+$outP['com']+$inH['com']);
												if(($gIn+$tCom)>0){
													$data .=  '<td style="color: green;">'.($gIn+$tCom).'</td>';
												}else{
													$data .=  '<td style="color: red;">'.($gIn+$tCom).'</td>';
												}
											
								$data .= '</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">';
						
								foreach($arr as $list){
									
							$data .= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								<a href="'.base_url().'59857792564e7b27ecd66c6570acd845/'.$list['bazar_id'].'/'.$list['bazar_name'].'?from='.$from.'&to='.$to.'">
									<div class="p3-game-list boxRegular">
										<p class="time"><span class="t otime">'.date('h:i A', strtotime($list['oTime'])).'</span> <span class="time-divider">|</span> <span class="t ctime">'.date('h:i A', strtotime($list['cTime'])).'</span></p>
										<div class="inner">
											<h4 class="bazarName">'.$list['bazar_name'].'</h4>
											<p> <span class="ctext"> Bets </span> : <span class="cvalue bets">'.$list['id'].'</span></p>
											<p> <span class="ctext"> Amount </span> : <span class="cvalue bets">'.$list['point'].'</span></p>
											<p> <span class="ctext"> Win </span> : <span class="cvalue bets">'.round($list['win'],2).'</span></p>
											<p> <span class="ctext"> Commission </span> : <span class="cvalue bets">'.round($list['com'],2).'</span></p>
											<p> <span class="ctext"> GGR </span> : <span class="cvalue bets">'.round($list['ggr'],2).'</span></p>
											<p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets">'.round(($list['ggr']+$list['com']),2).'</span></p>
											<p> <span class="ctext"> No Players </span> : <span class="cvalue bets">'.$list['cid'].'</span></p>
										</div>
									</div> 
								</a>
							</div>';
						} 
						$data .= '</div>
					</div>
				</section>';
			
			die(json_encode($data));
	        // $this->load->view('admin/regularBetRecordsBackBusiness',$arr);
		}else{
			$this->load->view('admin/backBusiness');
		}
	}

	public function regularTypeRecordsBackBusiness($id,$name){
		$this->load->model('Common_model');
		$arr['bazar_name'] = $name;
        $arr['bazar_id'] = $id;
		$arr['from'] = $_GET['from'];
        $arr['to'] = $_GET['to'];
		$con=' INNER JOIN regular_game_type ON regular_bazar_games.game_name=regular_game_type.id WHERE regular_bazar_games.result_date BETWEEN "'.$_GET['from'].'" AND "'.$_GET['to'].'" AND regular_bazar_games.bazar_name="'.$id.'"';
		
		$feilds = 'COUNT(regular_bazar_games.id) as count_id,SUM(regular_bazar_games.point_in_rs) as point,SUM(winning_in_rs) as win,regular_game_type.game_name,regular_game_type.id as game_id';
		// $feilds = 'COUNT(regular_bazar_games.id) as count_id,SUM(regular_bazar_games.point) as point,SUM(winning_point) as win,regular_game_type.game_name,regular_game_type.id as game_id';
		
        $arr['arr'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','regular_game_type.sequence asc','regular_bazar_games.game_name');
		$at = array_column($arr['arr'], 'game_id');
		$List = $this->Common_model->getData('regular_game_type','','id, game_name','','','','sequence ASC','');
		foreach ($List as $dataArray) {
			if(!in_array($dataArray['id'], $at)){
				$bazarResult['game_name'] = $dataArray['game_name'];
				$bazarResult['game_id'] = $dataArray['id'];
				$bazarResult['count_id'] = 0;
				$bazarResult['ggr'] = 0;
        	}else{
				$bazarResult['ggr'] = $dataArray['point']-$dataArray['win'];
			}
			if($bazarResult['game_name']!=''){
				array_push($arr['arr'],$bazarResult);
			}
        }
		
		$this->load->view('admin/regularTypeRecordsBackBusiness',$arr);
	}


	public function regularBetsDetailBackBusiness($bazarId,$gameId,$gameType,$gameName){
		$this->load->model('Common_model');
		$con = " WHERE bazar_name='".$bazarId."' AND result_date BETWEEN '".$_GET['from']."' AND '".$_GET['from']."'";
		$feilds = 'id,open,jodi,close';
		$data['gameName'] = $gameName;
		$data['bazar'] = $bazarId;
		$data['game'] = $gameId;
		$data['from'] = $_GET['from'];
		$data['to'] = $_GET['to'];
		$data['result'] = $this->Common_model->getData('regular_bazar_result',$con,$feilds,'','','One','','');
		if($gameType=='1'){
			$data['type'] = 'Open';
		}else if($gameType=='2'){
			$data['type'] = 'Close';
		}else{
			$data['type'] = 'Jodi';
		}
		$this->load->view('admin/regularBetsDetailBackBusiness',$data);
	}

	public function changeCustomerData(){
	    if(isset($_POST)){
	    	$addBhav['rate']=$_POST['bhav'];
	    	$id = AddUpdateTable('customer_rate', 'id', $_POST['id'], $addBhav);
	    	if($id){
	    		echo json_encode(['code'=>200,'massage'=>'Bhav Updated Successfully!']);
	    	}
	    }
	}

	public function customerList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getCustomerData($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/customerList', $this->data); 
		}
	}

	public function todaysPlayerList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getTodaysPlayerData($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/todaysPlayerList', $this->data); 
		}
	}

	public function regularRoundStatment(){
		$this->load->model('Common_model');
		// $con = " WHERE status='A'";
		$con = "";
        $data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name,open_time,close_time','','','','','');
		$this->load->view('admin/regularRoundStatment',$data);
	}

	

	public function getBazarResult(){
		if(isset($_POST['bazar'])){
			$this->load->model('Common_model');
			$con = " WHERE bazar_name='".$_POST['bazar']."' AND result_date='".$_POST['resultDate']."'";
			$d = $this->Common_model->getData('regular_bazar_result',$con,'open,close,jodi','','','One','','');
			if($d){
				die(json_encode(['status'=>200,'data'=>$d]));
			}else{
				die(json_encode(['status'=>300,'data'=>'***-**-***']));
			}
		}else{
			die(json_encode(['status'=>400,'data'=>'Please provide valid data.']));
		}
	}

	public function regularRoundStatmentData(){
		// die('working');
		$bazar =$_POST['bazar'];
		$type=$_POST['type'];
		$this->load->model('Common_model');
		$akda = "('0','1','2','3','4','5','6','7','8','9')";
		$sp = "('120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890')";
		$dp = "('100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990')";
		$tp = "('000','111','222','333','444','555','666','777','888','999')";
		$jodi = "('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79','80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','99')";
		if($type=='Akda'){
			$data = $akda;
		}else if($type=='SP'){
			$data = $sp;
		}else if($type=='DP'){
			$data = $dp;
		}else if($type=='TP'){
			$data = $tp;
		}else if($type=='JODI'){
			$data = $jodi;
			$_POST['op']='jodi';
		}
		$con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazar."' AND game_type='".$_POST['op']."' AND game IN ".$data;
		// $con = " WHERE result_date='2023-04-28' AND bazar_name='".$bazar."' AND game IN ".$data;
		// $feilds='game,sum(point_in_rs) as point';
		$feilds='game,sum(point) as point,count(id) as cId,count(DISTINCT customer_id) as uId';
        $d = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','','game');
		$nd = array_column($d, 'point', 'game');
		$nd1 = array_column($d, 'cId', 'game');
		$nd2 = array_column($d, 'uId', 'game');
		$arr=['status'=>200,'data'=>$nd,'dataCount'=>$nd1,'dataDistinct'=>$nd2];
		die(json_encode($arr));
	}


	public function segricatedRegularRoundStatment(){
		$this->load->model('Common_model');
		// $con = " WHERE status='A'";
		$con = "";
        $data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name,open_time,close_time,cutAk,cutSp,cutDp,cutTp,cutJodi','','','','','');
		$this->load->view('admin/segricatedRegularRoundStatment',$data);
	}

	public function segricatedRegularRoundStatmentNew(){
		$this->load->model('Common_model');
		// $con = " WHERE status='A'";
		$con = "";
        $data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name,open_time,close_time,cutAk,cutSp,cutDp,cutTp,cutJodi','','','','','');
		$this->load->view('admin/segricatedRegularRoundStatmentNew',$data);
	}

	public function segricatedRegularRoundStatmentData(){
		// die('working');
		$bazar =$_POST['bazar'];
		$type=$_POST['type'];
		$this->load->model('Common_model');
		$akda = "('0','1','2','3','4','5','6','7','8','9')";
		$sp = "('120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890')";
		$dp = "('100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990')";
		$tp = "('000','111','222','333','444','555','666','777','888','999')";
		$jodi = "('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79','80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','99')";
		if($type=='Akda'){
			$data = $akda;
		}else if($type=='SP'){
			$data = $sp;
		}else if($type=='DP'){
			$data = $dp;
		}else if($type=='TP'){
			$data = $tp;
		}else if($type=='JODI'){
			$data = $jodi;
			$_POST['op']='jodi';
		}
		$con = " WHERE result_date='".$_POST['resultDate']."' AND bazar_name='".$bazar."' AND game_type='".$_POST['op']."' AND game IN ".$data;
		
		$feilds='game,sum(point) as point,count(id) as cId,count(DISTINCT customer_id) as uId,GROUP_CONCAT(partner_id) as partner_id,GROUP_CONCAT(point) as amt';
		$d = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','','game');
		
		// $per = 0;
		// $feilds='DISTINCT partner_id as pId';
		// $d1 = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','','');
		// if($d1){
		// 	$nd3 = array_column($d1, 'pId');
		// 	$d2 = $this->Common_model->getData('client',' WHERE id IN ('.implode($nd3,",").')','SUM(percentage) as p','','','One','','');
		// 	$per = ($d2['p']/(count($nd3) * 100)) * 100;
		// }
		$d2 = $this->Common_model->getData('client',' WHERE status="A"','percentage,id','','','','','');
		$percentage = [];
		foreach($d2 as $ml){
			$percentage[$ml['id']] = $ml['percentage'];
		}
		$i=0;
		foreach($d as $e){
			$g = explode(",",$e['partner_id']);
			$h = $d[$i];
			$j = explode(",",$h['amt']);
			$pArr = [];
			$k=0;
			foreach($g as $f){
				if(array_key_exists($f,$pArr)){
					$pArr[$f] += $j[$k];
				}else{
					$pArr[$f] = $j[$k];
				}
				$k++;
			}
			$cP = 0;
			$oP = 0;
			if(!empty($pArr)){
				foreach($pArr as $x => $y){
					$c = ($percentage[$x] / 100) * $pArr[$x];
					$cP += $c;
					$oP += $pArr[$x] - $c;
				}
			}
			$pArr['cP'] = $cP;
			$pArr['oP'] = $oP;
			$d[$i]['myCal'] = $pArr;
			$i++;
		}

		$con1 = " WHERE bazarName='".$_POST['bazar']."' AND resultDate='".$_POST['resultDate']."' AND type='".$_POST['gType']."'";
		$c = $this->Common_model->getData('cutting',$con1,'cuttingPercentage','','','One','','');
		$nd = array_column($d, 'point', 'game');
		$nd1 = array_column($d, 'cId', 'game');
		$nd2 = array_column($d, 'uId', 'game');
		$nd3 = array_column($d, 'partner_id', 'game');
		$nd4 = array_column($d, 'amt', 'game');
		$nd5 = array_column($d, 'myCal', 'game');
		$arr=['status'=>200,'data'=>$nd,'dataCount'=>$nd1,'dataDistinct'=>$nd2,'calPer'=>$nd5,'cutting'=>$c,'partnerId'=>$nd3,'amt'=>$nd4];
		die(json_encode($arr));
	}

	public function addCutting(){
		$this->load->model('Common_model');
		$con = ' WHERE bazarName="'.$_POST['bazar'].'" AND type="'.$_POST['type'].'" AND resultDate="'.$_POST['date'].'"';
		$d = $this->Common_model->getData('cutting',$con,'id','','','One','','');
		
		$addResult['bazarName'] = $_POST['bazar'];
		$addResult['type'] = $_POST['type'];
		$addResult['cuttingPercentage'] = $_POST['percentage'];
		$addResult['resultDate'] = $_POST['date'];
		$addResult['updated'] = date('Y-m-d H:i:s');
		$addResult['cuttingData'] = json_encode($_POST['cuttingData']);
		// echo '<pre>';
		// print_r($addResult);
		// die();
		$addResult['adminId'] = $_SESSION['adid']['id'];
		if($d)
			$add = AddUpdateTable('cutting', 'id', $d['id'], $addResult);
		else
			$add = AddUpdateTable('cutting', '', '', $addResult);

		if($add)
			die(json_encode(['status'=>200,'message'=>'Cutting updated successfully!']));
		else
			die(json_encode(['status'=>400,'message'=>'Somthing wend wrong']));
		
	}

	public function cuttingRecord(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->cuttingRecord($postData);
		    echo json_encode($data);
		}else{
			$this->load->model('Common_model');
			$data['bazar'] = $this->Common_model->getData('regular_bazar','','id,bazar_name','','','','','');
			$this->load->view('admin/cuttingRecord', $data); 
		}
	}

	public function addData(){
		// $response = "Your response message here";
		// $log = log_message('info', "Your response message here");
		// $logErr = error_log($response);
		$message = "Your log message here";
		$log_path = APPPATH . 'logs/' . date('Y-m-d') . '-custom-log.php'; // Specify the log file path

		// Write the log message to the log file
		$log = file_put_contents($log_path, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
		echo 'done';die(json_encode($log));
		// $arr = array(
		// );

		// foreach($arr as $r){
		// 	$d = explode("-",$r['result']);
		// 	$nR['marketCode'] = 301;
		// 	$nR['resultDate'] = $r['result_date'];
		// 	$nR['open'] = $d[0];
		// 	$nR['jodi'] = $d[1];
		// 	$nR['close'] = $d[2];
		// 	$nR['bazarId'] = 36;
		// 	$req = sendResultDpbossNewProject(json_encode($nR),'https://resultwebsite.live/api/dpBoss/createAndUpdateBazarResult');
		// }
		// echo 'done';die();
	}

	public function outMarketPattiCutting(){
		$this->load->model('Common_model');
		$con = " WHERE bazar_type='Out' AND status='A'";
		$data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name,open_time,close_time','','','','','');
		$this->load->view('admin/outMarketPattiCutting',$data);
	}

	public function outMarketCutting(){
		$this->load->model('Common_model');
		$con = " WHERE status='A'";
		// $con = " WHERE status='A' AND bazar_type='Out'";
		$data['bazar'] = $this->Common_model->getData('regular_bazar',$con,'id,bazar_name,open_time,close_time','','','','','');
		$this->load->view('admin/outMarketCutting',$data);
	}
	public function outMarketCuttingData(){
		$this->load->model('Common_model');
		$data['baz'] = $this->Common_model->getData('regular_bazar'," WHERE id='".$_POST['bazarId']."'",'','','','One','','');
		$con = " WHERE bazar_name='".$_POST['bazarId']."' AND result_date='".$_POST['resultDate']."' AND status!='V'";
		$feild = "SUM(point) as point";
		$feild1 = "SUM(point) as point,game";
		$akda = "('0','1','2','3','4','5','6','7','8','9')";
		$sp = "('120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890')";
		$dp = "('100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990')";
		$tp = "('000','111','222','333','444','555','666','777','888','999')";
		$jodi = "('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63','64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79','80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95','96','97','98','99')";
		$data['jodi'] = $this->Common_model->getData('regular_bazar_games',$con." AND game IN ".$jodi,$feild,'','','One','','');
		
		$con1 .= $con." AND game_type IN ('HALF SANGAM','FULL SANGAM') ";
		if($_POST['bazarType']=='Open'){
			$con .= " AND game_type='Open' ";
		}else{
			$con .= " AND game_type!='Open' ";
		}
		$con .= " AND game IN ";
		$data['ak'] = $this->Common_model->getData('regular_bazar_games',$con.$akda,$feild,'','','One','','');
		// die(json_encode($this->db->last_query()));
		$data['sp'] = $this->Common_model->getData('regular_bazar_games',$con.$sp,$feild,'','','One','','');
		$data['dp'] = $this->Common_model->getData('regular_bazar_games',$con.$dp,$feild,'','','One','','');
		$data['tp'] = $this->Common_model->getData('regular_bazar_games',$con.$tp,$feild,'','','One','','');

		$feild .= ",game";
		$data['spB'] = $this->Common_model->getData('regular_bazar_games',$con.$sp,$feild,'','','','','game');
		$data['dpB'] = $this->Common_model->getData('regular_bazar_games',$con.$dp,$feild,'','','','','game');
		$data['tpB'] = $this->Common_model->getData('regular_bazar_games',$con.$tp,$feild,'','','','','game');
		$data['akB'] = $this->Common_model->getData('regular_bazar_games',$con.$akda,$feild,'','','','game asc','game');
		$data['sangam'] = $this->Common_model->getData('regular_bazar_games',$con1,$feild1,'','','','game asc','game');
		$data['res'] = $this->Common_model->getData('regular_bazar_result'," WHERE bazar_name='".$_POST['bazarId']."' AND result_date='".$_POST['resultDate']."'",'','','','One','','');
		// $data['res1'] = json_encode($this->db->last_query());
		die(json_encode($data));
	}

	public function changeCutting(){
		$this->load->model('Common_model');
		$addResult['cutAk'] = $_POST['akInp'];
		$addResult['cutSp'] = $_POST['spInp'];
		$addResult['cutDp'] = $_POST['dpInp'];
		$addResult['cutTp'] = $_POST['tpInp'];
		$addResult['cutJodi'] = $_POST['jodiInp'];
		$addResult['updated_by'] = $_SESSION['adid']['id'];
		$add = AddUpdateTable('regular_bazar', 'id', $_POST['bazarInp'], $addResult);

		if($add)
			die(json_encode(['status'=>200,'message'=>'Cutting updated successfully!']));
		else
			die(json_encode(['status'=>400,'message'=>'Somthing wend wrong']));
	}
	
}