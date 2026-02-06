<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/nC.css" rel="stylesheet" type="text/css" />
    
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
      #mysearch form {
          padding : 0px;
          border-radius : 10px 0px 0px 10px;
          border:none;
          display:inline-block;
      }
      #mysearch input, #mysearch select {
          padding: 6px 24px;
          margin: 0px 5px;
          border-radius : 10px;
          border:2px solid #3c8dbc;
      }
      #mysearch button {
          padding:  7px 21px;
          background-color: #3c8dbc;
          font-size:16px;
          color: #fff;
          border-radius:10px;
          border:none;
      }
      #mysearch button i{
          color:#fff;
          font-size: 16px;
          margin-right : 10px;
      }
      .boxRegular{
        color: #fff;
      }
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script type="text/javascript">
        // $.noConflict();
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link href="<?php echo base_url(); ?>assets/css/adminCssNew.css" rel="stylesheet" type="text/css" />
    <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
  </head>
  <?php
    $this->load->helper('data_helper');
    $this->load->helper('custom_helper');
  ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>CI</b>AS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown tasks-menu">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"> Last Login : <i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>login/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo base_url(); ?>admin/dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>831889aa06026edc2a57fce35fad5b70">
                <i class="fa fa-area-chart"></i> <span>Analysis</span></i>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>cb5ef3113af9fe69edca229f43c878ec">
                <i class="fa fa-free-code-camp" aria-hidden="true"></i> <span>Regular Market</span></i>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>bc0e5c2a1b60667c665944ed13a47e4b">
                <i class="fa fa-star-half-o"></i> <span>Starline Market</span></i>
              </a>
            </li>

            <li>
              <a href="<?php echo base_url(); ?>e2fcdfc449fc439efc025b14edb93cb3">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i> <span>King Market</span></i>
              </a>
            </li>
            <!-- start html for Gemes -->
            <!-- <li>
              <a href="javascript:void(0)" >
                <i class="fa fa-plane"></i>
                <span>Games Section</span>
              </a>
            </li> -->
            <!-- end html for Gemes -->

            <!-- <li>
              <a href="javascript:void(0)" >
                <i class="fa fa-ticket"></i>
                <span>My Tasks</span>
              </a>
            </li> -->

            <!-- start code for Matka Game -->
            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-gamepad" aria-hidden="true"></i> <span>Matka Game</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url(); ?>a429d046df97a54547ae9f9b523bb904"><i class="fa fa-circle-o"></i> All Bazar</a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>f2356c74eddd4a15682b144eaacb3071"><i class="fa fa-circle-o"></i>All Result</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>ac947e65b4985f0215ded1582c2ef6cd"><i class="fa fa-circle-o"></i>All Bazar Rate</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>495422a2a9c4fef025803d9180abc03b"><i class="fa fa-circle-o"></i>All Game Type</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>b61f5c1def0540c5dd1b6e2bb0787986"><i class="fa fa-circle-o"></i>All Bets</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>48dcc5c6511a02fd2229d34703910a24"><i class="fa fa-circle-o"></i>Back Business</a>
                </li>
                <!-- <li>
                  <a href="<?php echo base_url();?>Manage_Matkagames/AllotBazarGamesList"><i class="fa fa-circle-o"></i>Allot Bazar Games</a>
                </li> -->
              </ul>
            </li>
            <!--end code for Matka Game -->


            <!-- start code for Starline Game -->
            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-star fa-fw"></i> <span>Starline Game</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url();?>7932304afa07498c9b2b9cd3954c33d7"><i class="fa fa-circle-o"></i>All Bazar</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>0b1a4cf7c60a831e444002c6fdde6f8f"><i class="fa fa-circle-o"></i>All Bazar Time</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>086a938697cd6feb6d062e6fd0c5c845"><i class="fa fa-circle-o"></i>All Result</a>
                  <!-- <a href="<?php echo base_url();?>Manage_Starlinegameallresult"><i class="fa fa-circle-o"></i>All Result</a> -->
                </li>
                <li>
                  <a href="<?php echo base_url();?>bc81603a6bb850328fa301e58be072ed"><i class="fa fa-circle-o"></i>All Bhav</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>bc5b398327e1377d15fb309a07d92e8b"><i class="fa fa-circle-o"></i>All Game Type</a>
                  <!-- <a href="<?php echo base_url();?>Manage_Starlinegames/gameTypeList"><i class="fa fa-circle-o"></i>All Game Type</a> -->
                </li>
                <li>
                  <a href="<?php echo base_url();?>5e2166103d8c6d0514466533c633e35d"><i class="fa fa-circle-o"></i>All Bets</a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>5b219095e82147b46456272433496446"><i class="fa fa-circle-o"></i>Back Business</a>
                </li>
              </ul>
            </li>
            <!--end code for Starline Game -->


             <!-- start code for King Bazar Game -->
            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-rebel fa-fw"></i> <span>King Bazar Game</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url(); ?>Manage_Kingbazargames"><i class="fa fa-circle-o"></i>All Bazar</a></li>
                <li><a href="<?php echo base_url(); ?>239ef3437609e5a9ae1795724cfcbe92"><i class="fa fa-circle-o"></i>All Bazar Rate</a></li>
                <li>
                  <!-- <a href="<?php echo base_url(); ?>Manage_Kingbazarallresult"><i class="fa fa-circle-o"></i>All Result</a> -->
                  <a href="<?php echo base_url(); ?>721466737f6712c1f81542599265fd77"><i class="fa fa-circle-o"></i>All Result</a>
                </li>
                <li><a href="<?php echo base_url(); ?>651772891eada9a008917427f34f6d4f"><i class="fa fa-circle-o"></i>All Bets</a></li>
                <li>
                  <a href="<?php echo base_url();?>24a61b8dcaa54223fff747ea2c6fb72d"><i class="fa fa-circle-o"></i>Back Business</a>
                </li>
              </ul>
            </li>


            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-circle-o-notch"></i> <span>Crazy Matka</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url(); ?>65d1bb984c381c800f07280f66bd67dc">
                    <i class="fa fa-circle-o"></i>
                    Crazy Matka Result List
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>47c153ee854c6720c1b154ef62c3f6e7">
                    <i class="fa fa-circle-o"></i>
                    Crazy Matka Game List
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>c8cabfd9a100704c8451b942bc8f1029">
                    <i class="fa fa-circle-o"></i>
                    Crazy Matka Rate1
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>4cc076a6c888b77de68c248073c96fbd">
                    <i class="fa fa-circle-o"></i>
                    Back Business
                  </a>
                </li>
              </ul>
            </li>
            <!-- <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-rebel fa-fw"></i> <span>GoldenTable Bazar Game</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url(); ?>638d33c008cb5bd15e689fe963393ccb">
                    <i class="fa fa-circle-o"></i>
                    GoldenTable All Bets
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>49eef90ad0722ab54d478353bc7e0cfb">
                    <i class="fa fa-circle-o"></i>
                    GoldenTable Bhav
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url();?>e4d81e8a2e862b27b97d6e93c5878c54">
                    <i class="fa fa-circle-o"></i>
                    GoldenTable Result
                  </a>
                </li>
              </ul>
            </li> -->
            
            <!--end code for King Bazar Game -->
            <!-- <li>
              <a href="<?php echo base_url(); ?>0014fbc9f53bc70c4ae5f9d47aa2b5c9"><i class="fa fa-circle-o"></i>All Bets Worli</a>
            </li> -->
            <li>
              <a href="<?php echo base_url(); ?>d7ddb6f2c724eb31ec676b5a2b8ee3ba"><i class="fa fa-circle-o"></i>Todays Participents</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>bff07cc69563fe06d2260c6766e80a59"><i class="fa fa-circle-o"></i>Todays Winner</a>
            </li>
            <!-- start code for Global -->
            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-globe"></i> <span>Global</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url(); ?>d383679f6c7f94714026d747f9f77f33"><i class="fa fa-circle-o"></i>Bazar Back Business</a>
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>e2392d2c34003606d9478ac36e766e40"><i class="fa fa-circle-o"></i>Holidays</a>
                </li>
                <li>
                  <a href="<?=base_url()?>ea8121ad3617938478e90e8a81a1b058"><i class="fa fa-circle-o"></i>Check Market Cutting</a>
                </li>
              </ul>
            </li>
            <!--end code for Global -->

            <!-- start code for Pnl's -->
            <li class="treeview">
              <a href="javascript:void(0)">
                <i class="fa fa-calculator"></i> <span>Pnl's</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url(); ?>2aefee78dca1a4a40b110f5694960d8b"><i class="fa fa-circle-o"></i> All Bazar</a>
                </li>
              </ul>
            </li>
            
            <li><a href="<?=base_url()?>de42a3f3870e91622ccb9c71af924f19"><i class="fa fa-lock"></i>Change Password</a></li>
            <!--end code for Pnl's -->
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <div class="flexbox"style='position: fixed; z-index: 999999; top: 0; left: 0; right: 0;bottom: 0;'>
        <div style='height: 100vh;'>
            <div class="multi-spinner-container" style='top: 40%;'>
              <div class="multi-spinner">
                <div class="multi-spinner">
                  <div class="multi-spinner">
                    <div class="multi-spinner">
                      <div class="multi-spinner">
                        <div class="multi-spinner">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>