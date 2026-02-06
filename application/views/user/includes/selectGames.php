<select class="akdC" name="game-list" id="game_list" onchange="location = this.value;">
    <?php
        foreach($gameList as $g){
    ?>
        <option value="<?=base_url().'2f7b8019e658ea93b1e4d76ac4c6096f/'.$param['bazar_id'].'/'.$g['id'].'/'.$param['bazar_result']?><?=$tUrl?>" <?= $gameDetail['id']==$g['id']?'selected':''; ?>>
            <h3>
                <!-- <?php
                    if(array_slice(explode(' ', $string), -1)[0]=='SP'){
                        echo preg_replace('/\W\w+\s*(\W*)$/', '$1', $txt);
                    }else{
                        echo $g['game_name'];        
                    }
                ?> -->
                <?php
                    if(in_array($g['id'], [20,24,19,29,30])){
                        echo substr($g['game_name'], 0, -3);   
                    }else if($g['id']==7){
                        echo 'CHOICE PANA';
                    }else if($g['id']==18){
                        echo 'TWO DIGIT PANEL(CP,SR)';
                    }else{
                        echo $g['game_name'];
                    }
                ?>
            </h3>
        </option>
    <?php
        }
    ?>
</select>