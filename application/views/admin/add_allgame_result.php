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

                    

                    <form role="form" id="addUser" action="<?php echo base_url(); ?>Manage_Matkaallgames/AddAllGameResult/<?php echo $onegamedata['id']; ?>" method="post" role="form">

                        <div class="box-body">



                            <div class="row">



                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="game_in_week">Bazar Name</label>

                                        <select class="form-control" id="game_name" name="bazar_name" required>

                                            <option value="">Select Bazar Name...</option>

                                            <?php foreach ($matkaallgame as $matkagame) { ?>
                                                <option value="<?php echo $matkagame['id']; ?>" <?php if ($onegamedata['bazar_name'] == $matkagame['id']){ ?> selected <?php } ?> ><?= $matkagame['bazar_name']; ?></option>
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

                                        <input type="date" class="form-control required" value="<?php echo $currdate; ?>" id="result_date" name="result_date" required>

                                    </div>

                                </div>



                            </div>



                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="result_open">Open</label>

                                        <input type="text" class="form-control required" id="result_open" value="<?php echo $onegamedata['open']; ?>" name="open" maxlength='3' minlength="3" onkeypress="return isNumber(event)" required>

                                    </div>

                                </div>



                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="result_jodi">Jodi</label>
                                        <input type="text" class="form-control required" id="result_jodi" value="<?php echo $onegamedata['jodi']; ?>" name="jodi" readonly maxlength='2' required>
                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="form-group">

                                        <?php 
                                            if ($onegamedata['result_date'] != '') {
                                        ?>
                                            <label for="result_close">Close</label>
                                            <input type="text" class="form-control required" id="result_close" value="<?php echo $onegamedata['close']; ?>" name="close"  maxlength='3'  minlength="3" onkeypress="return isNumber(event)">
                                        <?php
                                            }
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
<script type="text/javascript">
    $(document).on("keyup", "#result_open", function() {
        var openVal = $("#result_open").val();
        if(openVal != '' && openVal != undefined && openVal.length == 3){
           var sum=0;
           var sumStr;
            for (var i = 0; i < openVal.length; i++) {
                sum += Number(openVal.charAt(i)); 
            }
            sumStr = sum.toString();
            if (sumStr.toString().length == 1) {
                $('#result_jodi').val(sum);
            } else {
                $('#result_jodi').val(sumStr.slice(-1));
            }
        } else {
            $('#result_jodi').val('');
        }
    });


    $(document).on("keyup", "#result_close", function() {
        var jodiVal = $("#result_jodi").val();
        var closeVal = $("#result_close").val();
        if(closeVal != '' && closeVal != undefined && closeVal.length == 3 && jodiVal.length == 1){
           var sum=0;
           var sumStr;
            for (var i = 0; i < closeVal.length; i++) {
                sum += Number(closeVal.charAt(i)); 
            }
            sumStr = sum.toString();

            if (sumStr.toString().length == 1) {
                $('#result_jodi').val(jodiVal+sum);
            } else {
                $('#result_jodi').val(jodiVal+sumStr.slice(-1));
            }
        } else {
            if(jodiVal.length == 2 && closeVal.length != 3){
                $('#result_jodi').val(jodiVal[0]);
            }
        }
    });
</script>