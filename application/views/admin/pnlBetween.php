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
                        <div class="form-group">
                            <label for="game_in_week">Client Name</label>
                            <select class="form-control" id="clientName" name="client_name">
                                <option value="">Select Client...</option>
                                <?php foreach ($client as $c) { ?>
                                    <option value="<?php echo $c['id']; ?>"><?= $c['client_name']; ?></option>
                                <?php } ?>    
                            </select>
                        </div>

				<!-- <div class="form-group">
                            <label for="game_in_week">Bazar Name</label>
                            <select class="form-control" id="bazarName" name="bazar_name">
                                <option value="">Select Bazar...</option>
                                <?php foreach ($bazar as $b) { ?>
                                    <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                                <?php } ?>    
                            </select>
                        </div> -->

                      <!-- <div class="form-group">
                        <label for="daterange">Client</label>
                      </div> -->
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
        $('.flexbox').show();
        event.preventDefault();
        var formData = {
          date: $("#dateRange").val(),
          clientName: $("#clientName").val(),
	    bazarName: $("#bazarName").val(),
        };
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>2aefee78dca1a4a40b110f5694960d8b",
            data: formData,
            success: function (res) {
                $('#dome').html('');
                $('#dome').append(res);
                $('.flexbox').hide();
            }
          });
        });
    });
</script>