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
        
        
        <div class="controlDv akdDV">
            <div class="bett-var-form  ">
                <h3 class="bettin text-center heading" id = "game-name"><?=$gameDetail['game_name']?></h3>
                <div class="var-type-sf controlDv">
                    <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required minlength="2" maxlength="2" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                    <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="4" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                </div>
                <div class="var-type-btn controlDv">
                    <a href="javascript:void(0)" onclick="addBets('twoDigitPanel')" class="btn sl-all">+ Add More</a>
                    <!-- <button class="sl-all" onclick="addBets('twoDigitPanel')">+ Add More</button> -->
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
 