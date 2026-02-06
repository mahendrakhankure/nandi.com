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
                <i class="fa fa-users"></i> Manage Bazar Rate
                <small>Add, Edit, Delete</small>
            </h1>
        </div>
        <div class="form-group add-button">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>fe51185ebf4796c15924a4d75baef204/0"><i class="fa fa-plus"></i> Add Bazar Rate</a>
        </div>
    </section>
    <section class="content">
        <div class="rows">
            <div class="col-12">
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
                                    <option value=''>Search Bazar Name</option>
                                    <?php
                                        foreach ($type as $b) {
                                            echo '<option value="'.$b['id'].'">'.$b['game_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bazar Name</th>
                      <th>Game Name</th>
                      <th>Commission</th>
                      <th>Rate</th>
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
            'order': [[1, 'desc']],
            'pageLength':25,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>ac947e65b4985f0215ded1582c2ef6cd',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
                    data.game_name = $('#game_name').val();
              }
            },
            'columns': [
                { data: 'sr' },
                { data: 'bazar_name' },
                { data: 'game_name' },
                { data: 'commission' },
                { data: 'rate' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>fe51185ebf4796c15924a4d75baef204/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });

        $('#bazar_name,#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>