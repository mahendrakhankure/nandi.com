<?php 
    include 'includes/header.php'; 
?>
	<style type="text/css">
		#userTable_wrapper{
			text-align: center;
		}
	</style>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        <i class="fa fa-users"></i> Blue Table Bazar Games
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
					                <input type="text" class="form-control" id="round_id" placeholder="Search Round ID"/>
					            </div>
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
					                <input type="date" class="form-control" id="result_date" placeholder="Search Result Date"/>
					            </div>
					            <div class="form-group">
					                <input type="rext" class="form-control" id="round_id" placeholder="Search Rount Id"/>
					            </div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
						  <th>Round ID</th>
					      <th>Transaction ID</th>
					      <th>Partner ID</th>
					      <th>Customer ID</th>
					      <!-- <th>Game Name</th> -->
					      <th>Game</th>
					      <th>Point</th>
					      <th>Result Date</th>
					      <th>Status</th>
					      <th>Winning Point</th>
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
<script type="text/javascript">
	$(document).ready(function(){
	   	var userDataTable = $('#userTable').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	'pageLength':25,
			'order': [[7, 'desc']],
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>485e3801e1b7984fedba6173dad08c3b',
	          'data': function(data){
	          		data.transaction_id = $('#transaction_id').val();
	          		data.partner_id = $('#partner_id').val();
	          		data.customer_id = $('#customer_id').val();
	          		data.game_name = $('#game_name').val();
	          		data.result_date = $('#result_date').val();
	          		data.result_date = $('#result_date').val();
	          		data.round_id = $('#round_id').val();
	          }
	      	},
	      	'columns': [
	      		{ data: 'id' ,render: function (data, type, row, meta) {
			        return row.sr;
			    }},
				{ data: 'round_id' },
				
	         	{ data: 'transaction_id' },
	         	{ data: 'partner_id' },
	         	{ data: 'customer_id' },
	         	// { data: 'game_name' },
	         	{ data: 'game' },
	         	{ data: 'point' },
	         	{ data: 'result_date' },
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span id="'+row.transaction_id+'">'+row.status+'</span>';
	         	} },
	         	{ data: 'winning_point' },
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

	   	$('#transaction_id,#partner_id,#customer_id,#bazar_name,#game_name,#result_date,#round_id').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
	function voidBet(id){
   		$.ajax({
            type: "POST",
            url: base_url+"/dc7b83839eaf36e8dd2380106538fdc6",
            data: {table:'redTable_users_game',data:[{transaction_id:id}]},
			// data: {table:'redTable_users_game',transaction_id:id},
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