<?php 
    include 'includes/header.php'; 
?>
	<style type="text/css">
		table{
			text-align: center;
		}
		table thead tr th{
			text-align: center;
		}
	</style>
	<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        <!-- <i class="fa fa-users"></i> Manage Customer Rate -->
	        <small></small>
	      </h1>
	    </section>
	    <section class="content">
	        <div class="rows">
	        	<div class="col-12 text-left">
	                <div class="form-group">
	                    <a class="btn btn-primary" href="<?php echo base_url(); ?>762a1c6be55b9a89fceffe61a6666aa2"><i class="fa fa-plus"></i> Add Customer Bhav</a>
	                </div>
	            </div>
	        	<div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					            <div class="form-group">
					            	<!-- <input type="text" class="form-control" id="partner_id" placeholder="Search Partner ID"/> -->
					                <!-- <select class="form-control" id="partner_id" name="partner_id" placeholder="Select Partner">
					                	<option value="">Select Partner</option>
                                        <?php foreach ($client as $cl) { ?>
                                            <option value="<?php echo $cl['id']; ?>"><?= $cl['client_name'];?></option>
                                        <?php } ?>    
                                    </select> -->
					            </div>
					            <div class="form-group">
					                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer ID"/>
					            </div>
					        	<div class="form-group">
					                <select class="form-control" aria-label="Default select example" id="status">
						            	<option value=''>Search Status</option>
						            	<option value='A'>Active</option>
						            	<option value='I'>Inactive</option>
									</select>
					            </div>
					        </div>
					    </div>
					</div>

					<table id='userTable' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
					      <th>Partner Name</th>
					      <th>Customer ID</th>
					      <th>Customer Name</th>
					      <th>Customer Mobile</th>
					      <th>Deducted Rate In %</th>
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
		var i = 1;
	   	var userDataTable = $('#userTable').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>b045f201f68498c76b8fae94c1081e2d',
	          'data': function(data){
	          		data.partner_id = $('#partner_id').val();
	          		data.customer_id = $('#customer_id').val();
	          		data.status = $('#status').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'id',render: function (data, type, row, meta) {
                        return row.sr;
                } },
	         	{ data: 'username' },
	         	{ data: 'customer_id' },
	         	{ data: 'name' },
	         	{ data: 'mobile' },
	         	{ data: 'rate','render':function(data, type, row, meta){
                    return '<input type="text" name="bhav" onchange="setBhav('+row.id+',this.value)" value="'+row.rate+'" onkeypress="return isNumber(event)" maxlength="5" />';
                } },
	         	// { data: 'rate' },
	         	{ data: 'status' },
	         	
	      	]
	   	});

	   	$('#partner_id,#customer_id,#status').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#userTable_filter').hide();

	});

	function setBhav(id,val){
        if(confirm("Do You Realy Want To Change The Bhav")){
            $.ajax({
                type:"post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>22d990b4b5ec7daecccce10725ac9db3",
                data:{id:id,bhav:val},
                success:function(re){ 
                    if (re['status'] == '200') {
                        alert(re['massage']);
                        console.log(re['massage'])
                    }else{
                        alert(re['massage']);
                        console.log(re['massage'])
                    }
                }
            });
        }
    }
</script>