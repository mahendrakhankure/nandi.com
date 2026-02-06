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
    #streming iframe {
        height: 251.75px;
        width: 90%;
    }
</style>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <h3>Instant Worli 2 Live Round Settlement For Round (<span id="roundId"></span>)</h3>
                    <h3>Total Bet On Akda :<span id="totalAkda">0</span>-<span id="totalAkdaWin">0</span>=<span id="totalAkdaGgr">0</span></h3>
                    <h3>Total Bet On Patti :<span id="totalPatti">0</span>-<span id="totalPattiWin">0</span>=<span id="totalPattiGgr">0</span></h3>

                    <!-- <label class="switch">
                      <input type="checkbox" class="switch-input" id="buf">
                      <span class="switch-label" data-on="On" data-off="Off"></span>
                      <span class="switch-handle"></span>
                    </label> -->
                    <?php 
                        if($status['status']==1){
                            echo '<label class="switch">
                            <input type="checkbox" class="switch-input" id="buf">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>';
                        }else{
                            echo '<label class="switch">
                            <input type="checkbox" checked class="switch-input" id="buf">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>';
                        }
                    ?>
                    <button class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#myModal" onclick="topPlayers()">Top Players</button>
                    <div class="form-group">
                        <input type="text" class="form-control" id="res" placeholder="Result"/>
                        <span class="btn btn-primary m-2" id="resWorli">Submit</span>
                    </div>
                </div>
                <div class="col-md-5 promo-video" id="streming">
                    <span><i class="fa-solid fa-message"></i></span>
                    <iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-4" title="Live Satta Result" id="iFrameWin"></iframe>
                </div>
                <div class="col-md-3">
                    <table class="table" id="listOfPlayers">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Akda</th>
                            <th scope="col">Patti</th>
                            </tr>
                        </thead>
                        <tbody id='tBody'>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <table class="table">
                        <thead>
                            <tr style="cursor:pointer;">
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
        </div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>
    <section>
        <div class="container">
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog" style="width:390px;">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <table class="table" id="topPlayerList">
                                <thead>
                                    <tr>
                                        <th scope="col">Customer ID</th>
                                        <th scope="col">Bet Amount</th>
                                        <th scope="col">Winning Amount</th>
                                        <th scope="col">GGR</th>
                                    </tr>
                                </thead>
                                <tbody id='tBody'>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    var singleAkda = "<?=$bhav[3]['bhav']?>";
    var singlePatti = "<?=$bhav[0]['bhav']?>";
    var doublePatti = "<?=$bhav[1]['bhav']?>";
    var triplePatti = "<?=$bhav[2]['bhav']?>";
    var resultA;
    var resultP;
</script>
<script type="text/javascript">
    var sp = getPattiAkdaWise('SinglePatti');
    var dp = getPattiAkdaWise('DoublePatti');
    // For Singal Patti Start
    var spdome = '<table class="table"><tbody>';
    $(sp).each(function(t) {
        spdome += '<tr>';
        $(sp[t]).each(function(l) {
            spdome += '<th id="'+sp[t][l]+'P">'+sp[t][l]+'</th>';
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
            dpdome += '<th id="'+dp[t][l]+'P">'+dp[t][l]+'</th>';
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
        tpdome += '<th id="'+tp[l]+'P">'+tp[l]+'</th>';
    });
    tpdome += '</tr><tr>';
    $(tp).each(function(l) {
        tpdome += '<td id="'+tp[l]+'">0</td>';
    });
    
    tpdome += '</tr></tbody></table>';
    $('#tpDome').append(tpdome);
</script>
 <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k"
        crossorigin="anonymous"></script>
<script>
    var cArr = [];
    var socket = io.connect('https://node.dpbosses.live');
    socket.on('error', function () { console.error(arguments) });
    socket.on('message', function () { console.log(arguments) });
    socket.on('resultdeclare', function (d) {
        var res = d.data;
        if (res.market=='blueTableRoundStetment') {
            var game = $('#'+res.game).text();
            var p = parseInt(game)+parseInt(res.point)
            if(parseInt(res.game)<10){
                var tmt = $('#totalAkda').text();
                var pt = parseInt(res.point)+parseInt(tmt)
                $('#totalAkda').text(pt);
            }else{
                var totalPatti = $('#totalPatti').text();
                var pp = parseInt(res.point)+parseInt(totalPatti)
                $('#totalPatti').text(pp);
            }
            $('#'+res.game).text(p);
            $('#'+res.game).css({"background-color":"red","color":"#fff"});

            $('#'+resultA).removeAttr('style');
            $('#'+resultP).removeAttr('style');

            if(cArr.includes(res.customer_id)) {
                if(parseInt(res.game)<10){
                    var am = $('#AK_'+res.customer_id).text();
                    if(!am){
                        am = 0;
                    }
                    var nM = parseInt(am)+parseInt(res.point);
                    $('#AK_'+res.customer_id).text(nM);
                }else{
                    var am = $('#PATTI_'+res.customer_id).text();
                    if(!am){
                        am = 0;
                    }
                    var nM = parseInt(am)+parseInt(res.point);
                    $('#PATTI_'+res.customer_id).text(nM);
                }
            } else {
                cArr.push(res.customer_id);
                if(parseInt(res.game)<10){
                    $('#listOfPlayers > tbody:last-child').append('<tr id="'+res.customer_id+'"><td>'+res.userName+'</td><td id="AK_'+res.customer_id+'">'+res.point+'</td><td id="PATTI_'+res.customer_id+'">0</td></tr>');
                    // $('#listOfPlayers').append('<li id="'+res.customer_id+'" class="list-group-item">'+res.userName+' =><span id="AK_'+res.customer_id+'">'+res.point+'</span>--><span id="PATTI_'+res.customer_id+'"></span></li>');
                }else{
                    $('#listOfPlayers > tbody:last-child').append('<tr id="'+res.customer_id+'"><td>'+res.userName+'</td><td id="AK_'+res.customer_id+'">0</td><td id="PATTI_'+res.customer_id+'">'+res.point+'</td></tr>');
                    // $('#listOfPlayers').append('<li id="'+res.customer_id+'" class="list-group-item">'+res.userName+' =><span id="AK_'+res.customer_id+'"></span>--><span id="PATTI_'+res.customer_id+'">'+res.point+'</span></li>');
                }
            } 
        }else if(res.market=='blueTableNewRound'){
            
            for (var i = 0; i < 10; i++) {
                $('#'+i).text('0');
                $('#'+tp[i]).text('0');
                $('#'+i).css({"background-color":"#ecf0f5","color":"#ddd"});
                $('#'+tp[i]).css({"background-color":"#ecf0f5","color":"#ddd"});
            }
            $(dp).each(function(t) {
                $(dp[t]).each(function(l) {
                    $('#'+dp[t][l]).text('0');
                    $('#'+dp[t][l]).css({"background-color":"#ecf0f5","color":"#ddd"});
                });
            });
            $(sp).each(function(t) {
                $(sp[t]).each(function(l) {
                    $('#'+sp[t][l]).text('0');
                    $('#'+sp[t][l]).css({"background-color":"#ecf0f5","color":"#ddd"});
                });
            });
            $('#roundId').text('');
            $('#totalAkda').text('0');
            $('#totalPatti').text('0');

            $('#totalAkdaWin').text('0');
            $('#totalPattiWin').text('0');
            $('#totalAkdaGgr').text('0');
            $('#totalPattiGgr').text('0');

            $('#roundId').text(res.roundId);
        }else if(res.market=='blueTable'){
            $('#'+res.akda+'A').css({"background-color":"#3ebc3c","color":"#ffffff"});
            $('#'+res.patti+'P').css({"background-color":"#3ebc3c","color":"#ffffff"});
            
            var rAkDa = $('#'+res.akda).text();
            var rPaTtI = $('#'+res.patti).text();
            var akdaWinR = parseInt(rAkDa)*parseInt(singleAkda);
            if(res.rResult=='SP'){
                var rTyPe = singlePatti;
            }else if(res.rResult=='DP'){
                var rTyPe = doublePatti;
            }else{
                var rTyPe = triplePatti;
            }
            var pattiWinR = parseInt(rPaTtI)*parseInt(rTyPe);

            var tAk = $('#totalAkda').text();
            var tAp = $('#totalPatti').text();
            var akGr = parseInt(tAk)-parseInt(akdaWinR);
            var ptGr = parseInt(tAp)-parseInt(pattiWinR);


            $('#totalAkdaWin').text(akdaWinR);
            $('#totalPattiWin').text(pattiWinR);
            $('#totalAkdaGgr').text(akGr);
            $('#totalPattiGgr').text(ptGr);
            resultA=res.akda+'A';
            resultP=res.patti+'P';
        }
    });
</script>
<script type="text/javascript">
    $('#resWorli').click(function(){
        var r = $('#res').val();
        var gId = $('#roundId').text();
        // var gId = '123456';
        if(r=='' || gId==''){
            alert('Please Wait For Five Secound!')
        }else{
            $.ajax({
                type: "POST",
                url: base_url+"/e33991c5a6ae3cc80cd8ec83d8584295",
                data: {res:r,GameId:gId},
                success: function (res) {
                    $('#res').val('');
                    alert('Success!')
                }
            });
        }
    });

    $('#buf').click(function(){
        if($("#buf").is(":checked")){
            var s = '0';
        }else{
            var s = '1';
        }
        $.ajax({
            type: "POST",
            url: base_url+"/bb4a1bc110d4a919e3fd660f0bdffb41",
            data: {status:s},
            success: function (res) {
            }
        });
    });


    $('#0A, #1A, #2A, #3A, #4A, #5A, #6A, #7A, #8A, #9A').click(function(evt){
        clearData();
        // console.log();
        // setOldData();
        var d = getPattiByDigit(evt.target.innerText);
        $(d).each(function(k) {
            $('#'+d[k]).css({'background-color': 'green','color': '#ccc'});
        });
    });

    function setOldData(){
        // var ak = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        // $(ak).each(function(l) {
        //     if(akData.data[ak[l]]){
        //         $('#'+l).text(akData.data[l]).css({'background-color': 'red','color': '#fff'});
        //     }else{
        //         $('#'+l).css({'background-color': '#f4f4f4','color': '#fff'});
        //     }
        // });

        var sp = getPanaSpDp('SP');
        $(sp).each(function(t) {
            if(spData.data[sp[t]]){
                $('#'+sp[t]).text(spData.data[sp[t]]).css({'background-color': 'red','color': '#fff'});
            }
        });

        var dp = getPanaSpDp('DP');
        $(dp).each(function(p) {
            if(dpData.data[dp[p]]){
                $('#'+dp[p]).text(dpData.data[dp[p]]).css({'background-color': 'red','color': '#fff'});
            }
        });

        var tp = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
        $(tp).each(function(k) {
            if(tpData.data[tp[k]]){
                $('#'+tp[k]).text(tpData.data[tp[k]]).css({'background-color': 'red','color': '#fff'});
            }
        });
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

    function topPlayers(){
        var d = new Date();
        var date = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getDate();
        console.log(date)
        $.ajax({
            type: "POST",
            url: base_url+"/ca9c9e1a461385a12cda04c779f16d9a",
            data: {date:date,market:'blueTable'},
            success: function (r) {
                $('#topPlayerList > tbody').empty();
                var res = JSON.parse(r);
                $(res).each(function(k) {
                    $('#topPlayerList > tbody:last-child').append('<tr><td>'+res[k].customer_id+'</td><td>'+res[k].amt+'</td><td>'+Math.round(res[k].win)+'</td><td>'+Math.round(res[k].amt-res[k].win)+'</td></tr>');
                });
            }
        });
    }
</script>