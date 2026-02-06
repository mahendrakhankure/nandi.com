<?php 

    include 'includes/header.php'; 

?>



<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <i class="fa fa-users"></i> Manage Star Line Result

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

                    

                    <form role="form" id="addUser" action="<?php echo base_url(); ?>Manage_Starlinegameallresult/AddStartLineResult/<?php echo $onegamedata['id']; ?>" method="post" role="form">

                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="game_in_week">Bazar Name</label>

                                        <select class="form-control" id="bazar_name" name="bazar_name" required onchange="getTime(this.value)">

                                            <option value="">Select Bazar Name...</option>
                                            <?php foreach ($starlinegame as $stargame) { ?>
                                                <option value="<?php echo $stargame['id']; ?>" <?php if ($onegamedata['bazar_name'] == $stargame['id']){ ?> selected <?php } ?> ><?php echo $stargame['bazar_name']; ?></option>
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

                                        <label for="result_date">Time</label>
                                        <select class="form-control" id="bazar_time" name="time" required>
                                            <option value="">Select Time Name...</option>
                                            <div id="time"></div>
                                        </select>

                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="result_patti">Patti</label>

                                        <input type="text" class="form-control required digits" id="result_patti" value="<?php echo $onegamedata['result_patti']; ?>" name="patti" maxlength='3' onkeypress="return isNumber(event)" required>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="adka_result">Akda</label>

                                        <input type="text" class="form-control required digits" id="adka_result" value="<?php echo $onegamedata['result_akda']; ?>" name="akda" readonly onkeypress="return isNumber(event)" required>

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

<!-- <script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script> -->



<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    // $( document ).ready(function() {
    //     var op = <?= isset($onegamedata['bazar_name']) ? json_encode($onegamedata['bazar_name']) : "--"; ?>;
    //     console.log(op)
    //     if(op!='--'){
    //         $.ajax({
    //           type: "POST",
    //           url: base_url+"Manage_Starlinegameallresult/getTime",
    //           data: {id:<?= $onegamedata['bazar_name']; ?>,time:<?= $onegamedata['bazar_name']; ?>},
    //           cache: false,
    //           success: function(json){
    //             $('#bazar_time').html('');
    //             $('#bazar_time').append(JSON.parse(json));
    //           }
    //         });
    //     }
    // });
    var l = <?=$onegamedata['time'];?>+'';
    if(typeof(l) != "undefined" && l != ""){
        getTime($('#bazar_name').val());
        $('option[value=<?=$onegamedata['time'];?>]').attr('selected','selected');
        $("#bazar_time").val("<?=$onegamedata['time'];?>").change();
    }
    function getTime(evt) {
        $.ajax({
          type: "POST",
          url: base_url+"/Manage_Starlinegameallresult/getTime",
          data: {id:evt,time:''},
          cache: false,
          success: function(json){
            $('#bazar_time').html('');
            $('#bazar_time').append(JSON.parse(json));
          }
        });
    }


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
                $('#adka_result').val(sumStr);
            } else {
                $('#adka_result').val(sumStr.slice(-1));
            }
        } else {
            $('#adka_result').val('');
        }
    });
</script>