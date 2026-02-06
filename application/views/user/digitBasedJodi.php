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
                    <select name="batt-date-sel" id="batt-date-sel date">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
                </div>  
            </div>
            
        </div>
    </div>


    <!-- Game Type -->

     

    <!-- Choose Variation Type and Digit -->
    <!-- <div class="col-md-8 col-sm-8  offset-md-2 offset-sm-2">
        
            <form>                 
                   
                <style>
                    .choose-digit-lr    {
                        display:flex;
                        justify-content: space-between;
                        margin-bottom:1rem;
                        margin-top:1rem;
                    }
                    .choose-digit-lr .form-group {
                        width:49%;
                    }
                    .choose-digit-lr input {
                        margin-top:0.5rem;
                    }
                    
                </style>

                     <div class="choose-digit-lr">
                        <div class="form-group">
                            <label class="check3-label" for="check3">
                                Left Digit
                              </label>  
                            <input type="text" class="form-control" id="left" name="digit" onkeyup="document.getElementById('right').value=''" onkeypress="return isNumber(event)" maxlength="1">
                          </div>
                          <div class="form-group">
                            <label class="check3-label" for="check3">
                                Right Digit
                              </label>
                            <input type="text" class="form-control" id="right" name="digit" onkeyup="document.getElementById('left').value=''" onkeypress="return isNumber(event)" maxlength="1">
                          </div>
                     </div>                       
              </form>      
              
              
                    <script>
                           

                    </script>

    </div> -->


    <!-- Betting Variation Type Form 1 -->

    <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1">
        <span class="btn" id="allPattiSelect" onclick="selectAllPattiSingleDigit('<?=$gameDetail['id']?>','<?=$page?>')">Select All Patti</span>
       <div class="bett-var-type-sf">
            
            <div class="var-type-if">
                <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" onkeypress="return isNumber(event)" maxlength="4" style="width:48.5%;" oninput="maxLengthCheck(this)">
                <button class="btn-v2" onclick="addBetsTable('DigitBasedJodi')">+ Add More</button>
            </div>
       </div>

    </div>

     <!-- Betting List Table -->
    <div class="col-md-8 offset-md-2">
        <div>

        <style>   
            .total-bid {
                border-top:2px solid white;
                display:flex;
                justify-content:space-between;
                  
            }
            .chipbox-action {
                margin-top: 0px;
            }
        </style>
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
                    </tbody>
                </table>
                <div class="total-bid">
                     <p>Total Bid <span id="totalBet">0</span></p>
                     <p>Total Amount <span id="totalAmount">0</span></p>   
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="rows">          
            <div class="col-12 chipbox-action" id="pBet">
                <a onclick="PlaceBets(<?=$param['bazar_id']?>,<?=$param['type_id']?>)" >PLACE BET</a>
                <a onclick="resetAll()" >RESET BET</a>
            </div>
        </div>
    </div>

    <?php 
        include 'includes/jsScript.php';
    ?>   
         
       
    <?php
        include 'includes/footer.php';
    ?>