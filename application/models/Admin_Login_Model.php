<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin_Login_Model extends CI_Model {





	public function validatelogin($username,$password){
		// Use bindings to prevent SQL injection
		$query = $this->db->query(
			"SELECT * FROM admin WHERE email = ? AND password = ? AND id = '1'",
			[$username, $password]
		);
		return $query->row_array();

	}

}



