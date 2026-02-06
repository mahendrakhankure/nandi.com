<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Kingbazarallresult (Manage_Kingbazarallresult)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class ClientLogin extends BaseController {



	function __construct(){
	    parent::__construct();
	    // if(! $this->session->userdata('client'))
	    // redirect('client/login');
	}


	public function login(){
		if($_POST){
			$this->load->model('Client_Model');
			$con=' WHERE username="'.$_POST['email'].'" AND password="'.md5($_POST['password']).'"';
			$client = $this->Client_Model->getData('client',$con,'','','','One','','');
			if(!empty($client)){
				$_SESSION['client'] = $client;
				return redirect('4772d54d262235a418ec16f4c0686614');
			}else{
				$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
			}
		}
		$this->load->view('client/login');
	}

	public function logout(){
		$this->session->unset_userdata('client');
		$this->session->sess_destroy();
		$this->load->view('admin/login');
		return redirect('462dad51418ceb8ba9d4d7972da579ec');

	}

}

