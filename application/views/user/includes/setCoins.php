<div class="chipDV">
    <a class="chip coin" id="coin1" onclick="setCoin(1)">
        <img src="<?=base_url()?>assets/images/chips1.png" alt="">
    </a>
    <a class="chip coin" id="coin5" onclick="setCoin(5)">
        <img src="<?=base_url()?>assets/images/chips2.png" alt="">
    </a>
    <a class="chip coin" id="coin10" onclick="setCoin(10)">
        <img src="<?=base_url()?>assets/images/chips3.png" alt="">
    </a>
    <a class="chip coin" id="coin20" onclick="setCoin(20)">
        <img src="<?=base_url()?>assets/images/chips4.png" alt="">
    </a>
    <a class="chip coin" id="coin50" onclick="setCoin(50)">
        <img src="<?=base_url()?>assets/images/chips5.png" alt="">
    </a>
    <a class="chip coin" id="coin100" onclick="setCoin(100)">
        <img src="<?=base_url()?>assets/images/chips6.png" alt="">
    </a>
    <!-- <a class="chip coin" id="coin200" onclick="setCoin(200)">
        <img src="<?=base_url()?>assets/images/chips7.png" alt="">
    </a> -->
    <a class="chip coin" id="coin500" onclick="setCoin(500)">
        <img src="<?=base_url()?>assets/images/chips7.png" alt="">
    </a>
        
    <a class="chip coin" id="coin1000" onclick="setCoin(1000)">
        <img src="<?=base_url()?>assets/images/chips8.png" alt="">
    </a>
    <p class="betTxt">SELECT THE CHIPS AND BET</p>
</div>
<?php
    if(in_array($_GET['app'],['OS','KS','PS','FB','HM'])){
        $crn = 'INR';
    }else if($_GET['app']=='PH'){
        $crn = 'PHP';
    }else if($_GET['app']=='BD'){
        $crn = 'BDT';
    }else{
        $crn = $_GET['app'];
    }
?>
<div class="totalBet">
    <p>Total Bet <span class="ramt"> <?=$crn;?> <span id="totalAmount">0.0</span></span></p>
</div>