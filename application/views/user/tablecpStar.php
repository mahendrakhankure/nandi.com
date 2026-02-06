<?php 
    include 'includes/header.php'; 
?>
    <div class="container container-custom">
    <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <div class="batt-name select-wrapper">
                <?php include 'includes/selectGamesStar.php'; ?>
            </div>  
            <div class="select-date select-wrapper dark">
                <select class="akdC" name="batt-date" id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
            </div> 
        </div>
        <div class="container" style="display:none;">
            <div class="rows">
                <div class="col-md-8 col-sm-10 col-xs-10 offset-md-2 offset-sm-1  game-type-wrapper">
                    <div class="game-type">
                        <input type="hidden" name="starTime" value="<?=$marketTime['time']?>" id="starTime" style="display:none;">
                        <input type="hidden" name="time" value="<?=$param['time']?>" id="time" style="display:none;">
                        <input type="radio" id="Jodi" name="gt-radio" value="Jodi" style="display:none;" checked>
                    </div>
                    
                </div>
            </div>
        </div>
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
        
          <div class="controlDv">
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
            <a href="javascript:void(0)"  onclick="addBets('choicePana')" class="btn sl-all">+ Add More</a>
            <!-- <button class="right-al akdC" onclick="addBets('choicePana')">+ Add More</button> -->
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
        <div class="betResSection">
            <a href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
            <div class="clrBoth"></div>
            <a href="javascript:void(0)" onclick="placeBetStar(<?=$param['bazar_id']?>,<?=$param['game_id']?>)" class="plceBet">Place Bet</a>
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