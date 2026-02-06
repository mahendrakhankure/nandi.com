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

			if(! $this->session->userdata('adid'))

			redirect('admin/login');

	}

	public function test(){
		// $this->load->helper('custom_helper');
		$this->load->helper('data_helper');
		
		// echo 'working';print_r($d);die();
		$con = 'result_date="'.date('Y-m-d').'" AND status="P"';
		$feild = 'SUM(point) as pending';
		//  $d=checkSumRecords('regular_bazar_games','One',$con);
		$d= getData('regular_bazar_games',$feild,$con,'One');
			print_r($d);
			die();
	}

	public function index(){
		$this->load->model('Common_model');
		$con=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("V","P")';
		$data['con1'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Out')";
		$data['con2'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='InHome')";
		$data['con3'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Home')";
		$data['feilds1']='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, COUNT(DISTINCT customer_id) as player, SUM(commission_in_rs) as com';
		$feilds='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, COUNT(DISTINCT customer_id) as player, SUM(commission_in_rs) as com';
		$data['regular'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');

		$data['star'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
		$data['king'] = $this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');

		$data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','One','','');
		// $data['redTable'] = $this->Common_model->getData('redTable_users_game',$con,$feilds,'','','One','','');
		
		$data['feild'] = 'SUM(point_in_rs) as pending,COUNT(id) as idP, COUNT(DISTINCT customer_id) as playerP,SUM(commission_in_rs) as com';
		$data['con'] = ' WHERE result_date="'.date('Y-m-d').'" AND status="P"';
		$data['conP'] = ' WHERE result_date="'.date('Y-m-d').'" AND status="P" AND bazar_name IN (select id from regular_bazar where bazar_type=';
		// $data['goldenTable'] = $this->Common_model->getData('goldenTable_users_game',$con,$feilds,'','','One','',''); //we close the golden table
        
		$this->load->view('admin/dashboard',$data);
	}

	public function dashboardTest(){
		$this->load->model('Common_model');
		$con=' WHERE result_date="'.date('Y-m-d').'" AND status NOT IN ("V","P")';
		$data['con1'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Out')";
		$data['con2'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='InHome')";
		$data['con3'] = $con." AND bazar_name IN (select id from regular_bazar where bazar_type='Home')";
		$data['feilds1']='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, COUNT(DISTINCT customer_id) as player, SUM(commission_in_rs) as com';
		$feilds='COUNT(id) as id, SUM(point_in_rs) as point, SUM(winning_in_rs) as win, COUNT(DISTINCT customer_id) as player, SUM(commission_in_rs) as com';
		$data['regular'] = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');

		$data['star'] = $this->Common_model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
		$data['king'] = $this->Common_model->getData('king_bazar_game',$con,$feilds,'','','One','','');

		$data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','One','','');
		echo '<pre>';
		print_r($this->db->last_query());
		print_r($data['worli']);
		die();
		// $data['redTable'] = $this->Common_model->getData('redTable_users_game',$con,$feilds,'','','One','','');
		
		$data['feild'] = 'SUM(point_in_rs) as pending,COUNT(id) as idP, COUNT(DISTINCT customer_id) as playerP,SUM(commission_in_rs) as com';
		$data['con'] = ' WHERE result_date="'.date('Y-m-d').'" AND status="P"';
		$data['conP'] = ' WHERE result_date="'.date('Y-m-d').'" AND status="P" AND bazar_name IN (select id from regular_bazar where bazar_type=';
		// $data['goldenTable'] = $this->Common_model->getData('goldenTable_users_game',$con,$feilds,'','','One','',''); //we close the golden table
        
		$this->load->view('admin/dashboard',$data);
	}

}
