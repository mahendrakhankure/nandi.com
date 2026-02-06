<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
?>
       
       <div class="container container-custom">
       <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <div class="batt-name select-wrapper">
                <?php include 'includes/selectGames.php'; ?>
            </div>  
            <div class="select-date select-wrapper dark">
                <?php include 'includes/blankChips.php'; ?>
            </div> 
        </div>
        <div class="game-type opnCLse" id="game-open-close">   
            <form class="chk-form"> 
                <div class="chkL gt-open">
                    <input type="radio" id="open" name="gt-radio" value="Open" <?= $status[0]['game_type1'] == 'NULL' ? 'disabled':''; ?>>
                    <label for="open">Open</label>
                </div>

                <div class="chkL gt-close">
                    <input type="radio" id="close" name="gt-radio" value="Close" <?= $status[0]['game_type2'] == 'NULL' ? 'disabled':''; ?>>
                    <label for="close">Close</label>
                </div>
                    
            </form>          
        </div>
        <p class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></p>
        <?php include 'includes/betMinMax.php'; ?>
        
        
        <div class="controlDv akdDV">
            <div class="bett-var-form">
                <h3 class="bettin text-center heading" id = "game-name"><?=$gameDetail['game_name']?></h3>
                <div class="col-md-8 col-sm-12 offset-md-2">
                    <div class="" style="margin-top: 1rem">
                        <div class="var-type-sf controlDv">
                            <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="3" onkeypress="return isNumber(event)"  oninput="maxLengthCheck(this)">
                            <a href="javascript:void(0)" onclick="addBets('<?=$page?>')" class="right-al sl-all" style="margin: 0px;width: 130px;border: 0;  text-align: center; line-height:27px;">+ Add More</a>
                            <!-- <button class="right-al sl-all" onclick="addBets('<?=$page?>')" style="margin: 0px;width: 130px;border: 0;">+ Add More</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/totalBetBox.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
        <div class="betPlaceTabel pana-Table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pana</th>
                        <th>Points</th>
                        <th>Game Type</th>
                        <th>Delete</th>
                    </tr> 
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
            
        </div>    
        <div class="totalNo">
            <span>Total no of bid:<span id = "totalBet">0</span></span>
        </div>
        <?php include 'includes/resultSection.php'; ?> 
    </div>
         
        
<?php 
    include 'includes/footer.php'; 
?>
 <script>
       $(document).ready(function() {
        $("td:empty").remove();
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
            cplaceHeight = viewHeight-370+78-144;
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