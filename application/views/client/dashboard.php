<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
  .bets{
    font-size: 20px;
  }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h4 class="text-center">Regular Bet's</h4>
                  Bets : <span class="bets"><?=$regular['id']?></span><br>
                  Points : <span class="bets"><?=$regular['point']?></span><br>
                  Winning : <span class="bets"><?=$regular['win']?></span><br>
                  GGR : <span class="bets"><?=$regular['point']-$regular['win']?></span>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h4 class="text-center">Starline Bet's</h4>
                  Bets : <span class="bets"><?=$star['id']?></span><br>
                  Points : <span class="bets"><?=$star['point']?></span><br>
                  Winning : <span class="bets"><?=$star['win']?></span><br>
                  GGR : <span class="bets"><?=$star['point']-$star['win']?></span>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4 class="text-center">King Bet's</h4>
                  Bets : <span class="bets"><?=$king['id']?></span><br>
                  Points : <span class="bets"><?=$king['point']?></span><br>
                  Winning : <span class="bets"><?=$king['win']?></span><br>
                  GGR : <span class="bets"><?=$king['point']-$king['win']?></span>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h4 class="text-center">GGR</h4>
                  Total : <span class="bets"><?=$regular['id']+$star['id']+$king['id']?></span><br>
                  Points : <span class="bets"><?=$regular['point']+$star['point']+$king['point']?></span><br>
                  Winning : <span class="bets"><?=$regular['win']+$star['win']+$king['win']?></span><br>
                  GGR : <span class="bets"><?=($regular['point']+$star['point']+$king['point'])-($regular['win']+$star['win']+$king['win'])?></span>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>