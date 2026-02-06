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
	      	<div>
				<h1>
					<i class="fa fa-users"></i> Red Table Winner List
					<small></small>
				</h1>
		  	</div>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	 
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-md-3">
                            <div class="form-group">
                                <label for="daterange">Date</label>
                                <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                                <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                            </div>
					    </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class='btn btn-success' id='searchDate'>Search</button>
                            </div>
                        </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <!-- <th>Sr.</th> -->
					      <th>Bet Amount</th>
					      <th>Winning Amount</th>
					      <th>PNL</th>
					      <th>Name</th>
					      <th>Mobile</th>
                          <th>State</th>
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
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>242e20696e8ccf521304bafa25deba4e',
	          'data': function(data){
	          		data.dateRange = $('#dateRange').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'bet_amount' },
	         	{ data: 'winning_point' },
	         	{ data: 'pnl' },
	         	{ data: 'name' },
	         	{ data: 'mobile' },
	         	{ data: 'state' },
	         	// { data: 'status','render':function(data, type, row, meta){
	         	// 	return '<span class="'+row.id+'">'+row.status+'</span>';
	         	// }},
	         	
	      	]
	   	});

	   	$('#searchDate').click(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
</script>