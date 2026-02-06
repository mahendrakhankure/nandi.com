<?php 
    include 'includes/header.php';
?>
<style>
    a {
        padding: 5px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div>
        <h1>
            <i class="fa fa-users"></i> Manage Starline Bazar
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>3afbe93779c63a141c07aa38bc717dad/0"><i class="fa fa-plus"></i> Add Starline Bazar</a>
      </div>
    </section>
    <section class="content">
        <div class="rows">
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bazar Name</th>
                      <th>Status</th>
                      <th>Live TV</th>
                      <th>Holiday</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        var i = 1;
        var userDataTable = $('#userTable').DataTable({
            "pageLength": 50,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>7932304afa07498c9b2b9cd3954c33d7',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return i++;
                } },
                { data: 'bazar_name' },
                { data: 'status' },
                { data: 'icon_status','render':function(data, type, row, meta){
                    if(row.icon_status=='1'){
                        return 'On';
                    }else{
                        return 'Off';
                    }
                } },
                { data: 'icon_status1','render':function(data, type, row, meta){
                    if(row.icon_status1=='1'){
                        return 'On';
                    }else{
                        return 'Off';
                    }
                } },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>3afbe93779c63a141c07aa38bc717dad/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });
        $('#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>