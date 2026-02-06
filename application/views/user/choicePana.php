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

    <!-- Batting Name, Batting Notes, Batting Date -->

    <div class="container">
        <div class="rows">
            <div class="col-12">
                <div class="batt-name dark ele-margin-tb">
                    <h3><?=$gameDetail['game_name']?></h3>
                </div>  
            </div>
            <div class="col-12 batt-notes ele-margin-tb">
                <h3>NOTE:- BET AMOUNT SHOULD GREATER OR EQUAL TO 5</h3>
            </div>
            <div class="col-12 ">  
                <div class="batt-date dark ele-margin-tb">
                    <select name="batt-date-sel" id="batt-date-sel date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
                </div>  
            </div>
            
        </div>
    </div>


    <!-- Game Type -->

    <div class="col-md-6 col-sm-8 col-xs-10 offset-md-3 offset-sm-2 offset-sm-1 game-type-wrapper">
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
              <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>        
        </div>
    </div>

    <!-- Choose Variation Type and Digit -->
    <div class="col-md-8 col-sm-8  offset-md-2 offset-sm-2">
        <style>
           
            
            
             
            
        </style>
            <form>                 
                    <div class="var-type-digit">
                        <div class="form-check">
                            <input class="check1" name="check" type="checkbox" value="SP" id="check1">
                            <label class="check1-label" for="check1">
                              SP
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="check2" name="check" type="checkbox" value="DP" id="check2">
                            <label class="check2-label" for="check2">
                              DP
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="check3" name="check" type="checkbox" value="TP" id="check3">
                            <label class="check3-label" for="check3">
                              TP
                            </label>
                          </div>
                    </div>

                     <div class="choose-digit">
                        <div class="form-group">
                            <label class="check3-label" for="check3">
                                Left
                              </label>  
                            <input type="number" class="form-control" id="left" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                          </div>
                          <div class="form-group">
                            <label class="check3-label" for="check3">
                                Middle
                              </label>
                            <input type="number" class="form-control" id="middle"  onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                          </div>
                          <div class="form-group">
                            <label class="check3-label" for="check3">
                                Right
                              </label>
                            <input type="number" class="form-control" id="right"  onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                          </div>
                     </div>                       
              </form>          
    </div>


    <!-- Betting Variation Type Form 1 -->

    <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1">
       <div class="bett-var-type-sf">
            
            <div class="var-type-if">
                <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4">
                <button class="btn-v2" onclick="addBets('choicePana')">+ Add More</button>
            </div>
       </div>

    </div>

     <!-- Betting List Table -->
    <div class="col-md-8 offset-md-2">
        <div>
            <div class="bett-table">
                <table>
                    <thead>
                        <tr>
                        <th>Pana</th>
                        <th>Points</th>
                        <th>Game Type</th>
                        <th>Game Patti</th>
                        <th></th>
                        </tr> 
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="total-bid">
                     <p>Total Amount <span id="totalAmount">0</span></p>
                     <p>Bid Amount <span id="totalBet">0</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 chipbox-action" id="pBet">
        <a href="javascript:void(0)" onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)">PLACE BET</a>
        <a href="javascript:void(0)" onclick="resetAll()">RESET BET</a>
    </div>
<?php include 'includes/footer.php'; ?>