<?php 
    include 'includes/header.php'; 
?>

<style>
    input {
        color: white;
    }
</style>

    <!-- Batting Name, Batting Notes, Batting Date -->

    <div class="container">
        <div class="rows">
            <div class="col-12">
                <div class="htp">
                    <a href="#">How To Play</a>
                </div>
                <div class="batt-name dark ele-margin-tb">
                    <h3>Pana Difference</h3>
                </div>  
            </div>
            <div class="col-12 batt-notes ele-margin-tb">
                <h3>NOTE:- BET AMOUNT SHOULD GREATER OR EQUAL TO 5</h3>
            </div>
            <div class="col-12 ">  
                <div class="batt-date dark ele-margin-tb">
                    
                    <select name="batt-date-sel" id="batt-date-sel">
                        <option value="12-12-20022">12-12-20022</option>
                        <option value="12-12-20022">13-12-20022</option>
                        <option value="12-12-20022">14-12-20022</option>
                        <option value="12-12-20022">15-12-20022</option>
                      </select>
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
 


      <!-- Betting Variation Type Form -->
      <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1">
        <div class="bett-var-type-sf">
             <h3 class="bettin text-center mar-top-bottom"> Pana Difference </h3>
             <div class="var-type-sf">
                 <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" onkeypress="return isNumber(event)" maxlength="1" oninput="maxLengthCheck(this)">
                 <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4" oninput="maxLengthCheck(this)">
             </div>
             <div class="var-type-btn">
                 <button onclick="addBetsPana('panaDifference')">+ Add More</button>
             </div>
        </div>
 
     </div>
    



         <!-- Betting List Table -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
               
                    <div class="bett-table">
                        <table>
                            <thead>
                                <tr>
                                <th>Pana</th>
                                <th>Points</th>
                                <th>Delete</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <tr>
                                     
                                </tr>
                            </tbody>
                        </table>
                        <div class="total-bid"  style="display:flex; justify-content:space-between; margin:0.5rem 1rem;" >
                             <p>Bid Amount <span id="totalBet">0.0</span></p>
                             <p>Total Amount <span id = "totalAmount">0.0</span></p>
                        </div>
                    </div>
                    
            </div>

                <!-- Bet Action Button -->
            <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1 bett-action " style="margin-top: -0.8rem;" id="pBet">
                <a href="javascript:void(0)" onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)">PLACE BET</a>
                <a href="javascript:void(0)" onclick="resetAll()">RESET BET</a>
            </div>
        </div>
    </div>

    
     

 



    <?php include 'includes/footer.php'; ?>