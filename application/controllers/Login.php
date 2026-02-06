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
		$this->form_validation->set_rules('email','email','required');

		$this->form_validation->set_rules('password','password','required');

		if($this->form_validation->run()){



			$username = $this->input->post('email');

			$password = md5($this->input->post('password'));	



			$this->load->model('Admin_Login_Model');



			$validate=$this->Admin_Login_Model->validatelogin($username,$password);
		
			if($validate){

				$this->session->set_userdata('adid',$validate);
				
				return redirect('dashboard');
				die;
			} else{

				$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');

				redirect('login');



			}



		} else {

			$this->load->view('admin/login');

		}	

	}



	//function for logout

	public function logout(){

		$this->session->unset_userdata('adid');

		$this->session->sess_destroy();
		$this->load->view('admin/login');

	}

}