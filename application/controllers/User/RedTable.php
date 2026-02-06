<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
// die(FCPATH.'../vendor/autoload.php');
require FCPATH . '/vendor/autoload.php';

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

class RedTable extends BaseController{
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
	}

	 
	public function index(){
        $this->load->model('Common_model');
        $data['buf'] = $this->Common_model->getData('buffer',' WHERE id="5"','status','','','One','','');
		$this->load->view('user/redTable',$data);
        // $this->load->view('user/maintenance');
	}

	public function PlaceBets(){
        // echo '<pre>';
                // print_r($data);
                // print_r($_POST);
                // die();
		if(isset($_POST['game_name']) && isset($_POST['games']) && isset($_POST['roundId']) && isset($_POST['totalAmount'])){
            $date = date('Y-m-d'); 
            $this->load->model('Common_model');
            if(!empty($_POST['games'])){
                
                $client = $this->Common_model->getData('client',' WHERE client_token="'.$_POST['tokenId'].'"','end_point_url,id,currancy_rate','','','One','','');
                $data=requestForClient($client['end_point_url'],['id'=>$_POST['customer_id'],'code'=>'300']);
                
                $res = json_decode($data);
                if($res->Code==200 && $res->data[0] >= $_POST['totalAmount']){
                    $_SESSION['balance']=$res->data[0];
                	$cArr['arr']=[];
                	$rId = $this->Common_model->getData('redTable_timer',' WHERE id="1"','roundId,cTime','','','One','','');
                    if($rId['cTime']>date('Y-m-d H:i:s',strtotime('-1 minutes'))){
                    	foreach ($_POST['games'] as $arr) {
                            if($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']){
                                if($_POST['gameId']=='4' && $arr['coin'] < 10){
                                    continue;
                                }else if($arr['coin'] < 5){
                                    continue;
                                }
                                $betArr=[];
                                $betArr['transaction_id'] = transactionID(36,36);
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
                                $add = AddUpdateTable('redTable_users_game','','',$betArr);
                                
                                $_SESSION['balance']=$_SESSION['balance']-$arr['coin'];

                                $betArr['gameId'] = $_POST['gameId'];
                                $betArr['game_name'] = $_POST['game_name'];
                                // $notifyResult['point']=$betArr['point_in_rs'];
                                $notifyResult['point']=$betArr['point'];
                                
                                unset($betArr['point_in_rs']);
                                unset($betArr['partner_id']);
                                array_push($cArr['arr'],$betArr);

                                $notifyResult['market']='blueTableRoundStetment';
                                $notifyResult['game']=$betArr['game'];
                                
                                $notifyResult['userName']=$_SESSION['userName'];
                                $notifyResult['customer_id'] = $_POST['customer_id'];
                                notifyUserWithResult(json_encode($notifyResult));
                            }
                        }
                        $cArr['arr'] = json_encode($cArr['arr']);
                        $cArr['code']='702';
                        $cArr['id']=$_POST['customer_id'];
                        
                        $req = requestForClient($client['end_point_url'],$cArr);
                        $jReq = json_decode($req);
                        // echo '<pre>';
                        // print_r($jReq);
                        // die();
            			$_SESSION['balance']=$jReq->data;
                        $array = [
                                "balance"=>$_SESSION['balance'],
                                "message"=>"Bet Placed Successfully!",
                                "code"=>200
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

    public function updateCommission(){
        $this->load->model('Common_model');
        $rOC = $this->Common_model->getData('redTable_users_game',' WHERE status="W" AND commission_in_rs="0" AND partner_id="2"','transaction_id,winning_point,commission','','','','','');
        // echo '<pre>';
        // print_r($rOC);
        // die();
        foreach($rOC as $r){
            
            $bArr['winning_in_rs']=$r['winning_point'];
            $bArr['commission_in_rs']=$r['commission'];
            $res1=AddUpdateTable('redTable_users_game','transaction_id',$r['transaction_id'],$bArr);
            
        }
        echo 'done';
    }
    public function resultRedTable(){
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        // echo '<pre>';
        // print_r(json_encode($arr));
        // die();
        $tArr['time']=$data->BetTime;
        $tArr['round']='0';
        $res1=AddUpdateTable('redTable_timer','id','1',$tArr);
        if($data->GameState=='Between Game'){
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

            $res=AddUpdateTable('redTable_result','','',$betArr);
            
            /*---------------- For Responce And Process Start ----------------*/
            if($res){
                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
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
            $notifyResult['url']='61e244a8b1f70b8dc67e4014eb9bc963';
            notifyUserWithResult(json_encode($notifyResult));
            /*---------------- For Responce And Process End ----------------*/
            $this->load->model('Common_model');
            $bets = $this->Common_model->getData('redTable_users_game',' WHERE status="P" AND round_id="'.$data->GameId.'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
            
            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');
            
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
                        $bhav = $this->Common_model->getData('redTable_rate',' WHERE id="'.$b['game_name'].'"','rate','','','One','','');
                        if($rOC){
                            $win = ((int)$b['point']*$bhav['rate']) * ((100-$rOC['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav['rate']*(int)$b['point'];
                            $bArr['winning_point']=($bhav['rate']*(int)$b['point'])-$bArr['commission'];
                        }
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
                        $bhav = $this->Common_model->getData('redTable_rate',' WHERE id="'.$b['game_name'].'"','rate','','','One','','');
                        if($rOC){
                            $win = ((int)$b['point']*$bhav['rate']) * ((100-$rOC['rate']) / 100);
                            $bArr['commission'] = ($commission / 100) * $win;
                            $bArr['winning_point'] = $win - $addRes['commission'];
                        }else{
                            $bArr['commission'] = ($commission / 100) * $bhav['rate']*(int)$b['point'];
                            $bArr['winning_point']=($bhav['rate']*(int)$b['point'])-$bArr['commission'];
                        }
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
                
                $res1=AddUpdateTable('redTable_users_game','transaction_id',$b['transaction_id'],$bArr);
                   
            }
            $notifyMeW['userList'] = $this->Common_model->getData('redTable_users_game',' WHERE round_id="'.$data->GameId.'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
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
                $arrLossBet = $this->Common_model->getData('redTable_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$data->GameId.'"','transaction_id,status,winning_point,commission,customer_id','','','','','');
                
                $arrReq['code']='601';
                $arrReq['rec']=json_encode($arrLossBet);
                $arrReq['market']='Red Table';
                $arrReq['market_code']='702';
                $arrReq['bazar_name']='Blue Table';
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


            $notifyMeL['userList'] = $this->Common_model->getData('redTable_users_game',' WHERE round_id="'.$data->GameId.'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
            
            requestForBalance(json_encode($notifyMeW));
            
            requestForBalance(json_encode($notifyMeL));

            die(json_encode($arr));
        }else if($data->GameState=="Bet Timer"&&!$data->spot1&&!$data->spot2&&!$data->spot3){
            $tArr['round']='1';
            $tArr['roundId']=$data->GameId;
            $tArr['cTime']=date('Y-m-d H:i:s', strtotime("-10 sec"));
            $tArr['time']='50';
            $res=AddUpdateTable('redTable_timer','id','1',$tArr);
            $notifyResult['market']='blueTableNewRound';
            $notifyResult['roundId']=$data->GameId;
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
            $req = setalmentWorli($_POST['id']);
            die($req);
        }
        $this->load->view('admin/worliSetalment');
    }
    // public function resultInstantWorliBk(){
    //     $inp = file_get_contents('php://input');
    //     $data = json_decode($inp);
        
    //     if(isset($data->spot1)&&isset($data->spot2)&&isset($data->spot3)){
            
    //         $ak=(string)$data->CardScore;
    //         $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

    //         if($akda>9){
    //             $a=(string)$akda;
    //             $akda=$a[1];
    //         }
    //         $patti = $data->CardScore;
    //         $betArr['result_date'] = date('Y-m-d');
    //         $betArr['tableId'] = $data->TableID;
    //         $betArr['gameId'] = $data->GameId;
    //         $betArr['patti_result'] = $ak;
    //         $betArr['akda_result'] = $akda;
    //         $betArr['status'] = 'A';
    //         $res=AddUpdateTable('warli_result','','',$betArr);
    //         if($data->BetTime){
    //             $tArr['time']=$data->BetTime;
    //             $tArr['round']='0';
    //             $res1=AddUpdateTable('worli_timer','id','2',$tArr);
    //         }
            

    //         $this->load->model('Common_model');
    //         $bets = $this->Common_model->getData('warli_users_game',' WHERE status="P" AND round_id="'.$data->GameId.'"','transaction_id,game,game_name,point,customer_id','','','','','');
            
    //         foreach ($bets as $b) {
    //             if($b['game_name']=='4'){
    //                 if($b['game']==$akda){
    //                     $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
    //                     $bArr['commission'] = (0 / 100) * $bhav['bhav']*(int)$b['point'];
    //                     $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
    //                     $bArr['status']='W';
    //                 }else{
    //                     $bArr['commission']=0;
    //                     $bArr['winning_point']=0;
    //                     $bArr['status']='L';
    //                 }
    //             }else{
    //                 if($b['game']==$patti){
    //                     $bhav = $this->Common_model->getData('warli_bhav',' WHERE id="'.$b['game_name'].'"','bhav','','','One','','');
    //                     $bArr['commission'] = (0 / 100) * $bhav['bhav']*(int)$b['point'];
    //                     $bArr['winning_point']=($bhav['bhav']*(int)$b['point'])-$bArr['commission'];
    //                     $bArr['status']='W';
    //                 }else{
    //                     $bArr['commission']=0;
    //                     $bArr['winning_point']=0;
    //                     $bArr['status']='L';
    //                 }
    //             }
                
    //             $res1=AddUpdateTable('warli_users_game','transaction_id',$b['transaction_id'],$bArr);         
    //         }
                

    //         $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');

    //         foreach($arrLoss as $l){
    //             $con=" WHERE partner_id='".$l['id']."' AND round_id='".$data->GameId."'";
    //             $arrLossBet = $this->Common_model->getData('warli_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$data->GameId.'"','transaction_id,status,winning_point,commission,customer_id','','','','','');
    //             if($arrLossBet){
    //                 $arrReq['code']='601';
    //                 $arrReq['rec']=json_encode($arrLossBet);
    //                 $arrReq['market']='Instant Worli';
    //                 $arrReq['market_code']='702';
    //                 $arrReq['bazar_name']='Blue Table';
    //                 $req = requestForClient($l['end_point_url'],$arrReq);
    //             }
               
    //         }

    //         if($res){
    //             $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
    //         }else{
    //             $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
    //         }

    //         die(json_encode($arr));
    //     }else if($data->GameState=="Bet Timer"&&!$data->spot1&&!$data->spot2&&!$data->spot3){
    //         $tArr['time']=$data->BetTime;
    //         $tArr['round']='1';
    //         $tArr['roundId']=$data->GameId;
    //         $tArr['cTime']=date('Y-m-d H:i:s');
    //         $res=AddUpdateTable('worli_timer','id','2',$tArr);
    //         if($res){
    //             $arr=['status'=>200,'massage'=>'Betting Start Now.'];
    //         }else{
    //             $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
    //         }
    //         die(json_encode($arr));
    //     }
    // }

    public function worliHistory($id,$cid){
        $this->load->model('Common_model');
        $con=' WHERE partner_id="'.$id.'" AND customer_id="'.$cid.'" AND result_date="'.date('Y-m-d').'"';
        $feilds = 'round_id,game_name,point,game,status,winning_point';
        $data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','','','');
        $this->load->view('user/worliHistory',$data);
    }

    public function testMCript($id){
        $mcrypt = new MCrypt();
        $amount = $mcrypt->encrypt($id);
        echo $amount.'<br>';
        $newAmount = $mcrypt->decrypt($id);
        echo $newAmount;
        die();
    }

   

    public function checkStrimStatusRedTable(){
        $this->load->model('Common_model');
        $bName = $this->Common_model->getData('redTable_timer',' WHERE status="A"','cTime,roundId','','','One','','');
        die(json_encode($bName));
    }

    public function testInstantWorli(){
        $this->load->view('user/test/testInstantWorli');
    }

    public function getProb(){
        $weights = [
            0 => 200,
            1 => 200,
            2 => 200,
            3 => 200,
            4 => 200,
            5 => 200,
            6 => 200,
            7 => 200,
            8 => 200,
            9 => 200,
            10 => 26,
            11 => 48
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

    public function getProbCrazyWheel(){
        $weights = [
            '10' => 10,
            '25' => 10,
            '50' => 40,
            '100' => 45,
            '200' => 10
        ];

        // Validate weights
        foreach ($weights as $k => $v) {
            if (!is_numeric($v) || $v < 0) {
                $weights[$k] = 0;
            }
        }

        $totalWeight = array_sum($weights);

        if ($totalWeight <= 0) {
            return null; // or any fallback value
        }

        $rand = mt_rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($weights as $number => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $number;
            }
        }

        // Fallback (should never happen)
        return array_key_first($weights);
    }

    public function getProbRedAndBlack(){
        $weights = [
            '10' => 100,
            '25' => 100
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

    public function requestToGetBetEndLess(){
        $this->load->model('Common_model');
        // echo '<pre>';
        $weights = [
            '0' => 0,
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0
        ];
        $weightsCrazyWheel = [
            '10' => 0,
            '25' => 0,
            '50' => 0,
            '100' => 0,
            '200' => 0
        ];
        $weightsRedBlack = [
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '13' => 0,
            '14' => 0,
            '15' => 0,
            '16' => 0,
            '17' => 0,
            '18' => 0,
            '19' => 0,
            '20' => 0,
            '21' => 0,
            '22' => 0,
            '23' => 0,
            '24' => 0,
            '25' => 0,
        ];
        $totalBetPoint = 0;
        $totalWinPoint = 0;
        $totalComPoint = 0;
        // $result = $this->Common_model->getData('crezyMatkaResult',' WHERE result_date="2025-08-06"','','','','','','');
        $result = $this->Common_model->getData('crezyMatkaResult',' WHERE result_date="2025-08-06" AND akda IN (10)','','','','','','');
        
        foreach($result as $r){
            $d = $this->getProb();
            // $d = 10;
            $weights[$d] += 1;
            $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE result_date="2025-08-06" AND round_id="'.$r['round_id'].'"','IFNULL(SUM(point), 0) as p','','','One','','');    
            if($bets['p']!=0){
                $R1 = [];
                $j = json_encode(['round_id'=>$r['round_id'],'res'=>$d]);
                if($d!=10 && $d!=11){
                    $R1 = $this->updateWalletCrezyMatka($j);
                    // $R1 = [0,0];
                }else if($d==10){
                    $R1 = $this->updateWalletSpeenFlipCoinWin($r['round_id']);
                    $weightsRedBlack[$R1[2]] += 1;
                    if (!isset($R1[2]) || $R1[2] === '') {
                        echo "Red Black Warning: R1[2] is not set or empty for round_id: " . $r['round_id'] . "\n";
                        die();
                    }
                }else{
                    $R1 = $this->updateWalletCrezyWin($r['round_id']);
                    $weightsCrazyWheel[$R1[2]] += 1;
                    if (!isset($R1[2]) || $R1[2] === '') {
                        echo "Crazy Wheel Warning: R1[2] is not set or empty for round_id: " . $r['round_id'] . "\n";
                        die();
                    }
                }
                $totalBetPoint += $bets['p'];
                $totalWinPoint += $R1[0];
                $totalComPoint += $R1[1];
            }
        }
        
        echo '<pre>';
        print_r($weights);
                    echo 'Total Point<br>';
        print_r($totalBetPoint);

                    echo '<br>Crazy Wheel<br>';
        print_r($weightsCrazyWheel);
                    echo 'Red&black<br>';
        print_r($weightsRedBlack);

                    echo '<br>Total Win<br>';
        print_r($totalWinPoint);
                    echo '<br>Total Commission<br>';
        print_r($totalComPoint);
                    echo '<br>GGR<br>';
        print_r($totalBetPoint-$totalWinPoint);
        die();
            
    }

    public function updateWalletCrezyMatka($j){
        $data = json_decode($j);
        $this->load->model('Common_model');
        $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$data->round_id.'" AND game="'.$data->res.'"','','','','','','');
        if($bets){
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
           
            $winning_in_rs=0;
            $commission_in_rs=0;
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
                $winning_in_rs += $bArr['winning_point']*(double)$b['exchange_rate'];
                $commission_in_rs += $bArr['commission']*(double)$b['exchange_rate'];
            } 
            return [$winning_in_rs,$commission_in_rs];
        }else{
            return [0,0];
        }
        /*--------------------- Setel Market End --------------------------*/
    }

    public function updateWalletSpeenFlipCoinWin($rId){
        // $this->load->model('Common_model');
        // $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="10"','','','','','','');
        $into = rand(2,25);
        return [0,0,$into];
        // if($bets){
        //     $comR = array();
        //     $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
        //     foreach($com as $c){
        //         $comR[$c['client_id']] = $c['commission'];
        //     }
            
        //     $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
        //     $cR = array();
        //     foreach ($cCR as $d){
        //         $cR[$d['id']] = $d['currancy_rate'];
        //     }
        //     $winning_in_rs=0;
        //     $commission_in_rs=0;
        //     foreach($bets as $b){
        //         $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$b['customer_id'].'" AND partner_id="'.$b['partner_id'].'"','rate','','','One','','');
            
        //         $bArr = array();
        //         $commission = $comR[$b['partner_id']]; 
        //         if(!$commission){
        //             $commission = 2;
        //         }
        //         if($rOC){
        //             $win = ((int)$b['point']*$into) * ((100-$rOC['rate']) / 100);
        //             $bArr['commission'] = ($commission / 100) * $win;
        //             $bArr['winning_point'] = $win - $bArr['commission'];
        //         }else{
        //             $bArr['commission'] = ((int)$commission / 100) * (int)$into*(int)$b['point'];
        //             $bArr['winning_point']=((int)$into*(int)$b['point'])-$bArr['commission'];
        //         }
        //         $winning_in_rs=$bArr['winning_point']*(double)$b['exchange_rate'];
        //         $commission_in_rs=$bArr['commission']*(double)$b['exchange_rate'];
        //     }
        //     if ($into === null || $into === '') {
        //         echo "Null or empty at iteration $i\n";
        //         die();
        //     }
        //     return [$winning_in_rs,$commission_in_rs,$into];
        // }else{
            
        //     if ($into === null || $into === '') {
        //         echo "Null or empty at iteration $i\n";
        //         die();
        //     }
        //     return [0,0,$into];
        // }
        /*--------------------- Setel Market End --------------------------*/
    }
    public function updateWalletCrezyWin($rId){
        // $this->load->model('Common_model');
        $into = $this->getProbCrazyWheel();
        return [0,0,$into];
        // $bets = $this->Common_model->getData('crezyMatkaGame',' WHERE round_id="'.$rId.'" AND game="11"','','','','','','');
        // if($bets){
        //     $comR = array();
        //     $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
        //     foreach($com as $c){
        //         $comR[$c['client_id']] = $c['commission'];
        //     }
            
        //     $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
        //     $cR = array();
        //     foreach ($cCR as $d){
        //         $cR[$d['id']] = $d['currancy_rate'];
        //     }
            
        //     $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets[0]['customer_id'].'" AND partner_id="'.$bets[0]['partner_id'].'"','rate','','','One','','');
        //     $winning_in_rs=0;
        //     $commission_in_rs=0;
        //     foreach($bets as $b){
        //         $bArr = array();
        //         $commission = $comR[$b['partner_id']]; 
        //         if(!$commission){
        //             $commission = 2;
        //         }
        //         if($rOC){
        //             $win = ((int)$b['point']*$into) * ((100-$rOC['rate']) / 100);
        //             $bArr['commission'] = ($commission / 100) * $win;
        //             $bArr['winning_point'] = $win - $bArr['commission'];
        //         }else{
        //             $bArr['commission'] = ((int)$commission / 100) * (int)$into*(int)$b['point'];
        //             $bArr['winning_point']=((int)$into*(int)$b['point'])-$bArr['commission'];
        //         }
        //         $winning_in_rs+=$bArr['winning_point']*(double)$b['exchange_rate'];
        //         $commission_in_rs+=$bArr['commission']*(double)$b['exchange_rate'];
               
        //     } 
        //     return [$winning_in_rs,$commission_in_rs,$into];
        // }else{
        //     return [0,0,$into];
        // }
        /*--------------------- Setel Market End --------------------------*/
    }
}