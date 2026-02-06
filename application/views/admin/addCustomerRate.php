<?php 
    include 'includes/header.php'; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Customer Rate
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
                        <h3 class="box-title">Enter Rate</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>762a1c6be55b9a89fceffe61a6666aa2" method="post" role="form">
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="customer_id">Client Name</label>
                                        <select class="form-control" id="client_name" name="client_name" required>
                                            <option value="">Select Client...</option>
                                            <?php foreach ($client as $cl) { ?>
                                                <option value="<?php echo $cl['id']; ?>" <?php if ($onegamedata['client_name'] == $cl['id']){ ?> selected <?php } ?> ><?php echo $cl['client_name']; ?></option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="customer_id">Customer Id</label>
                                        <input type="text" class="form-control required" value="<?php echo $onegamedata['customer_id']; ?>" id="customer_id" name="customer_id" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="text" class="form-control required" value="<?php echo $onegamedata['rate']; ?>" id="rate" name="rate" maxlength="5" onkeypress="return isNumber(event)">
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
        </div>    
    </section>
    
</div>
<?php include 'includes/footer.php'; ?>