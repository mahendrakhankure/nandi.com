<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class User_Login_Model extends CI_Model {





	public function validatelogin($emailid,$password){
		$query=$this->db->where(['mobile'=>$emailid,'password'=>$password]);
		$account=$this->db->get('user')->row();
		if($account!=NULL){
			return $account;
		}
		return NULL;
	}

}



