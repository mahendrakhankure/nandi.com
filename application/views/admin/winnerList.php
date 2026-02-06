<?php include 'includes/header.php'; ?>
<style>
    body .modal-dialog {
        /* max-width: 100%; */
        width: auto !important;
    }
    table{
        width: 100%;
        display: block;
        overflow-x: auto;
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
                                <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                            </div>
                            <div class="form-group">
                                <select class="form-control" aria-label="Default select example" id="order">
                                    <option value='desc'>Win</option>
                                    <option value='asc' selected>Loss</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="limit" value='25' placeholder="Search Limit"/>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <table id='userTable' class='display dataTable'  style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>App</th>
                            <th>Point</th>
                            <th>Win</th>
                            <th>GGR</th>
                        </tr>
                    </thead>
                    <tbody id='tBody'>
                    </tbody>
                </table>
            </div>
		</div>
        <button type="button" class="btn btn-info btn-lg" id='openModel' data-toggle="modal" data-target="#myModal" style='display:none'>Open Modal</button>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table id='userTable' class='display dataTable'>
                        <thead>
                            <tr>
                                <th>Market Type</th>
                                <th>Point</th>
                                <th>Win</th>
                                <th>GGR</th>
                                <th>Bet On Bazar</th>
                                <th>Win On Bazar</th>
                            </tr>
                        </thead>
                        <tbody id='customerTBody'>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        getData()
        function getData(){
            $('.flexbox').show()
            $.ajax({
                type:"post",
                dataType: 'json',
                url: "<?php echo base_url(); ?>bff07cc69563fe06d2260c6766e80a59",
                data:{date:$('#dateRange').val(),order:$('#order').val(),limit:$('#limit').val()},
                success:function(re){ 
                    $('.flexbox').hide();
                    if (re.status == '200') {
                        $('#tBody').empty();
                        var d = '';
                        var i = 1;
                        $.each(re.data, function(index, value) {
                            d += '<tr onclick=checkUserData("'+value.customer_id+'")>';
                            d += '<td>'+i+'</td>';
                            d += '<td>'+value.customer_id+'</td>';
                            d += '<td>'+value.name+'</td>';
                            d += '<td>'+value.mobile+'</td>';
                            d += '<td>'+value.app+'</td>';
                            d += '<td>'+roundToTwoDecimals(value.total_points)+'</td>';
                            d += '<td>'+roundToTwoDecimals(value.total_win_points)+'</td>';
                            d += '<td>'+roundToTwoDecimals(value.ggr)+'</td>';
                            d += '</tr>';
                            i++;
                        });
                        $('#tBody').append(d);
                    }else{
                        alert(re.massage);
                    }
                },
                error:function(err){
                    $('.flexbox').hide();
                    console.log(err)
                }
            });
        }
        $('#submit').click(function(){
            getData();
        });
        function roundToTwoDecimals(num) {
            return Math.round(num * 100) / 100;
        }
	});

    function checkUserData(d) {
        console.log(d)
        $.ajax({
            type:"post",
            dataType: 'json',
            url: "<?php echo base_url(); ?>173e9596a0164a1b1793e8bf7322ba31",
            data:{date:$('#dateRange').val(),id:d},
            success:function(re){ 
                $('.flexbox').hide();
                console.log(re)
                if (re.status == '200') {
                    $('#customerTBody').empty();
                    var dumy = {total_points:0,total_win_points:0,ggr:0,all_bazars:'-'};
                    var d = '';
                    var t = re.data;
                    var regular = t.regular[0]?t.regular[0]:dumy;
                    var regularHome = t.regularHome[0]?t.regularHome[0]:dumy;
                    var starline = t.starline[0]?t.starline[0]:dumy;
                    var kingBazar = t.kingBazar[0]?t.kingBazar[0]:dumy;
                    var worli = t.worli[0]?t.worli[0]:dumy;
                    var wheel = t.wheel[0]?t.wheel[0]:dumy;
                    
                    d += '<tr><td>Regular</td><td>'+regular.total_points+'</td><td>'+regular.total_win_points+'</td><td>'+regular.ggr+'</td><td>'+regular.all_bazars+'</td><td>'+regularHome.all_bazars+'</td></tr>';
                    d += '<tr><td>Starline</td><td>'+starline.total_points+'</td><td>'+starline.total_win_points+'</td><td>'+starline.ggr+'</td><td>'+starline.all_bazars+'</td></tr>';
                    d += '<tr><td>King Bazar</td><td>'+kingBazar.total_points+'</td><td>'+kingBazar.total_win_points+'</td><td>'+kingBazar.ggr+'</td><td>'+kingBazar.all_bazars+'</td></tr>';
                    d += '<tr><td>Instant Worli</td><td>'+worli.total_points+'</td><td>'+worli.total_win_points+'</td><td>'+worli.ggr+'</td><td>-</td></tr>';
                    d += '<tr><td>Crazy Wheel</td><td>'+wheel.total_points+'</td><td>'+wheel.total_win_points+'</td><td>'+wheel.ggr+'</td><td>-</td></tr>';
                    $('#customerTBody').append(d);
                    $('#openModel').click();
                }else{
                    alert(re.massage);
                }
            },
            error:function(err){
                $('.flexbox').hide();
                console.log(err)
            }
        });
    }
</script>