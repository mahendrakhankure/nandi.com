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
	                    <a class="btn btn-primary" href="<?php echo base_url(); ?>762a1c6be55b9a89fceffe61a6666aa3/"><i class="fa fa-plus"></i> Add Market Holidays</a>
	                </div>
	            </div>
	        	<div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					            <div class="form-group">
					            </div>
					             
                                <div class="form-group">
					                <input type="text" class="form-control" id="massage" placeholder="Message"/>
					            </div>
                                <div class="form-group">
					                <input type="text" class="form-control" id="market_type" placeholder="Market Type"/>
					            </div>
                                <div class="form-group">
					                <input type="text" class="form-control" id="bazar_name" placeholder="Bazar Name"/>
					            </div>
                                <div class="form-group">
					                <input type="date" class="form-control" id="date" placeholder="Select Date"/>
					            </div>
                                 
					        	 
					        </div>
					    </div>
					</div>

					<table id='mktHoliday' class='display dataTable'>
					  <thead>
					    <tr>
					      <th>Sr.</th>
					      <th>Message</th>
                          <th>Market Type</th>
					      <th>Bazar Name</th>
					      <th>Date</th>
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
	   	var mktHoliday = $('#mktHoliday').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	// 'searching': true, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>b045f201f68498c76b8fae94c1081e3d',
	          'data': function(data){
	          		data.massage = $('#massage').val();
                    data.market_type = $('#market_type').val();
	          		data.bazar_name = $('#bazar_name').val();
                    data.date = $('#date').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'id',render: function (data, type, row, meta) {
                        return row.sr;
                } },
	         	{ data: 'massage' },
	         	{ data: 'market_type' },
                { data: 'bazar_name' },
	         	{ data: 'date' },
				 { data: 'action','render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>762a1c6be55b9a89fceffe61a6666aa3/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i>';
	         	} },
	      	]
	   	});

	   	$('#massage,#market_type,#bazar_name,#date').change(function(){
            mktHoliday.draw();
	   	});
	   	$('#mktHoliday_filter').hide();

	});
</script>