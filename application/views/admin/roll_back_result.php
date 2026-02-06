<?php 

    include 'includes/header.php'; 

?>



<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <i class="fa fa-users"></i> Regular Bazar Result Roll Back

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

                    

                    <form role="form" id="addUser" action="<?php echo base_url(); ?>fa3f22e952b82786ee43dedb66969556/<?php echo $result['id']; ?>" method="post" role="form">

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
                                        <label for="result_close">Typee</label>
                                        <select class="form-control" id="game_type" name="game_type" required>
                                            <option value="Open">Open</option>
                                            <option value="Close">Close</option>
                                        </select>
                                    </div>

                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="result_open">Patti</label>

                                        <input type="text" class="form-control required" id="result_open" value="<?php echo $onegamedata['open']; ?>" name="open" maxlength='3' minlength="3" onkeypress="return isNumber(event)" required>

                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="result_jodi">Akda</label>
                                        <input type="text" class="form-control required" id="result_jodi" value="<?php echo $onegamedata['jodi']; ?>" name="jodi" readonly maxlength='2' required>
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
        var openVal = $("#result_close").val();
        if(openVal != '' && openVal != undefined && openVal.length == 3){
           var sum=0;
           var sumStr;
            for (var i = 0; i < openVal.length; i++) {
                sum += Number(openVal.charAt(i)); 
            }
            sumStr = sum.toString();

            if (sumStr.toString().length == 1) {
                $('#result_jodi').val(jodiVal+sum);
            } else {
                $('#result_jodi').val(jodiVal+sumStr.slice(-1));
            }
        } else {
            $('#result_jodi').val(jodiVal[0]);
        }
    });
</script>