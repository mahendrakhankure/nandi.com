<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" id="bazarName" name="bazarName">
                                    <option value="">Select Bazar Name...</option>
                                    <?php foreach ($bazar as $b) { ?>
                                        <option value="<?php echo $b['id']; ?>" ?><?= $b['bazar_name']; ?></option>
                                    <?php } ?>    
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="type">
                                    <option value="">Select Type...</option>
                                    <option value="Open">Open</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="resultDate" placeholder="Search Result Date"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="adminId" placeholder="Search Admin"/>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bazar Name</th>
                      <th>Type</th>
                      <th>Result Date</th>
                      <th>Cutting</th>
                      <th>Cutting Data</th>
                      <th>Admin</th>
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
            'order': [[3, 'desc']],
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>f80d15e4e53ed623b385a4b62b1cef38',
              'data': function(data){
                    data.bazarName = $('#bazarName').val();
                    data.resultDate = $('#resultDate').val();
                    data.type = $('#type').val();
                    data.adminId = $('#adminId').val();
              }
            },
            'columns': [
                { data: 'id' },
                { data: 'bazarName' },
                { data: 'type' },
                { data: 'resultDate' },
                { data: 'cuttingPercentage' },
                { data: 'cuttingData','render':function(data, type, row, meta){
                    var nR = JSON.parse(row.cuttingData);
                    var t = '<table class=table table-striped>';
                    if(i==1){
                        t += '<thead><tr><th scope="col">totalAmount</th><th scope="col">clientStack</th><th scope="col">ourStack</th><th scope="col">cuttingAmount</th></tr></thead>';
                    }
                    i++;
                    return t += '<tbody><tr><td scope="col">'+nR.totalAmount+'</td><td scope="col">'+nR.clientStack+'</td><td scope="col">'+nR.ourStack+'</td><td scope="col">'+nR.cuttingAmount+'</td></tr></tbody></table>';
                } },
                { data: 'adminId' },
                { data: 'updated' },
                    
            ]
        });

        $('#bazarName,#resultDate,#type,#adminId').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>