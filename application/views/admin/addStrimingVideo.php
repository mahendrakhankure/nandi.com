<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Buffer Videos
        <small>Add / Edit Video</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Video Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>e78040d41159a2b2143250b07eff78ac/<?php echo $onegamedata['id']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="game_in_week">Patti</label>
                                        <select class="form-control" id="patti" name="patti" required>
                                            <option value="">Select Patti...</option>
                                            <div id="getPatti"></div>   
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
                                        <input type="file" class="form-control required" id="videoFile" name="video_file" accept="video/mp4,video/x-m4v,video/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
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
<script type="text/javascript">
    $( document ).ready(function() {
        var patti = allPatti();
        var d = '';
        $(patti).each(function(l) {
            d += '<option id="'+patti[l]+'">'+patti[l]+'</option>';
        });
        $('#patti').append(d);
    });
</script>