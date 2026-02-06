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
					<i class="fa fa-users"></i> Blue Table Bazar Result
					<small></small>
				</h1>
		  	</div>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	 
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					            <div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="status">
						            	<option value=''>Search Status</option>
						            	<option value='A'>A</option>
						            	<option value='I'>I</option>
						            	<option value='V'>V</option>
									</select>
					            </div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <!-- <th>Sr.</th> -->
					      <th>gameId</th>
					      <th>result_date</th>
					      <th>patti_result</th>
					      <th>akda_result</th>
					      <th>Status</th>
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
	          'url':'<?=base_url()?>e4d81e8a2e862b27b97d6e93c5878c54',
	          'data': function(data){
	          		data.status = $('#status').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'gameId' },
	         	{ data: 'result_date' },
	         	{ data: 'patti_result' },
	         	{ data: 'akda_result' },
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span class="'+row.id+'">'+row.status+'</span>';
	         	}},
	         	
	      	]
	   	});

	   	$('#status,#customer_id').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
</script>