<?php 
    include 'includes/header.php';
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
    </style>
    <div class="content-wrapper">
        <section class="content-header">
          <h1>
            <i class="fa fa-users"></i> Regular Bazar
          </h1>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Players</th>
                                    <th>Bets</th>
                                    <th>Betting Amount</th>
                                    <th>Win</th>
                                    <th>GGR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IN</td>
                                    <td>
                                        <?=$inP['cid']?>
                                    </td>
                                    <td>
                                        <?=$inP['id']?>
                                    </td>
                                    <td>
                                        <?=round($inP['point'])?>
                                    </td>
                                    <td>
                                        <?=round($inP['win'])?>
                                    </td>
                                    <?php
                                        $gIn=round($inP['point']-$inP['win']);
                                        if($gIn>0){
                                            echo '<td class="s">'.$gIn.'</td>';
                                        }else{
                                            echo '<td class="d">'.$gIn.'</td>';
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <td>IN Home</td>
                                    <td>
                                        <?=$inH['cid']?>
                                    </td>
                                    <td>
                                        <?=$inH['id']?>
                                    </td>
                                    <td>
                                        <?=round($inH['point'])?>
                                    </td>
                                    <td>
                                        <?=round($inH['win'])?>
                                    </td>
                                    <?php
                                        $gIn=round($inH['point']-$inH['win']);
                                        if($gIn>0){
                                            echo '<td class="s">'.$gIn.'</td>';
                                        }else{
                                            echo '<td class="d">'.$gIn.'</td>';
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <td>Out</td>
                                    <td>
                                        <?=$outP['cid']?>
                                    </td>
                                    <td>
                                        <?=$outP['id']?>
                                    </td>
                                    <td>
                                        <?=round($outP['point'])?>
                                    </td>
                                    <td>
                                        <?=round($outP['win'])?>
                                    </td>
                                    <?php
                                        $gOut=round($outP['point']-$outP['win']);
                                        if($gOut>0){
                                            echo '<td class="s">'.$gOut.'</td>';
                                        }else{
                                            echo '<td class="d">'.$gOut.'</td>';
                                        }
                                    ?>
                                </tr>
                                <tr style="background-color: pink;">
                                    <td>Total</td>
                                    <td>
                                        <?=$inP['cid']+$outP['cid']+$inH['cid'].'('.$cUni['cUni'].')'?>
                                    </td>
                                    <td>
                                        <?=$inP['id']+$outP['id']+$inH['id']?>
                                    </td>
                                    <td>
                                        <?=round($inP['point']+$outP['point']+$inH['point'])?>
                                    </td>
                                    <td>
                                        <?=round($inP['win']+$outP['win']+$inH['win'])?>
                                    </td>
                                    <?php
                                        $gIn=round($inP['point']-$inP['win'])+round($outP['point']-$outP['win'])+round($inH['point']-$inH['win']);
                                        if($gIn>0){
                                            echo '<td style="color: green;">'.$gIn.'</td>';
                                        }else{
                                            echo '<td style="color: red;">'.$gIn.'</td>';
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <?php 
                        foreach($arr as $list){
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <a href="<?=base_url();?>59857792564e7b27ecd66c6570acd845/<?=$list['bazar_id']?>/<?=$list['bazar_name']?>?from=<?=$from?>&to=<?=$to?>">
                            <div class="p3-game-list boxRegular">
                                <p class="time"><span class="t otime"><?=date('h:i A', strtotime($list['oTime']));?></span> <span class="time-divider">|</span> <span class="t ctime"><?=date('h:i A', strtotime($list['cTime']));?></span></p>
                                <div class="inner">
                                    <h4 class="bazarName"><?=$list['bazar_name'];?></h4>
                                    <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$list['id']?></span></p>
                                    <p> <span class="ctext"> Amount </span> : <span class="cvalue bets"><?=empty($list['point'])?'0':$list['point'];?></span></p>
                                    <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=empty($list['win'])?'0':round($list['win'],2);?></span></p>
                                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($list['com'],2);?></span></p>
                                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($list['ggr'],2);?></span></p>
                                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($list['ggr']+$list['com']),2);?></span></p>
                                    <p> <span class="ctext"> No Players </span> : <span class="cvalue bets"><?=empty($list['cid'])?'0':$list['cid'];?></span></p>
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