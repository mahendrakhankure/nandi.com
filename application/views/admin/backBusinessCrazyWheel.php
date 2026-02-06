<?php include 'includes/header.php'; ?>
<style>
    table{
        text-align:center;
    }
</style>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <h3>Back Business Crazy Wheel</h3>
                <div class="col-md-4 offset-md-8">
                      <div class="form-group">
                        <label for="daterange">Date</label>
                        <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                        <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submit">Submit</button>
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
            url: base_url+"/4cc076a6c888b77de68c248073c96fbd",
            data: {dateRange:$('#dateRange').val()},
            success: function (res) {
                $('.flexbox').hide();
                console.log(res)
                var data = jQuery.parseJSON(res);
                $('#dome').empty()
                $('#dome').append(data)
            }
        });
    })
</script>