<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));  
    // if($_GET['app']){
    //     $imgF=$_GET['app'];
    // }else{
    //     $imgF='images';
    // }
    $imgF='images';
?>
    <style>
        .clockdiv div{
            color: #EABA13;
            font-size: 14px;
            padding-right: 3px;
        }
        #stremingGif{
            margin-bottom: -1rem;
        }
        #stremingGif img {
            width: 100%;
             height: 52.6vw;
        }
        body {font-family: Arial, Helvetica, sans-serif;}

        /* The Modal (background) */
        .modal {
          display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 1; /* Sit on top */
          padding-top: 100px; /* Location of the box */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgb(0,0,0); /* Fallback color */
          background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
          background-color: #fefefe;
          margin: auto;
          padding: 20px;
          border: 1px solid #888;
          width: 80%;
        }

        /* The Close Button */
        .close {
          color: #aaaaaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }

        .close:hover,
        .close:focus {
          color: #000;
          text-decoration: none;
          cursor: pointer;
        }

        #streming1 #divVideo #videoID{
            width: 100% !important;
            height: 303.75px;
        }
    </style>
    <div class="container container-custom" style="margin-top: 60px;">
        <p class="week-days"><?=$marketDetail['days']?></p>
        <div class="live-center">
            <a href="javascript:void(0)" id="myBtn" class="oldRed">OLD RESULT</a> 
            <p class="res-digit-no">
            <?php
                if(!empty($marketResult[0]['open'])){
                    echo $marketResult[0]['open'].'-'.$marketResult[0]['jodi'].'-'.$marketResult[0]['close'];
                }else if($param['bazar_result']!="--"){
                    echo $param['bazar_result'];
                }else{
                    echo '***-**-***';
                }
            ?>
            </p>
            <div class="videoDV">
            <div class="col-md-12 stremingRegular" id="streming1"></div>
                <?php  
                if(!in_array(trim($marketDetail['bazar_name']), ['MORNING SYNDICATE','TIME BAZAR','BALAJI DAY','MILAN DAY','KALYAN','SYNDICATE NIGHT','MILAN NIGHT','RAJDHANI NIGHT','MAIN BAZAR'])) {
                ?>
                    <div class="col-md-12" id="stremingGif"></div>
                <?php
                }
                ?>
            </div>
            <?php  
                if(!in_array(trim($marketDetail['bazar_name']), ['MORNING SYNDICATE','TIME BAZAR','BALAJI DAY','MILAN DAY','KALYAN','SYNDICATE NIGHT','MILAN NIGHT','RAJDHANI NIGHT','MAIN BAZAR'])) {
                ?>
                <p class="lvHead"><img class="livab" src="<?=base_url()?>assets/newDesign/images/live.gif"><?=$marketDetail['bazar_name']?></p>
                <?php
                }
                ?>
            <div class="time-show">
                <p class="open-close">Open Time Remaining <span class="time-seprate"> | </span> Close Time Remaining</p>
                <p class="open-close-time">
                <div class="main-clock" style=" display: flex; justify-content: space-around;">
                    <span style="display: inline-block;" class="opnRem">
                        <div class="clockdiv" data-date="<?=date($oD[0].' H:i:s',checkTime($marketDetail['open_time']))?>">
                            <div style="display:none;">
                                <span class="days"></span>
                            </div>
                            <div>
                                <span class="hours"></span>H
                            </div>
                            <div>
                                <span class="minutes"></span>M
                            </div>
                            <div>
                                <span class="seconds"></span>S
                            </div>
                        </div>
                    </span>
                    <div class="pipe">|</div>
                    <span style="display: inline-block;" class="clsRem">
                        <div class="clockdiv" data-date="<?=date($cD[0].' H:i:s',checkTime($marketDetail['close_time']))?>">
                            <div style="display:none;">
                                <span class="days"></span>
                            </div>
                            <div>
                                <span class="hours"></span>H
                            </div>
                            <div>
                                <span class="minutes"></span>M
                            </div>
                            <div>
                                <span class="seconds"></span>S
                            </div>
                        </div>
                    </span>
                </div>
                </p>
            </div>
        <div class="akdaMain" id="akdaMain">   
        <?php
        foreach($gameList as $games){
            if(!in_array($games['id'], [34,35,36])){
        ?>
            <a href="<?=base_url();?>2f7b8019e658ea93b1e4d76ac4c6096f/<?=$param['bazar_id']?>/<?=$games['id']?>/<?=$param['bazar_result']?><?=$tUrl?>" class="akda-block">
                <?php
                    if(in_array($games['id'], [20,24,19,29,30])){
                        $g = substr($games['game_name'], 0, -3);   
                    }else if($games['id']==7){
                        $g = 'CHOICE PANA';
                    }else if($games['id']==18){
                        $g = 'TWO DIGIT PANEL(CP,SR)';
                    }else{
                        $g = $games['game_name'];
                    }
                ?>
                <img src="<?php echo base_url().'assets/'.$imgF.'/'.$games['icon']; ?>" alt="<?=$g?>">
                <label><?=$g?></label>
            </a>
        <?php
                }
            }
        ?> 
         
               
         <div class="clrBoth"></div>    
            </div>
            
         <div class="clrBoth"></div>   
        </div>
    </div>
        <!-- Game Variation Days -->
        <!-- <div class="container-fluid">
            <div class="rows">
                <div class="col-12 gv-days dark">
                    <div class="days">
                        <h4 class="text-center" style="text-transform:uppercase; margin:5px;"><?=$marketDetail['days']?></h4>
                    </div>
                </div>
            </div>
            <span class="bett-action" style="align-items: center;">
                <a  href="javascript:void(0)" id="myBtn" class="btn btn-lg">Old Result</a>
                <button style="
                position: absolute;
                right: 10px;
                font-size: 13px;
                padding: 4px 12px;
                border-radius: 5px;
                background: transparent;
                border: none;
                color: #eee;
                outline: none;
                text-transform: capitalize;
                font-weight: 700;
                background: #c50d0d;
                margin-top: 3px;
            " onclick="refresh()">Refresh <i class="fa fa-refresh" style="font-size: 13px;" aria-hidden="true"></i></button>
            </span>
        </div> -->
        <!-- Game Variation Result and Time duration -->
        <!-- <div class="container gv-wrapper" >
            <div class="row">
                <div class="col-md-12">  
                        <h3 class="text-center random-num" id="random-num">
                        <?php
                            if(!empty($marketResult[0]['open'])){
                                echo $marketResult[0]['open'].'-'.$marketResult[0]['jodi'].'-'.$marketResult[0]['close'];
                            }else if($param['bazar_result']!="--"){
                                echo $param['bazar_result'];
                            }else{
                                echo '***-**-***';
                            }
                        ?>
                        </h3>
                </div>
                <div class="col-md-12 stremingRegular" id="streming1"></div>
                <?php  
                if(!in_array(trim($marketDetail['bazar_name']), ['MORNING SYNDICATE','TIME BAZAR','BALAJI DAY','MILAN DAY','KALYAN','SYNDICATE NIGHT','MILAN NIGHT','RAJDHANI NIGHT','MAIN BAZAR'])) {
                ?>
                <div class="col-md-12" id="stremingGif"></div>
                <div class="col-12 gn-header" style="text-align: center; margin-top: 1rem; text-transform: uppercase; background: #fbb700; position: relative;">
                    <button style="position: absolute; left: 5px; margin-top: 4px; background: #c50d0d; color: white; border: none; font-size: 11px; padding: 4px 8px; border-radius: 5px; font-weight: 700; text-transform: capitalize;">Live Result</button>
                    <h3 style="font-size: 13px; font-weight: 900; padding-top: 8px; color: #222; text-shadow: 1px 1px #999;"><?=$marketDetail['bazar_name']?></h3>
                </div>
                <?php
                }
                ?>
                <div class="gv-open-close text-center col-lg-6 offset-lg-3 col-md-8 offset-md-2  col-sm-10 offset-sm-1 col-xs-12" id="timeID">
                    <span style="display: inline-block;">
                        <div class="text-center mb-2">Open Time Remaining</div>

                        <div class="clockdiv" data-date="<?=date($oD[0].' H:i:s',strtotime($marketDetail['open_time']))?>">
                            <div style="display:none;">
                                <span class="days"></span>
                            </div>
                            <div>
                                <span class="hours"></span>H
                            </div>
                            <div>
                                <span class="minutes"></span>M
                            </div>
                            <div>
                                <span class="seconds"></span>S
                            </div>
                        </div>
                    </span>

                    <div class="pipe">|</div>
                    <span style="display: inline-block;">
                        <div class="text-center mb-2">Close Time Remaining</div>
                        <div class="clockdiv" data-date="<?=date($cD[0].' H:i:s',strtotime($marketDetail['close_time']))?>">
                            <div style="display:none;">
                                <span class="days"></span>
                            </div>
                            <div>
                                <span class="hours"></span>H
                            </div>
                            <div>
                                <span class="minutes"></span>M
                            </div>
                            <div>
                                <span class="seconds"></span>S
                            </div>
                        </div>
                    </span>
                </div>
                <p style="text-align: center;">
                </p>
            </div>
        </div> -->
        <!-- All Games List -->
        <!-- <div class="container">
            <div class="row">
                <div class="col-12">
                    <p style="text-align: center;">Pending Bet Amount : <?=$exposer[0]['SUM(point)']?></p>
                    <div class="gamelist">
                    <?php
                    foreach($gameList as $games){
                        if(!in_array($games['id'], [34,35,36])){
                    ?>
                        <a href="<?=base_url();?>2f7b8019e658ea93b1e4d76ac4c6096f/<?=$param['bazar_id']?>/<?=$games['id']?>/<?=$param['bazar_result']?><?=$tUrl?>">
                            <div class="game">
                                <img src="<?php echo base_url().'assets/'.$imgF.'/'.$games['icon']; ?>" alt="">
                                <p class="text-center">
                                        <?php
                                            if(in_array($games['id'], [20,24,19,29,30])){
                                                echo substr($games['game_name'], 0, -3);   
                                            }else if($games['id']==7){
                                                echo 'CHOICE PANA';
                                            }else if($games['id']==18){
                                                echo 'TWO DIGIT PANEL(CP,SR)';
                                            }else{
                                                echo $games['game_name'];
                                            }
                                        ?>
                                </p>
                            </div>
                        </a>
                    <?php
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div> -->
    <input type="hidden" name="oD" value="<?=$oD[1]?>">
    <input type="hidden" name="cD" value="<?=$cD[1]?>">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <table class="table table-responsive text-center">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Result Date</th>
                        <th>Open</th>
                        <th>Jodi</th>
                        <th>Close</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;

                    foreach($marketResultOld as $r){
                ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=date("d-m-Y", strtotime($r['result_date']))?></td>
                        <td><?=$r['open']?></td>
                        <td><?=$r['jodi']?></td>
                        <td><?=$r['close']?></td>
                    </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="bazarIdFR" name="bazarIdFR" value="<?=$marketDetail['id']?>">
    <?php 
          include 'includes/footer.php'; 
    ?>

    <script type="text/javascript">
        setInterval(everyTime, 1000);
        function everyTime(){
            var marketId = <?=$marketDetail['id']?>;
            var gameArr = [15,24,23,13,1];
            if(jQuery.inArray(marketId, gameArr) === -1){
                var d=new Date();
                var open=<?=strtotime($marketDetail['open_time'])?>;
                var close=<?=strtotime($marketDetail['close_time'])?>;
                // var o=parseInt(open)-300; // 5 min before for open
                // var c=parseInt(close)-300; // 5 min before for close
                var o=parseInt(open)-0; // 5 min before for open
                var c=parseInt(close)-0; // 5 min before for close
                var ct= parseInt(d.getTime() / 1000)-360;
                var at= ct+360;
                if(<?=$buffer['status']?>==0 && <?=$buffer['bazar']?>==<?=$marketDetail['id']?>){
                    // if ((o > ct && o < at) || (c > ct && c < at)){
                        if($("#streming1").html() == ''){
                            var vi1 = '<div class="col-12" id="divVideo"><video width="400" id="videoID" muted autoplay playsinline poster="../../assets/images/buffer.png" autobuffer="true"><source src="" type="video/mp4"></source><img src="../../assets/images/buffer.png" title="Your browser does not support the live streaming" /></video></div>';
                            $('#streming1').empty();
                            $('#streming1').append(vi1);
                            
                            var dT = "<?=$buffer['startTime']?>".split(" ");
                            var tm = dT[1].split(":");
                            var hS1 = (parseInt(tm[0])*60)*60;
                            var mS1 = parseInt(tm[1])*60;
                            var s1 = parseInt(tm[2]);
                            var bufferStartTime = hS1+mS1+s1;
                            
                            var d = new Date();
                            var hS = (d.getHours()*60)*60;
                            var mS = d.getMinutes()*60;
                            var s = d.getSeconds();
                            var currentTime = hS+mS+s;
                            var vTime = currentTime-bufferStartTime;
                            var vUrl = "<?=$buffer['vUrl']?>";
                            var $video = $('#divVideo video'),
                            videoSrc = $('source', $video).attr('src',vUrl);
                            // videoSrc = $('source', $video).attr('src',base_url+'/'+vUrl);
                            $video[0].load();
                            $video[0].currentTime = vTime;
                            $video[0].play();


                            var myVideoPlayer = document.getElementById('videoID');
                            myVideoPlayer.addEventListener('loadedmetadata', function () {
                                var duration = myVideoPlayer.duration;
                                console.log(duration+' asdfghj')
                            });
                            
                            var videoID = document.getElementById('videoID');
                            function checkTime() {
                                if (videoID.currentTime >= duration) {
                                    videoID.pause();
                                } else {
                                    setTimeout(checkTime, 100);
                                }
                            }
                            
                            var vids = document.querySelectorAll("video");
                            for (var x = 0; x < vids.length; x++) {
                                vids[x].addEventListener('error', function(e) {
                                    if (this.networkState > 2) {
                                        this.setAttribute("poster", "http://localhost/assets/images/buffer.png");
                                    }
                                }, true);
                            }
                            // $("#streming1").empty();
                            // $("#stremingGif").empty();
                            // var dome = '<div style="position:relative;"><img src="<?=base_url()?>assets/images/buffer.png" alt="" id="iFrameWin" style="width: 100% !important;height: 303.75px;"></div>';
                            // $("#streming1").append(dome);
                            // $("#timeID").hide();
                        }
                    // }else{
                    //     if($("#stremingGif").html() == ''){
                    //         $("#streming1").empty();
                    //         if(<?=$marketDetail['id']?>=='23' || <?=$marketDetail['id']?>=='14' || <?=$marketDetail['id']?>=='70' || <?=$marketDetail['id']?>=='73'){
                    //             var id = '13';
                    //         }else{
                    //             var id = <?=$marketDetail['id']?>;
                    //         }
                    //         var gif = getGifRegular(id);
                    //         var k = '<div style="position:relative;"><img src="<?=base_url()?>'+gif+'" alt="" id="iFrameWin"></div>';
                    //         $("#stremingGif").append(k);
                    //         $("#timeID").show();
                    //     }
                    // }
                }else{
                    if ((o > ct && o < at) || (c > ct && c < at)){
                        $("#stremingGif").empty();
                        // if ((open > ct && open < at) || (close > ct && close < at)){
                        if($("#streming1").html() == ''){
                            
                            var dome = '<div style="position:relative;"><img src="<?=base_url()?>assets/images/regular/regular.jpg" alt="" id="iFrameWin"></div>';
                            // var dome = '<div style="position:relative;"><img src="<?=base_url()?>assets/images/buffer.png" alt="" id="iFrameWin"></div>';
                            // var dome = '<div style="position:relative;"><iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-2" title="Live Satta Result" id="iFrameWin"></iframe></div>';
                            // var dome = '<div style="position:relative;"><iframe src="https://vdo-feedstg.jaaztech.com/?token=QVbu0naS1M" title="Live Satta Result" id="iFrameWin"></iframe></div>';
                            // if($marketDetail['bazar_name'] != 'MORNING SYNDICATE' && $marketDetail['bazar_name'] != 'TIME BAZAR' && $marketDetail['bazar_name'] != 'BALAJI DAY' && $marketDetail['bazar_name'] != 'MILAN DAY' && $marketDetail['bazar_name'] != 'KALYAN' && $marketDetail['bazar_name'] != 'SYNDICATE NIGHT' && $marketDetail['bazar_name'] != 'MILAN NIGHT' && $marketDetail['bazar_name'] != 'RAJDHANI NIGHT' && $marketDetail['bazar_name'] != 'MAIN BAZAR' )    {
                            // }
                                $("#streming1").append(dome);
                                $("#timeID").hide();
                        }else{
                            // $.ajax({
                            //   url: base_url+"/45985ee2c0322111323ce1c8013fbb7c",
                            //   cache: false,
                            //   success: function(html){
                            //     console.log('this is my curl request => '+html)
                            //   }
                            // });
                        }
                    }else{
                        if($("#stremingGif").html() == ''){
                            $("#streming1").empty();
                            if(<?=$marketDetail['id']?>=='23' || <?=$marketDetail['id']?>=='14' || <?=$marketDetail['id']?>=='70' || <?=$marketDetail['id']?>=='73'){
                                var id = '13';
                            }else{
                                var id = <?=$marketDetail['id']?>;
                            }
                            var gif = getGifRegular(id);
                            // var k = '<div style="position:relative;"><img src="<?=base_url()?>assets/images/buffer.png" alt="" id="iFrameWin"></div>';
                            var k = '<div style="position:relative;"><img src="<?=base_url()?>'+gif+'" alt="" id="iFrameWin"></div>';
                            $("#stremingGif").append(k);
                            $("#timeID").show();
                        }
                    }
                }
            }
        };
    </script>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
          modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
        function handleVisibilityChange() {
            if (document.visibilityState === "visible") {
                console.log('visible')
                if($("#streming1").html() != ''){
                    if(newBFUrl!='' && bST!=''){
                        var $video = $('#divVideo video'),
                        videoSrc = $('source', $video).attr('src', newBFUrl);
                        // videoSrc = $('source', $video).attr('src', base_url+'/'+newBFUrl);
                        $video[0].load();
                        var d1 = new Date();
                        var hS1 = (d1.getHours()*60)*60;
                        var mS1 = d1.getMinutes()*60;
                        var s1 = d1.getSeconds();
                        var currentTime1 = hS1+mS1+s1;
                        var gt = currentTime1 - bST ;
                        console.log('visible => '+bST)
                        console.log('visible => '+currentTime1)
                        $video[0].currentTime = gt;
                        $video[0].play();
                    }
                }
            } else {
                console.log('not visible')
            }
        }
        document.addEventListener("visibilitychange", handleVisibilityChange);
    </script>