<div class="betResSection">
    <a href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
    <?php
        if(!in_array($param['type_id'], [7,11,12,13,14,15,16,17,18,19,20])){
    ?>
        <a href="javascript:void(0)" onclick="undo('<?=$page?>')" class="imgBtn"><img src="<?=base_url()?>assets/images/undo.png"> Undo</a>
    <?php
        }
    ?>
    <div class="clrBoth"></div>
    <a href="javascript:void(0)" onclick="placeBet(<?=$param['bazar_id']?>,<?=$param['type_id']?>)"class="plceBet">Place Bet</a>
    <span class="separate"></span>
    <h5 class="lrest">Last Result</h5>
    <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[0]['result_date']))?> <span><?=$gameResult[0]['open']?>-<?=$gameResult[0]['jodi']?>-<?=$gameResult[0]['close']?></span></p>
    <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[1]['result_date']))?> <span><?=$gameResult[1]['open']?>-<?=$gameResult[1]['jodi']?>-<?=$gameResult[1]['close']?></span></p>
    <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[2]['result_date']))?> <span><?=$gameResult[2]['open']?>-<?=$gameResult[2]['jodi']?>-<?=$gameResult[2]['close']?></span></p>
    <p class="lresDate"><?=date('d-m-Y',strtotime($gameResult[3]['result_date']))?> <span><?=$gameResult[3]['open']?>-<?=$gameResult[3]['jodi']?>-<?=$gameResult[3]['close']?></span></p>
    
</div> 