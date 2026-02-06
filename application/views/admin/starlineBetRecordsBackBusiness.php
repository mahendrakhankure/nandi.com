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
</style>
<section class="content-wrapper star-wrapper">
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
                                if($inP['ggr']>0){
                                    echo '<td class="s">'.round($inP['ggr']).'</td>';
                                }else{
                                    echo '<td class="d">'.round($inP['ggr']).'</td>';
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
             
            <?php
            foreach($arr as $data){
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="starMain">
                        <a href="<?=base_url().'94bfdb1790a9084227983742ede72196/'.$data['bazar_id'].'/'.$data['bazarName']?>?from=<?=$from?>&to=<?=$to?>">
                            <div class="inner">
                                <h4><?=$data['bazarName']?></h4>
                                <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$data['id']?></span></p>
                                <p> <span class="ctext"> Amount </span> : <span class="cvalue bets"><?=empty($data['point'])?0:$data['point'];?></span></p>
                                <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=empty($data['win'])?'0':round($data['win'],2);?></span></p>
                                <p> <span class="ctext"> Comission </span> : <span class="cvalue bets"><?=round($data['com'],2);?></span></p>
                                <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($data['ggr'],2);?></span></p>
                                <p> <span class="ctext"> GGR+Comission </span> : <span class="cvalue bets"><?=round(($data['ggr']+$data['com']),2);?></span></p>
                                <p> <span class="ctext"> Player </span> : <span class="cvalue bets"><?=empty($data['cid'])?0:$data['cid'];?></span></p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                    }
                ?>     
                <div class="clrBoth"></div>
             
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>