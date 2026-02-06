<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/helpers/MCrypt.php';


/**

 * Class : Manage_Matkagames (Manage_Matkagames)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 06 April 2021

 */

class Holidays extends BaseController{



	function __construct(){
	    parent::__construct();
	    if(! $this->session->userdata('adid'))
	    redirect('admin/login');

	}

	public function marketholidays(){
		$Common_model = $this->load->model('Common_model');
		// $con=' WHERE status="A"';
		$data['holidays'] = $this->Common_model->getData('market_holidays', '','id,massage,market_type,bazar_name,date','','','','','');
		$this->load->view('admin/marketHolidays',$data);
	}
    public function holidaysData(){   
		$postData = $this->input->post();
		$Data = file_get_contents('php://input');
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getHolidayData($postData);
	    echo json_encode($data);
	}

	public function addHolidays($id=''){
		$this->load->model('Common_model');
		$data['holidays'] = $this->Common_model->getData('market_holidays', '','id,massage,market_type,bazar_name,date','','','','','');
		if ($id > 0) {
			$data['holiday'] = getRecordById('market_holidays', 'id', $id);
		}
		 	
		if ($_POST) {
			$addHoliday = array(
				'massage' => $_POST['massage'], 
				'market_type' => $_POST['market_type'], 
				'bazar_name' => $_POST['bazar_name'], 
				'date' => $_POST['date'],
				'updated_by' => $_SESSION['adid']['id']
			);

			if ($id > 0) {
				$updatedId = AddUpdateTable('market_holidays', 'id', $id, $addHoliday);
			}else{
				// print_r("Executing Else Block");
				// die();
				$con=' WHERE massage="'.$_POST['massage'].'" AND market_type="'.$_POST['market_type'].'" AND bazar_name="'.$_POST['bazar_name'].'" AND date="'.$_POST['date'].'"';
				$checkResult=$this->Common_model->getData('market_holidays',$con,'id','','','One','','');
				if(empty($checkResult)){
					$updatedId = AddUpdateTable('market_holidays', '', '', $addHoliday);
				}else{
					$updatedId=0;
				}
			}
			if ($updatedId > 0) {
				redirect('admin/Holidays/marketholidays');
			}
		}

		 
		$this->load->view('admin/add_holiday',$data);
	}

	public function getBazarNames($table){
		$Common_model = $this->load->model('Common_model');
		$gameList = $this->Common_model->getData($table, '','id,bazar_name','','','','','');
		return $gameList;
	}
	 
	 
}