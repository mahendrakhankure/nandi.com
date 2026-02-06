<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
require APPPATH . '/libraries/BaseController.php';
/**

 * Class : Manage_Matkagames (Manage_Matkagames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class RegularMarket extends BaseController
{

    function __construct()
    {
        parent::__construct();
        if (isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])) {
            $_GET['id'] = str_replace(" ", "+", $_GET['id']);
            $this->load->model('Common_model');
            $con = ' WHERE status="A" AND client_token="' . $_GET['token'] . '"';
            $partner = $this->Common_model->getData('client', $con, 'id,end_point_url', '', '', 'One', '', '');
            // echo '<pre>';
            // print_r($partner);
            // die();
            if (!empty($partner)) {
                $_SESSION['end_point_url'] = $partner['end_point_url'];
                $data = requestForClient($partner['end_point_url'], ['id' => $_GET['id'], 'code' => '300']);
                $res = json_decode($data);
                if ($res->Code == 200) {
                    $_SESSION['token'] = $_GET['token'];
                    $_SESSION['app'] = $_GET['app'];
                    $_SESSION['partner'] = $partner;
                    $_SESSION['balance'] = $res->data[0];
                    $_SESSION['userName'] = $res->data[1];
                    $_SESSION['customer_id'] = $_GET['id'];
                }
            }
        }
    }


    /*------------- Bazars List -----------------*/
    public function homePageNew()
    {
        // echo 'working';die();
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        $List = $this->Common_model->getData('regular_bazar', $con, '', '', '', '', 'sequence ASC', '');
        foreach ($List as $dataArray) {
            $days = explode(",", $dataArray['days']);
            $con = ' WHERE result_date="' . date('Y-m-d') . '" AND bazar_name="' . $dataArray['id'] . '"';
            $bazarResult = $this->Common_model->getData('regular_bazar_result', $con, 'open,jodi,close', '', '', 'One', 'id DESC', '');

            if (empty($bazarResult['open']) && empty($bazarResult['jodi']) && empty($bazarResult['close'])) {
                $con1 = ' WHERE result_date="' . date('Y-m-d', strtotime("-1 days")) . '" AND bazar_name="' . $dataArray['id'] . '"';
                $bazarResult = $this->Common_model->getData('regular_bazar_result', $con1, '', '', '', 'One', 'id DESC', '');
                if (empty($bazarResult)) {
                    $bazarResult['open_result'] = "";
                    $bazarResult['jodi_result'] = "";
                    $bazarResult['close_result'] = "";
                }
            }
            $time = time() + 1 * 60;

            $time = time() + 1 * 60;
            $open = checkTime($dataArray['open_time']);
            $close = checkTime($dataArray['close_time']);
            $DateArrayOpen = [];
            $DateArrayClose = [];
            for ($i = 0; $i < 15; $i++) {
                if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days)) {
                    if ($i == 0) {
                        if ($open > $time && $close > $time) {
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        } else if ($open < $time && $close > $time) {
                            $n = $i + 1;
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $n . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        }
                    } else {
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                    }
                }
            }

            $con5 = " WHERE market_type='Regular' AND bazar_name='" . $dataArray['id'] . "'";
            $hld = $this->Common_model->getData('market_holidays', $con5, 'date', '', '', '', '', '');
            $arrN = [];
            foreach ($hld as $val) {
                array_push($arrN, $val['date']);
            }
            $nO = [];
            $nC = [];
            foreach ($DateArrayOpen as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nO, $d);
                }
                $i++;
            }
            foreach ($DateArrayClose as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nC, $d);
                }
            }
            // $this->data['oD'] = array_slice($nO,0,2);
            // $this->data['cD'] = array_slice($nC,0,2);



            $this->data['marketList'][] = [
                'result' => $bazarResult['open'] . "-" . $bazarResult['jodi'] . "-" . $bazarResult['close'],
                'bazar_name' => $dataArray['bazar_name'],
                'open_time' => date('H:i:s', checkTime($dataArray['open_time'])),
                'close_time' => date('H:i:s', checkTime($dataArray['close_time'])),
                'sequence' => $dataArray['sequence'],
                'days' => $dataArray['days'],
                'bazar_id' => $dataArray['id'],
                'oD' => array_slice($nO, 0, 2),
                'cD' => array_slice($nC, 0, 2),
                'icon' => $dataArray['icon'],
                'icon1' => $dataArray['icon1'],
                'text' => $dataArray['text'],
                'text1' => $dataArray['text1'],
                'icon_status' => $dataArray['icon_status'],
                'icon_status1' => $dataArray['icon_status1'],
                'bazar_image' => $dataArray['bazar_image'],
            ];
            $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        }
        $this->load->view('user/homePageNew', $this->data);
    }

    /*------------- Bazars List -----------------*/
    public function index()
    {
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        $List = $this->Common_model->getData('regular_bazar', $con, '', '', '', '', 'sequence ASC', '');
        foreach ($List as $dataArray) {
            $days = explode(",", $dataArray['days']);
            $con = ' WHERE result_date="' . date('Y-m-d') . '" AND bazar_name="' . $dataArray['id'] . '"';
            $bazarResult = $this->Common_model->getData('regular_bazar_result', $con, 'open,jodi,close', '', '', 'One', 'id DESC', '');

            if (empty($bazarResult['open']) && empty($bazarResult['jodi']) && empty($bazarResult['close'])) {
                $con1 = ' WHERE result_date="' . date('Y-m-d', strtotime("-1 days")) . '" AND bazar_name="' . $dataArray['id'] . '"';
                $bazarResult = $this->Common_model->getData('regular_bazar_result', $con1, '', '', '', 'One', 'id DESC', '');
                if (empty($bazarResult)) {
                    $bazarResult['open_result'] = "";
                    $bazarResult['jodi_result'] = "";
                    $bazarResult['close_result'] = "";
                }
            }
            $time = time() + 1 * 60;

            $time = time() + 1 * 60;
            $open = checkTime($dataArray['open_time']);
            $close = checkTime($dataArray['close_time']);
            $DateArrayOpen = [];
            $DateArrayClose = [];
            for ($i = 0; $i < 15; $i++) {
                if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days)) {
                    if ($i == 0) {
                        if ($open > $time && $close > $time) {
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        } else if ($open < $time && $close > $time) {
                            $n = $i + 1;
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $n . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        }
                    } else {
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                    }
                }
            }

            $con5 = " WHERE market_type='Regular' AND bazar_name='" . $dataArray['id'] . "'";
            $hld = $this->Common_model->getData('market_holidays', $con5, 'date', '', '', '', '', '');
            $arrN = [];
            foreach ($hld as $val) {
                array_push($arrN, $val['date']);
            }
            $nO = [];
            $nC = [];
            foreach ($DateArrayOpen as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nO, $d);
                }
                $i++;
            }
            foreach ($DateArrayClose as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nC, $d);
                }
            }
            // $this->data['oD'] = array_slice($nO,0,2);
            // $this->data['cD'] = array_slice($nC,0,2);



            $this->data['marketList'][] = [
                'result' => $bazarResult['open'] . "-" . $bazarResult['jodi'] . "-" . $bazarResult['close'],
                'bazar_name' => $dataArray['bazar_name'],
                'open_time' => date('H:i:s', checkTime($dataArray['open_time'])),
                'close_time' => date('H:i:s', checkTime($dataArray['close_time'])),
                'sequence' => $dataArray['sequence'],
                'days' => $dataArray['days'],
                'bazar_id' => $dataArray['id'],
                'oD' => array_slice($nO, 0, 2),
                'cD' => array_slice($nC, 0, 2),
                'icon' => $dataArray['icon'],
                'icon1' => $dataArray['icon1'],
                'text' => $dataArray['text'],
                'text1' => $dataArray['text1'],
                'icon_status' => $dataArray['icon_status'],
                'icon_status1' => $dataArray['icon_status1'],
                'bazar_image' => $dataArray['bazar_image'],
            ];
            $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        }
        $this->load->view('user/regularMarketList-new', $this->data);
    }


    /*------------- Bhav List -----------------*/
    public function marketBhav()
    {
        $this->load->view('user/marketBhav');
    }

    /*------------- Game List -----------------*/
    public function GameTypeList($id, $result)
    {
        $this->load->model('Common_model');
        $con = " WHERE status='A'";
        $this->data['gameList'] = $this->Common_model->getData('regular_game_type', $con, '', '', '', '', 'sequence asc', '');
        $con1 = " WHERE id='" . $id . "'";
        $this->data['marketDetail'] = $this->Common_model->getData('regular_bazar', $con1, '', '', '', 'One', 'sequence asc', '');
        $con2 = " WHERE bazar_name='" . $id . "' AND result_date BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date('Y-m-d') . "' AND status='A'";
        $this->data['marketResult'] = $this->Common_model->getData('regular_bazar_result', $con2, 'result_date,open,jodi,close', '', '', '', 'result_date DESC', '');

        if (empty($_SESSION['customer_id'])) {
            $_SESSION['customer_id'] = $this->input->get('id');
        }
        // $con3 = " INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_games.game_name WHERE customer_id='".$_SESSION['customer_id']."' AND result_date='".date('Y-m-d')."' AND bazar_name='".$id."'";
        // $feilds = "regular_bazar_games.game,regular_bazar_games.game_type,regular_game_type.game_name";
        // $res = $this->Common_model->getData('regular_bazar_games',$con3,$feilds,'','','','regular_bazar_games.id DESC','');
        if (!empty($res)) {
            $this->data['userGames'] = $res;
        }
        $this->data['param'] = [
            'bazar_id' => $id,
            'bazar_result' => $result
        ];
        $con = " WHERE id='" . $id . "'";
        $marketDetail = $this->Common_model->getData('regular_bazar', $con, 'days,open_time,close_time,id', '', '', 'One', '', '');
        $days = explode(",", $marketDetail['days']);
        $time = time() + 2 * 60;
        $open = checkTime($marketDetail['open_time']);
        $close = checkTime($marketDetail['close_time']);
        $DateArrayOpen = [];
        $DateArrayClose = [];
        for ($i = 0; $i < 15; $i++) {
            if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days)) {
                if ($i == 0) {
                    if ($open > $time && $close > $time) {
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                    } else if ($open < $time && $close > $time) {
                        $n = $i + 1;
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $n . "day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                    }
                } else {
                    array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                    array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                }
            }
        }

        $con5 = " WHERE market_type='Regular' AND bazar_name='" . $id . "'";
        $hld = $this->Common_model->getData('market_holidays', $con5, 'date', '', '', '', '', '');

        $con6 = " WHERE status='P' AND customer_id='" . $_SESSION['customer_id'] . "'";
        $this->data['exposer'] = $this->Common_model->getData('regular_bazar_games', $con6, 'SUM(point)', '', '', '', '', '');
        // echo '<pre>';
        // print_r($this->data['exposer']);
        // die();
        $arrN = [];
        foreach ($hld as $val) {
            array_push($arrN, $val['date']);
        }
        $nO = [];
        $nC = [];
        foreach ($DateArrayOpen as $d) {
            if (!in_array($d, $arrN)) {
                array_push($nO, $d);
            }
            $i++;
        }
        foreach ($DateArrayClose as $d) {
            if (!in_array($d, $arrN)) {
                array_push($nC, $d);
            }
        }
        $this->data['oD'] = array_slice($nO, 0, 2);
        $this->data['cD'] = array_slice($nC, 0, 2);
        $con6 = " WHERE result_date BETWEEN '" . date('Y-m-d', strtotime('-7 day')) . "' AND '" . date('Y-m-d') . "' AND bazar_name='" . $id . "'";
        $this->data['marketResultOld'] = $this->Common_model->getData('regular_bazar_result', $con6, 'result_date,open,jodi,close', '', '', '', '', '');

        $con7 = ' WHERE id="4"';
        $this->data['buffer'] = $this->Common_model->getData('buffer', $con7, 'status,startTime,vUrl,bazar', '', '', 'One', '', '');

        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];

        // if($_GET['token']=='25da54332a349da64992c22f905000e7'){
        //     $con6=' WHERE customer_id="'.$_GET['id'].'"';
        //     $user = $this->Common_model->getData('customer',$con6,'id,customer_id','','','One','','');
        //     if(empty($user)){
        //         $url='https://laxmi999.com/index.php/psapi/get-user-detail?id='.$_GET['id'];
        //         $data=getUserDetail($url);
        //         $res = json_decode($data);
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

        $this->load->view('user/regularGameList', $this->data);
    }

    /*------------- Game Type Bet Pages -----------------*/
    public function betsOnGame($bazar_id, $type_id, $result)
    {

        $this->load->model('Common_model');
        $this->data['gameList'] = $this->Common_model->getData('matka_patti', '', '', '', '', '', 'patti asc', '');
        $con = " WHERE id='" . $bazar_id . "'";
        $marketDetail = $this->Common_model->getData('regular_bazar', $con, '', '', '', 'One', '', '');
        $con1 = " WHERE id='" . $type_id . "'";
        $gameDetail = $this->Common_model->getData('regular_game_type', $con1, '', '', '', 'One', '', '');

        $con2 = " WHERE status='A'";
        $feilds = 'id,game_name';
        $this->data['gameList'] = $this->Common_model->getData('regular_game_type', $con2, $feilds, '', '', '', 'sequence ASC', '');
        $this->data['param'] = [
            'bazar_id' => $bazar_id,
            'type_id' => $type_id,
            'bazar_result' => $result
        ];
        $this->data['marketDetail'] = $marketDetail;
        $this->data['gameDetail'] = $gameDetail;
        $time = time() + 1 * 60;
        $open = checkTime($marketDetail['open_time']);
        $close = checkTime($marketDetail['close_time']);
        $days = explode(",", $marketDetail['days']);
        $jArr = [6, 22, 11, 17, 14, 10, 23, 50, 51];
        $minMaxBet = getMinMaxBet($_GET['app']);
        
        $this->data['minBet'] = $minMaxBet['minBetLimit'];
        $this->data['maxBet'] = $minMaxBet['maxBetLimit'];
        if (in_array($type_id, $jArr)) {
            for ($i = 0; $i < 15; $i++) {
                $con3 = " WHERE market_type='Regular' AND bazar_name='" . $bazar_id . "' AND date='" . date('Y-m-d', strtotime("+" . $i . "day")) . "'";
                $holiday = $this->Common_model->getData('market_holidays', $con3, 'id', '', '', 'One', '', '');
                if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days) && !$holiday) {
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
                if (!empty($dateArray)) {
                    if (sizeof(@$dateArray) > 2) {
                        break;
                    }
                }
            }
            $this->data['status'] = array_slice($dateArray, 0, 3);
        } else {
            $DateArray = [];
            for ($i = 0; $i < 15; $i++) {
                $con4 = " WHERE market_type='Regular' AND bazar_name='" . $bazar_id . "' AND date='" . date('Y-m-d', strtotime("+" . $i . "day")) . "'";
                $holiday = $this->Common_model->getData('market_holidays', $con4, 'id', '', '', 'One', '', '');
                if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days) && !$holiday) {
                    if ($i == 0) {
                        if ($open > $time && $close > $time) {
                            $DateArray[] = [
                                'date' => date('d-m-Y', strtotime("+" . $i . "day")),
                                'game_type1' => 'Open',
                                'game_type2' => 'Close',
                            ];
                        } else if ($open < $time && $close > $time) {
                            $DateArray[] = [
                                'date' => date('d-m-Y', strtotime("+" . $i . "day")),
                                'game_type1' => 'NULL',
                                'game_type2' => 'Close',
                            ];
                        }
                    } else {
                        $DateArray[] = [
                            'date' => date('d-m-Y', strtotime("+" . $i . "day")),
                            'game_type1' => 'Open',
                            'game_type2' => 'Close',
                        ];
                    }
                }
            }
            $nArr = [];
            foreach ($DateArray as $val) {
                if (!in_array($val, $nArr)) {
                    array_push($nArr, $val);
                }
            }
            $this->data['status'] = array_slice($nArr, 0, 3);
        }
        $con3 = " WHERE status='A' AND bazar_name='" . $bazar_id . "'";
        $feilds = 'result_date,open,jodi,close';
        $this->data['gameResult'] = $this->Common_model->getData('regular_bazar_result', $con3, $feilds, '4', '', '', 'result_date DESC', '');
        // echo '<pre>';
        // print_r($this->data['gameResult']);die();
        $this->data['tUrl'] = "?token=" . $_GET['token'] . "&id=" . $_GET['id'] . "&app=" . $_GET['app'];
        if ($type_id == 5 || $type_id == 4 || $type_id == 66) {
            if ($type_id == 5) {
                $this->data['patti'] = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
            }
            if ($type_id == 4) {
                $this->data['patti'] = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
            }
            $this->load->view('user/chipsvar1', $this->data);
        } else if ($type_id == 6) {
            $this->load->view('user/chipsvar2', $this->data);
        } else if ($type_id == 18) {
            $this->load->view('user/tablevar1', $this->data);
        } else if ($type_id == 7) {
            $this->load->view('user/tablecp', $this->data);
        } else if ($type_id == 1 || $type_id == 2) {
            $this->load->view('user/patti', $this->data);
        } else if ($type_id == 26 || $type_id == 27 || $type_id == 28 || $type_id == 29 || $type_id == 25 || $type_id == 30 || $type_id == 31 || $type_id == 32 || $type_id == 33) {
            $this->load->view('user/patti2', $this->data);
        } else if ($type_id == 14) {
            $this->load->view('user/tablegj', $this->data);
        } else if ($type_id == 12 || $type_id == 13) {
            $this->load->view('user/tablemotor', $this->data);
        } else if ($type_id == 15 || $type_id == 16) {
            $this->load->view('user/tableabr', $this->data);
        } else if ($type_id == 17) {
            $this->load->view('user/tablejc', $this->data);
        } else if ($type_id == 19 || $type_id == 20) {
            $this->load->view('user/tablepana', $this->data);
        } else if ($type_id == 10 || $type_id == 22 || $type_id == 23) {
            $this->load->view('user/pattiRb', $this->data);
        } else if ($type_id == 11) {
            $this->load->view('user/tabledbj', $this->data);
        } else if ($type_id == 24) {
            $this->load->view('user/chipsvar2pana', $this->data);
        } else if ($type_id == 50) {
            $this->load->view('user/halfsangam', $this->data);
        } else if ($type_id == 51) {
            $this->load->view('user/fullsangam', $this->data);
        }
    }

    /*------------- Place Bet Pages -----------------*/

    public function PlaceBets()
    {
        if (isset($_POST['bazar_name']) && isset($_POST['game_name']) && isset($_POST['game_type']) && isset($_POST['games']) && isset($_POST['result_date'])) {
            
            checkBetData($_post, 'Regular');
           
            $date = date('Y-m-d', strtotime($_POST['result_date']));
            $this->load->model('Common_model');
            $bazarTime = $this->Common_model->getData('regular_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', '', '', '', 'One', '', '');
            
            $time = strtotime(date('Y-m-d H:i:s')) + 1 * 60;
            $open = strtotime(date('Y-m-d ' . $bazarTime['open_time']));
            $close = strtotime(date('Y-m-d ' . $bazarTime['close_time']));

            $days = explode(",", $bazarTime['days']);
            $jArr = ['6', '22', '11', '17', '14', '10', '23'];
            if ($date < date('Y-m-d')) {
                $array = [
                    'message' => 'Invalid date!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            }
            $_POST['game_type'] = strtolower($_POST['game_type']);
            if (($_POST['game_type'] == "full sangam" && $open < $time && $date == date('Y-m-d')) || ($_POST['game_type'] == "half sangam" && $open < $time && $date == date('Y-m-d'))) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            }
           

            if ($_POST['game_type'] == "jodi" && $open < $time && $date == date('Y-m-d')) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            }
            if (in_array($_POST['game_name'], $jArr) && $open < $time && $date == date('Y-m-d')) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            } else if ($_POST['game_type'] == "open" && $open < $time && !in_array(date("D", strtotime($date)), $days) && $date == date('Y-m-d')) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            } else if ($_POST['game_type'] == "close" && $close < $time && !in_array(date("D", strtotime($date)), $days) && $date == date('Y-m-d')) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            } else if (($_POST['game_type'] == "open" && $open < $time && $date == date('Y-m-d')) || ($_POST['game_type'] == "close" && $close < $time && $date == date('Y-m-d')) || ($_POST['game_type'] == "jodi" && $open < $time && $date == date('Y-m-d')) && !in_array(date("D", strtotime($date)), $days)) {
                $array = [
                    'message' => 'Todays Betting Is Closed!.',
                    'Code' => 203,
                ];
                die(json_encode($array));
            } else if (!empty($_POST['games'])) {
                if($_POST['tokenId']=='b2c'){
                    $client = $this->Common_model->getData('user', ' WHERE id="' . $_SESSION['usid']->id . '"', 'id,balance', '', '', 'One', '', '');
                    
                    $res = json_decode($data);
                }else{
                    $client = $this->Common_model->getData('client', ' WHERE client_token="' . $_POST['tokenId'] . '"', 'end_point_url,id,currancy_rate', '', '', 'One', '', '');
                    $data = requestForClient($client['end_point_url'], ['id' => $_POST['customer_id'], 'code' => '300']);
                    $res = json_decode($data);
                }
                
                if ($res->Code == '200' && $res->data[0] >= $_POST['totalA']) {
                    $_SESSION['balance'] = $res->data[0];
                    $cArr['arr'] = [];
                    $bName = $this->Common_model->getData('regular_bazar', ' WHERE id="' . $_POST['bazar_name'] . '"', 'bazar_name', '', '', 'One', '', '');
                    $gName = $this->Common_model->getData('regular_game_type', ' WHERE id="' . $_POST['game_name'] . '"', 'game_name', '', '', 'One', '', '');
                    $arrBets['arr'] = [];
                    $betArrTransaction = [];
                    foreach ($_POST['games'] as $arr) {
                        if ($arr['coin'] > 0 && $_SESSION['balance'] >= $arr['coin']) {
                            if ($_POST['game_name'] == '5' && $arr['coin'] < 10) {
                                continue;
                            } else if ($arr['coin'] < 5) {
                                continue;
                            }
                            if (strlen($arr['akda']) > 7) {
                                continue;
                            }
                            $betArr = [];
                            $betArr['transaction_id'] = transactionID(22, 22) . time();
                            array_push($betArrTransaction, $betArr['transaction_id']);
                            $betArr['bazar_name'] = (int)$_POST['bazar_name'];
                            $betArr['game_name'] = (int)$_POST['game_name'];

                            if ($arr['gameName'] != '') {
                                $gName = $this->Common_model->getData('regular_game_type', ' WHERE id="' . $arr['gameName'] . '"', 'game_name', '', '', 'One', '', '');
                                $betArr['game_name'] = (int)$arr['gameName'];
                            } else {
                                $betArr['game_type'] = $arr['game_type'];
                            }

                            if ($_POST['game_type'] == 'List') {
                                $betArr['game_type'] = $arr['game_type'];
                            } else {
                                $betArr['game_type'] = $_POST['game_type'];
                            }
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
                            // $add = AddUpdateTable('regular_bazar_games','','',$betArr);
                            $_SESSION['balance'] = $_SESSION['balance'] - $arr['coin'];

                            $betArr['bazar_id'] = $betArr['bazar_name'];
                            $betArr['game_id'] = $betArr['game_name'];
                            $betArr['bazar_name'] = $bName['bazar_name'];
                            $betArr['game_name'] = $gName['game_name'];
                            unset($betArr['point_in_rs']);
                            unset($betArr['partner_id']);
                            unset($betArr['updated']);
                            array_push($cArr['arr'], $betArr);
                        } else {
                            $array = [
                                "message" => "You Dont Have Sufficient Balance.",
                                "code" => 203,
                            ];
                            die(json_encode($array));
                            break;
                        }
                    }
                    $conversion = exchangeCurrency($_POST['app'], 'INR');
                    $betValidation = getMinMaxBet($_POST['app']);
                    if ($conversion['status']) {
                        $loopLimit = count($arrBets['arr']);
                        for ($x = 0; $x < $loopLimit; $x++) {
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
                        $add = newAddUpdateTable('regular_bazar_games', '', '', $arrBets['arr']);
                        if ($add) {
                            $cArr['arr'] = json_encode($cArr['arr']);
                            $cArr['code'] = '301';
                            $cArr['id'] = $_POST['customer_id'];
                            $req = requestForClient($client['end_point_url'], $cArr);
                            betResponseLog(["Regular Market", $client['end_point_url'], $cArr, $req]);
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
                                $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);
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


    /*------------- Users History -----------------*/

    public function usersHistory($partnerId)
    {
        $id = $_GET['id'];
        $this->load->model('Common_model');
        // $con=" INNER JOIN regular_bazar ON regular_bazar_games.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_games.game_name WHERE regular_bazar_games.partner_id='".$partnerId."' AND regular_bazar_games.customer_id='".$id."'";
        $con = " INNER JOIN regular_bazar ON regular_bazar_games.bazar_name = regular_bazar.id INNER JOIN regular_game_type ON regular_game_type.id = regular_bazar_games.game_name WHERE regular_bazar_games.customer_id='" . $id . "'";
        $feilds = 'regular_bazar.bazar_name, regular_game_type.game_name, regular_bazar_games.result_date, regular_bazar_games.point, regular_bazar_games.game_type, regular_bazar_games.game, regular_bazar_games.status, regular_bazar_games.winning_point, regular_bazar_games.commission, regular_bazar_games.created';
        $this->data['pID'] = $partnerId;
        $this->data['cID'] = $id;
        $this->data['gameList'] = $this->Common_model->getData('regular_bazar_games', $con, $feilds, '25', '0', '', 'regular_bazar_games.id DESC', '');
        $this->load->view('user/usersHistory', $this->data);
    }

    public function getUserHistory()
    {
        $this->load->model('Common_model');
        if ($_SESSION['partner']['id'] == '') {
            $_SESSION['partner']['id'] = $_POST['partner'];
            $_SESSION['customer_id'] = $_POST['id'];
        }
        if ($_POST['tbl'] == "warli_users_game") {
            $con = " INNER JOIN regular_game_type ON warli_users_game.game_name = regular_game_type.id WHERE partner_id='" . $_SESSION['partner']['id'] . "' AND customer_id='" . $_SESSION['customer_id'] . "'";
            $feilds = 'warli_users_game.commission, warli_users_game.result_date, regular_game_type.game_name, warli_users_game.point, warli_users_game.game, warli_users_game.status, warli_users_game.winning_point, warli_users_game.round_id, warli_users_game.created';
            $data = $this->Common_model->getData($_POST['tbl'], $con, $feilds, '25', '0', '', '', '');
            $dome = "";
            $dome .= "<table class='table table-responsive text-center'>
                        <thead></thead>
                        <tbody>
                            <tr>
                                <th>Sr.</th>
                                <th>Round Id</th>
                                <th>Game Name</th>
                                <th>Result Date</th>
                                <th>Point</th>
                                <th>Game</th>
                                <th>Status</th>
                                <th>Winning Point</th>
                                <th>Commission</th>
                                <th>Bet Time</th>
                            </tr>";
            $i = 1;
            foreach ($data as $r) {
                $dome .= "<tr>
                                    <td>" . $i . "</td>
                                    <td>" . $r['round_id'] . "</td>
                                    <td>" . $r['game_name'] . "</td>
                                    <td>" . $r['result_date'] . "</td>
                                    <td>" . $r['point'] . "</td>
                                    <td>" . $r['game'] . "</td>
                                    <td>" . $r['status'] . "</td>
                                    <td>" . $r['winning_point'] . "</td>
                                    <td>" . $r['commission'] . "</td>
                                    <td>" . $r['created'] . "</td>
                                </tr>";
                $i++;
            }
            $dome .= "</tbody>
                    </table>";
            die($dome);
        } else if ($_POST['tbl'] == "starline_bazar_game") {
            $con = " INNER JOIN starline_bazar ON starline_bazar_game.bazar_name = starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_time.id = starline_bazar_game.time WHERE starline_bazar_game.partner_id='" . $_SESSION['partner']['id'] . "' AND starline_bazar_game.customer_id='" . $_SESSION['customer_id'] . "'";
            $feilds = 'starline_bazar.bazar_name, starline_bazar_time.time, starline_bazar_game.result_date, starline_bazar_game.point, starline_bazar_game.game, starline_bazar_game.status, starline_bazar_game.winning_point, starline_bazar_game.created';
            $or = 'starline_bazar_game.id DESC';
            $data = $this->Common_model->getData($_POST['tbl'], $con, $feilds, '', '', '', $or, '');
            $dome = "";
            $dome .= "<table class='table table-responsive text-center'>
                        <thead></thead>
                        <tbody>
                            <tr>
                                <th>Sr.</th>
                                <th>Bazar Name</th>
                                <th>Time</th>
                                <th>Result Date</th>
                                <th>Point</th>
                                <th>Game</th>
                                <th>Winning Point</th>
                                <th>Bet Time</th>
                            </tr>";
            $i = 1;
            foreach ($data as $r) {
                $dome .= "<tr>
	                                <td>" . $i . "</td>
	                                <td>" . $r['bazar_name'] . "</td>
	                                <td>" . $r['time'] . "</td>
	                                <td>" . $r['result_date'] . "</td>
	                                <td>" . $r['point'] . "</td>
	                                <td>" . $r['game'] . "</td>
	                                <td>" . $r['winning_point'] . "</td>
                                    <td>" . $r['created'] . "</td>
	                            </tr>";
                $i++;
            }
            $dome .= "</tbody>
                    </table>";
            die($dome);
        } else {
            $con = " INNER JOIN king_bazar ON king_bazar_game.bazar_name = king_bazar.id WHERE king_bazar_game.partner_id='" . $_SESSION['partner']['id'] . "' AND king_bazar_game.customer_id='" . $_SESSION['customer_id'] . "'";
            $feilds = 'king_bazar.bazar_name, king_bazar_game.result_date, king_bazar_game.game_name, king_bazar_game.point, king_bazar_game.game, king_bazar_game.status, king_bazar_game.winning_point, king_bazar_game.created';
            $or = 'king_bazar_game.id DESC';
            $data = $this->Common_model->getData($_POST['tbl'], $con, $feilds, '', '', '', $or, '');
            $dome = "";
            $dome .= "<table class='table table-responsive text-center'>
                        <thead></thead>
                        <tbody>
                            <tr>
                                <th>Sr.</th>
                                <th>Bazar Name</th>
                                <th>Game Name</th>
                                <th>Result Date</th>
                                <th>Point</th>
                                <th>Game</th>
                                <th>Winning Point</th>
                                <th>Bet Time</th>
                            </tr>";
            $i = 1;
            foreach ($data as $r) {
                if ($r['game_name'] == 1) {
                    $game_name = "FIRST DIGIT(EKAI)";
                } else if ($r['game_name'] == 2) {
                    $game_name = "SECOND DIGIT(HARUF)";
                } else {
                    $game_name = "JODI";
                }
                $dome .= "<tr>
	                                <td>" . $i . "</td>
	                                <td>" . $r['bazar_name'] . "</td>
	                                <td>" . $game_name . "</td>
	                                <td>" . $r['result_date'] . "</td>
	                                <td>" . $r['point'] . "</td>
	                                <td>" . $r['game'] . "</td>
	                                <td>" . $r['winning_point'] . "</td>
                                    <td>" . $r['created'] . "</td>
	                            </tr>";
                $i++;
            }
            $dome .= "</tbody>
                    </table>";
            die($dome);
        }
    }


    public function resultRequest()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://matka-stg.livedealersol.com/api/ClientData/GameData",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: e701853c-0413-9a00-3a59-2ede7996c11d"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


    /*------------- Striming Result -----------------*/

    public function strimingResult()
    {
        if (isset($_POST['token']) && isset($_POST['result']) && isset($_POST['type'])) {
            if (strlen((string)$_POST['result']) != 3 && $_POST['type'] != 'Kg') {
                $arr = [
                    'status' => 300,
                    'massage' => 'Result Should Be 3 Digit!'
                ];
            } else {
                $notifyMe = [];
                if ($_POST['type'] == 'Rg') {
                    $a = $_POST['result'];
                    $ak = (int)$a[0] + (int)$a[1] + (int)$a[2];
                    if ($ak > 9) {
                        $akda = abs($ak % 10);
                    } else {
                        $akda = $ak;
                    }
                    $this->load->model('Common_model');
                    $bazarResult = $this->Common_model->getData('regular_bazar_result', ' WHERE token_close="' . $_POST['token'] . '" AND status="A"', 'id,open,jodi,bazar_name', '', '', 'One', '', '');
                    if ($bazarResult) {
                        $addResult['close'] = $_POST['result'];
                        $addResult['jodi'] = $bazarResult['jodi'] . $akda;
                        $wU = 'Close';

                        $sR['open_result'] = $bazarResult['open'];
                        $sR['close_result'] = $addResult['close'];
                        $sR['jodi_result'] = $addResult['jodi'];

                        $dnew['open'] = (string)$bazarResult['open'];
                        $dnew['jodi'] = (string)$addResult['jodi'];
                        $dnew['close'] = (string)$addResult['close'];
                    } else {
                        $bazarResult = $this->Common_model->getData('regular_bazar_result', ' WHERE token_open="' . $_POST['token'] . '" AND status="I"', 'id,bazar_name', '', '', 'One', '', '');
                        $addResult['open'] = $_POST['result'];
                        $addResult['jodi'] = $akda;
                        $addResult['status'] = 'A';
                        $wU = 'Open';

                        $sR['open_result'] = $addResult['open'];
                        $sR['jodi_result'] = $addResult['jodi'];
                        $sR['close_result'] = '';

                        $dnew['open'] = (string)$addResult['open'];
                        $dnew['jodi'] = (string)$addResult['jodi'];
                        $dnew['close'] = NULL;
                    }
                    if (empty($bazarResult)) {
                        $arr = [
                            'status' => 402,
                            'massage' => 'Invalid Token'
                        ];
                        die(json_encode($arr));
                    } else {
                        $arr = [
                            'status' => 200,
                            'message' => 'Result Updated Successfully!'
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
                        $addUpdate = AddUpdateTable('regular_bazar_result', 'id', $bazarResult['id'], $addResult);

                        /*------------------------ Notify Users -------------------------*/

                        $notifyResult['market'] = 'Regular';
                        $notifyResult['type'] = $wU;
                        $notifyResult['result'] = $dnew['open'] . '-' . $dnew['jodi'] . '-' . $dnew['close'];
                        $notifyResult['bazarID'] = $bazarResult['bazar_name'];
                        $notifyResult['url'] = '9a27a7e97c16a7b3ac6382d21205357f/' . $bazarResult['bazar_name'];

                        notifyUserWithResult(json_encode($notifyResult));

                        /*------------------------ Update Wallet Start -------------------------*/
                        if ($wU == 'Close') {
                            $win = getWinnersClose($bazarResult['id']);
                        } else {
                            $win = getWinnersOpen($bazarResult['id']);
                        }

                        if (!empty($win)) {
                            $type = '';
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

                            foreach ($win as $data) {
                                $bet = $this->Common_model->getData('regular_bazar_games', ' WHERE id="' . $data . '"', 'partner_id,customer_id,bazar_name,game_name,result_date,point,game_type', '', '', 'One', '', '');
                                $rate = $this->Common_model->getData('regular_bazar_rate', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_name="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');
                                if ($bet['partner_id'] == '2') {
                                    $commission = $lC;
                                } else if ($bet['partner_id'] == '4') {
                                    $commission = $fbC;
                                } else {
                                    $commission = $oC;
                                }
                                $rOC = $this->Common_model->getData('customer_rate', ' WHERE customer_id="' . $bets['customer_id'] . '" AND partner_id="' . $bets['partner_id'] . '"', 'rate', '', '', 'One', '', '');
                                if ($rOC) {
                                    $win = ($bet['point'] * $rate['rate']) * ((100 - $rOC['rate']) / 100);
                                    $addRes['commission'] = ($commission / 100) * $win;
                                    $addRes['winning_point'] = $win - $addRes['commission'];
                                } else {
                                    $addRes['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
                                    $addRes['winning_point'] = ($bet['point'] * $rate['rate']) - $addRes['commission'];
                                }


                                $addRes['winning_in_rs'] = $addRes['winning_point'] * (float)$cR[$bet['partner_id']];
                                $addRes['commission_in_rs'] = $addRes['commission'] * (float)$cR[$bet['partner_id']];

                                $addRes['status'] = 'W';

                                $updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addRes);
                                if (empty($type)) {
                                    if ($bet['game_type'] == 'Open') {
                                        $type = ' AND game_type="Open"';
                                    } else {
                                        $type = ' AND game_type!="Open"';
                                    }
                                }
                                // array_push($notifyMe, $bet['customer_id']);
                            }
                        }

                        $con = " WHERE result_date='" . $bet['result_date'] . "' AND status='P' AND bazar_name='" . $bet['bazar_name'] . "'" . $type;
                        $field['status'] = "L";
                        $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);

                        /*--------------------- Setel Market Start --------------------------*/
                        $con1 = " INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.result_date='" . $bet['result_date'] . "' AND regular_bazar_games.bazar_name='" . $bet['bazar_name'] . "'" . $type;


                        $arrLoss = $this->Common_model->getData('regular_bazar_games', $con1, 'DISTINCT regular_bazar_games.partner_id,client.end_point_url', '', '', '', '', '');
                        $multiUrl = [];
                        $multiData = [];
                        $multiI = 0;
                        foreach ($arrLoss as $l) {
                            $con = " WHERE result_date='" . $bet['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bet['bazar_name'] . "'" . $type;
                            if ($l['partner_id'] == '2' || $l['partner_id'] == '5' || $l['partner_id'] == '7') {
                                $con .= ' AND status="W"';
                                $arrReq['result_date'] = $bet['result_date'];
                                $arrReq['bazar_id'] = $bet['bazar_name'];
                                $arrReq['type'] = $type;
                            }
                            $arrLossBet = $this->Common_model->getData('regular_bazar_games', $con, 'transaction_id,status,winning_point,commission,customer_id', '', '', '', '', '');
                            $arrReq['code'] = '601';
                            $arrReq['rec'] = json_encode($arrLossBet);
                            $arrReq['market'] = 'Regular Bazar';
                            $arrReq['market_code'] = '301';
                            // $req = requestForClient($l['end_point_url'],$arrReq);
                            // if($l['partner_id']=="4"){
                            //     responseLog($arrReq);
                            // }
                            $multiUrl[$multiI] = $l['end_point_url'];
                            $multiData[$multiI] = $arrReq;
                            $multiI++;
                        }
                        $req = requestForMultiClient($multiUrl, $multiData);
                        responseLog($req);
                        responseLog($multiData);
                        responseLog($multiUrl);
                        $arr = [
                            'status' => 200,
                            'message' => 'Wallet Updated Successfully!'
                        ];
                        /*--------------------- Setel Market End --------------------------*/
                        /*--------------------- notifyMe Start --------------------------*/
                        $con1 = " WHERE result_date='" . $bet['result_date'] . "' AND bazar_name='" . $bet['bazar_name'] . "'" . $type;
                        $notifyMeW['userList'] = $this->Common_model->getData('regular_bazar_games', $con1 . ' AND status="W"', 'customer_id as id,status,commission', '', '', '', '', '');


                        requestForBalance(json_encode($notifyMeW));
                        /*--------------------- notifyMe End --------------------------*/
                        /*--------------------- send Result to dpboss Start --------------------------*/
                        $con2 = " WHERE id='" . $bazarResult['bazar_name'] . "'";
                        $sendRes = $this->Common_model->getData('regular_bazar', $con2, 'bazar_name', '', '', 'One', '', '');

                        $sR['bazar_name'] = $bet['bazar_name'];
                        $sR['result_date'] = $bet['result_date'];
                        $url = 'https://channapoha.com/postdata';
                        sendResultDpboss($sR, $url);
                        /*--------------------- send Result to dpboss End --------------------------*/

                        /*--------------------- send Result to dpboss new project Start --------------------------*/
                        $dnew['bazarId'] = (int)$bet['bazar_name'];
                        $dnew['resultDate'] = $bet['result_date'];
                        $dnew['marketCode'] = 301;
                        // $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
                        $url = config_item('resultsite_url');
                        $res = sendResultDpbossNewProject(json_encode($dnew), $url);
                        $addResData['response'] = $res;
                        $addResData['client_id'] = 0;
                        $addUpdate = AddUpdateTable('client_response', '', '', $addResData);
                        /*--------------------- send Result to dpboss new project End --------------------------*/
                        /*------------------------ Update Wallet End -------------------------*/
                    }
                } else if ($_POST['type'] == 'St') {
                    $a = $_POST['result'];
                    $ak = (int)$a[0] + (int)$a[1] + (int)$a[2];
                    if ($ak > 9) {
                        $akda = substr($ak, -1);
                    } else {
                        $akda = $ak;
                    }
                    $this->load->model('Common_model');
                    $bazarResult = $this->Common_model->getData('starline_bazar_result', ' WHERE token="' . $_POST['token'] . '" AND status="I"', '', '', '', 'One', '', '');

                    if ($bazarResult) {
                        $arr = [
                            'status' => 200,
                            'message' => 'Result Updated Successfully!'
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

                        $addRes['result_patti'] = $_POST['result'];
                        $addRes['result_akda'] = $akda;
                        $addRes['status'] = 'A';

                        $addUpdate = AddUpdateTable('starline_bazar_result', 'id', $bazarResult['id'], $addRes);
                        $winStar = getWinnersStar($bazarResult['id']);
                        if (!empty($winStar)) {
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

                            foreach ($winStar as $data) {
                                $con = ' INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id WHERE starline_bazar_game.id="' . $data . '"';
                                $feilds = 'starline_bazar_game.partner_id,starline_bazar_game.customer_id,starline_bazar_game.bazar_name,starline_bazar_game.game_name,starline_bazar_game.result_date,starline_bazar_game.time,starline_bazar_game.point,starline_bazar_time.time as timeId';

                                $bet = $this->Common_model->getData('starline_bazar_game', $con, $feilds, '', '', 'One', '', '');
                                // $bet = $this->Common_model->getData('starline_bazar_game',' WHERE id="'.$data.'"','partner_id,customer_id,bazar_name,game_name,result_date,time,point','','','One','','');
                                $rate = $this->Common_model->getData('starline_bhav', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_name="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');

                                $rOC = $this->Common_model->getData('customer_rate', ' WHERE customer_id="' . $bets['customer_id'] . '" AND partner_id="' . $bets['partner_id'] . '"', 'rate', '', '', 'One', '', '');
                                if ($bet['partner_id'] == '2') {
                                    $commission = $lC;
                                }
                                if ($bet['partner_id'] == '4') {
                                    $commission = $fbC;
                                }
                                if ($rOC) {
                                    $win = ($bet['point'] * $rate['rate']) * ((100 - $rOC['rate']) / 100);
                                    $addR['commission'] = ($commission / 100) * $win;
                                    $addR['winning_point'] = $win - $addR['commission'];
                                } else {
                                    $addR['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
                                    $addR['winning_point'] = ($bet['point'] * $rate['rate']) - $addR['commission'];
                                }
                                $addR['status'] = 'W';
                                $addR['winning_in_rs'] = $addR['winning_point'] * (float)$cR[$bet['partner_id']];
                                $addR['commission_in_rs'] = $addR['commission'] * (float)$cR[$bet['partner_id']];

                                $updateresultid = AddUpdateTable('starline_bazar_game', 'id', $data, $addR);
                            }
                        } else {
                            $bet = $bazarResult;
                        }

                        $con = " WHERE result_date='" . $bet['result_date'] . "' AND status='P' AND bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";
                        $field['status'] = "L";
                        $updateresultLose = updateAllLose('starline_bazar_game', $con, $field);

                        /*--------------------- Setel Market Start --------------------------*/
                        $con1 = " INNER JOIN client ON starline_bazar_game.partner_id = client.id WHERE starline_bazar_game.result_date='" . $bet['result_date'] . "' AND starline_bazar_game.bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";

                        $arrLossPartner = $this->Common_model->getData('starline_bazar_game', $con1, 'DISTINCT starline_bazar_game.partner_id,client.end_point_url', '', '', '', '', '');
                        foreach ($arrLossPartner as $l) {
                            $con = " WHERE result_date='" . $bet['result_date'] . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";
                            if ($l['partner_id'] == '2') {
                                $con .= ' AND status="W"';
                                $arrReq['result_date'] = $bet['result_date'];
                                $arrReq['bazar_id'] = $bet['bazar_name'];
                                $arrReq['time'] = $bet['timeId'];
                            }
                            $arrLossBet = $this->Common_model->getData('starline_bazar_game', $con, 'transaction_id,winning_point,status,commission,customer_id', '', '', '', '', '');
                            $arrReq['code'] = '601';
                            $arrReq['rec'] = json_encode($arrLossBet);
                            $arrReq['market'] = 'Starline Bazar';

                            $arrReq['market_code'] = '401';
                            $req = requestForClient($l['end_point_url'], $arrReq);
                        }
                        /*--------------------- Setel Market End --------------------------*/
                        /*--------------------- notifyMe Start --------------------------*/
                        $con1 = " WHERE result_date='" . $bet['result_date'] . "' AND bazar_name='" . $bet['bazar_name'] . "' AND time='" . $bet['time'] . "'";


                        $notifyMeW['userList'] = $this->Common_model->getData('starline_bazar_game', $con1 . ' AND status="W"', 'customer_id as id,status', '', '', '', '', '');
                        $notifyMeL['userList'] = $this->Common_model->getData('starline_bazar_game', $con1 . ' AND status="L"', 'customer_id as id,status', '', '', '', '', '');

                        /*--------------------- notifyMe End --------------------------*/
                        $arr = [
                            'status' => 200,
                            'message' => 'Wallet Updated Successfully!'
                        ];
                    } else {
                        $arr = [
                            'status' => 402,
                            'massage' => 'Invalid Token'
                        ];
                        die(json_encode($arr));
                    }
                } else if ($_POST['type'] == 'Kg') {
                    $this->load->model('Common_model');
                    $bazarResult = $this->Common_model->getData('king_bazar_result', ' WHERE token="' . $_POST['token'] . '" AND status="I"', 'id,result_date,bazar_name', '', '', 'One', '', '');
                    if ($bazarResult) {
                        $arr = [
                            'status' => 200,
                            'message' => 'Result Updated Successfully!'
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

                        $addResult['result'] = $_POST['result'];
                        $addResult['status'] = 'A';
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
                            $arrReq['rec'] = json_encode($arrLossBet);
                            $arrReq['market'] = 'King Bazar';
                            $arrReq['market_code'] = '501';
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
                    } else {
                        $arr = [
                            'status' => 402,
                            'massage' => 'Invalid Token'
                        ];
                        die(json_encode($arr));
                    }
                }
                if ($addUpdate) {
                    // requestForBalance(json_encode($notifyMeW));
                    // requestForBalance(json_encode($notifyMeL));
                    $arr = [
                        'status' => 200,
                        'massage' => 'Result Updated Successfully'
                    ];
                } else {
                    $arr = [
                        'status' => 400,
                        'massage' => 'Something Went Wrong!'
                    ];
                }
            }
        } else {
            $arr = [
                'status' => 401,
                'massage' => 'Please Provide Valid Data!123456'
            ];
        }
        die(json_encode($arr));
    }

    public function loopResult()
    {
        $this->load->model('Common_model');
        $market = $this->Common_model->getData('regular_bazar', ' WHERE status="A"', 'id,days', '', '', '', '', '');
        $arrG = ['8', '9', '11', '13', '15', '19', '23', '24', '25'];
        for ($i = 0; $i < 19; $i++) {
            foreach ($market as $m) {
                $days = explode(",", $m['days']);
                // if(in_array($m['id'],[74,75,78,79]) && date('Y-m-d',strtotime("+".$i." day"))=='2024-08-31'){
                //     die(json_encode($days));
                // }
                if (!in_array($m['id'], $arrG)) {
                    $arr['result_date'] = date('Y-m-d', strtotime("+" . $i . " day"));
                    $res = $this->Common_model->getData('regular_bazar_result', ' WHERE bazar_name="' . $m['id'] . '" AND result_date="' . $arr['result_date'] . '"', 'id', '', '', '', '', '');
                    if (!$res) {
                        if (in_array(date('D', strtotime($arr['result_date'])), $days)) {
                            $arr['token_open'] = transactionID(10, 10) . time();
                            $arr['token_close'] = transactionID(10, 10) . time();
                            $arr['bazar_name'] = $m['id'];
                            $arr['status'] = 'I';
                            $arr['announcer'] = 0;
                            $addUpdate = AddUpdateTable('regular_bazar_result', '', '', $arr);
                            if (!$addUpdate) {
                                $arr['token_open'] = transactionID(10, 10) . time();
                                $arr['token_close'] = transactionID(10, 10) . time();
                                AddUpdateTable('regular_bazar_result', '', 'id', $arr);
                            }
                        }
                    }
                }
            }
        }
        echo 'Done';
    }


    public function getResultDataForIframe()
    {
        $res = $this->db->query("SELECT regular_bazar_result.token_open, CONCAT(regular_bazar_result.result_date, ' ' ,regular_bazar.open_time) AS result_date, regular_bazar.bazar_name FROM regular_bazar_result INNER JOIN regular_bazar ON regular_bazar_result.bazar_name=regular_bazar.id WHERE regular_bazar.status='A' AND regular_bazar_result.result_date>'2024-12-15'");
        $bO = $res->result_array();
        $res1 = $this->db->query("SELECT regular_bazar_result.token_close, CONCAT(regular_bazar_result.result_date, ' ' ,regular_bazar.close_time) AS result_date, regular_bazar.bazar_name FROM regular_bazar_result INNER JOIN regular_bazar ON regular_bazar_result.bazar_name=regular_bazar.id WHERE regular_bazar.status='A' AND regular_bazar_result.result_date>'2024-12-15'");
        $bC = $res1->result_array();
        $fp = fopen('file.csv', 'wb');
        $data = [];
        $i = 0;
        foreach ($bO as $b) {
            $b['result_date'] = date('d-m-Y H:i:s', strtotime($b['result_date']));
            $bC[$i]['result_date'] = date('d-m-Y H:i:s', strtotime($bC[$i]['result_date']));
            array_push($data, $b);
            array_push($data, $bC[$i]);
            $i++;
        }

        foreach ($data as $h) {
            fputcsv($fp, $h);
        }
        fclose($fp);
        echo '<pre>';
        print_r($data);
        die();
    }



    public function loopResultStarline()
    {
        $this->load->model('Common_model');
        $market = $this->Common_model->getData('starline_bazar', ' WHERE status="A"', 'id', '', '', '', '', '');
        for ($i = 0; $i < 33; $i++) {
            foreach ($market as $m) {
                $arr['result_date'] = date('Y-m-d', strtotime("+" . $i . " day"));
                $time = $this->Common_model->getData('starline_bazar_time', ' WHERE status="A" AND bazar_name="' . $m['id'] . '"', 'id', '', '', '', '', '');
                foreach ($time as $t) {
                    $res = $this->Common_model->getData('starline_bazar_result', ' WHERE bazar_name="' . $m['id'] . '" AND result_date="' . $arr['result_date'] . '" AND time="' . $t['id'] . '"', 'id', '', '', '', '', '');
                    if (!$res) {
                        $arr['token'] = transactionID(10, 10);
                        $arr['bazar_name'] = $m['id'];
                        $arr['time'] = $t['id'];
                        $arr['status'] = 'I';
                        $arr['announcer'] = 0;
                        $addUpdate = AddUpdateTable('starline_bazar_result', '', '', $arr);
                        if (!$addUpdate) {
                            $arr['token_open'] = transactionID(10, 10);
                            AddUpdateTable('starline_bazar_result', '', '', $arr);
                        }
                    }
                }
            }
        }
        echo 'Done';
    }

    public function getResultDataForIframeStarline()
    {
        $res = $this->db->query("SELECT starline_bazar_result.token, CONCAT(starline_bazar_result.result_date, ' ' ,starline_bazar_time.time) AS result_date, starline_bazar.bazar_name FROM starline_bazar_result INNER JOIN starline_bazar_time ON starline_bazar_result.time=starline_bazar_time.id INNER JOIN starline_bazar ON starline_bazar_result.bazar_name=starline_bazar.id WHERE starline_bazar_result.result_date>'2022-10-31'");
        $bO = $res->result_array();
        $fp = fopen('fileStarline.csv', 'wb');
        $data = [];
        $i = 0;
        foreach ($bO as $b) {
            array_push($data, $b);
            $i++;
        }

        foreach ($data as $h) {
            fputcsv($fp, $h);
        }
        // fclose($fp);
        echo '<pre>';
        print_r($data);
        die();
    }

    public function loopResultKing()
    {
        $this->load->model('Common_model');
        $market = $this->Common_model->getData('king_bazar', ' WHERE status="A"', 'id,bazar_name', '', '', '', '', '');
        for ($i = 0; $i < 33; $i++) {
            foreach ($market as $m) {
                $arrG = ['13', '3', '10', '8'];
                if (!in_array($m['id'], $arrG)) {
                    $arr['result_date'] = date('Y-m-d', strtotime("+" . $i . " day"));
                    $res = $this->Common_model->getData('king_bazar_result', ' WHERE bazar_name="' . $m['id'] . '" AND result_date="' . $arr['result_date'] . '"', 'id', '', '', '', '', '');
                    if (!$res) {
                        $arr['token'] = transactionID(10, 10);
                        $arr['bazar_name'] = $m['id'];
                        $arr['status'] = 'I';
                        $arr['announcer'] = 0;
                        $addUpdate = AddUpdateTable('king_bazar_result', '', '', $arr);
                        if (!$addUpdate) {
                            $arr['token_open'] = transactionID(10, 10);
                            AddUpdateTable('king_bazar_result', '', '', $arr);
                        }
                    }
                }
            }
        }
        echo 'Done';
    }

    public function getResultDataForIframeKing()
    {
        $res = $this->db->query("SELECT king_bazar_result.token, CONCAT(king_bazar_result.result_date, ' ' ,king_bazar.time) AS result_date, king_bazar.bazar_name FROM king_bazar_result INNER JOIN king_bazar ON king_bazar_result.bazar_name=king_bazar.id WHERE king_bazar_result.result_date>'2022-10-31'");
        $bO = $res->result_array();
        $fp = fopen('fileking.csv', 'wb');
        $data = [];
        $i = 0;
        foreach ($bO as $b) {
            array_push($data, $b);
            $i++;
        }

        foreach ($data as $h) {
            fputcsv($fp, $h);
        }
        fclose($fp);
        echo '<pre>';
        print_r($data);
        die();
    }

    public function ApiBazarList()
    {
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        if ($_POST['app'] == 'BD') {
            $con .= ' AND bazar_type!="Out"';
        }
        $List = $this->Common_model->getData('regular_bazar', $con, '', '', '', '', 'open_time ASC', '');
        $data['marketList'] = [];
        if (isset($_POST['app'])) {
            $_GET['app'] = $_POST['app'];
        }
        foreach ($List as $dataArray) {
            $days = explode(",", $dataArray['days']);
            $con = ' WHERE result_date="' . date('Y-m-d') . '" AND bazar_name="' . $dataArray['id'] . '" AND status="A"';
            $bazarResult = $this->Common_model->getData('regular_bazar_result', $con, '', '', '', 'One', 'id DESC', '');
            if (empty($bazarResult)) {
                $con1 = ' WHERE result_date="' . date('Y-m-d', strtotime("-1 days")) . '" AND bazar_name="' . $dataArray['id'] . '"';
                $bazarResult = $this->Common_model->getData('regular_bazar_result', $con1, '', '', '', 'One', 'id DESC', '');
                if (empty($bazarResult)) {
                    $bazarResult['open_result'] = "";
                    $bazarResult['jodi_result'] = "";
                    $bazarResult['close_result'] = "";
                }
            }
            $time = time() + 2 * 60;
            $open = checkTime($dataArray['open_time']);
            $close = checkTime($dataArray['close_time']);
            $DateArrayOpen = [];
            $DateArrayClose = [];
            for ($i = 0; $i < 15; $i++) {
                if (in_array(date("D", strtotime(date('Y-m-d', strtotime("+" . $i . "day")))), $days)) {
                    if ($i == 0) {
                        if ($open > $time && $close > $time) {
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        } else if ($open < $time && $close > $time) {
                            $n = $i + 1;
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $n . "day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                        }
                    } else {
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+" . $i . "day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+" . $i . "day")));
                    }
                }
            }

            $con5 = " WHERE market_type='Regular' AND bazar_name='" . $dataArray['id'] . "'";
            $hld = $this->Common_model->getData('market_holidays', $con5, 'date', '', '', '', '', '');
            $arrN = [];
            foreach ($hld as $val) {
                array_push($arrN, $val['date']);
            }
            $nO = [];
            $nC = [];
            foreach ($DateArrayOpen as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nO, $d);
                }
                $i++;
            }
            foreach ($DateArrayClose as $d) {
                if (!in_array($d, $arrN)) {
                    array_push($nC, $d);
                }
            }
            $data['marketList'][] = [
                'result' => $bazarResult['open'] . "-" . $bazarResult['jodi'] . "-" . $bazarResult['close'],
                'bazar_name' => $dataArray['bazar_name'],
                'bazar_image' => $dataArray['bazar_image'],
                'open_time' => date('H:i:s', checkTime($dataArray['open_time'])),
                'close_time' => date('H:i:s', checkTime($dataArray['close_time'])),
                'sequence' => $dataArray['sequence'],
                'days' => $dataArray['days'],
                'bazar_id' => $dataArray['id'],
                'oD' => array_slice($nO, 0, 2),
                'cD' => array_slice($nC, 0, 2),
                'image1' => base_url() . $dataArray['icon'],
                'image2' => base_url() . $dataArray['icon1'],
                'text1' => $dataArray['text'],
                'text2' => $dataArray['text1'],
                'icon_status1' => $dataArray['icon_status'],
                'icon_status2' => $dataArray['icon_status1'],
                'time_status' => $dataArray['time_status'],
            ];
        }
        $data['status'] = 200;
        die(json_encode($data));
    }


    public function checkBalance()
    {
        if (isset($_POST['url']) && $_POST['customer_id']) {
            $data = requestForClient($_POST['url'], ['id' => $_POST['customer_id'], 'code' => '300']);
            // die($data);
            $res = json_decode($data);
            if ($res->Code == 200) {
                $_SESSION['balance'] = $res->data[0];
                $bName['balance'] = $res->data[0];
                $bName['code'] = 200;
            }
        } else {
            $bName['code'] = 300;
        }
        die(json_encode($bName));
    }



    public function voidBet()
    {
        $addResult['status'] = 'V';
        $trId = $_POST['data']['transaction_id'];
        $addUpdate = AddUpdateTable($_POST['table'], 'transaction_id', $trId, $addResult);
        if ($addUpdate) {
            $Common_model = $this->load->model('Common_model');
            $tbl = $_POST['table'] . '.partner_id=client.id ';
            $c1 = 'WHERE ' . $_POST['table'] . '.transaction_id="' . $trId . '"';
            $con = ' INNER JOIN client ON ' . $tbl . $c1;

            $c = $this->Common_model->getData($_POST['table'], $con, 'client.end_point_url', '', '', 'One', '', '');
            $arr['transaction_id'] = $_POST['data'];
            $cArr['arr'] = json_encode($arr);
            $cArr['code'] = '801';
            if ($_POST['table'] == 'regular_bazar_games') {
                $tbl = 'Regular Bazar';
            } else if ($_POST['table'] == 'king_bazar_game') {
                $tbl = 'King Bazar';
            } else if ($_POST['table'] == 'starline_bazar_game') {
                $tbl = 'Starline Bazar';
            } else if ($_POST['table'] == 'instant_worli_game') {
                $tbl = 'Instant Worli';
            }
            $cArr['market'] = $tbl;
            $void = requestForClient($c['end_point_url'], $cArr);

            die(json_encode(['status' => 200, 'massage' => 'Bet Void Successfully.']));
        } else {
            die(json_encode(['status' => 300, 'massage' => 'Somthing Went Wrong.']));
        }
    }


    public function resultPanel($id, $type, $market)
    {
        $this->data['id'] = $id;
        $this->data['type'] = $type;
        $this->data['market'] = $market;
        $this->load->view('user/resultPanel', $this->data);
    }


    public function testForSoketTest()
    {
        $notifyResult['market'] = 'ForBuffer';
        $t = notifyUserWithResult(json_encode($notifyResult));
        echo '<pre>done';
        print_r($t);
        die();
    }

    public function getResultByCron($bazarId, $type)
    {
        $this->load->model('Common_model');
        if ($bazarId == 27 && $type == 'C') {
            $resDate = date('Y-m-d', strtotime('-1 day'));
        } else {
            $resDate = date('Y-m-d');
        }
        $con = ' WHERE bazar_name="' . $bazarId . '" AND result_date="' . $resDate . '"';
        $data = $this->Common_model->getData('regular_bazar_result', $con, 'id,token_open,token_close,open,jodi,close,bazar_name,result_date', '', '', 'One', '', '');

        if ($type == 'O') {
            $t = ' AND game_type="OPEN"';
            $token = $data['token_open'];
        } else {
            $t = ' AND game_type!="OPEN"';
            $token = $data['token_close'];
        }
        $die = 0;
        if ($type == 'O' && !empty($data['open'])) {
            $dnew['open'] = (string)$data['open'];
            $dnew['jodi'] = (string)$data['jodi'];
            $dnew['close'] = (string)$data['close'];
            $dnew['bazarId'] = (int)$data['bazar_name'];
            $dnew['resultDate'] = $data['result_date'];
            $die = 1;
        }
        if ($type == 'C' && !empty($data['close'])) {
            $dnew['open'] = (string)$data['open'];
            $dnew['jodi'] = (string)$data['jodi'];
            $dnew['close'] = (string)$data['close'];
            $dnew['bazarId'] = (int)$data['bazar_name'];
            $dnew['resultDate'] = $data['result_date'];
            $die = 1;
        }
        $dnew['marketCode'] = 301;
        $url = config_item('resultsite_url');
        $res = sendResultDpbossNewProject(json_encode($dnew), $url);
        if ($die == 1) {
            die();
        }


        $getResult = getStrimingResult($token);
        $res = json_decode($getResult);

        if ($res) {
            if ($type == 'O') {
                $con1 = ' WHERE token_open="' . $token . '"';
                $data = $this->Common_model->getData('regular_bazar_result', $con1, 'id', '', '', 'One', '', '');
                $a = $res->result . '';
                $ak = (int)$a[0] + (int)$a[1] + (int)$a[2];

                if ($ak > 9) {
                    $akda = abs($ak % 10);
                } else {
                    $akda = $ak;
                }
                $arr['open'] = $res->result;
                $arr['jodi'] = $akda;
            } else if ($type == 'C') {
                $con2 = ' WHERE token_close="' . $token . '"';
                $data = $this->Common_model->getData('regular_bazar_result', $con2, 'id,jodi', '', '', 'One', '', '');
                $a = $res->result . '';
                $ak = (int)$a[0] + (int)$a[1] + (int)$a[2];
                if ($ak > 9) {
                    $akda = abs($ak % 10);
                } else {
                    $akda = $ak;
                }
                $arr['close'] = $res->result;
                $arr['jodi'] = $data['jodi'] . $akda;
            }
            $table = 'regular_bazar_result';

            $arr['status'] = 'A';

            $gameaddid = AddUpdateTable($table, 'id', $data['id'], $arr);
            if ($gameaddid) {
                if ($type == 'O') {
                    $win = getWinnersOpen($data['id']);
                } else {
                    $win = getWinnersClose($data['id']);
                }

                if (!empty($win)) {
                    $type = '';
                    $com = $this->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
                    $lC = 0;
                    $fbC = 0;
                    $oC = 0;
                    $commission = 0;
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

                    foreach ($win as $data) {
                        if ($bet['partner_id'] == '2') {
                            $commission = $lC;
                        } else if ($bet['partner_id'] == '4') {
                            $commission = $fbC;
                        } else {
                            $commission = $oC;
                        }
                        $bet = $this->Common_model->getData('regular_bazar_games', ' WHERE id="' . $data . '"', 'exchange_rate,partner_id,customer_id,bazar_name,game_name,result_date,point,game_type', '', '', 'One', '', '');
                        $rate = $this->Common_model->getData('regular_bazar_rate', ' WHERE bazar_name="' . $bet['bazar_name'] . '" AND game_name="' . $bet['game_name'] . '"', 'rate', '', '', 'One', '', '');

                        $rOC = $this->Common_model->getData('customer_rate', ' WHERE customer_id="' . $bets['customer_id'] . '" AND partner_id="' . $bets['partner_id'] . '"', 'rate', '', '', 'One', '', '');
                        if ($rOC) {
                            $win = ($bet['point'] * $rate['rate']) * ((100 - $rOC['rate']) / 100);
                            $addRes['commission'] = ($commission / 100) * $win;
                            $addRes['winning_point'] = $win - $addRes['commission'];
                        } else {
                            $addRes['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
                            $addRes['winning_point'] = ($bet['point'] * $rate['rate']) - $addRes['commission'];
                        }

                        $addRes['winning_in_rs'] = $addRes['winning_point'] * (double)$bet['exchange_rate'];
                        $addRes['commission_in_rs'] = $addRes['commission'] * (double)$bet['exchange_rate'];
                        $addRes['status'] = 'W';

                        $updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addRes);
                        // array_push($notifyMe, $bet['customer_id']);
                    }
                }

                $con = " WHERE result_date='" . $resDate . "' AND status='P' AND bazar_name='" . $bazarId . "'" . $t;
                $field['status'] = "L";
                $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);

                /*--------------------- Setel Market Start --------------------------*/
                $con1 = " INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.result_date='" . $resDate . "' AND regular_bazar_games.bazar_name='" . $bazarId . "'" . $t;


                $arrLoss = $this->Common_model->getData('regular_bazar_games', $con1, 'DISTINCT regular_bazar_games.partner_id,client.end_point_url', '', '', '', '', '');
                foreach ($arrLoss as $l) {
                    $con = " WHERE result_date='" . $resDate . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bazarId . "'" . $t;
                    if ($l['partner_id'] == '2') {
                        $con .= ' AND status="W"';
                        $arrReq['result_date'] = $bet['result_date'];
                        $arrReq['bazar_id'] = $bet['bazar_name'];
                        $arrReq['type'] = $t;
                    }
                    $arrLossBet = $this->Common_model->getData('regular_bazar_games', $con, 'transaction_id,status,winning_point,commission,customer_id', '', '', '', '', '');
                    $arrReq['code'] = '601';
                    $arrReq['rec'] = json_encode($arrLossBet);
                    $arrReq['market'] = 'Regular Bazar';
                    $arrReq['market_code'] = '301';
                    $req = requestForClient($l['end_point_url'], $arrReq);
                }
                $arr = [
                    'status' => 200,
                    'message' => 'Wallet Updated Successfully!'
                ];
                /*--------------------- Setel Market End --------------------------*/
                /*--------------------- notifyMe Start --------------------------*/
                $con1 = " WHERE result_date='" . $resDate . "' AND bazar_name='" . $bazarId . "'" . $t;
                $notifyMeW['userList'] = $this->Common_model->getData('regular_bazar_games', $con1 . ' AND status="W"', 'customer_id as id,status,commission', '', '', '', '', '');

                $notifyResult['market'] = 'Regular';
                $notifyResult['type'] = $wU;
                if ($wU == 'Open') {
                    $notifyResult['result'] = $_POST['result'] . '-' . $akda;
                } else {
                    $notifyResult['result'] = $akda . '-' . $_POST['result'];
                }
                $notifyResult['url'] = '9a27a7e97c16a7b3ac6382d21205357f/' . $bazarId;
                requestForBalance(json_encode($notifyMeW));
                notifyUserWithResult(json_encode($notifyResult));
            }
        } else {
            $con1 = ' INNER JOIN regular_bazar ON regular_bazar_result.bazar_name=regular_bazar.id WHERE regular_bazar_result.bazar_name="' . $bazarId . '"';
            $data = $this->Common_model->getData('regular_bazar_result', $con1, 'regular_bazar.bazar_name', '', '', 'One', '', '');
            $url = '';
            if ($type == 'O') {
                $t = 'Open';
            } else {
                $t = 'Close';
            }
            $log = $data['bazar_name'] . ' ' . $t . ' Result Not Found On Striming!';
            sendResultErrorLog($url, $log);
        }
    }

    public function getTokenDetail()
    {
        if (isset($_POST['token'])) {
            $this->load->model('Common_model');
            $con = ' where token_open="' . $_POST['token'] . '" or token_close="' . $_POST['token'] . '"';
            $c = $this->Common_model->getData('regular_bazar_result', $con, '', '', '', '', '', '');
            die(json_encode(['status' => 200, 'data' => $c]));
        } else {
            die(json_encode(['status' => 401, 'massage' => 'Token Not Found.']));
        }
    }

    // public function settleBets()
    // {
    //     $inp = file_get_contents('php://input');
    //     $data = json_decode($inp);
    //     if (isset($data->token) & isset($data->market_code) & isset($data->transaction_id)) {
    //         $this->load->model('Common_model');
    //         $p = $this->Common_model->getData('client', ' where client_token="' . $data->token . '"', 'id', '', '', 'One', '', '');

    //         if (!$p) {
    //             die(json_encode(['status' => 401, 'massage' => 'Invalid Token.']));
    //         }
    //         if ($data->market_code == '06b18d99e81793a06954c79dfddfa9e5') {
    //             $table = 'regular_bazar_games';
    //             $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
    //             $con = ' where regular_bazar_games.transaction_id="' . $data->transaction_id . '" AND partner_id="' . $p['id'] . '"';
    //         } else if ($data->market_code == '10543ac80b0bcfb7b806da8bdb854e39') {
    //             $table = 'starline_bazar_game';
    //             $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
    //             $con = ' where starline_bazar_game.transaction_id="' . $data->transaction_id . '" AND partner_id="' . $p['id'] . '"';
    //         } else if ($data->market_code == '32cf33156b6b5ad1765aa5cce310e5f0') {
    //             $table = 'king_bazar_game';
    //             $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
    //             $con = ' where transaction_id="' . $data->transaction_id . '" AND partner_id="' . $p['id'] . '"';
    //         } else {
    //             die(json_encode(['status' => 401, 'massage' => 'Invalid Market Code.']));
    //         }

    //         $c = $this->Common_model->getData($table, $con, $feild, '', '', 'One', '', '');
    //         if ($data->market_code == '32cf33156b6b5ad1765aa5cce310e5f0' & !empty($c)) {
    //             if ($c['game_name'] == '1') {
    //                 $c['game_name'] = 'FIRST DIGIT(EKAI)';
    //             } else if ($c['game_name'] == '2') {
    //                 $c['game_name'] = 'SECOND DIGIT(HARUF)';
    //             } else {
    //                 $c['game_name'] = 'JODI';
    //             }
    //         }
    //         die(json_encode(['status' => 200, 'data' => $c]));
    //     } else {
    //         die(json_encode(['status' => 401, 'massage' => 'Token Not Found.']));
    //     }
    // }

    public function settleBets()
    {
        if (isset($_POST['token']) & isset($_POST['market_code']) & isset($_POST['transaction_id'])) {
            $this->load->model('Common_model');
            $p = $this->Common_model->getData('client', ' where client_token="' . $_POST['token'] . '"', 'id', '', '', 'One', '', '');
    
            if (!$p) {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Token.']));
            }
           
            if ($_POST['market_code'] == '301') {
                $table = 'regular_bazar_games';
                $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
                $con = ' where regular_bazar_games.transaction_id="' . $_POST['transaction_id'] . '" AND partner_id="' . $p['id'] . '"';
            } else if ($_POST['market_code'] == '401') {
                $table = 'starline_bazar_game';
                $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
                $con = ' where starline_bazar_game.transaction_id="' . $_POST['transaction_id'] . '" AND partner_id="' . $p['id'] . '"';
            } else if ($_POST['market_code'] == '501') {
                $table = 'king_bazar_game';
                $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
                $con = ' where transaction_id="' . $_POST['transaction_id'] . '" AND partner_id="' . $p['id'] . '"';
            } else if ($_POST['market_code'] == '101') {
                $table = 'crezyMatkaGame';
                $feild = 'transaction_id,customer_id,point,status,winning_point,commission';
                $con = ' where transaction_id="' . $_POST['transaction_id'] . '" AND partner_id="' . $p['id'] . '"';
            } else {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Market Code.']));
            }
    
            $c = $this->Common_model->getData($table, $con, $feild, '', '', 'One', '', '');
            if ($_POST['market_code'] == '501' & !empty($c)) {
                if ($c['game_name'] == '1') {
                    $c['game_name'] = 'FIRST DIGIT(EKAI)';
                } else if ($c['game_name'] == '2') {
                    $c['game_name'] = 'SECOND DIGIT(HARUF)';
                } else {
                    $c['game_name'] = 'JODI';
                }
            }
            die(json_encode(['status' => 200, 'data' => $c]));
        } else {
            die(json_encode(['status' => 401, 'massage' => 'Token Not Found.']));
        }
    }

    public function getJson()
    {
        // die('working');
        $this->load->model('Common_model');
        $c = $this->Common_model->getData('starline_bazar_game', " WHERE result_date='2023-11-29' AND partner_id='4' AND bazar_name='2' AND time='22'", 'transaction_id,winning_point,status,commission,customer_id', '', '', '', '', '');
        $arrReq['code'] = '601';
        $arrReq['rec'] = json_encode($c);
        $arrReq['market'] = 'Starline Bazar';
        $arrReq['market_code'] = '401';
        $req = requestForClientTest('https://fairbets.co/api/sattaMatka', $arrReq);
        die(json_encode($req));
    }

    public function kingList()
    {
        $this->load->model('Common_model');
        $con = ' WHERE status="A"';
        $data['kingGame'] = $this->Common_model->getData('king_bazar', $con, 'id,bazar_name,time,icon,icon1,text,text1,icon_status,icon_status1,bazar_image', '', '', '', 'sequence asc', '');
        
        // echo '<pre>';
        // print_r($data);
        // die();
        $dome = '';
        $_GET['app'] = $_POST['app'];
        foreach ($data['kingGame'] as $d) {
            $con = ' WHERE bazar_name="' . $d['id'] . '" AND result_date="' . date('Y-m-d') . '"';
            $re = $this->Common_model->getData('king_bazar_result', $con, 'result', '', '', 'One', '', '');
            if (empty($re['result'])) {
                $con = ' WHERE bazar_name="' . $d['id'] . '" AND result_date="' . date('Y-m-d', strtotime("- 1 day")) . '"';
                $re = $this->Common_model->getData('king_bazar_result', $con, 'result', '', '', 'One', '', '');
                if (empty($re['result'])) {
                    $re['result'] = '**';
                }
            }


            $dome .= '<div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
                <a href="' . base_url() . '9c8f59a017280083c64fbc7e958e590f/' . $d['id'] . '?token=' . $_POST['token'] . '&id=' . $_POST['customer_id'] . '&app=' . $_POST['app'] . '">
                    <div class="pricing-item">
                        <img class="bzimg" src="' . $d['bazar_image'] . '" alt="">
                        <div class="ldv">
                            <p class="bzname">' . $d['bazar_name'] . '</p>
                            <p class="re-txt">' . $re['result'] .
                '</p>
                            <p class="run">';
            if (checkTime($d['time']) <= time()) {
                $dome .= 'Running for tomorrow';
            } else {
                $dome .= '<span class="blink">Running for today</span>';
            }
            $dome .= '</p>
                        </div>';

            if ($d['icon_status'] == '1') {

                $dome .= '<div class="rdv">
                                <img src="<?=base_url()?>assets/newDesign/images/tv.png" class="tv" id="icn">
                                <span class="liv-txt">' .
                    $d['text'] .
                    '</span>
                            </div>';
            }
            if ($d['icon_status1'] == '1') {
                $dome .= '<div class="rdv">
                                <img src="' . base_url() . $d['icon1'] . '" class="tv" id="icn1">
                                <span class="liv-txt">' .
                    $d['text1'] . '
                                </span>
                            </div>';
            }

            $dome .= '<div class="clrBoth"></div>
                        <div class="btmDv kdg">
                            <div class="lfirst">
                                <p>' . date('h:i A', checkTime($d['time'])) . '</p>
                                <p class="retime">
                                <div class="mktitem-time time-detail clockdiv" data-date="' . date('Y-m-d H:i:s', checkTime($d['time'])) . '">
                                    <div style="display:none;">
                                        <span class="days"></span>
                                    </div>
                                    <div>
                                        <span class="hours"></span>H
                                    </div>
                                    <div>
                                        <span class="minutes"></span>M
                                    </div>
                                    <div>
                                        <span class="seconds"></span>S
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="clrBoth"></div>
                        </div>
                    </div>
                </a>
            </div>';
        }
        die(json_encode($dome));
    }

    // public function setRate(){
    //     $this->load->model('Common_model');
    //     $data = $this->Common_model->getData('regular_bazar',' WHERE status="A"','id','','','','','');
    //     foreach($data as $d){
    //         // echo $d['id'];die();
    //         $addUsr['game_name']=50;
    //         $addUsr['bazar_name']=$d['id'];
    //         $addUsr['rate']=1200;
    //         $addUsr['commission']=2;
    //         $addUsr['updated_by']=1;
    //         AddUpdateTable('regular_bazar_rate', '', '', $addUsr);
    //         $addUsr1['game_name']=51;
    //         $addUsr1['bazar_name']=$d['id'];
    //         $addUsr1['rate']=2400;
    //         $addUsr1['commission']=2;
    //         $addUsr1['updated_by']=1;
    //         AddUpdateTable('regular_bazar_rate', '', '', $addUsr1);
    //     }
    //     echo 'done';
    //     die();
    // }

    public function setGameRate()
    {
        $this->load->model('Common_model');
        $data = $this->Common_model->getData('regular_game_type', ' WHERE status="A"', 'id', '', '', '', '', '');
        foreach ($data as $d) {
            // echo $d['id'];die();
            $r = $this->Common_model->getData('regular_bazar_rate', ' WHERE bazar_name="6" AND game_name="' . $d['id'] . '"', 'rate', '', '', 'One', '', '');
            // echo $r['rate'];die();
            $addUsr['game_name'] = $d['id'];
            $addUsr['bazar_name'] = 74;
            $addUsr['rate'] = $r['rate'];
            $addUsr['commission'] = 2;
            $addUsr['updated_by'] = 1;
            AddUpdateTable('regular_bazar_rate', '', '', $addUsr);
            $addUsr1['game_name'] = $d['id'];
            $addUsr1['bazar_name'] = 75;
            $addUsr1['rate'] = $r['rate'];
            $addUsr1['commission'] = 2;
            $addUsr1['updated_by'] = 1;
            AddUpdateTable('regular_bazar_rate', '', '', $addUsr1);

            $addUsr2['game_name'] = $d['id'];
            $addUsr2['bazar_name'] = 78;
            $addUsr2['rate'] = $r['rate'];
            $addUsr2['commission'] = 2;
            $addUsr2['updated_by'] = 1;
            AddUpdateTable('regular_bazar_rate', '', '', $addUsr2);
            $addUsr3['game_name'] = $d['id'];
            $addUsr3['bazar_name'] = 79;
            $addUsr3['rate'] = $r['rate'];
            $addUsr3['commission'] = 2;
            $addUsr3['updated_by'] = 1;
            AddUpdateTable('regular_bazar_rate', '', '', $addUsr3);
        }
        echo 'done';
        die();
    }

    public function getClientDataOnRequest()
    {
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        // die(json_encode($data->token));
        if (isset($data->token) & isset($data->marketCode) & isset($data->resultDate) & isset($data->customer_id)) {
            $this->load->model('Common_model');
            $p = $this->Common_model->getData('client', ' where client_token="' . $data->token . '"', 'id', '', '', 'One', '', '');
            if (!$p) {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Token.']));
            }
            if ($data->marketCode == '301') {
                $table = 'regular_bazar_games';
                $feild = 'regular_bazar_games.result_date,regular_bazar_games.transaction_id,regular_bazar_games.customer_id,regular_bazar_games.point,regular_bazar_games.status,regular_bazar_games.winning_point,regular_bazar_games.commission,regular_bazar_games.bazar_name as bazar_id,regular_bazar.bazar_name as bazar_name,regular_game_type.game_name as game_name,regular_bazar_games.game_name as game_id';
                $con = ' INNER JOIN regular_bazar ON regular_bazar_games.bazar_name=regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_games.game_name=regular_game_type.id where regular_bazar_games.result_date="' . $data->resultDate . '" AND regular_bazar_games.partner_id="' . $p['id'] . '" AND regular_bazar_games.customer_id="' . $data->customer_id . '"';
            } else if ($data->marketCode == '401') {
                $table = 'starline_bazar_game';
                $feild = 'starline_bazar_game.result_date,starline_bazar_game.transaction_id,starline_bazar_game.customer_id,starline_bazar_game.point,starline_bazar_game.status,starline_bazar_game.winning_point,starline_bazar_game.commission,starline_bazar_game.bazar_name as bazar_id,starline_bazar.bazar_name as bazar_name,starline_bazar_time.time as time';
                $con = ' INNER JOIN starline_bazar ON starline_bazar_game.bazar_name=starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id where starline_bazar_game.result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '" AND starline_bazar_game.customer_id="' . $data->customer_id . '"';
            } else if ($data->marketCode == '501') {
                $table = 'king_bazar_game';
                $feild = 'king_bazar_game.result_date,king_bazar.bazar_name as bazar_name,king_bazar_game.bazar_name as bazar_id,king_bazar_game.transaction_id,king_bazar_game.customer_id,king_bazar_game.point,king_bazar_game.status,king_bazar_game.winning_point,king_bazar_game.commission';
                $con = ' INNER JOIN king_bazar ON king_bazar_game.bazar_name=king_bazar.id where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '" AND customer_id="' . $data->customer_id . '"';
            } else if ($data->marketCode == '701') {
                $table = 'warli_users_game';
                $feild = 'warli_users_game.game,warli_users_game.result_date,warli_users_game.transaction_id,warli_users_game.customer_id,warli_users_game.point,warli_users_game.status,warli_users_game.winning_point,warli_users_game.commission';
                $con = ' where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '" AND customer_id="' . $data->customer_id . '"';
            } else if ($data->marketCode == '801') {
                $table = 'redTable_users_game';
                $feild = 'redTable_users_game.result_date,redTable_users_game.transaction_id,redTable_users_game.customer_id,redTable_users_game.point,redTable_users_game.status,redTable_users_game.winning_point,redTable_users_game.commission';
                $con = ' where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '" AND customer_id="' . $data->customer_id . '"';
            } else {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Market Code.']));
            }

            $c = $this->Common_model->getData($table, $con, $feild, '', '', '', '', '');
            if ($data->marketCode == '501' & !empty($c)) {
                if ($c['game_name'] == '1') {
                    $c['game_name'] = 'FIRST DIGIT(EKAI)';
                } else if ($c['game_name'] == '2') {
                    $c['game_name'] = 'SECOND DIGIT(HARUF)';
                } else {
                    $c['game_name'] = 'JODI';
                }
            }
            die(json_encode(['status' => 200, 'data' => $c]));
        } else {
            die(json_encode(['status' => 401, 'massage' => 'Token Not Found.']));
        }
    }

    public function stopBuffer()
    {

        $this->load->model('Common_model');
        $nT = $this->Common_model->getData('buffer', ' WHERE id="4"', '', '', '', 'One', '', '');
        if (!$nT) {
            die(json_encode(['status' => 401, 'message' => 'Patti Not Updated On Buffer']));
        }
        $bArr1['status'] = 1;
        $bArr1['vUrl'] = '';
        $bArr1['patti'] = '';
        $bArr1['type'] = NULL;
        $baf = AddUpdateTable('buffer', 'id', '4', $bArr1);

        if (empty($nT['patti'])) {
            $au = $this->Common_model->getData('autoStrimingResult', ' WHERE bazarName="' . $nT['bazar'] . '"', '', '', '', 'One', 'id desc', '');
            $nT['bazar'] = $au['bazarName'];
            $nT['type'] = $au['bazarType'];
            $nT['patti'] = $au['patti'];
        }

        $bazarId = $nT['bazar'];
        $type = $nT['type'];
        $s = $nT['patti'];

        // sort($s, SORT_STRING);
        $k = $s[0] . $s[1] . $s[2];
        if ($s[0] == 0 & $s[1] == 0) {
            $k = $s[2] . $s[1] . $s[0];
        } else if ($s[0] == 0) {
            $k = $s[1] . $s[2] . $s[0];
        }

        if ($nT['bazar'] == '27' && $nT['type'] == "Close") {
            $bDate = date('Y-m-d', strtotime(' -1 day'));
        } else {
            $bDate = date('Y-m-d');
        }
        $con = " WHERE result_date='" . $bDate . "' AND bazar_name='" . $nT['bazar'] . "'";

        $token = $this->Common_model->getData('regular_bazar_result', $con, 'id,open,jodi,close', '', '', 'One', '', '');

        if ($type == "Open") {
            if (!empty($token['open'])) {
                die(json_encode($arr = [
                    'status' => 400,
                    'message' => 'Open Result Already Updated!'
                ]));
            }
        } else {
            if (!empty($token['close'])) {
                die(json_encode($arr = [
                    'status' => 400,
                    'message' => 'Close Result Already Updated!'
                ]));
            }
        }
        $tArr['bazar_name'] = $bazarId;
        $akda = $k[0] + $k[1] + $k[2];

        if ($akda > 9) {
            $quotient = intdiv($akda, 10);
            $akda = (string)($akda - (10 * $quotient));
            $notifyResult['result_akda'] = (string)$akda;
        } else {
            $akda;
            $notifyResult['result_akda'] = (string)$akda;
        }

        if ($type == 'Close') {
            $tArr['close'] = $k;
            $tArr['jodi'] = $token['jodi'] . $akda;
            $tArr['token_close'] = time();
            $tArr['updated_by'] = '1';
            $tArr['updated'] = date('Y-m-d H:i:s');
        } else {
            $tArr['token_open'] = time();
            $tArr['token_close'] = time();
            $tArr['status'] = 'A';
            $tArr['result_date'] = $bDate;
            $tArr['created'] = date('Y-m-d H:i:s');
            $tArr['open'] = $k;
            $tArr['jodi'] = $akda;
            $tArr['close'] = '';
            $tArr['updated_by'] = '1';
        }

        if ($token) {
            $addUpdate = AddUpdateTable('regular_bazar_result', 'id', $token['id'], $tArr);
        } else {
            $addUpdate = AddUpdateTable('regular_bazar_result', '', '', $tArr);
            $con = " WHERE result_date='" . $bDate . "' AND bazar_name='" . $bazarId . "'";
            $token = $this->Common_model->getData('regular_bazar_result', $con, 'id', '', '', 'One', '', '');
        }
        $vid = $this->Common_model->getData('dealerVideos', ' WHERE patti LIKE "%' . $k . '%"', 'dealer', '', '', '', '', '');
        $playVid = array_column($vid, 'dealer');
        $vp = $playVid[array_rand($playVid)];

        notifyUserWithResult(json_encode($notifyResult));

        /*------------------------ Update Wallet Start -------------------------*/
        if ($type == 'Close') {
            $win = getWinnersClose($token['id']);
            $c1 = " AND game_type!='Open'";
        } else {
            $win = getWinnersOpen($token['id']);
            $c1 = " AND game_type='Open'";
        }
        if (!empty($win)) {
            $com = $this->Common_model->getData('client_commission', '', 'client_id,commission', '', '', '', '', '');
            $clinetC = array();
            foreach ($com as $c) {
                $clinetC[$c['client_id']] = $c['commission'];
            }

            $cCR = $this->Common_model->getData('client', '', 'id,currancy_rate', '', '', '', '', '');
            $cR = array();
            foreach ($cCR as $d) {
                $cR[$d['id']] = $d['currancy_rate'];
            }
            $rate = $this->Common_model->getData('regular_bazar_rate', ' WHERE bazar_name="' . $bazarId . '"', 'rate,game_name', '', '', '', '', '');
            $rT = array();
            foreach ($rate as $d) {
                $rT[$d['game_name']] = $d['rate'];
            }

            foreach ($win as $data) {
                $bet = $this->Common_model->getData('regular_bazar_games', ' WHERE id="' . $data . '"', 'exchange_rate,partner_id,customer_id,bazar_name,game_name,result_date,point,game_type', '', '', 'One', '', '');
                $rate['rate'] = $rT[$bet['game_name']];

                $commission = $clinetC[$bet['partner_id']];
                $rOC = $this->Common_model->getData('customer_rate', ' WHERE customer_id="' . $bet['customer_id'] . '" AND partner_id="' . $bet['partner_id'] . '"', 'rate', '', '', 'One', '', '');
                if ($rOC) {
                    $win = ($bet['point'] * $rate['rate']) * ((100 - $rOC['rate']) / 100);
                    $addRes['commission'] = ($commission / 100) * $win;
                    $addRes['winning_point'] = $win - $addRes['commission'];
                } else {
                    $addRes['commission'] = ($commission / 100) * $bet['point'] * $rate['rate'];
                    $addRes['winning_point'] = ($bet['point'] * $rate['rate']) - $addRes['commission'];
                }

                $addRes['winning_in_rs'] = $addRes['winning_point'] * (double)$bet['exchange_rate'];
                $addRes['commission_in_rs'] = $addRes['commission'] * (double)$bet['exchange_rate'];

                $addRes['status'] = 'W';
                $updateresultid = AddUpdateTable('regular_bazar_games', 'id', $data, $addRes);
            }
        }

        $con = " WHERE result_date='" . $bDate . "' AND status='P' AND bazar_name='" . $bazarId . "'" . $c1;
        $field['status'] = "L";
        $updateresultLose = updateAllLose('regular_bazar_games', $con, $field);

        /*--------------------- Setel Market Start --------------------------*/
        $con1 = " INNER JOIN client ON regular_bazar_games.partner_id = client.id WHERE regular_bazar_games.result_date='" . $bDate . "' AND regular_bazar_games.bazar_name='" . $bazarId . "'" . $c1;


        $arrLoss = $this->Common_model->getData('regular_bazar_games', $con1, 'DISTINCT regular_bazar_games.partner_id,client.end_point_url', '', '', '', '', '');

        $multiUrl = [];
        $multiData = [];
        $multiI = 0;
        foreach ($arrLoss as $l) {
            $con = " WHERE result_date='" . $bDate . "' AND partner_id='" . $l['partner_id'] . "' AND bazar_name='" . $bazarId . "'" . $c1;
            if ($l['partner_id'] == '2' || $l['partner_id'] == '5' || $l['partner_id'] == '7') {
                $con .= ' AND status="W"';
                $arrReq['result_date'] = $bDate;
                $arrReq['bazar_id'] = $bazarId;
                $arrReq['type'] = $c1;
            }
            $arrLossBet = $this->Common_model->getData('regular_bazar_games', $con, 'transaction_id,status,winning_point,commission,customer_id', '', '', '', '', '');
            $arrReq['code'] = '601';
            $arrReq['rec'] = json_encode($arrLossBet);
            $arrReq['market'] = 'Regular Bazar';
            $arrReq['market_code'] = '301';
            $multiUrl[$multiI] = $l['end_point_url'];
            $multiData[$multiI] = $arrReq;
            $multiI++;
        }
        $req = requestForMultiClient($multiUrl, $multiData);

        responseLog($req);
        responseLog($multiUrl);
        $arr = [
            'status' => 200,
            'message' => 'Wallet Updated Successfully!'
        ];
        /*--------------------- Setel Market End --------------------------*/
        /*--------------------- notifyMe Start --------------------------*/
        $con1 = " WHERE result_date='" . $bDate . "' AND bazar_name='" . $bazarId . "'" . $c1;
        $notifyMeW['userList'] = $this->Common_model->getData('regular_bazar_games', $con1 . ' AND status="W"', 'customer_id as id,status,commission', '', '', '', '', '');


        requestForBalance(json_encode($notifyMeW));
        /*--------------------- notifyMe End --------------------------*/
        $con2 = " WHERE result_date='" . $bDate . "' AND bazar_name='" . $nT['bazar'] . "'";
        $resultForWeb = $this->Common_model->getData('regular_bazar_result', $con2, 'id,open,jodi,close', '', '', 'One', '', '');
        /*--------------------- send Result to dpboss Start --------------------------*/
        // $con3 = " WHERE id='".$bazarResult['bazar_name']."'";
        // $sendRes = $this->Common_model->getData('regular_bazar',$con3,'bazar_name','','','One','','');


        $sR['open_result'] = $resultForWeb['open'];
        $sR['close_result'] = $resultForWeb['close'];
        $sR['jodi_result'] = $resultForWeb['jodi'];
        $sR['bazar_name'] = $nT['bazar'];
        $sR['result_date'] = $bDate;
        $url = 'https://channapoha.com/postdata';
        sendResultDpboss($sR, $url);
        /*--------------------- send Result to dpboss End --------------------------*/

        /*--------------------- send Result to dpboss new project Start --------------------------*/
        $dnew['open'] = (string)$resultForWeb['open'];
        $dnew['jodi'] = (string)$resultForWeb['jodi'];
        $dnew['close'] = (string)$resultForWeb['close'];
        $dnew['bazarId'] = (int)$nT['bazar'];
        $dnew['resultDate'] = (string)$bDate;
        $dnew['marketCode'] = 301;
        // $url='https://dpbossstaging.com/api/dpBoss/createAndUpdateBazarResult';
        $url = config_item('resultsite_url');
        $res = sendResultDpbossNewProject(json_encode($dnew), $url);
        $addResData['response'] = $res;
        $addResData['client_id'] = 0;
        $addUpdate = AddUpdateTable('client_response', '', '', $addResData);
        /*--------------------- send Result to dpboss new project End --------------------------*/
        /*------------------------ Update Wallet End -------------------------*/

        die(json_encode($arr));
    }

    public function getClientDataOnRequestForLaxmi()
    {
        $inp = file_get_contents('php://input');
        $data = json_decode($inp);
        // die(json_encode($data->token));
        if (isset($data->token) & isset($data->marketCode) & isset($data->resultDate) & isset($data->transaction_id)) {
            $this->load->model('Common_model');
            $p = $this->Common_model->getData('client', ' where client_token="' . $data->token . '"', 'id', '', '', 'One', '', '');
            if (!$p) {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Token.']));
            }
            if ($data->marketCode == '301') {
                $table = 'regular_bazar_games';
                $feild = 'regular_bazar_games.result_date,regular_bazar_games.transaction_id,regular_bazar_games.customer_id,regular_bazar_games.point,regular_bazar_games.status,regular_bazar_games.winning_point,regular_bazar_games.commission,regular_bazar_games.bazar_name as bazar_id,regular_bazar.bazar_name as bazar_name,regular_game_type.game_name as game_name,regular_bazar_games.game_name as game_id';
                $con = ' INNER JOIN regular_bazar ON regular_bazar_games.bazar_name=regular_bazar.id INNER JOIN regular_game_type ON regular_bazar_games.game_name=regular_game_type.id where regular_bazar_games.result_date="' . $data->resultDate . '" AND regular_bazar_games.partner_id="' . $p['id'] . '"';
            } else if ($data->marketCode == '401') {
                $table = 'starline_bazar_game';
                $feild = 'starline_bazar_game.result_date,starline_bazar_game.transaction_id,starline_bazar_game.customer_id,starline_bazar_game.point,starline_bazar_game.status,starline_bazar_game.winning_point,starline_bazar_game.commission,starline_bazar_game.bazar_name as bazar_id,starline_bazar.bazar_name as bazar_name,starline_bazar_time.time as time';
                $con = ' INNER JOIN starline_bazar ON starline_bazar_game.bazar_name=starline_bazar.id INNER JOIN starline_bazar_time ON starline_bazar_game.time=starline_bazar_time.id where starline_bazar_game.result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '"';
            } else if ($data->marketCode == '501') {
                $table = 'king_bazar_game';
                $feild = 'king_bazar_game.result_date,king_bazar.bazar_name as bazar_name,king_bazar_game.bazar_name as bazar_id,king_bazar_game.transaction_id,king_bazar_game.customer_id,king_bazar_game.point,king_bazar_game.status,king_bazar_game.winning_point,king_bazar_game.commission';
                $con = ' INNER JOIN king_bazar ON king_bazar_game.bazar_name=king_bazar.id where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '"';
            } else if ($data->marketCode == '701') {
                $table = 'warli_users_game';
                $feild = 'warli_users_game.game,warli_users_game.result_date,warli_users_game.transaction_id,warli_users_game.customer_id,warli_users_game.point,warli_users_game.status,warli_users_game.winning_point,warli_users_game.commission';
                $con = ' where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '"';
            } else if ($data->marketCode == '801') {
                $table = 'redTable_users_game';
                $feild = 'redTable_users_game.result_date,redTable_users_game.transaction_id,redTable_users_game.customer_id,redTable_users_game.point,redTable_users_game.status,redTable_users_game.winning_point,redTable_users_game.commission';
                $con = ' where result_date="' . $data->resultDate . '" AND partner_id="' . $p['id'] . '"';
            } else {
                die(json_encode(['status' => 401, 'massage' => 'Invalid Market Code.']));
            }

            $cid = $this->Common_model->getData($table, ' where transaction_id="' . $data->transaction_id . '"', 'customer_id', '', '', 'One', '', '');
            $con .= ' AND customer_id="' . $cid['customer_id'] . '"';
            $c = $this->Common_model->getData($table, $con, $feild, '', '', '', '', '');
            $point = 0;
            $win = 0;
            if ($c) {
                $point = array_sum(array_column($c, 'point'));
                $win = array_sum(array_column($c, 'winning_point'));
            }
            if ($data->marketCode == '501' & !empty($c)) {
                if ($c['game_name'] == '1') {
                    $c['game_name'] = 'FIRST DIGIT(EKAI)';
                } else if ($c['game_name'] == '2') {
                    $c['game_name'] = 'SECOND DIGIT(HARUF)';
                } else {
                    $c['game_name'] = 'JODI';
                }
            }
            die(json_encode(['status' => 200, 'data' => $c, 'point' => $point, 'win' => $win]));
        } else {
            die(json_encode(['status' => 401, 'massage' => 'Token Not Found.']));
        }
    }

    public function autoStrimingResult($bazarId, $type)
    {
        if (isset($bazarId) && isset($type)) {
            $result = $this->getResultByPercentage($bazarId, $type);
            if (!empty($result['game'])) {
                $this->load->model('Common_model');
                $notifyResult['market'] = 'BufferForRegular';
                $notifyResult['status'] = '0';
                $notifyResult['bazar_id'] = $bazarId;
                $s = $result['game'];
                // sort($s, SORT_STRING);
                $k = $s[0] . $s[1] . $s[2];
                if ($s[0] == 0 & $s[1] == 0) {
                    $k = $s[2] . $s[1] . $s[0];
                } else if ($s[0] == 0) {
                    $k = $s[1] . $s[2] . $s[0];
                }
                $con = " WHERE result_date='" . date('Y-m-d') . "' AND bazar_name='" . $bazarId . "'";
                $token = $this->Common_model->getData('regular_bazar_result', $con, 'id,open,jodi,close', '', '', 'One', '', '');
                if ($type == "Open") {
                    if (!empty($token['open'])) {
                        die(json_encode($arr = [
                            'status' => 400,
                            'message' => 'Open Result Already Updated!'
                        ]));
                    }
                } else {
                    if (!empty($token['close'])) {
                        die(json_encode($arr = [
                            'status' => 400,
                            'message' => 'Close Result Already Updated!'
                        ]));
                    }
                }
                $checkVidbazar = $this->Common_model->getData('buffer', ' WHERE id="4"', '', '', '', 'One', '', '');
                if (!empty($checkVidbazar['vUrl']) || $checkVidbazar['status'] == '0') {
                    die(json_encode(['status' => 401, 'massage' => 'Patti Already Selected!']));
                }
                $vid = $this->Common_model->getData('dealerVideos', ' WHERE patti LIKE "%' . $k . '%"', 'dealer', '', '', '', '', '');
                $playVid = array_column($vid, 'dealer');
                $vp = $playVid[array_rand($playVid)];

                $bArr['startTime'] = date('Y-m-d H:i:s');
                $bArr['bazar'] = $bazarId;
                $bArr['vUrl'] = $vp;
                $bArr['type'] = $type;
                $bArr['status'] = 0;
                $bArr['patti'] = $k;
                $res = AddUpdateTable('buffer', 'id', '4', $bArr);

                $bArr1['bazarName'] = $bazarId;
                $bArr1['resultDate'] = date('Y-m-d');
                $bArr1['bazarType'] = $type;
                $bArr1['patti'] = $k;
                $res1 = AddUpdateTable('autoStrimingResult', '', '', $bArr1);

                $notifyResult['startTime'] = $bArr['startTime'];
                $notifyResult['vUrl'] = $vp;
                notifyUserWithResult(json_encode($notifyResult));
                if ($res) {
                    $arr = [
                        'status' => 200,
                        'massage' => 'Result updated!'
                    ];
                } else {
                    $arr = [
                        'status' => 400,
                        'massage' => 'Result Not updated!'
                    ];
                }
            } else {
                $arr = [
                    'status' => 400,
                    'massage' => 'Result Not updated!'
                ];
            }
        } else {
            $arr = [
                'status' => 401,
                'massage' => 'Please Provide Valid Data!'
            ];
        }
        die(json_encode($arr));
    }

    

    public function getResultByPercentage($bazarId, $type)
    {
        if (isset($bazarId) && isset($type)) {
            $this->load->model('Common_model');
            $per = $this->Common_model->getData('regular_bazar', ' WHERE id="' . $bazarId . '"', '', '', '', 'One', '', '');
            $con = " WHERE result_date='" . date('Y-m-d') . "' AND bazar_name='" . $bazarId . "'";
            // $con = " WHERE result_date='".date('Y-m-d',strtotime("-1 days"))."' AND bazar_name='".$bazarId."'";
            $allPatti = getPana();
            $akda = getVariationPatti('SingleAkda');
            $con1 = $con;
            if ($type == "Open") {
                $con .= " AND game_type='Open'";
            } else {
                $con .= " AND game_type!='Open'";
            }
            $conPatti = $con;
            $feild = "SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer";
            $pattiBet = $this->Common_model->getData('regular_bazar_games', $con . " AND (game > 99 OR game='000')", "SUM(point_in_rs) as point,COUNT(DISTINCT customer_id) as customer", '', '', 'One', '', '');
            $con .= " AND game IN ('" . implode("','", $akda) . "')";
            $ak = $this->Common_model->getData('regular_bazar_games', $con, $feild, '', '', '', 'game asc', 'game');

            $arrPatti = [];
            $newArrPatti = [];
            $arr = [];
            $sum = array_sum(array_column($ak, 'point'));
            $jodiSum = 0;
            foreach ($ak as $k) {
                $j = loadDigitBasedJodi($k['game'], 'left');
                $p = getAllPattiByDigit($k['game']);
                $patti = $this->Common_model->getData('regular_bazar_games', $conPatti . " AND game IN ('" . implode("','", $p) . "')", 'SUM(point_in_rs) as point,game,COUNT(DISTINCT customer_id) as customer', '', '', '', 'game asc', 'game');
                $arrPatti[$k['game']] = $patti;
                foreach ($patti as $e) {
                    array_push($newArrPatti, $e);
                }
                $jodi = $this->Common_model->getData('regular_bazar_games', $con1 . " AND game IN ('" . implode("','", $j) . "')", 'SUM(point_in_rs) as point,game', '', '', '', 'game asc', 'game');
                $jodiSum += array_sum(array_column($jodi, 'point'));
                $arr[$k['game']] = $jodi;
            }
            if ($type == "Open") {
                $totalBet = $sum + $pattiBet['point'];
            } else {
                $totalBet = $sum + $jodiSum + $pattiBet['point'];
            }

            $profit =  (($totalBet / 100) * $per['profit']);
            if ($type == "Open") {
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
                    // die(json_encode($n));
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
                // $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                $resultPatti = $this->findProfitableArray($pArr, 'prof', $profit);
                if (!$resultPatti) {
                    $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                }
                // die(json_encode($resultPatti));
                return $resultPatti;
            } else {
                $resultPana = $this->Common_model->getData('regular_bazar_result', ' WHERE bazar_name="' . $bazarId . '" AND result_date="' . date('Y-m-d') . '"', '', '', '', 'One', '', '');
                $akda = $resultPana['jodi'][0];
                $i = 0;
                $jArr = [];
                $pArr = [];
                for ($s = 0; $s < 10; $s++) {
                    foreach ($arrPatti[$s] as $m) {
                        $panaType = checkPanaType($m['game']);
                        if ($panaType === 'SP') {
                            $parrRate = 140;
                        } else if ($panaType === 'DP') {
                            $parrRate = 280;
                        } else if ($panaType === 'TP') {
                            $parrRate = 800;
                        }
                        $jd = $arr[$akda][$s];
                        $m['customer'] = $ak[$s]['customer'] + $m['customer'];
                        $m['jodiPoint'] = $jd['point'];
                        $m['akdaPoint'] = $ak[$s]['point'];
                        $m['win'] = ($m['point'] * $parrRate) + ($ak[$s]['point'] * 9.7) + ($jd['point'] * 97);
                        $m['prof'] = $totalBet - $m['win'];
                        array_push($pArr, $m);
                    }
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
                        $m['point'] = 0;

                        $m['customer'] = $ak[$akSum]['customer'];
                        $m['game'] = $balPatti;
                        $jd = $arr[$akda][$akSum];
                        $m['jodiPoint'] = $jd['point'];
                        $m['akdaPoint'] = $ak[$akSum]['point'];
                        $m['win'] = ($m['point'] * $parrRate) + ($ak[$akSum]['point'] * 9.7) + ($jd['point'] * 97);
                        $m['prof'] = $totalBet - $m['win'];
                        array_push($pArr, $m);
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
                if ($panaOpen === 'TP' || $panaOpen === 'DP' || $panaClose === 'TP') {
                    $nArr = [];
                    foreach ($pArr as $arr) {
                        $cPana = checkPanaType($arr['game']);
                        if ($cPana === 'SP') {
                            array_push($nArr, $arr);
                        }
                    }
                    $resultPatti = $this->findProfitableArray($nArr, 'prof', $profit);
                    if (!$resultPatti) {
                        $resultPatti = $this->findClosestArray($pArr, 'prof', $profit);
                    }
                }
                // die(json_encode($resultPatti));
                return $resultPatti;
            }
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
