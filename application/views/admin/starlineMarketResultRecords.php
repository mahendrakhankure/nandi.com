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
				<i class="fa fa-users"></i> Manage Starline Bazar Result
				<small></small>
			</h1>
		  </div>
		  <div class="form-group add-button">
	            <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Starlinegameallresult/AddStartLineResult"><i class="fa fa-plus"></i> Add Result</a>
	      </div>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	 
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					        	<div class="form-group">
					            	<input type="text" class="form-control" placeholder="Search Token" id="token" name="token" >
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
					      <th>Token</th>
					      <th>Bazar Name</th>
					      <th>Time</th>
					      <th>Result Date</th>
					      <th>Patti</th>
					      <th>Akda</th>
					      <th>Status</th>
					      <th>Winners</th>
					      <th>Void</th>
					      <th>Action</th>
					      <th>Rollback</th>
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
	      	'order': [[4, 'desc']],
	      	'pageLength':25,
	      	'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>0fead7315f135c6b3d8f6846e3324c15',
	          'data': function(data){
	          		data.status = $('#status').val();
	          		data.bazarDate = $('#bazarDate').val();
	          		data.bazar_name = $('#bazar_name').val();
	          		data.token = $('#token').val();
	          }
	      	},
	      	'columns': [
	      		
	         	{ data: 'sr' },
	         	{ data: 'token' },
	         	{ data: 'bazar_name' },
	         	{ data: 'time' },
	         	{ data: 'result_date' },
	         	{ data: 'patti' },
	         	{ data: 'akda' },
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span class="'+row.id+'">'+row.status+'</span>';
	         	}},
	         	{ data: 'openWin'},
	         	{ data: 'void','render':function(data, type, row, meta){
	         		if(row.status=='A'){
	         			return '<span id="'+row.id+'1" onclick="voidBet('+row.id+')" class="btn btn-danger"><i class="fa fa-check">Void</i></span>';
	         		}else{
	         			return '';
	         		}
	         	}},
	         	{ data: 'action' ,'render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Starlinegameallresult/AddStartLineResult/'+row.result_id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
	         		
	         	}},
	         	{ data: 'rollback' ,'render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>e7c0c0ac654bb6980952235a04ffe26e/'+row.result_id+'" title="Edit"><i class="fa fa-times"></i></a>';
	         		
	         	}},
	         	
	      	]
	   	});

	   	$('#status,#customer_id,#bazar_name,#bazarDate,#token').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});
</script>
<script type="text/javascript">

	function voidBet(id){
		if(confirm('Do You Want To Void This?')){
	   		$.ajax({
	            type: "POST",
	            url: base_url+"/dc7b83839eaf36e8dd2380106538fdc6",
	            data: {table:'starline_bazar_game',bazar_id:id,market:'starline_bazar_game'},
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