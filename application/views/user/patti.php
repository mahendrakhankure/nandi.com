<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
      
?>
        <style type="text/css">
            
            hr{
                height: 5px;
                color: #f80000;
                width: 100%
            }
            .cplaceHr{
                border-bottom: 2px solid Yellow;
            }
            .iId{
                color: #fff;
                display: none;
            }
            .cplace-box{
                text-align:center;
            }
        </style>
 
    <div class="container container-custom">
    <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <?php include 'includes/selectGames.php'; ?>
            <?php include 'includes/blankChips.php'; ?>
        </div>
        <?php include 'includes/betMinMax.php'; ?>
        <div class="game-type-wrapper">
            <div class="opnCLse" id="game-open-close">   
                <form class="chk-form"> 
                    <div class="gt-open chkL">
                        <input type="radio" id="open" name="gt-radio" value="open" <?= $status[0]['game_type1'] == 'NULL' ? 'disabled':''; ?>>
                        <label for="open">Open</label>
                    </div>
                    <div class="gt-close chkL">
                        <input type="radio" id="close" name="gt-radio" value="close" <?= $status[0]['game_type2'] == 'NULL' ? 'disabled':''; ?>>
                        <label for="close">Close</label>
                    </div>
                </form>         
            </div>
            <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        </div>
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
            <a href="javascript:void(0)" onclick="selectAllPattiSingleDigit('<?=$gameDetail['id']?>','<?=$page?>')" class="btn sl-all">Select All Patti</a>
            <!-- <span class="btn sl-all" id="allPattiSelect" onclick="selectAllPattiSingleDigit('<?=$gameDetail['id']?>','<?=$page?>')">Select All Patti</span> -->
            <span class="betPlaceTabel">
                <table class="table">
                    <tbody>
                        <?php
                            $arr =[];
            
                            if($gameDetail['id']==1){
                                $ty = 'SinglePatti';
                                $arr['1']=['137', '146', '236', '245', '290', '380', '470', '489', '560', '579', '678', '128'];
                                $arr['2']=['570', '237', '480', '156', '390', '147', '679', '345', '138', '589', '246', '129'];
                                $arr['3']=['580', '238', '490', '157', '346', '148', '689', '256', '139', '670', '247', '120'];
                                $arr['4']=['590', '239', '347', '158', '789', '257', '149', '680', '248', '130', '167', '356'];
                                $arr['5']=['456', '249', '357', '230', '348', '168', '780', '159', '690', '258', '140', '267'];
                                $arr['6']=['367', '240', '358', '349', '169', '790', '268', '150', '457', '259', '123', '178'];
                                $arr['7']=['458', '269', '368', '250', '359', '179', '890', '340', '160', '467', '278', '124'];
                                $arr['8']=['459', '260', '189', '369', '170', '567', '350', '134', '468', '125', '279', '378'];
                                $arr['9']=['469', '234', '450', '270', '379', '180', '568', '360', '135', '478', '289', '126'];
                                $arr['10']=['479', '280', '460', '190', '389', '145', '578', '370', '136', '569', '127', '235'];
                            }else if($gameDetail['id']==2){
                                $ty = 'DoublePatti';
                                $arr['1']=['100', '335', '344', '119', '399', '155', '588', '227', '669'];
                                $arr['2']=['200', '336', '499', '110', '660', '228', '688', '255', '778'];
                                $arr['3']=['300', '355', '445', '166', '599', '229', '779', '337', '788'];
                                $arr['4']=['400', '338', '446', '112', '455', '220', '699', '266', '770'];
                                $arr['5']=['500', '339', '366', '113', '447', '122', '799', '177', '889'];
                                $arr['6']=['600', '448', '466', '114', '556', '277', '880', '330', '899'];
                                $arr['7']=['700', '223', '377', '115', '449', '133', '557', '188', '566'];
                                $arr['8']=['800', '288', '440', '116', '477', '224', '558', '233', '990'];
                                $arr['9']=['900', '225', '388', '117', '559', '144', '577', '199', '667'];
                                $arr['10']=['226', '668', '488', '118', '334', '299', '550', '244', '677'];
                            }else if($gameDetail['id']==4){
                                $ty = 'TriplePatti';
                                $arr['1']=['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
                            }else if($gameDetail['id']==5){
                                $ty = 'SingleAkda';
                                $arr['1']=['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                            }
                            for ($s = 0; $s < count($arr); $s++) {
                                $i=$s;
                                if($i==0){
                                    $i=10;
                                    echo "<tr><td colspan='5'><div class='btn'><span class='btn btn-default sl-all' for='srid0' onclick='checkAll([".implode($arr[10],',')."],0)'>Select All<label for='srid0'>0</label></span></div></td></tr>";
                                }else{
                                    echo "<tr><td colspan='5'><div class='btn'><span id='srid$i' class='btn btn-default sl-all' onclick='checkAll([".implode($arr[$i],',')."],".$i.")'>Select All<label for='srid$i'>$i</label></span></div></td></tr>";
                                }
                                
                                $nR = array_chunk($arr[$i],5);
                                $t=0;
                                foreach($nR as $k){
                                    echo '<tr>';
                                    foreach($k as $t){
                                        echo "<td><div class='place-input-main cplace' onclick='addCoinSingleDigitRegular(".$t.",&#39;".$page."&#39;)'><label class='inputNo'>$t</label><div class='btInput pos cplace-box'><span id='".$page.$t."Akda-wrapper' class='text-center'></span></div></div></td>";
                                    }
                                    echo "</tr>";
                                }
                                // echo "<tr><td colspan='5'><hr></td></tr>";
                            } 
                        ?>
                    </tbody>
                </table>
            </span>
        </div>
        <?php include 'includes/resultSection.php'; ?>
    </div>
        
    <?php 
          include 'includes/footer.php'; 
    ?>
     
<script type="text/javascript">
    var ty = '';
    $(document).ready(function() {
         

        var arr =[];
        
        if(<?=$gameDetail['id']?>==1){
            ty = 'SinglePatti';
            arr['1']=['137', '146', '236', '245', '290', '380', '470', '489', '560', '579', '678', '128'];
            arr['2']=['570', '237', '480', '156', '390', '147', '679', '345', '138', '589', '246', '129'];
            arr['3']=['580', '238', '490', '157', '346', '148', '689', '256', '139', '670', '247', '120'];
            arr['4']=['590', '239', '347', '158', '789', '257', '149', '680', '248', '130', '167', '356'];
            arr['5']=['456', '249', '357', '230', '348', '168', '780', '159', '690', '258', '140', '267'];
            arr['6']=['367', '240', '358', '349', '169', '790', '268', '150', '457', '259', '123', '178'];
            arr['7']=['458', '269', '368', '250', '359', '179', '890', '340', '160', '467', '278', '124'];
            arr['8']=['459', '260', '189', '369', '170', '567', '350', '134', '468', '125', '279', '378'];
            arr['9']=['469', '234', '450', '270', '379', '180', '568', '360', '135', '478', '289', '126'];
            arr['10']=['479', '280', '460', '190', '389', '145', '578', '370', '136', '569', '127', '235'];
        }else if(<?=$gameDetail['id']?>==2){
            ty = 'DoublePatti';
            arr['1']=['100', '335', '344', '119', '399', '155', '588', '227', '669'];
            arr['2']=['200', '336', '499', '110', '660', '228', '688', '255', '778'];
            arr['3']=['300', '355', '445', '166', '599', '229', '779', '337', '788'];
            arr['4']=['400', '338', '446', '112', '455', '220', '699', '266', '770'];
            arr['5']=['500', '339', '366', '113', '447', '122', '799', '177', '889'];
            arr['6']=['600', '448', '466', '114', '556', '277', '880', '330', '899'];
            arr['7']=['700', '223', '377', '115', '449', '133', '557', '188', '566'];
            arr['8']=['800', '288', '440', '116', '477', '224', '558', '233', '990'];
            arr['9']=['900', '225', '388', '117', '559', '144', '577', '199', '667'];
            arr['10']=['226', '668', '488', '118', '334', '299', '550', '244', '677'];
        }else if(<?=$gameDetail['id']?>==4){
            ty = 'TriplePatti';
            arr['1']=['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
        }else if(<?=$gameDetail['id']?>==5){
            ty = 'SingleAkda';
            arr['1']=['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        }
        for (var i = 1; i < arr.length; i++) {
            var dome = '';
            if(i==10){
                dome += '<div class="srId"><span class="btn btn-default" for="srid0" onclick="checkAll(['+arr[10]+'],0)">Select All</span><label for="srid0">0</label></div>';
            }else{
                dome += '<div class="srId"><span id="srid'+i+'" class="btn btn-default" onclick="checkAll(['+arr[i]+'],'+i+')">Select All</span><label for="srid'+i+'">'+i+'</label></div>';
            }
            dome+= '<tr>';
            $(arr[i]).each(function(t) {
                
                dome+='<td><div class="place-input-main cplace" onclick="addCoinSingleDigitRegular('+arr[i][t]+',\'<?=$page?>\')"><label class="inputNo">'+arr[i][t]+'</label><div class="btInput pos cplace-box"><span id="<?=$page?>'+arr[i][t]+'Akda-wrapper" class="countNo"></span></div></div></td>';
            
            });
            dome += '</tr><hr>';
            // $('#dome').append(dome);
        } 
    });
    function checkAll(val,i){
        if(ty=="SinglePatti"){
            $(val).each(function(i) {
                addCoinInstantWorli(val[i],ty);
            });
        }else{
            $(val).each(function(i) {
                addCoinRegular(val[i],ty);
            });
        }
    }
    $(document).ready(function() {
        var viewWidth;
        var viewHeight;

        if(window.innerWidth !== undefined && window.innerHeight !== undefined) { 
            viewWidth = window.innerWidth;
            viewHeight = window.innerHeight;
        } else {  
            viewWidth = document.documentElement.clientWidth;
            viewHeight = document.documentElement.clientHeight;
        }
        if(parseInt(viewWidth) <= 340) {
            cplaceHeight = viewHeight-360;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }
        if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
            console.log('working')
            cplaceHeight = viewHeight-370;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else{
            
            cplaceHeight = viewHeight-495;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }

    });
</script>