<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Profile_Model extends CI_Model{

public function getprofile($userid){
	$query=$this->db->select('tblusers.*,packages.*')
                ->where('tblusers.id',$userid)
                ->from('tblusers')
                ->join('packages','packages.id=tblusers.package_id')
                ->get();
  return $query->row();  
}

public function update_profile($name,$mnumber,$whatsapp_no,$cname,$address,$userid){
	$data = array(
	               'name'=>$name,				
					'mobileNumber'=>$mnumber,
					'whats_app_no'=>$whatsapp_no,
					'company_name'=>$cname,
					'address'=>$address					
	            );

	$sql_query=$this->db->where('id', $userid)
	                ->update('tblusers', $data); 

                if($sql_query){
                	return true;
                } else{
                	return false;
                }


}


}