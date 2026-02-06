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
                <h3 >NOTE:- BET AMOUNT SHOULD GREATER OR EQUAL TO 10</h3>
            </div>
            <div class="col-12 div-center">  
                <div class="">
                    <select class="game-time darkbg myborder text-center" id="date">
                        <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                        <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                        <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                    </select>
                </div>  
            </div>
            <div class="col-md-4 offset-md-4">
                <div class="game-selection" >
                    <select class="form-select" aria-label="Game Selection" id="typeOfJodi" onchange="getGameTypePatti(this.value)" >
                        <option selected >Choose a Game</option>
                        <option value="EE">Even Even Jodi</option>
                        <option value="OO">Odd Odd Jodi</option>
                        <option value="OE">Odd Even Jodi</option>
                        <option value="EO">Even Odd Jodi</option>
                        <option value="All">Jodi All</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="rows">
            <div class="col-12 mychips-wrapper">
                <h4 class="text-center" >Select the chips and Bet</h4>
                <div class="mychips">
                     
                    <input type="radio" id="jodi" checked name="gt-radio" value="Jodi" style="display:none;">
                    <div class="chip-option-wrapper coin" onclick="setCoin(1)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips1.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(5)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips2.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(10)">
                        <div class="chip">    
                            <img src="<?=base_url()?>assets/images/chips3.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(20)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips4.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(50)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips5.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(100)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips6.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(200)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips7.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(500)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips8.png" alt="">
                        </div>
                    </div>
                    <div class="chip-option-wrapper coin" onclick="setCoin(1000)">
                        <div class="chip">
                            <img src="<?=base_url()?>assets/images/chips9.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 darkbg c-boxes ">
                
                <div class="chipbox-wrapper" id="getJodiPana">
                    <?php
                        for($i=0;$i<100;$i++){
                    ?>
                        <div class="chipbox-inner-wrapper" onclick="addCoinJodiAll(<?=$i?>),'JodiAll'">
                            <span><?=str_pad($i, 2, '0', STR_PAD_LEFT)?></span>
                            <div class="chipbox">
                                <span id="Jodi<?=$i?>Akda" class="centered"></span>
                            </div>
                        </div>
                    <?php
                        }
                    ?> 
                </div>
                <div class="total-wrapper">
                    <div class="undo" onclick="undo('Jodi')">
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
    
    
 
<?php include 'includes/footer.php'; ?>