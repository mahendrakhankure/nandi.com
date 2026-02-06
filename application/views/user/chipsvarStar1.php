<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));    
?>
        <style type="text/css">
            .betPlaceTabel table td:first-child {
                border-top: 0;
                margin-top: 0rem !important;
            }
            .table{
                margin-top: 0rem !important;
            }
            .srId{
                display: block;
                width: 100%;
                height: 55px;
                margin-top: -0.8rem;
            }
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
            .result-inner-wrapper .result-item h3 {
                text-align: center;
            }
        </style>
        <img src="<?=base_url()?>assets/images/blankchips01.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips02.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips03.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips04.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips05.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips06.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips07.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips08.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips09.png" style="display: none;">


        <div class="container container-custom">
        <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <?php include 'includes/selectGamesStar.php'; ?>
            <select class="akdC" name="batt-date"  id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
            </select>
            <input type="hidden" name="starTime" value="<?=$marketTime['time']?>" id="starTime">
            <input type="hidden" name="time" value="<?=$param['time']?>" id="time">
        </div>
        <!-- <p class="betNote"> NOTE : BET AMOUNT SHOULD GREATER OR EQUAL TO <?=$param['type_id']==5?'10':'5';?> </p> -->
        <?php include 'includes/betMinMax.php'; ?>
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
            <div class="betPlaceTabel">
                <table class="table">
                    <tbody>
                        <div class="cplace-wrapper">
                        <?php
                            $page = $param['game_id'];
                            $arr = [];
                            $sA = 'Select All Patti';
                            if($page==2 || $page==13 || $page==25 || $page==7){
                                $res = ['0','1','2','3','4','5','6','7','8','9'];
                                // $('#allPattiSelect').text('Select All Digit');
                            }else  if($page==1 || $page==14 || $page==26){
                                $arr = getPattiAkdaWise('SinglePatti');
                            }else if($page==3 || $page==15 || $page==27 || $page==8){
                                $arr = getPattiAkdaWise('DoublePatti');
                            }else  if($page==6 || $page==16 || $page==28 || $page==4){
                                $res = ['000','111','222','333','444','555','666','777','888','999'];
                            }
                            if($res){
                                $a=array();
                                foreach(array_chunk($res, 5) as $a) {
                                    echo '<tr>';
                                    foreach($a as $i){
                                        echo '<td><div class="cplace place-input-main" onclick="addCoinStar('.$i.','.$page.')"><label class="inputNo">'.$i.'</label><div class="cplace-box btInput pos"><div id="'.$page.$i.'Akda-wrapper" class="text-center"></div></div></div></td>';
                                    }
                                    echo '</tr>';
                                }
                            }else{
                                $a=array();
                                $W=1;
                                foreach($arr as $k){
                                    if($W==10){
                                        echo '<tr><td colspan="5"><div><a href="javascript:void(0)" class="btn btn-default sl-all" for="srid0" onclick="checkAll(['.implode(",",$k).'],1)">Select All<label for="srid0">0</label></a></div></td></tr>';
                                    }else{
                                        echo '<tr><td colspan="5"><div><a href="javascript:void(0)" id="srid'.$W.'" class="btn btn-default sl-all" onclick="checkAll(['.implode(",",$k).'],'.$param['game_id'].')">Select All<label for="srid'.$W.'">'.$W.'</label></a></div></td></tr>';
                                    }
                                    foreach(array_chunk($k, 5) as $a) {
                                        echo '<tr>';
                                        foreach($a as $i){
                                            echo '<td><div class="cplace place-input-main" onclick="addCoinStar('.$i.','.$page.')"><label class="inputNo">'.$i.'</label><div class="cplace-box btInput pos"><div id="'.$page.$i.'Akda-wrapper" class="text-center"></div></div></div></td>';
                                        }
                                        echo '</tr>';
                                    }
                                    $W++;
                                }
                            }
                        ?> 
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="betResSection">
            <a   href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
            <a href="javascript:void(0)" onclick="undoStar(<?=$page?>)" class="imgBtn"><img src="<?=base_url()?>assets/images/undo.png"> Undo</a>
            <a href="javascript:void(0)" class="imgBtn"><img src="<?=base_url()?>assets/images/repeat.png"> Repeat </a>
            <div class="clrBoth"></div>
            <a href="javascript:void(0)" onclick="placeBetStar(<?=$param['bazar_id']?>,<?=$param['game_id']?>)"class="plceBet">Place Bet</a>
            <span class="separate"></span>
            <h5 class="lrest">Last Result</h5>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[0]['result_date']))?> <span><?=$gameResult[0]['result_patti']?>-<?=$gameResult[0]['result_akda']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[1]['result_date']))?> <span><?=$gameResult[1]['result_patti']?>-<?=$gameResult[1]['result_akda']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[2]['result_date']))?> <span><?=$gameResult[2]['result_patti']?>-<?=$gameResult[2]['result_akda']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[3]['result_date']))?> <span><?=$gameResult[3]['result_patti']?>-<?=$gameResult[3]['result_akda']?></span></p>
            
        </div> 
    </div>
    <?php
          include 'includes/footer.php'; 
    ?>
    <script>
        var ty = '';
        $(document).ready(function() {
            var page = <?=$param['game_id']?>;
            var arr = [];
            var sA = 'Select All Patti';
            if(page==2 || page==13 || page==25){
                var res = ['0','1','2','3','4','5','6','7','8','9'];
                $('#allPattiSelect').text('Select All Digit');
            }else if(page==4){
                var res = ['000','111','222','333','444','555','666','777','888','999'];
            }else if(page==1 || page==14 || page==26){
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
            }else if(page==3 || page==15 || page==27){
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
            }else if(page==7){
                var res = ['0','1','2','3','4','5','6','7','8','9'];
            }else if(page==6 || page==16 || page==28){
                var res = ['000','111','222','333','444','555','666','777','888','999'];
            }else if(page==8){
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
            }
            if(res){
                var dome = '<table class="table"><tbody><div class="col-12 cplace-outer">';     
                $(res).each(function(i) {
                    dome +='<td><div class="cplace place-input-main" onclick="addCoinStar('+res[i]+','+page+')"><label class="inputNo">'+res[i]+'</label><div class="cplace-box btInput pos"><div id="'+page+res[i]+'Akda-wrapper" class="text-center"></div></div></div></td>';
                });
                dome +='</div></div></tbody></table>';
                $('#dome').append(dome);
                var un = '<a  href="javascript:void(0)" onclick="undoStar(<?=$param['game_id']?>)">Undo <i class="fa-solid fa-rotate-left"></i></a>';
                $('#undo').append(un);
            }else{
                var dome = '<table class="table"><tbody><div class="col-12 cplace-outer">';
                for (var i = 1; i < arr.length; i++) {
                    var dome = '';
                    if(i==10){
                        dome += '<div class=""><span class="btn btn-default" for="srid0" onclick="checkAll(['+arr[10]+'],1)">Select All</span><label for="srid0">0</label><br></div>';
                    }else{
                        dome += '<div class=""><span id="srid'+i+'" class="btn btn-default" onclick="checkAll(['+arr[i]+'],'+i+')">Select All</span><label for="srid'+i+'">'+i+'</label><br></div>';
                    }

                    $(arr[i]).each(function(t) {
                        dome +='<td><div class="cplace place-input-main" onclick="addCoinStar('+arr[i][t]+','+page+')"><label class="inputNo">'+arr[i][t]+'</label><div class="cplace-box btInput pos"><div id="'+page+arr[i][t]+'Akda-wrapper" class="text-center"></div></div></div></td>';
                    });
                    dome += '<br><hr>';
                }
                dome +='</div></div></tbody></table>';
                $('#dome').append(dome);
                var un = '<a  href="javascript:void(0)" onclick="undoStar('+page+')">Undo <i class="fa-solid fa-rotate-left"></i></a>';
                $('#undo').append(un);
            }
            
        });
        function checkAll(val,p){
            
            if(p==2){
                $(val).each(function(i) {
                    addCoinInstantWorli(val[i],p);
                });
            }else{
                console.log(val)
                console.log(p)
                $(val).each(function(i) {
                    addCoinStar(val[i],p);
                    // addCoinRegular(val[i],p);
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
                cplaceHeight = viewHeight-360-8;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }
            if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
                cplaceHeight = viewHeight-370+37;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
                cplaceHeight = viewHeight-394-8;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }else if(parseInt(viewWidth) >= 768) {
                cplaceHeight = viewHeight-359-8;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }

        });
    </script>
