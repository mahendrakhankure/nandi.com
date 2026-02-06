<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

require '/var/www/html/vendor/autoload.php';

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
	function __construct(){
	    parent::__construct();
	}

    public function indexOld(){
        $this->load->model('Common_model');
        $data['buf'] = $this->Common_model->getData('buffer',' WHERE id="1"','status','','','One','','');
        $data['res'] = $this->Common_model->getData('crezyMatkaResult','','akda','6','0','','id desc','');
        // echo '<pre>';
        // print_r($data['res']);
        // die();
        $data['rate'] = $this->Common_model->getData('crezyMatkaBhav',' WHERE id="1"','bhav','','','One','','');
        if (date('a', time())=='pm') {
            if($_GET['token']=='25da54332a349da64992c22f905000e7'){
                $con6=' WHERE customer_id="'.$_GET['id'].'"';
                $user = $this->Common_model->getData('customer',$con6,'id,customer_id','6','0','One','id desc','');
                if(empty($user)){
                    $url='https://laxmi999.com/index.php/psapi/get-user-detail?id='.$_GET['id'];
                    $dt=getUserDetail($url);
                    $res = json_decode($dt);
                    if($res->Code==200){
                        $d=$res->data;
                        $addUsr['partner_id']=2;
                        $addUsr['customer_id']=$_GET['id'];
                        $addUsr['name']=$d->name;
                        $addUsr['mobile']=$d->mobile;
                        $addUsr['state']=$d->state;
                        $addUsr['city']=$d->city;
                        $addUsr['email']=$d->email;
                        $addUsr['signup_date']=$d->signup_date;
                        $addUsr['app']=$d->app;
                        $addUsr['status']='A';
                        $addUsr['created']=date('Y-m-d');
                        AddUpdateTable('customer', '', '', $addUsr);
                    }
                }
            }
        }
		// $this->load->view('user/crezyMatka',$data);
        $this->load->view('user/crezyHtml-old',$data);
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
        if($_GET['token']=='25da54332a349da64992c22f905000e7'){
            $con6=' WHERE customer_id="'.$_GET['id'].'"';
            $user = $this->Common_model->getData('customer',$con6,'id,customer_id','6','0','One','id desc','');
            if(empty($user)){
                $url='https://laxmi999.com/index.php/psapi/get-user-detail?id='.$_GET['id'];
                $dt=getUserDetail($url);
                $res = json_decode($dt);
                if($res->Code==200){
                    $d=$res->data;
                    $addUsr['partner_id']=2;
                    $addUsr['customer_id']=$_GET['id'];
                    $addUsr['name']=$d->name;
                    $addUsr['mobile']=$d->mobile;
                    $addUsr['state']=$d->state;
                    $addUsr['city']=$d->city;
                    $addUsr['email']=$d->email;
                    $addUsr['signup_date']=$d->signup_date;
                    $addUsr['app']=$d->app;
                    $addUsr['status']='A';
                    $addUsr['created']=date('Y-m-d');
                    AddUpdateTable('customer', '', '', $addUsr);
                }
            }
        }
		// $this->load->view('user/crezyMatka',$data);
        $this->load->view('user/maintenance');
        // $this->load->view('user/crezyHtml',$data);
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

    public function PlaceBetsOld(){
        
		$inp = file_get_contents('php://input');
        $req = json_decode($inp);
        
		if(isset($req->customer_id) && isset($req->games) && isset($req->tokenId) && isset($req->totalAmount)){
            $date = date('Y-m-d'); 
            $this->load->model('Common_model');
            if(!empty($req->games)){
                $client = $this->Common_model->getData('client',' WHERE client_token="'.$req->tokenId.'"','end_point_url,id,currancy_rate','','','One','','');
                $data=requestForClient($client['end_point_url'],['id'=>$req->customer_id,'code'=>'300']);
                
                $res = json_decode($data);
                if($res->Code==200 && $res->data[0] >= $req->totalAmount){
                    $_SESSION['balance']=$res->data[0];
                	$cArr['arr']=[];
                    $myBet=[];
                    $rId = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId','','','One','','');
                    $roundId=$rId['roundId'];
                    foreach ($req->games as $arr) {
                        if($arr->coin > 0 && $_SESSION['balance'] >= $arr->coin){
                            $betArr=[];
                            $betArr['transaction_id'] = transactionID(32,32);
                            $betArr['round_id'] = $roundId;
                            $betArr['result_date'] = $date;
                            $betArr['point'] = (int)$arr->coin;
                            $betArr['game'] = $arr->akda;
                            $betArr['partner_id'] = (int)$client['id'];
                            $betArr['customer_id'] = $req->customer_id;
                            $betArr['status'] = 'P';
                            $betArr['point_in_rs'] = $betArr['point']*$client['currancy_rate'];
                            array_push($myBet,$betArr);
                            
                            $_SESSION['balance']=$_SESSION['balance']-$arr->coin;
                            
                            unset($betArr['partner_id']);
                            unset($betArr['point_in_rs']);
                            array_push($cArr['arr'],$betArr);
                        }
                    }
                    
                    $cArr['arr'] = json_encode($cArr['arr']);
                    $cArr['code']='101';
                    $cArr['id']=$req->customer_id;
                    // {
                    //     "arr": "[{\"transaction_id\":\"H273bBMcG02T2tzGaXcY8v3D5vTUlQDy\",\"round_id\":\"sZCC560ekXAxz5vDgXTpY0is7tpaZgYp\",\"result_date\":\"2024-09-02\",\"point\":5,\"game\":\"00\",\"customer_id\":\"e25f293ebc411412b277fdc4569976bd\",\"status\":\"P\"}]",
                    //     "code": "101",
                    //     "id": "e25f293ebc411412b277fdc4569976bd"
                    // }
                    // die(json_encode($cArr));
                    $reqJ = requestForClient($client['end_point_url'],$cArr);
                    
                    $jReq = json_decode($reqJ);
                    
                    if($jReq->Code==200){
                        
                        $add = newAddUpdateTable('crezyMatkaGame','','',$myBet);
                        
                        $r = rand(0,10);
                        $addUsr['round_id']=$roundId;
                        $addUsr['result_date']=date('Y-m-d');
                        $addUsr['status']='A';
                        $addUsr['akda']=$r;
                        $res = AddUpdateTable('crezyMatkaResult', '', '', $addUsr);
                        if($res && $add){
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
                            // $arr = [
                            //     [1,5],
                            //     [4,10],
                            //     [17,21],
                            //     [2,8],
                            //     [7,16],
                            //     [6,14],
                            //     [9,18],
                            //     [12,19],
                            //     [15,20],
                            //     [3,13],
                            //     [22,22],
                            //     [11,11],
                            // ];
                            $t = rand(0,1);
                            $notifyResult['market'] = 'speenZatkamatka';
                            // $notifyResult['customer_id'] = $req->customer_id;
                            $notifyResult['tokenId'] = $req->tokenId;
                            $notifyResult['akda'] = $arr[$r][$t];
                            // $notifyResult['akda'] = 11;
                            $notifyResult['round_id'] = $roundId;
                            // $notifyResult['js'] = $cArr;
                            $notifyResult['bal'] = $_SESSION['balance'];
                            // $notifyResult['res'] = 11;
                            $notifyResult['partner_id'] = $client['id'];
                            $notifyResult['res'] = $r;
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
                            if($notifyResult['res']!=10 && $notifyResult['res']!=11){
                                $this->updateWalletCrezyMatka($j); 
                            }
                            $array = [
                                "balance"=>$_SESSION['balance'],
                                "message"=>"Bet Placed Successfully!",
                                "code"=>200,
                            ];
                        }else{
                            $arr = [
                                'status'=>400,
                                'message'=>'Please Try Again.'
                            ];
                            die(json_encode($arr));
                        }
                    }else{
                        $array = [
                            "message"=>"Please Try again.",
                            "code"=>203,
                        ];
                        $cancel['status'] = 'C';
                        $res = AddUpdateTable('crezyMatkaGame', 'round_id', $roundId, $cancel);
                    }
                } else {
                    $array = [
                        "message"=>"You Dont Have Sufficient Balance.",
                        "code"=>203,
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
            $t = rand(1,38);
            $notifyResult['market'] = 'crezyMatka';
            // $notifyResult['akda'] = 1;
            $notifyResult['akda'] = $t;
            // $notifyResult['bal'] = $_SESSION['balance'];

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
            
            die(json_encode($array));
            // die('working');
        } else {
            die(json_encode(["message"=>"Please Provide Valid data","code"=>401]));
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
            foreach($bets as $b){
                $bArr = array();
                $commission = $cCR[$b['partner_id']]; 
                if(!$commission){
                    $commission = 2;
                }
                if($rOC){
                    $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                    $bArr['commission'] = ($commission / 100) * $win;
                    $bArr['winning_point'] = $win - $bArr['commission'];
                }else{
                    $bArr['commission'] = ((int)$commission / 100) * (int)$bhav['bhav']*(int)$b['point'];
                    $bArr['winning_point']=((int)$bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                }
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                $bArr['status']='W';
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
        $con=" WHERE round_id='".$data->round_id."' AND status='P'";
        $field['status']="L";
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."'",'DISTINCT partner_id','','','','','');
        responseLog(json_encode($arrLoss));
        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        // echo '<pre>';
        // print_r($l);
        foreach($arrLoss as $l){
            $la = $this->Common_model->getData('client',' WHERE id="'.$l['partner_id'].'"','end_point_url','','','One','','');
            $con="  WHERE round_id='".$data->round_id."'";
            $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'transaction_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Crezy Matka';
            $arrReq['market_code']='101';
            $arrReq['round_id']=$data->round_id;
            
            $multiUrl[$multiI]=$la['end_point_url'];
            $multiData[$multiI]=$arrReq;
            $multiI++;
        }
        $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data->round_id."' AND status='W'",'winning_point, customerName','','','','','');
        if(count($arrWinner)>0){
            $reqWin = requestForCrezyMatka('https://node.dpbosses.live/winnerList',json_encode($arrWinner));
        }
        // print_r($multiUrl);
        // print_r($multiData);
        $req = requestForMultiClient($multiUrl,$multiData);
        // $req = requestForClient($l['end_point_url'],$arrReq);
        $cR = json_decode($req);
        responseLog($req);
        responseLog($la['end_point_url']);
        responseLog($multiData);
        // die(json_encode($req));
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
        
        return json_encode($arr);
        /*--------------------- Setel Market End --------------------------*/
    }
    
    public function updateWalletCrezyWin($t,$rId,$into){
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
            
            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets[0]['customer_id'].'" AND partner_id="'.$bets[0]['partner_id'].'"','rate','','','One','','');
            foreach($bets as $b){
                $bArr = array();
                $commission = $cCR[$b['partner_id']]; 
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
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                $bArr['status']='W';
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
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        // return json_encode($updateresultLose);
        // die();
        /*--------------------- Setel Market Start --------------------------*/
        $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."'",'','','','','','');
        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        // $l = $this->Common_model->getData('client',' WHERE id="'.$bets[0]['partner_id'].'"','end_point_url','','','One','','');
        foreach($arrLoss as $l){
            $con="  WHERE round_id='".$rId."'";
            $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'transaction_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Crezy Matka';
            $arrReq['market_code']='101';
            $multiUrl[$multiI]=$l['end_point_url'];
            $multiData[$multiI]=$arrReq;
            $multiI++;
        }
        $arrWinner = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$rId."' AND status='W'",'winning_point, customerName','','','','','');
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
            $bArr['userCoin']=$req->coinS;
            
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

    public function updateFlipCoinWin($type,$rId,$into){
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="11" AND status="P"','','','','','','');
        if($bets && $type=="Win"){
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
                $commission = $cCR[$b['partner_id']]; 
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
                $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                $bArr['status']='W';
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
        $updateresultLose = updateAllLose('crezyMatkaGame', $con, $field);
        // return json_encode($updateresultLose);
        // die();
        /*--------------------- Setel Market Start --------------------------*/
        // $arrLoss = $this->Common_model->getData('crezyMatkaGame'," WHERE round_id='".$data['id']."'",'','','','','','');
        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        $l = $this->Common_model->getData('client',' WHERE id="'.$bets[0]['partner_id'].'"','end_point_url','','','One','','');
        // foreach($arrLoss as $l){
            $con="  WHERE round_id='".$rId."'";
            $arrLossBet = $this->Common_model->getData('crezyMatkaGame',$con,'transaction_id,status,winning_point,commission,customer_id,round_id,result_date,point,game','','','','','');
            $arrReq['code']='601';
            $arrReq['rec']=json_encode($arrLossBet);
            $arrReq['market']='Crezy Matka';
            $arrReq['market_code']='101';
            $multiUrl[$multiI]=$l['end_point_url'];
            $multiData[$multiI]=$arrReq;
            $multiI++;
        // }
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
        return json_encode($req);
        /*--------------------- Setel Market End --------------------------*/
    }

    public function requestToGetBet(){
        $new = $this->setRound();
        $data=requestForCrezyMatka('https://node.dpbosses.live/getBets',json_encode([]));
        $d = $this->getResultOfRound();
        $data = json_decode($d);
        $res=requestForCrezyMatka('https://node.dpbosses.live/startRound',$d);
        sleep(10);
        if($data->res!=10 && $data->res!=11){
            $this->updateWalletCrezyMatka($d); 
        }else{
            sleep(3);
            $this->crezyWinNew($data->round_id);
        }
        die($res);
    }

    public function PlaceBets(){
		$inp = file_get_contents('php://input');
        $req = json_decode($inp);
		if(isset($req->customer_id) && isset($req->games) && isset($req->tokenId) && isset($req->totalAmount)){
            $date = date('Y-m-d'); 
            $this->load->model('Common_model');
            if(!empty($req->games)){
                $client = $this->Common_model->getData('client',' WHERE client_token="'.$req->tokenId.'"','end_point_url,id,currancy_rate','','','One','','');
                $data=requestForClient($client['end_point_url'],['id'=>$req->customer_id,'code'=>'300']);
                $res = json_decode($data);
                if($res->Code==200 && $res->data[0] >= $req->totalAmount){
                    $_SESSION['balance']=$res->data[0];
                	$cArr['arr']=[];
                    $myBet=[];
                    $rId = $this->Common_model->getData('crezyMatkaRound',' WHERE id="1"','roundId','','','One','','');
                    $roundId=$rId['roundId'];
                    foreach ($req->games as $arr) {
                        if($arr->coin > 0 && $_SESSION['balance'] >= $arr->coin){
                            $betArr=[];
                            $betArr['transaction_id'] = transactionID(32,32);
                            $betArr['round_id'] = $roundId;
                            $betArr['result_date'] = $date;
                            $betArr['point'] = (int)$arr->coin;
                            $betArr['game'] = $arr->akda;
                            $betArr['partner_id'] = (int)$client['id'];
                            $betArr['customer_id'] = $req->customer_id;
                            $betArr['status'] = 'P';
                            $betArr['point_in_rs'] = $betArr['point']*$client['currancy_rate'];
                            array_push($myBet,$betArr);
                            
                            $_SESSION['balance']=$_SESSION['balance']-$arr->coin;
                            
                            unset($betArr['partner_id']);
                            unset($betArr['point_in_rs']);
                            array_push($cArr['arr'],$betArr);
                        }
                    }
                    
                    $cArr['arr'] = json_encode($cArr['arr']);
                    $cArr['code']='101';
                    $cArr['id']=$req->customer_id;
                    $reqJ = requestForClient($client['end_point_url'],$cArr);
                    
                    $jReq = json_decode($reqJ);
                    
                    if($jReq->Code==200){
                        
                        $add = newAddUpdateTable('crezyMatkaGame','','',$myBet);
                        $arr = [
                            'status'=>200,
                            'message'=>'Bet Accepted.'
                        ];
                        die(json_encode($arr));
                    }else{
                        $array = [
                            "message"=>"Please Try again.",
                            "code"=>203,
                        ];
                        $cancel['status'] = 'C';
                        $res = AddUpdateTable('crezyMatkaGame', 'round_id', $roundId, $cancel);
                    }
                } else {
                    $array = [
                        "message"=>"You Dont Have Sufficient Balance.",
                        "code"=>203,
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
        $r = rand(0,10);
        $addUsr['round_id']=$roundId;
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
            // $arr = [
            //     [1,5],
            //     [4,10],
            //     [17,21],
            //     [2,8],
            //     [7,16],
            //     [6,14],
            //     [9,18],
            //     [12,19],
            //     [15,20],
            //     [3,13],
            //     [22,22],
            //     [11,11],
            // ];
            $t = rand(0,1);
            $notifyResult['market'] = 'speenZatkamatka';
            $notifyResult['akda'] = $arr[$r][$t];
            // $notifyResult['akda'] = 21;
            $notifyResult['round_id'] = $roundId;
            // $notifyResult['js'] = $cArr;
            // $notifyResult['res'] = 10;
            $notifyResult['res'] = $r;
            $j = json_encode($notifyResult);
            return $j;
            // die($j);
            // ob_start();
            // echo $j;
            // $size = ob_get_length();
            // header("Content-Encoding: none");
            // header("Content-Length: {$size}");
            // header("Connection: close");
            // ob_end_flush();
            // ob_flush();
            // flush();
            // if($notifyResult['res']!=10 && $notifyResult['res']!=11){
            //     $this->updateWalletCrezyMatka($j); 
            // }
            // $array = [
            //     "message"=>"Bet Placed Successfully!",
            //     "status"=>200,
            // ];
        }else{
            $arr = [
                'status'=>400,
                'message'=>'Please Try Again.'
            ];
            return json_encode($arr);
        }
    }

    public function setRound(){
        $addUsr['roundId']=transactionID(32,32);
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
}