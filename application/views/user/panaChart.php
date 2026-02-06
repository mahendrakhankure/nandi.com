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
    .coin{
        cursor: pointer;
    }
    .chipbox{
        position: relative;
        text-align: center;
        color: white;
    }
    .centered {
      position: absolute;
      top: 30%;
      left: 50%;
      transform: translate(-50%, -50%);
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
                            <option value="<?=$status[0]['date']?>"><?=$status[1]['date']?></option>
                            <option value="<?=$status[0]['date']?>"><?=$status[2]['date']?></option>
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
        </div>
    </div>

    <div class="container">
        <div class="rows">
            <div class="col-12 mychips-wrapper">
                <h4 class="text-center" >Select the chips and Bet</h4>
                <div class="mychips">
                     
                    
                    <div class="chip-option-wrapper coin" id="coin1" onclick="setCoin(1)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips1.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin5" onclick="setCoin(5)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips2.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin10" onclick="setCoin(10)">
                        <div class="chip">    
                            <img src="<?=base_url()?>assets/images/chips3.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin20" onclick="setCoin(20)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips4.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin50" onclick="setCoin(50)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips5.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin100" onclick="setCoin(100)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips6.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin200" onclick="setCoin(200)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips7.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin500" onclick="setCoin(500)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips8.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin"  id="coin1000" onclick="setCoin(1000)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips9.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 darkbg c-boxes ">
                <div class="chipbox-wrapper" id="dome">
                    
                </div>
                <div class="total-wrapper">
                    <div class="undo" onclick="undo('Single')">
                        <span><i class="fa-solid fa-rotate-left"></i></span>
                        <p>Undo</p>
                    </div>
                    <div class="total">
                        
                        <div class="total-box">
                            <h4>Total Amount</h4>
                                <div id="totalAmount">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 chipbox-action" id="pBet">
                <a href="javascript:void(0)" onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)">PLACE BET</a>
                <a href="javascript:void(0)" onclick="resetAll()">RESET BET</a>
            </div>
        </div>
    </div>
<div class="container" style="width: 100%; height:100px; visibility:hidden;">
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        if(<?=$gameDetail['id']?>==26){
            var res = panaChart52();
        }else if(<?=$gameDetail['id']?>==27){
            var res = panaChart56();
        }else if(<?=$gameDetail['id']?>==28){
            var res = panaChart77();
        }else if(<?=$gameDetail['id']?>==29){
            var res = allFigureHalfRedPana();
        }else if(<?=$gameDetail['id']?>==25){
            var res = favoritePana();
        }else if(<?=$gameDetail['id']?>==31){
            var res = nonFavoritePana();
        }else if(<?=$gameDetail['id']?>==32){
            var res = touchChipkePana();
        }else if(<?=$gameDetail['id']?>==33){
            var res = untouchBikhrePana();
        }
        $(res).each(function(i) {
            dome='<div class="chipbox-inner-wrapper" onclick="addCoinSingleDigit('+res[i]+',/SingleDigit/)"><span>'+res[i]+'</span><div class="chipbox"><span id="Single'+res[i]+'Akda" class="centered"></span></div></div>';
            $('#dome').append(dome);
        });
    });
</script>