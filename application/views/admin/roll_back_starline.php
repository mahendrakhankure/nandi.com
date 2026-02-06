<?php 

    include 'includes/header.php'; 

?>



<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <i class="fa fa-users"></i> Starline Bazar Result Roll Back

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

                    

                    <form role="form" id="addUser" action="<?php echo base_url(); ?>e7c0c0ac654bb6980952235a04ffe26e/<?php echo $result['id']; ?>" method="post" role="form">

                        <div class="box-body">



                            <div class="row">



                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="game_in_week">Bazar Name</label>
                                        <input type="text" class="form-control required" value="<?=$result['bazar_name'];   ?>" id="bazar_name" name="bazar_name" readonly="true">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="result_date">Result Date</label>
                                        <input type="text" class="form-control required" value="<?=$result['result_date']; ?>" id="result_date" name="result_date" readonly="true">

                                    </div>

                                </div>



                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="result_close">Time</label>
                                        <input type="text" class="form-control required" value="<?=$result['time']; ?>" id="time" name="time" readonly="true">
                                    </div>

                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="result_open">Patti</label>

                                        <input type="text" class="form-control required" id="result_patti" value="<?php echo $onegamedata['result_patti']; ?>" name="result_patti" maxlength='3' minlength="3" onkeypress="return isNumber(event)" required>

                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="result_akda">Akda</label>
                                        <input type="text" class="form-control required" id="result_akda" value="<?php echo $onegamedata['result_akda']; ?>" name="result_akda" readonly maxlength='1' required>
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
    $(document).on("keyup", "#result_patti", function() {
        var openVal = $("#result_patti").val();
        if(openVal != '' && openVal != undefined && openVal.length == 3){
           var sum=0;
           var sumStr;
            for (var i = 0; i < openVal.length; i++) {
                sum += Number(openVal.charAt(i)); 
            }
            sumStr = sum.toString();
            if (sumStr.toString().length == 1) {
                $('#result_akda').val(sum);
            } else {
                $('#result_akda').val(sumStr.slice(-1));
            }
        } else {
            $('#result_akda').val('');
        }
    });
</script>