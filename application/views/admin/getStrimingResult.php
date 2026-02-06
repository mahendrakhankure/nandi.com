<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Get Striming Result
        <small>Regular / Starline / King bazar</small>
      </h1>
    </section>
    <?php   
        $error = $this->session->flashdata('error');
        if($error){
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
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>f4993364a3d838b4174d4a40bd82604f" method="post" role="form">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="days">Market</label><br>
                                          <select data-placeholder="Select Market" class="chosen-select form-control" name="market" onchange="checkMarket(this.value)">
                                            <option value="regular">Regular</option>
                                            <option value="starline">Starline</option>
                                            <option value="king">King Bazar</option>
                                          </select>
                                    </div>
                                    <div class="form-group" id="oc">
                                        <label class="radio-inline"></label>
                                        <input type="radio" name="optradio" value="Open">Open
                                        <label class="radio-inline"></label>
                                        <input type="radio" name="optradio" value="Close">Close
                                    </div>
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <?php echo form_error('close_time'); ?>
                                        <input type="text" class="form-control required" id="token" name="token">
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
        </div>    
    </section>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    function checkMarket(val){
        if(val=='regular'){
            $('#oc').show();
        }else{
            $('#oc').hide();
        }
    }
</script>