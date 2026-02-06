<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

require APPPATH.'../vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/helpers/MCrypt.php';



/**

 * Class : Manage_Matkagames (Manage_Matkagames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class CrezyMatka extends BaseController{
    public $testAmountForLaxmi = 1000;
    public $rounStatus = 0;
	function __construct(){
	    parent::__construct();
	}
	 
	public function index(){
        $this->load->model('Common_model');
        $data['buf'] = $this->Common_model->getData('buffer',' WHERE id="1"','status','','','One','','');
        $data['res'] = $this->Common_model->getData('crezyMatkaResult','','akda','6','0','','id desc','');
        $data['rId'] = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId,updated','','','One','','');
        if(isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])){
            $_GET['id'] = str_replace(" ","+",$_GET['id']);
            $con=' WHERE status="A" AND client_token="'.$_GET['token'].'"';
            $partner = $this->Common_model->getData('client',$con,'id,end_point_url','','','One','','');
            if(!empty($partner)){
                $_SESSION['end_point_url']=$partner['end_point_url'];
                $d1=requestForClient($partner['end_point_url'],['id'=>$_GET['id'],'code'=>'300']);
                // echo '<pre>working';
                // print_r($d1);
                // die();
                $res = json_decode($d1);
                if($res->Code==200){
                    $_SESSION['token']=$_GET['token'];
                    $_SESSION['app']=$_GET['app'];
                    $_SESSION['partner']=$partner;
                    $_SESSION['balance']=$res->data[0];
                    $_SESSION['userName']=$res->data[1];
                    $_SESSION['customer_id']=$_GET['id'];
                    $data['bal'] = $res->data[0];
                    $data['userName'] = $res->data[1];
                }
            }
        }
        $data['rate'] = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
        $data['client'] = $this->Common_model->getData('client_commission',' WHERE client_id="'.$partner['id'].'"','','','','One','','');
        // $this->load->view('user/crezyMatka',$data);
        // $this->load->view('user/crezyHtml',$data);
        $this->load->view('user/crazyHtmlCanvas',$data);
	}
    public function requestForSpeen(){
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        $r = rand(0,10);
        $addUsr['round_id']=$data->round_id;
        $addUsr['result_date']=date('Y-m-d');
        $addUsr['status']='A';
        $addUsr['akda']=$r;
        $res = AddUpdateTable('crezyMatkaResult', '', '', $addUsr);
        if($res){
            $arr = [
                [1,5],
                [4,10],
                [16,20],
                [2,8],
                [7,15],
                [6,13],
                [9,17],
                [11,18],
                [14,19],
                [3,12],
                [21,21],
            ];
            $t = rand(0,1);
            $notifyResult['market'] = 'speenZatkamatka';
            $notifyResult['akda'] = $arr[$r][$t];
            die(json_encode($notifyResult));
        }else{
            $arr = [
                'status'=>400,
                'message'=>'Please Try Again.'
            ];
            die(json_encode($arr));
        }
    }

    public function crezyWin(){
		$inp = file_get_contents('php://input');
        $req = json_decode($inp);
		if(isset($req->roundId)){
            $t = rand(1,38);
            $notifyResult['market'] = 'crezyMatka';
            // $notifyResult['akda'] = 1;
            $notifyResult['akda'] = $t;
            $notifyResult['bal'] = $_SESSION['balance'];

            $arr = [
                "1"=>200,
                "2"=>25,
                "3"=>10,
                "4"=>10,
                "5"=>50,
                "6"=>25,
                "7"=>10,
                "8"=>10,
                "9"=>10,
                "10"=>25,
                "11"=>100,
                "12"=>10,
                "13"=>10,
                "14"=>25,
                "15"=>10,
                "16"=>10,
                "17"=>50,
                "18"=>25,
                "19"=>10,
                "20"=>10,
                "21"=>10,
                "22"=>50,
                "23"=>25,
                "24"=>10,
                "25"=>10,
                "26"=>100,
                "27"=>25,
                "28"=>10,
                "29"=>10,
                "30"=>50,
                "31"=>25,
                "32"=>10,
                "33"=>10,
                "34"=>50,
                "35"=>25,
                "37"=>10,
                "38"=>10,
            ];
            $into = $arr[$t];
            $notifyResult['into'] = $into;
            $j = json_encode($notifyResult);
            ob_start();
            echo $j;
            $size = ob_get_length();
            header("Content-Encoding: none");
            header("Content-Length: {$size}");
            header("Connection: close");
            ob_end_flush();
            ob_flush();
            flush();
            
            $uW = $this->updateWalletCrezyWin($t,$req->roundId,$into);
            $cR = json_decode($uW);
            if($cR->status==200){
                $array = [
                    "balance"=>$_SESSION['balance'],
                    "message"=>"Bet Placed Successfully!",
                    "code"=>200
                ];
            }else{
                $array=[
                    'status'=>400,
                    'message'=>$cR->message
                ];
            }
            
            die(json_encode($array));
            // die('working');
        } else {
            die(json_encode(["message"=>"Please Provide Valid data","code"=>401]));
        }
	}

    public function crezyWinNew($id){
		if(isset($id)){
            $t = rand(0,36);
            // $nArr = [
            //     "10"=>[2,3,6,7, 8,11,12,14,15,18,19,20,23,24,27,28,31,32,35,36],
            //     "25"=>[1,5,9,13,17,22,26,30,34],
            //     "50"=>[4,16,21,29,33],
            //     "100"=>[10,25],
            //     "200"=>[0],
            // ];
            // $t = 2;
            $notifyResult['market'] = 'crezyMatka';
            // $notifyResult['akda'] = 1;
            $notifyResult['akda'] = $t;
            // $notifyResult['bal'] = $_SESSION['balance'];

            $arr = [
                "0"=>200,
                "1"=>25,
                "2"=>10,
                "3"=>10,
                "4"=>50,
                "5"=>25,
                "6"=>10,
                "7"=>10,
                "8"=>10,
                "9"=>25,
                "10"=>100,
                "11"=>10,
                "12"=>10,
                "13"=>25,
                "14"=>10,
                "15"=>10,
                "16"=>50,
                "17"=>25,
                "18"=>10,
                "19"=>10,
                "20"=>10,
                "21"=>50,
                "22"=>25,
                "23"=>10,
                "24"=>10,
                "25"=>100,
                "26"=>25,
                "27"=>10,
                "28"=>10,
                "29"=>50,
                "30"=>25,
                "31"=>10,
                "32"=>10,
                "33"=>50,
                "34"=>25,
                "35"=>10,
                "36"=>10,
            ];
            $into = $arr[$t];
            $notifyResult['into'] = $into;
            // $j = json_encode($notifyResult);
            // ob_start();
            // echo $j;
            // $size = ob_get_length();
            // header("Content-Encoding: none");
            // header("Content-Length: {$size}");
            // header("Connection: close");
            // ob_end_flush();
            // ob_flush();
            // flush();
            $rT['bhav']=$into;
            $rate = AddUpdateTable('crezyMatkaResult', 'round_id', $id, $rT);
            $res=requestForCrezyMatka('https://node.dpbosses.live/crezyMatka',json_encode($notifyResult));
            $uW = $this->updateWalletCrezyWin($t,$id,$into);
            $cR = json_decode($uW);
            if($cR->status==200){
                $array = [
                    "balance"=>$_SESSION['balance'],
                    "message"=>"Bet Placed Successfully!",
                    "code"=>200
                ];
            }else{
                $array=[
                    'status'=>400,
                    'message'=>$cR->message
                ];
            }
            // echo json_encode($array); 
            return json_encode($array);
        } else {
            // echo json_encode(["message"=>"Please Provide Valid data","code"=>401]);
            return json_encode(["message"=>"Please Provide Valid data","code"=>401]);
        }
	}

    public function updateWalletCrezyMatka($j){
        $data = json_decode($j);
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$data->round_id.'" AND game="'.$data->res.'" AND status="P"','','','','','','');
        if($bets){
            $lC=0;
            $fbC=0;
            $oC=0;
            $comR = array();
            $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
            foreach($com as $c){
                $comR[$c['client_id']] = $c['commission'];
            }
            
            $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
            $cR = array();
            foreach ($cCR as $d){
                $cR[$d['id']] = $d['currancy_rate'];
            }
            
            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets[0]['customer_id'].'" AND partner_id="'.$bets[0]['partner_id'].'"','rate','','','One','','');
            
            $bhav = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
            $rT['bhav']=$bhav['bhav'];
            $rate = AddUpdateTable('crezyMatkaResult', 'round_id', $data->round_id, $rT);
            foreach($bets as $b){
                $bArr = array();
                $commission = $comR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                
                if($rOC){
                    $win = ($b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ($commission / 100) * $bhav['bhav']*$b['point'];
                    $bArr['winning_point']=($bhav['bhav']*$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$b['exchange_rate'];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$b['exchange_rate'];
                $bArr['status']='W';
                $bArr['bhav'] = $bhav['bhav'];
                $bArr['updated'] = date('Y-m-d H:i:s');
                $res = AddUpdateTable('crezyMatkaGame', 'transaction_id', $b['transaction_id'], $bArr);
                if(!$res){
                    $arr=[
                        'status'=>400,
                        'message'=>'Wallet Not Updated!'
                    ];
                    // echo json_encode($arr);
                    return json_encode($arr);
                }
            } 
        }
        $con=" WHERE round_id='".$data->round_id."' AND status='P'";
        $field['status']="L";
        $field['updated'] = date('Y-m-d H:i:s');
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."'",'DISTINCT partner_id','','','','','');
        if($arrLoss){
            $multiUrl = [];
            $multiData = [];
            $multiI = 0;
            foreach($arrLoss as $l){
                $la = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
                $con="  WHERE round_id='".$data->round_id."'";
                $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'bhav,transaction_id,customer_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Crazy Wheel';
                $arrReq['market_code']='101';
                // $arrReq['round_id']=$data->round_id;
                
                $multiUrl[$multiI]=$la['end_point_url'];
                $multiData[$multiI]=$arrReq;
                $multiI++;
                
                responseLogTest("crazy matka end point =>".$la['end_point_url']); 
            }
            $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."'",'winning_point, customerName','','','','','');
            if(count($arrWinner)>0){
                $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
            }
            responseLog($multiData);
            $req = requestForMultiClient($multiUrl,$multiData);
            
            $cR = json_decode($req);
            responseLog($multiUrl);
            responseLog(json_encode($req));
            if($cR[0]->Code==200){
                $arr=[
                    'status'=>200,
                    'message'=>'Wallet Updated Successfully!'
                ];
            }else{
                $arr=[
                    'status'=>400,
                    'message'=>'Client not responding!'
                ];
            }
        }else{
            $arr=[
                'status'=>200,
                'message'=>'Wallet Updated Successfully!'
            ];
        }
        // echo json_encode($arr);
        return json_encode($arr);
        /*--------------------- Setel Market End --------------------------*/
    }
    
    public function updateWalletCrezyWin($t,$rId,$into){
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="11" AND status="P"','','','','','','');
        if($bets){
            $lC=0;
            $fbC=0;
            $oC=0;
            $comR = array();
            $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
            foreach($com as $c){
                $comR[$c['client_id']] = $c['commission'];
            }
            
            $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
            $cR = array();
            foreach ($cCR as $d){
                $cR[$d['id']] = $d['currancy_rate'];
            }
            
            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets[0]['customer_id'].'" AND partner_id="'.$bets[0]['partner_id'].'"','rate','','','One','','');
            foreach($bets as $b){
                $bArr = array();
                $commission = $comR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                responseLog($commission);
                responseLog($b['partner_id']);
                if($rOC){
                    $win = ((int)$b['point']*$into) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ((int)$commission / 100) * (int)$into*(int)$b['point'];
                    $bArr['winning_point']=((int)$into*(int)$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$b['exchange_rate'];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$b['exchange_rate'];
                $bArr['status']='W';
                $bArr['bhav']=(int)$into;
                $bArr['updated'] = date('Y-m-d H:i:s');
                $res = AddUpdateTable('crezyMatkaGame', 'transaction_id', $b['transaction_id'], $bArr);
                if(!$res){
                    $arr=[
                        'status'=>400,
                        'message'=>'Wallet Not Updated!'
                    ];
                    return json_encode($arr);
                }
            } 
        }
        $con=" WHERE round_id='".$rId."' AND status='P'";
        $field['status']="L";
        $field['updated'] = date('Y-m-d H:i:s');
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        // return json_encode($updateresultLose);
        // die();
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'DISTINCT partner_id','','','','','');
        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        if($arrLoss){
            // $l = $this->Common_model->getData('client',' WHERE id="'.$bets[0]['partner_id'].'"','end_point_url','','','One','','');
            foreach($arrLoss as $l){
                $con="  WHERE round_id='".$rId."' AND partner_id='".$l['partner_id']."'";
                $end = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
                $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'bhav,transaction_id,customer_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Crazy Wheel';
                $arrReq['market_code']='101';
                $multiUrl[$multiI]=$end['end_point_url'];
                $multiData[$multiI]=$arrReq;
                $multiI++;
            }
            $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."' AND status='W'",'winning_point, customerName','','','','','');
            if(count($arrWinner)>0){
                $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
            }
            $req = requestForMultiClient($multiUrl,$multiData);
            $cR = json_decode($req);
            responseLog($multiUrl);
            responseLog('Request For Settlement'.$req);
            if($cR[0]->Code==200){
                $arr=[
                    'status'=>200,
                    'message'=>'Wallet Updated Successfully!'
                ];
            }else{
                $arr=[
                    'status'=>400,
                    'message'=>'Client not responding!'
                ];
            }
        }else{
            $arr=[
                'status'=>200,
                'message'=>'Wallet Updated Successfully!'
            ];
        }
        return json_encode($req);
        /*--------------------- Setel Market End --------------------------*/
    }

    
    public function flipCoin(){
		$inp = file_get_contents('php://input');
        $req = json_decode($inp);
		if(isset($req->customer_id) && isset($req->games) && isset($req->tokenId) && isset($req->roundId) && isset($req->coinS)){
            if($req->coinS=="head"){
                $win = 1;
            }else{
                $win = 2;
            }
            $type = "Loss";
            $t = rand(1,10);
            $notifyResult['market'] = 'flipCoin';
            // $notifyResult['akda'] = 1;
            $notifyResult['akda'] = rand(1,2);
            $notifyResult['bal'] = $_SESSION['balance'];
            $highest = [
                "1"=>10,
                "2"=>20,
                "3"=>30,
                "4"=>40,
                "5"=>50,
                "6"=>60,
                "7"=>70,
                "8"=>80,
                "9"=>90,
                "10"=>100
            ];
            $lowest = [
                "1"=>100,
                "2"=>90,
                "3"=>80,
                "4"=>70,
                "5"=>60,
                "6"=>50,
                "7"=>40,
                "8"=>30,
                "9"=>20,
                "10"=>10
            ];
            $notifyResult['head'] = $highest[$t];
            $notifyResult['tail'] = $lowest[$t];
            if($notifyResult['akda']==$win){
                $type = "Win";
                if($win==1){
                    $into = $notifyResult['head'];
                }else{
                    $into = $notifyResult['tail'];
                }
            }
            if($notifyResult['akda']==1){
                $bArr['resultCoin']="head";
            }else{
                $bArr['resultCoin']="tail";
            }


            $bArr['roundId']=$req->roundId;
            // $bArr['userCoin']=$req->coinS;
            
            $bArr['headRate']=$notifyResult['head'];
            $bArr['tailRate']=$notifyResult['tail'];
            $notifyResult['cn'] = json_encode($bArr);
            $res = AddUpdateTable('coinFlipResult', '', '', $bArr);

            if(!$res){

            }
            $notifyResult['type'] = $type;
            $j = json_encode($notifyResult);
            ob_start();
            echo $j;
            $size = ob_get_length();
            header("Content-Encoding: none");
            header("Content-Length: {$size}");
            header("Connection: close");
            ob_end_flush();
            ob_flush();
            flush();
            $uW = $this->updateFlipCoinWin($type,$req->roundId,$into);
            $cR = json_decode($uW);
            if($cR->status==200){
                $array = [
                    "balance"=>$_SESSION['balance'],
                    "message"=>"Bet Placed Successfully!",
                    "code"=>200
                ];
            }else{
                $array=[
                    'status'=>400,
                    'message'=>$cR->message
                ];
            }
            die(json_encode($array));
        } else {
            die(json_encode(["message"=>"Please Provide Valid data","code"=>401]));
        }
	}

    public function updateFlipCoinWin($rId,$into){
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="11" AND status="P"','','','','','','');
        if($bets){
            $lC=0;
            $fbC=0;
            $oC=0;
            $comR = array();
            $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
            foreach($com as $c){
                $comR[$c['client_id']] = $c['commission'];
            }
            
            $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
            $cR = array();
            foreach ($cCR as $d){
                $cR[$d['id']] = $d['currancy_rate'];
            }
            
            foreach($bets as $b){
                $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$b['customer_id'].'" AND partner_id="'.$b['partner_id'].'"','rate','','','One','','');
            
                $bArr = array();
                $commission = $comR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                if($rOC){
                    $win = ((int)$b['point']*$into) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ((int)$commission / 100) * (int)$into*(int)$b['point'];
                    $bArr['winning_point']=((int)$into*(int)$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$b['exchange_rate'];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$b['exchange_rate'];
                $bArr['status']='W';
                $bArr['updated'] = date('Y-m-d H:i:s');
                $res = AddUpdateTable('crezyMatkaGame', 'transaction_id', $b['transaction_id'], $bArr);
                if(!$res){
                    $arr=[
                        'status'=>400,
                        'message'=>'Wallet Not Updated!'
                    ];
                    return json_encode($arr);
                }
            } 
            $con=" WHERE round_id='".$rId."' AND status='P'";
            $field['status']="L";
            $field['updated'] = date('Y-m-d H:i:s');
            $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
            
            /*--------------------- Setel Market Start --------------------------*/
            $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'partner_id','','','','','');
            if($arrLoss){
                $multiUrl = [];
                $multiData = [];
                $multiI = 0;
                foreach($arrLoss as $l){
                    $end = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
                    $con="  WHERE round_id='".$l['partner_id']."'";
                    $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'transaction_id,status,winning_point,commission,round_id,result_date,point,game','','','','','');
                    $arrReq['code']='601';
                    $arrReq['rec']=json_encode($arrLossBet);
                    $arrReq['market']='Crazy Wheel';
                    $arrReq['market_code']='101';
                    $multiUrl[$multiI]=$end['end_point_url'];
                    $multiData[$multiI]=$arrReq;
                    $multiI++;
                }

                $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'winning_point, customerName','','','','','');
                if(count($arrWinner)>0){
                    $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
                }
                $req = requestForMultiClient($multiUrl,$multiData);
                $cR = json_decode($req);
                if($cR[0]->Code==200){
                    $arr=[
                        'status'=>200,
                        'message'=>'Wallet Updated Successfully!'
                    ];
                }else{
                    $arr=[
                        'status'=>400,
                        'message'=>'Client not responding!'
                    ];
                }
            }else{
                $arr=[
                    'status'=>200,
                    'message'=>'Wallet Updated Successfully!'
                ];
            }
        }else{
            $arr=[
                'status'=>200,
                'message'=>'Wallet Updated Successfully!'
            ];
        }
        return json_encode($arr);
        /*--------------------- Setel Market End --------------------------*/
    }

    // public function requestToGetBet(){
    //     $new = $this->setRound();
    //     $data=requestForCrezyMatka('https://node.dpbosses.live/getBets',json_encode([]));
    //     $d = $this->getResultOfRound();
    //     $data = json_decode($d);
    //     $res=requestForCrezyMatka('https://node.dpbosses.live/startRound',$d);
    //     sleep(10);
    //     if($data->res!=10 && $data->res!=11){
    //         $this->updateWalletCrezyMatka($d); 
    //         $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
    //         sleep(20);
    //     }else if($data->res==10){
    //         sleep(5);
    //         $this->flipCoinSpeenWheel($data->round_id);
    //         sleep(10);
    //         $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
    //         sleep(20);
    //     }else{
    //         sleep(5);
    //         $this->crezyWinNew($data->round_id);
    //         sleep(10);
    //         $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
    //         sleep(20);
    //     }
    // }

    public function requestToGetBetEndLess(){
        $this->load->model('Common_model');
        $roundId = $this->Common_model->getData('crezyMatkaRound','','','','','One','','');
        $to_time = strtotime($roundId["updated"]);
        // $to_time = strtotime("2025-05-10 18:02:59");
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $time = round(abs($to_time - $from_time) / 60,2);
        if($time > 2){
            while(1){
                if($this->rounStatus==0){
                    $new = $this->setRound();
                    $data=requestForCrezyMatka('https://node.dpbosses.live/getBets',json_encode([]));
                    $d = $this->getResultOfRound();
                    $data = json_decode($d);
                    $res=requestForCrezyMatka('https://node.dpbosses.live/startRound',$d);
                    sleep(10);
                    if($data->res!=10 && $data->res!=11){
                        $this->updateWalletCrezyMatka($d); 
                        $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
                        sleep(20);
                    }else if($data->res==10){
                        sleep(5);
                        $this->flipCoinSpeenWheel($data->round_id); //red and black
                        sleep(10);
                        $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
                        sleep(20);
                    }else{
                        sleep(5);
                        $this->crezyWinNew($data->round_id); // crazy matka
                        sleep(10);
                        $res=requestForCrezyMatka('https://node.dpbosses.live/startTimer',$d);
                        sleep(20);
                    }
                }else{
                    break;
                }
            }
        }else{
            echo round(abs($to_time - $from_time) / 60). " minute";
            return true;
        }
    }

    public function PlaceBets(){
		$inp = file_get_contents('php://input');
        $req = json_decode($inp);
        // $req = $_POST;
		if(isset($req->customer_id) && isset($req->games) && isset($req->tokenId) && isset($req->totalAmount)){
            $date = date('Y-m-d'); 
            $this->load->model('Common_model');
            if(!empty($req->games)){
                $client = $this->Common_model->getData('client',' WHERE client_token="'.$req->tokenId.'"','end_point_url,id,currancy_rate','','','One','','');
                $data=requestForClient($client['end_point_url'],['id'=>$req->customer_id,'code'=>'300']);
                $res = json_decode($data);
                $conversion = exchangeCurrency($req->app, 'INR');
                if ($conversion['status']) {
                    if($res->Code==200 && $res->data[0] >= $req->totalAmount){
                        $_SESSION['balance']=$res->data[0];
                        $cArr['arr']=[];
                        $myBet=[];
                        $rId = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId','','','One','','');
                        $roundId=$rId['roundId'];
                        foreach ($req->games as $arr) {
                            if($arr->coin > 0 && $_SESSION['balance'] >= $arr->coin){
                                $betArr=[];
                                $betArr['transaction_id'] = transactionID(10,10).time();
                                $betArr['round_id'] = $roundId;
                                $betArr['customerName'] = $req->userName;
                                $betArr['result_date'] = $date;
                                $betArr['point'] = (int)$arr->coin;
                                $betArr['game'] = (string)intval($arr->akda);
                                $betArr['partner_id'] = (int)$client['id'];
                                $betArr['customer_id'] = $req->customer_id;
                                $betArr['status'] = 'P';
                                $betArr['point_in_rs'] = $betArr['point']*$conversion['conversion_rate'];
                                $betArr['exchange_rate'] = $conversion['conversion_rate'];
                                // $betArr['currency_code'] = 'OS';
                                $betArr['currency_code'] = $req->app;
                                array_push($myBet,$betArr);
                                
                                $_SESSION['balance']=$_SESSION['balance']-$arr->coin;
                                
                                if($betArr['game'] == 10){
                                    $betArr['game'] = 'Red&Black';
                                }else if($betArr['game'] == 11){
                                    $betArr['game'] = 'Crazy Wheel';
                                }


                                unset($betArr['partner_id']);
                                unset($betArr['point_in_rs']);
                                unset($betArr['customerName']);
                                array_push($cArr['arr'],$betArr);
                            }
                        }
                        
                        $cArr['arr'] = json_encode($cArr['arr']);
                        $cArr['code']='101';
                        $cArr['id']=$req->customer_id;
                        $add = newAddUpdateTable('crezyMatkaGame','','',$myBet);
                        
                        
                        if($add){
                            $reqJ = requestForClient($client['end_point_url'],$cArr);
                            betResponseLog(["Crazy Wheel", $client['end_point_url'], $cArr, $reqJ]);
                            $jReq = json_decode($reqJ);
                            if($jReq->Code==200){
                                $arr = [
                                    'status'=>200,
                                    'message'=>'Bet Accepted.',
                                    'data'=>$reqJ
                                ];
                                die(json_encode($arr));
                            }else{
                                $CI = &get_instance();
                                $sql = "UPDATE crezyMatkaGame SET status = 'V' WHERE round_id = ? AND customer_id = ?";
                                $sth = $CI->db->query($sql, [$round_id, $req->customer_id]);
                                if($jReq->Code==203){
                                    $array['message'] = $jReq->message;
                                }else{
                                    $array['message'] = "Bet not accepted by client.";
                                }
                                $array["code"] = 203;
                                die(json_encode($arr));
                            }
                        }else{
                            $array = [
                                "message"=>"Please Try again.",
                                "code"=>203,
                            ];
                        }
                    } else {
                        $array = [
                            "message"=>"You Dont Have Sufficient Balance.",
                            "code"=>203,
                        ];
                    }
                } else {
                    $array = [
                        "message" => "Third party error.",
                        "code" => 203,
                    ];
                }
            }else {
                $array = [
                    "message"=>"Please Select Game And Bet Points.",
                    "code"=>202,
                ];
            }
            die(json_encode($array));
        } else {
            die(json_encode(["message"=>"Please Provide Valid data","code"=>401]));
        }
	}

    public function getResultOfRound(){
        $this->load->model('Common_model');
        $rId = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId','','','One','','');
        $roundId=$rId['roundId'];
        // $r = rand(0,11);
        $r = $this->getProb();
        // $r = 11;
        // if($r==10 || $r==11){
        //     $r = rand(0,11);
        // }
        $addUsr['round_id']=$roundId;
        $addUsr['result_date']=date('Y-m-d');
        $addUsr['status']='A';
        $addUsr['akda']=$r;
        if($r!=10 && $r!=11){
            $bhav = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
            $addUsr['bhav']=$bhav['bhav'];
        }
        // $addUsr['akda']=11; // for crezy matka
        // $addUsr['akda']=10; // for flip coin
        // $possibilities = $this->getPossibilities();
        $res = AddUpdateTable('crezyMatkaResult', '', '', $addUsr);
        if($res){
            $arr = [
                [1,5,23,27],
                [4,10,26,32],
                [17,21,39,43],
                [2,8,24,30],
                [7,16,29,38],
                [6,14,28,36],
                [9,18,31,40],
                [12,19,34,41],
                [15,20,37,42],
                [3,13,25,35],
                [11,33,11,33],
                [22,44,22,44],
            ];
            $t = rand(0,1);
            $notifyResult['market'] = 'speenZatkamatka';
            $notifyResult['akda'] = $arr[$r][$t];
            $notifyResult['res'] = $r;
            // $notifyResult['akda'] = 22; // for crezy matka
            // $notifyResult['res'] = 11; // for crezy matka
            // $notifyResult['res'] = 10; // for flip coin
            // $notifyResult['akda'] = 33; // for flip coin
            $notifyResult['round_id'] = $roundId;
            $j = json_encode($notifyResult);
            return $j;
        }else{
            $arr = [
                'status'=>400,
                'message'=>'Please Try Again.'
            ];
            return json_encode($arr);
        }
    }

    public function setRound(){
        $addUsr['roundId']=transactionID(15,15).time();
        $addUsr['status']='A';
        $res = AddUpdateTable('crezyMatkaRound', 'id', '1', $addUsr);
        if($res){
            $arr = [
                "message"=>"Round Updated",
                "status"=>200,
            ];
        }else{
            $arr = [
                "message"=>"Round Not Updated!",
                "status"=>400,
            ];
        }
        return json_encode($arr);
    }
    public function voiceToText(){
        $this->load->view('user/voiceTotext');
    }

  
    public function flipCoinSpeenWheel($id){
		if(isset($id)){
            $t = rand(0,23);
            // $t = 9;
            $redBlack = rand(0,1);
            $notifyResult['market'] = 'crezyFlipCoinMatka';
            $notifyResult['random'] = $t;
            // $notifyResult['akda'] = 1;
            $notifyResult['akda'] = 11;
            // $notifyResult['bal'] = $_SESSION['balance'];
            // $arr = [[0,2,4,6,8,10],[1,3,5,7,9,11]];
            
            $arr = [[1,3,5,7,9,11,13,15,17,19,21],[0,2,4,6,8,10,12,14,16,18,20,22]];
            // $arr = [[0,2,4,6,8,10,12,14,16,18,20,22],[1,3,5,7,9,11,13,15,17,19,21]];
            $arrF = $arr[$redBlack];
            $randF = array_rand($arrF,1);
            $notifyResult['wheelAkda'] = $arrF[$randF];
            // $notifyResult['wheelAkda'] = $t;
            
            $highest = [
                "0"=>2,
                "1"=>3,
                "2"=>4,
                "3"=>5,
                "4"=>6,
                "5"=>7,
                "6"=>8,
                "7"=>9,
                "8"=>10,
                "9"=>11,
                "10"=>12,
                "11"=>13,
                "12"=>14,
                "13"=>15,
                "14"=>16,
                "15"=>17,
                "16"=>18,
                "17"=>19,
                "18"=>20,
                "19"=>21,
                "20"=>22,
                "21"=>23,
                "22"=>24,
                "23"=>25
            ];
            $lowest = [
                "0"=>25,
                "1"=>24,
                "2"=>23,
                "3"=>22,
                "4"=>21,
                "5"=>20,
                "6"=>19,
                "7"=>18,
                "8"=>17,
                "9"=>16,
                "10"=>15,
                "11"=>14,
                "12"=>13,
                "13"=>12,
                "14"=>11,
                "15"=>10,
                "16"=>9,
                "17"=>8,
                "18"=>7,
                "19"=>6,
                "20"=>5,
                "21"=>4,
                "22"=>3,
                "23"=>2
            ];
            $notifyResult['red'] = $highest[$t];
            $notifyResult['black'] = $lowest[$t];
            
            if($redBlack==0){
                $bArr['resultCoin']="red";
                $into = $notifyResult['red'];
            }else{
                $bArr['resultCoin']="black";
                $into = $notifyResult['black'];
            }
            
            $rT['bhav']=$into;
            $rate = AddUpdateTable('crezyMatkaResult', 'round_id', $id, $rT);

            $notifyResult['rate'] = $into;
            $bArr['roundId']=$id;
            $bArr['redRate']=$notifyResult['red'];
            $bArr['blackRate']=$notifyResult['black'];
            $notifyResult['cn'] = json_encode($bArr);
            $res = AddUpdateTable('coinFlipResult', '', '', $bArr);

            $res=requestForCrezyMatka('https://node.dpbosses.live/speenFlipCoin',json_encode($notifyResult));
            
            $uW = $this->updateWalletSpeenFlipCoinWin($id,$into);
            $cR = json_decode($uW);
            if($cR->status==200){
                $array = [
                    "balance"=>$_SESSION['balance'],
                    "message"=>"Bet Placed Successfully!",
                    "code"=>200
                ];
            }else{
                $array=[
                    'status'=>400,
                    'message'=>$cR->message
                ];
            }
            // echo json_encode($array);
            return json_encode($array);
        } else {
            // echo json_encode(["message"=>"Please Provide Valid data","code"=>401]);
            return  json_encode(["message"=>"Please Provide Valid data","code"=>401]);
        }
	}


    public function getPossibilities(){
        $this->load->model('Common_model');
        $roundId = $this->Common_model->getData('crezyMatkaRound','','','','','One','','');
        $rate = $this->Common_model->getData('crezyMatkaBhav','','','','','One','','');
        $feilds = "SUM(point) as point,count(DISTINCT customer_id) as cCount,game";
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="kOhYqLGazG6p1yu9mtcatvIlaIQrlNLd" AND status="P"',$feilds,'','','','','game');
        // $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$roundId['roundId'].'" AND status="P"','','','','','','');
        // die(json_encode($bets));
        $pArr = [];
        $totalPoint = array_sum(array_column($bets,'point'));
        foreach($bets as $b){
            if($b['game']==10){
                $b['win'] = $b['point']*100;
            }else if($b['game']==11){
                $b['win'] = $b['point']*5.5;
            }else{
                $b['win'] = $b['point']*$rate['bhav'];
            }
            $b['prof'] = $totalPoint-$b['win'];
            array_push($pArr,$b);
        }
        $profit =  (($totalBet/100)*$rate['profit']);
        $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
        if(!$resultPatti){
            $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
        }
        echo '<pre>';
        print_r($resultPatti);
        print_r($pArr);
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
    public function checkLoop(){
        $this->load->model('Common_model');
        $roundId = $this->Common_model->getData('crezyMatkaRound','','','','','One','','');
        $to_time = strtotime($roundId["updated"]);
        // $to_time = strtotime("2025-05-10 18:02:59");
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $time = round(abs($to_time - $from_time) / 60,2);
        if($time > 2){
            $this->requestToGetBetEndLess();
        }else{
            echo round(abs($to_time - $from_time) / 60). " minute";
            return true;
        }
    }

    public function breakLoop(){
        $this->rounStatus = 1;
        die("loop bredked".$this->rounStatus);
    }

    public function settlePendingBets(){
        $this->load->model('Common_model');
        $con = " WHERE status='P'";
        $feild = "DISTINCT round_id";
        $roundId = $this->Common_model->getData('crezyMatkaGame',$con,$feild,'','','','','');
        foreach($roundId as $r){
            $con1 = " WHERE round_id='".$r['round_id']."'";
            $result = $this->Common_model->getData('crezyMatkaResult',$con1,'','','','one','','');
            if($result['akda']!=10 && $result['akda']!=11){
                $d = json_encode(['round_id'=>$result['round_id'],'res'=>$result['akda']]);
                $wal = $this->updateWalletCrezyMatka($d); 
                // $wal = $this->updateWalletCrezyMatkaTest($d); 
            }else if($result['akda']==10){
                $wal = $this->updateWalletSpeenFlipCoinWin($result['round_id'],$result['bhav']);
                // $wal = $this->updateWalletSpeenFlipCoinWinTestUpdate($result['round_id'],$result['bhav']);
            }else{
                $wal = $this->updateWalletCrezyWin(1,$result['round_id'],$result['bhav']);
            }
        }
        die('wallet Updated!');
    }






    public function updateWalletSpeenFlipCoinWin($rId,$into){
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="10" AND status="P"','','','','','','');
        
        if($bets){
            $lC=0;
            $fbC=0;
            $oC=0;
            $comR = array();
            $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
            foreach($com as $c){
                $comR[$c['client_id']] = $c['commission'];
            }
            
            $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
            $cR = array();
            foreach ($cCR as $d){
                $cR[$d['id']] = $d['currancy_rate'];
            }
            
            foreach($bets as $b){
                $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$b['customer_id'].'" AND partner_id="'.$b['partner_id'].'"','rate','','','One','','');
            
                $bArr = array();
                $commission = $comR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                if($rOC){
                    $win = ((int)$b['point']*$into) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ((int)$commission / 100) * (int)$into*(int)$b['point'];
                    $bArr['winning_point']=((int)$into*(int)$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$b['exchange_rate'];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$b['exchange_rate'];
                $bArr['status']='W';
                $bArr['bhav']=(int)$into;
                $bArr['updated'] = date('Y-m-d H:i:s');
                $res = AddUpdateTable('crezyMatkaGame', 'transaction_id', $b['transaction_id'], $bArr);
                if(!$res){
                    $arr=[
                        'status'=>400,
                        'message'=>'Wallet Not Updated!'
                    ];
                    return json_encode($arr);
                }
            }
        }

        $con=" WHERE round_id='".$rId."' AND status='P'";
        $field['status']="L";
        $field['updated'] = date('Y-m-d H:i:s');
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'DISTINCT partner_id','','','','','');
        if($arrLoss){
            $multiUrl = [];
            $multiData = [];
            $multiI = 0;
            foreach($arrLoss as $l){
                $end = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
                $con="  WHERE round_id='".$rId."' AND partner_id='".$l['partner_id']."'";
                $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'bhav,transaction_id,customer_id,status,winning_point,commission,round_id,result_date,point,game','','','','','');
                if($arrLossBet){
                    $arrReq['code']='601';
                    $arrReq['rec']=json_encode($arrLossBet);
                    $arrReq['market']='Crazy Wheel';
                    $arrReq['market_code']='101';
                    $multiUrl[$multiI]=$end['end_point_url'];
                    $multiData[$multiI]=$arrReq;
                    $multiI++;
                }
            }

            $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'winning_point, customerName','','','','','');
            if(count($arrWinner)>0){
                $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
            }
            if($multiUrl){
                $req = requestForMultiClient($multiUrl,$multiData);
                $cR = json_decode($req);
                responseLog($multiUrl);
                responseLog('Request For Settlement'.$req);
                if($cR[0]->Code==200){
                    $arr=[
                        'status'=>200,
                        'message'=>'Wallet Updated Successfully!'
                    ];
                }else{
                    $arr=[
                        'status'=>400,
                        'message'=>'Client not responding!'
                    ];
                }
            }else{
                $arr=[
                    'status'=>200,
                    'message'=>'Nothing to update'
                ];
            }
        }else{
            $arr=[
                'status'=>200,
                'message'=>'Wallet Updated Successfully!'
            ];
        }
        return json_encode($arr);
        /*--------------------- Setel Market End --------------------------*/
    }

    public function getProb(){
        $weights = [
            0 => 9,
            1 => 9,
            2 => 9,
            3 => 9,
            4 => 9,
            5 => 9,
            6 => 9,
            7 => 9,
            8 => 9,
            9 => 9,
            10 => 3.5,
            11 => 3.5
        ];
        $totalWeight = array_sum($weights);
        $rand = mt_rand(1, $totalWeight);
        $cumulative = 0;
        foreach ($weights as $number => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $number;
                // return 10;
            }
        }
    }

    public function getProbCrazyWheel(){
        $weights = [
            "10" => 54.05,
            "25" => 24.33,
            "50" => 13.51,
            "100" => 5.41,
            "200" => 2.70,
        ];
        $totalWeight = array_sum($weights);
        $rand = mt_rand(1, $totalWeight);
        $cumulative = 0;
        foreach ($weights as $number => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $number;
            }
        }
    }
    public function updateWalletCrezyMatkaTest(){
        $data->round_id = "Cw993uBHB98UK3R1750521893";
        $data->res = "9";
        $this->updateWalletCrezyMatkaNew(json_encode($data));
    }
    public function updateWalletCrezyMatkaNew($j){
        $data = json_decode($j);
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$data->round_id.'" AND game="'.$data->res.'"','','','','','','');
        if($bets){
            $lC=0;
            $fbC=0;
            $oC=0;
            $comR = array();
            $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
            foreach($com as $c){
                $comR[$c['client_id']] = $c['commission'];
            }
            
            $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
            $cR = array();
            foreach ($cCR as $d){
                $cR[$d['id']] = $d['currancy_rate'];
            }
            
            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets[0]['customer_id'].'" AND partner_id="'.$bets[0]['partner_id'].'"','rate','','','One','','');
            
            $bhav = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
            $rT['bhav']=$bhav['bhav'];
            $rate = AddUpdateTable('crezyMatkaResult', 'round_id', $data->round_id, $rT);
            foreach($bets as $b){
                $bArr = array();
                $commission = $comR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                
                if($rOC){
                    $win = ($b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ($commission / 100) * $bhav['bhav']*$b['point'];
                    $bArr['winning_point']=($bhav['bhav']*$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$b['exchange_rate'];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$b['exchange_rate'];
                $bArr['status']='W';
                $bArr['bhav'] = $bhav['bhav'];
                $bArr['updated'] = date('Y-m-d H:i:s');
                $res = AddUpdateTable('crezyMatkaGame', 'transaction_id', $b['transaction_id'], $bArr);
                if(!$res){
                    $arr=[
                        'status'=>400,
                        'message'=>'Wallet Not Updated!'
                    ];
                    // echo json_encode($arr);
                    return json_encode($arr);
                }
            } 
        }
        $con=" WHERE round_id='".$data->round_id."' AND status='P'";
        $field['status']="L";
        $field['updated'] = date('Y-m-d H:i:s');
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."'",'DISTINCT partner_id','','','','','');
        if($arrLoss){
            $multiUrl = [];
            $multiData = [];
            $multiI = 0;
            foreach($arrLoss as $l){
                $la = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
                $con="  WHERE round_id='".$data->round_id."'";
                $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'bhav,transaction_id,customer_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Crazy Wheel';
                $arrReq['market_code']='101';
                // $arrReq['round_id']=$data->round_id;
                
                $multiUrl[$multiI]=$la['end_point_url'];
                $multiData[$multiI]=$arrReq;
                $multiI++;
                
                // responseLogTest("crazy matka end point =>".$la['end_point_url']); 
            }
            $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."'",'winning_point, customerName','','','','','');
            if(count($arrWinner)>0){
                $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
            }
            responseLog($multiData);
            $req = requestForMultiClient($multiUrl,$multiData);
            
            $cR = json_decode($req);
            responseLog($multiUrl);
            responseLog(json_encode($req));
            if($cR[0]->Code==200){
                $arr=[
                    'status'=>200,
                    'message'=>'Wallet Updated Successfully!'
                ];
            }else{
                $arr=[
                    'status'=>400,
                    'message'=>'Client not responding!'
                ];
            }
        }else{
            $arr=[
                'status'=>200,
                'message'=>'Wallet Updated Successfully!'
            ];
        }
        // echo json_encode($arr);
        return json_encode($arr);
        /*--------------------- Setel Market End --------------------------*/
    }

        public function checkProbability($roundId){
            $this->load->model('Common_model');
            $con = ' WHERE round_id="'.$roundId.'"';
            $result = $this->Common_model->getData('crezyMatkaGame',$con,'game,COUNT(DISTINCT customer_id) as customer,COUNT(id) as bets,SUM(point_in_rs) as point','','','','game ASC','game');
            $result1 = $this->Common_model->getData('crezyMatkaGame',$con,'game,COUNT(DISTINCT customer_id) as customer,COUNT(id) as bets,SUM(point_in_rs) as point,round_id','','','One','','');
            $r = $this->Common_model->getData('crezyMatkaBhav','','','','','One','','');
            $rate = $r['bhav'];
            $pArr = [];
            $pArrN = [];
            $s = [];
            $totalPoint = array_sum(array_column($result,'point'));
            foreach($result as $b){
                if($b['game']==10){
                    $b['redBlack'] = [];
                    for($i=2;$i<25;$i++){
                        $pArrN[$b['game'].'r'.$i] = ['profit'=>$totalPoint-($b['point']*$i),'customer'=>$b['customer']];
                    }
                }else if($b['game']==11){
                    $k = [10,25,50,100,200];
                    $b['crazyWheel'] = [];
                    foreach($k as $p){
                        $pArrN[$b['game'].'c'.$p] = ['profit'=>$totalPoint-($b['point']*$p),'customer'=>$b['customer']];
                    }
                }else{
                    $s['win'] = $b['point']*$rate;
                    $x = $totalPoint-$s['win'];
                    $pArrN[$b['game']] = ['profit'=>$x,'customer'=>$b['customer']];
                    
                }
                $b['prof'] = $totalPoint-$s['win'];
                array_push($pArr,$b);
            }
            return $res = $this->profitableR($pArrN,0.05,$totalPoint);
        }
    

    function profitableR($arr) {
        $bestKey = null;
        $bestProfit = 0;
        $bestCustomers = -1;
        foreach ($arr as $key => $data) {
            $profit = $data['profit'];
            $customers = $data['customer'];
            if ($profit <= 0) continue; // skip losses
            // Prioritize highest customer
            if ($customers > $bestCustomers) {
                $bestCustomers = $customers;
                $bestProfit = $profit;
                $bestKey = $key;
            } elseif ($customers === $bestCustomers) {
                // If same customers, choose the one with higher profit
                if ($profit > $bestProfit) {
                    $bestProfit = $profit;
                    $bestKey = $key;
                }
            }
        }
        return [
            'key' => $bestKey,
            'profit' => $bestProfit,
            'customer' => $bestCustomers
        ];
    }

    public function getProfitableResultOfRound(){
        $this->load->model('Common_model');
        $rId = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId','','','One','','');
        $roundId=$rId['roundId'];
        $p = $this->checkProbability($roundId);
        if($p['key']=='' && $p['customer']==-1){
            $r = $this->getProb();
            $notifyResult['newProb'] = '-';
        }else{
            if (strpos($p['key'], 'c') !== false) {
                $parts = explode('c', $p['key']);
                $notifyResult['newProb'] = $parts[1];
            } elseif (strpos($p['key'], 'r') !== false) {
                $parts = explode('r', $p['key']);
                $notifyResult['newProb'] = $parts[1];
            } else {
                $parts = [$p['key']]; // no split character found
                $notifyResult['newProb'] = '-';
            }
            $r = $parts[0];
            
        }
        $addUsr['round_id']=$roundId;
        $addUsr['result_date']=date('Y-m-d');
        $addUsr['status']='A';
        $addUsr['akda']=$r;
        if($r!=10 && $r!=11){
            $bhav = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
            $addUsr['bhav']=$bhav['bhav'];
        }
        // $addUsr['akda']=11; // for crezy matka
        // $addUsr['akda']=10; // for flip coin
        // $possibilities = $this->getPossibilities();
        $res = AddUpdateTable('crezyMatkaResult', '', '', $addUsr);
        if($res){
            $arr = [
                [1,5,23,27],
                [4,10,26,32],
                [17,21,39,43],
                [2,8,24,30],
                [7,16,29,38],
                [6,14,28,36],
                [9,18,31,40],
                [12,19,34,41],
                [15,20,37,42],
                [3,13,25,35],
                [11,33,11,33],
                [22,44,22,44],
            ];
            $t = rand(0,3);
            $notifyResult['market'] = 'speenZatkamatka';
            $notifyResult['akda'] = $arr[$r][$t];
            $notifyResult['res'] = $r;
            $notifyResult['round_id'] = $roundId;
            $j = json_encode($notifyResult);
            return $j;
        }else{
            $arr = [
                'status'=>400,
                'message'=>'Please Try Again.'
            ];
            return json_encode($arr);
        }
    }
}