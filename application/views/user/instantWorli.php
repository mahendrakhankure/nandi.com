<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));    
?>
        <style type="text/css">
            .headerTop{
                height:50px !important;
            }
            .my-popup-outer {
                box-shadow: 0px 0px 8px 2px #fbb700;
                width: 225px;
                height: 125px;
                position: absolute;
                background: rgba(243,  246, 244, 0.1);
                text-align: center;
                left: 50%;
                top: 30%;
                transform: translate(-50%, -30%);
                z-index: 1000;
                border: 2px solid #eee;
                border-radius: 15px;
                display: none;
            }
            .my-popup   {
                margin-top: 16px;
                color: #fff;
            }
            .my-popup-inner h3 {
                text-transform: uppercase;
                font-size: 18px;
                font-weight: 750;
                letter-spacing: 1.1px;
                line-height: 30px;
            }
             
            .my-popup-inner i   {
                font-size: 13px;
            }
            .my-popup-inner i.fa-star {
                color:#1af764;
            }
            .my-popup-inner p {
                background-color: #1af764;
                width: 125px;
                padding: 8px 16px;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
                border-radius: 5px;
                font-weight: 700;
                background: #c50d0d;
            }
            .test{
                width: 50%;
                height:250px;
            }
            #streming {
                /* width: 540px; */
                position: relative;
                text-align:center;
            }
            /* #streming iframe{
                width:100% !important;
            } */
            @media screen and (max-width: 768px) {
                .test {
                    width: 100%;
                    /* margin: auto;
                    height:303.75px; */
                }
            }
            .srId{
                display: block;
                width: 100%;
                height: 37px;
                margin-top: -0.2rem;
            }
            hr{
                height: 5px;
                color: #f80000;
                width: 100%
            }
            .cplaceHr{
                border-bottom: 2px solid Yellow;
            }
            .iId{
                color: #fff;
                display: none;
            }
            .result-inner-wrapper .result-item h3 {
                text-align: center;
            }
            .container-custom {
                margin-top: 30px !important;
                padding: 0px 0px !important;
            }

            .betResSection{
                /* position: absolute;
                bottom: 0px;
                left: 50%;
                transform: translate(-50%, -50%); */
                text-align:center;
                margin-top:10px;
            }
            .last5res {
                display: flex;
                flex-direction: row;
                font-size: 10px;
            }

            .last5res div {
                /* display:none; */
                text-align: center;
                margin: 0px 4%;
                width: 100px;
            }
        @media (min-width:1281px) { 
            .betResSection{
                /* margin-top:-225px !important; */
            }
         }
        </style>
        <img src="<?=base_url()?>assets/images/blankchips01.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips02.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips03.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips04.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips05.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips06.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips07.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips08.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips09.png" style="display: none;">


    <div class="container-fluid container-custom">
    <?php include 'includes/betLoader.php'; ?>
        <div class="col-12 my-popup-outer" id="popUpDiv" style="display: none;">
            <div class="my-popup">
                <div class="my-popup-inner">
                    <h3>
                        <i class="fa-sharp fa-solid fa-star"></i>You Win<i class="fa-sharp fa-solid fa-star"></i>
                    </h3>
                    <p>
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                        <span id="popUpWin"></span>
                    </p>
                </div>
            </div>    
        </div>
        <div class="col-md-12 promo-video" id="streming">
            <!-- <img src="<?=base_url()?>assets/images/live.gif" height='20px' style="left: 7px;position: relative;top: 25px;float: inline-start;"> -->
            <?php
                if($buf['status']=='1'){
                    if(isset($url)){
            ?>
                <!-- <img src="<?=base_url()?>assets/images/independence_day.png" style="width: 100% !important;height: 303.75px;"> -->
                <iframe src="<?=$url?>" title="Live Satta Result" class="test" id="iFrameWin"></iframe>
                <!-- <span><i class="fa-solid fa-message"></i></span> -->
                <!-- <iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-1" title="Live Satta Result" class="test" id="iFrameWin"></iframe> -->
                    <!-- <iframe src="https://matkaui.livedealersol.com/Video/Index?ts=1679789000" title="Live Satta Result" id="iFrameWin"></iframe> -->
            <?php
                    }else{
            ?>
                <!-- <img src="<?=base_url()?>assets/images/independence_day.png" style="width: 100% !important;height: 303.75px;"> -->
                <img src="<?=base_url()?>assets/images/Instant-Worli1.jpg" style="width: 100% !important;height: 303.75px;">
            <?php
                    }
                }else{
            ?>
                <!-- <img src="<?=base_url()?>assets/images/independence_day.png" style="width: 100% !important;height: 303.75px;"> -->
                <img src="<?=base_url()?>assets/images/buffer.png" style="width: 100% !important;height: 303.75px;">
            <?php
                }
            ?>
        </div>
        <marquee>Welcome to INDIA'S BIGGEST LIVE GAME Instant Worli ! Now play worli matka 24/7 ! Bet big and Win-big !</marquee>
        <div class='last5res'>
        <?php
            foreach(array_reverse($res) as $re){
                echo "<div>{$re['patti_result']}<br>{$re['akda_result']}</div>";
            }
        ?>
        </div>
        <div class="tabpatti-wrapper">
            <ul class="tabpatti slider">
                <li onclick="getPattiResponce('SingleDigit','4')" class="btn btn-default slide active">Single Digit</li>
                <li onclick="getPattiResponce('SinglePatti','1')" class="btn btn-default slide">Single Patti</li>
                <li onclick="getPattiResponce('DoublePatti','2')" class="btn btn-default slide">Double Patti</li>
                <li onclick="getPattiResponce('TriplePatti','3')" class="btn btn-default slide">Triple Patti</li>
            </ul>
        </div>
        <div class="chipDV">
            <p class="betTxt">SELECT THE CHIPS AND BET</p>
            <a class="chip coin" id="coin1" onclick="setCoin(1)">
                <img src="<?=base_url()?>assets/images/chips1.png" alt="">
            </a>
            <a class="chip coin" id="coin5" onclick="setCoin(5)">
                <img src="<?=base_url()?>assets/images/chips2.png" alt="">
            </a>
            <a class="chip coin" id="coin10" onclick="setCoin(10)">
                <img src="<?=base_url()?>assets/images/chips3.png" alt="">
            </a>
            <a class="chip coin" id="coin20" onclick="setCoin(20)">
                <img src="<?=base_url()?>assets/images/chips4.png" alt="">
            </a>
            <a class="chip coin" id="coin50" onclick="setCoin(50)">
                <img src="<?=base_url()?>assets/images/chips5.png" alt="">
            </a>
            <a class="chip coin" id="coin100" onclick="setCoin(100)">
                <img src="<?=base_url()?>assets/images/chips6.png" alt="">
            </a>
            <!-- <a class="chip coin" id="coin200" onclick="setCoin(200)">
                <img src="<?=base_url()?>assets/images/chips7.png" alt="">
            </a> -->
            <a class="chip coin" id="coin500" onclick="setCoin(500)">
                <img src="<?=base_url()?>assets/images/chips7.png" alt="">
            </a>
             
            <a class="chip coin" id="coin1000" onclick="setCoin(1000)">
                <img src="<?=base_url()?>assets/images/chips8.png" alt="">
            </a>
        </div>
        <div class="row">
            <div class="col-6">
                <div id="sAll"></div>
            </div>
            <div class="col-6">
            <?php include 'includes/totalBetBox.php'; ?>
            </div>
        </div>
        <div class="clrBoth"></div>
        <div class="betPlaceTabelComb">
            <div class="betPlaceTabel">
                <div class="cplace-wrapper " id="dome">
                </div> 
            </div>
        </div>
        <div class="betResSection">
            <a   href="javascript:void(0)" onclick="resetAll()" class="imgBtn"><img src="<?=base_url()?>assets/images/cross.png"> Reset Bet</a>
            <!-- <a href="javascript:void(0)" class="imgBtn"><img src="<?=base_url()?>assets/images/2x.png"> Double</a> -->
            <a href="javascript:void(0)" onclick="undo('SinglePatti')" class="imgBtn"><img src="<?=base_url()?>assets/images/undo.png"> Undo</a>
            <a href="javascript:void(0)" onclick="repeatBet()" id='repeat' style='display:none;' class="imgBtn"><img src="<?=base_url()?>assets/images/repeat.png"> Repeat </a>
            <div class="clrBoth"></div>
            <a href="javascript:void(0)"  onclick="placeBetInstantWorli()" class="plceBet">Place Bet</a>
        </div> 
    </div>
    
    <?php
          include 'includes/footer.php'; 
    ?>
    <span class="iId" id="roundId"></span>
    <span class="iId" id="gameName">SingleDigit</span>
    <span class="iId" id="gameId">4</span>
    <span class="iId" id="timeId"></span>
   <script>
        console.log("<?=$_SESSION['userName']?>")
        function errorMassage(){
            alert('We have some technical issue in worli live streaming. It will start after the resolving the problem. We are sorry for your inconvenience.')
        }
    	$(document).ready(function(){
            var arr=['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            var dome = '<table class="table"><tbody>';
            const chunkSize = 5;
            for (let l = 0; l < arr.length; l += chunkSize) {
                const chunk = arr.slice(l, l + chunkSize);
                dome += '<tr>';
                $(chunk).each(function(t) {
                    dome += '<td><div class="cplace place-input-main" onclick="addCoinInstantWorli('+chunk[t]+',/'+"SingleDigit"+'/)"><label class="inputNo">'+chunk[t]+'</label><div class="cplace-box btInput pos"><div id="SinglePatti'+chunk[t]+'Akda-wrapper" class="text-center"></div></div></div></td>';
                    // dome += '<div class="cplace" onclick="addCoinInstantWorli('+arr[t]+',/'+"SingleDigit"+'/)"><span>'+arr[t]+'</span><div class="cplace-box"><div id="SinglePatti'+arr[t]+'Akda-wrapper" class="text-center"></div></div></div>';
                });
                dome += '</tr>';
            }
            dome += '</tbody></table>';


            var sAll = '<span class="btn sl-all" id="allPattiSelect" onclick="checkAll(['+arr+'],/'+"SingleDigit"+'/)">Select All Digit</span>';
            $('#sAll').empty();
            $('#sAll').append(sAll);
            $('#dome').empty();
            $('#dome').append(dome);

    		$(window).on('scroll', function(){
			  var s = $(window).scrollTop(),
			      d = $(document).height(),
			      c = $(window).height();
			  var scrollPercent = (s / (d - c)) * 100;
			   if(parseInt(scrollPercent)>= 9)	{
			   		var boxheight = (45/100)*parseInt(c);
			   		var chiplist = $(".chiplist-wrapper");
			   		var chipbox = $(".cplace-outer");
			   		var chipcontainer = $(".cplace-container");
			   		chiplist.css("position", "sticky");
			   		chiplist.css("top", "40px");
			   		chipbox.css("height", boxheight+"px");
			   		chipbox.css("overflow", "scroll");
			   		chipcontainer.css("position", "sticky");
			   		chipcontainer.css("top", "90px");
			   }
            })
    	});
    </script>

    <script type="text/javascript">
        function getPattiResponce(p,id){
            resetAllInstantWorli();
            var arr =[];
            var pattiAll =[];
            var sA = 'Select All Patti';
            if(p=="SinglePatti"){
	            arr['1']=['137', '146', '236', '245', '290', '380', '470', '489', '560', '579', '678', '128'];
	            arr['2']=['570', '237', '480', '156', '390', '147', '679', '345', '138', '589', '246', '129'];
	            arr['3']=['580', '238', '490', '157', '346', '148', '689', '256', '139', '670', '247', '120'];
	            arr['4']=['590', '239', '347', '158', '789', '257', '149', '680', '248', '130', '167', '356'];
	            arr['5']=['456', '249', '357', '230', '348', '168', '780', '159', '690', '258', '140', '267'];
	            arr['6']=['367', '240', '358', '349', '169', '790', '268', '150', '457', '259', '123', '178'];
	            arr['7']=['458', '269', '368', '250', '359', '179', '890', '340', '160', '467', '278', '124'];
	            arr['8']=['459', '260', '189', '369', '170', '567', '350', '134', '468', '125', '279', '378'];
	            arr['9']=['469', '234', '450', '270', '379', '180', '568', '360', '135', '478', '289', '126'];
	            arr['10']=['479', '280', '460', '190', '389', '145', '578', '370', '136', '569', '127', '235'];
            }else if(p=="DoublePatti"){
                arr['1']=['100', '335', '344', '119', '399', '155', '588', '227', '669'];
                arr['2']=['200', '336', '499', '110', '660', '228', '688', '255', '778'];
                arr['3']=['300', '355', '445', '166', '599', '229', '779', '337', '788'];
                arr['4']=['400', '338', '446', '112', '455', '220', '699', '266', '770'];
                arr['5']=['500', '339', '366', '113', '447', '122', '799', '177', '889'];
                arr['6']=['600', '448', '466', '114', '556', '277', '880', '330', '899'];
                arr['7']=['700', '223', '377', '115', '449', '133', '557', '188', '566'];
                arr['8']=['800', '288', '440', '116', '477', '224', '558', '233', '990'];
                arr['9']=['900', '225', '388', '117', '559', '144', '577', '199', '667'];
                arr['10']=['226', '668', '488', '118', '334', '299', '550', '244', '677'];
            }else if(p=="TriplePatti"){
                arr['1']=['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
            }else if(p=="SingleDigit"){
                arr['1']=['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                sA = 'Select All Digit';
            }
            var dome = '<table class="table"><tbody>';
            for (var i = 1; i < arr.length; i++) {
                if(p=="DoublePatti" || p=="SinglePatti"){
                    if(i==10){
                        dome += '<tr><td colspan="5"><div class="srId"><span class="sl-all pull-right" for="srid0" onclick="checkAll(['+arr[10]+'],/'+p+'/)">Select All <label for="srid0">0</label></span></div></td></tr>';
                    }else{
                        dome += '<tr><td colspan="5"><div class="srId"><span id="srid'+i+'" class="sl-all pull-right" onclick="checkAll(['+arr[i]+'],/'+p+'/)">Select All <label for="srid'+i+'">'+i+'</label></span></div></td></tr>';
                    }
                }
                
                const chunkSize = 5;
                for (let l = 0; l < arr[i].length; l += chunkSize) {
                    const chunk = arr[i].slice(l, l + chunkSize);
                    dome += '<tr>';
                    $(chunk).each(function(t) {
                        dome += '<td><div class="cplace place-input-main" onclick="addCoinInstantWorli('+chunk[t]+',/'+p+'/)"><label class="inputNo">'+chunk[t]+'</label><div class="cplace-box btInput pos"><div id="SinglePatti'+chunk[t]+'Akda-wrapper" class="text-center"></div></div></div></td>';
                        pattiAll.push(chunk[t]);
                    });
                    dome += '</tr>';
                }
            }
            dome += '</tbody></table>';
            var sAll = '<span class="btn sl-all" id="allPattiSelect" onclick="checkAll(['+pattiAll+'],/'+p+'/)">'+sA+'</span>';
            $('#sAll').empty();
            $('#sAll').append(sAll);
            $('#dome').empty();
            $('#dome').append(dome);
            $('#gameName').empty();
            $('#gameName').append(p);
            $('#gameId').empty();
            $('#gameId').append(id);
        }
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }

        function checkAll(val,p){
            $(val).each(function(i) {
                addCoinInstantWorli(val[i],p);
            });
        }

        $(document).ready(function() {
            buttonFunction();
            var gameName = $('#gameName').text();
            var viewWidth;
            var viewHeight;
            
            if(window.innerWidth !== undefined && window.innerHeight !== undefined) { 
                viewWidth = window.innerWidth;
                viewHeight = window.innerHeight;
            } else {  
                viewWidth = document.documentElement.clientWidth;
                viewHeight = document.documentElement.clientHeight;
            }
            if(parseInt(viewWidth) <= 340) {
                cplaceHeight = viewHeight-360+60;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }
            if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
                cplaceHeight = viewHeight-270-312;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
                cplaceHeight = viewHeight-394+60;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }else if(parseInt(viewWidth) >= 768) {
                cplaceHeight = viewHeight-359+60;
                $(".betPlaceTabelComb").height(cplaceHeight);
            }else{
                $(".betPlaceTabelComb").height(300);
            }
        

            function buttonFunction() {
                jQuery(".slide").on("click", function () {
                    jQuery(this).siblings().removeClass("active");
                    jQuery(this).toggleClass("active");
                });
            }

            window.addEventListener("online",function(){
                location.reload();
            });
            function checkFocus() {
                if (document.hidden) {
                    console.log('Web View Focus: Out of Focus');
                } else {
                    location.reload();
                }
            }
            document.addEventListener('visibilitychange', checkFocus);
            // window.addEventListener("focus",function(){
            //     location.reload();
            // });
            window.addEventListener("offline",function(){
                console.log('am offline')
            });
            // var video = $('#iFrameWin')[0];
            //(event) blur
            // video.addEventListener('waiting', function() {
            //     console.log('Video Status: Buffering...');
            // });

        });
    </script>
