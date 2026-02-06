<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>NANDI | Admin System Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

   
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <style>
    .nC{
      color:#3c8dbc !important;
    }
    /* #otp,#submit{
      display:none;
    } */
  </style>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0)" class='nC'><b>NANDI</b><br>Admin System</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg nC">Sign In</p>
        <?php //$this->load->helper('form'); ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php
        //$this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error; ?>                    
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>                    
            </div>
        <?php } ?>
        <form action="<?php echo base_url(); ?>95dfb6e273f059ca76e2e35750819ed3" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email" id="email" name="email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback" id="password">
            <input type="number" class="form-control" placeholder="password" name="password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>  -->                       
            </div>
            <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" id="submit" value="Sign In" />
            </div><!-- /.col -->
          </div>
        </form>
        <!-- <button class="btn btn-primary btn-block btn-flat" id="sendOtp">Send Otp</button> -->

        <!-- <a href="<?php echo base_url() ?>forgotPassword">Forgot Password</a><br> -->
        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>
<script>
  $('#sendOtp').click(()=>{
    const email = $('#email').val();
    if(email){
      $('.flexbox').show();
      $.ajax({
        type: "POST",
        url: "<?=base_url();?>"+"1828962beb83c30f2541d601ea2b4251a",
        data: {email:email},
        success: function (res) {
            $('.flexbox').hide();
            var data = jQuery.parseJSON(res);
            console.log(data['status'])
            if(data['status']==200){
                $('.flexbox').hide();
                $('#submit').show();
                $('#email').removeAttr('readonly');
                $('#otp').show();
                $('#sendOtp').hide();
                
                // $("#myForm").hide();
                success(data['message']);
            }else{
                $('.flexbox').hide();
                alert(data['message']);
            }
        },
        error: function (err){
          alert(err)
        }
      });
    }
  })
</script>