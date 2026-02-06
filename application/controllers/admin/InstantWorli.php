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

class InstantWorli extends BaseController{



	function __construct(){
	    parent::__construct();
        if(isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])){
            $_GET['id'] = str_replace(" ","+",$_GET['id']);
            $this->load->model('Common_model');
            $con=' WHERE status="A" AND client_token="'.$_GET['token'].'"';
            $partner = $this->Common_model->getData('client',$con,'id,end_point_url','','','One','','');
            if(!empty($partner)){
                $_SESSION['end_point_url']=$partner['end_point_url'];
                $data=requestForClient($partner['end_point_url'],['id'=>$_GET['id'],'code'=>'300']);
                $res = json_decode($data);
                if($res->Code==200){
                    $_SESSION['token']=$_GET['token'];
                    $_SESSION['app']=$_GET['app'];
                    $_SESSION['partner']=$partner;
                    $_SESSION['balance']=$res->data[0];
                    $_SESSION['userName']=$res->data[1];
                    $_SESSION['customer_id']=$_GET['id'];
                }
            }
        }
	    // if(! $this->session->userdata('adid'))

	    // redirect('login');

	}

	 
	public function index(){
        $this->load->model('Common_model');
        $data['buf'] = $this->Common_model->getData('buffer',' WHERE id="1"','status','','','One','','');
        if (date('a', time())=='pm') {
        if($_GET['token']=='25da54332a349da64992c22f905000e7'){
            $con6=' WHERE customer_id="'.$_GET['id'].'"';
            $user = $this->Common_model->getData('customer',$con6,'id,customer_id','','','One','','');
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
            $data['url'] = "https://buyphotography.online/?nocache";
        }
        if($_GET['token']=='146c45564e4bd0673706cfa9a2ab2ebf' && $_GET['id']=='aFr4FgOW1Kd6eNgX367NFQ=='){
            $this->load->view('user/instantWorli',$data);
        }else{
            $this->load->view('user/maintenance');
        }
	}


	public function instantWorliStrimingApi(){

	}


	public function PlaceBets(){
		
		if(isset($_POST['game_name']) && isset($_POST['games']) && isset($_POST['roundId']) && isset($_POST['totalAmount'])){
            $date = date('Y-m-d'); 
            $this->load->model('Common_model');
            if(!empty($_POST['games'])){
                
                $client = $this->Common_model->getData('client',' WHERE client_token="'.$_POST['tokenId'].'"','end_point_url,id,currancy_rate','','','One','','');
                $data=requestForClient($client['end_point_url'],['id'=>$_POST['customer_id'],'code'=>'300']);
                // die(json_encode([
                //     "message"=>"You Dont Have Sufficient Balance new massage.",
                //     "code"=>203,
                //     "data"=>$data,
                //     "req"=>$_POST,
                //     "client"=>$client
                // ]));
                $res = json_decode($data);
                
                // $data=requestForClient($_SESSION['end_point_url'],['id'=>$_SESSION['customer_id'],'code'=>'300']);
                // $res = json_decode($data);
                // if($_SESSION['balance'] >= $_POST['totalAmount']){
                if($res->Code==200 && $res->data[0] >= $_POST['totalAmount']){
                    $_SESSION['balance']=$res->data[0];
                	$cArr['arr']=[];
                	$rId = $this->Common_model->getData('worli_timer',' WHERE id="1"','roundId,cTime','','','One','','');
                    if($rId['cTime']>date('Y-m-d H:i:s',strtotime('-1 minutes'))){
                    	foreach ($_POST['games'] as $arr) {
                            if($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']){
                                if($_POST['gameId']=='4' && $arr['coin'] < 10){
                                    continue;
                                }else if($arr['coin'] < 5){
                                    continue;
                                }
                                $betArr=[];
                                $betArr['transaction_id'] = transactionID(16,16);
                                $betArr['game_name'] = $_POST['gameId'];
                                $betArr['round_id'] = $_POST['roundId'];
                              
                                $betArr['result_date'] = $date;
                                $betArr['point'] = (int)$arr['coin'];
                                $betArr['game'] = $arr['akda'];
                                $betArr['partner_id'] = (int)$client['id'];
                                $betArr['customer_id'] = $_POST['customer_id'];
                                $betArr['status'] = 'P';
                                $betArr['created'] = date('Y-m-d H:i:s');
                                $betArr['point_in_rs'] = $betArr['point']*$client['currancy_rate'];
                                $add = AddUpdateTable('warli_users_game','','',$betArr);
                                $_SESSION['balance']=$_SESSION['balance']-$arr['coin'];

                                $betArr['gameId'] = $_POST['gameId'];
                                $betArr['game_name'] = $_POST['game_name'];

                                // $notifyResult['point']=$betArr['point_in_rs'];
                                $notifyResult['point']=$betArr['point'];
                                
                                unset($betArr['partner_id']);
                                unset($betArr['point_in_rs']);
                                array_push($cArr['arr'],$betArr);

                                $notifyResult['market']='WorliRoundStetment';
                                $notifyResult['game']=$betArr['game'];
                                
                                $notifyResult['userName']=$_SESSION['userName'];
                                $notifyResult['customer_id'] = $_POST['customer_id'];
                                notifyUserWithResult(json_encode($notifyResult));
                            }
                        }
                        $cArr['arr'] = json_encode($cArr['arr']);
                        $cArr['code']='701';
                        $cArr['id']=$_POST['customer_id'];
                        
                        $req = requestForClient($client['end_point_url'],$cArr);
                        $jReq = json_decode($req);
            			$_SESSION['balance']=$jReq->data;
                        $array = [
                                "balance"=>$_SESSION['balance'],
                                "message"=>"Bet Placed Successfully!",
                                "code"=>200,
                        ];
                    }else{
                        die(json_encode(["message"=>"Wait For Five Secound!","code"=>202]));
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



    // public function checkStrimStatus(){
    //     $this->load->model('Common_model');
    //     $bName = $this->Common_model->getData('worli_timer',' WHERE status="A"','','','','One','','');
    //     if($bName['round']=='1' && $bName['time']>0){
    //         $res['time']=$bName['time']-1;
    //         AddUpdateTable('worli_timer','id','1',$res);
    //         $bName['time']=$res['time'];
    //     }
    //     if(isset($_POST['url']) && $_POST['customer_id']){
    //         $data=requestForClient($_POST['url'],['id'=>$_POST['customer_id'],'code'=>'300']);
    //         $res = json_decode($data);
    //         if($res->Code==200){
    //             $_SESSION['balance']=$res->data[0];
    //             $bName['balance']=$res->data[0];
    //         }
    //     }
    //     die(json_encode($bName));
    // }

    public function resultInstantWorli(){
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        $tArr['time']=$data->BetTime;
        $tArr['round']='0';
        $res1=AddUpdateTable('worli_timer','id','1',$tArr);
        if($data->GameState=='Between Game'){
            $this->load->model('Common_model');
            $buf = $this->Common_model->getData('buffer',' WHERE status="1" AND id="1"','','','','One','','');
            
            if($buf){
                $ak=(string)$data->CardScore;
                $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

                if($akda>9){
                    $a=(string)$akda;
                    $akda=$a[1];
                }
                $patti = $data->CardScore;
                $betArr['result_date'] = date('Y-m-d');
                $betArr['tableId'] = $data->TableID;
                $betArr['gameId'] = $data->GameId;
                $betArr['patti_result'] = $ak;
                $betArr['akda_result'] = $akda;
                $betArr['status'] = 'A';

                $res=AddUpdateTable('warli_result','','',$betArr);
                
                /*---------------- For Responce And Process Start ----------------*/
                if($res){
                    $arr=['status'=>200,'massage'=>'Betting Start Now.'];
                }else{
                    $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
                }
                ob_start();
                echo json_encode($arr);
                $size = ob_get_length();
                header("Content-Encoding: none");
                header("Content-Length: {$size}");
                header("Connection: close");
                ob_end_flush();
                ob_flush();
                flush();
                $notifyResult['market']='Worli';
                $notifyResult['patti']=$ak;
                $notifyResult['akda']=$akda;
                $notifyResult['rResult']=$data->Result;
                $notifyResult['url']='4ad7b357b4a728f18d6e27dea29a071e';
                notifyUserWithResult(json_encode($notifyResult));
                /*---------------- For Responce And Process End ----------------*/
                
                $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$data->GameId.'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
                
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
                
                $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');
                                    
                foreach ($bets as $b) {
                    if($b['partner_id']=='2'){
                        $commission=$lC;
                    }else if($b['partner_id']=='4'){
                        $commission=$fbC;
                    }else{
                        $commission=$oC;
                    }
                    if($b['game_name']=='4'){
                        if($b['game']==$akda){
                            $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                            if($rOC){
                                $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                                $bArr['commission'] = ($commission / 100) * $win;
                                $bArr['winning_point'] = $win - $addRes['commission'];
                            }else{
                                $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                                $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                            }
                            $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                            $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];

                            $bArr['status']='W';
                        }else{
                            $bArr['commission']=0;
                            $bArr['winning_point']=0;
                            $bArr['status']='L';
                            $bArr['winning_in_rs']=0;
                            $bArr['commission_in_rs']=0;
                        }
                    }else{
                        if($b['game']==$patti){
                            $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                            if($rOC){
                                $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                                $bArr['commission'] = ($commission / 100) * $win;
                                $bArr['winning_point'] = $win - $addRes['commission'];
                            }else{
                                $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                                $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                            }
                            $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                            $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                            $bArr['status']='W';
                        }else{
                            $bArr['commission']=0;
                            $bArr['winning_point']=0;
                            $bArr['status']='L';
                            $bArr['winning_in_rs']=0;
                            $bArr['commission_in_rs']=0;
                        }
                    }
                    
                    $res1=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);
                       
                }
                $notifyMeW['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$data->GameId.'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
                $notifyResult['resultStatus']=$notifyMeW['userList'];
                notifyUserWithResult(json_encode($notifyResult));
                $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
                $multiUrl = [];
                $multiData = [];
                $multiI = 0;
                foreach($arrLoss as $l){
                    $con=" WHERE partner_id='".$l['id']."' AND round_id='".$data->GameId."'";
                    if($l['id']=='2'){
                        $con.=' AND status="W"';
                        $arrReq['dataRes']=$data->GameId;
                    }
                    $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$data->GameId.'"','transaction_id,status,winning_point,commission,customer_id','','','','','');
                    
                    $arrReq['code']='601';
                    $arrReq['rec']=json_encode($arrLossBet);
                    $arrReq['market']='Instant Worli';
                    $arrReq['market_code']='701';
                    $arrReq['bazar_name']='Instant Worli';
                    // $req = requestForClient($l['end_point_url'],$arrReq);
                   
                    $multiUrl[$multiI]=$l['end_point_url'];
                    $multiData[$multiI]=$arrReq;
                    $multiI++;
                }
                $req = requestForMultiClient($multiUrl,$multiData);

                if($res&&$res1){
                    $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
                }else{
                    $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
                }


                $notifyMeL['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$data->GameId.'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
                
                requestForBalance(json_encode($notifyMeW));
                
                requestForBalance(json_encode($notifyMeL));
            }else{
                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
            }
            die(json_encode($arr));
        }else if($data->GameState=="Bet Timer"&&!$data->spot1&&!$data->spot2&&!$data->spot3){
            // $tArr['time']=$data->BetTime;
            $tArr['round']='1';
            $tArr['roundId']=$data->GameId;
            // $tArr['cTime']=date('Y-m-d H:i:s', strtotime("-10 sec"));
            $tArr['cTime']=date('Y-m-d H:i:s');
            // $tArr['time']='120';
            $tArr['time']='60';
            $res=AddUpdateTable('worli_timer','id','1',$tArr);
            // $ted=AddUpdateTable('goldenTable_timer','id','1',$tArr);
            if($res){
                $arr=['status'=>200,'massage'=>'Betting Start Now.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
            }
            ob_start();
            echo json_encode($arr);
            $size = ob_get_length();
            header("Content-Encoding: none");
            header("Content-Length: {$size}");
            header("Connection: close");
            ob_end_flush();
            ob_flush();
            flush();
            // $ted=AddUpdateTable('redTable_timer','id','1',$tArr);
            $notifyResult['market']='WorliNewRound';
            $notifyResult['roundId']=$data->GameId;
            notifyUserWithResult(json_encode($notifyResult));
            if($res){
                $arr=['status'=>200,'massage'=>'Betting Start Now.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
            }
            die(json_encode($arr));
        }
    }


    public function worliSetalment(){
        if($_POST){
            $this->load->model('Common_model');
            $result = $this->Common_model->getData('warli_result',' WHERE gameId="'.$_POST['id'].'"','id,patti_result,akda_result','','','One','','');

            if(empty($result)){
                $req = setalmentWorli($_POST['id']);
                if(empty($req)){
                    $arr=['status'=>201,'massage'=>'Result Not Available.'];
                    die(json_encode($arr));
                }
                $data = json_decode($req);
                $ak=(string)$data->gameScore;
                $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];
                $patti=$data->gameScore;
                if($akda>9){
                    $a=(string)$akda;
                    $akda=$a[1];
                }
                $wArr['akda_result']=$akda;
                $wArr['patti_result']=$patti;
                $wArr['result_date']=date('Y-m-d');
                $wArr['gameId']=$_POST['id'];
                $wArr['created']=date('Y-m-d');
                $wArr['tableId']='Matka-1';
                $wArr['status']='A';
                $res=AddUpdateTable('warli_result','','',$wArr); 
            }else{
                $patti=$result['patti_result'];
                $akda=$result['akda_result'];
            }
             
            $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$_POST['id'].'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
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

            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');              
            foreach ($bets as $b) {
                if($b['partner_id']=='2'){
                    $commission=$lC;
                }else if($b['partner_id']=='4'){
                    $commission=$fbC;
                }else{
                    $commission=$oC;
                }
                if($b['game_name']=='4'){
                    if($b['game']==$akda){
                        $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                        if($rOC){
                            $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                            $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                        }
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                        $bArr['status']='W';
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                        
                    }
                }else{
                    if($b['game']==$patti){
                        $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                        if($rOC){
                            $win = ((int)$b['point']*$bhav['bhav']) * ((100-$rOC['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                            $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                        }
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                        $bArr['status']='W';
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                    }
                }
                $res=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);   
            }
                
            $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
            
            foreach($arrLoss as $l){
                $con=" WHERE partner_id='".$l['id']."' AND round_id='".$_POST['id']."'";
                if($l['id']=='2'){
                    $con.=' AND status="W"';
                    $arrReq['dataRes']=$_POST['id'];
                }
                
                $arrLossBet = $this->Common_model->getData('warli_users_game',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
                // $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$_POST['id'].'"','transaction_id,status,winning_point,commission','','','','','');
                
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Instant Worli';
                $arrReq['market_code']='701';
                $arrReq['bazar_name']='Instant Worli';
                $req = requestForClient($l['end_point_url'],$arrReq);
            }
            if($res || $result){
                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
            }
            $CI = &get_instance();
            $sth = $CI->db->query(
                "UPDATE warli_users_game SET status='L', winning_point='0', commission='0' WHERE round_id = ? AND status = 'P'",
                [$_POST['id']]
            );

            // $notifyMeW['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['id'].'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
            // $notifyMeL['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="'.$_POST['id'].'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
            // $notifyResult['resultStatus']=$notifyMeW['userList'];
            // notifyUserWithResult(json_encode($notifyResult));
            // requestForBalance(json_encode($notifyMeW));
            // requestForBalance(json_encode($notifyMeL));
            die(json_encode($arr));
        }
        $this->load->view('admin/worliSetalment');
    }
    public function resultInstantWorliBk(){
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        
        if(isset($data->spot1)&&isset($data->spot2)&&isset($data->spot3)){
            
            $ak=(string)$data->CardScore;
            $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

            if($akda>9){
                $a=(string)$akda;
                $akda=$a[1];
            }
            $patti = $data->CardScore;
            $betArr['result_date'] = date('Y-m-d');
            $betArr['tableId'] = $data->TableID;
            $betArr['gameId'] = $data->GameId;
            $betArr['patti_result'] = $ak;
            $betArr['akda_result'] = $akda;
            $betArr['status'] = 'A';
            // echo '<pre>';
            // print_r($betArr);
            // die();
            $res=AddUpdateTable('warli_result','','',$betArr);
            if($data->BetTime){
                $tArr['time']=$data->BetTime;
                $tArr['round']='0';
                $res1=AddUpdateTable('worli_timer','id','2',$tArr);
            }
            

            $this->load->model('Common_model');
            $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$data->GameId.'"','transaction_id,game,game_name,point,customer_id','','','','','');
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

            foreach ($bets as $b) {
                if($b['partner_id']=='2'){
                    $commission=$lC;
                }else if($b['partner_id']=='4'){
                    $commission=$fbC;
                }else{
                    $commission=$oC;
                }
                if($b['game_name']=='4'){
                    if($b['game']==$akda){
                        $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                        $bArr['status']='W';
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                    }
                }else{
                    if($b['game']==$patti){
                        $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
                        $bArr['commission'] = ($commission / 100) * $bhav['bhav']*(int)$b['point'];
                        $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
                        $bArr['status']='W';
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                    }
                }
                
                $res1=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);         
            }
                

            $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');

            foreach($arrLoss as $l){
                $con=" WHERE partner_id='".$l['id']."' AND round_id='".$data->GameId."'";
                $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$data->GameId.'"','transaction_id,status,winning_point,commission','','','','','');
                if($arrLossBet){
                    $arrReq['code']='601';
                    $arrReq['rec']=json_encode($arrLossBet);
                    $arrReq['market']='Instant Worli';
                    $req = requestForClient($l['end_point_url'],$arrReq);
                }
               
            }

            if($res){
                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
            }

            die(json_encode($arr));
        }else if($data->GameState=="Bet Timer"&&!$data->spot1&&!$data->spot2&&!$data->spot3){
            // echo 'working';die();
            $tArr['time']=$data->BetTime;
            $tArr['round']='1';
            $tArr['roundId']=$data->GameId;
            $tArr['cTime']=date('Y-m-d H:i:s');
            $res=AddUpdateTable('worli_timer','id','2',$tArr);
            if($res){
                $arr=['status'=>200,'massage'=>'Betting Start Now.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
            }
            die(json_encode($arr));
        }
    }

    public function worliHistory($id){
        // echo 'working';die();
        $cid = $_GET['id'];
        $this->load->model('Common_model');
        $con=' WHERE partner_id="'.$id.'" AND customer_id="'.$cid.'" AND result_date="'.date('Y-m-d').'"';
        $feilds = 'round_id,game_name,point,game,status,winning_point,created';
        $data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','','id DESC','');
        $this->load->view('user/worliHistory',$data);
    }

    public function lastWorliResults($table){
        $this->load->model('Common_model');
        $feilds = 'gameId, patti_result, akda_result';
        $data['worli'] = $this->Common_model->getData($table,'', $feilds,'15','0','','id DESC','');
         
        $this->load->view('user/lastWorliResults',$data);
    }
    public function testMCript($id){
        $mcrypt = new MCrypt();
        $amount = $mcrypt->encrypt($id);
        echo $amount.'<br>';
        $newAmount = $mcrypt->decrypt($id);
        echo $newAmount;
        die();
    }

    public function testsoket(){
        if($_POST){
            $time = 'working';
        }else{
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            $this->load->model('Common_model');
            $data = $this->Common_model->getData('worli_timer','','','','','One','','');
        }
        echo json_encode($data);
         
    }

    public function checkStrimStatus(){
        $this->load->model('Common_model');
        $bName = $this->Common_model->getData('worli_timer',' WHERE status="A"','cTime,roundId','','','One','','');
        die(json_encode($bName));
    }

    public function testInstantWorli(){
        $this->load->view('user/testInstantWorli');
    }


    public function canceledRound(){
        $addResult['status']='V';
        $trId = $_POST['data']['transaction_id'];
        $addUpdate = AddUpdateTable('instant_worli_game', 'round_id', $trId, $addResult);
        if($addUpdate){
            $arr=[
                'status'=>200,
                'message'=>'Round Canceled!'
            ];
            ob_start();
            echo json_encode($arr);
            $size = ob_get_length();
            header("Content-Encoding: none");
            header("Content-Length: {$size}");
            header("Connection: close");
            ob_end_flush();
            ob_flush();
            flush();
            $Common_model = $this->load->model('Common_model');
            $con = ' WHERE status="A"';
            
            $c=$this->Common_model->getData('client',$con,'end_point_url,id','','','','','');
            $cArr['code']='801';
            $cArr['market']='Instant Worli';
            $cArr['market_code']='701';
            $cArr['bazar_name']='Instant Worli';
            foreach($c as $b){
                $con1 = ' WHERE partner_id="'.$b['id'].'" AND round_id="'.$trId.'"';
                $data=$this->Common_model->getData('instant_worli_game',$con,'end_point_url,id','','','','','');
                $arr['transaction_id']=$data;
                $cArr['arr'] = json_encode($arr);
                $void = requestForClient($c['end_point_url'],$cArr);
            }
            die(json_encode(['status'=>200,'massage'=>'Bet Void Successfully.']));
        }else{
            die(json_encode(['status'=>300,'massage'=>'Somthing Went Wrong.']));
        }
    }

   
    public function worliSetalmentCrownJob(){
        $this->load->model('Common_model');
        $con=" LEFT JOIN warli_result ON warli_users_game.round_id = warli_result.gameId WHERE warli_users_game.status='P'";
        $fields="DISTINCT warli_users_game.round_id,warli_users_game.result_date,warli_result.id,warli_result.patti_result,warli_result.akda_result";
        
        $data = $this->Common_model->getData('warli_users_game',$con,$fields,'','','','warli_users_game.id DESC','');
        array_shift($data);
        $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
        $lC=0;
        $fbC=0;
        $oC=0;
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

        $bhav = $this->Common_model->getData('warli_bhav','','bhav,id','','','','','');
        
        $bhav1 = array_combine(array_column($bhav,'id'),array_column($bhav,'bhav'));
        
        foreach($data as $nD){
            $d=$nD['round_id'];
            $result = $nD;
            if(empty($nD['patti_result'])){
                $req = setalmentWorli($d);
                if(empty($req)){
                    $arr=['status'=>201,'massage'=>'Result Not Available.'];
                    continue;
                }else{
                    $data = json_decode($req);
                    $ak=(string)$data->gameScore;
                    $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];
                    $patti=$data->gameScore;
                    if($akda>9){
                        $a=(string)$akda;
                        $akda=$a[1];
                    }
                    $wArr['akda_result']=$akda;
                    $wArr['patti_result']=$patti;
                    $wArr['result_date']=$nD['result_date'];
                    $wArr['gameId']=$d;
                    $wArr['created']=date('Y-m-d H:i:s');
                    $wArr['tableId']='Matka-1';
                    $wArr['status']='A';
                    $res=AddUpdateTable('warli_result','','',$wArr); 
                }
            }else{
                $patti=$nD['patti_result'];
                $akda=$nD['akda_result'];
            }
            $con1 = ' LEFT JOIN customer_rate ON warli_users_game.customer_id = customer_rate.customer_id WHERE warli_users_game.status="P" AND warli_users_game.round_id="'.$d.'" AND warli_users_game.game IN ("'.$akda.'","'.$patti.'")';
            $feild = 'customer_rate.rate,warli_users_game.transaction_id,warli_users_game.game,warli_users_game.game_name,warli_users_game.point,warli_users_game.customer_id,warli_users_game.partner_id';
            $bets = $this->Common_model->getData('warli_users_game',$con1,$feild,'','','','','');
            
            foreach ($bets as $b) {
                if($b['partner_id']=='2'){
                    $commission=$lC;
                }else if($b['partner_id']=='4'){
                    $commission=$fbC;
                }else{
                    $commission=$oC;
                }
                if($b['game_name']=='4'){
                    if($b['game']==$akda){
                        if($b['rate']){
                            $win = ((int)$b['point']*$bhav1[$b['game_name']]) * ((100-$b['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav1[$b['game_name']]*(int)$b['point'];
                            $bArr['winning_point']=($bhav1[$b['game_name']]*(int)$b['point'])-$bArr['commission'];
                        }
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                        $bArr['status']='W';
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                    }
                }else{
                    if($b['game']==$patti){
                        if($rOC){
                            $win = ((int)$b['point']*$bhav1[$b['game_name']]) * ((100-$rOC['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav1[$b['game_name']]*(int)$b['point'];
                            $bArr['winning_point']=($bhav1[$b['game_name']]*(int)$b['point'])-$bArr['commission'];
                        }
                        $bArr['winning_in_rs']=$bArr['winning_point']*(double)$cR[$b['partner_id']];
                        $bArr['commission_in_rs']=$bArr['commission']*(double)$cR[$b['partner_id']];
                        $bArr['status']='W';
                    }else{
                        $bArr['commission']=0;
                        $bArr['winning_point']=0;
                        $bArr['status']='L';
                        $bArr['winning_in_rs']=0;
                        $bArr['commission_in_rs']=0;
                    }
                }
                $res=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);   
            }
                
            $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');
            $multiUrl = [];
            $multiData = [];
            $multiI = 0;
            foreach($arrLoss as $l){
                $con=" WHERE partner_id='".$l['id']."' AND round_id='".$d."'";
                if($l['id']=='2'){
                    $con.=' AND status="W"';
                    $arrReq['dataRes']=$d;
                }
                $arrLossBet = $this->Common_model->getData('warli_users_game',$con,'transaction_id,status,winning_point,commission,customer_id','','','','','');
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Instant Worli';
                $arrReq['market_code']='701';
                $arrReq['bazar_name']='Instant Worli';
                // $req = requestForClient($l['end_point_url'],$arrReq);
                $multiUrl[$multiI]=$l['end_point_url'];
                $multiData[$multiI]=$arrReq;
                $multiI++;
            }
            $req = requestForMultiClient($multiUrl,$multiData);
            if($res || $result){
                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
            }else{
                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
            }
            $CI = &get_instance();
            $query = "UPDATE warli_users_game SET status='L',winning_point='0',commission='0' where round_id='".$d."' and status='P'";
            $sth = $CI->db->query($query);
        }
        die(json_encode(['status'=>200,'massage'=>'Result Updated Successfully']));
    }


    public function worliResetalmentCrownJob($partner,$round){
        $d = explode("-",$round);
        $round = implode("','",$d);
        $this->load->model('Common_model');
        $con=" WHERE partner_id='".$partner."' AND round_id IN ('".$round."') AND result_date > '2023-04-16' AND status='W'";
        
        $arrWinBet = $this->Common_model->getData('warli_users_game',$con,'transaction_id,status,winning_point,commission,round_id','','','','','');

        $con1=" WHERE partner_id='".$partner."' AND round_id IN ('".$round."') AND result_date > '2023-04-16' AND status='L'";
        $arrLossBet = $this->Common_model->getData('warli_users_game',$con1,'transaction_id,status,winning_point,commission','','','','','');
        
        if(!empty($arrWinBet) || !empty($arrLossBet)){
            die(json_encode([
                'status'=>200,
                'dataWin'=>$arrWinBet,
                'dataLoss'=>$arrLossBet,
                'market'=>'Instant Worli',
                'market_code'=>701,
                'bazar_name'=>'Instant Worli'
            ]));
        }else{
            die(json_encode(['status'=>404,'data'=>'No Data Found']));
        }
    }

    public function testSocket(){
        $notifyResult['market']='Worli';
        $notifyResult['patti']='123';
        $notifyResult['akda']='6';
        $notifyResult['rResult']='6';
        $notifyResult['url']='4ad7b357b4a728f18d6e27dea29a071e';
        $this->load->model('Common_model');
        $notifyMeW['userList'] = $this->Common_model->getData('warli_users_game',' WHERE round_id="20230227500" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
        $notifyResult['resultStatus']=$notifyMeW['userList'];
        $d = notifyUserWithResult(json_encode($notifyResult));
        die(json_encode(['status'=>200,'data'=>$d,'message'=>'Data Send Successfully']));
    }
}