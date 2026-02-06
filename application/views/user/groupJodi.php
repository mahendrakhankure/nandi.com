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
                        <select class="game-time darkbg myborder text-center" id="date">
                            <option value="<?=$status[0]['date']?>"><?=$status[0]['date']?></option>
                            <option value="<?=$status[1]['date']?>"><?=$status[1]['date']?></option>
                            <option value="<?=$status[2]['date']?>"><?=$status[2]['date']?></option>
                        </select>
                    </h3>
                </div>  
            </div>
            <!--  -->
            <div class="col-md-8 offset-md-2 p5-bet-form">
            <span class="btn" id="allPattiSelect" onclick="selectAllPattiSingleDigit('<?=$gameDetail['id']?>','<?=$page?>')">Select All Patti</span>
                <h2 class="g-name text-center">Group Jodi</h2>

                <input type="number" name="ent-digit" id="ent-digit" placeholder="Enter Digit" required maxlength="2" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                <input type="number" name="ent-amount" id="ent-amount" placeholder="Enter Amount" required maxlength="4" onkeypress="return isNumber(event)" oninput="maxLengthCheck(this)">
                <button onclick="addJodiBets('groupJodi')">+ Add More</button>

                <table>
                    <tr class="table-header">
                      <th>Jodi</th>
                      <th>Points</th>
                      <th></th>
                    </tr>
                </table>
                <div class="total-bid">
                     <p>Total Amount <span id="totalAmount">0</span></p>
                     <p>Bid Amount <span id="totalBet">0</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="rows">          
            <div class="col-12 chipbox-action" id="pBet">
                <a onclick="PlaceBets(<?=$param['bazar_id']?>,<?=$param['type_id']?>)" style="cursor: pointer;">PLACE BET</a>
                <a onclick="resetAll()" style="cursor: pointer;">RESET BET</a>
            </div>
        </div>
    </div>
    
    
<div class="container" style="width: 100%; height:100px; visibility:hidden;">

</div>
<script type="text/javascript">


    // function PlaceBets(){
    //     console.log(data)
    //     if(data.length>0){
    //         $.ajax({
    //             type:"post",
    //             dataType: 'json',
    //             url: "<?php echo base_url(); ?>5d28279d2fbc52cd3d81275f5a65ae0e",
    //             data:data,
    //             success:function(response){ 
    //                 console.log(response);
    //                 if (response.successmsg == 'deleted') {
    //                     $("#row_div_"+removeid).remove();
    //                 }else{
    //                     alert('Error');
    //                 }
    //             }
    //         });
    //     }else{
    //         error('Please Select The Bet')
    //     }
    // }   

</script>
<?php include 'includes/footer.php'; ?>
