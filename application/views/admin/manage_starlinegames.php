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
            <i class="fa fa-users"></i> Manage Startline Bazar Time
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>77ea0d27f166c8231ec4a9a0861af552/0"><i class="fa fa-plus"></i> Add Game</a>
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
                      <th>Time</th>
                      <th>Status</th>
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
            "pageLength": 25,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>0b1a4cf7c60a831e444002c6fdde6f8f',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return row.sr;
                } },
                { data: 'bazar_name' },
                { data: 'time' },
                { data: 'status' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>77ea0d27f166c8231ec4a9a0861af552/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });
        $('#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>