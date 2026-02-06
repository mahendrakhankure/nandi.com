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

class Login extends BaseController{



	function __construct(){

	    parent::__construct();

	    // if(! $this->session->userdata('adid'))

	    // redirect('admin/login');

	}



	public function index(){
		$this->form_validation->set_rules('email','email','trim|required|valid_email');
		$this->form_validation->set_rules('password','password','required');
		if($this->form_validation->run()){
			$username = $this->input->post('email');
			$password = md5($this->input->post('password'));	
			$this->load->model('Admin_Login_Model');
			$validate=$this->Admin_Login_Model->validatelogin($username,$password);
			
			if($validate){
				// $myfileread = fopen("newfile.txt", "r") or die("Unable to open file! first");
				// $arr = fgets($myfileread);
				// fclose($myfileread);
				// $checkLoginArr = json_decode($arr);
				// $auth = transactionID(25,25);
				// $newId = $validate['id'];
				// if($checkLoginArr->$newId){
				// 	$checkLoginArr->$newId = $auth;
				// 	$fp = fopen("newfile.txt", "r+");
				// 	ftruncate($fp, 0);
				// 	fwrite($fp, json_encode($checkLoginArr));
				// 	fclose($fp);
				// }else{
				// 	$myfile = fopen("newfile.txt", "a") or die("Unable to open file! second");
				// 	$arr[$validate['id']]=$auth;
				// 	fwrite($myfile, json_encode($arr));
				// 	fclose($myfile);
				// }
				// $validate['authId'] = $auth;

				$this->session->set_userdata('adid',$validate);
				$data=array('login' =>'Y' );
				$this->db->where(['id'=>1])->update('admin',$data);
				return redirect('admin/dashboard');
			} else{
				$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
				redirect('95dfb6e273f059ca76e2e35750819ed3');
			}
		} else {
			$this->load->view('admin/login');
		}	
	}

	// 	public function index(){
	// 	// $this->form_validation->set_rules('email','email','trim|required|valid_email');
	// 	// $this->form_validation->set_rules('password','password','required');
	// 	if($_POST){
	// 		$this->load->model('Common_model');
	// 		$username = $this->input->post('email');
	// 		$otp = $this->input->post('otp');	
	// 		// $password = md5($this->input->post('otp'));	
	// 		$con = " WHERE (email='".$_POST['email']."' OR mobile='".$_POST['email']."') AND otp='".$otp."'";
	// 		$admin = $this->Common_model->getData('admin',$con,'','','','One','','');
	// 		// echo '<pre>';
	// 		// print_r($admin);
	// 		// print_r($this->db->last_query());
	// 		// die();
	// 		// $this->load->model('Admin_Login_Model');
	// 		// $validate=$this->Admin_Login_Model->validatelogin($username,$password);
			
	// 		if($admin){
	// 			// $myfileread = fopen("newfile.txt", "r") or die("Unable to open file! first");
	// 			// $arr = fgets($myfileread);
	// 			// fclose($myfileread);
	// 			// $checkLoginArr = json_decode($arr);
	// 			// $auth = transactionID(25,25);
	// 			// $newId = $validate['id'];
	// 			// if($checkLoginArr->$newId){
	// 			// 	$checkLoginArr->$newId = $auth;
	// 			// 	$fp = fopen("newfile.txt", "r+");
	// 			// 	ftruncate($fp, 0);
	// 			// 	fwrite($fp, json_encode($checkLoginArr));
	// 			// 	fclose($fp);
	// 			// }else{
	// 			// 	$myfile = fopen("newfile.txt", "a") or die("Unable to open file! second");
	// 			// 	$arr[$validate['id']]=$auth;
	// 			// 	fwrite($myfile, json_encode($arr));
	// 			// 	fclose($myfile);
	// 			// }
	// 			// $validate['authId'] = $auth;

	// 			$this->session->set_userdata('adid',$admin);
	// 			$data=array('login' =>'Y' );
	// 			$this->db->where(['id'=>1])->update('admin',$data);
	// 			return redirect('admin/dashboard');
	// 		} else{
	// 			$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
	// 			redirect('95dfb6e273f059ca76e2e35750819ed3');
	// 		}
	// 	} else {
	// 		$this->load->view('admin/login');
	// 	}	
	// }

	public function otp(){
		$this->load->model('Common_model');
		$con = " WHERE (email='".$_POST['email']."' OR mobile='".$_POST['email']."') AND status='A'";
		$admin = $this->Common_model->getData('admin',$con,'','','','One','','');
		$otp = rand ( 10000 , 99999 );
		if($admin){
			$betArr['otp'] = $otp;
        	$add = AddUpdateTable('admin', 'id', $admin['id'], $betArr);
			if($add){
				// CURLOPT_URL => 'http://sumit.bulksmsnagpur.net/sendsms?uname=harsh12&pwd=harsh12&senderid=BIMOAR&to='.$admin['mobile'].'&msg='.$otp.'%20is%20your%20OTP%20for%20Online%20games%20OTP%20is%20valid%20for%205%20minutes%20%20BIRJUA&route=T&peid=1701165235362061790&tempid=1707165458450579558',
				
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://msg.bulksmsnagpur.net/api/sms/v1.0/send-sms?accessToken=UF8H3M67N6TOY0H&expire=2068180317&authSignature=6b96925155fe0291f2ff41b8b031af45&route=transactional&smsHeader=BIMOAR&messageContent='.$otp.'%20is%20your%20OTP%20for%20Online%20games%20OTP%20is%20valid%20for%205%20minutes%20%20BIRJUA&recipients='.$admin['mobile'].'&contentType=text&entityId=&templateId=',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				));
				$response = curl_exec($curl);
				curl_close($curl);
				
				if ($response === "Enter valid Mobile No" || $response === "Invalid Number" || $response === `Invalid route. Route can be from {T,A,SID,PD,'I'}`) {
					die(json_encode(['status'=>401,'message'=>'Mobile/Email Not Found']));
				} else {
					die(json_encode(['status'=>200,'message'=>'Otp Send']));
				}
			}
		}
		die(json_encode(['status'=>401,'message'=>'Mobile/Email Not Found']));
	}

	//function for logout

	public function logout(){

		$this->session->unset_userdata('adid');

		$this->session->sess_destroy();

		// return redirect('http://mybizvcard.in');
		redirect('95dfb6e273f059ca76e2e35750819ed3');
		// $this->load->view('admin/login');

	}

}