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

class Manage_CurrencyRate extends BaseController{



	function __construct(){
	    parent::__construct();
	    if(! $this->session->userdata('adid'))
	    redirect('admin/login');
	}


    public function index(){
        $this->load->model('Common_model');
        if($this->input->post()){
            $postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getCurrencyRateList($postData);
		    echo json_encode($data);
        }else{
            $this->load->view('admin/currencyList');
        }
	    
	}





	public function AddCurrencyRate($id=''){
		$this->load->model('Common_model');
		if ($id > 0) {
			$data['currency'] = getRecordById('currency', 'id', $id);
		}
		if ($_POST) {
			$addResult = array(
				'country' => $_POST['country'], 
				'currency' => $_POST['currency'], 
				'minBetLimit' => $_POST['minBetLimit'],
				'currencyRate' => $_POST['currencyRate'],
				'updated_by' => $_SESSION['adid']['id']
			);
			if ($id > 0) {
				$updateresultid = AddUpdateTable('currency', 'id', $id, $addResult);
			}else{
				$updateresultid = AddUpdateTable('currency', '', '', $addResult);
			}
			if ($updateresultid > 0) {
				redirect('86c774568bf0aa9c94c15cc1cdb5f508');
			}else{
                $this->session->set_flashdata('error', $updateresultid);
                redirect('86c774568bf0aa9c94c15cc1cdb5f508');
            }
		}
		$this->load->view('admin/add_currency',$data);
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
	        	$bet = $this->Common_model->getData('regular_bazar_games',' WHERE id="'.$data.'"','partner_id,customer_id,bazar_name,game_name,result_date,point,game_type','','','One','','');
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
				
				$addResult['winning_in_rs']=$addResult['winning_point']*(double)$cR[$bet['partner_id']];
                $addResult['commission_in_rs']=$addResult['commission']*(double)$cR[$bet['partner_id']];

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
			$req = requestForMultiClient($multiUrl,$multiData);
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



}