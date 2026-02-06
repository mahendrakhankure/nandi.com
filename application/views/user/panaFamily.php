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
                      <h3><?=$gameDetail['game_name']?></h3>
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

      <!-- Betting Variation Type Form -->
      <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1">
        <div class="bett-var-type-sf">
             <h3 class="bettin text-center mar-top-bottom"><?=$gameDetail['game_name']?></h3>
             <div class="var-type-sf">
                 <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" onkeypress="return isNumber(event)" minlength="3" maxlength="3" oninput="maxLengthCheck(this)">
                 <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4" oninput="maxLengthCheck(this)">
             </div>
             <div class="var-type-btn">
                 <button onclick="addBetsPana('panaFamily')">+ Add More</button>
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
                             <p>Bid Amount <span id="bamount">0.0</span></p>
                             <p>Total Amount <span id = "tamount">0.0</span></p>
                        </div>
                    </div>
                    
            </div>

                <!-- Bet Action Button -->
            <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1 bett-action " style="margin-top: -0.8rem;" id="pBet">
                <a href="javascript:void(0)" onclick="placeBetPana(<?=$param['bazar_id']?>,<?=$param['type_id']?>)">PLACE BET</a>
                <a href="javascript:void(0)" onclick="resetAll()">RESET BET</a>
            </div>
        </div>
    </div>

    
     

 



    <?php include 'includes/footer.php'; ?>