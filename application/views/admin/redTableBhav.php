<?php 
    include 'includes/header.php';
?>
<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
        <style>
            a {
                padding: 5px;
            }
            .oRes{
                background-color: #081f58;
            }
        </style>

<?php
    function get_common_sql($bazar,$game,$game_type,$i){
        $CI =& get_instance();
        $arr = ['7','46','47','11'];
        if(in_array($game,$arr)){
            $con=' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game ="'.$i.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'"';
        } else {
            $con=' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game ="'.$i.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'"';
        }
        $feilds = 'SUM(point) AS money, COUNT(id) AS id, game AS game';
        return $CI->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
    }
    function get_common_total_sql($bazar,$game,$game_type){
        $CI =& get_instance();
        $con = ' WHERE result_date ="'.date('Y-m-d').'" AND game_name= "'.$game.'" AND game_type="'.$game_type.'" AND bazar_name ="'.$bazar.'"';
        $feilds = 'SUM(point) AS money, COUNT(id) AS id';
        return $CI->Common_model->getData('regular_bazar_games',$con,$feilds,'','','One','','');
    }
    
    $sPatti=['1','7','12','15','16','18','19','20','24','25','26','27','28','29','30','31','32','33'];
    $dPatti=['2','13','34','36','39','40','41','43','46'];
    $tPatti=['4','35','42','45','47','48'];
    $family=[];
    $jodi=['6','10','11','14','17','22','23'];
?>

<style type="text/css">
    .boxPanna span { padding: 20px; font-size: x-large;}
    .boxPanna{ border: 1px solid #BFE924; padding: 10px 0; margin: 6px 0; color: #FF1362; min-height: 50px;}
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
        border: 2px solid #0800FF;padding-top: 20px;padding-bottom: 20px;margin-bottom: 20px;color: #00A6D3;text-align: center; }
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
    .jodi{
        float: left;
    }
</style>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" id="game_name" placeholder="Search Game Name"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="id" placeholder="Search ID"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="status" placeholder="Search status"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Game Name</th>
                      <th>Bhav</th>
                      <th>Status</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var i = 0;
        var userDataTable = $('#userTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'pageLength':25,
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>8faca56e342dd1e7d5deb2d2df3d27fb',
              'data': function(data){

                    data.game_name = $('#game_name').val();
                    data.id = $('#id').val();
                    data.status = $('#status').val();
              }
            },
            'columns': [
                { data: 'id' ,render: function (data, type, row, meta) {
                    return row.sr;
                } },
                { data: 'game_name' },
                { data: 'bhav','render':function(data, type, row, meta){
                    return '<input type="text" name="bhav" onchange="setBhav('+row.id+',this.value)" value="'+row.bhav+'" onkeypress="return isNumber(event)" maxlength="5" />';
                } },
                { data: 'status' },
                // { data: 'id' },
                    
            ]
        });

        $('#game_name,#id,#status').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });

    function setBhav(id,val){
        if(confirm("Do You Realy Want To Change The Bhav")){
            $.ajax({
                type:"post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>3813dc5521288f7693e5ba4132fd44d1",
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