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



class Postdata extends BaseController{







	function __construct(){



	    parent::__construct();



	}







	public function index(){

		//echo "i am here";

		//pr($_POST);

		

		$this->load->model('Postdata_model');

		

		$getgametime = $this->Postdata_model->getgamedetails(strtoupper($_POST['bazar_name']));

		

		$getgameResult = $this->Postdata_model->getgameresultdetails(strtoupper($_POST['bazar_name']),$_POST['result_date']);

		

		pr($getgameResult[0]);

		

		if($_POST['close_result']!=''){

			$declearResult = $_POST['open_result'].'-'.$_POST['jodi_result'].'-'.$_POST['close_result'];

		}else{

			$declearResult = $_POST['open_result'].'-'.$_POST['jodi_result'];

		}

		$addResult = array(



			'game_name' => strtoupper(trim($_POST['bazar_name'])), 



			'result' => $declearResult, 



			'start_time' => $getgametime[0]['start_time'], 



			'end_time' => $getgametime[0]['end_time'], 



			'result_date' => $_POST['result_date'], 



			'highlight' => $_POST['result_mode'],



			'priority' => $getgametime[0]['priority'], 



			'created' => date('Y-m-d H:i:s'), 



			'updated' => date('Y-m-d H:i:s'), 



		);

			if ($getgameResult[0]['id'] > 0) {



				$updateresultid = AddUpdateTable('game_result', 'id', $getgameResult[0]['id'], $addResult);



			}else{



				$updateresultid = AddUpdateTable('game_result', '', '', $addResult);



			}

		pr($addResult);exit;



	}

	

	public function starlineresult(){

				

		if($_POST['bazar']=='Dubai Starline'){

			

			$_POST['bazar']='Dubai Star Line';

		}

					

		$this->load->model('Postdata_model');

		$resTime = explode(' ',$_POST['time']);

		

		$postdate = $_POST['date'];

		

		if($_POST['bazar']=='Dubai Star Line'){

			if($resTime[1]=='AM'){

				$postdate = date("Y-m-d", strtotime($_POST['date']. "-1 day"));

			}

		}

		

		$getgameResult = $this->Postdata_model->getstarlineresult($_POST['bazar'],$postdate);

		

		//pr($getgameResult);

		

		$dubaiArray = array('result_1'=>'10.00','result_2'=>'10.30','result_3'=>'11.00','result_4'=>'11.30','result_5'=>'12.05','result_6'=>'12.30','result_7'=>'01.00','result_8'=>'01.30','result_9'=>'02.00','result_10'=>'02.30','result_11'=>'03.00','result_12'=>'03.30');

		

		$milanArray = array('result_1'=>'09.30','result_2'=>'10.30','result_3'=>'11.30','result_4'=>'12.30','result_5'=>'01.30','result_6'=>'02.30','result_7'=>'03.30','result_8'=>'04.30','result_9'=>'05.30','result_10'=>'06.30','result_11'=>'07.30','result_12'=>'08.30');

		

		$kalyanArray = array('result_1'=>'11.00','result_2'=>'12.00','result_3'=>'01.00','result_4'=>'02.00','result_5'=>'03.00','result_6'=>'04.00','result_7'=>'05.00','result_8'=>'06.00','result_9'=>'07.00','result_10'=>'08.00','result_11'=>'09.00','result_12'=>'10.00');

		

		

		

		

		if($_POST['bazar']=='Kalyan Star Line'){

		

			foreach($kalyanArray as $kalyankey=>$kalyanvalue)

			{

				if($kalyanvalue==$resTime[0]){

					$updateRes = $kalyankey;

				}

			}

		

		}

		

		if($_POST['bazar']=='Milan Starline'){

		

			foreach($milanArray as $milankey=>$milanvalue)

			{

				if($milanvalue==$resTime[0]){

					$updateRes = $milankey;

				}

			}

		

		}

		

		if($_POST['bazar']=='Dubai Star Line'){

			foreach($dubaiArray as $dubaikey=>$dubaivalue)

			{

				if($dubaivalue==$resTime[0]){

					$updateRes = $dubaikey;

				}

			}

		

		}



			if ($getgameResult[0]['id'] > 0) {

				

					$updateAddResult = array(

	

					'result_date' => $_POST['date'], 

	

					'game' => $_POST['bazar'], 

	

					$updateRes => $_POST['result'].'-'.$_POST['resultdigit'],  

	

					'updated' => date('Y-m-d h:i:s'), 

	

					);



				$updateresultid = AddUpdateTable('table_result', 'id', $getgameResult[0]['id'], $updateAddResult);



			}else{

				

					$updateAddResult = array(

	

					'result_date' => $_POST['date'], 

	

					'game' => $_POST['bazar'], 

	

					$updateRes => $_POST['result'].'-'.$_POST['resultdigit'],  

	

					'created' => date('Y-m-d'), 

	

					'updated' => date('Y-m-d h:i:s'), 

	

					);



				$updateresultid = AddUpdateTable('table_result', '', '', $updateAddResult);



			}

			pr($updateresultid);exit; 

		

	}

	

	public function kingbazarresult(){

				

		$this->load->model('Postdata_model');

		

		$getgameResult = $this->Postdata_model->getkingbazarresult($_POST['bazar'],$_POST['result_date']);		

		

		$addResult = array(



				'bazar' => $_POST['bazar'], 



				'result' => $_POST['result'], 



				'result_date' => $_POST['result_date'], 



				'status' => 'Active', 



				'created' => date('Y-m-d H:i:s'), 



				'updated' => date('Y-m-d H:i:s'), 



			);



			if ($getgameResult[0]['id'] > 0) {



				$updateresultid = AddUpdateTable('king_bazar_result', 'id', $getgameResult[0]['id'], $addResult);



			}else{



				$updateresultid = AddUpdateTable('king_bazar_result', '', '', $addResult);



			}

			

			pr($updateresultid);exit;

		

	}

	public function testAPI(){
		ob_start();
		echo "Testing Responce";
		$size = ob_get_length();
		header("Content-Encoding: none");
		header("Content-Length: {$size}");
		header("Connection: close");
		ob_end_flush();
		ob_flush();
		flush();
		// die();
		// sleep(30);
		$fp = fopen('filetestApi.csv', 'wb');
        $data=[];
        for($i=0;$i>100;$i++){
            fputcsv($fp, $i);
        }
        fclose($fp);
        die('done');
		// file_put_contents('test.txt', 'testing');
	}

}