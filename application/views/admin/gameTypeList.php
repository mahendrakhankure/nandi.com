 <?php 
    include 'includes/header.php'; 
    // echo '<pre>';
    // print_r($matkagame);
    // die();
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
            <i class="fa fa-users"></i> Manage Starline Game Type
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>79046094d59e745770a92655779e6284/0"><i class="fa fa-plus"></i> Add Starline Game Type</a>
      </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12 form-group" id="mysearch">
                    <input type="text" placeholder="Enter Game Name" id="gameName" name="gameName" value="<?php echo $searchMode; ?>" >
                    <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" >
            </div>
        </div>
         
        <div class="col-12">
            <table id='userTable' class='display dataTable'>
              <thead>
                <tr>
                  <th>Sr.</th>
                  <th>Game Name</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
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
              'url':'<?=base_url()?>bc5b398327e1377d15fb309a07d92e8b',
              'data': function(data){
                    data.status = $('#status').val();
                    data.game_name = $('#gameName').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return row.sr;
                } },
                { data: 'game_name' },
                { data: 'priority' },
                { data: 'status' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>79046094d59e745770a92655779e6284/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });
        $('#status,#gameName').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>