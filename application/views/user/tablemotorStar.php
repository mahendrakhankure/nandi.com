<?php 
    include 'includes/header.php'; 
    if($gameDetail['id']==12){
        $gameDetail['game_name']=substr($gameDetail['game_name'],0,-3);
    }
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));
    if($gameDetail['id']==12 || $gameDetail['id']==23 || $gameDetail['id']==35){
        $page="twoDigitPanel";
    }
?>
       
       <div class="container container-custom">
       <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <div class="batt-name select-wrapper">
                <?php include 'includes/selectGamesStar.php'; ?>
            </div>  
            <div class="select-date select-wrapper dark">
                <input type="hidden" name="starTime" value="<?=$marketTime['time']?>" id="starTime">
                <input type="hidden" name="time" value="<?=$param['time']?>" id="time">
                <select class="akdC" name="batt-date" id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
            </div> 
        </div>
        <input type="radio" id="open" name="gt-radio" value="open" checked style="display:none;">
        
        <?php include 'includes/betMinMax.php'; ?>
        
        <div class="container">
            <div class="rows">
                <div class="col-md-8 col-sm-12 offset-md-2">
                    <div class="bett-var-form">
                        <h3 class="bettin text-center heading" id = "game-name"><?=$gameDetail['game_name']?></h3>
                        <div class="var-type-sf controlDv">
                            <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required minlength="4" maxlength="10" onkeyup="return SPDPDigit('<?=$page?>', this.value, event)" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                            <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="4"   onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                        </div>
                        <div class="var-type-btn controlDv">
                            <a href="javascript:void(0)"  onclick="addBets('<?=$page?>')" class="btn sl-all">+ Add More</a>
                            <!-- <button onclick="addBets('<?=$page?>')">+ Add More</button> -->
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
        
        <?php include 'includes/totalBetBox.php'; ?>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
        <div class="betPlaceTabel pana-Table">
            <table class="table text-center">
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
            cplaceHeight = viewHeight-370-42;
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