<?php include 'includes/header.php';
?>
<style type="text/css">
    
    #rG,#sG,#kG,#baz{
        display: none;
    }
    .chosen-container{
        width: 100% !important;
    }
    table,.Headding{
        text-align: center;
    }
    table tr th{
        text-align: center;
    }

    .switch {
      position: relative;
      display: inline-block;
      vertical-align: top;
      width: 56px;
      height: 20px;
      padding: 3px;
      background-color: white;
      border-radius: 18px;
      box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
      cursor: pointer;
      background-image: -webkit-linear-gradient(top, #eeeeee, white 25px);
      background-image: -moz-linear-gradient(top, #eeeeee, white 25px);
      background-image: -o-linear-gradient(top, #eeeeee, white 25px);
      background-image: linear-gradient(to bottom, #eeeeee, white 25px);
    }



    .switch-input {
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
    }

    .switch-label {
      position: relative;
      display: block;
      height: inherit;
      font-size: 10px;
      text-transform: uppercase;
      background: #eceeef;
      border-radius: inherit;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
      -webkit-transition: 0.15s ease-out;
      -moz-transition: 0.15s ease-out;
      -o-transition: 0.15s ease-out;
      transition: 0.15s ease-out;
      -webkit-transition-property: opacity background;
      -moz-transition-property: opacity background;
      -o-transition-property: opacity background;
      transition-property: opacity background;
    }
    .switch-label:before, .switch-label:after {
      position: absolute;
      top: 50%;
      margin-top: -.5em;
      line-height: 1;
      -webkit-transition: inherit;
      -moz-transition: inherit;
      -o-transition: inherit;
      transition: inherit;
    }
    .switch-label:before {
      content: attr(data-off);
      right: 11px;
      color: #aaa;
      text-shadow: 0 1px rgba(255, 255, 255, 0.5);
    }
    .switch-label:after {
      content: attr(data-on);
      left: 11px;
      color: white;
      text-shadow: 0 1px rgba(0, 0, 0, 0.2);
      opacity: 0;
    }
    .switch-input:checked ~ .switch-label {
      background: #47a8d8;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
    }
    .switch-input:checked ~ .switch-label:before {
      opacity: 0;
    }
    .switch-input:checked ~ .switch-label:after {
      opacity: 1;
    }

    .switch-handle {
      position: absolute;
      top: 4px;
      left: 4px;
      width: 18px;
      height: 18px;
      background: white;
      border-radius: 10px;
      box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
      background-image: -webkit-linear-gradient(top, white 40%, #f0f0f0);
      background-image: -moz-linear-gradient(top, white 40%, #f0f0f0);
      background-image: -o-linear-gradient(top, white 40%, #f0f0f0);
      background-image: linear-gradient(to bottom, white 40%, #f0f0f0);
      -webkit-transition: left 0.15s ease-out;
      -moz-transition: left 0.15s ease-out;
      -o-transition: left 0.15s ease-out;
      transition: left 0.15s ease-out;
    }
    .switch-handle:before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -6px 0 0 -6px;
      width: 12px;
      height: 12px;
      background: #f9f9f9;
      border-radius: 6px;
      box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
      background-image: -webkit-linear-gradient(top, #eeeeee, white);
      background-image: -moz-linear-gradient(top, #eeeeee, white);
      background-image: -o-linear-gradient(top, #eeeeee, white);
      background-image: linear-gradient(to bottom, #eeeeee, white);
    }
    .switch-input:checked ~ .switch-handle {
      left: 40px;
      box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
    }

    .switch-green > .switch-input:checked ~ .switch-label {
      background: #4fb845;
    }
    #stremingRegular iframe {
        height: 251.75px;
        width: 75%;
    }
    .akdaPoint{
        cursor: pointer;
    }
    .sty{
        color:#fff;
    }
    .sty div {
        border-radius: 5px;
    }
    .meaningOfColor{
        height:25px;
        width: 20px;
    }
    .meaningOfColorP p{
        float:left;
        margin: 0px 15px;
    }
    .table>tbody>tr>td{
        padding:2px !important;
    }
    .table-striped tr td {
        color:#fff;
    }
</style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <p>Regular Round Statment</p>
                    <!-- <p>
                        Total Bet On Akda :<span id="totalAkda">0</span>-<span id="totalAkdaWin">0</span>=<span id="totalAkdaGgr">0</span> 
                        <span style='float: right;'>Total Bet On Patti :<span id="totalPatti">0</span>-<span id="totalPattiWin">0</span>=<span id="totalPattiGgr">0</span></span>
                    </p> -->
                    

                    <label class="switch" id="bufLable" style="display:none;">
                      <input type="checkbox" class="switch-input" id="buf">
                      <span class="switch-label" data-on="On" data-off="Off"></span>
                      <span class="switch-handle"></span>
                    </label>
                    <span id="showResult"></span>
                    <label class="switch" style="width: 68px !important;float: right;">
                      <input type="checkbox" class="switch-input" id="buf1">
                      <span class="switch-label" data-on="Open" data-off="Close"></span>
                      <span class="switch-handle"></span>
                    </label>
                    <div class="form-group">
                        <label for="game_in_week">Bazar Name</label>
                        <select class="form-control" id="game_name" name="bazar_name" onchange="getData()">
                            <option value="">Select Bazar Name...</option>
                            <?php foreach ($bazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>" id="bazar_<?php echo $b['id']; ?>"><?= $b['bazar_name'].' ('.$b['open_time'].'-'.$b['close_time'].')'; ?></option>
                            <?php } ?>    
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="res" maxlength='3' readonly placeholder="Result"/>
                        <span class="btn btn-primary m-2" id="resWorli">Submit</span>
                    </div>
                    <div class="col-md-6">
                        <input type='date' name='date' id='date' placeholder='date' value='<?=date('Y-m-d')?>' class="form-control" onchange="getData()">
                    </div><div class="col-md-6">
                        <input type='number' name='Percentage' id='Percentage' placeholder='Percentage' value='0' max="99" class="form-control form-inline" onKeyPress="if(this.value.length==2) return false;" onchange="calculatePercentage()">
                    </div>
                </div>
                <div class="col-md-6 promo-video" id="stremingRegular">
                    <span><i class="fa-solid fa-message"></i></span>
                    <iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-2" title="Live Satta Result" id="iFrameWinRegular"></iframe>
                    <span class="btn btn-primary m-2" id="cut" style='display:none;'>Cut</span>
                </div>
                <div class="col-md-12 meaningOfColorP">
                    <p><span class="meaningOfColor btn" style="background-color:#2eb998;"></span>Total Amount Of Bet</p>
                    <p><span class="meaningOfColor btn" style="background-color:#3E5C78;"></span>Client Stack</p>
                    <p><span class="meaningOfColor btn" style="background-color:#EF974A;"></span>Our Stack</p>
                    <p><span class="meaningOfColor btn" style="background-color:#4C96B1;"></span>Total No. Of Bets</p>
                    <p><span class="meaningOfColor btn" style="background-color:#B2A24B;"></span>Total Players</p>
                    <p><span class="meaningOfColor btn" style="background-color:#9063BE;"></span>Cutting Amount</p>
                    <p><span class="meaningOfColor btn" style="background-color:#BA2E6B;"></span>Amount After Cutting</p>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Akda</th>
                            <th>Single Patti</th>
                            <th>Double Patti</th>
                            <th>Triple Patti</th>
                            <th>Jodi</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background-color: #2eb998;">
                            <td id="akdaTotal"></td>
                            <td id="singleTotal"></td>
                            <td id="doubleTotal"></td>
                            <td id="tripleTotal"></td>
                            <td id="jodiTotal"></td>
                            <td><b id="totalBA"></b></td>
                        </tr>
                        <tr style="background-color: #3E5C78;">
                            <td id="akdaTotalCP"></td>
                            <td id="singleTotalCP"></td>
                            <td id="doubleTotalCP"></td>
                            <td id="tripleTotalCP"></td>
                            <td id="jodiTotalCP"></td>
                            <td><b id="totalCP"></b></td>
                        </tr>
                        <tr style="background-color: #EF974A;">
                            <td id="akdaTotalOP"></td>
                            <td id="singleTotalOP"></td>
                            <td id="doubleTotalOP"></td>
                            <td id="tripleTotalOP"></td>
                            <td id="jodiTotalOP"></td>
                            <td><b id="totalOP"></b></td>
                        </tr>
                        <tr style="background-color: #a1dfd2;">
                            <td id="akdaTotalBet"></td>
                            <td id="singleTotalBet"></td>
                            <td id="doubleTotalBet"></td>
                            <td id="tripleTotalBet"></td>
                            <td id="jodiTotalBet"></td>
                            <td><b id="totalBet"></b></td>
                        </tr>
                        <tr style="background-color: #8c8d32;">
                            <td id="akdaTotalPlayer"></td>
                            <td id="singleTotalPlayer"></td>
                            <td id="doubleTotalPlayer"></td>
                            <td id="tripleTotalPlayer"></td>
                            <td id="jodiTotalPlayer"></td>
                            <td><b id="totalPlayer"></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <table class="table">
                        <thead>
                            <tr class='akdaPoint'>
                                <th id="0A">0</th>
                                <th id="1A">1</th>
                                <th id="2A">2</th>
                                <th id="3A">3</th>
                                <th id="4A">4</th>
                                <th id="5A">5</th>
                                <th id="6A">6</th>
                                <th id="7A">7</th>
                                <th id="8A">8</th>
                                <th id="9A">9</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="0">0</td>
                                <td id="1">0</td>
                                <td id="2">0</td>
                                <td id="3">0</td>
                                <td id="4">0</td>
                                <td id="5">0</td>
                                <td id="6">0</td>
                                <td id="7">0</td>
                                <td id="8">0</td>
                                <td id="9">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 offset-md-6">
                    <div id="tpDome"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div id="spDome"></div>
                </div>
                <div class="col-md-6 offset-md-6">
                    <div id="dpDome"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="jodiDomeCut"></div>
                    <div id="jodiDome"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    var singleAkda = "<?=$bhav[3]['bhav']?>";
    var singlePatti = "<?=$bhav[0]['bhav']?>";
    var doublePatti = "<?=$bhav[1]['bhav']?>";
    var triplePatti = "<?=$bhav[2]['bhav']?>";
    var resultA;
    var resultP;
    var bPatti='';


    var sp = getPattiAkdaWise('SinglePatti');
    var dp = getPattiAkdaWise('DoublePatti');
    var jodi = [['00','01','02','03','04','05','06','07','08','09'],['10','11','12','13','14','15','16','17','18','19'],['20','21','22','23','24','25','26','27','28','29'],['30','31','32','33','34','35','36','37','38','39'],['40','41','42','43','44','45','46','47','48','49'],['50','51','52','53','54','55','56','57','58','59'],['60','61','62','63','64','65','66','67','68','69'],['70','71','72','73','74','75','76','77','78','79'],['80','81','82','83','84','85','86','87','88','89'],['90','91','92','93','94','95','96','97','98','99']];
    // For Singal Patti Start
    var spdome = '<table class="table"><tbody>';
    $(sp).each(function(t) {
        spdome += '<tr>';
        $(sp[t]).each(function(l) {
            spdome += '<th id="'+sp[t][l]+'P" onclick="setPatti('+sp[t][l]+')">'+sp[t][l]+'</th>';
        });
        spdome += '</tr><tr>';
        $(sp[t]).each(function(l) {
            spdome += '<td id="'+sp[t][l]+'">0</td>';
        });
        spdome += '</tr>';
    });
    spdome += '</tbody></table>';
    $('#spDome').append(spdome);

    // For Double Patti Start
    var dpdome = '<table class="table"><tbody>';
    $(dp).each(function(t) {
        dpdome += '<tr>';
        $(dp[t]).each(function(l) {
            dpdome += '<th id="'+dp[t][l]+'P" onclick="setPatti('+dp[t][l]+')">'+dp[t][l]+'</th>';
        });
        dpdome += '</tr><tr>';
        $(dp[t]).each(function(l) {
            dpdome += '<td id="'+dp[t][l]+'">0</td>';
        });
        dpdome += '</tr>';
    });
    dpdome += '</tbody></table>';
    $('#dpDome').append(dpdome);

    // For Triple Patti Start
    var tpdome = '<table class="table"><tbody><tr>';
    var tp = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    
    $(tp).each(function(l) {
        tpdome += '<th id="'+tp[l]+'P" onclick="setPatti('+tp[l]+')">'+tp[l]+'</th>';
    });
    tpdome += '</tr><tr>';
    $(tp).each(function(l) {
        tpdome += '<td id="'+tp[l]+'">0</td>';
    });
    
    tpdome += '</tr></tbody></table>';
    $('#tpDome').append(tpdome);


    function setJodi(){
        $('#jodiDome').empty();
        $('#jodiDomeCut').html('<input type="number" name="cutting" id="cutting" placeholder="Cutting" max="9" class="form-control form-inline" onKeyPress="if(this.value.length==1) return false;" onchange="calculateCutting()">');
        
        // if(!$("#buf1").is(":checked")){
            $('#jodiDome').show();
            var jodidome = '<table class="table"><tbody>';
            $(jodi).each(function(t) {
                jodidome += '<tr>';
                $(jodi[t]).each(function(l) {
                    jodidome += '<th id="'+jodi[t][l]+'P">'+jodi[t][l]+'</th>';
                });
                jodidome += '</tr><tr>';
                $(jodi[t]).each(function(l) {
                    jodidome += '<td id="'+jodi[t][l]+'">0</td>';
                });
                jodidome += '</tr>';
            });
            jodidome += '</tbody></table>';
            $('#jodiDome').append(jodidome);
        // }else{
        //     $('#jodiDome').hide();
        // }
    }
    
    function setPatti(q){
        if(bPatti!=''){
            $('#'+bPatti+'P').css({'background-color': '#f4f4f4','color': '#333'})
        }
        bPatti=q;
        $.ajax({
            type: "POST",
            url: base_url+"/33e5297a14f36c67dffc9de09970384a",
            data: {bPatti:bPatti,id:'4'},
            success: function (res) {
                var nR = JSON.parse(res);
                if(nR.status==200){
                    bPatti = q;
                    $('#res').val(bPatti);
                    
                    $('#'+q+'P').css({'background-color': 'orange','color': '#fff'})
                }else{
                    alert(nR.massage)
                    return false;
                }
            }
        });
    }   


    function addRemoveAttr(t){
        if(t=='show'){
            $(".flexbox1").attr('class', 'flexbox');
        }else if('hide'){
            $(".flexbox").attr('class', 'flexbox1');
        }
    }
    var akData;
    var spData;
    var dpData;
    var tpData;
    var jodiData;
    // var url = 'http://localhost/stagging_nandi';
    var op = 'Close';
    $('#buf1').click(function(){
        if($("#buf1").is(":checked")){
            op = 'Open';
            getData();
        }else{
            op = 'Close';
            getData();
        }
    });
    // $('.flexbox').show();
    async function getData(){
        var bazar = $('#game_name').val();
        var rDate = $('#date').val();
        if(!bazar){
            alert('Plz select bazar')
            return;
        }
        // addRemoveAttr('hide');
        var totalBA = 0;
        var totalCP = 0;
        var totalOP = 0;
        var totalBet = 0;
        var totalPlayer = 0;
        var flexbox = 0;
        if(op=='Close'){
            flexbox--;
        }
        
        if("<?=date('Y-m-d')?>" != rDate){
            $('#Percentage').attr("disabled", true)
        }else{
            $('#Percentage').attr("disabled", false)
        }
        clearData();
        if(bazar){
            setJodi();
            var cuttingP = $('#Percentage').val();
            var aD = await $.ajax({
                type: "POST",
                url: base_url+"/aaaca16a7669672bc7f438c88c9432cf",
                data: {bazar:bazar,resultDate:rDate,gType:op},
                cache : false,
                async : true,
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.status==200){
                        var d = nR.data;
                        if(d.close==null){
                            var c = '';
                        }else{
                            var c = '-'+d.close;
                        }
                        var h = d.open+'-'+d.jodi+c;

                        $('#cutting').val(d.jodi[0])
                        if(d.cutting){
                            cuttingP = d.cutting['cuttingPercentage'];
                        }
                    }else{
                        var h = nR.data;
                    }
                    $('#showResult').text(h).css({'background-color': '#27b45b','color': '#fff','font-weight': '900','padding': '5px','border-radius': '7px'});
                    
                }
            });
            
            $.ajax({
                type: "POST",
                url: base_url+"/ba12cb7f1e10a13d014c07c9c37a1e9c",
                data: {bazar:bazar,type:'Akda',op:op,resultDate:rDate,gType:op},
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.cutting){
                        cuttingP = nR.cutting.cuttingPercentage; 
                        $('#Percentage').val(cuttingP);
                    }else{
                        cuttingP = 0; 
                        $('#Percentage').val(0);
                    }
                    akData = nR;
                    var akdaTotal = 0;
                    var totalClientP = 0;
                    var tPlayer = 0;
                    var tBet = 0;
                    var ak = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    $(ak).each(function(l) {
                        if(nR.data[ak[l]]){
                            akdaTotal += parseInt(nR.data[l]);
                            var clinetP = nR.calPer[l]['cP'];
                            // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[l]);
                            totalClientP +=clinetP;
                            tPlayer += parseInt(nR.dataDistinct[l]);
                            tBet += parseInt(nR.dataCount[l]);
                            var myP = nR.data[l]-clinetP;
                            var cPer = (myP * cuttingP/100);
                            var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+nR.data[l]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+nR.dataCount[l]+')</div><div style="background-color: #B2A24B;">('+nR.dataDistinct[l]+')</div>';
                            if(cuttingP > 0){
                                tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                            }
                            tx += '</div>';
                            $('#'+l).html(tx).css({'font-size':'19px'});
                        }
                    });
                    $("#akdaTotal").text(akdaTotal);
                    totalPlayer += tPlayer;
                    totalBet += tBet;
                    $("#akdaTotalPlayer").text(tPlayer);
                    $("#akdaTotalBet").text(tBet);
                    
                    $("#totalPlayer").text(totalPlayer);
                    $("#totalBet").text(totalBet);
                    totalBA +=akdaTotal;
                    totalCP +=Math.round(totalClientP);
                    $("#totalBA").text(totalBA);
                    $("#totalCP").text(totalCP);
                    $("#akdaTotalOP").text(Math.round(akdaTotal-totalClientP));
                    totalOP +=akdaTotal-totalClientP;
                    $("#totalOP").text(Math.round(totalOP));
                    $("#akdaTotalCP").text(Math.round(totalClientP));
                    flexbox++;
                    if(flexbox>3){
                        addRemoveAttr('show');
                        $('#cut').show();
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: base_url+"/ba12cb7f1e10a13d014c07c9c37a1e9c",
                data: {bazar:bazar,type:'SP',op:op,resultDate:rDate,gType:op},
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.cutting){
                        cuttingP = nR.cutting.cuttingPercentage; 
                        $('#Percentage').val(cuttingP);
                    }else{
                        cuttingP = 0; 
                        $('#Percentage').val(0);
                    }
                    spData = nR;
                    var sp = getPanaSpDp('SP');
                    var spTotal = 0;
                    var totalClientP = 0;
                    var tPlayer = 0;
                    var tBet = 0;
                    $(sp).each(function(t) {
                        if(nR.data[sp[t]]){
                            spTotal += parseInt(nR.data[sp[t]]);
                            var clinetP = nR.calPer[sp[t]]['cP'];
                            // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[sp[t]]);
                            tPlayer += parseInt(nR.dataDistinct[sp[t]]);
                            tBet += parseInt(nR.dataCount[sp[t]]);
                            totalClientP +=clinetP;
                            var myP = nR.data[sp[t]]-clinetP;
                            var cPer = (myP * cuttingP/100);
                            var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+nR.data[sp[t]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+nR.dataCount[sp[t]]+')</div><div style="background-color: #B2A24B;">('+nR.dataDistinct[sp[t]]+')</div>';
                            if(cuttingP > 0){
                                tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                            }
                            tx += '</div>';
                            $('#'+sp[t]).html(tx).css({'font-size':'19px'});
                        }
                    });
                    $("#singleTotal").text(spTotal);
                    
                    $("#singleTotalPlayer").text(tPlayer);
                    $("#singleTotalBet").text(tBet);
                    totalPlayer += tPlayer;
                    totalBet += tBet;
                    $("#totalPlayer").text(totalPlayer);
                    $("#totalBet").text(totalBet);
                    totalBA +=spTotal;
                    totalCP +=Math.round(totalClientP);
                    $("#totalBA").text(totalBA);
                    $("#totalCP").text(totalCP);
                    $("#singleTotalOP").text(Math.round(spTotal-totalClientP));
                    totalOP +=spTotal-totalClientP;
                    $("#totalOP").text(Math.round(totalOP));
                    $("#singleTotalCP").text(Math.round(totalClientP));
                    flexbox++;
                    if(flexbox>3){
                        addRemoveAttr('show');
                        $('#cut').show();
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: base_url+"/ba12cb7f1e10a13d014c07c9c37a1e9c",
                data: {bazar:bazar,type:'DP',op:op,resultDate:rDate,gType:op},
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.cutting){
                        cuttingP = nR.cutting.cuttingPercentage; 
                        $('#Percentage').val(cuttingP);
                    }else{
                        cuttingP = 0; 
                        $('#Percentage').val(0);
                    }
                    dpData = nR;
                    var dp = getPanaSpDp('DP');
                    var dpTotal = 0;
                    var totalClientP = 0;
                    var tPlayer = 0;
                    var tBet = 0;
                    $(dp).each(function(p) {
                        if(nR.data[dp[p]]){
                            dpTotal += parseInt(nR.data[dp[p]]);
                            var clinetP = nR.calPer[dp[p]]['cP'];
                            // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[dp[p]]);
                            tPlayer += parseInt(nR.dataDistinct[dp[p]]);
                            tBet += parseInt(nR.dataCount[dp[p]]);
                            totalClientP +=clinetP;
                            var myP = nR.data[dp[p]]-clinetP;
                            var cPer = (myP * cuttingP/100);
                            var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+nR.data[dp[p]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+nR.dataCount[dp[p]]+')</div><div style="background-color: #B2A24B;">('+nR.dataDistinct[dp[p]]+')</div>';
                            if(cuttingP > 0){
                                tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                            }
                            tx += '</div>';
                            $('#'+dp[p]).html(tx).css({'font-size':'19px'});
                        }
                    });
                    $("#doubleTotal").text(dpTotal);
                    
                    
                    totalPlayer += tPlayer;
                    totalBet += tBet;
                    $("#doubleTotalPlayer").text(tPlayer);
                    $("#doubleTotalBet").text(tBet);
                    $("#totalPlayer").text(totalPlayer);
                    $("#totalBet").text(totalBet);
                    totalBA +=dpTotal;
                    totalCP +=Math.round(totalClientP);
                    $("#totalBA").text(totalBA);
                    $("#totalCP").text(totalCP);
                    $("#doubleTotalOP").text(Math.round(dpTotal-totalClientP));
                    totalOP +=dpTotal-totalClientP;
                    $("#totalOP").text(Math.round(totalOP));
                    $("#doubleTotalCP").text(Math.round(totalClientP));
                    flexbox++;
                    if(flexbox>3){
                        addRemoveAttr('show');
                        $('#cut').show();
                    }
                }
            });
            $.ajax({
                type: "POST",
                url: base_url+"/ba12cb7f1e10a13d014c07c9c37a1e9c",
                data: {bazar:bazar,type:'TP',op:op,resultDate:rDate,gType:op},
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.cutting){
                        cuttingP = nR.cutting.cuttingPercentage; 
                        $('#Percentage').val(cuttingP);
                    }else{
                        cuttingP = 0; 
                        $('#Percentage').val(0);
                    }
                    tpData = nR;
                    var tp = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
                    var tpTotal = 0;
                    var totalClientP = 0;
                    var tPlayer = 0;
                    var tBet = 0;
                    $(tp).each(function(k) {
                        if(nR.data[tp[k]]){
                            tpTotal += parseInt(nR.data[tp[k]]);
                            var clinetP = nR.calPer[tp[k]]['cP'];
                            // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[tp[k]]);
                            tPlayer += parseInt(nR.dataDistinct[tp[k]]);
                            tBet += parseInt(nR.dataCount[tp[k]]);
                            totalClientP +=clinetP;
                            var myP = nR.data[tp[k]]-clinetP;
                            var cPer = (myP * cuttingP/100);
                            var tx ='<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+nR.data[tp[k]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+nR.dataCount[tp[k]]+')</div><div style="background-color: #B2A24B;">('+nR.dataDistinct[tp[k]]+')</div>';
                            if(cuttingP > 0){
                                tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                            }
                            tx += '</div>';
                            $('#'+tp[k]).html(tx).css({'font-size':'19px'});
                        }
                    });
                    $("#tripleTotal").text(tpTotal);
                    
                    totalPlayer += tPlayer;
                    totalBet += tBet;
                    $("#totalPlayer").text(totalPlayer);
                    $("#totalBet").text(totalBet);
                    $("#tripleTotalPlayer").text(tPlayer);
                    $("#tripleTotalBet").text(tBet);
                    totalBA +=tpTotal;
                    totalCP +=Math.round(totalClientP);
                    $("#totalBA").text(totalBA);
                    $("#totalCP").text(totalCP);
                    $("#tripleTotalOP").text(Math.round(tpTotal-totalClientP));
                    totalOP +=tpTotal-totalClientP;
                    $("#totalOP").text(Math.round(totalOP));
                    $("#tripleTotalCP").text(Math.round(totalClientP));
                    flexbox++;
                    if(flexbox>3){
                        addRemoveAttr('show');
                        $('#cut').show();
                    }
                }
            });
            // if(op=='Close'){
                // setJodi();
                $.ajax({
                    type: "POST",
                    url: base_url+"/ba12cb7f1e10a13d014c07c9c37a1e9c",
                    data: {bazar:bazar,type:'JODI',op:op,resultDate:rDate,gType:op},
                    success: function (res) {
                        var nR = JSON.parse(res);
                        if(nR.cutting){
                            cuttingP = nR.cutting.cuttingPercentage; 
                            $('#Percentage').val(cuttingP);
                        }else{
                            cuttingP = 0; 
                            $('#Percentage').val(0);
                        }
                        jodiData = nR;
                        var jodiTotal = 0;
                        var totalClientP = 0;
                        var tPlayer = 0;
                        var tBet = 0;
                        var cutAK = $('#cutting').val()*10;
                        
                        $(jodi).each(function(l) {
                            $(jodi[l]).each(function(j) {
                                var n = jodi[l][j];
                                if(nR.data[n]){
                                    jodiTotal += parseInt(nR.data[n]);
                                    var clinetP = nR.calPer[n]['cP'];
                                    // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[n]);
                                    totalClientP +=clinetP;
                                    tPlayer += parseInt(nR.dataDistinct[[n]]);
                                    tBet += parseInt(nR.dataCount[[n]]);
                                    var myP = nR.data[n]-clinetP;
                                    var cPer = (myP * cuttingP/100);
                                    var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+nR.data[[n]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+nR.dataCount[[n]]+')</div><div style="background-color: #B2A24B;">('+nR.dataDistinct[[n]]+')</div>';
                                    if(cuttingP > 0){
                                        tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                                    }
                                    if(op=='Close'){
                                        if($('#cutting').val()){
                                            if((cutAK < jodi[l][j] && (cutAK+9) > jodi[l][j]) || (cutAK+9) == jodi[l][j] || cutAK == jodi[l][j]){
                                                var oA = $( "#"+$('#cutting').val()+" .sty div" ).first().text();
                                                var cutA = (jodiData.data[[n]]*10)+parseInt(oA);
                                                console.log(jodiData.data[[n]])
                                                console.log(oA)
                                                tx += '<div style="background-color:#746e71;color:#fff;">'+cutA+'</div>';
                                            }
                                        }
                                    }
                                    tx += '</div>';
                                    $('#'+jodi[l][j]).html(tx).css({'font-size':'19px'});
                                }
                            });
                        });
                        $("#jodiTotal").text(jodiTotal);
                        
                        totalPlayer += tPlayer;
                        totalBet += tBet;
                        $("#jodiTotalPlayer").text(tPlayer);
                        $("#jodiTotalBet").text(tBet);

                        $("#totalPlayer").text(tPlayer);
                        $("#totalBet").text(tBet);
                        totalBA +=jodiTotal;
                        totalCP +=Math.round(totalClientP);
                        $("#totalBA").text(totalBA);
                        $("#totalCP").text(totalCP);
                        $("#jodiTotalOP").text(Math.round(jodiTotal-totalClientP));
                        totalOP +=jodiTotal-totalClientP;
                        $("#totalOP").text(Math.round(totalOP));
                        $("#jodiTotalCP").text(Math.round(totalClientP));
                        flexbox++;
                        if(flexbox>3){
                            addRemoveAttr('show');
                            $('#cut').show();
                        }
                    }
                });
            // }else{
            //     setJodi();
            // }
            $('.content-wrapper').show();
            $('.flexbox').hide();
            $('#bufLable').show();
        }else{
            clearData();
        }
    }

    function clearData(){
        var ak = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $(ak).each(function(l) {
            $('#'+l).text('0').css({'background-color': '#f4f4f4','color': '#333'});
        });

        var sp = getPanaSpDp('SP');
        $(sp).each(function(t) {
            $('#'+sp[t]).text('0').css({'background-color': '#f4f4f4','color': '#333'}); 
        });

        var dp = getPanaSpDp('DP');
        $(dp).each(function(p) {
            $('#'+dp[p]).text('0').css({'background-color': '#f4f4f4','color': '#333'});
        });

        var tp = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
        $(tp).each(function(k) {
            $('#'+tp[k]).text('0').css({'background-color': '#f4f4f4','color': '#333'});
        });
    }

    function setOldData(){
        var ak = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var cuttingP = $('#Percentage').val();
        var rPer = 0;
        $(ak).each(function(l) {
            if(akData.data[ak[l]]){
                var clinetP = akData.calPer[ak[l]]['cP'];
                // var clinetP = (akData.pPercentage / 100) * parseInt(akData.data[ak[l]]);
                var myP = akData.data[ak[l]]-clinetP;
                var cPer = (myP * cuttingP/100);
                rPer += cPer;
                var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+akData.data[ak[l]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+akData.dataCount[l]+')</div><div style="background-color: #B2A24B;">('+akData.dataDistinct[l]+')</div>';
                if(cuttingP > 0){
                    tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                }
                tx += '</div>';
                $('#'+l).html(tx);
            }else{
                $('#'+l).css({'background-color': '#f4f4f4','color': '#fff'});
            }
        });

        var sp = getPanaSpDp('SP');
        $(sp).each(function(t) {
            if(spData.data[sp[t]]){
                var clinetP = spData.calPer[sp[t]]['cP'];
                // var clinetP = (spData.pPercentage / 100) * parseInt(spData.data[sp[t]]);
                var myP = spData.data[sp[t]]-clinetP;
                var cPer = (myP * cuttingP/100);
                rPer += cPer;
                var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+spData.data[sp[t]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+spData.dataCount[sp[t]]+')</div><div style="background-color: #B2A24B;">('+spData.dataDistinct[sp[t]]+')</div>';
                if(cuttingP > 0){
                    tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                }
                tx += '</div>';        
                $('#'+sp[t]).html(tx);
            }
        });

        var dp = getPanaSpDp('DP');
        $(dp).each(function(p) {
            if(dpData.data[dp[p]]){
                var clinetP = dpData.calPer[dp[p]]['cP'];
                // var clinetP = (dpData.pPercentage / 100) * parseInt(dpData.data[dp[p]]);
                var myP = dpData.data[dp[p]]-clinetP;
                var cPer = (myP * cuttingP/100);
                rPer += cPer;
                var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+dpData.data[dp[p]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+dpData.dataCount[dp[p]]+')</div><div style="background-color: #B2A24B;">('+dpData.dataDistinct[dp[p]]+')</div>';
                if(cuttingP > 0){
                    tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                }
                tx += '</div>'; 
                $('#'+dp[p]).html(tx);
            }
        });

        var tp = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
        $(tp).each(function(k) {
            if(tpData.data[tp[k]]){
                var clinetP = tpData.calPer[tp[k]]['cP'];
                // var clinetP = (tpData.pPercentage / 100) * parseInt(tpData.data[tp[k]]);
                var myP = tpData.data[tp[k]]-clinetP;
                var cPer = (myP * cuttingP/100);
                rPer += cPer;
                var tx ='<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+tpData.data[tp[k]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+tpData.dataCount[tp[k]]+')</div><div style="background-color: #B2A24B;">('+tpData.dataDistinct[tp[k]]+')</div>';
                if(cuttingP > 0){
                    tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                }
                tx += '</div>';
                $('#'+tp[k]).html(tx);
            }
        });

        // if(!$("#buf1").is(":checked")){
            
            var cutAK = $('#cutting').val()*10;
            $(jodi).each(function(l) {
                $(jodi[l]).each(function(j) {
                    var n = jodi[l][j];
                    if(jodiData.data[n]){
                        jodiTotal += parseInt(jodiData.data[n]);
                        var clinetP = jodiData.calPer[n]['cP'];
                        // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[n]);
                        var myP = jodiData.data[n]-clinetP;
                        var cPer = (myP * cuttingP/100);
                        var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+jodiData.data[[n]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+jodiData.dataCount[[n]]+')</div><div style="background-color: #B2A24B;">('+jodiData.dataDistinct[[n]]+')</div>';
                        if(cuttingP > 0){
                            tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                        }
                        if($('#cutting').val()){
                            if((cutAK < jodi[l][j] && (cutAK+9) > jodi[l][j]) || (cutAK+9) == jodi[l][j] || cutAK == jodi[l][j]){
                                var oA = $( "#"+$('#cutting').val()+" .sty div" ).first().text();
                                var cutA = (jodiData.data[[n]]*10)+parseInt(oA);
                                tx += '<div style="background-color:#746e71;color:#fff;">'+cutA+'</div>';
                            }
                        }
                        tx += '</div>';
                        $('#'+jodi[l][j]).html(tx).css({'font-size':'19px'});
                    }
                });
            });
        // }
    }
    

    function calculateCutting(){
        var cuttingP = $('#Percentage').val();
        var cutAK = $('#cutting').val()*10;
        $(jodi).each(function(l) {
            $(jodi[l]).each(function(j) {
                var n = jodi[l][j];
                if(jodiData.data[n]){
                    jodiTotal += parseInt(jodiData.data[n]);
                    var clinetP = jodiData.calPer[n]['cP'];
                    // var clinetP = (nR.pPercentage / 100) * parseInt(nR.data[n]);
                    var myP = jodiData.data[n]-clinetP;
                    var cPer = (myP * cuttingP/100);
                    var tx = '<div class="sty"><div style="background-color:#2eb998;color:#fff;">'+jodiData.data[[n]]+'</div><div style="background-color: #3E5C78;">('+Math.round(clinetP)+')</div><div style="background-color: #EF974A;">('+Math.round(myP)+')</div><div style="background-color: #4C96B1;">('+jodiData.dataCount[[n]]+')</div><div style="background-color: #B2A24B;">('+jodiData.dataDistinct[[n]]+')</div>';
                    if(cuttingP > 0){
                        tx += '<div style="background-color: #9063BE;">('+Math.round(cPer)+')</div><div style="background-color: #BA2E6B;">('+(Math.round(myP-cPer))+')</div>';
                    }
                    if((cutAK < jodi[l][j] && (cutAK+9) > jodi[l][j]) || (cutAK+9) == jodi[l][j] || cutAK == jodi[l][j]){
                        console.log($( "#"+$('#cutting').val()+" .sty div" ).first().text())
                        var oA = $( "#"+$('#cutting').val()+" .sty div" ).first().text();
                        var cutA = (parseInt(jodiData.data[[n]])*10)+parseInt(oA);
                        tx += '<div style="background-color:#746e71;color:#fff;">'+cutA+'</div>';
                    }
                    tx += '</div>';
                    $('#'+jodi[l][j]).html(tx).css({'font-size':'19px'});
                }
            });
        });
    }
    $('#resWorli').click(function(){
        var bazar = $('#game_name').val();
        if($("#buf1").is(":checked")){
            var op = 'Open';
        }else{
            var op = 'Close';
        }
        var res = $('#res').val();
        if(bazar=='' || res==''){
            alert('Please Select Market And Result!')
        }else{
            var bt = $('#bazar_'+bazar).text();
            var st = 'Update Result '+bt+' '+op+' '+res;
            if (confirm(st)) {
                var gameArr = [15,24,23,13,1];
                if(jQuery.inArray(bazar, gameArr) === -1){
                    $.ajax({
                        type: "POST",
                        url: base_url+"/d2e99d93a56c1e1263c5714f1729084f",
                        data: {res:res,bazar:bazar,type:op},
                        success: function (res) {
                            var nR = JSON.parse(res);
                            $('#res').val('');
                            alert(nR['message'])
                        }
                    });
                }else{
                    alert('Buffer Not Allowed For This Market!.');
                }
            } else {
                alert('Why did you press cancel? You should have confirmed');
            }
        }
    });

    $('#buf').click(function(){
        if(bPatti==''){
            alert('please select patti First!')
        }else{
            var bazar = $('#game_name').val();
            if($("#buf").is(":checked")){
                var s = '0';
            }else{
                var s = '1';
            }
            $.ajax({
                type: "POST",
                url: base_url+"/02acba6322d212c923e5093dca48055b",
                data: {status:s,id:4,bazar:bazar,type:op},
                success: function (res) {
                    var nR = JSON.parse(res);
                    if(nR.status=='400'){
                        alert(nR.massage)
                    }
                }
            });
        }
    });

    $('#0A, #1A, #2A, #3A, #4A, #5A, #6A, #7A, #8A, #9A').click(function(evt){
        clearData();
        setOldData();
        var d = getPattiByDigit(evt.target.innerText);
        $(d).each(function(k) {
            $('#'+d[k]).css({'background-color': '#a13cbc','color': '#ccc'});
        });
    });

    function calculatePercentage(){
        clearData();
        setOldData();
    }

    $('#cut').click(function(){
        var msg = "Do you want to cut "+$('#Percentage').val()+"% from "+$("#game_name option:selected").text()+" for "+op+"?";
        if (confirm(msg) == true) {
            var k = {
                "totalAmount":parseInt($('#totalBA').text()),
                "clientStack":parseInt($('#totalCP').text()),
                "ourStack":parseInt($('#totalOP').text()),
                "cuttingAmount":Math.round(($('#Percentage').val() / 100) * parseInt($('#totalOP').text())),
            }
            $.ajax({
                type: "POST",
                url: base_url+"/20957dcc477ff123890ec02233ed3f2f",
                data: {percentage:$('#Percentage').val(),bazar:$('#game_name').val(),type:op,date:$('#date').val(),cuttingData:k},
                success: function (res) {
                    var nR = JSON.parse(res);
                    alert(nR['message'])
                }
            });
        } else {
            console.log('Error')
        }
    })
</script>