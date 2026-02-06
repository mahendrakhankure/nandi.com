<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Deler Videos
        <small>Add / Edit Game</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Game Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php //pr($onegamedata); ?>
                    <?php //$this->load->helper("form"); ?>
                     
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>46f866085c79443c31667d1ad3b700e5/<?= isset($onegamedata['id'])?$onegamedata['id']:0; ?>" method="post" role="form" enctype="multipart/form-data">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="bazar_name">Patti</label>
                                        <?php echo form_error('bazar_name'); ?>
                                        <input type="text" class="form-control required" id="patti" name="patti" onkeyup="isNumber(this)" maxlength="6" minlength="3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Delars Video</label>
                                        <?php echo form_error('delar_image'); ?>
                                        <input type="file" class="form-control required digits" id="file" name="file">
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