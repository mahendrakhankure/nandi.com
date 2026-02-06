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
                <i class="fa fa-users"></i> Manage Buffer Video
                <small>Add, Edit, Delete</small>
            </h1>
        </div>
        <div class="form-group add-button">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>e78040d41159a2b2143250b07eff78ac/0"><i class="fa fa-plus"></i> Add Video</a>
        </div>
    </section>
    <section class="content">
        <div class="rows">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" aria-label="Default select example" id="patti">
                                    <option value="">Select Patti...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="link" id="link">
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Patti</th>
                      <th>Link</th>
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
              'url':'<?=base_url()?>29c84e979cf8e713d94bf77a3cdba080',
              'data': function(data){
                    data.patti = $('#patti').val();
                    data.link = $('#link').val();
              }
            },
            'columns': [
                // { data: 'sr' },
                {"title": "Sr.",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'patti' },
                { data: 'link'  ,'render':function(data, type, row, meta){
                    return '<video width="200" height="200" controls><source src="'+row.link+'" type="video/mp4"><source src="'+row.link+'" type="video/ogg"></video>';
                }},
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>e78040d41159a2b2143250b07eff78ac/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });

        $('#patti,#link').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
        var patti = allPatti();
        var d = '';
        $(patti).each(function(l) {
            d += '<option id="'+patti[l]+'">'+patti[l]+'</option>';
        });
        $('#patti').append(d);
    });
</script>