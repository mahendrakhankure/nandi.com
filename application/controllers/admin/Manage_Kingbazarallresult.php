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

	    redirect('admin/login');

	}

	public function index(){

	    $this->load->model('ManageKingbazarallresult_Model');

	    $this->load->library('pagination');

	    $data['kingbazarallresult'] = $this->ManageKingbazarallresult_Model->getkingbazarallresultdetails();

	    $config['total_rows'] = count($data['kingbazarallresult']);

	    $config['per_page'] = 10;

		$config['num_links'] = 20;      

		$config['page_query_string'] = TRUE;

		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

	    // pr($this->pagination->create_links());

	    $this->load->view('admin/manage_kingbazarallresult',$data);

	}

	public function AddKingBazarResult($id=''){

		$this->load->model('ManageKingbazarallresult_Model');

		$data['kingbazarallgame'] = $this->ManageKingbazarallresult_Model->getkingbazarallGame();

		if ($id > 0) {

			$data['onegamedata'] = getRecordById('king_bazar_result', 'id', $id);

		}

		if ($_POST) {

			$addResult = array(

				'bazar' => $_POST['bazar_name'], 

				'result' => $_POST['result'], 

				'result_date' => $_POST['result_date'], 

				'status' => $_POST['result_mode'], 

				'created' => date('Y-m-d H:i:s'), 

				'updated' => date('Y-m-d H:i:s'), 

			);

			if ($id > 0) {

				$updateresultid = AddUpdateTable('king_bazar_result', 'id', $id, $addResult);

			}else{

				$updateresultid = AddUpdateTable('king_bazar_result', '', '', $addResult);

			}

				

			if ($updateresultid > 0) {

				redirect('admin/Manage_Kingbazarallresult');

			}

		}

		$this->load->view('admin/add_king_bazzar_result',$data);

	}

	public function deleteBazzarResult($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('king_bazar_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('admin/Manage_Kingbazarallresult');

		}

	}


	public function updateWalletKing(){
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

            	$bet = $this->Common_model->getData('king_bazar_game',' WHERE id="'.$data.'"','exchange_rate,transaction_id,bazar_name,game_name,result_date,point,partner_id','','','One','','');
				if($bet['partner_id']=='2'){
					$commission=$lC;
				}else if($bet['partner_id']=='4'){
					$commission=$fbC;
				}else{
					$commission=$oC;
				}
            	$rate = $this->Common_model->getData('king_bazar_rate',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_type="'.$bet['game_name'].'"','rate','','','One','','');

            	
    			$addResult['commission'] = ($commission / 100) * $bet['point']*$rate['rate'];
    			$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];
    			$addResult['status']= 'W';
				$addResult['winning_in_rs']=$addResult['winning_point']*(double)$bet['exchange_rate'];
                $addResult['commission_in_rs']=$addResult['commission']*(double)$bet['exchange_rate'];
				$updateresultid = AddUpdateTable('king_bazar_game', 'id', $data, $addResult);
    		}
    		
    		$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."'";
    		$field['status']="L";

    		$updateresultLose = updateAllLose('king_bazar_game', $con, $field);
    		
    		/*--------------------- Setel Market Loss Start --------------------------*/
    		$con1=" INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.result_date='".$bet['result_date']."' AND king_bazar_game.bazar_name='".$bet['bazar_name']."'";


    		$arrLossPartner = $this->Common_model->getData('king_bazar_game',$con1,'DISTINCT king_bazar_game.partner_id,client.end_point_url','','','','','');

    		$multiUrl = [];
			$multiData = [];
			$multiI = 0;
    		foreach($arrLossPartner as $l){
    			$con2=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."'";
    			if($l['partner_id']=='2' || $l['partner_id']=='5' || $l['partner_id']=='7'){
                    $con2.=' AND status="W"';
                    $arrReq['result_date']=$bet['result_date'];
                    $arrReq['bazar_id']=$bet['bazar_name'];
                }
    			$arrLossBet = $this->Common_model->getData('king_bazar_game',$con2,'transaction_id,winning_point,status,commission,customer_id','','','','','');
    			$arrReq['code']='601';
	    		$arrReq['rec']=json_encode($arrLossBet);
	    		$arrReq['market']='King Bazar';
				$arrReq['market_code']='501';
    			// $req = requestForClient($l['end_point_url'],$arrReq);
				if($l['end_point_url']=='https://laxminarayan.live/api/sattaMatka'){
					responseLogTest($arrReq);
					responseLogTest($l['end_point_url']);
				}
				$multiUrl[$multiI]=$l['end_point_url'];
				$multiData[$multiI]=$arrReq;
				$multiI++;
			}
			$req = requestForMultiClient($multiUrl,$multiData);
			responseLog($req);
			responseLog($multiUrl);
    		/*--------------------- Setel Market Loss End --------------------------*/

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

		$con1=' INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.id IN ("'.implode('","',$data['ids']).'")';
		$this->load->model('Common_model');
		$arrLoss = $this->Common_model->getData('king_bazar_game',$con1,'DISTINCT king_bazar_game.partner_id,client.end_point_url','','','','','');
		$result = $this->Common_model->getData('king_bazar_result',' WHERE id="'.$data['res'].'"','','','','One','','');
		$con=" WHERE result_date='".$result['result_date']."' AND bazar_name='".$result['bazar_name']."' AND status='P'";
        $updateresultLose = updateAllLose('king_bazar_game', $con, $fieldMy);
		$multiUrl = [];
		$multiData = [];
		$multiI = 0;
        foreach($arrLoss as $l){
            $con=" WHERE result_date='".$result['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$result['bazar_name']."' AND status='L'";
            $arrLossBet = $this->Common_model->getData('king_bazar_game',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='King Bazar';
			$arrReq['market_code']='501';
			if($l['partner_id']==2 || $l['partner_id']==5){
				$arrReq['result_date']=$result['result_date'];
				$arrReq['bazar_id']=$result['bazar_name'];
			}
            // $r = requestForClient($l['end_point_url'],$arrReq);
			$multiUrl[$multiI]=$l['end_point_url'];
			$multiData[$multiI]=$arrReq;
			$multiI++;
        }
		// echo '<pre>';
		// print_r($multiData);
		// die();
		$req = requestForMultiClient($multiUrl,$multiData);
		responseLog($req);
		responseLog($multiUrl);
		die(json_encode(['status'=>200,'massage'=>'Bets Updated.']));
	}
}