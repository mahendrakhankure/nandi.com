<select name="game-list" class="form-select l akdC" id="game_list" onchange="location = this.value;">
    <?php
        foreach($gameType as $g){
    ?>
        <option value="<?=base_url().'d04cd65a193d25064eb7375b799adc29/'.$param['bazar_id'].'/'.$g['id'].'/'.$param['time']?><?=$tUrl?>" <?= $gameDetail['id']==$g['id']?'selected':''; ?>>
            <h3>
                <?=$g['game_name'];?>
            </h3>
        </option>
    <?php
        }
    ?>
</select>