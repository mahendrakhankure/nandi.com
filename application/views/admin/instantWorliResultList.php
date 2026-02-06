<?php 
    include 'includes/header.php'; 
?>
	<style type="text/css">
		#userTable_wrapper{
			text-align: center;
		}
		.ggr-column .profit{
			background:green;color:#fff;
			padding: 5px 20px;
			border-radius: 15px;
		}
		.ggr-column .loss{
			background:red;
			color:#fff;
			padding: 5px 20px;
			border-radius: 15px;
		}
		.bet,.win,.ggr{
			text-align:right;
			color:#fff;
			margin: 0 -10px;
			padding-right: 100px;
			font-size: large;
		}
		.bet{
			background:green;
		}
		.win{
			background:red;
		}
		.ggr{
			background:orange;
		}
	</style>
	<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	    <section class="content-header">
	      	<div>
				<h1>
					<i class="fa fa-users"></i> Manage Worli Bazar Result
					<small></small>
				</h1>
		  	</div>
	    </section>
	    <section class="content">
	        <div class="rows">
				<div class="col-12">
					<div class="col-8"></div>
					<div class="col-4">
						<p class="bet">Betting Points => <span id="totalAmt"></span></p>
						<p class="win">Winning Points => <span id="totalWin"></span></p>
						<p class="ggr">GGR => <span id="GGR"></span></p>
					</div>
				</div>
	            <div class="col-12">
					<div class="form-group">
					    <div class="col-xs-12">
					        <div class="form-inline">
					        	<div class="form-group">
					                <input type="date" class="form-control" id="result_date" placeholder="Search Result Date"/>
					            </div>
					            <div class="form-group">
					                <input type="rext" class="form-control" id="game_id" placeholder="Search Rount Id"/>
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
					      <th>Round Id</th>
					      <th>result_date</th>
					      <th>patti_result</th>
					      <th>akda_result</th>
						  <th>Point</th>
						  <th>Win</th>
						  <th>GGR</th>
					      <th>Status</th>
					    </tr>
					  </thead>
					</table>
				</div>
	        </div>
    	</section>
		<section>
			<div class="container">
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog" style="width:1250px;">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body">
							
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    </div>
<?php include 'includes/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		var sumAmt = 0;
		var sumWin = 0;
	   	var userDataTable = $('#userTable').DataTable({
			"columnDefs": [
				{
					targets:-2,
					className:'ggr-column'
				}
			],
			"lengthMenu": [[10, 25, 50, 100, 200, 500], [10, 25, 50, 100, 200, 500]],
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	'pageLength':25,
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>34642c7cc851bdfd6834b7940e59026e',
	          'data': function(data){
					sumAmt = 0;
					sumWin = 0;
	          		data.status = $('#status').val();
	          		data.result_date = $('#result_date').val();
	          		data.game_id = $('#game_id').val();
	          }
	      	},
			"fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
				$('#totalAmt').empty();
				$('#totalWin').empty();
				$('#GGR').empty();
				sumAmt += parseFloat(aData.amt);
				sumWin += parseFloat(aData.win);
				$('#totalAmt').append(sumAmt);
				$('#totalWin').append(sumWin);
				$('#GGR').append(sumAmt-sumWin);
                return nRow;
            },
	      	'columns': [
	      		{ data: 'id','render':function(data, type, row, meta){
	         		return row.sr;
	         	}},
	         	{ data: 'gameId' },
	         	{ data: 'result_date' },
	         	{ data: 'patti_result' },
	         	{ data: 'akda_result' },
				{ data: 'amt' },
	         	{ data: 'win','render':function(data, type, row, meta){
	         		// return Math.round(row.win);
					 return row.win;
	         	} },
				 { data: 'status','render':function(data, type, row, meta){
					var ggr = Math.round(parseFloat(row.amt))-Math.round(parseFloat(row.win));
					if(ggr>0){
						var st = '<button data-toggle="modal" data-target="#myModal" class="profit" onclick="checkBets('+row.gameId+')" id="'+row.gameId+'">'+ggr+'</button>';
					}else{
						var st = '<button data-toggle="modal" data-target="#myModal" class="loss" onclick="checkBets('+row.gameId+')" id="'+row.gameId+'">'+ggr+'</button>';
					}
	         		return st;
	         	}},
	         	{ data: 'status','render':function(data, type, row, meta){
	         		return '<span class="'+row.id+'">'+row.status+'</span>';
	         	}},
	      	],
			// "footerCallback": function (row, data, start, end, display) {
				// var api = this.api();
				// let sum = api.column(6).data().sum();
				// $(api.column(6).footer()).html(sum);
				// var api = this.api();
				// $(api.table().footer()).html(
				// 	api.column(6, { page: 'current' }).data().sum()
				// );
			// }
	   	});

	   	$('#status,#result_date,#game_id').change(function(){
			sumAmt = 0;
			sumWin = 0;
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

	function checkBets(id){
		$.ajax({
			type: "POST",
			url: base_url+"/1b7688d1678b1a77de4951b40301b4b4",
			data: {id:id,market:'worli'},
			success: function (res) {
				var data = jQuery.parseJSON(res);
				$('.modal-body').empty();
				if(data!=''){
					var dome = '<table class="table table-bordered red-border text-center"><thead><tr><th>Sr.</th><th>Transaction Id</th><th>Partner Id</th><th>Customer Id</th><th>Game</th><th>Point</th><th>Win</th><th>Commission</th><th>Status</th></tr></thead><tbody>';
					$.each(data, function(i, item) {
						dome += '<tr><th scope="row">'+i+'</th><td>'+data[i].transaction_id+'</td><td>'+data[i].partner_id+'</td><td>'+data[i].customer_id+'</td><td>'+data[i].game+'</td><td>'+data[i].point+'</td><td>'+data[i].winning_point+'</td><td>'+data[i].commission+'</td><td>'+data[i].status+'</td></tr>';
					});     
					dome += '</tbody></table>';
					$('.modal-body').append(dome);
					
					// $("#listOfRound").click();
				}else{
					error(data.message);
				}
			}
		});
	}
</script>