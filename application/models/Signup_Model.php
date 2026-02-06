<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Signup_Model extends CI_Model{
	public function insert($fname,$cname,$emailid,$mnumber,$whatsapp_no,$address,$package,$password,$status){
	$data=array(
				'name'=>$fname,
				'emailid'=>$emailid,
				'mobileNumber'=>$mnumber,
				'whats_app_no'=>$whatsapp_no,
				'company_name'=>$cname,
				'address'=>$address,
				'userPassword'=>$password,
				'package_id'=>$package,
				'isActive'=>$status
			);
	
	$sql_query=$this->db->insert('tblusers',$data);

	if($sql_query){
		
		$this->session->set_flashdata('success', 'Registration successfull');
			redirect('user/login');
		} else{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('user/signup');
		}

	}

}