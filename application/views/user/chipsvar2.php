<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
   
    if($gameDetail['id']=='6'){
        $sA = 'Select All Jodi';
    }else{
        $sA = 'Select All Patti';
    }
?>
    <style>
        .betPlaceTabel{
            overflow-y:auto;
        }
    </style>
    <div class="container container-custom">
        <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <?php include 'includes/selectGames.php'; ?>
            <?php include 'includes/blankChips.php'; ?>
        </div>
        <div class="controlDv">
            <select name="game-var" aria-label="Game Selection" class="akdC" id="typeOfJodi" onchange="getGameTypePatti(this.value)">
                <!-- <option selected="">Choose a Game</option> -->
                <option value="All" selected="">Jodi All</option>
                <option value="EE">Even Even Jodi</option>
                <option value="OO">Odd Odd Jodi</option>
                <option value="OE">Odd Even Jodi</option>
                <option value="EO">Even Odd Jodi</option>
                    
            </select>
        </div>
        <?php include 'includes/betMinMax.php'; ?>
        <input type="radio" id="Jodi" name="gt-radio" value="Jodi" disabled="" checked="" style="visibility:hidden">
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
            <div class="betPlaceTabel" id="getJodiPana">
                <div class="col-12 cplace-outer">
                    <div class="cplace-wrapper" id="dome">
                    <table class="table">
                        <tbody>
                            <?php
                                $a=array();
                                
                                for($i=0;$i<100;$i++){
                                    array_push($a,$i);
                                }
                                foreach(array_chunk($a, 5) as $p) { 
                                    echo '<tr>';
                                    foreach($p as $i){
                                        if($i<10)    {
                                            $i = '0'.$i;
                                        }
                                ?>
                                    <td>
                                        <div class="cplace place-input-main" onclick="addCoinJodiAll(<?=$i?>)">
                                            <label class="inputNo"><?=str_pad($i, 2, '0', STR_PAD_LEFT)?></label>
                                            <div class="cplace-box btInput pos">
                                                <div id="<?=$page.$i?>Akda-wrapper" class="text-center"></div>
                                            </div>
                                        </div>          
                                    </td>
                                <?php
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'includes/resultSection.php'; ?>
    </div>
           
    <?php 
          include 'includes/footer.php'; 
    ?>
     

    <script>
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
            $(".cplace-outer").height(cplaceHeight);
        }
        if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
            cplaceHeight = viewHeight-370;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359;
            $(".cplace-outer").height(cplaceHeight);
        }
    }); 
    </script>



     <!-- <script type="text/javascript">
    $(document).ready(function() {
        if(<?=$gameDetail['id']?>==2){
            var ty = 'DP';
        }else if(<?=$gameDetail['id']?>==1){
            var ty = 'SP';
        }
        var data = checkPannaType('SP/DP/TP',ty);
        $(data).each(function(i) {
            dome='<div class="cplace" onclick="addCoinSingleDigit('+data[i]+',\'<?=$page?>\')"><span>'+data[i]+'</span><div class="cplace-box"><div id="<?=$page?>'+data[i]+'Akda-wrapper" class="text-center"></div></div></div>';
            $('#dome').append(dome);
        });


        // <div class="cplace" onclick="addCoinSingleDigit(<?=$i?>, '<?=$page?>')"><span><?=$i?></span>
        //                 <div class="cplace-box" >
        //                     <div id="<?=$page.$i?>Akda-wrapper" class="text-center"></div>
        //                 </div>
        //             </div>   
    }); -->
<!-- </script> -->