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
        <input type="radio" id="Jodi" name="gt-radio" value="Jodi" disabled="" checked="" style="visibility:hidden">
        <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        <?php include 'includes/betMinMax.php'; ?>
        
        
        
        <div class="controlDv akdDV">
                <form>                 
                    <div class="choose-digit-lr controlDv">
                        <div class="form-group akdCOuter">
                            <label class="check3-label" for="check3">
                                Left
                                </label>  
                            <input type="number" class="akdC" id="left" onkeyup="document.getElementById('right').value=''" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                            </div>
                            
                            <div class="form-group akdCOuter">
                            <label class="check3-label" for="check3">
                                Right
                                </label>
                            <input type="number" class="akdC" id="right" onkeyup="document.getElementById('left').value=''" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                            </div>
                    </div>                       
                </form>
        </div>
       <div class="controlDv">
            <input type="number"class="akdC" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4" oninput="maxLengthCheck(this)">                  
        </div> 
        <div class="controlDv">
         <button class="right-al sl-all" onclick="addBetsTable('DigitBasedJodi')">+ Add More</button>
        </div>
        
        <?php include 'includes/totalBetBox.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
        <div class="betPlaceTabel pana-Table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Digit</th>
                        <th>Points</th>
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
            <span>Total amount:<span id= "totalAmount">0.0</span></span>
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
            cplaceHeight = viewHeight-370+40-120;
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