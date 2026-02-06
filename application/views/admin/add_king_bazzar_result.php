<?php 
    include 'includes/header.php'; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Bazar Result
        <small>Add / Edit Bazar Result</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Result Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>Manage_Kingbazarallresult/AddKingBazarResult/<?php echo $onegamedata['id']; ?>" method="post" role="form">
                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="game_in_week">Bazar Name</label>
                                        <select class="form-control" id="bazar_name" name="bazar_name">
                                            <option value="0">Select Bazar Name...</option>
                                            <?php foreach ($kingbazarallgame as $kingbazgame) { ?>
                                            
                                                <option value="<?php echo $kingbazgame['id']; ?>" <?php if ($onegamedata['bazar_name'] == $kingbazgame['id']){ ?> selected <?php } ?> ><?php echo $kingbazgame['bazar_name']; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>

                                <?php 
                                    if ($onegamedata['result_date'] != '') {
                                        $currdate = $onegamedata['result_date'];
                                    }else{
                                       $currdate = date('Y-m-d'); 
                                    }
                                ?>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="result_date">Result Date</label>
                                        <input type="date" class="form-control required" value="<?php echo $currdate; ?>" id="result_date" name="result_date">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="result">Result</label>
                                        <input type="text" class="form-control required digits" id="result" value="<?php echo $onegamedata['result']; ?>" name="result"  onkeypress="return isNumber(event)" maxlength="2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
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