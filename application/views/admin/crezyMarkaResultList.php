<?php 
    include 'includes/header.php'; 
?>
<style>
    tr th {text-align:center;}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div>
        <h1>
            <i class="fa fa-users"></i> Crezy Matka Result List
            <small></small>
        </h1>
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" aria-label="Default select example" id="status">
                                    <option value=''>Select Status</option>
                                    <option value='A'>Active</option>
                                    <option value='I'>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="round_id" placeholder="Search Round Id"/>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="result_date" placeholder="Search Result Date"/>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Round Id</th>
                      <th>Result Date</th>
                      <th>Akda</th>
                      <th>Status</th>
                      <th>Bhav</th>
                      <th>Total Player</th>
                      <th>Total Bet</th>
                      <th>Total Point</th>
                      <th>Total Win</th>
                      <th>Total Com</th>
                      <th>GGR</th>
                      <th>Updated</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        var i = 1;
        var userDataTable = $('#userTable').DataTable({
            "pageLength": 25,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'order': [[12, 'desc']],
            'lengthMenu': [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>65d1bb984c381c800f07280f66bd67dc',
              'data': function(data){

                    data.round_id = $('#round_id').val();
                    data.result_date = $('#result_date').val();
                    data.status = $('#status').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
	         	}},
                { data: 'round_id' },
                { data: 'result_date' },
                { data: 'akda','render':function(data, type, row, meta){
                    if(row.akda==10){
                        var ak = 'Red&Black';
                    }else if(row.akda==11){
                        var ak = 'Crazy Wheel';
                    }else{
                        var ak = row.akda;
                    }
                    return ak;
	         	}},
                { data: 'status' },
                { data: 'bhav' },
                { data: 'totalPlayer' },
                { data: 'totalBet' },
                { data: 'betPoint' },
                { data: 'totalWin' },
                { data: 'totalCom' },
                { data: 'akda','render':function(data, type, row, meta){
                    return ((parseFloat(row.betPoint)-parseFloat(row.totalWin))+parseFloat(row.totalCom)).toFixed(2);
	         	},createdCell: function(td, cellData, rowData, row, col) {
                    var ggr = ((parseFloat(rowData.betPoint)-parseFloat(rowData.totalWin))+parseFloat(rowData.totalCom));
                    // console.log(rowData)
                    if(ggr < 0){
                        td.style.backgroundColor = 'red';
                        td.style.color = 'white';
                    }else if(ggr > 0){
                        td.style.backgroundColor = 'green';
                        td.style.color = 'white';
                    }
                }},
                { data: 'updated' },
                    
            ]
        });

        $('#round_id,#result_date,#status').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>