<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Matkagames (Manage_Matkagames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

Class Welcome extends BaseController {

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
                echo '<pre>';
                print_r($_GET);
                print_r($data);
                die();
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
		
	// 	if(isset($_GET['token']) && isset($_GET['id']) && isset($_GET['app'])){
			
	// 		$_SESSION['app']=$_GET['app'];
	// 		$this->load->model('Common_model');
	// 		$con=' WHERE status="A" AND client_token="'.$_GET['token'].'"';
	// 		$partner = $this->Common_model->getData('client',$con,'id,end_point_url','','','One','','');
			
	// 		if(!empty($partner)){
	// 			$_SESSION['end_point_url']=$partner['end_point_url'];
	// 			if($partner['id']=='5'){
    //                 $_GET['id'] = str_replace(" ","+",$_GET['id']);
    //             }
	// 			$data=requestForClient($partner['end_point_url'],['id'=>$_GET['id'],'code'=>'300']);
	// 			// if($_GET['token']=='70f05f86e289b3d4a4fdb3e574a96e91'){
	// 			// 	print_r($partner);
	// 			// 	die(json_encode($data));
	// 			// }
	// 			$res = json_decode($data);
	// 			if($res->Code==200){
	// 				$_SESSION['token']=$_GET['token'];
	// 				$_SESSION['app']=$_GET['app'];
	// 				$_SESSION['partner']=$partner;
	// 				$_SESSION['balance']=$res->data[0];
	// 				$_SESSION['userName']=$res->data[1];
	// 				$_SESSION['customer_id']=$_GET['id'];
	// 			}
	// 			$this->data['s']=$_SESSION;
				
	// 		}
	// 	}
	// 	$this->load->view('user/home',$this->data);
	// }
	public function index(){

		$this->load->model('Common_model');
		$con=' WHERE status="A"';
        if($_GET['app']=='BD'){
            $con .=' AND bazar_type!="Out"';
        }
		$List = $this->Common_model->getData('regular_bazar',$con,'','','','','sequence ASC','');
        // echo '<pre>';
        // print_r($List);
        // print_r($this->db->last_query());
        // die();
        foreach ($List as $dataArray) {
        	$days = explode(",",$dataArray['days']);
            $con=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$dataArray['id'].'" AND status="A"';
            $bazarResult = $this->Common_model->getData('regular_bazar_result',$con,'open,jodi,close','','','One','id DESC','');
            
            if(empty($bazarResult['open']) && empty($bazarResult['jodi']) && empty($bazarResult['close'])){
            	$con1=' WHERE result_date="'.date('Y-m-d',strtotime("-1 days")).'" AND bazar_name="'.$dataArray['id'].'"';
                $bazarResult = $this->Common_model->getData('regular_bazar_result',$con1,'','','','One','id DESC','');
                if(empty($bazarResult)){
                    $bazarResult['open_result'] = "";
                    $bazarResult['jodi_result'] = "";
                    $bazarResult['close_result'] = "";
                }
            }
            $time=time() + 1*60;

            $time=time() + 1*60;
            $open=checkTime($dataArray['open_time']);
            $close=checkTime($dataArray['close_time']);
            $DateArrayOpen = [];
            $DateArrayClose = [];
            for($i=0;$i<15;$i++){
                if(in_array(date("D",strtotime(date('Y-m-d', strtotime("+".$i."day")))),$days)){
                    if($i == 0){
                        if($open > $time && $close > $time){
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+".$i."day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+".$i."day")));
                        } else if($open < $time && $close > $time){
                            $n = $i+1;
                            array_push($DateArrayOpen, date('Y-m-d', strtotime("+".$n."day")));
                            array_push($DateArrayClose, date('Y-m-d', strtotime("+".$i."day")));
                        }
                    } else {
                        array_push($DateArrayOpen, date('Y-m-d', strtotime("+".$i."day")));
                        array_push($DateArrayClose, date('Y-m-d', strtotime("+".$i."day")));
                    }
                }
            }

            $con5 = " WHERE market_type='Regular' AND bazar_name='".$dataArray['id']."'";
            $hld = $this->Common_model->getData('market_holidays',$con5,'date','','','','','');
            $arrN=[];
            foreach ($hld as $val) {
                array_push($arrN, $val['date']);
            }
            $nO = [];
            $nC = [];
            foreach ($DateArrayOpen as $d) {
                if(!in_array($d, $arrN)){
                    array_push($nO, $d);
                }
                $i++;
            }
            foreach ($DateArrayClose as $d) {
                if(!in_array($d, $arrN)){
                    array_push($nC, $d);
                }
            }
            // $this->data['oD'] = array_slice($nO,0,2);
            // $this->data['cD'] = array_slice($nC,0,2);

            

            $this->data['marketList'][] = [
                'result' => $bazarResult['open']."-".$bazarResult['jodi']."-".$bazarResult['close'],
                'bazar_name' => $dataArray['bazar_name'],
                'open_time' => date('H:i:s',checkTime($dataArray['open_time'])),
                'close_time' => date('H:i:s',checkTime($dataArray['close_time'])),
                'sequence' => $dataArray['sequence'],
                'days' => $dataArray['days'],
                'bazar_id' => $dataArray['id'],
                'oD' => array_slice($nO,0,2),
                'cD' => array_slice($nC,0,2),
                'icon' => $dataArray['icon'],
                'icon1' => $dataArray['icon1'],
                'text' => $dataArray['text'],
                'text1' => $dataArray['text1'],
                'icon_status' => $dataArray['icon_status'],
                'icon_status1' => $dataArray['icon_status1'],
                'bazar_image' => $dataArray['bazar_image'],
            ];
            $this->data['tUrl']="?token=".$_GET['token']."&id=".$_GET['id']."&app=".$_GET['app'];
        }

        //starline market
        $this->load->model('Common_model');
	    $con = ' WHERE status="A"';
	    $this->data['starlinegame'] = $this->Common_model->getData('starline_bazar',$con,'id,bazar_name,icon,bazar_image','','','','');
        $this->data['stUrl']="?token=".$_GET['token']."&id=".$_GET['id']."&app=".$_GET['app'];

		$this->load->view('user/home',$this->data);
	}
	public function ForPSApp(){
		if(isset($_GET['token']) && isset($_GET['id'])){
			$this->load->model('Common_model');
			$con=' WHERE status="A" AND client_token="'.$_GET['token'].'"';
			$partner = $this->Common_model->getData('client',$con,'id,end_point_url','','','One','','');
			if(!empty($partner)){
				$_SESSION['end_point_url']=$partner['end_point_url'];
				$data=requestForClient($partner['end_point_url'],['id'=>$_GET['id'],'code'=>'300']);
				$res = json_decode($data);
				if($res->Code==200){
					$_SESSION['partner']=$partner;
					$_SESSION['balance']=$res->data[0];
					$_SESSION['userName']=$res->data[1];
					$_SESSION['customer_id']=$_GET['id'];
				}
			}
		}
		$data='<iframe src="http://localhost/?token='.$_GET['token'].'&&id='.$_GET['id'].'" title="Live Satta Matka" id="iFrameApp" height="100%" width="100%"></iframe>';
		die(json_encode($data));
	}





	public function login(){
		$this->form_validation->set_rules('mobile','number','required');
		$this->form_validation->set_rules('password','password','required');
		if($this->form_validation->run()){
			$username = $this->input->post('mobile');
			$password = md5($this->input->post('password'));	
			$this->load->model('User_Login_Model');
			$validate=$this->User_Login_Model->validatelogin($username,$password);
          
			if($validate){
				$this->session->set_userdata('usid',$validate);
				$this->session->set_userdata('balance',$validate->balance);
				$this->session->set_userdata('customer_id',$validate->id);
				$this->session->set_userdata('partner',1);
				$this->session->set_userdata('end_point_url','/');
				$this->session->set_userdata('tokenId','/b2c');
				redirect('/');
			} else{
				$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
				redirect('signup');
			}
		} else {
			$this->load->view('user/login');
		}	

	}
	//function for logout
	public function logout(){
		$this->session->unset_userdata('usid');
		$this->session->sess_destroy();
        redirect('/');
	}

}