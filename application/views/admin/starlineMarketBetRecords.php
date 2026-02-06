<?php 
    include 'includes/header.php'; 
?>
	<style type="text/css">
		#userTable_wrapper{
			text-align: center;
		}
	</style>
	<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        <i class="fa fa-users"></i> Manage Starline Bazar Games
	        <small></small>
	      </h1>
	    </section>
	    <section class="content">
	        <div class="rows">
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					            <div class="form-group">
					                <input type="text" class="form-control" id="transaction_id" placeholder="Search Transaction ID"/>
					            </div>
					            <!-- <div class="form-group">
					                <input type="text" class="form-control" id="partner_id" placeholder="Search Partner ID"/>
					            </div> -->
								<div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="partner_id">
						            	<option value=''>Search Partner Name</option>
						            	<?php
						            		foreach ($clientAll as $b) {
						            			echo '<option value="'.$b['id'].'">'.$b['client_name'].'</option>';
						            		}
						            	?>
									</select>
					            </div>
					            <div class="form-group">
					                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer ID"/>
					            </div>
					            <!-- <div class="form-group">
					                <input type="date" class="form-control" id="result_date" placeholder="Search Result Date"/>
					            </div> -->
								<div class="form-group">
									<input type="text" class="form-control daterange" name="dateRange" id="result_date" placeholder="Enter Date's" />
								</div>
					            <div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="bazar_name">
						            	<option value=''>Search Bazar Name</option>
						            	<?php
						            		foreach ($bazarAll as $b) {
						            			echo '<option value="'.$b['id'].'">'.$b['bazar_name'].'</option>';
						            		}
						            	?>
									</select>
					            </div>
					            <div class="form-group">
						            <select class="form-control" aria-label="Default select example" id="game_name">
						            	<option value=''>Search Game Name</option>
						            	<?php
						            		foreach ($gamesAll as $b) {
						            			echo '<option value="'.$b['id'].'">'.$b['game_name'].'</option>';
						            		}
						            	?>
									</select>
					        	</div>
					        	<div class="form-group">
						            <select class="form-control" aria-label="Default select example" id="game_time">
						            	<option value=''>Search Time</option>
						            	<?php
						            		foreach ($timeAll as $b) {
						            			echo '<option value="'.$b['id'].'">'.$b['time'].'</option>';
						            		}
						            	?>
									</select>
					        	</div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
					      <th>Transaction ID</th>
					      <th>Partner Name</th>
					      <th>Customer ID</th>
					      <th>Bazar Name</th>
					      <th>Game Name</th>
					      <th>Time</th>
					      <th>Game</th>
					      <th>Point</th>
					      <th>Point in INR</th>
					      <th>Result Date</th>
					      <th>Status</th>
					      <th>Winning Point</th>
					      <th>Winning Point in INR</th>
					      <th>Currency Code</th>
					      <th>Exchange Rate</th>
					      <th>Bet Time</th>
					      <th>Action</th>
					    </tr>
					  </thead>
					</table>
				</div>
	        </div>
    	</section>
    </div>
<?php include 'includes/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var i = 1;
	   	var userDataTable = $('#userTable').DataTable({
	   		"pageLength": 25,
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>0b7b0e682049a1de334771eda98ad759',
	          'data': function(data){
	          		data.transaction_id = $('#transaction_id').val();
	          		data.partner_id = $('#partner_id').val();
	          		data.customer_id = $('#customer_id').val();
	          		data.bazar_name = $('#bazar_name').val();
	          		data.game_name = $('#game_name').val();
	          		data.game_time = $('#game_time').val();
	          		data.result_date = $('#result_date').val();
	          }
	      	},
	      	'columns': [
	      		{ data: 'transaction_id',render: function (data, type, row, meta) {
			            return row.sr;
			       } },
	         	{ data: 'transaction_id' },
	         	//{ data: 'partner_id' },
				 { data: 'partner_name' },
	         	{ data: 'customer_id' },
	         	{ data: 'bazar_name' },
	         	{ data: 'game_name' },
	         	{ data: 'time' },
	         	{ data: 'game' },
	         	{ data: 'point' },
	         	{ data: 'point_in_rs' },
	         	{ data: 'result_date' },
	         	{ data: 'status' },
	         	{ data: 'winning_point' },
	         	{ data: 'winning_in_rs' },
	         	{ data: 'currency_code' },
	         	{ data: 'exchange_rate' },
	         	{ data: 'created' },
	         	{ data: 'action','render':function(data, type, row, meta){
	         		if(row.status!='V'){
	         			return '<span id="'+row.transaction_id+'1" onclick="voidBet(\''+row.transaction_id+'\')" class="btn btn-danger"><i class="fa fa-check">Void</i></span>';
	         		}else{
	         			return '--';
	         		}
	         	} },
	      	]
	   	});

	   	$('#transaction_id,#partner_id,#customer_id,#bazar_name,#game_name,#game_time,#result_date').change(function(){
	   		userDataTable.draw();
	   	});
		function sleep(ms) {
			return new Promise(resolve => setTimeout(resolve, ms || 10000));
		}
		$('.applyBtn').click(function(){
			(async()=>{
				await sleep(100);
				userDataTable.draw()
			})();
	   	});
	   	$('#userTable_filter').hide();
	});
	function voidBet(id){
   		$.ajax({
            type: "POST",
            url: base_url+"/dc7b83839eaf36e8dd2380106538fdc6",
            data: {table:'starline_bazar_game',data:[{transaction_id:id}]},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if(data['status']==200){
                    success(data['message']);
                    $('td #'+id).text('V');
                    $('#'+id+'1').hide();
                }else{
                    error(data['message']);
                }
            }
        });
   	}
</script>