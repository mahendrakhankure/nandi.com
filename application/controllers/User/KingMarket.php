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

class KingMarket extends BaseController
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



    public function maintenance()
    {
        $this->load->view('user/maintenance');
    }

    public function index()
    {
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        $data['kingGame'] = $this->Common_model->getData('king_bazar', $con, 'id,bazar_name,time,icon,icon1,text,text1,icon_status,icon_status1,bazar_image', '', '', '', 'sequence asc', '');
        $i = 0;
        foreach ($data['kingGame'] as $d) {
            $con = ' WHERE bazar_name="' . $d['id'] . '" AND result_date="' . date('Y-m-d') . '"';
            $re = $this->Common_model->getData('king_bazar_result', $con, 'result', '', '', 'One', '', '');
            if (empty($re['result'])) {
                $con = ' WHERE bazar_name="' . $d['id'] . '" AND result_date="' . date('Y-m-d', strtotime("- 1 day")) . '"';
                $re = $this->Common_model->getData('king_bazar_result', $con, 'result', '', '', 'One', '', '');
                // echo '<pre>';
                // print_r($re);
                // die();
            }
            $data['kingGame'][$i]['result'] = $re['result'];
            $i++;
        }
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
        $this->load->view('user/kingMarketList', $data);
    }

    /*------------- Game List -----------------*/
    public function kingGameList($id)
    {
        $this->load->model('Common_model');
        $con = ' WHERE bazar_name="' . $id . '" AND result_date="' . date('Y-m-d') . '"';
        $this->data['result'] = $this->Common_model->getData('king_bazar_result', $con, 'result', '', '', 'One', '', '');
        $con1 = ' WHERE id="' . $id . '"';
        $this->data['marketDetail'] = $this->Common_model->getData('king_bazar', $con1, 'id,bazar_name,time', '', '', 'One', '', '');
        $con2 = " WHERE result_date BETWEEN '" . date('Y-m-d', strtotime('-7 day')) . "' AND '" . date('Y-m-d') . "' AND bazar_name='" . $id . "'";
        $this->data['marketResultOld'] = $this->Common_model->getData('king_bazar_result', $con2, 'result_date,result', '', '', '', '', '');
        $this->data['bazar_id'] = $id;
        $this->data['param'] = [
            'bazar_id' => $id,
        ];
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        $this->load->view('user/kingGameList', $this->data);
    }

    /*------------- Game Type Bet Pages -----------------*/
    public function betsOnGame($bazar_id, $game_id)
    {
        $this->data['param'] = [
            'bazar_id' => $bazar_id,
            'game_id' => $game_id
        ];
        $this->load->model('Common_model');
        $con1 = ' WHERE id="' . $bazar_id . '"';
        $this->data['marketDetail'] = $this->Common_model->getData('king_bazar', $con1, 'id,bazar_name,time', '', '', 'One', '', '');

        $con3 = " WHERE status='A' AND bazar_name='" . $bazar_id . "'";
        $feilds = 'result_date,result';
        $this->data['gameResult'] = $this->Common_model->getData('king_bazar_result', $con3, $feilds, '4', '0', '', 'result_date DESC', '');

        $time = time() + 1 * 60;
        $open = checkTime($this->data['marketDetail']['time']);
        $dateArray = [];
        $con4 = " WHERE market_type='King' AND bazar_name='" . $bazar_id . "' AND date > '" . date('Y-m-d', strtotime("-1 day")) . "'";
        $feilds = 'date';
        $holiday = $this->Common_model->getData('market_holidays', $con4, $feilds, '', '', '', '', '');
        $hol = array_column($holiday, 'date');
        for ($i = 0; $i < 7; $i++) {
            if (!in_array(date('Y-m-d', strtotime("+" . $i . "day")), $hol)) {
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
        }
        $minMaxBet = getMinMaxBet($_GET['app']);
        $this->data['minBet'] = $minMaxBet['minBetLimit'];
        $this->data['maxBet'] = $minMaxBet['maxBetLimit'];
        $this->data['status'] = array_slice($dateArray, 0, 3);

        $nArr = [];
        foreach ($dateArray as $val) {
            if (!in_array($val, $nArr)) {
                array_push($nArr, $val);
            }
        }
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        $this->data['status'] = array_slice($nArr, 0, 3);
        $this->load->view('user/kingBets', $this->data);
    }


    /*------------- Place Bet Pages -----------------*/

    public function PlaceBetsKing()
    {

        if (isset($_POST['bazar_name']) && isset($_POST['game_name']) && isset($_POST['games']) && isset($_POST['result_date'])) {
            checkBetData($_post, 'KingBazar');
            $date = date('Y-m-d', strtotime($_POST['result_date']));
            if ($date < date('Y-m-d')) {
                $array = [
                    'message' => 'Invalid date!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            }
            $this->load->model('Common_model');
            $bazarTime = $this->Common_model->getData('king_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', '', '', '', 'One', '', '');
            // $time = strtotime(date('Y-m-d H:i:s'))+1*60;
            $time = strtotime(date('Y-m-d H:i:s')) + 1 * 60;
            if ($date < date('Y-m-d') || ($date == date('Y-m-d') && strtotime(date('Y-m-d ' . $bazarTime['time'])) < $time)) {
                die(json_encode(['message' => 'This Bazar Is Close For This day.', 'Code' => 203,]));
            }
            if (!empty($_POST['games'])) {
                $client = $this->Common_model->getData('client', ' WHERE client_token="' . $_POST['tokenId'] . '"', 'end_point_url,id,currancy_rate', '', '', 'One', '', '');
                $data = requestForClient($client['end_point_url'], ['id' => $_POST['customer_id'], 'code' => '300']);
                $res = json_decode($data);
                if ($res->Code == '200' && $res->data[0] >= $_POST['totalA']) {
                    $_SESSION['balance'] = $res->data[0];
                    $cArr['arr'] = [];

                    $bName = $this->Common_model->getData('king_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', 'bazar_name', '', '', 'One', '', '');
                    if ($_POST['game_name'] == '1') {
                        $gName = 'FIRST DIGIT(EKAI)';
                    } else if ($_POST['game_name'] == '2') {
                        $gName = 'SECOND DIGIT(HARUF)';
                    } else if ($_POST['game_name'] == '3') {
                        $gName = 'JODI';
                    }
                    $arrBets['arr'] = [];


                    $betArrTransaction = [];
                    foreach ($_POST['games'] as $arr) {

                        if ($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']) {
                            if (($_POST['game_name'] == '2' || $_POST['game_name'] == '1') && $arr['coin'] < 10) {
                                continue;
                            } else if ($arr['coin'] < 5) {
                                continue;
                            }
                            // echo '<pre>';
                            // print_r($arr);
                            // die();
                            $betArr = [];
                            $betArr['transaction_id'] = transactionID(16, 16) . time();
                            $betArr['bazar_name'] = (int)$_POST['bazar_name'];
                            $betArr['game_name'] = (int)$_POST['game_name'];
                            $betArr['result_date'] = $date;
                            $betArr['point'] = (int)$arr['coin'];
                            $betArr['game'] = $arr['akda'];

                            $betArr['partner_id'] = (int)$client['id'];
                            $betArr['customer_id'] = $_POST['customer_id'];
                            $betArr['status'] = 'P';
                            $betArr['created'] = date('Y-m-d H:i:s');
                            $betArr['updated'] = date('Y-m-d H:i:s');
                            $betArr['point_in_rs'] = $betArr['point'] * $client['currancy_rate'];

                            array_push($arrBets['arr'], $betArr);
                            // $add = AddUpdateTable('king_bazar_game','','',$betArr);
                            $_SESSION['balance'] = $_SESSION['balance'] - $arr['coin'];

                            $betArr['bazar_name'] = $bName['bazar_name'];
                            $betArr['bazar_id'] = $_POST['bazar_name'];
                            $betArr['game_id'] = $_POST['game_name'];
                            $betArr['game_name'] = $gName;

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
                        $add = newAddUpdateTable('king_bazar_game', '', '', $arrBets['arr']);
                        if ($add) {
                            $cArr['arr'] = json_encode($cArr['arr']);
                            $cArr['code'] = '501';
                            $cArr['id'] = $_POST['customer_id'];



                            $req = requestForClient($client['end_point_url'], $cArr);
                            $jReq = json_decode($req);
                            betResponseLog(["King Market", $client['end_point_url'], $cArr, $req]);
                            $jReq = json_decode($req);

                            if ($jReq->Code == 200) {
                                $_SESSION['balance'] = $jReq->data;

                                $array = [
                                    "balance" => $_SESSION['balance'],
                                    "message" => "Bet Placed Successfully!",
                                    "Code" => 200,
                                ];
                            } else {
                                $transactionId = implode("','", $betArrTransaction);
                                $con = " WHERE transaction_id IN ('" . $transactionId . "')";
                                $field['status'] = "V";
                                $updateresultLose = updateAllLose('king_bazar_game', $con, $field);
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
                        "Code" => 203,
                    ];
                }
            } else {
                $array = [
                    "message" => "Please Select Game And Bet Points.",
                    "Code" => 202,
                ];
            }
            die(json_encode($array));
        } else {
            die(json_encode(["message" => "Please Provide Valid data", "Code" => 401]));
        }
    }

    /*------------- Auto Result Start -----------------*/
    public function kingAutoResult($id)
    {
        if ($id == '2' || $id == '7') {
            $this->load->model('Common_model');
            $con = ' WHERE bazar_name="' . $id . '" AND result_date="' . date('Y-m-d') . '"';
            $bazarResult = $this->Common_model->getData('king_bazar_result', $con, 'id,result_date,bazar_name', '', '', 'One', '', '');

            $nR = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
            $key = array_rand($nR, 1);
            $addResult['result'] = $nR[$key];
            $addResult['status'] = 'A';
            $addResult['announcer'] = 0;
            $addResult['updated_by'] = 0;
            if (empty($bazarResult)) {
                $addResult['token'] = transactionID(10, 10);
                $addResult['bazar_name'] = $id;
                $addResult['result_date'] = $id;
                $addUpdate = AddUpdateTable('king_bazar_result', '', 'id', $addResult);
                $bazarResult = $this->Common_model->getData('king_bazar_result', $con, 'id,result_date,bazar_name', '', '', 'One', '', '');
            }
            $addUpdate = AddUpdateTable('king_bazar_result', 'id', $bazarResult['id'], $addResult);

            $winKing = getWinnersKing($bazarResult['id']);

            if (!empty($winKing)) {
                $lC = 0;
                $fbC = 0;
                $oC = 0;
                $com = $this->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
                foreach ($com as $c) {
                    if ($c['client_id'] == '2') {
                        $lC = $c['commission'];
                    } else if ($c['client_id'] == '4') {
                        $fbC = $c['commission'];
                    } else {
                        $oC = $c['commission'];
                    }
                }

                $cCR = $this->Common_model->getData('client', '', 'id,currancy_rate', '', '', '', '', '');
                $cR = array();
                foreach ($cCR as $d) {
                    $cR[$d['id']] = $d['currancy_rate'];
                }

                foreach ($winKing as $data) {
                    $bet = $this->Common_model->getData('king_bazar_game', ' WHERE id="' . $data . '"', 'transaction_id,bazar_name,game_name,result_date,point,partner_id,customer_id', '', '', 'One', '', '');

                    $rate = $this->Common_model->getData('king_bazar_rate', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_type="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');

                    $rOC = $this->Common_model->getData('customer_rate', ' WHERE customer_id="' . $bets['customer_id'] . '" AND partner_id="' . $bets['partner_id'] . '"', 'rate', '', '', 'One', '', '');

                    if ($bet['partner_id'] == '2') {
                        $commission = $lC;
                    } else if ($bet['partner_id'] == '4') {
                        $commission = $fbC;
                    } else {
                        $commission = $oC;
                    }

                    if ($rOC) {
                        $win = ($bet['point'] * $rate['rate']) * ((100 - $rOC['rate']) / 100);
                        $addR['commission'] = ($commission / 100) * $win;
                        $addR['winning_point'] = $win - $addResult['commission'];
                    } else {
                        $addR['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
                        $addR['winning_point'] = ($bet['point'] * $rate['rate']) - $addResult['commission'];
                    }
                    $addR['status'] = 'W';
                    $addR['winning_in_rs'] = $addR['winning_point'] * (float)$cR[$bet['partner_id']];
                    $addR['commission_in_rs'] = $addR['commission'] * (float)$cR[$bet['partner_id']];
                    $updateresultid = AddUpdateTable('king_bazar_game', 'id', $data, $addR);
                }

                $con = " WHERE result_date='" . $bazarResult['result_date'] . "' AND status='P' AND bazar_name='" . $bazarResult['bazar_name'] . "'";
                $field['status'] = "L";

                $updateresultLose = updateAllLose('king_bazar_game', $con, $field);
            } else {
                $con = " WHERE result_date='" . $bazarResult['result_date'] . "' AND status='P' AND bazar_name='" . $bazarResult['bazar_name'] . "'";
                $field['status'] = "L";

                $updateresultLose = updateAllLose('king_bazar_game', $con, $field);
            }
            /*--------------------- Setel Market Loss Start --------------------------*/
            $con1 = " INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.result_date='" . $bazarResult['result_date'] . "' AND king_bazar_game.bazar_name='" . $bazarResult['bazar_name'] . "'";


            $arrLossPartner = $this->Common_model->getData('king_bazar_game', $con1, 'DISTINCT king_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');


            foreach ($arrLossPartner as $l) {
                $con2 = " WHERE result_date='" . $bazarResult['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bazarResult['bazar_name'] . "'";
                if ($l['partner_id'] == '2') {
                    $con2 .= ' AND status="W"';
                    $arrReq['result_date'] = $bazarResult['result_date'];
                    $arrReq['bazar_id'] = $bazarResult['bazar_name'];
                }
                $arrLossBet = $this->Common_model->getData('king_bazar_game', $con2, 'transaction_id,winning_point,status,commission,customer_id', '', '', '', '', '');
                $arrReq['code'] = '601';
                $arrReq['market_code'] = '501';
                $arrReq['rec'] = json_encode($arrLossBet);
                $arrReq['market'] = 'King Bazar';
                $req = requestForClient($l['end_point_url'], $arrReq);
            }
            /*--------------------- Setel Market Loss End --------------------------*/
            /*--------------------- notifyMe Start --------------------------*/
            $con2 = " WHERE result_date='" . $bazarResult['result_date'] . "' AND bazar_name='" . $bazarResult['bazar_name'] . "'";
            $notifyMeW['userList'] = $this->Common_model->getData('king_bazar_game', $con2 . ' AND status="W"', 'customer_id,status', '', '', '', '', '');
            $notifyMeL['userList'] = $this->Common_model->getData('king_bazar_game', $con2 . ' AND status="L"', 'customer_id,status', '', '', '', '', '');
            /*--------------------- notifyMe End --------------------------*/
            $arr = [
                'status' => 200,
                'message' => 'Wallet Updated Successfully!'
            ];
            die(json_encode($arr));
        }
    }

    /*------------- Auto Result Start -----------------*/
}
