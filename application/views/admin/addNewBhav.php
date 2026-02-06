<?php 
    include 'includes/header.php';
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Starline Bhav
        <small>Add / Edit Bhav</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Bhav</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php //pr($onegamedata); ?>
                    <?php //$this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>5799688ce86ca0aeee3a5db6e27dae22/<?php echo $onegamedata['id']; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="game_name">Bazar Name</label>
                                        <select class="form-control" id="bazar_name" name="bazar_name" required>
                                            <option value="">Select Bazar Name...</option>
                                            <?php foreach ($bazarList as $stargame) { ?>
                                                <option value="<?php echo $stargame['id']; ?>" <?php if ($onegamedata['bazar_name'] == $stargame['id']){ ?> selected <?php } ?> ><?php echo $stargame['bazar_name']; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="game_name">Game Name</label>
                                        <select class="form-control" id="game_name" name="game_name" required>
                                            <option value="">Select Game Name...</option>
                                            <?php foreach ($gameList as $game) { ?>
                                                <option value="<?php echo $game['id']; ?>" <?php if ($onegamedata['game_name'] == $game['id']){ ?> selected <?php } ?> ><?php echo $game['game_name']; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Bhav</label>
                                        <input type="text" class="form-control required" value="<?php echo $onegamedata['rate']; ?>" id="rate" name="rate" required onkeypress="return isNumber(event)" maxlength='4'>
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