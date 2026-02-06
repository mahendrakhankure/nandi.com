<?php include 'includes/header.php'; ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <h3>Back Business Regular</h3>
                <div class="col-md-4 offset-md-8">
                    <!-- <form role="form" action="<?= base_url(); ?>48dcc5c6511a02fd2229d34703910a24" method="post"> -->
                      <div class="form-group">
                        <label for="daterange">Date</label>
                        <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                        <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <div id="dome"></div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>
<script>
    $('#submit').click(function (){
        $('.flexbox').show();
        
        $.ajax({
            type: "POST",
            url: base_url+"/48dcc5c6511a02fd2229d34703910a24",
            data: {dateRange:$('#dateRange').val()},
            success: function (res) {
                $('.flexbox').hide();
                var data = jQuery.parseJSON(res);
                $('#dome').empty()
                $('#dome').append(data)
            }
        });
    })
</script>