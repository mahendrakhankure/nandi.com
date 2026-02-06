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
	        <i class="fa fa-users"></i> Last Change List
	        <small></small>
	      </h1>
	    </section>
	    <section class="content">
	        <div class="rows">
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-md-6">
					        <div class="form-inline">
					            <div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="ent">
						            	<option value=''>Search Table Name</option>
										<option value='Worli Buffer'>Worli Buffer</option>
										<option value='Regular Bazar Result'>Regular Bazar Result</option>
										<option value='Starline Bazar Result'>Starline Bazar Result</option>
										<option value='King Bazar Result'>King Bazar Result</option>
										<option value='Regular Bazar Bhav'>Regular Bazar Bhav</option>
										<option value='Starline Bazar Bhav'>Starline Bazar Bhav</option>
										<option value='King Bazar Bhav'>King Bazar Bhav</option>
										<option value='Instant Worli Bhav'>Instant Worli Bhav</option>
										<option value='Blu Table Bhav'>Blu Table Bhav</option>

										<option value='Customer Bhav'>Customer Bhav</option>
										<option value='Regular Bazar'>Regular Bazar Time</option>
									</select>
					            </div>
								<div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="emp">
						            	<option value=''>Support Name</option>
										<option value='1'>Admin</option>
										<option value='2'>Rahul</option>
										<option value='3'>Rock</option>
										<option value='4'>HT</option>
										<option value='5'>BA</option>
										<option value='6'>SH</option>
										<option value='7'>SA</option>
										<option value='10'>MU</option>
										<option value='11'>AB</option>
										<option value='12'>Taurus</option>
									</select>
					            </div>
					        </div>
					    </div>
						<div class="col-md-6">
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
					      <th>Table</th>
					      <th>Support Name</th>
					      <th>Detail</th>
					      <th>Created</th>
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
	      	'processing': true,
	      	'serverSide': true,
	      	'pageLength':25,
	      	'serverMethod': 'post',
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>0dd506e396bf18ea8798d354bb9acd6f',
	          'data': function(data){
	          		data.ent = $('#ent').val();
					data.emp = $('#emp').val();
	          }
	      	},
	      	'columns': [
	      		{ data: 'id',render: function (data, type, row, meta) {
			            return row.sr;
			       } },
	         	{ data: 'entry_table' },
	         	{ data: 'supportName' },
	         	{ data: 'detail' },
	         	{ data: 'created' },
	      	]
	   	});

	   	$('#ent,#emp').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();
	});
</script>