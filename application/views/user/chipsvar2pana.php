
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

        <div class="col-12 myselect-outer-wrapper controlDv">  
            <div class="select-jodi  select-wrapper">
                <select name="game-var" class="akdC" aria-label="Game Selection" id="typeOfdata"    onchange="getGameTypePanaNew(this.value)">
                    <option value="EEE" selected="">Even Even Even</option>
                    <option value="EEO">Even Even Odd</option>
                    <option value="EOE">Even Odd Even</option>
                    <option value="EOO">Even Odd Odd</option>
                    <option value="OEE">Odd Even Even</option>
                    <option value="OEO">Odd Even Odd</option>
                    <option value="OOE">Odd Odd Even</option>
                    <option value="OOO">Odd Odd Odd</option>
                        
                </select>
            </div>  
        </div>

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
            <span class="betPlaceTabel" id="getEvenOddPana">
           
            </span>
        </div>
        <?php include 'includes/resultSection.php'; ?> 
    </div>
         
        
    <?php 
          include 'includes/footer.php'; 
    ?>
     
     <script>
        $(document).ready(function(){
            getGameTypePanaNew('EEE');
        });
    </script>

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
            cplaceHeight = viewHeight-360-44;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }
        if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
            cplaceHeight = viewHeight-370-69+38;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394-44;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359-44;
            $(".betPlaceTabelComb").height(cplaceHeight);
        }

    }); 
    </script> 