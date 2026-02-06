<?php
    if(!in_array($param['type_id'], [7,11,12,13,14,15,16,17,18,19,20])){
?>
<img src="<?=base_url()?>assets/images/blankchips01.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips02.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips03.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips04.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips05.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips06.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips07.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips08.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips09.png" style="display: none;">
<?php
    }
?>
<select class="akdC" name="batt-date"  id="date" onchange="checkOpenCloseRegular('<?=$status[0]['game_type1']?>','<?=$status[0]['game_type2']?>')">
    <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
    <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
    <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
</select>