<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');


require APPPATH . '/libraries/BaseController.php';



/**

 * Class : Manage_Starlinegames (Manage_Starlinegames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class StarlineMarket extends BaseController
{



    function __construct()
    {

        parent::__construct();
        if (isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])) {
            $_GET['id'] = str_replace(" ", "+", $_GET['id']);
            $_SESSION['token'] = $_GET['token'];
            $_SESSION['app'] = $_GET['app'];
            $this->load->model('Common_model');
            $con = ' WHERE status="A" AND client_token="' . $_GET['token'] . '"';
            $partner = $this->Common_model->getData('client', $con, 'id,end_point_url', '', '', 'One', '', '');
            if (!empty($partner)) {
                $_SESSION['end_point_url'] = $partner['end_point_url'];

                $data = requestForClient($partner['end_point_url'], ['id' => $_GET['id'], 'code' => '300']);
                $res = json_decode($data);
                if ($res->Code == 200) {
                    $_SESSION['partner'] = $partner;
                    $_SESSION['balance'] = $res->data[0];
                    $_SESSION['userName'] = $res->data[1];
                    $_SESSION['customer_id'] = $_GET['id'];
                }
            }
        }
        // if(! $this->session->userdata('adid'))

        // redirect('login');

    }





    public function index()
    {
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        $data['starlinegame'] = $this->Common_model->getData('starline_bazar', $con, 'id,bazar_name,icon', '', '', '', '');
        $data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];

        // if($_GET['token']=='25da54332a349da64992c22f905000e7'){
        //     $con6=' WHERE customer_id="'.$_GET['id'].'"';
        //     $user = $this->Common_model->getData('customer',$con6,'id,customer_id','','','One','','');
        //     if(empty($user)){
        //         $url='https://laxmi999.com/index.php/psapi/get-user-detail?id='.$_GET['id'];
        //         $dt=getUserDetail($url);
        //         $res = json_decode($dt);
        //         if($res->Code==200){
        //             $d=$res->data;
        //             $addUsr['partner_id']=2;
        //             $addUsr['customer_id']=$_GET['id'];
        //             $addUsr['name']=$d->name;
        //             $addUsr['mobile']=$d->mobile;
        //             $addUsr['state']=$d->state;
        //             $addUsr['city']=$d->city;
        //             $addUsr['email']=$d->email;
        //             $addUsr['signup_date']=$d->signup_date;
        //             $addUsr['app']=$d->app;
        //             $addUsr['status']='A';
        //             $addUsr['created']=date('Y-m-d');
        //             AddUpdateTable('customer', '', '', $addUsr);
        //         }
        //     }
        // }
        if ($_GET['token'] && $_GET['id']) {
            addUserById($_GET['token'], $_GET['id']);
        }
        $this->load->view('user/starlineGameList', $data);
    }

    public function GameTimeList($id, $name)
    {
        $this->load->model('Common_model');
        $con = ' INNER JOIN starline_bazar ON starline_bazar.id=starline_bazar_time.bazar_name WHERE starline_bazar_time.bazar_name="' . $id . '" AND starline_bazar_time.status="A"';
        $feilds = 'starline_bazar_time.id,starline_bazar_time.bazar_name,starline_bazar_time.time,starline_bazar_time.bazar_image,starline_bazar.icon1,starline_bazar.icon2,starline_bazar.text,starline_bazar.text1,starline_bazar.icon_status,starline_bazar.icon_status1';
        $data['starlineTime'] = $this->Common_model->getData('starline_bazar_time', $con, $feilds, '', '', '', 'sequence ASC', '');
        // echo '<pre>';
        // print_r($data);
        // die();
        $data['param']['bazar_id'] = $id;
        $time = time() + 2 * 60;
        $con2 = " WHERE market_type='Starline' AND bazar_name='" . $id . "'";
        $hld = $this->Common_model->getData('market_holidays', $con2, 'date', '', '', '', '', '');
        $arrN = [];
        foreach ($hld as $val) {
            array_push($arrN, $val['date']);
        }
        $i = 0;
        foreach ($data['starlineTime'] as $dt) {
            $open = checkTime($dt['time']);
            if ($open > $time) {
                if (!in_array(date('Y-m-d'), $arrN)) {
                    $ad = date('Y-m-d') . " " . $dt['time'];
                } else {
                    $ad = date('Y-m-d', strtotime("+1day")) . " " . $dt['time'];
                }
            } else {
                if (!in_array(date('Y-m-d', strtotime("+1day")), $arrN)) {
                    $ad = date('Y-m-d', strtotime("+1day")) . " " . $dt['time'];
                } else {
                    $ad = date('Y-m-d', strtotime("+2day")) . " " . $dt['time'];
                }
            }
            $data['starlineTime'][$i]['time'] = $ad;
            $i++;
        }

        $data['starlineName'] = $name;
        $data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        $this->load->view('user/starlineTimeList', $data);
    }

    /*------------- Game List -----------------*/
    public function StarlineGameTypeList($id, $result, $bazar)
    {
        $this->load->model('ManageStarlinegames_Model');
        $con = 'WHERE starline_bazar_time.id="' . $id . '"';
        $this->data['gameDetail'] = $this->ManageStarlinegames_Model->getstarlinegame($con, 'one');
        $this->load->model('Common_model');
        $con1 = ' WHERE status="A"';
        $this->data['gameType'] = $this->Common_model->getData('starline_game_type', $con1, 'id,game_name,icon', '', '', '', 'priority ASC', '');
        $con2 = " WHERE result_date BETWEEN '" . date('Y-m-d', strtotime('-7 day')) . "' AND '" . date('Y-m-d') . "' AND bazar_name='" . $bazar . "' AND time='" . $id . "'";
        $this->data['marketResultOld'] = $this->Common_model->getData('starline_bazar_result', $con2, 'result_date,result_patti,result_akda', '', '', '', '', '');
        // echo '<pre>';
        // print_r($this->data['marketResultOld']);
        // die();
        $this->data['param']['bazar_id'] = $id;
        $this->data['param']['bazar'] = $bazar;
        $this->data['result'] = $result;
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        // $this->load->view('user/starlineGameTypeList', $this->data);
        $this->load->view('user/starlineGameTypeList1', $this->data);
    }

    /*------------- Game Type Bet Pages -----------------*/
    public function betsOnGame($bazar_id, $game_id, $time)
    {

        $this->load->model('Common_model');
        $this->data['gameList'] = $this->Common_model->getData('matka_patti', '', '', '', '', '', 'patti asc', '');
        $con = " WHERE id='" . $bazar_id . "'";
        $marketDetail = $this->Common_model->getData('starline_bazar', $con, '', '', '', 'One', '', '');
        $con1 = " WHERE id='" . $game_id . "'";
        $gameDetail = $this->Common_model->getData('starline_game_type', $con1, '', '', '', 'One', '', '');
        $con2 = " WHERE id='" . $time . "'";
        $gameTime = $this->Common_model->getData('starline_bazar_time', $con2, '', '', '', 'One', '', '');

        $con3 = " INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id WHERE starline_bazar_result.announcer!='0' AND starline_bazar_result.bazar_name='" . $bazar_id . "' AND starline_bazar_result.time='" . $time . "'";
        $feilds = 'starline_bazar_result.result_date,starline_bazar_result.result_patti,starline_bazar_result.result_akda';
        $this->data['gameResult'] = $this->Common_model->getData('starline_bazar_result', $con3, $feilds, '4', '0', '', 'starline_bazar_result.result_date DESC', '');
        // echo '<pre>';
        // print_r($this->data['gameResult']);
        // die();
        $con4 = ' WHERE status="A"';
        $this->data['gameType'] = $this->Common_model->getData('starline_game_type', $con4, 'id,game_name', '', '', '', '', '');
        $this->data['param'] = [
            'bazar_id' => $bazar_id,
            'game_id' => $game_id,
            'time' => $time
        ];
        $this->data['marketTime'] = $gameTime;
        $this->data['marketDetail'] = $marketDetail;
        $this->data['gameDetail'] = $gameDetail;
        $time = time() + 1 * 60;
        $open = checkTime($gameTime['time']);
        if ($open > $time) {
            $this->data['date'] = date('d-m-Y');
        } else {
            $this->data['date'] = date('d-m-Y', strtotime("+ 1 day"));
        }
        $dateArray = [];

        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                if ($open > $time) {
                    $dateArray[] = [
                        'date' => date('d-m-Y', strtotime("+" . $i . "day"))
                    ];
                }
            } else {
                $dateArray[] = [
                    'date' => date('d-m-Y', strtotime("+" . $i . "day"))
                ];
            }
        }
        $this->data['status'] = array_slice($dateArray, 0, 3);

        $nArr = [];
        foreach ($dateArray as $val) {
            if (!in_array($val, $nArr)) {
                array_push($nArr, $val);
            }
        }
        $minMaxBet = getMinMaxBet($_GET['app']);
        $this->data['minBet'] = $minMaxBet['minBetLimit'];
        $this->data['maxBet'] = $minMaxBet['maxBetLimit'];

        $this->data['status'] = array_slice($nArr, 0, 3);
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];

        if ($game_id == 2 || $game_id == 4 || $game_id == 1 || $game_id == 3 || $game_id == 13 || $game_id == 14 || $game_id == 15 || $game_id == 16 || $game_id == 25 || $game_id == 26 || $game_id == 27 || $game_id == 28) {
            $this->load->view('user/chipsvarStar1', $this->data);
        } else if ($game_id == 5 || $game_id == 17 || $game_id == 30) {
            $this->load->view('user/tablecpStar', $this->data);
        } else if ($game_id == 7 || $game_id == 6 || $game_id == 12 || $game_id == 18 || $game_id == 19 || $game_id == 23 || $game_id == 31 || $game_id == 32 || $game_id == 35) {
            $this->load->view('user/tablemotorStar', $this->data);
        }
    }


    /*------------- Place Bet Pages -----------------*/

    public function PlaceBets()
    {
        if (isset($_POST['bazar_name']) && isset($_POST['game_name']) && isset($_POST['games']) && isset($_POST['result_date'])) {
            checkBetData($_post, 'Starline');
            $date = date('Y-m-d', strtotime($_POST['result_date']));
            // $time=strtotime(date('Y-m-d H:i:s')) + 1*60;
            if ($date < date('Y-m-d')) {
                $array = [
                    'message' => 'Invalid date!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            }
            $time = strtotime(date('Y-m-d H:i:s')) + 1 * 60;
            if (date('Y-m-d') == $date && strtotime(date('Y-m-d ' . $_POST['starTime'])) < $time) {
                die(json_encode(['message' => 'This Bazar Is Close For This day.', 'Code' => 203,]));
            }
            $this->load->model('Common_model');
            $bazarTime = $this->Common_model->getData('regular_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', '', '', '', 'One', '', '');
            if (!empty($_POST['games'])) {
                $client = $this->Common_model->getData('client', ' WHERE client_token="' . $_POST['tokenId'] . '"', 'end_point_url,id,currancy_rate', '', '', 'One', '', '');
                $data = requestForClient($client['end_point_url'], ['id' => $_POST['customer_id'], 'code' => '300']);
                $res = json_decode($data);
                if ($res->Code == '200' && $res->data[0] >= $_POST['totalA']) {
                    $_SESSION['balance'] = $res->data[0];
                    $cArr['arr'] = [];
                    $bName = $this->Common_model->getData('starline_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', 'bazar_name', '', '', 'One', '', '');
                    $gName = $this->Common_model->getData('starline_game_type', ' WHERE id="' . $_POST['game_name'] . '"', 'game_name', '', '', 'One', '', '');
                    $gameTime = $this->Common_model->getData('starline_bazar_time', ' WHERE id="' . $_POST['time'] . '"', 'time', '', '', 'One', '', '');
                    $arrBets['arr'] = [];
                    $betArrTransaction = [];
                    foreach ($_POST['games'] as $arr) {
                        if ($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']) {

                            $betArr = [];
                            $betArr['transaction_id'] = transactionID(16, 16) . time();
                            array_push($betArrTransaction, $betArr['transaction_id']);
                            $betArr['bazar_name'] = (int)$_POST['bazar_name'];
                            $betArr['time'] = (int)$_POST['time'];
                            $betArr['result_date'] = $date;
                            $betArr['point'] = (int)$arr['coin'];
                            $betArr['game'] = $arr['akda'];

                            if ($arr['gameName'] != '') {
                                $betArr['game_name'] = (int)$arr['gameName'];
                            } else {
                                $betArr['game_name'] = (int)$_POST['game_name'];
                            }
                            // to check the amount
                            if ($betArr['game_name'] == '2' && $arr['coin'] < 10) {
                                continue;
                            } else if ($arr['coin'] < 5) {
                                continue;
                            }


                            $betArr['partner_id'] = (int)$client['id'];
                            $betArr['customer_id'] = $_POST['customer_id'];
                            $betArr['status'] = 'P';
                            $betArr['created'] = date('Y-m-d H:i:s');
                            $betArr['updated'] = date('Y-m-d H:i:s');
                            $betArr['point_in_rs'] = $betArr['point'] * $client['currancy_rate'];
                            array_push($arrBets['arr'], $betArr);
                            // $add = AddUpdateTable('starline_bazar_game','','',$betArr);
                            $_SESSION['balance'] = $_SESSION['balance'] - $arr['coin'];

                            $betArr['bazar_name'] = $bName['bazar_name'];
                            if ($client['id'] == '7') {
                                if ($bName['bazar_name'] == 'Milan Starline') {
                                    $betArr['bazar_name'] = 'Dhaka Starline';
                                }
                            }

                            $betArr['game_name'] = $gName['game_name'];

                            $betArr['bazar_id'] = (int)$_POST['bazar_name'];
                            $betArr['game_id'] = (int)$_POST['game_name'];
                            $betArr['time'] = $gameTime['time'];
                            unset($betArr['point_in_rs']);
                            unset($betArr['partner_id']);
                            unset($betArr['updated']);
                            array_push($cArr['arr'], $betArr);
                        }
                    }
                    $conversion = exchangeCurrency($_POST['app'], 'INR');
                    $betValidation = getMinMaxBet($_POST['app']);
                    if ($conversion['status']) {
                        for ($x = 0; $x < count($arrBets['arr']); $x++) {
                            if ($arrBets['arr'][$x]['point'] >= $betValidation['minBetLimit'] && $arrBets['arr'][$x]['point'] <= $betValidation['maxBetLimit']) {
                                $arrBets['arr'][$x]['exchange_rate'] = $conversion['conversion_rate'];
                                $arrBets['arr'][$x]['point_in_rs'] = $arrBets['arr'][$x]['point'] * $conversion['conversion_rate'];
                                $arrBets['arr'][$x]['currency_code'] = $_POST['app'];

                                $cArr['arr'][$x]['exchange_rate'] = $conversion['conversion_rate'];
                                $cArr['arr'][$x]['currency_code'] = $_POST['app'];
                            } else {
                                $array = [
                                    "message" => "Min ".$betValidation['minBetLimit']." & Max ".$betValidation['maxBetLimit']." Bet Limit",
                                    "code" => 203,
                                ];
                                die(json_encode($array));
                            }
                        }
                        $add = newAddUpdateTable('starline_bazar_game', '', '', $arrBets['arr']);
                        if ($add) {
                            $cArr['arr'] = json_encode($cArr['arr']);
                            $cArr['code'] = '401';
                            $cArr['id'] = $_POST['customer_id'];

                            $req = requestForClient($client['end_point_url'], $cArr);
                            betResponseLog(["Starline Market", $client['end_point_url'], $cArr, $req]);
                            $jReq = json_decode($req);
                            if ($jReq->Code == 200) {
                                $_SESSION['balance'] = $jReq->data;
                                $array = [
                                    "balance" => $_SESSION['balance'],
                                    "message" => "Bet Placed Successfully!",
                                    "code" => 200,
                                ];
                            } else {
                                $transactionId = implode("','", $betArrTransaction);
                                $con = " WHERE transaction_id IN ('" . $transactionId . "')";
                                $field['status'] = "V";
                                $updateresultLose = updateAllLose('starline_bazar_game', $con, $field);
                                if($jReq->Code==203){
                                    $array['message'] = $jReq->message;
                                }else{
                                    $array['message'] = "Bet not accepted by client.";
                                }
                                $array["code"] = 203;
                            }
                        } else {
                            $array = [
                                "message" => "Bet not accepted by provider.",
                                "code" => 203,
                            ];
                        }
                    } else {
                        $array = [
                            "message" => "Third party error.",
                            "code" => 203,
                        ];
                    }
                } else {
                    $array = [
                        "message" => "You Dont Have Sufficient Balance.",
                        "code" => 203,
                    ];
                }
            } else {
                $array = [
                    "message" => "Please Select Game And Bet Points.",
                    "code" => 202,
                ];
            }
            die(json_encode($array));
        } else {
            die(json_encode(["message" => "Please Provide Valid data", "code" => 401]));
        }
    }


    /*------------- Auto Result Start -----------------*/
    // public function starAutoResult($id,$time){
    //     die(json_encode(['status'=>404,'massage'=>'Page Not Found']));
    //     $nR=['120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890', '100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990'];

    //     $key=array_rand($nR,1);
    //     $_POST['result'] = $nR[$key];

    //     $a=$_POST['result'];
    //     $ak=(int)$a[0]+(int)$a[1]+(int)$a[2];
    //     if($ak>9){
    //         $akda=substr($ak, -1);
    //     }else{
    //         $akda=$ak;
    //     }


    //     $this->load->model('Common_model');
    //     $con = ' WHERE bazar_name="'.$id.'" AND time="'.$time.'" AND result_date="'.date('Y-m-d').'"';
    //     $bazarResult = $this->Common_model->getData('starline_bazar_result',$con,'','','','One','','');

    //     $addRes['result_patti'] = $nR[$key];
    //     $addRes['result_akda'] = $akda;
    //     $addRes['status']= 'A';
    //     $addRes['updated_by']= '0';

    //     if(empty($bazarResult)){
    //         $addRes['token']=transactionID(10,10);
    //         $addRes['bazar_name']=$id;
    //         $addRes['time']=$time;
    //         $addRes['result_date']=date('Y-m-d');
    //         $addUpdate = AddUpdateTable('starline_bazar_result', '', '', $addRes);

    //         $bazarResult = $this->Common_model->getData('starline_bazar_result',$con,'id,result_date,bazar_name,time','','','One','','');

    //         $conLst = ' INNER JOIN starline_bazar ON starline_bazar_result.bazar_name=starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id WHERE starline_bazar_result.bazar_name="'.$bazarResult['bazar_name'].'" AND starline_bazar_result.time="'.$bazarResult['time'].'" AND starline_bazar_result.result_date="'.$bazarResult['result_date'].'"';

    //         $feildsLst = 'starline_bazar_result.result_patti,starline_bazar_result.result_akda,starline_bazar_time.time,starline_bazar.bazar_name,starline_bazar_result.result_date';

    //         $lst = $this->Common_model->getData('starline_bazar_result',$conLst,$feildsLst,'','','One','','');

    //         $sR['resultdigit']=$addRes['result_akda'];
    //         $sR['result']=$addRes['result_patti'];
    //         $sR['bazar']=$id;
    //         $sR['date']=date('Y-m-d');
    //         $sR['time']=$time; 
    //         $sR['tm']=$lst['time']; 
    //         $url='https://channapoha.com/postdata/starlineresult';
    //         // echo '<pre>';
    //         // echo($url);
    //         // print_r($sR);
    //         // die();
    //         $res=sendResultDpboss($sR,$url);
    //         $dnew['bazarId'] = (int)$sR['bazar'];
    //         $dnew['timeId'] = (int)$time;
    //         $dnew['resultDate'] = $_POST['result_date'];
    //         $dnew['patti']=$sR['result'];
    //         $dnew['akda']=$sR['resultdigit'];
    //         $dnew['marketCode'] = 401;
    //         $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
    //         sendResultDpbossNewProject(json_encode($dnew),$url);
    //     }
    //     $winStar = getWinnersStar($bazarResult['id']);
    //     if(!empty($winStar)){
    //         $com = $this->Common_model->getData('client_commission','','client_id,commission','','','','','');
    //         $lC=0;
    // 		$fbC=0;
    //         $oC=0;
    //         $commission=0;
    // 		foreach($com as $c){
    // 			if($c['client_id']=='2'){
    // 				$lC=$c['commission'];
    // 			}else if($c['client_id']=='4'){
    // 				$fbC=$c['commission'];
    // 			}else{
    //                 $oC=$c['commission'];
    //             }
    // 		}
    //         $cCR = $this->Common_model->getData('client','','id,currancy_rate','','','','','');
    //         $cR = array();
    //         foreach ($cCR as $d){
    //             $cR[$d['id']] = $d['currancy_rate'];
    //         }
    //         foreach($winStar as $data){
    //             $con = ' INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id WHERE starline_bazar_game.id="'.$data.'"';
    //             $feilds = 'starline_bazar_game.partner_id,starline_bazar_game.customer_id,starline_bazar_game.bazar_name,starline_bazar_game.game_name,starline_bazar_game.result_date,starline_bazar_game.time,starline_bazar_game.point,starline_bazar_time.time as timeId';

    //             $bet = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');


    //             if($bet['partner_id']=='2'){
    // 				$commission=$lC;
    // 			}else if($bet['partner_id']=='4'){
    // 				$commission=$fbC;
    // 			}else{
    //                 $commission=$oC;
    //             }

    //             $rate = $this->Common_model->getData('starline_bhav',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_name="'.$bet['game_name'].'"','rate','','','One','','');

    //             $rOC = $this->Common_model->getData('customer_rate',' WHERE customer_id="'.$bets['customer_id'].'" AND partner_id="'.$bets['partner_id'].'"','rate','','','One','','');
    //             if($rOC){
    //                 $win = ($bet['point']*$rate['rate']) * ((100-$rOC['rate']) / 100);
    //                 $addR['commission'] = ($commission / 100) * $win;
    //                 $addR['winning_point'] = $win - $addR['commission'];
    //             }else{
    //                 $addR['commission'] = ($commission / 100) * $bet['point']*$rate['rate'];
    //                 $addR['winning_point'] = ($bet['point']*$rate['rate'])-$addR['commission'];
    //             }
    //             $addR['winning_in_rs']=$addR['winning_point']*(double)$cR[$bet['partner_id']];
    //             $addR['commission_in_rs']=$addR['commission']*(double)$cR[$bet['partner_id']];
    //             $addR['status']= 'W';
    //             $updateresultid = AddUpdateTable('starline_bazar_game', 'id', $data, $addR);
    //         }
    //     }else{
    //         $bet=$bazarResult;
    //     }
    //     $con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    //     $field['status']="L";
    //     $updateresultLose = updateAllLose('starline_bazar_game', $con, $field);
    //     /*--------------------- Setel Market Start --------------------------*/
    //     $con1=" INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='".$bet['result_date']."' AND starline_bazar_game.bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    //     $arrLossPartner = $this->Common_model->getData('starline_bazar_game',$con1,'DISTINCT starline_bazar_game.partner_id,client.end_point_url','','','','','');
    //     foreach($arrLossPartner as $l){
    //         $con=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    //         if($l['partner_id']=='2'){
    //             $con.=' AND status="W"';
    //             $arrReq['result_date']=$bet['result_date'];
    //             $arrReq['bazar_id']=$bet['bazar_name'];
    //             $arrReq['time']=$bet['timeId'];
    //         }
    //         $arrLossBet = $this->Common_model->getData('starline_bazar_game',$con,'transaction_id,winning_point,status,commission,customer_id','','','','','');
    //         $arrReq['code']='601';
    //         $arrReq['rec']=json_encode($arrLossBet);
    //         $arrReq['market']='Starline Bazar';
    //         $arrReq['market_code']='401';
    //         $req = requestForClient($l['end_point_url'],$arrReq);
    //     }
    //     /*--------------------- Setel Market End --------------------------*/
    //     /*--------------------- notifyMe Start --------------------------*/
    //     $con1=" WHERE result_date='".$bet['result_date']."' AND bazar_name='".$bet['bazar_name']."' AND time='".$bet['time']."'";
    //     $notifyMeW['userList'] = $this->Common_model->getData('starline_bazar_game',$con1.' AND status="W"','customer_id as id,status','','','','','');
    //     $notifyMeL['userList'] = $this->Common_model->getData('starline_bazar_game',$con1.' AND status="L"','customer_id as id,status','','','','','');
    //     /*--------------------- notifyMe End --------------------------*/
    //     $arr=[
    //         'status'=>200,
    //         'message'=>'Wallet Updated Successfully!'
    //     ];
    //     die(json_encode($arr));
    // }

    /*------------- Auto Result Start -----------------*/


    /*------------- Game List For Testing -----------------*/
    public function StarlineGameTypeListTest($id, $result, $bazar)
    {
        $this->load->model('ManageStarlinegames_Model');
        $con = 'WHERE starline_bazar_time.id="' . $id . '"';
        $this->data['gameDetail'] = $this->ManageStarlinegames_Model->getstarlinegame($con, 'one');
        $this->load->model('Common_model');
        $con1 = ' WHERE status="A"';
        $this->data['gameType'] = $this->Common_model->getData('starline_game_type', $con1, 'id,game_name,icon', '', '', '', 'priority ASC', '');
        $con2 = " WHERE result_date BETWEEN '" . date('Y-m-d', strtotime('-7 day')) . "' AND '" . date('Y-m-d') . "' AND bazar_name='" . $bazar . "' AND time='" . $id . "'";
        $this->data['marketResultOld'] = $this->Common_model->getData('starline_bazar_result', $con2, 'result_date,result_patti,result_akda', '', '', '', '', '');
        $this->data['param']['bazar_id'] = $id;
        $this->data['result'] = $result;
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        $this->load->view('user/starlineGameTypeListTest', $this->data);
    }


    public function spinTheWheel()
    {

        $this->load->model('Common_model');
        $notifyResult['bazar_name'] = $_GET['bazar_name'];
        if ($_GET['type'] == 'king') {

            $conLst = ' WHERE id="' . $_GET['bazar_name'] . '"';
            $feildsLst = 'bazar_name';
            $lst = $this->Common_model->getData('king_bazar', $conLst, $feildsLst, '', '', 'One', '', '');
            $sR['bazar'] = $lst['bazar_name'];

            $notifyResult['market'] = 'jackpotroller';
            $t = 1;
            // $con = ' WHERE bazar_name="'.$_GET['bazar_name'].'" AND result_date="2024-07-30"';
            $con = ' WHERE bazar_name="' . $_GET['bazar_name'] . '" AND result_date="' . date('Y-m-d') . '"';
            $table = 'king_bazar_result';
            $feild = 'id,result';
            $patti = getJodi();
        } else if ($_GET['type'] == 'starline') {
            $notifyResult['market'] = 'spinTheWheel';
            $notifyResult['time'] = $_GET['time'];
            $t = 2;
            $con = ' WHERE bazar_name="' . $_GET['bazar_name'] . '" AND result_date="' . date('Y-m-d') . '" AND time="' . $_GET['time'] . '"';
            $table = 'starline_bazar_result';
            $feild = 'id,result_patti';
            $patti = getPana();
            $sR['bazar'] = $_GET['bazar_name'];
            $sR['time'] = $_GET['time'];
            $d = $this->Common_model->getData('starline_bazar_time', ' WHERE id="' . $_GET['time'] . '"', 'time', '', '', 'one', '', '');
            $sR['tm'] = $d['time'];
        }
        if (isset($_GET['akda']) && strlen($_GET['akda']) == 3 && $_GET['type'] == 'starline') {
            $my = str_shuffle($_GET['akda']);
            $nAK = $_GET['akda'];
        } else if (isset($_GET['akda']) && strlen($_GET['akda']) == 2 && $_GET['type'] == 'king') {
            // $my = str_shuffle($_GET['akda']);
            $my = $_GET['akda'];
            $nAK = $_GET['akda'];
        } else {
            if ($_GET['type'] == 'king') {
                $nAK = $patti[rand(0, count($patti))];
                $my = $nAK;
            } else {
                $s = [rand(0, 9), rand(0, 9), rand(0, 9)];
                sort($s, SORT_STRING);
                $k = $s[0] . $s[1] . $s[2];
                if ($s[0] == 0 & $s[1] == 0) {
                    $k = $s[2] . $s[1] . $s[0];
                } else if ($s[0] == 0) {
                    $k = $s[1] . $s[2] . $s[0];
                }
                $nAK = $k;
                $my = str_shuffle($nAK);
            }
        }

        // echo '<pre>';
        // // include_once (__DIR__.'/../Front_controller/Front.php');
        // print_r($my);
        // die();
        if ($_GET['type'] == 'king') {
            $addResult = array(
                'bazar_name' => $_GET['bazar_name'],
                'result_date' => date('Y-m-d'),
                'status' => 'A',
                'announcer' => '1',
                'token' => transactionID(25, 25),
                'result' => $nAK,
                'updated_by' => 0
            );
        } else {
            $addResult = array(
                'bazar_name' => $_GET['bazar_name'],
                'time' => $_GET['time'],
                'result_date' => date('Y-m-d'),
                'status' => 'A',
                'announcer' => '1',
                'token' => transactionID(25, 25),
                'result_patti' => $nAK,
                'updated_by' => 0
            );
        }

        for ($i = 0; $i <= $t; $i++) {
            if ($i == $t) {
                $notifyResult['result_patti'] = $nAK;
                if ($_GET['type'] == 'king') {
                    $sR['result_date'] = date('Y-m-d');
                    $url = 'https://channapoha.com/Postdata/kingbazarresult';

                    $dnew['bazarId'] = (int)$_GET['bazar_name'];
                    $dnew['resultDate'] = date('Y-m-d');
                    $dnew['result'] = (string)$nAK;
                    $dnew['marketCode'] = 501;
                } else {
                    $akda = $my[0] + $my[1] + $my[2];
                    if ($akda > 9) {
                        $quotient = intdiv($akda, 10);
                        $addResult['result_akda'] = (string)($akda - (10 * $quotient));
                        $notifyResult['result_akda'] = (string)$addResult['result_akda'];
                    } else {
                        $addResult['result_akda'] = (string)$akda;
                        $notifyResult['result_akda'] = (string)$akda;
                    }
                    $sR['date'] = date('Y-m-d');
                    $sR['resultdigit'] = $notifyResult['result_akda'];
                    $url = 'https://channapoha.com/postdata/starlineresult';

                    $dnew['bazarId'] = (int)$_GET['bazar_name'];
                    $dnew['timeId'] = (int)$_GET['time'];
                    $dnew['resultDate'] = date('Y-m-d');
                    $dnew['patti'] = (string)$nAK;
                    $dnew['akda'] = (string)$notifyResult['result_akda'];
                    $dnew['marketCode'] = 401;
                }
                $d = $this->Common_model->getData($table, $con, $feild, '', '', 'one', '', '');
                if ($d) {
                    die(json_encode(['status' => 401, 'massage' => 'Already Updated']));
                }
                $updateresultid = AddUpdateTable($table, '', '', $addResult);
                $sR['result'] = $nAK;

                // $res=sendResultDpboss($sR,$url);
                $addResData['response'] = $res;
                $addResData['client_id'] = 1;
                $addUpdate = AddUpdateTable('client_response', '', '', $addResData);

                // $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
                $url = config_item('resultsite_url');
                $res = sendResultDpbossNewProject(json_encode($dnew), $url);
                $addResData['response'] = $res;
                $addResData['client_id'] = 0;
                $addUpdate = AddUpdateTable('client_response', '', '', $addResData);
            }

            $notifyResult['akda'] = $my[$i];
            $note = notifyUserWithResult(json_encode($notifyResult));
            sleep(12); // this should halt for 11 seconds for every loop
        }
        $d = $this->Common_model->getData($table, $con, $feild, '', '', 'one', '', '');

        $id = $d['id'];
        if ($_GET['type'] == 'king') {
            $data = getWinnersKing($id);
            if (empty($data)) {
                $dL['ids'] = $this->Common_model->getData('king_bazar_game', $con, 'id', '', '', '', '', '');
                $dL['res'] = $d;
                $wallet = updatePendingKing($dL);
            } else {
                $wallet = updateWalletKing($data);
            }
        } else {
            $data = getWinnersStar($id);
            if (empty($data)) {
                $dL['ids'] = $this->Common_model->getData('starline_bazar_game', $con, 'id', '', '', '', '', '');
                $dL['res'] = $d;
                $wallet = updatePendingStar($dL);
            } else {
                $wallet = updateWalletStar($data);
            }
        }
        die(json_encode(['status' => 200, 'massage' => 'Result Updated Successfully!']));
    }

    public function getStarlineResultByPercentage($bazarId, $time)
    {
        if (isset($bazarId)) {
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('starline_bazar', ' WHERE id="' . $bazarId . '"', '', '', '', 'One', '', '');

            $con = " WHERE result_date='" . date('Y-m-d') . "' AND bazar_name='" . $bazarId . "' AND time='" . $time . "'";
            $conPatti = $con;
            $allPatti = getPana();

            $akda = getVariationPatti('SingleAkda');


            $feild = "SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('starline_bazar_game', $con . " AND (game > 99 OR game='000')", "SUM(point) as point,COUNT(DISTINCT customer_id) as customer", '', '', 'One', '', '');

            $con .= " AND game IN ('" . implode("','", $akda) . "')";
            $ak = $this->Common_model->getData('starline_bazar_game', $con, $feild, '', '', '', 'game asc', 'game');

            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
            foreach ($ak as $k) {
                $p = getAllPattiByDigit($k['game']);
                $tr = $k['game'] . $k['game'] . $k['game'];
                array_push($p, $tr);
                $patti = $this->Common_model->getData('starline_bazar_game', $conPatti . " AND game IN ('" . implode("','", $p) . "')", 'SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer', '', '', '', 'game asc', 'game');
                $arrPatti[$k['game']] = $patti;
                foreach ($patti as $e) {
                    array_push($newArrPatti, $e);
                }
            }
            $totalBet = $sum + $pattiBet['point'];
            $profit =  (($totalBet / 100) * $per['per']);

            $i = 0;
            $jArr = [];
            $pArr = [];
            foreach ($newArrPatti as $n) {
                $akSum = 0;
                $digits = str_split((string) abs($n['game']));
                foreach ($digits as $digit) {
                    $akSum += $digit;
                }
                if ($akSum > 9) {
                    $myAk = str_split($akSum);
                    $akSum = $myAk[1];
                }
                $panaType = checkPanaType($n['game']);
                if ($panaType === 'SP') {
                    $parrRate = 140;
                } else if ($panaType === 'DP') {
                    $parrRate = 280;
                } else if ($panaType === 'TP') {
                    $parrRate = 800;
                }
                $m['customer'] = $ak[$akSum]['customer'] + $n['customer'];
                $m['game'] = $n['game'];
                $m['akdaPoint'] = $ak[$akSum]['point'];
                $m['pattiPoint'] = $n['point'];
                $m['win'] = ($n['point'] * $parrRate) + ($ak[$akSum]['point'] * 9.7);
                $m['prof'] = $totalBet - $m['win'];
                array_push($pArr, $m);
                $i++;
            }

            $result = array_diff($allPatti, array_column($pArr, 'game'));

            if (!empty($result)) {
                foreach ($result as $balPatti) {
                    $panaType = checkPanaType($balPatti);
                    if ($panaType === 'SP') {
                        $parrRate = 140;
                    } else if ($panaType === 'DP') {
                        $parrRate = 280;
                    } else if ($panaType === 'TP') {
                        $parrRate = 800;
                    }
                    $akSum = 0;
                    $digits = str_split((string) abs($balPatti));

                    foreach ($digits as $digit) {
                        $akSum += $digit;
                    }

                    if ($akSum > 9) {
                        $myAk = str_split($akSum);
                        $akSum = $myAk[1];
                    }

                    $m['customer'] = $ak[$akSum]['customer'];
                    $m['pattiPoint'] = 0;
                    $m['game'] = $balPatti;
                    // $jd = $arr[$akda][$akSum];
                    $m['akdaPoint'] = $ak[$akSum]['point'];
                    $m['win'] = ($ak[$akSum]['point'] * 9.7);
                    $m['prof'] = $totalBet - $m['win'];
                    array_push($pArr, $m);
                }
            }
            $key = 'prof';
            usort($pArr, function ($a, $b) use ($key) {
                return $b[$key] <=> $a[$key];
            });
            $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
            if (!$resultPatti) {
                $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
            }
            die(json_encode($resultPatti));
            return $resultPatti;
        } else {
            $arr = [
                'status' => 401,
                'massage' => 'Please Provide Valid Data!'
            ];
        }
        die(json_encode($arr));
    }
    public function getKingBazarResultByPercentage($bazarId)
    {
        if (isset($bazarId)) {
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('king_bazar', ' WHERE id="' . $bazarId . '"', '', '', '', 'One', '', '');
            $con = " WHERE result_date='" . date('Y-m-d') . "' AND bazar_name='" . $bazarId . "'";
            $feild = "SUM(point) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('king_bazar_game', $con, "SUM(point) as point,COUNT(DISTINCT customer_id) as customer", '', '', 'One', '', '');
            $ak = $this->Common_model->getData('king_bazar_game', $con . " AND game > 9", $feild, '', '', '', 'game asc', 'game');
            $akR = $this->Common_model->getData('king_bazar_game', $con . " AND game < 9 AND game_name=1", $feild, '', '', '', 'game asc', 'game');
            $akL = $this->Common_model->getData('king_bazar_game', $con . " AND game < 9 AND game_name=2", $feild, '', '', '', 'game asc', 'game');
            $rate = $this->Common_model->getData('king_bazar_rate', " WHERE bazar_name='" . $bazarId . "'", '', '', '', '', '', '');

            $rt = [];
            foreach ($rate as $k) {
                $rt[$k['game_type']] = $k['rate'];
            }
            $result = array_diff(getJodiForKingBazar(), array_column($ak, 'game'));
            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $colAk = array_column($ak, 'game');
            $colAkR = array_column($akR, 'game');
            $colAkL = array_column($akL, 'game');

            for ($i = 0; $i < 100; $i++) {
                $z['point'] = 0;
                $z['customer'] = 0;
                $z['win'] = 0;
                $z['prof'] = 0;
                $s = '' . $i;
                if ($i < 10) {
                    $s = '0' . $i;
                }
                $z['game'] = $s;

                if (in_array($s, $colAk)) {
                    foreach ($ak as $a) {
                        if ($s == $a['game']) {
                            $z['win'] += $a['point'] * $rt['3'];
                            $z['point'] += $a['point'];
                            $z['customer'] += $a['customer'];
                        }
                    }
                }
                // if($s=='54'){
                //     echo '<pre>';
                //     print_r($z['win']);
                //     print_r($rt);
                //     die();
                // }
                if (in_array($s[0], $colAkR)) {
                    foreach ($akR as $ar) {
                        if ($s[0] == $ar['game']) {
                            $z['win'] += $ar['point'] * $rt['1'];
                            $z['point'] += $ar['point'];
                            $z['customer'] += $ar['customer'];
                        }
                    }
                }
                if (in_array($s[1], $colAkL)) {
                    foreach ($akR as $ar) {
                        if ($s[1] == $a['game']) {
                            $z['win'] += $ar['point'] * $rt['2'];
                            $z['point'] += $ar['point'];
                            $z['customer'] += $ar['customer'];
                        }
                    }
                }
                $z['prof'] = $pattiBet['point'] - $z['win'];
                array_push($arr, $z);
            }
            // echo '<pre>';
            // print_r($arr);
            // die();
            $totalBet = $pattiBet['point'];
            $profit =  (($totalBet / 100) * $per['profit']);
            $key = 'prof';
            usort($arr, function ($a, $b) use ($key) {
                return $b[$key] <=> $a[$key];
            });

            $resultPatti = $this->findProfitableArray($arr, 'prof', $profit);
            if (!$resultPatti) {
                $resultPatti = $this->findClosestArray($arr, 'prof', $profit);
            }
            // echo '<pre>';
            // print_r($arr);
            // die();
            die(json_encode($resultPatti));
            // return $resultPatti;
        } else {
            $arr = [
                'status' => 401,
                'massage' => 'Please Provide Valid Data!'
            ];
        }
        die(json_encode($arr));
    }
    public function findClosestArray($multiArray, $columnKey, $targetValue)
    {
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

    public function findProfitableArray($multiArray, $columnKey, $targetValue)
    {
        $profitableArray = [];
        $cust = 0;
        foreach ($multiArray as $array) {
            if (isset($array[$columnKey])) {
                if ($array[$columnKey] > $targetValue) {
                    $panaType = checkPanaType($array['game']);
                    if (($cust < $array['customer'] || $cust == 0) && $panaType != 'TP') {
                        $cust = $array['customer'];
                        // array_push($profitableArray,$array);
                        $profitableArray = $array;
                    }
                }
            }
        }
        return $profitableArray;
    }
}
