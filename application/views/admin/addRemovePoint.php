<?php 
    include 'includes/header.php';  
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Add/Remove Points
        <small>Add/Remove Points</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add/Remove Points</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php //pr($onegamedata); ?>
                    <?php //$this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>Manage_Globles/addRemovePoint/<?php echo $onegamedata['id']; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_id">Bazar Name</label>
                                        <select data-placeholder="Select User" class="form-control" name="customer_id">
                                            <option value="">Select User</option>
                                            <?php
                                                foreach($users as $list){
                                            ?>
                                                    <option value="<?=$list['customer_id']?>" <?php if ($onegamedata['customer_id']==$list['customer_id']){ ?> selected <?php } ?> ><?=$list['customer_id']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="massage">Select Type</label>
                                        <select data-placeholder="Select Type" class="form-control" name="type">
                                            <option value="">Select Type</option>
                                            <option value="A" <?php if ($onegamedata['type']=="A"){ ?> selected <?php } ?> >Add Points</option>
                                            <option value="R" <?php if ($onegamedata['type']=="R"){ ?> selected <?php } ?> >Remove Points</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="massage">Massage</label>
                                        <input type="textarea" class="form-control" value="<?php echo $onegamedata['massage']; ?>" id="massage" name="massage" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="point">Points</label>
                                    <input type="text" class="form-control" value="<?php echo $onegamedata['point']; ?>" id="point" name="point" required onkeypress="return isNumber(event)">

                                    <input type="text" class="form-control" value="<?php echo $this->session->userdata['adid']['id']; ?>" id="admin" name="admin" required>
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