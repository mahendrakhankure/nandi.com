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
            <i class="fa fa-users"></i> Manage King Bazar Bhav
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>795fe65fb3eeb88fa7310a56502afbff/0"><i class="fa fa-plus"></i> Add King Bazar Bhav</a>
      </div>
    </section>
    <section class="content">
        <div class="rows">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="bazar_name">
                                <option value=''>Search Bazar Name</option>
                                <?php
                                    foreach ($bazar as $b) {
                                        echo '<option value="'.$b['id'].'">'.$b['bazar_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="game_name">
                                <option value=''>Search Game Name</option>
                                <option value='1'>First Digit(Ekai)</option>
                                <option value='2'>Second Digit(Haruf)</option>
                                <option value='3'>Jodi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bazar Name</th>
                      <th>Game Name</th>
                      <th>bhav</th>
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
              'url':'<?=base_url()?>239ef3437609e5a9ae1795724cfcbe92',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
                    data.game_name = $('#game_name').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return row.sr;
                } },
                { data: 'bazar_name' },
                { data: 'game_type' },
                { data: 'bhav' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>795fe65fb3eeb88fa7310a56502afbff/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });
        $('#bazar_name,#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>