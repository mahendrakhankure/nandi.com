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
<div class="content-wrapper king-wrapper">
    <div class="container-fluid" >
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
                                <?=$inP['cid']+$outP['cid'].'('.$cUni['cUni'].')'?>
                            </td>
                            <td>
                                <?=$inP['id']+$outP['id']?>
                            </td>
                            <td>
                                <?=round($inP['point']+$outP['point'])?>
                            </td>
                            <td>
                                <?=round($inP['win']+$outP['win'])?>
                            </td>
                            <?php
                                $gOut=round($outP['point']-$outP['win'])+round($inP['point']-$inP['win']);
                                if($gOut>0){
                                    echo '<td style="color: green;">'.$gOut.'</td>';
                                }else{
                                    echo '<td style="color: red;">'.$gOut.'</td>';
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row  mktlist">
            <?php
                foreach($arr as $data){
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?=base_url().'5ede4511d6734c99318abcd84ea332eb/'.$data['bazarId'].'/'.$data['bazar_name']?>?from=<?=$from?>&to=<?=$to?>">
                        <div class="kingMain">
                            <div class="inner">
                            <h4 class="mktitem-name"><?=$data['bazar_name']?></h4>
                            <p> <span class="time"><?=$data['time']?></p>
                            <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$data['id']?></span></p>
                            <p> <span class="ctext"> Points </span> : <span class="cvalue bets"><?=empty($data['point'])?0:$data['point'];?></span></p>
                            <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=empty($data['win'])?'0':round($data['win'],2);?></span></p>
                            <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($data['com'],2);?></span></p>
                            <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round(($data['point']-$data['win']),2);?></span></p>
                            <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round((($data['point']-$data['win'])+$data['com']),2);?></span></p>
                            <p> <span class="ctext"> Player </span> : <span class="cvalue bets"><?=empty($data['cid'])?0:$data['cid'];?></span></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>