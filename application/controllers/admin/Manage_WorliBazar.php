<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_Kingbazarallresult (Manage_Kingbazarallresult)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_WorliBazar extends BaseController {

    

	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('admin/login');

	}

	public function index(){

	    $this->load->model('ManageKingbazarallresult_Model');

	    $this->load->library('pagination');

	    $data['kingbazarallresult'] = $this->ManageKingbazarallresult_Model->getkingbazarallresultdetails();

	    $config['total_rows'] = count($data['kingbazarallresult']);

	    $config['per_page'] = 10;

		$config['num_links'] = 20;      

		$config['page_query_string'] = TRUE;

		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

	    // pr($this->pagination->create_links());

	    $this->load->view('admin/manage_kingbazarallresult',$data);

	}

	public function AddKingBazarResult($id=''){

		$this->load->model('ManageKingbazarallresult_Model');

		$data['kingbazarallgame'] = $this->ManageKingbazarallresult_Model->getkingbazarallGame();

		if ($id > 0) {

			$data['onegamedata'] = getRecordById('king_bazar_result', 'id', $id);

		}

		if ($_POST) {

			$addResult = array(

				'bazar' => $_POST['bazar_name'], 

				'result' => $_POST['result'], 

				'result_date' => $_POST['result_date'], 

				'status' => $_POST['result_mode'], 

				'created' => date('Y-m-d H:i:s'), 

				'updated' => date('Y-m-d H:i:s'), 

			);

			if ($id > 0) {

				$updateresultid = AddUpdateTable('king_bazar_result', 'id', $id, $addResult);

			}else{

				$updateresultid = AddUpdateTable('king_bazar_result', '', '', $addResult);

			}

				

			if ($updateresultid > 0) {

				redirect('admin/Manage_Kingbazarallresult');

			}

		}

		$this->load->view('admin/add_king_bazzar_result',$data);

	}

	public function deleteBazzarResult($gameid=''){

		// pr($gameid);exit;

		$chartgame = deleteRecord('king_bazar_result','id',$gameid);

		if ($chartgame > 0) {

			redirect('admin/Manage_Kingbazarallresult');

		}

	}


	public function updateWalletKing(){
    	$this->load->model('Common_model');
    	$this->load->model('ManageMatkaallgames_Model');
    	if(isset($_POST)){
    		foreach($_POST as $data){
            	$bet = $this->Common_model->getData('king_bazar_game',' WHERE id="'.$data.'"','transaction_id,bazar_name,game_name,result_date,point,partner_id','','','One','','');

            	$rate = $this->Common_model->getData('king_bazar_rate',' WHERE bazar_name="'.$bet['bazar_name'].'" AND game_type="'.$bet['game_name'].'"','rate','','','One','','');

            	
    			$addResult['commission'] = (2 / 100) * $bet['point']*$rate['rate'];
    			$addResult['winning_point'] = ($bet['point']*$rate['rate'])-$addResult['commission'];
    			$addResult['status']= 'W';
				$updateresultid = AddUpdateTable('king_bazar_game', 'id', $data, $addResult);
    		}
    		
    		$con=" WHERE result_date='".$bet['result_date']."' AND status='P' AND bazar_name='".$bet['bazar_name']."'";
    		$field['status']="L";

    		$updateresultLose = updateAllLose('king_bazar_game', $con, $field);
    		
    		/*--------------------- Setel Market Loss Start --------------------------*/
    		$con1=" INNER JOIN client ON king_bazar_game.partner_id = client.id WHERE king_bazar_game.result_date='".$bet['result_date']."' AND king_bazar_game.bazar_name='".$bet['bazar_name']."'";


    		$arrLossPartner = $this->Common_model->getData('king_bazar_game',$con1,'DISTINCT king_bazar_game.partner_id,client.end_point_url','','','','','');

    		
    		foreach($arrLossPartner as $l){
    			$con2=" WHERE result_date='".$bet['result_date']."' AND partner_id='".$l['partner_id']."' AND bazar_name='".$bet['bazar_name']."'";
    			$arrLossBet = $this->Common_model->getData('king_bazar_game',$con2,'transaction_id,winning_point,status','','','','','');
    			$arrReq['code']='601';
	    		$arrReq['rec']=json_encode($arrLossBet);
	    		$arrReq['market']='King Bazar';
    			$req = requestForClient($l['end_point_url'],$arrReq);
    		}
    		/*--------------------- Setel Market Loss End --------------------------*/

    		$arr=[
    			'status'=>200,
    			'message'=>'Wallet Updated Successfully!'
    		];
    	}else{
    		$arr=[
    			'status'=>400,
    			'message'=>'Somthing Went Wrong'
    		];
    	}
    	die(json_encode($arr));
    }


    public function redTableBetRecords(){
		$this->load->view('admin/redTableBetRecords');
	}

	public function dataRedTable(){
		$postData = $this->input->post();
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getRedTableData($postData);
	    echo json_encode($data);
	}

	public function goldenTableBetRecords(){
		$this->load->view('admin/goldenTableBetRecords');
	}

	public function dataGoldenTable(){
		$postData = $this->input->post();
		$postData['length']='25';
		$Common_model = $this->load->model('Common_model');
	    $data = $this->Common_model->getGoldenTableData($postData);
	    echo json_encode($data);
	}

	public function redTableBhavList(){
        $this->load->view('admin/redTableBhav');
    }
    public function redTableBhavData(){
        $postData = $this->input->post();
        $Data = file_get_contents('php://input');
        $Common_model = $this->load->model('Common_model');
        $data = $this->Common_model->getRedTableBhav($postData);
        echo json_encode($data);
    }
    public function redTableBhav(){
        if($_POST){
            $arr['rate']=$_POST['bhav'];
            $arr['updated_by'] = $_SESSION['adid']['id'];
            $bhav = AddUpdateTable('redTable_rate', 'id', $_POST['id'], $arr);
            if($bhav){
            	$this->load->model('Common_model');
	    		$lstAct['entry_table'] = 'Blue Table Bhav';
				$lstAct['supportId'] = $_SESSION['adid']['id'];
				$lstAct['created'] = date('Y-m-d H:i:s');
				$conLst=' WHERE id="'.$_POST['id'].'"';
				$feildsLst='rate,game_name';
				$lst = $this->Common_model->getData('redTable_rate',$conLst,$feildsLst,'','','One','','');
				$lstAct['detail'] = implode(', ',$lst);
				AddUpdateTable('lastActivity','','',$lstAct);
                die(json_encode(['status'=>200,'massage'=>'Bhav Updated Successfully!']));
            }else{
                die(json_encode(['status'=>400,'massage'=>'Somthing Went Wrong!']));
            }
        }
    }

    public function goldenTableBhavList(){
        $this->load->view('admin/goldenTableBhav');
    }
    public function goldenTableBhavData(){
        $postData = $this->input->post();
        $postData['length']='25';
        $Data = file_get_contents('php://input');
        $Common_model = $this->load->model('Common_model');
        $data = $this->Common_model->getGoldenTableBhav($postData);
        echo json_encode($data);
    }
    public function goldenTableBhav(){
        if($_POST){
            $arr['rate']=$_POST['bhav'];
            $arr['updated_by']=$_SESSION['adid']['id'];
            $bhav = AddUpdateTable('goldenTable_rate', 'id', $_POST['id'], $arr);
            if($bhav){
            	$this->load->model('Common_model');
	    		$lstAct['entry_table'] = 'Golden Table Bhav';
				$lstAct['supportId'] = $_SESSION['adid']['id'];
				$lstAct['created'] = date('Y-m-d H:i:s');
				$conLst=' WHERE id="'.$_POST['id'].'"';
				$feildsLst='rate,game_name';
				$lst = $this->Common_model->getData('goldenTable_rate',$conLst,$feildsLst,'','','One','','');
				$lstAct['detail'] = implode(', ',$lst);
				AddUpdateTable('lastActivity','','',$lstAct);
                die(json_encode(['status'=>200,'massage'=>'Bhav Updated Successfully!']));
            }else{
                die(json_encode(['status'=>400,'massage'=>'Somthing Went Wrong!']));
            }
        }
    }

    public function redTableResultList(){
		if($this->input->post()){
			$postData = $this->input->post();
		    $postData['order'][0]['column']=1;
			$postData['order'][0]['dir']='desc';
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getRedTableResultList($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/redTableResultList');
		}
	}

	public function goldenTableResultList(){
		if($this->input->post()){
			$postData = $this->input->post();
		    $postData['order'][0]['column']=1;
			$postData['order'][0]['dir']='desc';
			$postData['length']='25';
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getGoldenTableResultList($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/goldenTableResultList');
		}
	}

	public function winnerList(){
		if($this->input->post()){
			$postData = $this->input->post();
			$Data = file_get_contents('php://input');
			$Common_model = $this->load->model('Common_model');
		    $data = $this->Common_model->getWinnerList($postData);
		    echo json_encode($data);
		}else{
			$this->load->view('admin/redTableWinnerList');
		}
	}

	public function getCustomersGgr() {
		if($this->input->post()){
			// $Data = json_decode(file_get_contents('php://input'));
			$Data = $this->input->post();
			
			if(isset($Data['date'])){
				$d = explode(' - ',$Data['date']);
				$d1=date('Y-m-d',strtotime($d[0]));
				$d2=date('Y-m-d',strtotime($d[1]));
			}else{
				$d1=date('Y-m-d');
				$d2=date('Y-m-d');
			}
			// Optional: Validate the date format (best practice)
			if (!isset($d1) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $d1) || !isset($d2) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $d2)) {
				show_error('Invalid or missing result_date', 400);
				return;
			}
			$d1="'".$d1."'";
			$d2="'".$d2."'";
			$order = isset($Data['order'])?$Data['order']:'asc';
			$limit = isset($Data['limit'])?$Data['limit']:25;
			// Escape date to prevent SQL injection
			$date = $this->db->escape($Data->result_date);

			// Build the full SQL query using UNION ALL
			$sql = "
				SELECT IFNULL(customer.customer_id, combined_data.customer_id) AS customer_id, customer.name, customer.mobile, customer.app, SUM(point_in_rs) AS total_points, SUM(winning_in_rs) AS total_win_points, (SUM(point_in_rs) - SUM(winning_in_rs)) AS ggr
				FROM (
					SELECT customer_id, point_in_rs, winning_in_rs
					FROM regular_bazar_games
					WHERE result_date BETWEEN $d1 AND $d2

					UNION ALL

					SELECT customer_id, point_in_rs AS point, winning_in_rs
					FROM starline_bazar_game
					WHERE result_date BETWEEN $d1 AND $d2

					UNION ALL

					SELECT customer_id, point_in_rs AS point, winning_in_rs
					FROM king_bazar_game
					WHERE result_date BETWEEN $d1 AND $d2

					UNION ALL

					SELECT customer_id, point_in_rs AS point, winning_in_rs
					FROM warli_users_game
					WHERE result_date BETWEEN $d1 AND $d2

					UNION ALL

					SELECT customer_id, point_in_rs AS point, winning_in_rs
					FROM crezyMatkaGame
					WHERE result_date BETWEEN $d1 AND $d2
				) AS combined_data
				LEFT JOIN customer ON customer.customer_id = combined_data.customer_id
				GROUP BY combined_data.customer_id
				ORDER BY ggr $order
				LIMIT $limit
			";
			// die($sql);
			// Run the query
			$query = $this->db->query($sql);
			$result = $query->result();

			## Response
			if($result){
				$arr = [
					'status'=>200,
					'data'=>$result
				];
			}else{
				$arr = [
					'status'=>203,
					'message'=>'No data found'
				];
			}
			die(json_encode($arr));
		}else{
			$this->load->view('admin/winnerList');
		}
	}

	public function getCustomersGgrDetail() {
		if($this->input->post()){
			$Data = $this->input->post();
			$Common_model = $this->load->model('Common_model');
			$d = explode(' - ',$Data['date']);
			$d1=date('Y-m-d',strtotime($d[0]));
			$d2=date('Y-m-d',strtotime($d[1]));
			
			$date = $this->db->escape($Data->result_date);
			$feilds = "IFNULL(SUM(point_in_rs),0) AS total_points, IFNULL(SUM(winning_in_rs),0) AS total_win_points, IFNULL((SUM(point_in_rs) - SUM(winning_in_rs)),0) AS ggr";
			$con = " WHERE result_date BETWEEN '".$d1."' AND '".$d2."' AND customer_id='".$Data['id']."'";
			// Build the full SQL query using UNION ALL
			
			$feilds1 = $feilds.", IFNULL(GROUP_CONCAT(DISTINCT regular_bazar.bazar_name),'-') AS all_bazars";
			$join = " LEFT Join regular_bazar ON regular_bazar_games.bazar_name=regular_bazar.id";
			$data['regular'] = $this->Common_model->getData('regular_bazar_games',$join.$con,$feilds1,'','','','','');

			$conN = $con." AND regular_bazar_games.status='W'";
			$data['regularHome'] = $this->Common_model->getData('regular_bazar_games',$join.$conN,"IFNULL(GROUP_CONCAT(DISTINCT regular_bazar.bazar_name),'-') AS all_bazars",'','','','','bazar_type');
			//  die(json_encode($this->db->last_query()));
			$feilds2 = $feilds.", IFNULL(GROUP_CONCAT(DISTINCT starline_bazar.bazar_name),'-') AS all_bazars";
			$join = " LEFT Join starline_bazar ON starline_bazar_game.bazar_name=starline_bazar.id";
			$data['starline'] = $this->Common_model->getData('starline_bazar_game',$join.$con,$feilds2,'','','','','');

			$feilds3 = $feilds.", IFNULL(GROUP_CONCAT(DISTINCT king_bazar.bazar_name),'-') AS all_bazars";
			$join = " LEFT Join king_bazar ON king_bazar_game.bazar_name=king_bazar.id";
			$data['kingBazar'] = $this->Common_model->getData('king_bazar_game',$join.$con,$feilds3,'','','','','');

			$data['worli'] = $this->Common_model->getData('warli_users_game',$con,$feilds,'','','','','');
			$data['wheel'] = $this->Common_model->getData('crezyMatkaGame',$con,$feilds,'','','','','');
			

			## Response
			if($data){
				$arr = [
					'status'=>200,
					'data'=>$data
				];
			}else{
				$arr = [
					'status'=>203,
					'message'=>'No data found'
				];
			}
			die(json_encode($arr));
		}else{
			$this->load->view('admin/winnerList');
		}
	}
}