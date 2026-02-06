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
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>795fe65fb3eeb88fa7310a56502afbff/<?php echo $onegamedata['id']; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bazar_name">Bazar Name</label>
                                        <select class="form-control" id="bazar_name" name="bazar_name" required>
                                            <option value="">Select Bazar Name...</option>
                                            <?php foreach ($bhavList as $stargame) { ?>
                                                <option value="<?php echo $stargame['id']; ?>" <?php if ($onegamedata['bazar_name'] == $stargame['id']){ ?> selected <?php } ?> ><?php echo $stargame['bazar_name']; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="game_type">Game Type</label>
                                        <select class="form-control" id="game_type" name="game_type" required>
                                            <option value="">Game Type...</option>
                                                <option value="1" <?php if ($onegamedata['game_type'] == "1"){ ?> selected <?php } ?> >First Digit(Ekai)</option>
                                                <option value="2" <?php if ($onegamedata['game_type'] == "Second Digit(Haruf)"){ ?> selected <?php } ?> >Second Digit(Haruf)</option>
                                                <option value="3" <?php if ($onegamedata['game_type'] == "3"){ ?> selected <?php } ?> >Jodi</option>   
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Bhav</label>
                                        <input type="text" class="form-control" value="<?php echo $onegamedata['rate']; ?>" id="rate" name="rate" required onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                                <div class="col-md-6">
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