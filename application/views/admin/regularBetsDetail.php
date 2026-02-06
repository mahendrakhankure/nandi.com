<?php 
    include 'includes/header.php';
?>
<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
        <style>
            a {
                padding: 5px;
            }
 			.oRes{
 				background-color: #081f58;
 			}
        </style>

<?php
    function get_common_sql($bazar,$game,$game_type){
    	$CI =& get_instance();
    	$arr = ['7','46','47','11'];
        if(in_array($game,$arr)){
            $con=' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'" AND status!="V"';
        } else {
          	$con=' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'" AND status!="V"';
        }
        // $feilds = 'SUM(point) AS money, COUNT(id) AS id, game AS game';
		$feilds = 'SUM(point_in_rs) AS money, COUNT(id) AS id, game AS game';
        return $CI->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','','game');
	}
	function get_common_total_sql($bazar,$game,$game_type){
		$CI =& get_instance();
		$con = ' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'" AND status!="V"';
		// $feilds = 'SUM(point) AS money, COUNT(id) AS id';
		$feilds = 'SUM(point_in_rs) AS money, COUNT(id) AS id';
		return $CI->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
	}
	
    $sPatti=['1','7','12','15','16','18','19','20','24','25','26','27','28','29','30','31','32','33'];
    $dPatti=['2','13','34','36','39','40','41','43','46'];
    $tPatti=['4','35','42','45','47','48'];
    $family=[];
    $jodi=['6','10','11','14','17','22','23'];
?>

<style type="text/css">
    .boxPanna span { padding: 20px; font-size: x-large;}
	.boxPanna{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; color: #FF1362; min-height: 50px;}
	.box{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; text-align: center; color: #FF1362; min-height: 50px;}
	.box1{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; color: #FF1362; }
	.bazarHeader { padding: 8px; border: solid 1px #FF1362; margin: 0; text-align: center }
	.jodi{ border: 1px solid #BFE924; padding: 8px; margin: 10px;  size: 30px 30px; height: 70px; width: 138px;}
	.sangam{ border: 1px solid #BFE924; padding: 8px; margin: 10px;  size: 30px 30px; height: 80px; width: 255px;}
	.sopen{ border: 1px solid #BFE924; padding: 4px; margin: 5px; height: 60px; width: 200px;    float: left;}
	.game{ font-size: 15px;  text-align:left; color: #e65100; background: #f4ff81;}
	.amount{ font-size: 20px; text-align: right; color: #004d40; font-weight: 100%;}
	.akda{ color: #1c2331; padding: 15px; background-color: #f4ff81;}
	.title {
		border: 2px solid #0800FF;padding-top: 20px;padding-bottom: 20px;margin-bottom: 20px;color: #00A6D3;text-align: center; }
	td{
		padding:20px;
		text-align: center;
		border:1px solid #ccc;
	}
	#search {
        padding: 5px;
        width: 80px;
        margin: 23px 0px;
    }
    .jodi{
    	float: left;
    }
</style>
<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="title"><?=strtoupper(urldecode($gameName))?></h3>
				<?php
					if(!empty($result)){
						echo '<b>Todays Result :- '.$result['open'].'-'.$result['jodi'].'-'.$result['close'].'</b>';
					} else {
						echo "<b>Todays Result :- ***-**-***</b>";
					}
				?>
			</div>
		</div>
		<div class="row">
			<?php 
				if($game=="5"){
				$allGames = get_common_total_sql($bazar,$game,$type);
				$allTotal = 0;
				$allTotal = $allGames['money'];
				$allData = get_common_sql($bazar,$game,$type);
				$ng = array_column($allData, 'game');
			?>
				<div class='col-md-12'><div class='box bazarHeader'><h3><?=$type?></h3></div></div>
			<?php
				for ($i=0; $i < 10; $i++) { 
					if($type=='Open' && $i==$result['jodi'][0] || $type=='Close' && $i==$result['jodi'][1]){
						$hi = 'oRes';
					}else{
						$hi = '';
					}
					$Total = 0;

					$newIndex = array_search($i, $ng);
					$openData = $allData[$newIndex];
	          		
					if($newIndex === FALSE){
							$Total = "-";
							$sty = "color:ccc";
							$Data = "-";
					} else {
						$sty = "color:red";
						$Data = $openData['id'];
						$Total = $openData['money'].".00";
					}
					echo $html = "<div class='col-md-6'>
							<div class='box1 $hi'>
								<span class='akda'>".$i."</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span>Total Bet : ".$Data."</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class='amount' style='".$sty."'>Amt : ".$Total."</span>
							</div>	
						</div>
						";
				}
				echo "<div class='col-md-12'>
					<div class='box bazarHeader'>
						<h3>
							TOTAL BET : ".$allGames['id']."
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							TOTAL AMOUNT : ".$allTotal.".00
						</h3>
					</div>
				</div>";

				}  else if (in_array($game, $sPatti)) {
					echo "<div class='col-md-12'><div class='box bazarHeader'><h3>".$game." - ".$type."</h3></div></div>";
				
					echo"<div class='col-md-12'>";
					$allGames = get_common_total_sql($bazar,$game,$type);
					
					$allTotal = 0;
					$allTotal += $allGames['money'];
					// for ($i=0; $i < 10; $i++) { 
					$patti = ['120', '123', '124', '125', '126', '127', '128', '129', '130', '134', '135', '136', '137', '138', '139', '140', '145', '146', '147', '148', '149', '150', '156', '157', '158', '159', '160', '167', '168', '169', '170', '178', '179', '180', '189', '190', '230', '234', '235', '236', '237', '238', '239', '240', '245', '246', '247', '248', '249', '250', '256', '257', '258', '259', '260', '267', '268', '269', '270', '278', '279', '280', '289', '290', '340', '345', '346', '347', '348', '349', '350', '356', '357', '358', '359', '360', '367', '368', '369', '370', '378', '379', '380', '389', '390', '450', '456', '457', '458', '459', '460', '467', '468', '469', '470', '478', '479', '480', '489', '490', '560', '567', '568', '569', '570', '578', '579', '580', '589', '590', '670', '678', '679', '680', '689', '690', '780', '789', '790', '890'];
					$allData = get_common_sql($bazar,$game,$type);
					$ng = array_column($allData, 'game');
					foreach ($patti as $p) {
						$Total = 0;
						$newIndex = array_search($p, $ng);
						$openData = $allData[$newIndex];
						
						if($newIndex === FALSE){
							$sty = "color:ccc";
							$Data = "-";
							$Total = "-";
						}else{
							$sty = "color:red";
							$Total = $openData['money'].".00";
							$Data = $openData['id'];
						}
						if($type=='Open' && $p==$result['open'] || $type=='Close' && $p==$result['close']){
							$hi = 'oRes';
						}else{
							$hi = '';
						}
						echo $html = "
								<div class='sopen $hi'>
									<span class='game'>".$p."</span>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span>: ".$Data."</span>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span class='amount' style='".$sty."'>: ".$Total."</span>
								</div>";
					}
					
				// }
				echo"</div>";
				echo "<div class='col-md-12'>
						<div class='box bazarHeader'>
							<h3>
								TOTAL BET : ".$allGames['id']."
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								TOTAL AMOUNT : ".$allTotal.".00
							</h3>
						</div>
					</div>";

				/*----------------------------------------------------------------------------*/
				
				}  else if(in_array($game, $dPatti)){

					echo "<div class='col-md-12'><div class='box bazarHeader'><h3>".$type."</h3></div></div>";
				
					echo"<div class='col-md-12'>";
					$allGames = get_common_total_sql($bazar,$game,$type);
					$allTotal = 0;
					$allTotal += $allGames['money'];
					// for ($i=0; $i < 10; $i++) { 
					$patti = ['100', '110', '112', '113', '114', '115', '116', '117', '118', '119', '122', '133', '144', '155', '166', '177', '188', '199', '200', '220', '223', '224', '225', '226', '227', '228', '229', '233', '244', '255', '266', '277', '288', '299', '300', '330', '334', '335', '336', '337', '338', '339', '344', '355', '366', '377', '388', '399', '400', '440', '445', '446', '447', '448', '449', '455', '466', '477', '488', '499', '500', '550', '556', '557', '558', '559', '566', '577', '588', '599', '600', '660', '667', '668', '669', '677', '688', '699', '700', '770', '778', '779', '788', '799', '800', '880', '889', '899', '900', '990'];
					
					$allData = get_common_sql($bazar,$game,$type);
					$ng = array_column($allData, 'game');
					foreach ($patti as $p) {
						$Total = 0;
						$newIndex = array_search($p, $ng);
						$openData = $allData[$newIndex];
						if($newIndex === FALSE){
							$sty = "color:ccc";
							$Data = "-";
							$Total = "-";
						}else{
							$sty = "color:red";
							$Total = $openData['money'].".00";
							$Data = $openData['id'];
						}
						if($type=='Open' && $p==$result['open'] || $type=='Close' && $p==$result['close']){
							$hi = 'oRes';
						}else{
							$hi = '';
						}
						echo $html = "
								<div class='sopen %hi'>
									<span class='game'>".$p."</span>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span>: ".$Data."</span>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span class='amount' style='".$sty."'>: ".$Total."</span>
								</div>";
					}
					
				// }
	            echo"</div>";  
				echo "<div class='col-md-12'>
						<div class='box bazarHeader'>
							<h3>
								TOTAL BET : ".$allGames['id']."
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								TOTAL AMOUNT : ".$allTotal.".00
							</h3>
						</div>
					<div>";

				/*----------------------------------------------------------------------------*/

				} else if(in_array($game, $tPatti)){
					echo "<div class='col-md-12'><div class='box bazarHeader'><h3>".$type."</h3></div></div>";

					$sangams = ["000","111","222","333","444","555","666","777","888","999"];
					$allGames = get_common_total_sql($bazar,$game,$type);
					$allTotal = 0;
					$allTotal += $allGames['money'];

					$allData = get_common_sql($bazar,$game,$type);
					$ng = array_column($allData, 'game');
					foreach ($sangams as $sangam){ 
						$sangamTotal = 0;

						$newIndex = array_search($sangam, $ng);
						$sangamData = $allData[$newIndex];

						if($newIndex === FALSE){
							$sty = "color:ccc";
							$sangamTotal = "-";
							$Data = "-";
						} else {
							$sty = "color:red";
							$Data = $sangamData['id'];
							$sangamTotal = $sangamData['money'].".00";
						}
						if($type=='Open' && $p==$result['open'] || $type=='Close' && $p==$result['close']){
							$hi = 'oRes';
						}else{
							$hi = '';
						}
						echo $html = "<div class='sangam $hi'>
								<span class='game'>".$sangam."</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span>: ".$Data."</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span class='amount' style='".$sty."'>: ".$sangamTotal."</span>
							</div>";
					}
					echo "<div class='col-md-12'>
							<div class='box bazarHeader'>
								<h3>
									TOTAL BET : ".$allGames['id']."
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									TOTAL AMOUNT : ".$allTotal.".00
								</h3>
							</div>
						</div>";
				
				}  else if (in_array($game, $jodi)){
			?>
				<!-- <div class='col-md-12'><div class='box bazarHeader'><h3><?=$game?></h3></div></div> -->
				<?php
					$CI =& get_instance();
	              	// $in = '("'.implode('","',$game).'")';
	              	// $feilds = 'SUM(point) AS money, COUNT(id) AS id';
					  $feilds = 'SUM(point_in_rs) AS money, COUNT(id) AS id';
	              	$con = ' WHERE game_name="'.$game.'" AND result_date ="'.date('Y-m-d').'" AND game_type="Jodi" AND bazar_name ="'.$bazar.'"';
					$allGames = $CI->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
					$allTotal = 0;
					$allTotal += $allGames['money'];
					
					$allData = get_common_sql($bazar,$game,"Jodi");
					
					$ng = array_column($allData, 'game');
					// echo '<pre>';
					// print_r($ng);
					for ($i=00; $i < 100; $i++) { 
						$n =  str_pad($i, 2, "0", STR_PAD_LEFT);
						$jodiTotal = 0;
						if((string)$n===(string)$result['jodi']){
							$hi = 'oRes';
						}else{
							$hi = '';
						}
						
						
						$newIndex = array_search($n, $ng);
						$jodiData = $allData[$newIndex];
						// print_r($newIndex);
						// print_r($n);
						// print_r($jodiData['id']);
						// die();
						
						if($newIndex === FALSE){
						// if($jodiData['id']==0){
							$sty = "color:ccc";
							$jodiTotal = "-";
							$Data = "-";
						} else {
							$sty = "color:red";
							$Data = $jodiData['id'];
							$jodiTotal = $jodiData['money'].".00";
						}
						echo $html = "<div class='jodi $hi'>
								<span class='game'>".$n."</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span>: ".$Data."</span><br>
								Amt : 
								<span class='amount' style='".$sty."'>".$jodiTotal."</span>
							</div>";
					}
					echo "<div class='col-md-12'>
							<div class='box bazarHeader'>
								<h3>
									TOTAL BET : ".$allGames['id']."
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									TOTAL AMOUNT : ".$allTotal.".00
								</h3>
							</div>
						</div>";

				/*----------------------------------------------------------------------------*/
				
				}
			?>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="form-group">
				    <div class="col-xs-12">
				        <div class="form-inline">
				            <div class="form-group">
				                <input type="text" class="form-control" id="transaction_id" placeholder="Search Transaction ID"/>
				            </div>
				            <div class="form-group">
				                <input type="text" class="form-control" id="partner_id" placeholder="Search Partner ID"/>
				            </div>
				            <div class="form-group">
				                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer ID"/>
				            </div>
				            <div class="form-group">
				                <input type="text" class="form-control" id="user_game" placeholder="Search Game"/>
				            </div>
				        </div>
				    </div>
				</div>

				<table id='userTable' class='display dataTable'>
				  <thead>
				    <tr>
				      <th>Sr.</th>
				      <th>Transaction ID</th>
				      <th>Partner ID</th>
				      <th>Customer ID</th>
				      <th>Bazar Name</th>
				      <th>Game Name</th>
				      <th>Game Type</th>
				      <th>Game</th>
				      <th>Point</th>
				      <th>Result Date</th>
				      <th>Status</th>
				      <th>Winning Point</th>
				      <th>Bet Time</th>
				    </tr>
				  </thead>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var i = 1;
		var userDataTable = $('#userTable').DataTable({
			
			"pageLength": 25,
			'order': [[7, 'asc']],
			'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>42f91b81db7ca9bfa8a6d411d64b248c',
	          'data': function(data){

	          		data.transaction_id = $('#transaction_id').val();
	          		data.partner_id = $('#partner_id').val();
	          		data.customer_id = $('#customer_id').val();
	          		data.game = $('#user_game').val();
	          		data.bazar_name = <?=$bazar?>;
	          		data.game_name = <?=$game?>;
	          		data.type = "<?=$type?>";
	          		data.result_date = "<?=date('Y-m-d').' - '.date('Y-m-d')?>";
	          }
	      	},
	      	'columns': [
	         	{ data: 'sr' },
	         	{ data: 'transaction_id' },
	         	{ data: 'partner_id' },
	         	{ data: 'customer_id' },
	         	{ data: 'bazar_name' },
	         	{ data: 'game_name' },
	         	{ data: 'game_type' },
	         	{ data: 'game' },
	         	{ data: 'point' },
	         	{ data: 'result_date' },
	         	{ data: 'status' },
	         	{ data: 'winning_point' },
	         	{ data: 'created' },
	         		
	      	]
	   	});

	   	$('#transaction_id,#partner_id,#customer_id,#user_game').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
</script>