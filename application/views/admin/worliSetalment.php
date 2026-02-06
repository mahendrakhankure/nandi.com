<?php 
    include 'includes/header.php'; 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Worli Settlement Games
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
                    <form role="form" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="bazar_name">Round Id</label>
                                        <?php echo form_error('bazar_name'); ?>
                                        <input type="number" class="form-control required" value="" id="round_id" name="round_id" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <span class="btn btn-primary" id="submit">Submit</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $('#submit').click(function(){
        var id = $('#round_id').val();
        if(id==''){
            alert('Plese Fill Round ID.')
        }else{
            $.ajax({
                type: "POST",
                url: base_url+'/5e1e2ea84d99f30fb324ceb6c034583e',
                data:{id:id},
                success: function (res) {
                    var r = JSON.parse(res);
                    $('#round_id').val('');
                    alert(r.massage)
                    // var d = jQuery.parseJSON(res);
                    // if(d.gameId!='' && d.gameScore!=''){
                    //     d.TableID='Matka-1';
                    //     d.GameId=id;
                    //     d.CardScore=d.gameScore;
                    //     $.ajax({
                    //         type: "POST",
                    //         url: base_url+'/6d672c14ad6348f4154754d0f5fda34b',
                    //         // url: base_url+'/de2747cd14c59e90e13aa2e40393936d',
                    //         data: JSON.stringify(d),
                    //         success: function (r) {
                    //             var d = jQuery.parseJSON(r);
                    //             if(d.status==200){
                    //                 success("Result Updated Successfully.");
                    //             }else{
                    //                 error('Somthing Went Wrong');
                    //             }

                    //             $('#round_id').val('');
                    //             alert(d.massage)
                    //         }
                    //     });
                    // }else{
                    //     error('Somthing Went Wrong');
                    // }
                }
            });
        }
    });
</script>