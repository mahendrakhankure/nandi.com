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
	        <i class="fa fa-users"></i> Manage Regular Bazar Games
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
					                <input type="date" class="form-control" id="result_date" placeholder="Search Result Date" value="<?=date('Y-m-d');?>"/>
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
					                <select class="form-control" aria-label="Default select example" id="status">
						            	<option value=''>Search Status</option>
						            	<option value='P'>Pending</option>
										<option value='W'>Win</option>
										<option value='L'>Loss</option>
										<option value='V'>Void</option>
									</select>
					            </div>
								<div class="form-group">
					                <input type="number" class="form-control" id="risk" placeholder="Search Risk"/>
					            </div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
						  <th id='c'><input type="checkbox" name="check" id="checkAll"></th>
					      <th>Sr.</th>
					      <th>Transaction ID</th>
					      <th>Partner Name</th>
					      <th>Customer ID</th>
					      <th>Bazar Name</th>
					      <th>Game Name</th>
					      <th>Game Type</th>
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
	   	var userDataTable = $('#userTable').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	'order': [[11, 'desc']],
			// 'columnDefs': [
			// 	{
			// 		'targets': [10],
			// 		'orderData': [0, 1]
			// 	},
			// 	{
			// 		'targets': [9],
			// 		'orderData': [0, 1]
			// 	}
			// ],
	      	'pageLength':25,
	      	'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>42f91b81db7ca9bfa8a6d411d64b248c',
	          'data': function(data){
	          		data.transaction_id = $('#transaction_id').val();
	          		data.partner_id = $('#partner_id').val();
	          		data.customer_id = $('#customer_id').val();
	          		data.bazar_name = $('#bazar_name').val();
	          		data.game_name = $('#game_name').val();
	          		data.result_date = $('#result_date').val();
	          		data.status = $('#status').val();
	          		data.risk = $('#risk').val();
	          }
	      	},
	      	'columns': [
				{ data: 'id','render':function(data, type, row, meta){
	         		return '<input type="checkbox" name="id[]" value="' + row.id + '">';
	         	}, orderable: false },
	      		{ data: 'sr' },
	         	{ data: 'transaction_id' },
	         	//{ data: 'partner_id' },
				
	         	{ data: 'partner_name' },
	         	{ data: 'customer_id' },
	         	{ data: 'bazar_name' },
	         	{ data: 'game_name' },
	         	{ data: 'game_type' },
	         	{ data: 'game' },
	         	{ data: 'point' },
	         	{ data: 'point_in_rs' },
	         	{ data: 'result_date' },
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span id="'+row.transaction_id+'">'+row.status+'</span>';
	         	} },
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

	   	$('#transaction_id,#partner_id,#customer_id,#bazar_name,#game_name,#result_date,#status,#risk').change(function(){
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
            data: {table:'regular_bazar_games',data:[{transaction_id:id}]},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if(data.status=='200'){
                    success(data.message);
                    $('td #'+id).text('V');
                    $('#'+id+'1').hide();
                }else{
                    error(data.message);
                }
            }
        });
   	}

	   $("#checkAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});
	$("#voidAll").click(function(){
		var checked = document.querySelectorAll(':checked');
		var res = Array.from(checked).map(c => c.value).join(',');
		var k = 0;
		var stuff = [];
		$.each(Array.from(checked).map(c => c.value), function (key, val) {
			if(k!= 0 && k != 1){
				stuff.push({transaction_id:val});
			}
			k++;
		});
		$.ajax({
            type: "POST",
            url: base_url+"/dc7b83839eaf36e8dd2380106538fdc6",
            data: {table:'regular_bazar_games',data:[{transaction_id:id}]},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if(data.status=='200'){
                    success(data.message);
                    $('td #'+id).text('V');
                    $('#'+id+'1').hide();
                }else{
                    error(data.message);
                }
            }
        });
	});
</script>