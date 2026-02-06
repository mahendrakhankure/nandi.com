<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
   
      
?>

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

                            if($gameDetail['id']==26){
                                $res = panaChart52();
                            }else if($gameDetail['id']==27){
                                $res = panaChart56();
                            }else if($gameDetail['id']==28){
                                $res = panaChart77();
                            }else if($gameDetail['id']==29){
                                $res = allFigureHalfRedPana();
                            }else if($gameDetail['id']==25){
                                $res = favoritePana();
                            }else if($gameDetail['id']==30){
                                $res = linePanaChart();
                            }else if($gameDetail['id']==31){
                                $res = nonFavoritePana();
                            }else if($gameDetail['id']==32){
                                $res = touchChipkePana();
                            }else if($gameDetail['id']==33){
                                $res = untouchBikhrePana();
                            }

                            $nR = array_chunk($res,5);
                            $t=0;
                            foreach($nR as $k){
                                echo '<tr>';
                                foreach($k as $t){
                                    echo "<td><div class='place-input-main cplace' onclick='addCoinSingleDigit(".$t.",&#39;".$page."&#39;)'><label class='inputNo'>$t</label><div class='btInput pos cplace-box'><span id='".$page.$t."Akda-wrapper' class='text-center'></span></div></div></td>";
                                }
                                echo "</tr>";
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
    $(document).ready(function() {
        if(<?=$gameDetail['id']?>==26){
            var res = panaChart52();
        }else if(<?=$gameDetail['id']?>==27){
            var res = panaChart56();
        }else if(<?=$gameDetail['id']?>==28){
            var res = panaChart77();
        }else if(<?=$gameDetail['id']?>==29){
            var res = allFigureHalfRedPana();
        }else if(<?=$gameDetail['id']?>==25){
            var res = favoritePana();
        }else if(<?=$gameDetail['id']?>==30){
            var res = linePanaChart();
        }else if(<?=$gameDetail['id']?>==31){
            var res = nonFavoritePana();
        }else if(<?=$gameDetail['id']?>==32){
            var res = touchChipkePana();
        }else if(<?=$gameDetail['id']?>==33){
            var res = untouchBikhrePana();
        }
        $(res).each(function(i) {
            dome='<div class="cplace" onclick="addCoinSingleDigit('+res[i]+',\'<?=$page?>\')"><span>'+res[i]+'</span><div class="cplace-box"><div id="<?=$page?>'+res[i]+'Akda-wrapper" class="text-center"></div></div></div>';
            $('#dome').append(dome);
        });
    });
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
            cplaceHeight = viewHeight-370;
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