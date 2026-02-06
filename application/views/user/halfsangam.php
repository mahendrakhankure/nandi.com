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
        <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        <?php include 'includes/betMinMax.php'; ?>
        
        
        <div class="controlDv akdDV">
            <div class="bett-var-form  ">
                <h3 class="bettin text-center heading" id = "game-name"><?=$gameDetail['game_name']?></h3>
                <div class="var-type-sf controlDv">
                    <button onclick="changeType()" class="btn sl-all">+ CHANGE</button>
                </div>
                <div class="var-type-sf controlDv">   
                    <input type="number" name="s1" id="_s1" placeholder="Enter Digit" required minlength="1" maxlength="1" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                    <input type="number" name="s2" id="_s2" placeholder="Enter Patti" required minlength="1" maxlength="3" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                    <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="4" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                </div>
                <div class="var-type-btn controlDv">
                    <a href="javascript:void(0)" onclick="addSangamPana('<?=$page?>')" class="btn sl-all">+ Add BID</a>
                </div>
            </div>
        </div>
        <input type="radio" id="sangam" name="gt-radio" value="Half Sangam" disabled="" checked="" style="visibility:hidden">
        <?php include 'includes/totalBetBox.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
        <div class="betPlaceTabel pana-Table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Points</th>
                        <th style="display:none">Type</th>
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
 