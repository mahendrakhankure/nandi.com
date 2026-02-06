<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Matka Games
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
                     
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>0f32a616f35638d4e0b44c9ab643976e/<?php echo $onegamedata['id']; ?>" method="post" role="form" enctype="multipart/form-data">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="bazar_name">Bazar Name</label>
                                        <?php echo form_error('bazar_name'); ?>
                                        <input type="text" class="form-control required" value="<?php echo $onegamedata['bazar_name']; ?>" id="bazar_name" name="bazar_name" maxlength="50">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="open_time">Start Time</label>
                                        <?php echo form_error('open_time'); ?>
                                        <input type="time" class="form-control required" id="open_time" value="<?php echo $onegamedata['open_time']; ?>" name="open_time">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="close_time">End Time</label>
                                        <?php echo form_error('close_time'); ?>
                                        <input type="time" class="form-control required" value="<?php echo $onegamedata['close_time']; ?>" id="close_time" name="close_time">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="days">Days In Week</label><br>
                                        <?php echo form_error('days'); ?>
                                        <?php $days=explode(",", $onegamedata['days']);  ?>
                                          <select data-placeholder="Select Bazar Days" multiple class="chosen-select form-control" name="days[]">
                                            <option value="Sun" <?php if (in_array("Sun",$days)){ ?> selected <?php } ?> >Sunday</option>
                                            <option value="Mon" <?php if (in_array("Mon",$days)){ ?> selected <?php } ?>>Monday</option>
                                            <option value="Tue" <?php if (in_array("Tue",$days)){ ?> selected <?php } ?>>Tuesday</option>
                                            <option value="Wed" <?php if (in_array("Wed",$days)){ ?> selected <?php } ?>>Wednesday</option>
                                            <option value="Thu" <?php if (in_array("Thu",$days)){ ?> selected <?php } ?>>Thusday</option>
                                            <option value="Fri" <?php if (in_array("Fri",$days)){ ?> selected <?php } ?>>Friday</option>
                                            <option value="Sat" <?php if (in_array("Sat",$days)){ ?> selected <?php } ?> >Saturday</option>
                                          </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sequence">Priority</label>
                                        <?php echo form_error('sequence'); ?>
                                        <input type="text" class="form-control required digits" id="sequence" value="<?php echo $onegamedata['sequence']; ?>" name="sequence" onkeypress="return isNumber(event)" maxlength='2'>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Result Mode</label>
                                        <?php echo form_error('status'); ?>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="0">Select Mode...</option>
                                            <option value="A" <?php if ($onegamedata['status'] == 'A'){ ?> selected <?php } ?> >Active</option>
                                            <option value="I" <?php if ($onegamedata['status'] == 'I'){ ?> selected <?php } ?> >Inactive</option>
                                            <option value="Auto" <?php if ($onegamedata['status'] == 'Auto'){ ?> selected <?php } ?> >Auto</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Delar Image</label>
                                        <?php echo form_error('bazar_image'); ?>
                                        <input type="file" class="form-control required digits" id="delar_image" value="<?php echo $onegamedata['bazar_image']; ?>" name="delar_image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Profit</label>
                                        <?php echo form_error('profit'); ?>
                                        <input type="number" class="form-control required digits" id="profit" value="<?php echo $onegamedata['profit']; ?>" name="profit"">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Akda Cutting(%)</label>
                                        <?php echo form_error('cutAk'); ?>
                                        <input type="number" class="form-control required digits" id="cutAk" value="<?php echo $onegamedata['cutAk']; ?>" name="cutAk">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Jodi Cutting(%)</label>
                                        <?php echo form_error('cutJodi'); ?>
                                        <input type="number" class="form-control required digits" id="cutJodi" value="<?php echo $onegamedata['cutJodi']; ?>" name="cutJodi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Patti SP Cutting(greater than)</label>
                                        <?php echo form_error('cutSp'); ?>
                                        <input type="number" class="form-control required digits" id="cutSp" value="<?php echo $onegamedata['cutSp']; ?>" name="cutSp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Patti DP Cutting(greater than)</label>
                                        <?php echo form_error('cutDp'); ?>
                                        <input type="number" class="form-control required digits" id="cutDp" value="<?php echo $onegamedata['cutDp']; ?>" name="cutDp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Patti TP Cutting(greater than)</label>
                                        <?php echo form_error('cutTp'); ?>
                                        <input type="number" class="form-control required digits" id="cutTp" value="<?php echo $onegamedata['cutTp']; ?>" name="cutTp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bazar_type">Bazar Type</label>
                                        <?php echo form_error('bazar_type'); ?>
                                        <select class="form-control required" id="bazar_type" name="bazar_type">
                                            <option>Select Mode...</option>
                                            <option value="Home" <?php if ($onegamedata['bazar_type'] == 'Home'){ ?> selected <?php } ?> >Home</option>
                                            <option value="InHome" <?php if ($onegamedata['bazar_type'] == 'InHome'){ ?> selected <?php } ?> >In Home</option>
                                            <option value="Out" <?php if ($onegamedata['bazar_type'] == 'Out'){ ?> selected <?php } ?> >Out</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                            if($onegamedata['bazar_image'])
                                                echo '<img src="'.base_url().$onegamedata['bazar_image'].'" alt="'.$onegamedata['bazar_name'].'" width="200" height="200">';
                                        ?>
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