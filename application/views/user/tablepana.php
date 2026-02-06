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
                <select class="akdC" name="batt-date" id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
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
            <div class="bett-var-form">
                <h3 class="bettin text-center heading"><?=substr($gameDetail['game_name'], 0, -3)?></h3>
                <div class="var-type-sf akdCOuter">
                    <?php if($gameDetail['id']=="20")  { ?>
                        <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required minlength="3" maxlength="3" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                    <?php } else if($gameDetail['id']=="19") {?>
                        <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required minlength="1" maxlength="1" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                        <?php } ?>
                    <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="6" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                </div>
                <div class="var-type-btn akdCOuter">
                    <a href="javascript:void(0)" onclick="addBetsPana('<?=$page?>')" class="btn sl-all">+ Add More</a>
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
        <div class="betResSection">
            <a href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
            <div class="clrBoth"></div>
            <a href="javascript:void(0)" onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)"class="plceBet">Place Bet</a>
            <span class="separate"></span>
            <h5 class="lrest">Last Result</h5>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[0]['result_date']))?> <span><?=$gameResult[0]['open']?>-<?=$gameResult[0]['jodi']?>-<?=$gameResult[0]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[1]['result_date']))?> <span><?=$gameResult[1]['open']?>-<?=$gameResult[1]['jodi']?>-<?=$gameResult[1]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[2]['result_date']))?> <span><?=$gameResult[2]['open']?>-<?=$gameResult[2]['jodi']?>-<?=$gameResult[2]['close']?></span></p>
            <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[3]['result_date']))?> <span><?=$gameResult[3]['open']?>-<?=$gameResult[3]['jodi']?>-<?=$gameResult[3]['close']?></span></p>
        </div>  
    </div>
         
        
<?php 
    include 'includes/footer.php'; 
?>
 