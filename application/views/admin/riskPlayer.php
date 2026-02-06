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
                <h3>Risk Player</h3>
                <div class="col-md-4 offset-md-8">
                    <!-- <form> -->
                      <div class="form-group">
                        <label for="daterange">Date</label>
                        <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                        <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                      </div>
                      <div class="form-group">
                        <label for="risk">Risk</label>
                        <input type="number" class="form-control risk" name="dateRange" id="risk" placeholder="Enter Amount" />
                        <small id="risk" class="form-text text-muted">Enter Amount.</small>
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
                          <select data-placeholder="Select Bazar Days" class="chosen-select form-control" name="days" id="b1">
                            <?php foreach ($regularBazar as $b) { ?>
                                <option value="<?=$b['id'];?>"><?=$b['bazar_name'];?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="form-group" id="sG">
                        <label for="bazar_name">Starline Bazar Name</label>
                        <select class="chosen-select form-control" id="b2" name="starline_bazar_name" required>
                            <?php foreach ($starlineBazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                            <?php } ?>    
                        </select>
                      </div>
                      <div class="form-group" id="kG">
                        <label for="bazar_name">King Bazar Name</label>
                        <select class="chosen-select form-control" id="b3" name="king_bazar_name" required>
                            <?php foreach ($kingBazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                            <?php } ?>    
                        </select>
                      </div>
                      <span class="btn btn-primary" id="getD">Submit</span>
                    <!-- </form> -->
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
    $('#getD').click(function(){
        var mar = $("#market").val();
        if(mar=='1'){
            var bazar = $("#b1").val();
        }else if(mar=='2'){
            var bazar = $("#b2").val();
        }else if(mar=='3'){
            var bazar = $("#b3").val();
        }else{
            var bazar = '';
        }
        if(mar!="0"){
            // $('.flexbox').show();
            var formData = {
                mar: mar,
                bazar: bazar,
                date: $("#dateRange").val(),
                risk:$("#risk").val(),
            };
            console.log(formData)
            if(mar=='1'){
                var userDataTable = $('#userTable').DataTable({
                    "pageLength": 25,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    'ajax': {
                    'url':'<?=base_url()?>c5b1c5c42325ab0120d776f1961dd4df',
                    'data': function(data){
                            data.bazar_name = bazar;
                            data.result_date = $("#dateRange").val();
                            data.risk = $("#risk").val();
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
            }
        }else{
            alert('Please Select Market')
        }
    });
</script>