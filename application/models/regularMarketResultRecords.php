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
					<i class="fa fa-users"></i> Manage Regular Bazar Result
					<small></small>
				</h1>
		  	</div>
		    <div class="form-group add-button">
	            <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Matkaallgames/AddAllGameResult"><i class="fa fa-plus"></i> Add Result</a>
	    	</div>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	 
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					        	<div class="form-group">
					            	<input type="text" class="form-control" placeholder="Search Open Token" id="token_open" name="token_open" >
					            </div>
					            <div class="form-group">
					            	<input type="text" class="form-control" placeholder="Search Close Token" id="token_close" name="token_close" >
					            </div>
					            <div class="form-group">
					            	<input type="date" class="form-control" placeholder="Select Date" id="bazarDate" name="bazarDate" >
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
					      <th>Sr.</th>
					      <th>Open Token</th>
					      <th>Close Token</th>
					      <th>Bazar Name</th>
					      <th>Open</th>
					      <th>Jodi</th>
					      <th>Close</th>
					      <th>Result Date</th>
					      <th>Status</th>
					      <th>Open Win</th>
					      <th>Close Win</th>
					      <th>Action</th>
					      <th>Void</th>
					      <th>RollBack</th>
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
	      	'order': [[7, 'desc']],
	      	'pageLength':25,
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>0c57f9f166bd090aa1e47fae7ee93a96',
	          'data': function(data){
	          		data.status = $('#status').val();
	          		data.bazarDate = $('#bazarDate').val();
	          		data.bazar_name = $('#bazar_name').val();
	          		data.token_close = $('#token_close').val();
	          		data.token_open = $('#token_open').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'sr' },
	         	{ data: 'token_open' },
	         	{ data: 'token_close' },
	         	{ data: 'bazar_name' },
	         	{ data: 'open' },
	         	{ data: 'jodi' },
	         	{ data: 'close' },
	         	{ data: 'result_date' },
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span class="'+row.id+'">'+row.status+'</span>';
	         	}},
	         	{ data: 'openWin'},
	         	{ data: 'closeWin'},
	         	
	         	{ data: 'action','render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Matkaallgames/AddAllGameResult/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i>';
	         	} },

	         	{ data: 'void','render':function(data, type, row, meta){
	         		if(row.status=='A'){
	         			return '<span id="'+row.id+'1" onclick="voidBet('+row.id+')" class="btn btn-danger"><i class="fa fa-check">Void</i></span>';
	         		}else{
	         			return '';
	         		}
	         	}},

	         	{ data: 'rollback','render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>fa3f22e952b82786ee43dedb66969556/'+row.id+'" title="Edit"><i class="fa fa-times"></i>';
	         	} },
	         	
	      	]
	   	});

	   	$('#status,#customer_id,#bazar_name,#bazarDate,#token_open,#token_close').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
</script>
<script type="text/javascript">

	function voidBet(id){
		var con = prompt("Please enter Open/Close:", "");
		var v = 0;
		if(con=='Open' || con=='open'){
			v=1;
		}else if(con=='Close' || con=='close'){
			v=1;
		}else if(con=='Both' || con=='both'){
			v=1;
		}else{
			console.log('do nothing')
		}
		if(v==1){
	   		$.ajax({
	            type: "POST",
	            url: base_url+"/dc7b83839eaf36e8dd2380106538fdc6",
	            data: {table:'regular_bazar_games',bazar_id:id,market:'regular_bazar_games',marketType:con},
	            success: function (res) {
	            	console.log(res)
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
   	}
</script>