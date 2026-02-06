<?php

defined('BASEPATH') OR exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';

/**

 * Class : Manage_CrezyMatka (Manage_CrezyMatka)

 * User Class to control all user related operations.

 * @author : Mangesh

 * @version : 1.1

 * @since : 20 April 2021

 */

Class Manage_CrezyMatka extends BaseController {

    

	function __construct(){

	    parent::__construct();

	    if(! $this->session->userdata('adid'))

	    redirect('admin/login');

	}

    public function crezyMarkaResultList(){
        if($this->input->post()){
            $postData = $this->input->post();
            $Common_model = $this->load->model('Common_model');
            $data = $this->Common_model->crezyMarkaResultList($postData);
            echo json_encode($data);
        }else{
            $this->load->view('admin/crezyMarkaResultList',$data);
        }
    }

    public function crezyMarkaGameList(){
        $Common_model = $this->load->model('Common_model');
        if($this->input->post()){
            $postData = $this->input->post();
            $data = $this->Common_model->crezyMarkaGameList($postData);
            echo json_encode($data);
        }else{
            $data['client'] = $this->Common_model->getData('client',' WHERE status="A"','','','','','','');
            $this->load->view('admin/crezyMarkaGameList',$data);
        }
    }

    public function crezyMarkaRateList(){
        $Common_model = $this->load->model('Common_model');
        if($_POST){
            $addUsr['bhav']=$_POST['bhav'];
            $update = AddUpdateTable('crezyMatkaBhav', 'id', '1', $addUsr);
            if($update){
                $data = ['status'=>200,'massage'=>'Bhav Updated.'];
            }else{
                $data = ['status'=>400,'massage'=>'Somthing Went Wrong.'];
            }
            die(json_encode($data));
        }else{
            $data['bhav'] = $this->Common_model->getData('crezyMatkaBhav','','','','','One','','');
            $this->load->view('admin/crezyMarkaRateList',$data);
        }
    }

    public function backBusinessCrazyWheel(){
		if($_POST){
		    $this->load->model('Common_model');
		    $dback = explode(' - ',$_POST['dateRange']);
			$con = ' WHERE result_date BETWEEN "'.date('Y-m-d',strtotime($dback[0])).'" AND "'.date('Y-m-d',strtotime($dback[1])).'"';
		    $data=$this->Common_model->getData('crezyMatkaGame',$con,'COUNT(DISTINCT customer_id) as customer,COUNT(id) as bets,SUM(point_in_rs) as point,SUM(winning_in_rs) as win,SUM(commission_in_rs) as com','','','One','','');
            $ggrCom = (($data['point']-$data['win'])+$data['com']);
            $ggr = ($data['point']-$data['win']);
            if($ggr < 0){
                $sty = 'color:#fff;background-color:red';
            }else{
                $sty = 'color:#fff;background-color:green';
            }
            $dome = '<table class="table"><thead><tr><th scope="col">#</th><th scope="col">Bets</th><th>Customer</th><th>Points</th><th scope="col">Winning</th><th scope="col">Commission</th><th scope="col">GGR</th><th scope="col">GGR+Commission</th></tr></thead><tbody><tr><th scope="row">1</th><td>'.$data['bets'].'</td><td>'.$data['customer'].'</td><td>'.$data['point'].'</td><td>'.round($data['win'],2).'</td><td>'.round($data['com'],2).'</td><td style="'.$sty.'">'.round($ggr,2).'</td><td>'.round($ggrCom,2).'</td></tr></tbody></table>';
		    die(json_encode($dome));
		}else{
		    $this->load->view('admin/backBusinessCrazyWheel');
		}
	}


    public function checkProbability(){
		$this->load->model('Common_model');
        $con = ' WHERE round_id="mXqbPMYehh4sY1C9iZIHsmXxcEiU25FS"';
        $result = $this->Common_model->getData('crezyMatkaGame',$con,'game,COUNT(DISTINCT customer_id) as customer,COUNT(id) as bets,SUM(point_in_rs) as point','','','','game ASC','game');
        $rate = 9.5;
        
        $pArr = [];
        $pArrN = [];
        $s = [];
        $totalPoint = array_sum(array_column($result,'point'));
        
        foreach($result as $b){
            if($b['game']==11){
                $b['redBlack'] = [];
                for($i=2;$i<25;$i++){
                    $pArrN[$b['game'].'r'.$i] = ['profit'=>$totalPoint-($b['point']*$i),'customer'=>$b['customer']];
                }
            }else if($b['game']==10){
                $k = [10,25,50,100,200];
                $b['crazyWheel'] = [];
                foreach($k as $p){
                    $pArrN[$b['game'].'c'.$p] = ['profit'=>$totalPoint-($b['point']*$p),'customer'=>$b['customer']];
                }
            }else{
                $s['win'] = $b['point']*$rate;
                $x = $totalPoint-$s['win'];
                $pArrN[$b['game']] = ['profit'=>$x,'customer'=>$b['customer']];
            }
            $b['prof'] = $totalPoint-$s['win'];
            array_push($pArr,$b);
        }

            $res =$this->profitableR($pArrN,0.05,$totalPoint);
            // array_push($pArr,$res);
            echo '<pre>';
            print_r($res);
            print_r($result);
            die();
    }
    function profitableR($arr, $profitPercent, $totalPoint) {
        $targetProfit = $totalPoint * $profitPercent;

        $bestKey = null;
        $bestProfit = null;
        $bestCustomers = null;
        $closestDiff = PHP_INT_MAX;

        foreach ($arr as $key => $data) {
            $profit = $data['profit'];
            $customers = $data['customer'];
            if ($profit <= 0) continue; // skip losses
            $diff = abs($profit - $targetProfit);
            // Choose the closest profit OR, if same diff, higher customer
            if (
                $diff < $closestDiff ||
                ($diff === $closestDiff && $customers > $bestCustomers)
            ) {
                $closestDiff = $diff;
                $bestKey = $key;
                $bestProfit = $profit;
                $bestCustomers = $customers;
            }
        }
        return [
            'key' => $bestKey,
            'profit' => $bestProfit,
            'customer' => $bestCustomers,
            'target' => $targetProfit
        ];
    }


}