<?php
defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Globles (Manage_Globles)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_Globles extends BaseController {


    function __construct(){

        parent::__construct();

        if(! $this->session->userdata('adid'))

        redirect('login');

    }



    public function index(){
        $this->load->library('pagination');
        $this->load->model('ManageKingbazarallresult_Model');
        $config["base_url"] = base_url() . "Manage_Kingbazarallresult/index/";
        $config["total_rows"] = $this->ManageKingbazarallresult_Model->num_rows();
        $config["per_page"] = 10;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{ 
            $page = 0; 
        }
        $this->data["kingbazarallresult"] = $this->ManageKingbazarallresult_Model->getkingbazarallresultdetails('','',$config["per_page"], $page);
        $this->load->view('admin/manage_kingbazarallresult',$this->data);
    }


    public function MatkaPattiList(){
        $this->load->library('pagination');
        $this->load->model('Common_model');
        $this->load->model('ManageMatkagames_Model');
        $config["base_url"] = base_url() . "Manage_Globles/MatkaPattiList/";
        $config["total_rows"] = $this->ManageMatkagames_Model->num_rows('a_r_point');
        $config["per_page"] = 10;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{ 
            $page = 0; 
        }
        $this->data["matkaPatti"] = $this->Common_model->getData('matka_patti','','',$config["per_page"], $page,'','id desc','');
        $this->load->view('admin/MatkaPattiList',$this->data);
    }


    public function addNewPatti($id=''){
        if ($id > 0 ) {
            $data['onegamedata'] = getRecordById('matka_patti', 'id', $id);
        }
        if ($_POST) {
            for ($i =0; $i<=strlen($_POST['patti']);$i++){
               $_POST['akda']+=$_POST['patti'][$i];  
            }
            $addgamename = array(
                'patti' => $_POST['patti'], 
                'type' => $_POST['type'],
                'akda' => $_POST['akda']
            );

            if ($id > 0) {
                $gameaddid = AddUpdateTable('matka_patti', 'id', $id, $addgamename);
            }else{
                $addgamename['status']="A";
                $gameaddid = AddUpdateTable('matka_patti', '', '', $addgamename);
            }
            if ($gameaddid > 0) {
                redirect('Manage_Globles/MatkaPattiList');
            }
        }
        $this->load->view('admin/addNewPatti',$data);
    }


    public function ClientList(){
        $this->load->library('pagination');
        $this->load->model('Common_model');
        $this->load->model('ManageMatkagames_Model');
        $config["base_url"] = base_url() . "Manage_Globles/client/";
        $config["total_rows"] = $this->ManageMatkagames_Model->num_rows('a_r_point');
        $config["per_page"] = 10;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{ 
            $page = 0; 
        }
        $this->data["clients"] = $this->Common_model->getData('client','','',$config["per_page"], $page,'','id desc','');
        $this->load->view('admin/ClientList',$this->data);
    }

    public function addNewClient($id=''){
        if ($id > 0 ) {
            $data['onegamedata'] = getRecordById('client', 'id', $id);
        }
        if ($_POST) {
            // echo '<pre>';
            // print_r($_POST);
            // die();
            $addgamename = array(
                'client_name' => $_POST['client_name'], 
                'mobile' => $_POST['mobile'],
                'alternate_mobile' => $_POST['alternate_mobile'],
                'domain' => $_POST['domain'],
                'ip_address' => $_POST['ip_address'],
                'state' => $_POST['state'],
                'country' => $_POST['country'],
                'percentage' => $_POST['percentage'],
                'currency' => $_POST['currency'],
                'currancy_rate' => $_POST['currancy_rate'],
                'status' => $_POST['status'],
                'end_point_url' => $_POST['end_point_url']
            );
            if ($id > 0) {
                $gameaddid = AddUpdateTable('client', 'id', $id, $addgamename);
            }else{
                $addgamename['status']="A";
                $addgamename['created']=date('Y-m-d');
                $gameaddid = AddUpdateTable('client', '', '', $addgamename);
            }
            if ($gameaddid > 0) {
                redirect('2b8c2d994a9278e1ba9e5550010d77f2');
            }
        }
        $this->load->view('admin/addNewClient',$data);
    }

    public function addRemovePointList(){
        $this->load->library('pagination');
        $this->load->model('Common_model');
        $this->load->model('ManageMatkagames_Model');
        $config["base_url"] = base_url() . "Manage_Globles/addRemovePointList/";
        $config["total_rows"] = $this->ManageMatkagames_Model->num_rows('a_r_point');
        $config["per_page"] = 10;
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{ 
            $page = 0; 
        }
        $this->data["aRList"] = $this->Common_model->getData('a_r_point','','',$config["per_page"], $page,'','id desc','');
        $this->load->view('admin/addRemovePointList',$this->data);
    }

    public function addRemovePoint($id=''){
        $this->load->model('Common_model');
        if ($id > 0 ) {
            $data['onegamedata'] = getRecordById('a_r_point', 'id', $id);
        }
        if ($_POST) {
            if ($id > 0) {
                $gameaddid = AddUpdateTable('a_r_point', 'id', $id, $_POST);
            }else{
                $cusBal=$this->Common_model->getData('cuatomer',' WHERE customer_id="'.$_POST['customer_id'].'"','balance','','','One','id desc','');
                if($_POST['type']=="A"){
                    $bal=$cusBal['balance']+$_POST['point'];
                }else{
                    $bal=$cusBal['balance']-$_POST['point'];
                }
                $CI = &get_instance();
                $CI->db->query("UPDATE `cuatomer` SET `balance`='".$bal."' WHERE customer_id='".$_POST['customer_id']."'");
                $gameaddid = AddUpdateTable('a_r_point', '', '', $_POST);
            }
            if ($gameaddid > 0) {
                redirect('Manage_Globles/addRemovePointList');
            }
        }
        $data['users'] = $this->Common_model->getData('cuatomer','','','','','','id desc','');
        
        $this->load->view('admin/addRemovePoint',$data);
    }

    public function deleteGame($gameid='',$table){
        $returnval = deleteRecord($table, 'id', $gameid);
        if ($returnval > 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}

?>