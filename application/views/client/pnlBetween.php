<?php include 'includes/header.php'; ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <form>
                      <div class="form-group">
                        <label for="daterange">Date</label>
                        <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
                        <small id="emailHelp" class="form-text text-muted">Enter From Date And To Date.</small>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="dome"></div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>

<script>
    $(function () {
        $('#submit').bind('click', function (event) {
        event.preventDefault();
        var formData = {
          date: $("#dateRange").val(),
        };
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>4c0958082ad28b171c7888d8c9846c95",
            data: formData,
            success: function (res) {
                $('#dome').html('');
                $('#dome').append(res);
            }
          });
        });
    });
</script>