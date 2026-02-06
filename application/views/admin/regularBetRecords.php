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
        .j{
            
            color: rgb(255, 255, 255);
            background-color: rgb(30, 140, 178);
            padding: 2px 6px;
            border-radius: 10px;
        }
        
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
                                        <?=$inP['cid']?>(<span id="cidIn" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=$inP['id']?>(<span id="idIn" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($inP['point'])?>(<span id="pointIn" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($inP['win'])?>
                                    </td>
                                    <?php
                                        $gIn=round($inP['point']-$inP['win']);
                                        if($gIn>0){
                                            echo '<td class="s">'.$gIn.'</td><span id="ggrIn"></span>';
                                        }else{
                                            echo '<td class="d">'.$gIn.'</td><span id="ggrIn"></span>';
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <td>IN Home</td>
                                    <td>
                                        <?=$inH['cid']?>(<span id="cidInHome" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=$inH['id']?>(<span id="idInHome" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($inH['point'])?>(<span id="pointInHome" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($inH['win'])?>
                                    </td>
                                    <?php
                                        $gInH=round($inH['point']-$inH['win']);
                                        if($gInH>0){
                                            echo '<td class="s">'.$gInH.'</td><span id="ggrInHome"></span>';
                                        }else{
                                            echo '<td class="d">'.$gInH.'</td><span id="ggrInHome"></span>';
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <td>Out</td>
                                    <td>
                                        <?=$outP['cid']?>(<span id="cidOut" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=$outP['id']?>(<span id="idOut" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($outP['point'])?>(<span id="pointOut" class="j"></span>)
                                    </td>
                                    <td>
                                        <?=round($outP['win'])?>
                                    </td>
                                    <?php
                                        $gOut=round($outP['point']-$outP['win']);
                                        if($gOut>0){
                                            echo '<td class="s">'.$gOut.'</td><span id="ggrOut"></span>';
                                        }else{
                                            echo '<td class="d">'.$gOut.'</td><span id="ggrOut"></span>';
                                        }
                                    ?>
                                </tr>
                                <tr style="background-color: pink;">
                                    <td>Total</td>
                                    <td>
                                        <span id='cidTotal1'><?=$inP['cid']+$outP['cid']+$outH['cid']+$inH['cid']?></span><span id="cidTotal"></span>
                                    </td>
                                    <td>
                                        <span id='idTotal1'><?=$inP['id']+$outP['id']+$outH['id']+$inH['id']?></span>(<span id="idTotal" class="j"></span>)
                                    </td>
                                    <td>
                                        <span id='pointTotal1'><?=round($inP['point']+$outP['point']+$outH['point']+$inH['point'])?>(</span><span id="pointTotal" class="j"></span>)
                                    </td>
                                    <td>
                                        <span id='winTotal1'><?=round($inP['win']+$outP['win']+$outH['win']+$inH['win'])?></span><span id="winTotal"></span>
                                    </td>
                                    <?php
                                        $gIn=round($inP['point']-$inP['win'])+round($outP['point']-$outP['win'])+round($inH['point']-$inH['win']);
                                        if($gIn>0){
                                            echo '<td style="color: green;">'.$gIn.'</td><span id="ggrTotal"></span>';
                                        }else{
                                            echo '<td style="color: red;">'.$gIn.'</td><span id="ggrTotal"></span>';
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
                        <a href="<?=base_url();?>f14c46a21b8f8c33edb09b186406c8ba/<?=$list['bazar_id']?>/<?=$list['bazar_name']?>">
                            <div class="p3-game-list boxRegular">
                                <p class="time"><span class="t otime"><?=date('h:i A', strtotime($list['oTime']));?></span> <span class="time-divider">|</span> <span class="t ctime"><?=date('h:i A', strtotime($list['cTime']));?></span></p>
                                <div class="inner">
                                    <h4 class="bazarName"><?=$list['bazar_name'];?></h4>
                                    <p> <span class="ctext"> Bets </span> : <span class="cvalue bets"><?=$list['id']?></span></p>
                                    <p> <span class="ctext"> Amount </span> : <span class="cvalue bets"><?=empty($list['point'])?'0':$list['point'];?></span></p>
                                    <p> <span class="ctext"> Win </span> : <span class="cvalue bets"><?=round($list['win'],2);?></span></p>
                                    <p> <span class="ctext"> Pending </span> : <span class="cvalue bets"><?=round($arr1[$list['bazar_id']],2);?></span></p>
                                    <p> <span class="ctext"> Commission </span> : <span class="cvalue bets"><?=round($list['com'],2);?></span></p>
                                    <p> <span class="ctext"> GGR </span> : <span class="cvalue bets"><?=round($list['ggr'],2)-round($arr1[$list['bazar_id']],2);?></span></p>
                                    <p> <span class="ctext"> GGR+Commission </span> : <span class="cvalue bets"><?=round(($list['ggr']-$arr1[$list['bazar_id']])+$list['com'],2);?></span></p>
                                    <p> <span class="ctext"> No Players </span> : <span class="cvalue bets"><?=empty($list['cid'])?'0':$list['cid'];?></span></p>
                                    <p> <span class="ctext"> No Winners </span> : <span class="cvalue bets"><?=empty($arr2[$list['bazar_id']])?'0':$arr2[$list['bazar_id']];?></span></p>
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
<script>
    $( document ).ready(function() {
        $.ajax({
            type: "POST",
            
            url: base_url+"/2b22e4966c6c27677713efe0a012e190",
            dataType: "json",
            data: JSON.stringify({date:'0'}),
            contentType: "application/json",
            success: function (res) {
                
                var inH = res.data.inH;
                var inP = res.data.inP;
                var outP = res.data.outP;
                $('#cidIn').text(inP.cid);
                $('#idIn').text(inP.id);
                $('#pointIn').text(inP.point);

                $('#cidInHome').text(inH.cid);
                $('#idInHome').text(inH.id);
                $('#pointInHome').text(inH.point);

                $('#cidOut').text(outP.cid);
                $('#idOut').text(outP.id);
                $('#pointOut').text(outP.point);

                // $('#cidTotal1').text(outP.cid);
                $('#idTotal').text(parseInt(outP.id)+parseInt(inP.id)+parseInt(inH.id));
                $('#pointTotal').text(parseInt(outP.point)+parseInt(inH.point)+parseInt(inP.point));
            }
        });
    });
    
</script>