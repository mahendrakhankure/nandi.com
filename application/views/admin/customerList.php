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
                                <select class="form-control" aria-label="Default select example" id="ud">
                                    <option value=''>All</option>
                                    <option value='N'>Original</option>
                                    <option value='D'>Deducted</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="app" placeholder="Search App"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Search Name"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="customer_id" placeholder="Search Customer ID"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="Search Email"/>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Customer ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>App</th>
                      <th>Email</th>
                      <th>State</th>
                      <th>City</th>
                      <th>Status</th>
                      <th>Signup Date</th>
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
              'url':'<?=base_url()?>f475344d3c18a6b3a211b4fed6f12458',
              'data': function(data){

                    data.app = $('#app').val();
                    data.name = $('#name').val();
                    data.email = $('#email').val();
                    data.customer_id = $('#customer_id').val();
                    data.ud = $('#ud').val();
              }
            },
            'columns': [
                { data: 'id' },
                { data: 'customer_id' },
                { data: 'name' },
                { data: 'mobile' },
                { data: 'app' },
                { data: 'email' },
                { data: 'state' },
                { data: 'city' },
                { data: 'status' },
                { data: 'signup_date' }
                    
            ]
        });

        $('#app,#name,#customer_id,#email,#ud').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>