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
    <p>Total Bet <span class="ramt"> <?= $crn;?> <span id= "totalAmount">0.0</span></span></p>
</div>