<?php 
    include 'includes/header.php';  
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage King Bazar Bhav
        <small>Add / Bazar Bhav</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Bazar Bhav</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php //pr($onegamedata); ?>
                    <?php //$this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>Manage_Globles/addNewClient/<?php echo $onegamedata['id']; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['client_name']; ?>" id="client_name" name="client_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['mobile']; ?>" id="mobile" name="mobile" required onkeypress="return isNumber(event)" maxlength="10" minlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alternate_mobile">Alternate Mobile</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['alternate_mobile']; ?>" id="alternate_mobile" name="alternate_mobile" required onkeypress="return isNumber(event)" maxlength="10" minlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="domain">Domain</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['domain']; ?>" id="domain" name="domain" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ip_address">IP Address</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['ip_address']; ?>" id="ip_address" name="ip_address" required onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['country']; ?>" id="country" name="country" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['state']; ?>" id="state" name="state" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="percentage">Percentage</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['percentage']; ?>" id="percentage" name="percentage" maxlength='3' required onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="currency">Currency</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['currency']; ?>" id="currency" name="currency" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="currency">Currency rate</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['currancy_rate']; ?>" id="currancy_rate" name="currancy_rate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_point_url">End Point Url</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['end_point_url']; ?>" id="end_point_url" name="end_point_url" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name='status' id='status' aria-label="Default select example" value="<?php echo $onegamedata['status']; ?>" >
                                            <option value="A" <?= $onegamedata['status']=='A'?'selected="selected"':''; ?>>Active</option>
                                            <option value="I" <?= $onegamedata['status']=='I'?'selected="selected"':''; ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>