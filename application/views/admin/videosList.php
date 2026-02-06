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
				<i class="fa fa-users"></i> Manage Video List
				<small></small>
			</h1>
		  </div>
		  <div class="form-group add-button">
	            <a class="btn btn-primary" href="<?php echo base_url(); ?>46f866085c79443c31667d1ad3b700e5/0"><i class="fa fa-plus"></i> Add Video</a>
	      </div>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	 
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					        	<div class="form-group">
					            	<input type="text" class="form-control" placeholder="Search Patti" id="patti" name="patti" >
					            </div>
					            <div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="status">
						            	<option value=''>Search Status</option>
						            	<option value='A'>A</option>
						            	<option value='I'>I</option>
									</select>
					            </div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
					      <th>Patti</th>
					      <th>Status</th>
					      <th>Video</th>
					      <th>Updated</th>
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
	      	"pageLength": 25,
	      	'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>0571b3cbce86ae08dc5ba2b744302e53',
	          'data': function(data){
	          		data.status = $('#status').val();
	          		data.patti = $('#patti').val();
	          }
	      	},
	      	'columns': [
	      		{ data: 'id','render':function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
	         	}},
	         	{ data: 'patti' },
	         	// { data: 'status' },
                 { data: 'dealer' ,'render':function(data, type, row, meta){
                    var a = '';
                    var i = '';
                    if(row.status=="I"){
                        i = 'selected';
                    }
                    if(row.status=="A"){
                        a = 'selected';
                    }
                    return '<select class="form-control" onchange="statusUpdate(this.value,'+row.id+')"><option value="A" '+a+'>A</option><option value="I" '+i+'>I</option></select>';
	         		
	         	}},
	         	{ data: 'dealer' ,'render':function(data, type, row, meta){
                    return '<video width="320" height="240" controls><source src="'+row.dealer+'" type="video/mp4"></video>';
	         		
	         	}},
	         	{ data: 'updated' },
	         	{ data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="javascript:void(0)" onclick="deleteR('+row.id+')" title="Edit"><i class="fa fa-trash"></i></a>';
	         		
	         	}},
	      	]
	   	});

	   	$('#status,#patti').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();
	});

    function statusUpdate(s,i){
        $.ajax({
            type: "POST",
            url: base_url+"/dde26be899f802be450a5333939d150b",
            data: {id:i,status:s},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                if(data['status']==200){
                    success(data['message']);
                }else{
                    error(data['message']);
                }
            }
        });
    }

    function deleteR(i){
        if (confirm("Do you realy want to delete this record.") == true) {
            $.ajax({
                type: "POST",
                url: base_url+"/d4d107db39c79a35092a88ac6a4c47f2",
                data: {id:i},
                success: function (res) {
                    var data = jQuery.parseJSON(res);
                    if(data['status']==200){
                        success(data['message']);
                        location.reload();
                    }else{
                        error(data['message']);
                    }
                }
            });
        }
    }
</script>