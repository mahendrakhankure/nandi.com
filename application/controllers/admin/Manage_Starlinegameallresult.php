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

	    if(! $this->session->userdata('adid'))

	    redirect('admin/login');

	}



	public function index(){

	    $this->load->model('ManageStarlinegameallresult_Model');

	    $this->load->library('pagination');

	    $data['starlinegameallresult'] = $this->ManageStarlinegameallresult_Model->getstarlinegameallresultdetails();
	   
	    $this->load->view('admin/manage_starlinegameallresult',$data);

	}



	public function AddStartLineResult($id=''){
		$this->load->model('ManageStarlinegameallresult_Model');

		$data['starlinegame'] = $this->ManageStarlinegameallresult_Model->getStarLineGame();



		if ($id > 0) {

			$data['onegamedata'] = getRecordById('table_result', 'id', $id);

		}



		if ($_POST) {



			$updateAddResult = array(

				'result_date' => $_POST['result_date'], 

				'game' => $_POST['bazar_name'], 

				'result_1' => $_POST['result_1'], 

				'result_2' => $_POST['result_2'], 

				'result_3' => $_POST['result_3'], 

				'result_4' => $_POST['result_4'], 

				'result_5' => $_POST['result_5'], 

				'result_6' => $_POST['result_6'], 

				'result_7' => $_POST['result_7'], 

				'result_8' => $_POST['result_8'], 

				'result_9' => $_POST['result_9'], 

				'result_10' => $_POST['result_10'], 

				'result_11' => $_POST['result_11'], 

				'result_12' => $_POST['result_12'], 

				'result_13' => $_POST['result_13'], 

				'result_14' => $_POST['result_14'], 

				'created' => date('Y-m-d'), 

				'updated' => date('Y-m-d h:i:s'), 

			);



			if ($id > 0) {

				$updateresultid = AddUpdateTable('table_result', 'id', $id, $updateAddResult);

			}else{

				$updateresultid = AddUpdateTable('table_result', '', '', $updateAddResult);

			}



			if ($updateresultid > 0) {

				redirect('admin/Manage_Starlinegameallresult');

			}

		}

		$this->load->view('admin/add_starline_result',$data);

	}





	public function deleteStarlineResult($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('table_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('admin/Manage_Starlinegameallresult');

		}

	}


	// public function updateWalletStar(){
    // 	$this->load->model('Common_model');
    // 	$this->load->model('ManageMatkaallgames_Model');
    // 	if(isset($_POST)){
	// 		$lC=0;
	// 		$fbC=0;
	// 		$com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
	// 		foreach($com as $c){
	// 			if($c['client_id']=='2'){
	// 				$lC=$c['commission'];
	// 			}
	// 			if($c['client_id']=='4'){
	// 				$fbC=$c['commission'];
	// 			}
	// 		}
    // 		foreach($_POST as $data){
    // 			$con = ' INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id WHERE starline_bazar_game.id="'.$data.'"';
    //             $feilds = 'starline_bazar_game.partner_id, starline_bazar_game.customer_id, starline_bazar_game.bazar_name, starline_bazar_game.game_name, starline_bazar_game.result_date, starline_bazar_game.time, starline_bazar_game.point, starline_bazar_time.time as timeId';

    //             $bet = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');

	// 			if($bet['partner_id']=='2'){
	// 				$commission=$lC;
	// 			}
	// 			if($bet['partner_id']=='4'){
	// 				$commission=$fbC;
	// 			}
    //             // echo '<pre>';
    //             // print_r($bet);
    //             // die();
    //         	// $bet = $this->Common_model->getData('starline_bazar_game',' WHERE id="'.$data.'"','partner_id,customer_id,bazar_name,game_name,result_date,time,point','','','One','','');
                
    //         	$rate = $this->Common_model->getData('starline_bhav',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_name="'.$bet['game_name'].'"','rate','','','One','','');
            	
    // 			$addResult['commission'] = ($commission / 100) * $bet['point']*$rate['rate'];
    // 			$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];
    // 			$addResult['status']= 'W';
    			
	// 			$updateresultid = AddUpdateTable('starline_bazar_game', 'id', $data, $addResult);
    // 		}

    // 		$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    // 		$field['status']="L";
    // 		$updateresultLose = updateAllLose('starline_bazar_game', $con, $field);

    // 		/*--------------------- Setel Market Start --------------------------*/
    // 		$con1=" INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='".$bet['result_date']."' AND starline_bazar_game.bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";


    // 		$arrLossPartner = $this->Common_model->getData('starline_bazar_game',$con1,'DISTINCT starline_bazar_game.partner_id,client.end_point_url','','','','','');
    // 		foreach($arrLossPartner as $l){

    // 			$con=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";

    // 			if($l['partner_id']=='2'){
    //                 $con.=' AND status="W"';
    //                 $arrReq['result_date']=$bet['result_date'];
    //                 $arrReq['bazar_id']=$bet['bazar_name'];
    //                 $arrReq['time']=$bet['timeId'];
    //             }
    // 			$arrLossBet = $this->Common_model->getData('starline_bazar_game',$con,'transaction_id,winning_point,status,commission,customer_id','','','','','');
    // 			$arrReq['code']='601';
	//     		$arrReq['arr']=json_encode($arrLossBet);
	//     		$arrReq['market']='Starline Bazar';
	// 			$arrReq['market_code']='401';
	// 			// if($l['partner_id']=='2'){
	// 			// 	echo '<pre>';
	// 			// 	print_r($arrReq);
	// 			// 	die();
	// 			// }
    // 			$req = requestForClient($l['end_point_url'],$arrReq);
    // 		}
    // 		/*--------------------- Setel Market End --------------------------*/
    		
    // 		$arr=[
    // 			'status'=>200,
    // 			'message'=>'Wallet Updated Successfully!'
    // 		];
    // 	}else{
    // 		$arr=[
    // 			'status'=>400,
    // 			'message'=>'Somthing Went Wrong'
    // 		];
    // 	}
    // 	die(json_encode($arr));
    // }

	public function updateWalletStar(){
		// echo 'working';die();
		$this->load->model('Common_model');
    	$this->load->model('ManageMatkaallgames_Model');
    	if(isset($_POST)){
			
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
    			$con = ' INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id WHERE starline_bazar_game.id="'.$data.'"';
                $feilds = 'starline_bazar_game.exchange_rate,starline_bazar_game.partner_id, starline_bazar_game.customer_id, starline_bazar_game.bazar_name, starline_bazar_game.game_name, starline_bazar_game.result_date, starline_bazar_game.time, starline_bazar_game.point, starline_bazar_time.time as timeId';

                $bet = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
				if($bet['partner_id']=='2'){
					$commission=$lC;
				}else if($bet['partner_id']=='4'){
					$commission=$fbC;
				}else{
					$commission=$oC;
				}
            	// $bet = $this->Common_model->getData('starline_bazar_game',' WHERE id="'.$data.'"','partner_id,customer_id,bazar_name,game_name,result_date,time,point','','','One','','');
                
            	$rate = $this->Common_model->getData('starline_bhav',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_name="'.$bet['game_name'].'"','rate','','','One','','');
            	
    			$addResult['commission'] = ($commission / 100) * $bet['point']*$rate['rate'];
    			$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];

				$addResult['winning_in_rs']=$addResult['winning_point']*(double)$bet['exchange_rate'];
                $addResult['commission_in_rs']=$addResult['commission']*(double)$bet['exchange_rate'];
    			$addResult['status']= 'W';
    			
				$updateresultid = AddUpdateTable('starline_bazar_game', 'id', $data, $addResult);
    		}

    		$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    		$field['status']="L";
    		$updateresultLose = updateAllLose('starline_bazar_game', $con, $field);

    		/*--------------------- Setel Market Start --------------------------*/
    		$con1=" INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='".$bet['result_date']."' AND starline_bazar_game.bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";


    		$arrLossPartner = $this->Common_model->getData('starline_bazar_game',$con1,'DISTINCT starline_bazar_game.partner_id,client.end_point_url','','','','','');
    		$multiUrl = [];
			$multiData = [];
			$multiI = 0;
			
			foreach($arrLossPartner as $l){

    			$con=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";

    			if($l['partner_id']=='2'){
                    $con.=' AND status="W"';
                    $arrReq['result_date']=$bet['result_date'];
                    $arrReq['bazar_id']=$bet['bazar_name'];
                    $arrReq['time']=$bet['timeId'];
                }
    			$arrLossBet = $this->Common_model->getData('starline_bazar_game',$con,'transaction_id,winning_point,status,commission,customer_id','','','','','');
    			$arrReq['code']='601';
	    		$arrReq['rec']=json_encode($arrLossBet);
	    		$arrReq['market']='Starline Bazar';
				$arrReq['market_code']='401';
				
    			// $req = requestForClient($l['end_point_url'],$arrReq);
				// updateResponceLog($req);
				$multiUrl[$multiI]=$l['end_point_url'];
				$multiData[$multiI]=$arrReq;
				$multiI++;
			}

			$req = requestForMultiClient($multiUrl,$multiData);
			responseLog($req);
			responseLog($multiUrl);
    		/*--------------------- Setel Market End --------------------------*/
    		// echo '<pre>';print_r($req);die();
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


    public function updatePending(){
		$data = $_POST;
		$conMy=' WHERE id IN ("'.implode('","',$data['ids']).'")';
		$fieldMy['status']="L";

		$con1=' INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.id IN ("'.implode('","',$data['ids']).'")';
		$this->load->model('Common_model');
		$arrLoss = $this->Common_model->getData('starline_bazar_game',$con1,'DISTINCT starline_bazar_game.partner_id,client.end_point_url','','','','','');
		$result = $this->Common_model->getData('starline_bazar_result',' WHERE id="'.$data['res'].'"','','','','One','','');
		$con=" WHERE result_date='".$result['result_date']."' AND bazar_name='".$result['bazar_name']."' AND status='P'";
		$updateresultLose = updateAllLose('starline_bazar_game', $con, $fieldMy);
		$multiUrl = [];
		$multiData = [];
		$multiI = 0;
        foreach($arrLoss as $l){
			if($l['partner_id']=='2' || $l['partner_id']=='5'){
				$arrReq['result_date']=$result['result_date'];
				$arrReq['bazar_id']=$result['bazar_name'];
				$arrReq['time']=$result['time'];
			}
            $con=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_name']."' AND status='L'";
            $arrLossBet = $this->Common_model->getData('starline_bazar_game',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Starline Bazar';
			$arrReq['market_code']='401';
            // $req = requestForClient($l['end_point_url'],$arrReq);
			$multiUrl[$multiI]=$l['end_point_url'];
			$multiData[$multiI]=$arrReq;
			$multiI++;
        }
		$req = requestForMultiClient($multiUrl,$multiData);
		responseLog($req);
		responseLog($multiUrl);
		die(json_encode(['status'=>200,'massage'=>'Bets Updated.']));
	}

}

