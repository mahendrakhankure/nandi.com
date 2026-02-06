<?php 
    include 'includes/header.php';
?>
 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    <?php
      if($_SESSION['adid']['id']==1 || $_SESSION['adid']['id']==26){
    ?>
      <section class="content">
          <div class="container-fluid">
            <div class="row">
                <div class="col-lg-43 col-md-3 col-sm-6 col-xs-12">
                  <div class="small-box mycard">
                    <div class="inner">
                      <h4 class="text-center">All Regular Bets</h4>
                      <?php
                        $r = getData('regular_bazar_games',$feild,$con,'One');
                      ?>
                      <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$regular['id']?></span></p>
                      <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$r->idP?></span></p>
                      <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($regular['point'],2)?></span></p>
                      <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?= $r->pending;?></span></p>
                      <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($regular['win'])?></span></p>
                      <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($regular['com'])?></span></p>
                      <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$regular['player']?></span></p>
                      <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?= $r->playerP;?></span></p>
                      <p> <span class="ctext"> GGR</span> : <span class="cvalue bets"><?=round($regular['point']-$regular['win'])?></span></p>
                      <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round(($regular['point']-$regular['win'])+$regular['com'])?></span></p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="small-box mycard">
                    <div class="inner">
                      <h4 class="text-center">All Starline Bets</h4>
                      <?php
                        $s = getData('starline_bazar_game',$feild,$con,'One');
                        // die();
                      ?>
                      <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$star['id']?></span></p>
                      <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$s->idP?></span></p>
                      <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($star['point'],2)?></span></p>
                      <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?= $s->pending;?></span></p>
                      <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($star['win'])?></span></p>
                      <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($star['com'])?></span></p>
                      <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$star['player']?></span></p>
                      <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?= $s->playerP;?></span></p>
                      <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($star['point']-$star['win'])?></span></p>
                      <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round(($star['point']-$star['win'])+$star['com'])?></span></p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="small-box mycard">
                    <div class="inner">
                      <h4 class="text-center">All King Bets</h4>
                      <?php
                        $k = getData('king_bazar_game',$feild,$con,'One');
                      ?>
                      <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$king['id']?></span></p>
                      <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$s->idP?></span></p>
                      <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($king['point'],2)?></span></p>
                      <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?= $s->pending;?></span></p>
                      <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($king['win'])?></span></p>
                      <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($king['com'])?></span></p>
                      <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$king['player']?></span></p>
                      <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?= $s->playerP;?></span></p>
                      <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($king['point']-$king['win'])?></span></p>
                      <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round(($king['point']-$king['win'])+$king['com'])?></span></p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="small-box mycard">
                      <div class="inner">
                        <h4 class="text-center">Instant Worli Day Bets</h4>
                        <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$worli['id']?></span></p>
                        <p> <span class="ctext"> Points </span> : <span class="cvalue bets"><?=$worli['point']?></span></p>
                        <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($worli['win'])?></span></p>
                        <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($worli['com'])?></span></p>
                        <p> <span class="ctext"> Players </span> : <span class="cvalue bets"><?=$worli['player']?></span></p>
                        <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($worli['point']-$worli['win'])?></span></p>
                        <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round(($worli['point']-$worli['win'])+$worli['com'])?></span></p>
                        <p> <span class="ctext"></p>
                        <p> <span class="ctext"></p>
                        <p> <span class="ctext"></p>
                        <p> <span class="ctext"></p>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
              </div>
              <div class="row">
                <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <div class="small-box mycard">
                    <div class="inner">
                      <h4 class="text-center">Instant Worli Night Bets</h4>
                      <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$redTable['id']?></span></p>
                      <p> <span class="ctext"> Points </span> : <span class="cvalue bets"><?=$redTable['point']?></span></p>
                      <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($redTable['win'])?></span></p>
                      <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($redTable['com'])?></span></p>
                      <p> <span class="ctext"> Players </span> : <span class="cvalue bets"><?=$redTable['player']?></span></p>
                      <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($redTable['point']-$redTable['win'])?></span></p>
                      <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round(($redTable['point']-$redTable['win'])+$redTable['com'])?></span></p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <div class="small-box mycard">
                    <div class="inner">
                      <h4 class="text-center">All Instant Worli GGR</h4>
                      <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$worli['id']+$redTable['id']?></span></p>
                      <p> <span class="ctext"> Points </span> : <span class="cvalue bets"><?=$worli['point']+$redTable['point']?></span></p>
                      <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($worli['win']+$redTable['win'])?></span></p>
                      <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round(($worli['com']+$redTable['com']))?></span></p>
                      <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($worli['point']+$redTable['point'])-($worli['win']+$redTable['win']))?></span></p>
                      <p> <span class="ctext"> GGR+Commission</span> : <span class="cvalue bets"><?=round((($worli['point']+$redTable['point'])-($worli['win']+$redTable['win']))+($worli['com']+$redTable['com']))?></span></p>
                      <p> <span class="ctext">  </span>  <span class="cvalue bets"></span></p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div> -->
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="small-box mycard">
                  <div class="inner">
                    <h4 class="text-center">Crazy Wheel Bets</h4>
                    <?php
                      $crazyWheelFeild = 'COUNT(DISTINCT round_id) as playedRound,SUM(point_in_rs) as point,COUNT(id) as id, COUNT(DISTINCT customer_id) as player,SUM(commission_in_rs) as com,SUM(winning_in_rs) as win';
                      $crazyWheelCon = ' WHERE result_date="'.date('Y-m-d').'" AND status!="P"';
                      $crazyWheel = getData('crezyMatkaGame',$crazyWheelFeild,$crazyWheelCon,'One');
                      $crazyWheelRound = getData('crezyMatkaResult','COUNT(id) as totalRound',' WHERE result_date="'.date('Y-m-d').'"','One');
                    ?>
                    <p> <span class="ctext"> Bets</span> : <span class="cvalue bets"><?=$crazyWheel->id?></span></p>
                    <p> <span class="ctext"> Total Round</span> : <span class="cvalue bets"><?=$crazyWheelRound->totalRound?></span></p>
                    <p> <span class="ctext"> Bets On Round</span> : <span class="cvalue bets"><?=$crazyWheel->playedRound?></span></p>
                    <p> <span class="ctext"> Points</span> : <span class="cvalue bets"><?=$crazyWheel->point?></span></p>
                    <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($crazyWheel->win)?></span></p>
                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($crazyWheel->com)?></span></p>
                    <p> <span class="ctext"> Players</span> : <span class="cvalue bets"><?=$crazyWheel->player?></span></p>
                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($crazyWheel->point-$crazyWheel->win))?></span></p>
                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($crazyWheel->point-$crazyWheel->win)+$crazyWheel->com)?></span></p>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="small-box mycard">
                  <div class="inner">
                    <h4 class="text-center">Regular In Bets</h4>
                    <?php
                      $rIn = getData('regular_bazar_games',$feilds1,$con3,'One');
                      $rHome = getData('regular_bazar_games',$feild,$conP.'"Home")','One');
                    ?>
                    <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$rIn->id?></span></p>
                    <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$rHome->idP?></span></p>
                    <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($rIn->point,2)?></span></p>
                    <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?=$rHome->pending?></span></p>
                    <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($rIn->win)?></span></p>
                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($rIn->com)?></span></p>
                    <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$rIn->player?></span></p>
                    <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?=$rHome->playerP?></span></p>
                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($rIn->point-$rIn->win))?></span></p>
                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($rIn->point-$rIn->win)+$rIn->com)?></span></p>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="small-box mycard">
                  <div class="inner">
                    <h4 class="text-center">Regular In Home Bets</h4>
                    <?php
                      $rHome = getData('regular_bazar_games',$feilds1,$con2,'One');
                      $rInHome = getData('regular_bazar_games',$feild,$conP.'"InHome")','One');
                    ?>
                    <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$rHome->id?></span></p>
                    <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$rInHome->idP?></span></p>
                    <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($rHome->point,2)?></span></p>
                    <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?=$rInHome->pending?></span></p>
                    <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($rHome->win)?></span></p>
                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($rHome->com)?></span></p>
                    <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$rHome->player?></span></p>
                    <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?=$rInHome->playerP?></span></p>
                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($rHome->point-$rHome->win)?></span></p>
                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($rHome->point-$rHome->win)+$rHome->com)?></span></p>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="small-box mycard">
                  <div class="inner">
                    <h4 class="text-center">Regular Out Bets</h4>
                    <?php
                      $rOut = getData('regular_bazar_games',$feilds1,$con1,'One');
                      $rOutP = getData('regular_bazar_games',$feild,$conP.'"Out")','One');
                    ?>
                    <p> <span class="ctext"> Bets Settle</span> : <span class="cvalue bets"><?=$rOut->id?></span></p>
                    <p> <span class="ctext"> Bets Pending</span> : <span class="cvalue bets"><?=$rOutP->idP?></span></p>
                    <p> <span class="ctext"> Points Settle</span> : <span class="cvalue bets"><?=round($rOut->point,2)?></span></p>
                    <p> <span class="ctext"> Points Pending</span> : <span class="cvalue bets"><?=$rOutP->pending?></span></p>
                    <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($rOut->win)?></span></p>
                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($rOut->com)?></span></p>
                    <p> <span class="ctext"> Players Bet Settle</span> : <span class="cvalue bets"><?=$rOut->player?>  -  <?=$rOutP->playerP?></span></p>
                    <p> <span class="ctext"> Players Bet Pending</span> : <span class="cvalue bets"><?=$rOut->player?>  -  <?=$rOutP->playerP?></span></p>
                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($rOut->point-$rOut->win))?></span></p>
                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($rOut->point-$rOut->win)+$rOut->com)?></span></p>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="small-box mycard">
                  <div class="inner">
                    <h4 class="text-center">All Market GGR</h4>
                    <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$regular['id']+$star['id']+$king['id']+$worli['id']+$crazyWheel->id?></span></p>
                    <p> <span class="ctext"> Points </span> : <span class="cvalue bets"><?=round($regular['point']+$star['point']+$king['point']+$worli['point']+$crazyWheel->point,2)?></span></p>
                    <p> <span class="ctext"> Winning Point </span> : <span class="cvalue bets"><?=round($regular['win']+$star['win']+$king['win']+$worli['win']+$crazyWheel->win)?></span></p>
                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($regular['com']+$star['com']+$king['com']+$worli['com']+$crazyWheel->com)?></span></p>
                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($regular['point']+$star['point']+$king['point']+$worli['point']+$crazyWheel->point)-($regular['win']+$star['win']+$king['win']+$worli['win']+$crazyWheel->win))?></span></p>
                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($regular['point']+$star['point']+$king['point']+$worli['point']+$crazyWheel->point)-($regular['win']+$star['win']+$king['win']+$worli['win']+$crazyWheel->win)+($regular['com']+$star['com']+$king['com']+$worli['com']+$crazyWheel->com))?></span></p>
                    <p> <span class="ctext">  </span>  <span class="cvalue bets"></span></p>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
      </section>
    <?php } ?>
</div>

<?php include 'includes/footer.php'; ?>