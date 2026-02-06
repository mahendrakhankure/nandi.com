<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <section class="content-header">
      <div>
        <h1>
            <i class="fa fa-users"></i> Manage Currency
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>12e4d3aae35cd3fe83683f96c7e91ae3/0"><i class="fa fa-plus"></i> Add Currency Rate</a>
      </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Country</th>
                      <th>Currency</th>
                      <th>Min Bet Limit</th>
                      <th>Currency Rate</th>
                      <th>Updated</th>
                      <th>Action</th>
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
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>86c774568bf0aa9c94c15cc1cdb5f508',
              'data': function(data){
              }
            },
            'columns': [
                { data: 'id' },
                { data: 'country' },
                { data: 'currency' },
                { data: 'minBetLimit' },
                { data: 'currencyRate' },
                { data: 'updated' },
                { data: 'action','render':function(data, type, row, meta){
	         		return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>12e4d3aae35cd3fe83683f96c7e91ae3/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i>';
	         	} }
            ]
        });

        $('#app,#name,#customer_id,#email,#ud').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>