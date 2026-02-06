<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
   
    if($gameDetail['id']=='10'||$gameDetail['id']=='22'||$gameDetail['id']=='23'){
        $sA = 'Select All Jodi';
    }else{
        $sA = 'Select All Patti';
    }
?>
        
        <div class="container container-custom">
        <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <?php include 'includes/selectGames.php'; ?>
            <?php include 'includes/blankChips.php'; ?>
        </div>
        <?php include 'includes/betMinMax.php'; ?>
        <input type="radio" id="Jodi" name="gt-radio" value="Jodi" disabled="" checked="" style="visibility:hidden">
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabel">
            <div class="col-12 cplace-outer">
                <div class="cplace-wrapper" id = "dome">
                    <table class="table">
                        <tbody>
                            <?php
                                if($gameDetail['id']==10){
                                    $res = redBracket();
                                }else if($gameDetail['id']==22){
                                    $res = primeJodi();
                                }else if($gameDetail['id']==23){
                                    $res = halfRed();
                                }

                                $nR = array_chunk($res,5);
                                $t=0;
                                foreach($nR as $k){
                                    echo '<tr>';
                                    foreach($k as $t){
                                        echo "<td><div class='place-input-main cplace' onclick='addCoinSingleDigit(".$t.",&#39;".$page."&#39;)'><label class='inputNo'>$t</label><div class='btInput pos cplace-box'><span id='".$page.$t."Akda-wrapper' class='text-center'></span></div></div></td>";
                                        // echo "<td><div class='cplace' onclick='addCoinSingleDigit(".$t.",&#39;".$page."&#39;)'><span>".$t."</span><div class='cplace-box'><div id='".$page.$t."Akda-wrapper' class='text-center'></div></div></div></td>";
                                    }
                                    echo "</tr>";
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
            cplaceHeight = viewHeight-360+40;
            $(".cplace-outer").height(cplaceHeight);
        }
        if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
            cplaceHeight = viewHeight-360;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394+40;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359+40;
            $(".cplace-outer").height(cplaceHeight);
        }
    }); 
</script>