<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Manage_Guessingforum (Manage_Guessingforum)
 * User Class to control all user related operations.
 * @author : Mangesh
 * @version : 1.1
 * @since : 20 April 2021
 */
Class Manage_Guessingforum extends BaseController {

	function __construct(){
	    parent::__construct();
	    if(! $this->session->userdata('adid'))
	    redirect('admin/login');
	}

	public function index(){
	    $this->load->model('Manage_Guessingforum_model');
	    $this->load->library('pagination');
	    $data['adminguessinglist'] = $this->Manage_Guessingforum_model->getAdminGuessingList();
	    $this->load->view('admin/manage_adminguessinglist',$data);
	}

	public function AddAdminGuessing($id=''){
		$this->load->model('Manage_Guessingforum_model');
		$data['starlinegame'] = $this->Manage_Guessingforum_model->getAllGames();

		// $otherdb = $this->load->database('designdb', TRUE);
              // $stmt = "SELECT id,tg_product_id,tg_product_color,name FROM `lumise_products` WHERE tg_product_id='".$productid."' AND tg_product_color = '".$ticketcolor."'" ;
              // $stmt = $otherdb->query($stmt);

		if ($id > 0) {
			$data['onegamedata'] = getRecordById('admin_guessing', 'id', $id);
		}

		if ($_POST) {

			$updateAddResult = array(
				'game' => $_POST['game_name'], 
				'close_result' => $_POST['close_result'], 
				'panna_result' => $_POST['panna_result'], 
				'jodi_result' => $_POST['jodi_result'], 
				'sangam_result' => $_POST['sangam_result'], 
				'created' => $_POST['result_date'], 
				'updated' => date('Y-m-d h:i:s'), 
			);

			if ($id > 0) {
				$updateresultid = AddUpdateTable('admin_guessing', 'id', $id, $updateAddResult);
			}else{
				$updateresultid = AddUpdateTable('admin_guessing', '', '', $updateAddResult);
			}

			if ($updateresultid > 0) {
				redirect('admin/Manage_Guessingforum');
			}
		}
		$this->load->view('admin/add_admin_guessing',$data);
	}

	public function deleteAdminGuessing($gameid=''){
		// pr($gameid);exit;
		$chartgame = deleteRecord('admin_guessing','id',$gameid);
		if ($chartgame > 0) {
			redirect('admin/Manage_Guessingforum');
		}
	}

}
