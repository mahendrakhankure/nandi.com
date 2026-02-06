<?php 
    include 'includes/header.php'; 
    // print_r($matkagame);die();
?>
      
 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div>
            <h1>
                <i class="fa fa-users"></i> Manage Matka Games
                <small>Add, Edit, Delete</small>
            </h1>
       </div>
        <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>0f32a616f35638d4e0b44c9ab643976e/0"><i class="fa fa-plus"></i> Add Game</a>
        </div>
     
    </section>
    <section class="content">
            <div class="rows">
                <div class="col-12">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="bazar_name" placeholder="Search Bazar Name"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id='userTable' class='display dataTable'>
                      <thead>
                        <tr>
                          <th>Sr.</th>
                          <th>Bazar Name</th>
                          <th>Open Time</th>
                          <th>Close Time</th>
                          <th>Days</th>
                          <th>Sequence</th>
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
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'order': [[5, 'desc']],
            'pageLength':25,
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>a429d046df97a54547ae9f9b523bb904',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
              }
            },
            'columns': [
                { data: 'sr' },
                { data: 'bazar_name' },
                { data: 'open_time' },
                { data: 'close_time' },
                { data: 'days' },
                { data: 'sequence' },
                { data: 'status','render':function(data, type, row, meta){
                    return '<span id="'+row.id+'">'+row.status+'</span>';
                } },
                { data: 'icon_status' ,'render':function(data, type, row, meta){
                    if(row.icon_status=='1'){
                        return 'On';
                    }else{
                        return 'Off';
                    }
                }},
                { data: 'icon_status1' ,'render':function(data, type, row, meta){
                    if(row.icon_status1=='1'){
                        return 'On';
                    }else{
                        return 'Off';
                    }
                }},
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>0f32a616f35638d4e0b44c9ab643976e/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });

        $('#bazar_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>