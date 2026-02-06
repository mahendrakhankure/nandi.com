<?php 
    include 'includes/header.php'; 
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
        <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        <?php include 'includes/betMinMax.php'; ?>
        
        <div class="opnCLse">
            <form class="chk-form Col-3-check" action="#">
                <div class="chkL">
                    <input class="check1" name="check" type="checkbox" value="SP" id="check1">
                    <label for="test11">SP</label>
                </div>
                <div class="chkL">
                    <input class="check2" name="check" type="checkbox" value="DP" id="check2">
                    <label for="test22">DP</label>
                </div>
                <div class="chkL">
                    <input class="check3" name="check" type="checkbox" value="TP" id="check3">
                    <label for="test33">TP</label>
                </div>
            </form>
        </div>
        
          <div class="controlDv controlDv">
              <div class="akdCOuter">
                  <label>Left</label>
                  <input type="number" class="akdC" id="left" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
              </div>     
             <div class="akdCOuter">
                  <label>Middle</label>
                  <input type="number" class="akdC" id="middle" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
              </div>
              <div class="akdCOuter">
                  <label>Right</label>
                  <input type="number" class="akdC" id="right" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">       
              </div>
        </div>
       <div class="controlDv">
            <input type="number" class="akdC" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4" oninput="maxLengthCheck(this)">                  
        </div> 
        <div class="controlDv">
         <button class="right-al sl-all" onclick="addBets('choicePana')">+ Add More</button>
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
                        <th>Game Patti</th>
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
            cplaceHeight = viewHeight-370-160;
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