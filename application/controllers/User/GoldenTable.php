<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

require APPPATH . '../vendor/autoload.php';

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

class GoldenTable extends BaseController{
	function __construct(){
	    parent::__construct();
        if(isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])){
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

	 
	// public function index(){
	// 	$this->load->view('user/goldenTable');
	// }

	// public function PlaceBets(){
	// 	if(isset($_POST['game_name']) && isset($_POST['games']) && isset($_POST['roundId']) && isset($_POST['totalAmount'])){
 //            $date = date('Y-m-d'); 
 //            $this->load->model('Common_model');
 //            if(!empty($_POST['games'])){
                
 //                $client = $this->Common_model->getData('client',' WHERE client_token="'.$_POST['tokenId'].'"','end_point_url,id','','','One','','');
 //                $data=requestForClient($client['end_point_url'],['id'=>$_POST['customer_id'],'code'=>'300']);
 //                $res = json_decode($data);
 //                if($res->Code==200 && $res->data[0] >= $_POST['totalAmount']){
 //                    $_SESSION['balance']=$res->data[0];
 //                	$cArr['arr']=[];
 //                	$rId = $this->Common_model->getData('goldenTable_timer',' WHERE id="1"','roundId,cTime','','','One','','');
 //                    if($rId['cTime']>date('Y-m-d H:i:s',strtotime('-2 minutes'))){
 //                    	foreach ($_POST['games'] as $arr) {
 //                            if($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']){
                                
 //                                $betArr=[];
 //                                $betArr['transaction_id'] = transactionID(10,10);
 //                                $betArr['game_name'] = $_POST['gameId'];
 //                                $betArr['round_id'] = $_POST['roundId'];
                              
 //                                $betArr['result_date'] = $date;
 //                                $betArr['point'] = (int)$arr['coin'];
 //                                $betArr['game'] = $arr['akda'];
 //                                $betArr['partner_id'] = (int)$client['id'];
 //                                $betArr['customer_id'] = $_POST['customer_id'];
 //                                $betArr['status'] = 'P';
 //                                $betArr['created'] = date('Y-m-d H:i:s');
 //                                $add = AddUpdateTable('goldenTable_users_game','','',$betArr);
 //                                // echo '<pre>';
 //                                // print_r($add);
 //                                // die();
                                
                                
 //                                $_SESSION['balance']=$_SESSION['balance']-$arr['coin'];

 //                                $betArr['gameId'] = $_POST['gameId'];
 //                                $betArr['game_name'] = $_POST['game_name'];
 //                                unset($betArr['partner_id']);
 //                                array_push($cArr['arr'],$betArr);
 //                            }
 //                        }
 //                        $cArr['arr'] = json_encode($cArr['arr']);
 //                        $cArr['code']='703';
 //                        $cArr['id']=$_POST['customer_id'];
                        
 //                        $req = requestForClient($client['end_point_url'],$cArr);
 //                        $jReq = json_decode($req);
 //            			$_SESSION['balance']=$jReq->data;
 //                        $array = [
 //                                "balance"=>$_SESSION['balance'],
 //                                "message"=>"Bet Placed Successfully!",
 //                                "code"=>200,
 //                        ];
 //                    }else{
 //                        die(json_encode(["message"=>"Wait For Five Secound!","code"=>202]));
 //                    }
 //                } else {
 //                    $array = [
 //                        "message"=>"You Dont Have Sufficient Balance.",
 //                        "code"=>203,
 //                    ];
 //                }
 //            }else {
 //                $array = [
 //                    "message"=>"Please Select Game And Bet Points.",
 //                    "code"=>202,
 //                ];
 //            }
 //            die(json_encode($array));
 //        } else {
 //            die(json_encode(["message"=>"Please Provide Valid data","code"=>401]));
 //        }
	// }

 //    public function resultGoldenTable(){
 //        $inp = file_get_contents('php://input');
 //        $data = json_decode($inp);
 //        $tArr['time']=$data->BetTime;
 //        $tArr['round']='0';
 //        $res1=AddUpdateTable('worli_timer','id','1',$tArr);
 //        if($data->GameState=='Between Game'){
 //            $ak=(string)$data->CardScore;
 //            $akda=(int)$ak[0]+(int)$ak[1]+(int)$ak[2];

 //            if($akda>9){
 //                $a=(string)$akda;
 //                $akda=$a[1];
 //            }
 //            $patti = $data->CardScore;
 //            $betArr['result_date'] = date('Y-m-d');
 //            $betArr['tableId'] = $data->TableID;
 //            $betArr['gameId'] = $data->GameId;
 //            $betArr['patti_result'] = $ak;
 //            $betArr['akda_result'] = $akda;
 //            $betArr['status'] = 'A';

 //            $res=AddUpdateTable('goldenTable_result','','',$betArr);
            
 //            /*---------------- For Responce And Process Start ----------------*/
 //            if($res){
 //                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
 //            }else{
 //                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
 //            }
 //            ob_start();
 //            echo json_encode($arr);
 //            $size = ob_get_length();
 //            header("Content-Encoding: none");
 //            header("Content-Length: {$size}");
 //            header("Connection: close");
 //            ob_end_flush();
 //            ob_flush();
 //            flush();
 //            $notifyResult['market']='Golden Table';
 //            $notifyResult['url']='61e244a8b1f70b8dc67e4014eb9bc963';
 //            notifyUserWithResult(json_encode($notifyResult));
 //            /*---------------- For Responce And Process End ----------------*/
 //            $this->load->model('Common_model');
 //            $bets = $this->Common_model->getData('goldenTable_users_game',' WHERE status="P" AND round_id="'.$data->GameId.'"','transaction_id,game,game_name,point,customer_id,partner_id','','','','','');
            
 //            $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');
                                
 //            foreach ($bets as $b) {
 //                if($b['game_name']=='4'){
 //                    if($b['game']==$akda){
 //                        $bhav = $this->Common_model->getData('goldenTable_rate',' WHERE id="'.$b['game_name'].'"','rate','','','One','','');
 //                        if($rOC){
 //                            $win = ((int)$b['point']*$bhav['rate']) * ((100-$rOC['rate']) / 100);
 //                            $bArr['commission'] = (2 / 100) * $win;
 //                            $bArr['winning_point'] = $win - $addRes['commission'];
 //                        }else{
 //                            $bArr['commission'] = (2 / 100) * $bhav['rate']*(int)$b['point'];
 //                            $bArr['winning_point']=($bhav['rate']*(int)$b['point'])-$bArr['commission'];
 //                        }
 //                        $bArr['status']='W';
 //                    }else{
 //                        $bArr['commission']=0;
 //                        $bArr['winning_point']=0;
 //                        $bArr['status']='L';
 //                    }
 //                }else{
 //                    if($b['game']==$patti){
 //                        $bhav = $this->Common_model->getData('goldenTable_rate',' WHERE id="'.$b['game_name'].'"','rate','','','One','','');
 //                        if($rOC){
 //                            $win = ((int)$b['point']*$bhav['rate']) * ((100-$rOC['rate']) / 100);
 //                            $bArr['commission'] = (2 / 100) * $win;
 //                            $bArr['winning_point'] = $win - $addRes['commission'];
 //                        }else{
 //                            $bArr['commission'] = (2 / 100) * $bhav['rate']*(int)$b['point'];
 //                            $bArr['winning_point']=($bhav['rate']*(int)$b['point'])-$bArr['commission'];
 //                        }
	// 					$bArr['status']='W';
 //                    }else{
 //                        $bArr['commission']=0;
 //                        $bArr['winning_point']=0;
 //                        $bArr['status']='L';
 //                    }
 //                }
                
 //                $res1=AddUpdateTable('goldenTable_users_game','transaction_id',$b['transaction_id'],$bArr);
                   
 //            }
                

 //            $arrLoss = $this->Common_model->getData('client','','id,end_point_url','','','','','');

 //            foreach($arrLoss as $l){
 //                $con=" WHERE partner_id='".$l['id']."' AND round_id='".$data->GameId."'";
 //                if($l['id']=='2'){
 //                    $con.=' AND status="W"';
 //                    $arrReq['dataRes']=$data->GameId;
 //                }
 //                $arrLossBet = $this->Common_model->getData('goldenTable_users_game',' WHERE partner_id="'.$l['id'].'" AND round_id="'.$data->GameId.'"','transaction_id,status,winning_point,commission','','','','','');
                
 //                $arrReq['code']='601';
 //                $arrReq['rec']=json_encode($arrLossBet);
 //                $arrReq['market']='Golden Table';
 //                $req = requestForClient($l['end_point_url'],$arrReq);
               
 //            }

 //            if($res&&$res1){
 //                $arr=['status'=>200,'massage'=>'Result Updated Successfully.'];
 //            }else{
 //                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];
 //            }


 //            $notifyMeW['userList'] = $this->Common_model->getData('goldenTable_users_game',' WHERE round_id="'.$data->GameId.'" AND status="W"','customer_id as id,status,SUM(winning_point) as winning_point','','','','','customer_id');
 //            $notifyMeL['userList'] = $this->Common_model->getData('goldenTable_users_game',' WHERE round_id="'.$data->GameId.'" AND status="L"','DISTINCT customer_id as id,status','','','','','');
 //            $notifyResult['resultStatus']=$notifyMeW['userList'];
 //            notifyUserWithResult(json_encode($notifyResult));
 //            requestForBalance(json_encode($notifyMeW));
            
 //            requestForBalance(json_encode($notifyMeL));

 //            die(json_encode($arr));
 //        }else if($data->GameState=="Bet Timer"&&!$data->spot1&&!$data->spot2&&!$data->spot3){
 //            $tArr['round']='1';
 //            $tArr['roundId']=$data->GameId;
 //            $tArr['cTime']=date('Y-m-d H:i:s', strtotime("-10 sec"));
 //            $tArr['time']='120';
 //            $res=AddUpdateTable('goldenTable_timer','id','1',$tArr);
 //            if($res){
 //                $arr=['status'=>200,'massage'=>'Betting Start Now.'];
 //            }else{
 //                $arr=['status'=>201,'massage'=>'Something Went Wrong.'];   
 //            }
 //            die(json_encode($arr));
 //        }
 //    }

    // public function getResultByPercentage($bazarId,$type){
    //     if(isset($bazarId) && isset($type)){
    //         echo '<pre>';
    //         $this->load->model('Common_model');
    //         $per = $this->Common_model->getData('regular_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
    //         $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."'";
    //         // $sp = getVariationPatti('SinglePatti');
    //         // $dp = getVariationPatti('DoublePatti');
    //         // $tp = getVariationPatti('TriplePatti');
    //         $allPatti = getPana();
    //         $akda=getVariationPatti('SingleAkda');
    //         $con1 = $con;
    //         if($type=="Open"){
    //             $con .= " AND game_type='Open'";
    //         }else{
    //             $con .= " AND game_type!='Open'";
    //         }
    //         $feild = "SUM(point) as point,game";
    //         $pattiBet = $this->Common_model->getData('regular_bazar_games',$con." AND game > 99","SUM(point) as point",'','','One','','');
    //         $con .= " AND game IN ('".implode("','",$akda)."')";
    //         $ak = $this->Common_model->getData('regular_bazar_games',$con,$feild,'','','','game asc','game');
    //         $arrPatti = [];
    //         $arr = [];
    //         $sum = array_sum(array_column($ak, 'point'));
    //         $jodiSum = 0;
    //         foreach($ak as $k){
    //             $j = loadDigitBasedJodi($k['game'],'left');
    //             $p = getPattiByDigit($k['game']);
    //             $patti = $this->Common_model->getData('regular_bazar_games',$con1." AND game IN ('".implode("','",$p)."')",'SUM(point) as point,game','','','','game asc','game');
    //             $arrPatti[$k['game']] = $patti;
    //             $jodi = $this->Common_model->getData('regular_bazar_games',$con1." AND game IN ('".implode("','",$j)."')",'SUM(point) as point,game','','','','game asc','game');
    //             $jodiSum += array_sum(array_column($jodi, 'point'));
    //             $arr[$k['game']] = $jodi;
    //         }
    //         $totalBet = $sum+$jodiSum+$pattiBet['point'];
    //         $profit =  (($totalBet/100)*20);
    //         if($type=="Open"){
    //             $i = 0;
    //             $jArr = [];
    //             $pArr = [];
    //             foreach($arr as $p){
    //                 $com = 0;
    //                 $key = 'point';
    //                 $lowestPatti = array_reduce($arrPatti[$i], function ($lowest, $item) use ($key) {
    //                     if (!isset($item[$key])) {
    //                         return $lowest;
    //                     }
    //                     if ($lowest === null || $item[$key] < $lowest[$key]) {
    //                         return $item;
    //                     }
    //                     return $lowest;
    //                 });
    //                 foreach($p as $l){
    //                     $panaType = checkPanaType($lowestPatti['game']);
    //                     if($panaType=='SP'){
    //                         $parrRate = 140;
    //                     }else if($panaType=='DP'){
    //                         $parrRate = 280;
    //                     }else if($panaType=='TP'){
    //                         $parrRate = 800;
    //                     }
    //                     $tAk = $l['point']*97;
    //                     $tJodi = $ak[$i]['point']*9.7;
    //                     $tPatti = $lowestPatti['point']*$parrRate;
    //                     $pn = $totalBet-($tAk+$tJodi+$tPatti);
    //                     $jArr[$l['game']] = ['point'=>$pn,'patti'=>$lowestPatti['game']];
    //                     if((int)$pn > (int)$profit){
    //                         $pArr[$l['game']] = ['point'=>$pn,'patti'=>$lowestPatti['game']];
    //                     }
    //                 }
    //                 $i++;
    //             }
    //             print_r($jArr);
    //             die();
    //         }else{
    //             $result = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'"','','','','One','','');
    //             $akda = $result['jodi'][0];
    //             $i = 0;
    //             $jArr = [];
    //             $pArr = [];
    //             $pArr = [];
    //             for($s=0;$s<10;$s++){
    //                 foreach($arrPatti[$s] as $m){
    //                     $panaType = checkPanaType($m['game']);
    //                     if($panaType === 'SP'){
    //                         $parrRate = 140;
    //                     }else if($panaType === 'DP'){
    //                         $parrRate = 280;
    //                     }else if($panaType === 'TP'){
    //                         $parrRate = 800;
    //                     }
    //                     $jd = $arr[$akda][$s];
    //                     $m['jodiPoint'] = $jd['point'];
    //                     $m['akdaPoint'] = $ak[$s]['point'];
    //                     $m['win'] = ($m['point']*$parrRate)+($ak[$s]['point']*9.7)+($jd['point']*97);
    //                     $m['prof'] = $totalBet-$m['win'];
    //                     array_push($pArr,$m);
    //                 }
    //             }
    //             $result=array_diff($allPatti,array_column($pArr, 'game'));
    //             if(!empty($result)){
    //                 foreach($result as $balPatti){
    //                     $panaType = checkPanaType($balPatti);
    //                     if($panaType === 'SP'){
    //                         $parrRate = 140;
    //                     }else if($panaType === 'DP'){
    //                         $parrRate = 280;
    //                     }else if($panaType === 'TP'){
    //                         $parrRate = 800;
    //                     }
    //                     $akSum = 0;
    //                     $digits = str_split((string) abs($balPatti));
                        
    //                     foreach ($digits as $digit) {
    //                         $akSum += $digit;
    //                     }

    //                     if($akSum>9){
    //                         $myAk = str_split($akSum);
    //                         $akSum = $myAk[1];
    //                     }
    //                     $m['point'] = 0;
    //                     $m['game'] = $balPatti;
    //                     $jd = $arr[$akda][$akSum];
    //                     $m['jodiPoint'] = $jd['point'];
    //                     $m['akdaPoint'] = $ak[$akSum]['point'];
    //                     $m['win'] = ($m['point']*$parrRate)+($ak[$akSum]['point']*9.7)+($jd['point']*97);
    //                     $m['prof'] = $totalBet-$m['win'];
    //                     array_push($pArr,$m);
    //                 }
    //             }
    //             $key = 'prof';
    //             usort($pArr, function ($a, $b) use ($key) {
    //                 return $b[$key] <=> $a[$key];
    //             });
    //         }
    //         $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
    //         print_r($resultPatti);
    //         die();
    //         die(json_encode(arsort($jArr)));
    //     }else{
    //         $arr=[
    //             'status'=>401,
    //             'massage'=>'Please Provide Valid Data!'
    //         ];
    //     }
    //     die(json_encode($arr));
    // }


    public function worliSetalment(){
        if($_POST){
            $req = setalmentWorli($_POST['id']);
            die($req);
        }
        $this->load->view('admin/worliSetalment');
    }

    public function worliHistory($id,$cid){
        $this->load->model('Common_model');
        $con=' WHERE partner_id="'.$id.'" AND customer_id="'.$cid.'" AND result_date="'.date('Y-m-d').'"';
        $feilds = 'round_id,game_name,point,game,status,winning_point';
        $data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','','','');
        $this->load->view('user/worliHistory',$data);
    }

   

    public function checkStrimStatusGoldenTable(){
        $this->load->model('Common_model');
        $bName = $this->Common_model->getData('goldenTable_timer',' WHERE status="A"','cTime,roundId','','','One','','');
        die(json_encode($bName));
    }

    public function getResultByPercentage($bazarId,$type){
        if(isset($bazarId) && isset($type)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('regular_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."'";
            // $con = " WHERE result_date='".date('Y-m-d',strtotime("-1 days"))."' AND bazar_name='".$bazarId."'";
            $allPatti = getPana();
            $akda=getVariationPatti('SingleAkda');
            $con1 = $con;
            if($type=="Open"){
                $con .= " AND game_type='Open'";
            }else{
                $con .= " AND game_type!='Open'";
            }
            $conPatti = $con;
            $feild = "SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('regular_bazar_games',$con." AND (game > 99 OR game='000')","SUM(point) as point,COUNT(DISTINCT customer_id) as customer",'','','One','','');
            $con .= " AND game IN ('".implode("','",$akda)."')";
            $ak = $this->Common_model->getData('regular_bazar_games',$con,$feild,'','','','game asc','game');
            
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
            foreach($ak as $k){
                $j = loadDigitBasedJodi($k['game'],'left');
                $p = getAllPattiByDigit($k['game']);
                $patti = $this->Common_model->getData('regular_bazar_games',$conPatti." AND game IN ('".implode("','",$p)."')",'SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer','','','','game asc','game');
                $arrPatti[$k['game']] = $patti;
                foreach($patti as $e){
                    array_push($newArrPatti,$e);
                }
                $jodi = $this->Common_model->getData('regular_bazar_games',$con1." AND game IN ('".implode("','",$j)."')",'SUM(point) as point,game','','','','game asc','game');
                $jodiSum += array_sum(array_column($jodi, 'point'));
                $arr[$k['game']] = $jodi;
            }
            if($type=="Open"){
                $totalBet = $sum+$pattiBet['point'];
            }else{
                $totalBet = $sum+$jodiSum+$pattiBet['point'];
            }
            
            $profit =  (($totalBet/100)*$per['profit']);
            if($type=="Open"){
                $i = 0;
                $jArr = [];
                $pArr = [];
                foreach($newArrPatti as $n){
                    $akSum = 0;
                    $digits = str_split((string) abs($n['game']));
                    foreach ($digits as $digit) {
                        $akSum += $digit;
                    }
                    if($akSum>9){
                        $myAk = str_split($akSum);
                        $akSum = $myAk[1];
                    }
                    $panaType = checkPanaType($n['game']);
                    if($panaType === 'SP'){
                        $parrRate = 140;
                    }else if($panaType === 'DP'){
                        $parrRate = 280;
                    }else if($panaType === 'TP'){
                        $parrRate = 800;
                    }
                    $m['customer'] = $ak[$akSum]['customer']+$n['customer'];
                    $m['game']=$n['game'];
                    $m['akdaPoint'] = $ak[$akSum]['point'];
                    $m['pattiPoint'] = $n['point'];
                    $m['win'] = ($n['point']*$parrRate)+($ak[$akSum]['point']*9.7);
                    $m['prof'] = $totalBet-$m['win'];
                    array_push($pArr,$m);
                    $i++;
                }
                $result=array_diff($allPatti,array_column($pArr, 'game'));
                if(!empty($result)){
                    foreach($result as $balPatti){
                        $panaType = checkPanaType($balPatti);
                        if($panaType === 'SP'){
                            $parrRate = 140;
                        }else if($panaType === 'DP'){
                            $parrRate = 280;
                        }else if($panaType === 'TP'){
                            $parrRate = 800;
                        }
                        $akSum = 0;
                        $digits = str_split((string) abs($balPatti));
                        
                        foreach ($digits as $digit) {
                            $akSum += $digit;
                        }

                        if($akSum>9){
                            $myAk = str_split($akSum);
                            $akSum = $myAk[1];
                        }
                        
                        $m['customer'] = $ak[$akSum]['customer'];
                        $m['pattiPoint'] = 0;
                        $m['game'] = $balPatti;
                        // $jd = $arr[$akda][$akSum];
                        $m['akdaPoint'] = $ak[$akSum]['point'];
                        $m['win'] = ($ak[$akSum]['point']*9.7);
                        $m['prof'] = $totalBet-$m['win'];
                        array_push($pArr,$m);
                    }
                }
                $key = 'prof';
                usort($pArr, function ($a, $b) use ($key) {
                    return $b[$key] <=> $a[$key];
                });
                // $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
                if(!$resultPatti){
                    $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                }
                // print_r($pArr);
                die(json_encode($resultPatti));
                // return $resultPatti;
            }else{
                $resultPana = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'"','','','','One','','');
                $akda = $resultPana['jodi'][0];
                $i = 0;
                $jArr = [];
                $pArr = [];
                for($s=0;$s<10;$s++){
                    foreach($arrPatti[$s] as $m){
                        $panaType = checkPanaType($m['game']);
                        if($panaType === 'SP'){
                            $parrRate = 140;
                        }else if($panaType === 'DP'){
                            $parrRate = 280;
                        }else if($panaType === 'TP'){
                            $parrRate = 800;
                        }
                        $jd = $arr[$akda][$s];
                        $m['customer'] = $ak[$s]['customer']+$m['customer'];
                        $m['jodiPoint'] = $jd['point'];
                        $m['akdaPoint'] = $ak[$s]['point'];
                        $m['win'] = ($m['point']*$parrRate)+($ak[$s]['point']*9.7)+($jd['point']*97);
                        $m['prof'] = $totalBet-$m['win'];
                        array_push($pArr,$m);
                    }
                }
                
                $result=array_diff($allPatti,array_column($pArr, 'game'));
                if(!empty($result)){
                    foreach($result as $balPatti){
                        $panaType = checkPanaType($balPatti);
                        if($panaType === 'SP'){
                            $parrRate = 140;
                        }else if($panaType === 'DP'){
                            $parrRate = 280;
                        }else if($panaType === 'TP'){
                            $parrRate = 800;
                        }
                        $akSum = 0;
                        $digits = str_split((string) abs($balPatti));
                        
                        foreach ($digits as $digit) {
                            $akSum += $digit;
                        }
                        if($akSum>9){
                            $myAk = str_split($akSum);
                            $akSum = $myAk[1];
                        }
                        $m['point'] = 0;
                        
                        $m['customer'] = $ak[$akSum]['customer'];
                        $m['game'] = $balPatti;
                        $jd = $arr[$akda][$akSum];
                        $m['jodiPoint'] = $jd['point'];
                        $m['akdaPoint'] = $ak[$akSum]['point'];
                        $m['win'] = ($m['point']*$parrRate)+($ak[$akSum]['point']*9.7)+($jd['point']*97);
                        $m['prof'] = $totalBet-$m['win'];
                        array_push($pArr,$m);
                    }
                }
                $key = 'prof';
                usort($pArr, function ($a, $b) use ($key) {
                    return $b[$key] <=> $a[$key];
                });
                
                $resultPatti = [];
                $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
                // $resultPatti1 = $this->findClosestArray($pArr, 'prof', $profit);
                $panaClose = checkPanaType($resultPatti['game']);
                $panaOpen = checkPanaType($resultPana['open']);
                if($panaOpen === 'TP' || $panaOpen === 'DP' || $panaClose === 'TP'){
                    $nArr = [];
                    foreach($pArr as $arr){
                        $cPana = checkPanaType($arr['game']);
                        if($cPana === 'SP'){
                            array_push($nArr,$arr);
                        }
                    }
                    $resultPatti = $this->findProfitableArray($nArr, 'prof', $profit);
                    if(!$resultPatti){
                        $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                    }
                }
                die(json_encode($resultPatti));
                // return $resultPatti;
            }
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
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

    public function findProfitableArrayTest($multiArray, $columnKey, $targetValue) {
        $profitableArray = [];
        $cust = 0;
        foreach ($multiArray as $array) {
            if (isset($array[$columnKey])) {
                if ($array[$columnKey] > $targetValue) {
                    $panaType = checkPanaType($array['game']);
                    if(($cust < $array['winCustTotal'] || $cust == 0) && $panaType != 'TP'){
                        $cust = $array['winCustTotal'];
                        // array_push($profitableArray,$array);
                        $profitableArray = $array;
                    }
                }
            }
        }
        return $profitableArray;
    }

    public function sendMarketData($bazarId,$bazarType){
        $this->load->model('Common_model');
        $market = $this->Common_model->getData('regular_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
        $con = " WHERE bazar_name='".$bazarId."' AND result_date='".date('Y-m-d')."'";
        
        // $con = " WHERE bazar_name='".$bazarId."' AND result_date='".date('Y/m/d',strtotime("-1 days"))."'";
        $con1 = $con;
        if($bazarType=='Open'){
            $con .= " AND game_type='Open'";
        }else{
            $bName = $this->Common_model->getData('regular_bazar_result',$con,$feild,'','','One','','');
            $j = loadDigitBasedJodi($bName['jodi'][0],'left');
            $con .= " AND game_type!='Open'";
        }
        $con2 = $con;
        $feild = "SUM(point) as point, game";
        if($bazarId==9){
            $timeBazar = $this->Common_model->getData('regular_bazar_games',$con,'SUM(point) as point','','','One','','');
            if($timeBazar['point'] > 20000){
                $market['cutSp'] = 75;
                $market['cutDp'] = 150;
            }else if($timeBazar['point'] < 20000 && $timeBazar['point'] > 20000){
                $market['cutSp'] = 200;
                $market['cutDp'] = 100;
            }else if($timeBazar['point'] < 30000){
                $market['cutSp'] = 150;
                $market['cutDp'] = 300;
            }
        }
        $akda=getVariationPatti('SingleAkda');
        $con .= " AND game IN ('".implode("','",$akda)."')";
        $ak = $this->Common_model->getData('regular_bazar_games',$con,$feild,'','','','game asc','game');
        $spPatti = getPattiAkdaWise("SinglePatti");
        $dpPatti = getPattiAkdaWise("DoublePatti");
        
        $nAk = [];
        $akBody = "";
        $spBody = "";
        $dpBody = "";
        $tpBody = "";
        $newArrPatti = [];
        foreach($ak as $k){

            if($k['game']==0){
                $p = $spPatti['10'];
                $dp = $dpPatti['10'];
            }else{
                $p = $spPatti[$k['game']];
                $dp = $dpPatti[$k['game']];
            }
            $sql = 'SELECT SUM(point) as point,game FROM regular_bazar_games '.$con2.' AND game IN ("'.implode('","',$p).'") GROUP BY game HAVING SUM(point) > '.$market['cutSp'].' ORDER BY game asc';
            $res = $this->db->query($sql);
			$row = $res->result_array(); 
            
            $sql1 = 'SELECT SUM(point) as point,game FROM regular_bazar_games '.$con2.' AND game IN ("'.implode('","',$dp).'") GROUP BY game HAVING SUM(point) > '.$market['cutDp'].' ORDER BY game asc';
            $res1 = $this->db->query($sql1);
			$row1 = $res1->result_array(); 
            if($row){
                foreach($row as $t){
                    if(($t['point']-$market['cutSp']) > 10 && !in_array($bazarId,[8,11,19])){
                        $spBody .= $t['game']."=".($t['point']-$market['cutSp'])."\n";
                    }
                }
            }
            if($row1){
                foreach($row1 as $e){
                    if(($t['point']-$market['cutDp']) > 10 && !in_array($bazarId,[8,11,19])){
                        $dpBody .= $e['game']."=".($e['point']-$market['cutDp'])."\n";
                    }
                }
            }
            
            if($bazarType=='Open'){
                $j = loadDigitBasedJodi($k['game'],'left');
                $jodi = $this->Common_model->getData('regular_bazar_games',$con1." AND game IN ('".implode("','",$j)."')",'SUM(point) as point','','','One','','');
                $jodiPer = ($jodi['point'] / 100) * ($market['cutJodi']);
                $akdaPer = ($k['point'] / 100) * ($market['cutAk']);
                $nAk[$k['game']] = $akdaPer + $jodiPer;
                $akBody .= $k['game']."=".round($nAk[$k['game']])."\n";
            }else{
                $jodi = $this->Common_model->getData('regular_bazar_games',$con1." AND game='".$j[$k['game']]."'",'SUM(point) as point','','','One','','');
                $jodiPer = ($jodi['point'] / 100) * ($market['cutJodi']);
                $akdaPer = ($k['point'] / 100) * ($market['cutAk']);
                $nAk[$k['game']] = $akdaPer + ($jodiPer*10);
                $akBody .= $k['game']."=".round($nAk[$k['game']])."\n";
            }
        }
        $sql2 = 'SELECT SUM(point) as point,game FROM regular_bazar_games '.$con2.' AND game IN ("000","111","222","333","444","555","666","777","888","999") GROUP BY game HAVING SUM(point) > '.$market['cutTp'].' ORDER BY game asc';
        $res2 = $this->db->query($sql2);
        $row2 = $res2->result_array(); 
        if($row2){
            foreach($row2 as $l){
                $tpBody .= $l['game']."=".$l['point']."\n";
            }
        }
        $body = $akBody."\n".$spBody."\n".$dpBody."\n".$tpBody;
        // $res = $this->sendWhatsApp($body);
        print_r($body);die();
        // print_r($res);
        die(json_encode($res));
    }



    public function sendWhatsApp($body){      
        $params=array(
            'token' => 'e1kljqgyj5xj9xu8',
            'to' => '9730291547',
            'body' => $body
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance106460/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function getResultByPercentageForTest($bazarId,$type){
        if(isset($bazarId) && isset($type)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('regular_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            $con = " WHERE result_date='".date('Y-m-d')."' AND bazar_name='".$bazarId."'";
            // $con = " WHERE result_date='".date('Y-m-d',strtotime("-1 days"))."' AND bazar_name='".$bazarId."'";
            $allPatti = getPana();
            $akda=getVariationPatti('SingleAkda');
            $con1 = $con;
            if($type=="Open"){
                $con .= " AND game_type='Open'";
            }else{
                $con .= " AND game_type!='Open'";
            }
            $conPatti = $con;
            $feild = "SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('regular_bazar_games',$con." AND (game > 99 OR game='000')","SUM(point) as point,COUNT(DISTINCT customer_id) as customer",'','','One','','');
            $con .= " AND game IN ('".implode("','",$akda)."')";
            $ak = $this->Common_model->getData('regular_bazar_games',$con,$feild,'','','','game asc','game');
            
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
            foreach($ak as $k){
                $j = loadDigitBasedJodi($k['game'],'left');
                $p = getAllPattiByDigit($k['game']);
                $patti = $this->Common_model->getData('regular_bazar_games',$conPatti." AND game IN ('".implode("','",$p)."')",'SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer','','','','game asc','game');
                $arrPatti[$k['game']] = $patti;
                foreach($patti as $e){
                    array_push($newArrPatti,$e);
                }
                $jodi = $this->Common_model->getData('regular_bazar_games',$con1." AND game IN ('".implode("','",$j)."')",'SUM(point) as point,game','','','','game asc','game');
                $jodiSum += array_sum(array_column($jodi, 'point'));
                $arr[$k['game']] = $jodi;
            }
            if($type=="Open"){
                $totalBet = $sum+$pattiBet['point'];
            }else{
                $totalBet = $sum+$jodiSum+$pattiBet['point'];
            }
            
            $profit =  (($totalBet/100)*$per['profit']);
            if($type=="Open"){
                $i = 0;
                $jArr = [];
                $pArr = [];
                foreach($newArrPatti as $n){
                    $akSum = 0;
                    $digits = str_split((string) abs($n['game']));
                    foreach ($digits as $digit) {
                        $akSum += $digit;
                    }
                    if($akSum>9){
                        $myAk = str_split($akSum);
                        $akSum = $myAk[1];
                    }
                    $panaType = checkPanaType($n['game']);
                    if($panaType === 'SP'){
                        $parrRate = 140;
                    }else if($panaType === 'DP'){
                        $parrRate = 280;
                    }else if($panaType === 'TP'){
                        $parrRate = 800;
                    }
                    $m['customer'] = $ak[$akSum]['customer']+$n['customer'];
                    $m['game']=$n['game'];
                    $m['akdaPoint'] = $ak[$akSum]['point'];
                    $m['pattiPoint'] = $n['point'];
                    $m['win'] = ($n['point']*$parrRate)+($ak[$akSum]['point']*9.7);
                    $m['prof'] = $totalBet-$m['win'];
                    array_push($pArr,$m);
                    $i++;
                }
                $result=array_diff($allPatti,array_column($pArr, 'game'));
                if(!empty($result)){
                    foreach($result as $balPatti){
                        $panaType = checkPanaType($balPatti);
                        if($panaType === 'SP'){
                            $parrRate = 140;
                        }else if($panaType === 'DP'){
                            $parrRate = 280;
                        }else if($panaType === 'TP'){
                            $parrRate = 800;
                        }
                        $akSum = 0;
                        $digits = str_split((string) abs($balPatti));
                        
                        foreach ($digits as $digit) {
                            $akSum += $digit;
                        }

                        if($akSum>9){
                            $myAk = str_split($akSum);
                            $akSum = $myAk[1];
                        }
                        
                        $m['customer'] = $ak[$akSum]['customer'];
                        $m['pattiPoint'] = 0;
                        $m['game'] = $balPatti;
                        // $jd = $arr[$akda][$akSum];
                        $m['akdaPoint'] = $ak[$akSum]['point'];
                        $m['win'] = ($ak[$akSum]['point']*9.7);
                        $m['prof'] = $totalBet-$m['win'];
                        array_push($pArr,$m);
                    }
                }
                $key = 'prof';
                usort($pArr, function ($a, $b) use ($key) {
                    return $b[$key] <=> $a[$key];
                });
                // $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
                if(!$resultPatti){
                    $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                }
                // print_r($pArr);
                die(json_encode($resultPatti));
                // return $resultPatti;
            }else{
                $resultPana = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'"','','','','One','','');
                // $resultPana = $this->Common_model->getData('regular_bazar_result',' WHERE bazar_name="'.$bazarId.'" AND result_date="2025-04-03"','','','','One','','');
                $akda = $resultPana['jodi'][0];
                
                $nCon = ' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'" AND game_type="Open" AND status="W"';
                $custList = $this->Common_model->getData('regular_bazar_games',$nCon,'DISTINCT customer_id','','','','','');
                $nConC .=' WHERE bazar_name="'.$bazarId.'" AND result_date="'.date('Y-m-d').'" AND game_type!="Open" AND game IN ("0","1","2","3","4","5","6","7","8","9") OR game > 99 AND customer_id NOT IN ("'.implode('","',array_column('customer_id',$custList)).'")';
                $akdaList = $this->Common_model->getData('regular_bazar_games',$nConC,'DISTINCT game','','','','','game');
                
                $i = 0;
                $jArr = [];
                $pArr = [];
                for($s=0;$s<10;$s++){
                    if(!in_array($s, array_column('game',$akdaList))){
                        foreach($arrPatti[$s] as $m){
                            $sangamType1 = $resultPana['open'].'-'.$s;
                            $sangamType2 = $akda.'-'.$m['game'];
                            $sangamType3 = $resultPana['open'].'-'.$m['game'];

                            if(!in_array($sangamType1, array_column('game',$akdaList)) && !in_array($sangamType2, array_column('game',$akdaList)) && !in_array($sangamType3, array_column('game',$akdaList))){
                                $panaType = checkPanaType($m['game']);
                                if($panaType === 'SP'){
                                    $parrRate = 140;
                                }else if($panaType === 'DP'){
                                    $parrRate = 280;
                                }else if($panaType === 'TP'){
                                    $parrRate = 800;
                                }
                                $jd = $arr[$akda][$s];
                                $m['customer'] = $ak[$s]['customer']+$m['customer'];
                                $m['jodiPoint'] = $jd['point'];
                                $m['akdaPoint'] = $ak[$s]['point'];
                                $m['win'] = ($m['point']*$parrRate)+($ak[$s]['point']*9.7)+($jd['point']*97);
                                $m['prof'] = $totalBet-$m['win'];
                                array_push($pArr,$m);
                            }
                        }
                    }
                }
                $result=array_diff($allPatti,array_column($pArr, 'game'));
                if(!empty($result)){
                    foreach($result as $balPatti){
                        $panaType = checkPanaType($balPatti);
                        if($panaType === 'SP'){
                            $parrRate = 140;
                        }else if($panaType === 'DP'){
                            $parrRate = 280;
                        }else if($panaType === 'TP'){
                            $parrRate = 800;
                        }
                        $akSum = 0;
                        $digits = str_split((string) abs($balPatti));
                        
                        foreach ($digits as $digit) {
                            $akSum += $digit;
                        }
                        if($akSum>9){
                            $myAk = str_split($akSum);
                            $akSum = $myAk[1];
                        }
                        $m['point'] = 0;
                        
                        $m['customer'] = $ak[$akSum]['customer'];
                        $m['game'] = $balPatti;
                        $jd = $arr[$akda][$akSum];
                        $m['jodiPoint'] = $jd['point'];
                        $m['akdaPoint'] = $ak[$akSum]['point'];
                        $m['win'] = ($m['point']*$parrRate)+($ak[$akSum]['point']*9.7)+($jd['point']*97);
                        $m['prof'] = $totalBet-$m['win'];
                        array_push($pArr,$m);
                    }
                }
                $key = 'prof';
                usort($pArr, function ($a, $b) use ($key) {
                    return $b[$key] <=> $a[$key];
                });
                
                $resultPatti = [];
                $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
                // $resultPatti1 = $this->findClosestArray($pArr, 'prof', $profit);
                $panaClose = checkPanaType($resultPatti['game']);
                $panaOpen = checkPanaType($resultPana['open']);
                if($panaOpen === 'TP' || $panaOpen === 'DP' || $panaClose === 'TP'){
                    $nArr = [];
                    foreach($pArr as $arr){
                        $cPana = checkPanaType($arr['game']);
                        if($cPana === 'SP'){
                            array_push($nArr,$arr);
                        }
                    }
                    $resultPatti = $this->findProfitableArray($nArr, 'prof', $profit);
                    if(!$resultPatti){
                        $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                    }
                }
                die(json_encode($resultPatti));
                // return $resultPatti;
            }
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
    }

    public function riskPlayer($bazarId,$type){
        if(isset($bazarId) && isset($type)){
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('regular_bazar',' WHERE id="'.$bazarId.'"','','','','One','','');
            
            $sql = "SELECT 
                sub.gameArray,
                GROUP_CONCAT(sub.customer_id) AS customers,
                GROUP_CONCAT(sub.customer_name) AS customer_names,
                COUNT(*) AS total_customers,
                SUM(sub.total_bets) AS total_bets,
                GROUP_CONCAT(sub.bhav) AS bhav
            FROM (
                SELECT 
                    g.customer_id,
                    c.name AS customer_name,
                    COUNT(g.game) AS total_bets,
                    GROUP_CONCAT(DISTINCT g.game ORDER BY g.game) AS gameArray,
                	IFNULL(b.rate, 0) as bhav
                FROM 
                    regular_bazar_games g
                LEFT JOIN 
                    customer c ON c.customer_id = g.customer_id
                LEFT JOIN 
                    customer_rate b ON b.customer_id = g.customer_id
                WHERE 
                    g.result_date = '" . date('Y-m-d') . "'
                    AND g.bazar_name = '" . $bazarId . "'
                    AND g.game_type = '" . $type . "'
                    AND g.game IN ('0','1','2','3','4','5','6','7','8','9')
                GROUP BY 
                    g.customer_id
                HAVING 
                    COUNT(DISTINCT g.game) > 6
            ) AS sub
            GROUP BY 
                sub.gameArray
            ";

            $req = $this->db->query($sql);
            $rows = $req->result_array();
            
            $SP=getVariationPatti('SinglePatti');
            $sqlP = "SELECT 
                g.customer_id,
                COUNT(g.game) AS totalBets,
                GROUP_CONCAT(DISTINCT g.game ORDER BY g.game) AS gameArray,
                IFNULL(b.rate, 0) as bhav
            FROM 
                regular_bazar_games g
            LEFT JOIN 
                customer_rate b ON b.customer_id = g.customer_id
            WHERE 
                g.result_date = '" . date('Y-m-d') . "'
                AND g.bazar_name = '" . $bazarId . "'
                AND g.game_type = '" . $type . "'
                AND g.game NOT IN ('0','1','2','3','4','5','6','7','8','9')
            GROUP BY 
                g.customer_id
            HAVING 
                COUNT(DISTINCT g.game) > 30";

            $reqP = $this->db->query($sqlP);
            $rowsP = $reqP->result_array();
            
            $arr = [$per['bazar_name'],$type,date('Y-m-d')];

            $message = "*Game Report - {$arr[0]} ({$arr[1]}) - {$arr[2]}*\n\n";
            $message .= "*Sr.* || *Customer ID* || *Bhav*  || *Total Bets* || *Games*\n";
            $message .= str_repeat("-", 55) . "\n";
            $i = 1;
            $k = 0;
            $arrayInsert = [];
            foreach ($rows as $row) {
                $a = numberToAlphabet($i);
                $message .= "{$a})\n";
                $cust = explode(",",$row['customers']);
                $custN = explode(",",$row['customer_names']);
                $bhav = explode(",",$row['bhav']);
                $t = 0;
                foreach($cust as $id){
                    $q = $k+1;
                    $message .= "Sr : {$q}) Customer Id : {$id}  Customer Name : {$custN[$t]} Bhav : {$bhav[$t]}\n";
                    $k++;
                    $t++;
                    
                    $arr1 = ['0','1','2','3','4','5','6','7','8','9'];
                    $arr2 = explode(",", $row['gameArray']);

                    // Check if all values from arr1 exist in arr2
                    $allExist = array_diff($arr1, $arr2);

                    if ($allExist) {
                        $arrayInsert[] = [
                            'bazar_name' => $bazarId,
                            'game_type' => $type,
                            'result_date' => date('Y-m-d'),
                            'customer_id' => $id,
                            'games' => json_encode($row['gameArray'])
                        ];
                    }
                }
                $message .= " || Total Bets {$row['totalBets']} || Games : {$row['gameArray']}\n";
                $i++;
            }
            $message .= "-------Patti (30) ----------\n";
            foreach ($rowsP as $row) {
                $message .= "Sr : {$i}) || Customer Id : {$row['customer_id']} || Bhav : {$row['bhav']} || Total Bets {$row['totalBets']}\n";
                $i++;
            }
            if(COUNT($arrayInsert) > 0){
                $this->db->insert_batch('riskcalculator', $arrayInsert);
            }
            if ($this->db->affected_rows() > 0) {
                $sendTo = ['9730291547'];
                foreach($sendTo as $to){
                    // $res = sendWhatsApp($message,$to);
                }
                if ($res === "Enter valid Mobile No" || $res === "Invalid Number" || $res === `Invalid route. Route can be from {T,A,SID,PD,'I'}`) {
                    die(json_encode(['status'=>401,'message'=>'Mobile/Email Not Found']));
                } else {
                    die(json_encode(['status'=>200,'message'=>'Detail Send','message'=>$res]));
                }
            } else {
                die(json_encode(['status'=>401,'message'=>'Record Not Saved']));
            }
		}else{
			$arr=[
				'status'=>401,
				'massage'=>'Please Provide Valid Data!'
			];
		}
		die(json_encode($arr));
    }

    public function analizeRiskPlayer(){
        $this->load->model('Common_model');
        $per = $this->Common_model->getData('riskcalculator',' LEFT JOIN customer_rate ON riskcalculator.customer_id=customer_rate.customer_id GROUP BY riskcalculator.customer_id HAVING COUNT(riskcalculator.customer_id) > 1','COUNT(riskcalculator.customer_id) as count,riskcalculator.customer_id,customer_rate.rate,customer_rate.id as rateId','','','','','');
        if($per){
            foreach($per as $k=>$v){
                if($v['rate'] == '' || $v['rate'] == NULL || $v['rate'] == 0){
                    $partner = $this->Common_model->getData('customer',' WHERE customer_id="'.$v['customer_id'].'"','','','','One','','');
                    $addRate = [];
                    if(($partner['winning'] - $partner['point']) > 1000){
                        if($v['rate'] == 0 && $v['rateId'] > 0){
                            $addRate['rate'] = 10;
                            $gameaddid = AddUpdateTable('customer_rate', 'id', $v['rateId'], $addRate);
                        }else{
                            $addRate['customer_id'] = $v['customer_id'];
                            $addRate['partner_id'] = $partner['partner_id'];
                            $addRate['rate'] = 10;
                            $addRate['created'] = date('Y-m-d H:i:s');
                            $addRate['status'] = 'A';
                            $gameaddid = AddUpdateTable('customer_rate', '', '', $addRate);
                        }
                        $addRisk['status'] = 'I';
                        $gameaddid = AddUpdateTable('riskcalculator', 'customer_id', $v['customer_id'], $addRisk);
                    }
                }
            }
            die(json_encode(['status'=>200,'message'=>'Rate Managed Successfully']));
        }else{
            die(json_encode(['status'=>401,'message'=>'Nothing to update']));
        }
    }

    public function setCustomersGGR(){
        $this->load->model('Common_model');
        $con = " WHERE result_date='2025-08-11' GROUP BY customer_id";
        // $con = " WHERE result_date='".date('Y-m-d',strtotime("-1 days"))."' GROUP BY customer_id";
        $feild = "SUM(point_in_rs) as point, SUM(winning_in_rs) as winning, customer_id,partner_id";
        $regular = $this->Common_model->getData('regular_bazar_games',$con,$feild,'','','','','');
        $starline = $this->Common_model->getData('starline_bazar_game',$con,$feild,'','','','','');
        $kingBazar = $this->Common_model->getData('king_bazar_game',$con,$feild,'','','','','');
        $worli = $this->Common_model->getData('warli_users_game',$con,$feild,'','','','','');
        $crazyWheel = $this->Common_model->getData('crezymatkagame',$con,$feild,'','','','','');
        $allData = array_merge($regular,$starline,$kingBazar,$worli,$crazyWheel);

        $mergedData = [];
        foreach ($allData as $row) {
            $id = $row['customer_id']; // Use the correct key for your unique identifier
            if (isset($mergedData[$id])) {
                // Merge logic: sum numeric fields, or merge as needed
                foreach ($row as $key => $value) {
                    if ($key !== 'id') {
                        if (isset($mergedData[$id][$key]) && in_array($key, ['point', 'winning'])) {
                            $mergedData[$id][$key] += $value;
                        } else {
                            $mergedData[$id][$key] = $value;
                        }
                    }
                }
            } else {
                $mergedData[$id] = $row;
            }
        }
        
        $batchData = [];

        foreach ($mergedData as $data) {
            $batchData[] = [
                'customer_id' => $data['customer_id'],
                'partner_id'  => $data['partner_id'],
                'point'       => $data['point'],
                'winning'     => $data['winning']
            ];
        }

        // Convert to SQL insert
        $values = [];
        $i = 0;
        foreach ($batchData as $row) {
            $values[] = "('{$row['customer_id']}', '{$row['partner_id']}', {$row['point']}, {$row['winning']})";
            $i++;
            if($i==100){
                $sql = "
                    INSERT INTO customer (customer_id, partner_id, point, winning)
                    VALUES " . implode(',', $values) . "
                    ON DUPLICATE KEY UPDATE
                        point = point + VALUES(point),
                        winning = winning + VALUES(winning)
                ";
                $this->db->query($sql);
                $i=0;
                $values = [];

            }
        }
        if(!empty($values)){
            $sql = "
                INSERT INTO customer (customer_id, partner_id, point, winning)
                VALUES " . implode(',', $values) . "
                ON DUPLICATE KEY UPDATE
                    point = point + VALUES(point),
                    winning = winning + VALUES(winning)
            ";
            $this->db->query($sql);
        }

        die(json_encode(['status'=>200,'message'=>'GGR Updated Successfully']));
    }

    public function updateCustomerDetail(){
        $this->load->model('Common_model');
        $customers = $this->Common_model->getData('customer',' WHERE mobile="0"','id,customer_id,partner_id','','','','','');
        $client = $this->Common_model->getData('client',' WHERE status="A"','id,client_token','','','','','');
        $keyValuePairs = [];
        foreach ($client as $row) {
            $keyValuePairs[$row['id']] = $row['client_token'];
        }
        foreach($customers as $c){
            $url = getClientUserDetailURL($keyValuePairs[$c['partner_id']]);
            $d = ["_id"=>$c['customer_id']];
            $data=requestForUserDetail($url,json_encode($d));
            $data = json_decode($data);
            if($data->success != true && $data->Code != 200){
                continue;
            }else{
                $user = $data->data;
                $update['name'] = $user->name;
                $update['mobile'] = $user->mobile;
                $update['email'] = $user->email;
                $update['app'] = $user->app;
                $update['state'] = $user->state;
                $update['status'] = 'A';
                $update['city'] = $user->city;
                $update['signup_date'] = $user->signup_date;
                $d = AddUpdateTable('customer', 'customer_id', $c['customer_id'], $update);
            }
        }
        die(json_encode(['status'=>200,'message'=>'Customer Detail Updated Successfully']));
    }
    
    public function checkRiskPlayers(){
        $this->load->model('Common_model');
        $rateCheck = $this->Common_model->getData('customer_rate',' LEFT JOIN customer on customer_rate.customer_id=customer.customer_id WHERE customer_rate.rate > "0" AND (customer.point - customer.winning) > 1000','customer_rate.id as rId','','','','','');
        echo '<pre>';
        print_r($rateCheck);
        die();
        foreach($rateCheck as $c){
            $update['rate'] = 0;
            $d = AddUpdateTable('customer_rate', 'id', $c['rId'], $update);
        }
        die(json_encode(['status'=>200,'message'=>'Customer Rate Updated Successfully']));
    }
}