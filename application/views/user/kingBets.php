<?php 
    include 'includes/header.php'; 
    if($param['game_id']=='1'){
        $game_name='First Digit(Ekai)';
        $pg='HalfRed';
        $sa = "Select All Digits";
        
    }else if($param['game_id']=='2'){
        $game_name='Second Digit(Haruf)';
        $pg='HalfRed';
        $sa = "Select All Digits";
        
    }else{
        $game_name='Jodi';
        $pg='HalfRed';
        $sa = "Select All Jodi";
    }
?>
        <style type="text/css">
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
            <div class="col-12 myselect-outer-wrapper">
                <div class="batt-name select-wrapper controlDv">
                    <select name="game-list" class="form-select l akdC" id="game_list" onchange="location = this.value;">
                        <option value="<?=base_url().'5bfdc27f43fb4f5d76b0028e908b64a4/'.$param['bazar_id'].'/1'?><?=$tUrl?>" <?= $param['game_id']=='1'?'selected':''; ?>>
                            <h3>First Digit(Ekai)</h3>
                        </option>
                        <option value="<?=base_url().'5bfdc27f43fb4f5d76b0028e908b64a4/'.$param['bazar_id'].'/2'?><?=$tUrl?>" <?= $param['game_id']=='2'?'selected':''; ?>>
                            <h3>Second Digit(Haruf)</h3>
                        </option>
                        <option value="<?=base_url().'5bfdc27f43fb4f5d76b0028e908b64a4/'.$param['bazar_id'].'/3'?><?=$tUrl?>" <?= $param['game_id']=='3'?'selected':''; ?>>
                            <h3>Jodi</h3>
                        </option>
                    </select>
                </div>  
            </div>
        </div>
        <?php include 'includes/betMinMax.php'; ?>
        <div class="game-type-wrapper">
            <div class="opnCLse" id="game-open-close">
            <input type="radio" id="jodi" name="gt-radio" value="jodi" style="display:none;" checked>   
                <select class="akdC game-time darkbg myborder text-center" id="date">
                    <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                    <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                    <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                </select>         
            </div>
            <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        </div>
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
            <?php
                $arr =[];
                if($param['game_id']=='2' || $param['game_id']=='1'){
                    // <a href="javascript:void(0)" onclick="addBets('twoDigitPanel')" class="btn sl-all">+ Add More</a>
                    echo '<a href="javascript:void(0)" class="btn sl-all" onclick="selectAllPattiSingleDigit('."'".$param['game_id']."'".','."'SingleDigit'".')">'.$sa.'</a>';           
                }else{
                    echo '<a href="javascript:void(0)" class="btn sl-all" onclick="selectAllPattiSingleDigit('."'".$param['game_id']."'".','."'Jodi'".')">'.$sa.'</a>';            
                }
            ?>
            <div class="betPlaceTabel">
                <table class="table">
                    <tbody>
                        <?php
                            $arr =[];
                            if($param['game_id']=='2' || $param['game_id']=='1'){
                                $data = ['0','1','2','3','4','5','6','7','8','9'];
                                $k = array_chunk($data,5);
                                foreach($k as $nk){
                                    echo '<tr>';
                                    foreach($nk as $d){
                                        echo '<td><div class="place-input-main cplace" onclick="addCoinKing('.$d.',\'SingleDigit\')"><label class="inputNo">'.$d.'</label><div class="btInput pos cplace-box chipbox"><span id="SingleDigit'.$d.'Akda-wrapper" class="text-center"></span></div></div></td>';  
                                    }
                                    echo '</tr>';
                                }
                                $un = 'SingleDigit';
                            }else{
                                $data = getJodi();
                                $nR = array_chunk($data,5);
                                foreach($nR as $k){
                                    echo '<tr>';
                                    foreach($k as $i){
                                        echo '<td><div class="place-input-main cplace" onclick="addCoinKing('.$i.',\'Jodi\')"><label class="inputNo">'.$i.'</label><div class="btInput pos cplace-box chipbox"><span id="Jodi'.$i.'Akda-wrapper" class="text-center"></span></div></div></td>';
                                    }
                                    echo '</tr>';
                                }
                                $un = 'Jodi';
                                
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="betResSection">
            <a   href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
            <a href="javascript:void(0)" onclick="undo('<?=$un?>')" class="imgBtn"><img src="<?=base_url()?>assets/images/undo.png"> Undo</a>
            <div class="clrBoth"></div>
            <a href="javascript:void(0)" onclick="placeBetKing(<?=$param['bazar_id']?>,<?=$param['game_id']?>)" class="plceBet">Place Bet</a>
            <span class="separate"></span>
            <h5 class="lrest">Last Result</h5>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[0]['result_date']))?> <span><?=$gameResult[0]['open']?>-<?=$gameResult[0]['jodi']?>-<?=$gameResult[0]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[1]['result_date']))?> <span><?=$gameResult[1]['open']?>-<?=$gameResult[1]['jodi']?>-<?=$gameResult[1]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[2]['result_date']))?> <span><?=$gameResult[2]['open']?>-<?=$gameResult[2]['jodi']?>-<?=$gameResult[2]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[3]['result_date']))?> <span><?=$gameResult[3]['open']?>-<?=$gameResult[3]['jodi']?>-<?=$gameResult[3]['close']?></span></p>
        </div> 
    </div>
         
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        if(<?=$param['game_id']?>==2 || <?=$param['game_id']?>==1){
            var data = ['0','1','2','3','4','5','6','7','8','9'];
            $(data).each(function(i) {
                dome='<div class="cplace" onclick="addCoinKing('+data[i]+',\'SingleDigit\')"><span>'+data[i]+'</span><div class="cplace-box chipbox"><span id="SingleDigit'+data[i]+'Akda-wrapper" class="text-center"></span></div></div>';
                $('#dome').append(dome);
            });
            var p = <?=$param['game_id']?>;
            var sAll = '<span class="btn" id="allPattiSelect" onclick="selectAllPattiSingleDigit('+"'"+p+"'"+','+"'SingleDigit'"+')"><?php echo $sa ?></span>';
            $('#sAll').text('');
            $('#sAll').append(sAll);

            
            var un = '<a  href="javascript:void(0)" onclick="undoKing(\'SingleDigit\')">Undo <i class="fa-solid fa-rotate-left"></i></a>';
            // var un = '<span onclick="undoKing(\'SingleDigit\')"><i class="fa-solid fa-rotate-left"></i></span>';
            $('.undo-wrapper').append(un);
        }else{
            var data = [];
            for (var i = 0; i < 100; i++) {
                if (i.toString().length == 1) {
                    i = "0" + i;
                }
                data.push(i)
            }
            $(data).each(function(i) {
                dome='<div class="cplace" onclick="addCoinKing('+data[i]+',\'Jodi\')"><span>'+data[i]+'</span><div class="cplace-box chipbox"><span id="Jodi'+data[i]+'Akda-wrapper" class="text-center"></span></div></div>';
                $('#dome').append(dome);
            });
            var p = <?=$param['game_id']?>;
            var sAll = '<span class="btn" id="allPattiSelect" onclick="selectAllPattiSingleDigit('+"'"+p+"'"+','+"'Jodi'"+')"><?php echo $sa ?></span>';
            $('#sAll').text('');
            $('#sAll').append(sAll);
            var un = '<span onclick="undoKing(\'Jodi\')"><i class="fa-solid fa-rotate-left"></i></span>';
            $('.undo-wrapper').append(un);
        }

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
            cplaceHeight = viewHeight-370+40;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }
    });


       
    </script>