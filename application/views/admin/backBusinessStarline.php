<?php include 'includes/header.php'; ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <h3 style="text-align: center;">Starline Back Business</h3>
                <div class="col-md-4 offset-md-8">
                    <form role="form" action="<?= base_url(); ?>5b219095e82147b46456272433496446" method="post">
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