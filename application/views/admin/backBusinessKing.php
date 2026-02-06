<?php include 'includes/header.php'; ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <h3>Back Business King Bazar</h3>
                <div class="col-md-4 offset-md-8">
                    <form role="form" action="<?= base_url(); ?>24a61b8dcaa54223fff747ea2c6fb72d" method="post">
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