<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
    input{
        color: #ccc;
    }
    select{
        color: #ccc;
    }
</style>
    <div class="container">
        <div class="rows">
            <div class="col-12 div-center">
                <div class=" game-name darkbg myborder">
                    <h3><?=$gameDetail['game_name']?></h3>
                </div>  
            </div>
            <div class="col-12 game-notes">
                <h3 >NOTE:- BET AMOUNT SHOULD GREATER OR EQUAL TO 5</h3>
            </div>
            <div class="col-12 div-center">  
                <div>
                    <h3>
                        <select class="game-time darkbg myborder text-center" id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                            <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                            <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                            <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                        </select>
                    </h3>
                </div>  
            </div>
            <div class="col-md-6 col-sm-8  offset-md-3 offset-sm-2 game-type">
                <div class="game-open-close" id="game-open-close">   
                    <form> 
                           <div class="gt-open">
                            <input type="radio" id="open" name="gt-radio" value="open" <?= $status[0]['game_type1'] == 'NULL' ? 'disabled':''; ?>>
                            <label for="open">Open</label>
                           </div>
                            <div class="gt-close">
                                <input type="radio" id="close" name="gt-radio" value="close" <?= $status[0]['game_type2'] == 'NULL' ? 'disabled':''; ?>>
                                <label for="close">Close</label>
                            </div>
                      </form>          
                </div>
                <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
            </div>

            <div class="col-md-8 offset-md-2 p5-bet-form">
                <h2 class="g-name text-center">TWO DIGITS (CP, SR)</h2>
                <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required maxlength="2" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="4" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                <button onclick="addBets('towDigitPannel')">+ Add More</button>

                <table>
                    <tr class="table-header">
                      <th>Akda</th>
                      <th>Points</th>
                      <th>Game Type</th>
                      <th></th>
                    </tr>
                </table>
                <div class="total-bid">
                     <p>Total Amount <span id="totalAmount">0</span></p>
                     <p>Bid Amount <span id="totalBet">0</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="rows">          
            <div class="col-12 chipbox-action" id="pBet">
                <a onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)" style="cursor: pointer;">PLACE BET</a>
                <a onclick="resetAll()" style="cursor: pointer;">RESET BET</a>
            </div>
        </div>
    </div>
    
    
<div class="container" style="width: 100%; height:100px; visibility:hidden;">

</div>
<?php include 'includes/footer.php'; ?>
