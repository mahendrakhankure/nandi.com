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

Class Dashboard extends BaseController {

	function __construct(){

		parent::__construct();

			if(empty($_SESSION['adid']))
           {
			   redirect('login');
			}

	}

	

	public function index(){
		$this->load->model('Common_model');
		$con=' WHERE result_date="'.date('Y-m-d').'"';
		$feilds='COUNT(id) as id, SUM(point) as point, SUM(winning_point) as win, COUNT(DISTINCT customer_id) as player';
		$this->data['regular'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
		$this->data['star'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
		$this->data['king'] = $this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');

		$this->data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','One','','');

		$this->data['redTable'] = $this->Common_model->getData('redTable_users_game',$con,$feilds,'','','One','','');
		// $this->data['goldenTable'] = $this->Common_model->getData('goldenTable_users_game',$con,$feilds,'','','One','','');
		
		$con2 = $con." AND bazar_name IN ('".implode("','",['9','13','15','23','24','25'])."')";
		$this->data['regularOut'] = $this->Common_model->getData('regular_bazar_games',$con2,$feilds,'','','One','','');

		$con3 = $con." AND bazar_name IN ('".implode("','",['8','11','19'])."')";
		$this->data['regularInHome'] = $this->Common_model->getData('regular_bazar_games',$con3,$feilds,'','','One','','');
		
		$con4 = $con." AND icon_status='1'";
		$this->data['regularIn'] = $this->Common_model->getData('regular_bazar_games',$con4,$feilds,'','','One','','');
		// echo '<pre>';
		// print_r($this->data['regularIn']);
		// die();
		$this->load->view('admin/dashboard',$this->data);

	}



}
