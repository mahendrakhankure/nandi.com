<?php 
    include 'includes/header.php';
    $d1 = isset($_GET['date1'])?$_GET['date1']:date('Y-m-d');
    $d2 = isset($_GET['date2'])?$_GET['date2']:date('Y-m-d');
?>
     <style type="text/css">
        .s{
            background-color: #3b9e12;
            color: #fff;
        }
        .d{
            background-color: red;
            color: #fff;
        }
        table{
            font-weight: 600;
        }
        .j{
            
            color: rgb(255, 255, 255);
            background-color: rgb(30, 140, 178);
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        #Content1, #Content2 {border-bottom: 3px solid #4588ba; margin-bottom:10px;}
        h3 {text-align:center;}
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-users"></i> Regular Out Bazar
          </h1>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <form action="" method="get">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="daterange">From Date</label>
                                <input type="date" class="form-control" name="date1" placeholder="Enter Date's" value="<?=$d1?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="daterange">To Date</label>
                                <input type="date" class="form-control" name="date2" placeholder="Enter Date's" value="<?=$d2?>" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="row" id="dom">
                    <div id="Content1"></div>
                    <h3>Patti</h3>
                    <?php 
                        foreach($bazar as $list){
                            $data = outMarketPattiCutting($d1,$d2,$list['id']);
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <a href="<?=base_url();?>f14c46a21b8f8c33edb09b186406c8ba/<?=$list['id']?>/<?=$list['bazar_name']?>">
                            <div class="p3-game-list boxRegular">
                                <p class="time"><span class="t otime"><?=date('h:i A', strtotime($list['open_time']));?></span> <span class="time-divider">|</span> <span class="t ctime"><?=date('h:i A', strtotime($list['close_time']));?></span></p>
                                <div class="inner">
                                    <h4 class="bazarName"><?=$list['bazar_name'];?></h4>
                                    <p> <span class="ctext"> Bets Settle </span> : <span class="cvalue bets"><?=empty($data['bet'])?'0':$data['bet'];?></span></p>
                                    <p> <span class="ctext"> Bets Pending </span> : <span class="cvalue bets"><?=empty($data['betP'])?'0':$data['betP'];?></span></p>
                                    <p> <span class="ctext"> Settle Amount </span> : <span class="cvalue bets"><?=empty($data['point'])?'0':$data['point'];?></span></p>
                                    <p> <span class="ctext"> Pending Amount </span> : <span class="cvalue bets"><?=empty($data['amtP'])?'0':$data['amtP'];?></span></p>
                                    <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=round($data['win'],2);?></span></p>
                                    <p> <span class="ctext"> Com </span> : <span class="cvalue bets"><?=round($data['com'],2);?></span></p>
                                    <p> <span class="ctext"> GGR+Com </span> : <span class="cvalue bets"><?=round((($data['point']-$data['win'])+$data['com']),2);?></span></p>
                                </div>
                            </div> 
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <div class="row" id="dom">
                    <div id="Content1"></div>
                    <h3>Akda+Jodi</h3>
                    <?php 
                        foreach($bazar as $list){
                            $data = outMarketJodiCutting($d1,$d2,$list['id']);
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <a href="<?=base_url();?>f14c46a21b8f8c33edb09b186406c8ba/<?=$list['id']?>/<?=$list['bazar_name']?>">
                            <div class="p3-game-list boxRegular">
                                <p class="time"><span class="t otime"><?=date('h:i A', strtotime($list['open_time']));?></span> <span class="time-divider">|</span> <span class="t ctime"><?=date('h:i A', strtotime($list['close_time']));?></span></p>
                                <div class="inner">
                                    <h4 class="bazarName"><?=$list['bazar_name'];?></h4>
                                    <p> <span class="ctext"> Bets Settle </span> : <span class="cvalue bets"><?=empty($data['bet'])?'0':$data['bet'];?></span></p>
                                    <p> <span class="ctext"> Bets Pending </span> : <span class="cvalue bets"><?=empty($data['betP'])?'0':$data['betP'];?></span></p>
                                    <p> <span class="ctext"> Settle Amount </span> : <span class="cvalue bets"><?=empty($data['point'])?'0':$data['point'];?></span></p>
                                    <p> <span class="ctext"> Pending Amount </span> : <span class="cvalue bets"><?=empty($data['amtP'])?'0':$data['amtP'];?></span></p>
                                    <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=round($data['win'],2);?></span></p>
                                    <p> <span class="ctext"> Com </span> : <span class="cvalue bets"><?=round($data['com'],2);?></span></p>
                                    <p> <span class="ctext"> GGR+Com </span> : <span class="cvalue bets"><?=round((($data['point']-$data['win'])+$data['com']),2);?></span></p>
                                </div>
                            </div> 
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>
    
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>