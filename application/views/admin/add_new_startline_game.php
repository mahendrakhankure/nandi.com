<?php 
    include 'includes/header.php'; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Starline Games
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
                    
                    <form role="form" id="addUser" action="<?php echo base_url(); ?>77ea0d27f166c8231ec4a9a0861af552/<?php echo $chartGameName['id']; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="game_name">Game Name</label>
                                          <select data-placeholder="Select Bazar" class="form-control" name="bazar_name">
                                            <?php
                                                foreach($bazarList as $list){
                                            ?>
                                                    <option value="<?=$list['id']?>" <?php if ($chartGameName['id']==$list['id']){ ?> selected <?php } ?> ><?=$list['bazar_name']?></option>
                                            <?php
                                                }
                                            ?>
                                          </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div id="addmoresection">
                                <?php if ($chartGameName['id']) { ?>
                                        <div class="row" id="row_div_<?php echo $chartGameName['id']; ?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_time">Time</label>
                                                    <input type="time" class="form-control required" value="<?php echo $chartGameName['time']; ?>" id="gametime_<?php echo $chartGameName['id']; ?>" name="gametime[]">
                                                    <span style="color:red;" id="gametime_<?php echo $chartGameName['id']; ?>_error"></span>

                                                    <input type="hidden" name="timeid[]" id="timeid" value="<?php echo $chartGameName['id']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                        
                                <?php }else{ ?>
                                    <div class="row" id="row_div_1">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="end_time">Time</label>
                                                <input type="time" class="form-control required" value="" id="gametime_1" name="gametime[]">
                                                <span style="color:red;" id="gametime_1_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group" id="addmorebtndiv_1">
                                                <span type="addmorebtn" id="addmorebtn" onclick="addmoretime('1');" class="form-control btn btn-primary">Add More Time</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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

<script>
    function addmoretime(divid) {
        var newdivid = parseInt(divid) + 1;
        // alert(newdivid);
        var dametimeval = $("#gametime_"+divid).val();
        if (dametimeval == '') {
            $("#gametime_"+divid+'_error').html('Enter Time');
            $("#gametime_"+divid+'_error').show();
            return false;
        }else{
            $("#gametime_"+divid).html('');
            var html = '';
            html += '<div class="row" id="row_div_'+newdivid+'">';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label for="end_time">Time</label>';
            html += '<input type="time" class="form-control required" value="" id="gametime_'+newdivid+'" name="gametime[]">';
            html += '<span style="color:red;" id="gametime_'+newdivid+'_error"></span>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-md-3">';
            html += '</div>';

            html += '<div class="col-md-3">';
            html += '<div class="form-group" id="addmorebtndiv_'+newdivid+'">';
            html += '<span type="addmorebtn" id="addmorebtn" onclick="addmoretime(`'+newdivid+'`);" class="form-control btn btn-primary">Add More Time</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';


            $("#addmorebtndiv_"+divid).html('');

            if (parseInt(divid) != 1) {  
                $("#addmorebtndiv_"+divid).append('<span type="addmorebtn" id="addmorebtn" onclick="removeTime(`'+divid+'`);" class="form-control btn btn-danger">Remove Time</span>');   
            }

            $("#addmoresection").append(html);
        }
    }


    function removeTime(removeid) {
        $("#row_div_"+removeid).remove();
    }

    function removeTimefrmTbl(removeid) {
        $.ajax({
            type:"post",
            dataType: 'json',
            url: "<?php echo base_url(); ?>Manage_Starlinegames/removeTimefromTable",
            data:{ removeid:removeid},
            success:function(response){ 
                console.log(response);
                if (response.successmsg == 'deleted') {
                    $("#row_div_"+removeid).remove();
                }else{
                    alert('Error');
                }
            }
        }); 
    }

</script>

<?php include 'includes/footer.php'; ?>