<?php include 'includes/header.php'; ?>
<style type="text/css">
    #rG,#sG,#kG,#baz{
        display: none;
    }
    .chosen-container{
        width: 100% !important;
    }
    table,.Headding{
        text-align: center;
    }
    table tr th{
        text-align: center;
    }
</style>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <h3>Back Business All</h3>
                <div class="col-md-4 offset-md-8">
                    <form>
                      <div class="form-group">
                        <label for="daterange">Date</label>
                        <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                        <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                      </div>
                      <div class="form-group">
                        <label for="Client">Client</label><br>
                          <select data-placeholder="Select Client" multiple class="chosen-select form-control" name="client[]" id="c1">
                            <option value="">All Clients</option>
                            <?php foreach ($client as $b) { ?>
                                <option value="<?=$b['id'];?>"><?=$b['client_name'];?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="bazar_name">Market</label>
                        <select class="form-control" id="market" name="market" required>
                            <option value="0">Select Market Name...</option>
                            <option value="1">Regular</option>
                            <option value="2">Starline</option>
                            <option value="3">King</option>
                            <option value="4">Red</option>
                            <option value="5">Blue</option>
                            <!-- <option value="6">Golden</option> -->
                        </select>
                      </div>
                      <div class="form-group" id="rG">
                        <label for="days">Regular Bazar Name</label><br>
                          <select data-placeholder="Select Bazar Days" multiple class="chosen-select form-control" name="days[]" id="b1">
                            <option value="IN">IN</option>
                            <option value="OUT">OUT</option>
                            <?php foreach ($regularBazar as $b) { ?>
                                <option value="<?=$b['id'];?>"><?=$b['bazar_name'];?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="form-group" id="sG">
                        <label for="bazar_name">Starline Bazar Name</label>
                        <select class="chosen-select form-control" id="b2" name="starline_bazar_name[]" multiple="true" required>
                            <?php foreach ($starlineBazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                            <?php } ?>    
                        </select>
                      </div>
                      <div class="form-group" id="kG">
                        <label for="bazar_name">King Bazar Name</label>
                        <select class="chosen-select form-control" id="b3" name="king_bazar_name[]" multiple="multiple" required>
                            <?php foreach ($kingBazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                            <?php } ?>    
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </form>
                </div>
            </div>
        <div id="dome"></div>
        <div id="domeTable"></div>
        </div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>

<script type="text/javascript">

    $("#market").change(function() {
        var mar = $('#market').val();
        if(mar=='1'){
            $('#rG').show();
            $('#sG').hide();
            $('#kG').hide();
        }else if(mar=='2'){
            $('#rG').hide();
            $('#sG').show();
            $('#kG').hide();
        }else if(mar=='3'){
            $('#rG').hide();
            $('#sG').hide();
            $('#kG').show();
        }
    });
    $(function () {
        $('#submit').bind('click', function (event) {
        event.preventDefault();
        var mar = $("#market").val();
        if(mar=='1'){
            if($("#b1").val()=='IN'){
                var bazar = ['3','4','5','6','7','8','10','11','12','14','16','17','18','19','20','21','22','26','27','28','68','69','70','73'];
            }else if($("#b1").val()=='OUT'){
                var bazar = ['9','13','15','23','24','25'];
            }else{
                var bazar = $("#b1").val();
            }
        }else if(mar=='2'){
            var bazar = $("#b2").val();
        }else if(mar=='3'){
            var bazar = $("#b3").val();
        }else{
            var bazar = '';
        }
        
            if(mar!="0"){
                $('.flexbox').show();
                var formData = {
                    mar: mar,
                    bazar: bazar,
                    date: $("#dateRange").val(),
                    client:$("#c1").val()
                };
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>d383679f6c7f94714026d747f9f77f33",
                    data: formData,
                    success: function (res) {
                        var newRes = JSON.parse(res);
                        var d ='<div><h3 class="Headding">Business Statement (Bazar Wise)</h3>';
                        if(mar=='1'){
                            var tWin = newRes.sAkda.win+newRes.spatti.win+newRes.dpatti.win+newRes.tpatti.win+newRes.jodi.win+newRes.sangam.win;
                            var tBetPoint = newRes.sAkda.point+newRes.spatti.point+newRes.dpatti.point+newRes.tpatti.point+newRes.jodi.point+newRes.sangam.point;
                            var tBetId = newRes.sAkda.id+newRes.spatti.id+newRes.dpatti.id+newRes.tpatti.id+newRes.jodi.id+newRes.sangam.id;
                            var tCom = newRes.sAkda.com+newRes.spatti.com+newRes.dpatti.com+newRes.tpatti.com+newRes.jodi.com+newRes.sangam.com;
                            var tT = (tBetPoint-tWin)+tCom;

                            d += '<table class="table"><thead><tr><th></th><th>Singal Akda</th><th>Jodi</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Sangam</th><th>Total</th></tr></thead><tbody><tr><th>Bid Amount</th><td>'+parseInt(newRes.sAkda.point)+'</td><td>'+parseInt(newRes.jodi.point)+'</td><td>'+parseInt(newRes.spatti.point)+'</td><td>'+parseInt(newRes.dpatti.point)+'</td><td>'+parseInt(newRes.tpatti.point)+'</td><td>'+parseInt(newRes.sangam.point)+'</td><td>'+parseInt(tBetPoint)+'</td><td></td><td></td><td></td></tr><tr><th>Winning</th><td>'+parseInt(newRes.sAkda.win)+'</td><td>'+parseInt(newRes.jodi.win)+'</td><td>'+parseInt(newRes.spatti.win)+'</td><td>'+parseInt(newRes.dpatti.win)+'</td><td>'+parseInt(newRes.tpatti.win)+'</td><td>'+parseInt(newRes.sangam.win)+'</td><td>'+parseInt(tWin)+'</td><td></td><td></td><td></td></tr><tr><th>Commission</th><td>'+parseInt(newRes.sAkda.com)+'</td><td>'+parseInt(newRes.jodi.com)+'</td><td>'+parseInt(newRes.spatti.com)+'</td><td>'+parseInt(newRes.dpatti.com)+'</td><td>'+parseInt(newRes.tpatti.com)+'</td><td>'+parseInt(newRes.sangam.com)+'</td><td>'+parseInt(tCom)+'</td><td></td><td></td><td></td></tr><tr><th>GGR</th><td>'+parseInt((newRes.sAkda.point+newRes.sAkda.com)-newRes.sAkda.win)+'</td><td>'+parseInt((newRes.jodi.point+newRes.jodi.com)-newRes.jodi.win)+'</td><td>'+parseInt((newRes.spatti.point+newRes.spatti.com)-newRes.spatti.win)+'</td><td>'+parseInt((newRes.dpatti.point+newRes.dpatti.com)-newRes.dpatti.win)+'</td><td>'+parseInt((newRes.tpatti.point+newRes.tpatti.com)-newRes.tpatti.win)+'</td><td>'+parseInt((newRes.sangam.point+newRes.sangam.com)-newRes.sangam.win)+'</td><td>'+parseInt(tT)+'</td><td></td><td></td><td></td></tr></tbody></table></div>';
                        }else if(mar=='2'){
                            var tWin = newRes.sAkda.win+newRes.spatti.win+newRes.dpatti.win+newRes.tpatti.win;
                            var tBetPoint = newRes.sAkda.point+newRes.spatti.point+newRes.dpatti.point+newRes.tpatti.point;
                            var tBetId = newRes.sAkda.id+newRes.spatti.id+newRes.dpatti.id+newRes.tpatti.id;
                            var tCom = newRes.sAkda.com+newRes.spatti.com+newRes.dpatti.com+newRes.tpatti.com;
                            var tT = (tBetPoint-tWin)+tCom;
                            d += '<table class="table"><thead><tr><th></th><th>Singal Akda</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Total</th></tr></thead><tbody><tr><th>Bid Amount</th><td>'+parseInt(newRes.sAkda.point)+'</td><td>'+parseInt(newRes.spatti.point)+'</td><td>'+parseInt(newRes.dpatti.point)+'</td><td>'+parseInt(newRes.tpatti.point)+'</td><td>'+parseInt(tBetPoint)+'</td></tr><tr><th>Winning</th><td>'+parseInt(newRes.sAkda.win)+'</td><td>'+parseInt(newRes.spatti.win)+'</td><td>'+parseInt(newRes.dpatti.win)+'</td><td>'+parseInt(newRes.tpatti.win)+'</td><td>'+parseInt(tWin)+'</td></tr><tr><th>Commission</th><td>'+parseInt(newRes.sAkda.com)+'</td><td>'+parseInt(newRes.spatti.com)+'</td><td>'+parseInt(newRes.dpatti.com)+'</td><td>'+parseInt(newRes.tpatti.com)+'</td><td>'+parseInt(tCom)+'</td></tr><tr><th>GGR</th><td>'+parseInt((newRes.sAkda.point-newRes.sAkda.win)+newRes.sAkda.com)+'</td><td>'+parseInt((newRes.spatti.point-newRes.spatti.win)+newRes.spatti.com)+'</td><td>'+parseInt((newRes.dpatti.point-newRes.dpatti.win)+newRes.dpatti.com)+'</td><td>'+parseInt((newRes.tpatti.point-newRes.tpatti.win)+newRes.tpatti.com)+'</td><td>'+parseInt(tT)+'</td><td></tr></tbody></table></div>';
                        }else if(mar=='3'){
                            var tWin = newRes.sAkda.win+newRes.dAkda.win+newRes.jodi.win;
                            var tBetPoint = newRes.sAkda.point+newRes.dAkda.point+newRes.jodi.point;
                            var tBetId = newRes.sAkda.id+newRes.dAkda.id+newRes.jodi.id;
                            var tCom = newRes.sAkda.com+newRes.dAkda.com+newRes.jodi.com;
                            var tT = (tBetPoint-tWin)+tCom;
                            d += '<table class="table"><thead><tr><th></th><th>First Digit</th><th>Secound Digit</th><th>Jodi</th><th>Total</th></tr></thead><tbody><tr><th>Bid Amount</th><td>'+parseInt(newRes.sAkda.point)+'</td><td>'+parseInt(newRes.dAkda.point)+'</td><td>'+parseInt(newRes.jodi.point)+'</td><td>'+parseInt(tBetPoint)+'</td></tr><tr><th>Winning</th><td>'+parseInt(newRes.sAkda.win)+'</td><td>'+parseInt(newRes.dAkda.win)+'</td><td>'+parseInt(newRes.jodi.win)+'</td><td>'+parseInt(tWin)+'</td></tr><tr><th>Commission</th><td>'+parseInt(newRes.sAkda.com)+'</td><td>'+parseInt(newRes.dAkda.com)+'</td><td>'+parseInt(newRes.jodi.com)+'</td><td>'+parseInt(tCom)+'</td></tr><tr><th>GGR</th><td>'+parseInt((newRes.sAkda.point-newRes.sAkda.win)+newRes.sAkda.com)+'</td><td>'+parseInt((newRes.dAkda.point-newRes.dAkda.win)+newRes.dAkda.com)+'</td><td>'+parseInt((newRes.jodi.point-newRes.jodi.win)+newRes.jodi.com)+'</td><td>'+parseInt(tT)+'</td></tr></tbody></table></div>';
                        }else if(mar=='4' || mar=='5' || mar=='6'){
                            var tWin = newRes.sAkda.win+newRes.spatti.win+newRes.dpatti.win+newRes.tpatti.win;
                            var tBetPoint = newRes.sAkda.point+newRes.spatti.point+newRes.dpatti.point+newRes.tpatti.point;
                            var tBetId = newRes.sAkda.id+newRes.spatti.id+newRes.dpatti.id+newRes.tpatti.id;
                            var tCom = newRes.sAkda.com+newRes.spatti.com+newRes.dpatti.com+newRes.tpatti.com;
                            var tT = (tBetPoint-tWin)+tCom;
                            d += '<table class="table"><thead><tr><th></th><th>Singal Akda</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Total</th></tr></thead><tbody><tr><th>Bid Amount</th><td>'+parseInt(newRes.sAkda.point)+'</td><td>'+parseInt(newRes.spatti.point)+'</td><td>'+parseInt(newRes.dpatti.point)+'</td><td>'+parseInt(newRes.tpatti.point)+'</td><td>'+parseInt(tBetPoint)+'</td></tr><tr><th>Winning</th><td>'+parseInt(newRes.sAkda.win)+'</td><td>'+parseInt(newRes.spatti.win)+'</td><td>'+parseInt(newRes.dpatti.win)+'</td><td>'+parseInt(newRes.tpatti.win)+'</td><td>'+parseInt(tWin)+'</td></tr><tr><th>Commission</th><td>'+parseInt(newRes.sAkda.com)+'</td><td>'+parseInt(newRes.spatti.com)+'</td><td>'+parseInt(newRes.dpatti.com)+'</td><td>'+parseInt(newRes.tpatti.com)+'</td><td>'+parseInt(tCom)+'</td></tr><tr><th>GGR</th><td>'+parseInt(newRes.sAkda.point)+'</td><td>'+parseInt(newRes.spatti.point)+'</td><td>'+parseInt(newRes.dpatti.point)+'</td><td>'+parseInt(newRes.tpatti.point)+'</td><td>'+parseInt(tT)+'</td></tr></tbody></table></div>';
                        }

                        $('.flexbox').hide();

                        $('#dome').html('');
                        $('#dome').append(d);
                        var table = "<p id='baz'>"+bazar+"</p>";
                        if(mar=='1'){
                            table = "<table id='userTable' class='display dataTable'><thead><tr><th>Customer Id</th><th>Singal Akda</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Jodi</th><th>Bid Amount</th><th>Win</th><th>Commission</th><th>Total</th></tr></thead></table>";
                            $('#domeTable').html('');
                            $('#domeTable').append(table);
                            // var l = 1;
                            var userDataTable = $('#userTable').DataTable({
                                "pageLength": 25,
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                'ajax': {
                                'url':'<?=base_url()?>22c7b3b5d58876cf203a6a09dd70401a',
                                'data': function(data){
                                        data.bazar_name = bazar;
                                        data.result_date = $("#dateRange").val();
                                        data.client = $("#c1").val();
                                }
                                },
                                'columns': [
                                    // { data: 'customer_id',render: function (data, type, row, meta) {
                                    //         return i++;
                                    //    } },
                                    { data: 'customer_id' },
                                    { data: 'sAkda' },
                                    { data: 'sPatti' },
                                    { data: 'dPatti' },
                                    { data: 'tPatti' },
                                    { data: 'jodi' },
                                    { data: 'bet' },
                                    { data: 'win' },
                                    { data: 'com' },
                                    { data: 'total' }    
                                ]
                            });
                            $('#userTable_filter').hide();
                        }else if(mar=='2'){
                            table = "<table id='userTable' class='display dataTable'><thead><tr><th>Customer Id</th><th>Singal Akda</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Bid Amount</th><th>Win</th><th>Commission</th><th>Total</th></tr></thead></table>";
                            $('#domeTable').html('');
                            $('#domeTable').append(table);
                            // var l = 1;
                            var userDataTable = $('#userTable').DataTable({
                                "pageLength": 25,
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                'ajax': {
                                'url':'<?=base_url()?>8d37bb5635b7b6b13fea292d485a7765',
                                'data': function(data){
                                        data.mar = mar;
                                        data.result_date = $("#dateRange").val();
                                        data.client = $("#c1").val();
                                        data.bazar_name = bazar;
                                }
                                },
                                'columns': [
                                    // { data: 'customer_id',render: function (data, type, row, meta) {
                                    //         return i++;
                                    //    } },
                                    { data: 'customer_id' },
                                    { data: 'sAkda' },
                                    { data: 'sPatti' },
                                    { data: 'dPatti' },
                                    { data: 'tPatti' },
                                    { data: 'bet' },
                                    { data: 'win' },
                                    { data: 'com' },
                                    { data: 'total' }    
                                ]
                            });
                            $('#userTable_filter').hide();
                        }else if(mar=='3'){
                            table = "<table id='userTable' class='display dataTable'><thead><tr><th>Customer Id</th><th>First Digit</th><th>Secound Digit</th><th>Jodi</th><th>Bid Amount</th><th>Win</th><th>Commission</th><th>Total</th></tr></thead></table>";
                            $('#domeTable').html('');
                            $('#domeTable').append(table);
                            // var l = 1;
                            var userDataTable = $('#userTable').DataTable({
                                "pageLength": 25,
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                'ajax': {
                                'url':'<?=base_url()?>a29b052d4c3bd98b0357f56934d6460d',
                                'data': function(data){
                                        data.bazar_name = bazar;
                                        data.result_date = $("#dateRange").val();
                                        data.client = $("#c1").val();
                                }
                                },
                                'columns': [
                                    // { data: 'customer_id',render: function (data, type, row, meta) {
                                    //         return i++;
                                    //    } },
                                    { data: 'customer_id' },
                                    { data: 'sAkda' },
                                    { data: 'sPatti' },
                                    { data: 'dPatti' },
                                    { data: 'bet' },
                                    { data: 'win' },
                                    { data: 'com' },
                                    { data: 'total' }    
                                ]
                            });
                            $('#userTable_filter').hide();
                        }else if(mar=='4' || mar=='5' || mar=='6'){
                            table = "<table id='userTable' class='display dataTable'><thead><tr><th>Customer Id</th><th>Singal Akda</th><th>Singal Patti</th><th>Double Patti</th><th>Triple Patti</th><th>Bid Amount</th><th>Win</th><th>Commission</th><th>Total</th></tr></thead></table>";
                            $('#domeTable').html('');
                            $('#domeTable').append(table);
                            // var l = 1;
                            var userDataTable = $('#userTable').DataTable({
                                "pageLength": 25,
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                'ajax': {
                                'url':'<?=base_url()?>d3454bbf95ce2d44beee1693f52815c1',
                                'data': function(data){
                                        data.mar = mar;
                                        data.result_date = $("#dateRange").val();
                                        data.client = $("#c1").val();
                                        data.bazar = bazar;
                                }
                                },
                                'columns': [
                                    // { data: 'customer_id',render: function (data, type, row, meta) {
                                    //         return i++;
                                    //    } },
                                    { data: 'customer_id' },
                                    { data: 'sAkda' },
                                    { data: 'sPatti' },
                                    { data: 'dPatti' },
                                    { data: 'tPatti' },
                                    { data: 'bet' },
                                    { data: 'win' },
                                    { data: 'com' },
                                    { data: 'total' }    
                                ]
                            });
                            $('#userTable_filter').hide();
                        }
                    }
                });
            }else{
                alert('Please Select Market')
            }
        });
    });
</script>