<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
    .box{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; text-align: center; color: #FF1362; min-height: 50px;}
        .box1{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; color: #FF1362; }
        .bazarHeader { padding: 8px; border: solid 1px #FF1362; margin: 0; text-align: center }
        .jodi{ border: 1px solid #BFE924; padding: 8px; margin: 10px;  size: 30px 30px; height: 70px; width: 138px;}
        .sangam{ border: 1px solid #BFE924; padding: 8px; margin: 10px;  size: 30px 30px; height: 80px; width: 255px;}
        .sopen{ border: 1px solid #BFE924; padding: 4px; margin: 5px; height: 60px; width: 200px;    float: left;}
        .game{ font-size: 15px;  text-align:left; color: #e65100; background: #f4ff81;}
        .amount{ font-size: 20px; text-align: right; color: #004d40; font-weight: 100%;}
        .akda{ color: #1c2331; padding: 15px; background-color: #f4ff81;}
        .title {
            border: 2px solid #0800FF;padding-top: 20px;color: #00A6D3;text-align: center; }
        td{
            padding:20px;
            text-align: center;
            border:1px solid #ccc;
        }
        #search {
            padding: 5px;
            width: 80px;
            margin: 23px 0px;
        }
</style>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title"><?=strtoupper(urldecode($bazarName))?></h3>
            </div>
        </div>
        <div class="row">
            <div class='col-md-12'><div class='box bazarHeader'><h3><?=urldecode($gameName)?></h3></div></div>
            <?php 
                $tI = 0;
                $tP = 0;
                if($gameId=="2"){
            ?>

            <?php
                foreach ($arr as $d) { 
                    $tI = $tI+$d['id']; 
                    $tP = $tP+$d['point']; 
                    if($d['id']>0){
                        $sty = "color:ccc";
                    }else{
                        $sty = "color:red";
                    }
                    echo "<div class='col-md-6'>
                            <div class='box1'>
                                <span class='akda'>".$d['akda']."</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Total Bet : ".$d['id']."</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class='amount' style='".$sty."'>Amt : ".$d['point']."</span>
                            </div>  
                        </div>
                        ";
                }
                
            }else {
                foreach ($arr as $d) {
                    $tI = $tI+$d['id']; 
                    $tP = $tP+$d['point'];
                    if($d['id']>0){
                        $sty = "color:ccc";
                    }else{
                        $sty = "color:red";
                    }
                    echo $html = "
                            <div class='sopen'>
                                <span class='game'>".$d['akda']."</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span>: ".$d['id']."</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class='amount' style='".$sty."'>: ".$d['point']."</span>
                            </div>";
                }
            }
            echo "<div class='col-md-12'>
                    <div class='box bazarHeader'>
                        <h3>
                            TOTAL BET : ".$tI."
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            TOTAL AMOUNT : ".$tP.".00
                        </h3>
                    </div>";
        ?>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <!-- <div class="form-group">
                                <input type="text" class="form-control" id="transaction_id" placeholder="Search Transaction ID"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="partner_id" placeholder="Search Partner ID"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer ID"/>
                            </div> -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="user_game" placeholder="Search Game"/>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Transaction ID</th>
                      <th>Partner ID</th>
                      <th>Customer ID</th>
                      <th>Bazar Name</th>
                      <th>Game Name</th>
                      <th>Time</th>
                      <th>Game</th>
                      <th>Point</th>
                      <th>Result Date</th>
                      <th>Status</th>
                      <th>Winning Point</th>
                      <th>Commission</th>
                      <th>Bet Time</th>
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
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>fb8cea741f03e6ba2d5c7b90b8657500',
              'data': function(data){

                    data.transaction_id = $('#transaction_id').val();
                    data.partner_id = $('#partner_id').val();
                    data.customer_id = $('#customer_id').val();
                    data.game = $('#user_game').val();
                    data.bazar_name = <?=$bazar_id?>;
                    data.game_name = <?=$gameId?>;
                    data.game_time = "<?=$time_id?>";
                    data.result_date = "<?=$_GET['from']?>";
                    data.to_date = "<?=$_GET['to']?>";
              }
            },
            'columns': [
                { data: 'transaction_id',render: function (data, type, row, meta) {
                        return i++;
                   } },
                { data: 'transaction_id' },
                { data: 'partner_id' },
                { data: 'customer_id' },
                { data: 'bazar_name' },
                { data: 'game_name' },
                { data: 'time' },
                { data: 'game' },
                { data: 'point' },
                { data: 'result_date' },
                { data: 'status' },
                { data: 'winning_point' },
                { data: 'commission' },
                { data: 'created' },
                    
            ]
        });

        $('#transaction_id,#partner_id,#customer_id,#user_game').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>