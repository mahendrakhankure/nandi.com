<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name']))); 
    if($gameDetail['id']=='5'){
        $sA = 'Select All Akda';
    }else{
        $sA = 'Select All Patti';
    }
?>
<div class="container container-custom">
    <?php include 'includes/betLoader.php'; ?>
        <div class="controlDv">
            <?php include 'includes/selectGames.php'; ?>
            <?php include 'includes/blankChips.php'; ?>
        </div>
        <!-- <p class="betNote"> NOTE : BET AMOUNT SHOULD GREATER OR EQUAL TO <?=$param['type_id']==5?'10':'5';?> </p> -->
        <?php include 'includes/betMinMax.php'; ?>
        <div class="game-type-wrapper">
            <div class="opnCLse" id="game-open-close">   
                <form class="chk-form"> 
                    <div class="gt-open chkL">
                        <input type="radio" id="open" name="gt-radio" value="open" <?= $status[0]['game_type1'] == 'NULL' ? 'disabled':''; ?>>
                        <label for="open">Open</label>
                    </div>
                    <div class="gt-close chkL">
                        <input type="radio" id="close" name="gt-radio" value="close" <?= $status[0]['game_type2'] == 'NULL' ? 'disabled':''; ?>>
                        <label for="close">Close</label>
                    </div>
                </form>         
            </div>
            <span class="blink_me" id="blink_me"><?= $status[0]['game_type1'] == 'NULL' ? 'Open Result Is Already Decleared':''; ?></span>
        </div>
        <?php include 'includes/setCoins.php'; ?>
        <div class="clrBoth"></div>
        <div class="col-12 cplace-outer">

                        <div class="cplace-wrapper" id = "dome">
        <span class="betPlaceTabel">
            <table class="table">
                <tbody>
                    
                    
                        <?php
                        foreach(array_chunk($patti, 5) as $p) { 
                            echo '<tr>';
                            foreach($p as $i){
                        ?>
                            <td>
                                <div class="cplace place-input-main" onclick="addCoinSingleDigit(<?=$i?>, '<?=$page?>')">
                                    <label class="inputNo"><?=$i?></label>
                                    <div class="cplace-box btInput pos">
                                        <div id="<?=$page.$i?>Akda-wrapper" class="text-center"></div>
                                    </div>
                                </div>          
                            </td>
                        <?php
                            }
                            echo '</tr>';
                        }
                        ?> 
                       
                </tbody>
            </table>
        </span>
        </div>
                    
                    </div>
                    
        <?php include 'includes/resultSection.php'; ?>
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
        if(<?=$gameDetail['id']?>!=5 && <?=$gameDetail['id']?>!=4){
            if(parseInt(viewWidth) <= 340) {
                cplaceHeight = viewHeight-360;
                $(".cplace-outer").height(cplaceHeight);
            }
            if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
                cplaceHeight = viewHeight-370+40;
                $(".cplace-outer").height(cplaceHeight);
            }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
                cplaceHeight = viewHeight-394;
                $(".cplace-outer").height(cplaceHeight);
            }else if(parseInt(viewWidth) >= 768) {
                cplaceHeight = viewHeight-359;
                $(".cplace-outer").height(cplaceHeight);
            }   
        }else{
            console.log('working')
            cplaceHeight = viewHeight-396+28;
            $(".cplace-outer").height(cplaceHeight);
        }
    }); 
    </script>


     <!-- <script type="text/javascript">
    $(document).ready(function() {
        if(<?=$gameDetail['id']?>==2){
            var ty = 'DP';
        }else if(<?=$gameDetail['id']?>==1){
            var ty = 'SP';
        }
        var data = checkPannaType('SP/DP/TP',ty);
        $(data).each(function(i) {
            dome='<div class="cplace" onclick="addCoinSingleDigit('+data[i]+',\'<?=$page?>\')"><span>'+data[i]+'</span><div class="cplace-box"><div id="<?=$page?>'+data[i]+'Akda-wrapper" class="text-center"></div></div></div>';
            $('#dome').append(dome);
        });


        // <div class="cplace" onclick="addCoinSingleDigit(<?=$i?>, '<?=$page?>')"><span><?=$i?></span>
        //                 <div class="cplace-box" >
        //                     <div id="<?=$page.$i?>Akda-wrapper" class="text-center"></div>
        //                 </div>
        //             </div>   
    }); -->
<!-- </script> -->