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
            <i class="fa fa-users"></i> Crezy Matka Game List
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
                                <select class="form-control" aria-label="Default select example" id="partner_id">
                                    <option value=''>Select Partner</option>
                                    <?php
                                        foreach($client as $c){
                                            echo "<option value='".$c['id']."'>".$c['client_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" aria-label="Default select example" id="status">
                                    <option value=''>Select Status</option>
                                    <option value='P'>Pending</option>
                                    <option value='W'>Win</option>
                                    <option value='L'>Loss</option>
                                    <option value='V'>Void</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="transaction_id" placeholder="Search Transaction Id"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="round_id" placeholder="Search Round Id"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer Id"/>
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
                      <th>Partner Id</th>
                      <th>Customer Id</th>
                      <th>Customer Name</th>
                      <th>Transaction Id</th>
                      <th>Round Id</th>
                      <th>Result Date</th>
                      <th>Game</th>
                      <th>Status</th>
                      <th>Point</th>
                      <th>Bhav</th>
                      <th>Winning</th>
                      <th>Commission</th>
                      <th>Currency Code</th>
                      <th>Exchange Rate</th>
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
            'order': [[15, 'desc']],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>47c153ee854c6720c1b154ef62c3f6e7',
              'data': function(data){

                    data.round_id = $('#round_id').val();
                    data.result_date = $('#result_date').val();
                    data.status = $('#status').val();
                    data.partner_id = $('#partner_id').val();
                    data.customer_id = $('#customer_id').val();
                    data.transaction_id = $('#transaction_id').val();
                    
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
	         	}},
                { data: 'partner_id' },
                { data: 'customer_id' },
                { data: 'customerName' },
                { data: 'transaction_id' },
                { data: 'round_id' },
                { data: 'result_date' },
                { data: 'game','render':function(data, type, row, meta){
                    if(row.game==10){
                        var ak = 'Red&Black';
                    }else if(row.game==11){
                        var ak = 'Crazy Wheel';
                    }else{
                        var ak = row.game;
                    }
                    return ak;
	         	}},
                { data: 'status' },
                { data: 'point_in_rs' },
                { data: 'bhav' },
                { data: 'winning_in_rs' },
                { data: 'commission_in_rs' },
                { data: 'currency_code' },
                { data: 'exchange_rate' },
                { data: 'updated' },
                    
            ]
        });

        $('#round_id,#result_date,#status,#partner_id,#transaction_id,#customer_id').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>