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

Class ClientPanel extends BaseController {



	function __construct(){
	    parent::__construct();
	    if(! $this->session->userdata('client'))
	    redirect('462dad51418ceb8ba9d4d7972da579ec');
	}

	public function dashboard(){
		$this->load->model('Client_Model');
		$con=' WHERE result_date="'.date('Y-m-d').'" AND partner_id="'.$_SESSION['client']['id'].'"';
		$feilds='COUNT(id) as id, SUM(point) as point, SUM(winning_point) as win';
		$this->data['regular'] = $this->Client_Model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
		$this->data['star'] = $this->Client_Model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
		$this->data['king'] = $this->Client_Model->getData('king_bazar_game',$con,$feilds,'','','One','','');
		$this->load->view('client/dashboard', $this->data); 
	}

	public function pnlBetween(){
		$this->load->model('Client_Model');
		if($_POST){
			$d=explode(" - ",$_POST['date']);
			$con=' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($d[0])).'" AND "'.date('Y-m-d',strtotime($d[1])).'" AND partner_id="'.$_SESSION['client']['id'].'"';
			$feilds='COUNT(id) as id, SUM(point) as point, SUM(winning_point) as win';
			$data['regular'] = $this->Client_Model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
			$data['star'] = $this->Client_Model->getData('starline_bazar_game',$con,$feilds,'','','One','','');
			$data['king'] = $this->Client_Model->getData('king_bazar_game',$con,$feilds,'','','One','','');
			
			$rI=(int)$data['regular']['id'];
			$rB=(int)$data['regular']['point'];
			$rW=(int)$data['regular']['win'];

			$sI=(int)$data['star']['id'];
			$sB=(int)$data['star']['point'];
			$sW=(int)$data['star']['win'];

			$kI=(int)$data['king']['id'];
			$kB=(int)$data['king']['point'];
			$kW=(int)$data['king']['win'];

			$tI=$rI+$sI+$kI;
			$tB=$rB+$sB+$kB;
			$tW=$rW+$sW+$kW;

			$rG=$rB-$rW;
			$sG=$sB-$sW;
			$kG=$kB-$kW;

			$tGGR=$tB-$tW;

			$mGGR= ($tGGR/100)*$_SESSION['client']['percentage'];
			$dome = '<div class="row">
						<div class="col-lg-3 col-md-3 col-xs-6">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h4 class="text-center">Regular Bets</h4>Bets : <span class="bets">'.$rI.'</span><br>
									Points : <span class="bets">'.$rB.'</span><br>
									Winning : <span class="bets">'.$rW.'</span><br>
									GGR : <span class="bets">'.$rG.'</span>
								</div>
								<div class="icon"><i class="ion ion-bag"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-6">
							<div class="small-box bg-green">
								<div class="inner">
									<h4 class="text-center">Starline Bets</h4>Bets : <span class="bets">'.$sI.'</span><br>
									Points : <span class="bets">'.$sB.'</span><br>
									Winning : <span class="bets">'.$sW.'</span><br>
									GGR : <span class="bets">'.$sG.'</span>
								</div>
								<div class="icon"><i class="ion ion-stats-bars"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-6">
							<div class="small-box bg-yellow">
								<div class="inner">
									<h4 class="text-center">King Bets</h4>
									Bets : <span class="bets">'.$kI.'</span><br>
									Points : <span class="bets">'.$kB.'</span><br>
									Winning : <span class="bets">'.$kW.'</span><br>
									GGR : <span class="bets">'.$kG.'</span>
								</div>
								<div class="icon"><i class="ion ion-person-add"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-6">
							<div class="small-box bg-red">
								<div class="inner">
									<h4 class="text-center">
									GGR</h4>Total : <span class="bets">'.$tI.'</span><br>
									Points : <span class="bets">'.$tB.'</span><br>
									Winning : <span class="bets">'.$tW.'</span><br>
									GGR : <span class="bets">'.$tGGR.'</span>
									My Share : <span class="bets">'.$mGGR.'</span>
								</div>
								<div class="icon"><i class="ion ion-pie-graph"></i></div>
								<a href="#" class="small-box-footer">
									More info
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>';
			die($dome);
		}else{
			$this->load->view('client/pnlBetween');
		}
	}

	public function regularBazar(){
		 
		$record_per_page = 5;
		$cnMethod = trim('regularBazar');
		$cnName = trim('client/ClientPanel');
		  
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$page = $_POST['page'];
			$fieldsArray =  $_POST['fields'];
			$fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'],  "gameType"=>$fieldsArray['5'], "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);

			// $total_records = $_POST['total_records'];

			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*5;
				 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$record_per_page = 5;
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		    $fields = array("transactionId"=>"", "customerId"=>"", "bazarName"=>"", "gameName"=>"",  "gameType"=>"", "resultDate"=>"", "game"=>"", "point"=>"", "status"=>"");
		} 
		 
		if($flag == 0){
			$tableName = 'regular_bazar_games';
		}

		$this->load->model('ClientData_Model');

		if($flag == 0)	{
			$total_records = $this->ClientData_Model->countRecordRB($tableName, $fields);
			$this->data['fields'] = $fields;
			$this->data['total_records'] = $total_records;
			$this->data['total_pages'] = ceil($total_records/$record_per_page);
			$this->data['controllerName'] = 'client/ClientPanel';
			$this->data['controllerFunction'] = 'regularBazar';
			$this->data['tableName'] = 'regular_bazar_games';
			$this->data['regularbazar'] = $this->ClientData_Model->loadDataRB($tableName, $fields, $offset=0, $record_per_page); 	 
		}
		$total_pages = ceil($total_records/$record_per_page); 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages; 
			$this->load->view('client/regularBazarList', $this->data);
		}else {
			$tableData = $this->ClientData_Model->loadDataRB($tableName, $fields, $offset, $record_per_page);
			$this->loadPageRB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, json_encode($fields));  
		}	 
	}
 
	 
	public function searchResultRB()	{ 
		 
		 
		 $record_per_page = 5;
		 $page = 1;
		 $cnName = 'client/ClientPanel';
		 $cnMethod = 'searchResultRB';
		 $tableName = $_POST['tableName'];
		 $fieldsArray =  $_POST['fields'];
		 $fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'],  "gameType"=>$fieldsArray['5'], "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);
		 $total_records = $_POST['total_records'];

		 

		 if(isset($_POST['page']))	{
				$page = $_POST['page'];	 
		 }
		 $offset =($page-1)*5;
		 $this->load->model('ClientData_Model');
		 if($offset == 0 && $total_records == 0)	{
			 $total_records = $this->ClientData_Model->countRecordRB($tableName,  $fields); 
		 } 
		 $data = $this->ClientData_Model->loadDataRB($tableName, $fields, $offset, $record_per_page);
		  
		 $total_pages = ceil($total_records/$record_per_page);
		 $this->loadPageRB($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields);
	}

	public function loadPageRB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields){
		$output = '';
		$record_per_page = 5;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Transaction Id</th>
			<th>Customer Id</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Game Type</th>
			<th>Result Date</th>
			<th>Game</th>
			<th>Status</th>
			<th>Point</th>
			<th>Winning Point</th>
		</tr>';
		  
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["transaction_id"].'</td>
					<td>'.$d["customer_id"].'</td>
					<td>'.$d["bazar_name"].'</td>
					<td>'.$d["game_name"].'</td>
					<td>'.$d["game_type"].'</td>
					<td>'.$d["result_date"].'</td>
					<td>'.$d["game"].'</td>
					<td>'.$d["status"].'</td>
					<td>'.$d["point"].'</td>
					<td></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';
		 

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
		$fields = str_replace('"', "'", $fields);
			if($page>1)	{
			 
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextRB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',  \''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextRB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',\''.$current_page.'\')">Prev</span>';
				 }
				   
			}

			 
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageRB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if(($total_pages >= $page) && ($total_pages <= $page+2) )	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageRB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	  
  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextRB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.', \''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		
		echo $output;	
	}

	public function starBazar(){
		 
		$record_per_page = 5;
		$cnMethod = trim('starBazar');
		$cnName = trim('client/ClientPanel');
		  
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$page = $_POST['page'];
			$fieldsArray =  $_POST['fields'];
			$fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'], "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);

			$total_records = $_POST['total_records'];

			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*5;
				 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$record_per_page = 5;
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		    $fields = array("transactionId"=>"", "customerId"=>"", "bazarName"=>"", "gameName"=>"",  "resultDate"=>"", "game"=>"", "point"=>"", "status"=>"");
		} 
		 
		if($flag == 0){
			$tableName = 'starline_bazar_game';
		}

		$this->load->model('ClientData_Model');

		if($flag == 0)	{
			$total_records = $this->ClientData_Model->countRecordSB($tableName, $fields);
			$this->data['fields'] = $fields;
			$this->data['total_records'] = $total_records;
			$this->data['total_pages'] = ceil($total_records/$record_per_page);
			$this->data['controllerName'] = 'client/ClientPanel';
			$this->data['controllerFunction'] = 'starBazar';
			$this->data['tableName'] = 'starline_bazar_game';
			$this->data['starlinebazar'] = $this->ClientData_Model->loadDataSB($tableName, $fields, $offset=0, $record_per_page); 	 
		}
		$total_pages = ceil($total_records/$record_per_page); 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages; 
			$this->load->view('client/starBazarList', $this->data);
		}else {
			$tableData = $this->ClientData_Model->loadDataSB($tableName, $fields, $offset, $record_per_page);
			$this->loadPageSB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, json_encode($fields));  
		}	 
	}
 
	 
	public function searchResultSB()	{ 
		 
		 $record_per_page = 5;
		 $page = 1;
		 $cnName = 'client/ClientPanel';
		 $cnMethod = 'searchResultSB';
		 $tableName = $_POST['tableName'];
		 $fieldsArray =  $_POST['fields'];
		 $fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'],  "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);
		 $total_records = $_POST['total_records'];
		 if(isset($_POST['page']))	{
				$page = $_POST['page'];	 
		 }
		 $offset =($page-1)*5;
		 $this->load->model('ClientData_Model');
		 if($offset == 0 && $total_records == 0)	{
			 $total_records = $this->ClientData_Model->countRecordSB($tableName,  $fields); 
		 } 
		 $data = $this->ClientData_Model->loadDataSB($tableName, $fields, $offset, $record_per_page);
		 $total_pages = ceil($total_records/$record_per_page);
		 $this->loadPageSB($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields);
	}

	public function loadPageSB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields){
		$output = '';
		$record_per_page = 5;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Transaction Id</th>
			<th>Customer Id</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Result Date</th>
			<th>Game</th>
			<th>Status</th>
			<th>Point</th>
			<th>Winning Point</th>
		</tr>';
		  
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["transaction_id"].'</td>
					<td>'.$d["customer_id"].'</td>
					<td>'.$d["bazar_name"].'</td>
			        <td>'.$d["game_name"].'</td>
			        <td>'.$d["result_date"].'</td>
					<td>'.$d["game"].'</td>
					<td>'.$d["status"].'</td>
					<td>'.$d["point"].'</td>
					<td></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';
		 

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
		$fields = str_replace('"', "'", $fields);
			if($page>1)	{
			 
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',  \''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',\''.$current_page.'\')">Prev</span>';
				 }
				   
			}

			 
			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if(($total_pages >= $page) && ($total_pages <= $page+2) )	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageSB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	  
  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextSB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.', \''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		
		echo $output;	
	}


	public function kingBazar(){
		 
		$record_per_page = 5;
		$cnMethod = trim('kingBazar');
		$cnName = trim('client/ClientPanel');
		  
		if(isset($_POST['tableName']))	{
			$tableName = $_POST['tableName'];
			$page = $_POST['page'];
			$fieldsArray =  $_POST['fields'];
			$fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'],  "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);

			$total_records = $_POST['total_records'];

			if(isset($_POST['currentPage'] ) && $page == 'next') {
				 $offset = 0;
			} else if($page == 'prev')	{
				 $offset = 0;
			} else {
				$offset =($page-1)*5;
				 
			}
			$total_records = $_POST['total_records'];
			$flag = 1;
		} else {
			$record_per_page = 5;
		    $page = 1;
			$flag = 0;
		    $offset = 0;
		    $fields = array("transactionId"=>"", "customerId"=>"", "bazarName"=>"", "gameName"=>"",  "resultDate"=>"", "game"=>"", "point"=>"", "status"=>"");
		} 
		 
		if($flag == 0){
			$tableName = 'king_bazar_game';
		}

		$this->load->model('ClientData_Model');

		if($flag == 0)	{
			$total_records = $this->ClientData_Model->countRecordKB($tableName, $fields);
			$this->data['fields'] = $fields;
			$this->data['total_records'] = $total_records;
			$this->data['total_pages'] = ceil($total_records/$record_per_page);
			$this->data['controllerName'] = 'client/ClientPanel';
			$this->data['controllerFunction'] = 'kingBazar';
			$this->data['tableName'] = 'king_bazar_game';
			$this->data['kingbazar'] = $this->ClientData_Model->loadDataKB($tableName, $fields, $offset=0, $record_per_page); 	 
		}
		$total_pages = ceil($total_records/$record_per_page); 
		if($flag == 0)	{
			$this->data['total_pages'] =$total_pages; 
			$this->load->view('client/kingBazarList', $this->data);
		}else {
			$tableData = $this->ClientData_Model->loadDataKB($tableName, $fields, $offset, $record_per_page);
			$this->loadPageKB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, json_encode($fields));  
		}	 
	}
 
	 
	public function searchResultKB()	{ 
		 
		 $record_per_page = 5;
		 $page = 1;
		 $cnName = 'client/ClientPanel';
		 $cnMethod = 'searchResultKB';
		 $tableName = $_POST['tableName'];
		 $fieldsArray =  $_POST['fields'];
		 $fields = array("transactionId"=>$fieldsArray['1'], "customerId"=>$fieldsArray['2'], "bazarName"=> $fieldsArray['3'], "gameName"=>$fieldsArray['4'],  "resultDate"=>$fieldsArray['6'], "game"=>$fieldsArray['7'], "point"=>$fieldsArray['8'], "status"=>$fieldsArray['9']);
		 $total_records = $_POST['total_records'];
		 if(isset($_POST['page']))	{
				$page = $_POST['page'];	 
		 }
		 $offset =($page-1)*5;
		 $this->load->model('ClientData_Model');
		 if($offset == 0 && $total_records == 0)	{
			 $total_records = $this->ClientData_Model->countRecordKB($tableName,  $fields); 
		 } 
		 $data = $this->ClientData_Model->loadDataKB($tableName, $fields, $offset, $record_per_page);
		 $total_pages = ceil($total_records/$record_per_page);
		 $this->loadPageKB($data, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields);
	}

	public function loadPageKB($tableData, $total_records, $total_pages, $page, $cnName, $cnMethod, $tableName, $fields){
		$output = '';
		$record_per_page = 5;
		$output .= '<div class="box-body table-responsive no-padding"> <table class="table table-hover">
		<tr>
			<th>SR#</th>
			<th>Transaction Id</th>
			<th>Customer Id</th>
			<th>Bazar Name</th>
			<th>Game Name</th>
			<th>Result Date</th>
			<th>Game</th>
			<th>Status</th>
			<th>Point</th>
			<th>Winning Point</th>
		</tr>';
		  
		if($tableData){
			 
			$sr = 1;
			foreach($tableData as $d){
				$output .= '<tr>
					<td>'.$sr.'</td>
					<td>'.$d["transaction_id"].'</td>
					<td>'.$d["customer_id"].'</td>
					<td>'.$d["bazar_name"].'</td>';
					if($d["game_name"] == '1')	{
						$output .= '<td> First Digit(Ekai) </td>';
					}else if($d["game_name"] == '2'){
						$output .= '<td> Second Digit(Haruf) </td>';
					}else if($d["game_name"] == '3')	{
						$output .= '<td> Jodi </td>';
					}
				$output .= '<td>'.$d["result_date"].'</td>
					<td>'.$d["game"].'</td>
					<td>'.$d["status"].'</td>
					<td>'.$d["point"].'</td>
					<td></td>
				</tr>';
				$sr++;
			}
		}
		$output .='</table> </div>';
		 

		$output .= '<div class="box-footer clearfix" id="pagination">
	    <ul class="pagination pull-right">';
		$flag = 0;
		static $page_loaded = 3;
		$fields = str_replace('"', "'", $fields);
			if($page>1)	{
			 
				$current_page = $page -3;
				$prev = 'prev';
				 if($page > 3)	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',  \''.$current_page.'\')">Prev</span>';
				 } else {
					$current_page = 1;
					$page_loaded = 1;
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$prev.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.',\''.$current_page.'\')">Prev</span>';
				 }
				   
			}

			if($total_pages > $page+2 )	{
				for($i = $page; $i<=$page+2; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	   
				}
				$page_loaded  = $page+2;
			}else if(($total_pages >= $page) && ($total_pages <= $page+2) )	{
				
				for($i = $page; $i<=$total_pages; $i++) {
					$output .=	'<span id="'.$i.'" style="cursor: pointer; margin: 0px 10px;" onClick="loadpageKB('.$i.','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.')">'.$i.'</span>';	  
  
				}
				$page_loaded = $total_pages;
			}
			if( $total_pages - ($page_loaded-1) > 0)	{
				 
				$num = ceil($highest/2);
				$page_start = ($num-1)*2+1;
				$page_end = $page_start+2-1;
				$next = "next";
				$current_page = $page_loaded;
				 
				 
				 if(($total_pages > $page) && ($page_loaded < $total_pages))	{
					$output .=	'<span id="next" style="cursor: pointer; margin: 0px 10px;" onClick="prevNextKB(\''.$next.'\','.$total_records.',\''.$cnName.'\',\''.$cnMethod.'\',\''.$tableName.'\', '.$fields.', \''.$current_page.'\')">Next</span>';	
				 }
			 
			}
		
		echo $output;	
	}

	public function searchDataList()	{
			$tableName = $_POST['tableName'];
			$fieldName = $_POST['fieldName'];
			$fieldValue = $_POST['fieldValue'];
			$this->load->model('ClientData_Model');
			$bazarNameList = $this->ClientData_Model->bazarNameList($tableName, $fieldName, $fieldValue); 
		    echo json_encode($bazarNameList);

  

	}

	   
}

