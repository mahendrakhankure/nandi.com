<?php
include 'includes/header.php';
// if ($_GET['app']) {
//     $imgF = $_GET['app'];
// } else {
//     $imgF = 'images';
// }
$imgF = 'images';
?>
<link rel="stylesheet" href="/assets/css/spinthewheel/style.css">

<style type="text/css">
    .test1 div {
        color: #EABA13;
        font-size: 14px;
        padding-right: 3px;
    }
    .clockdiv{
        color:#fff;
    }
    .cre{
        color:#fff;
    }
    /* #spinthewheel{
        display:none;
    } */
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
    .gv-days{
        border: 2px 0px solid #808080 !important;
    }
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
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

    #stremingGif img {
        width: 100%;
        height: 52.6vw;
    }
</style>
<link rel="stylesheet" href="/assets/newDesign/css/custom.css">
<link rel="stylesheet" href="/assets/newDesign/css/responsive.css">
<!-- Application Heading -->
<!-- <div class="container">
    <div class="row">
        <div class="col-12 app-heading">
            <h3 class="heading">
                <?= $gameDetail['bazar_name'] ?>
            </h3>
        </div>
    </div>
</div> -->
<!-- Game Variation Days -->
<div class="container-fluid container-custom">
    <div class="rows">
        <div class="col-12 gv-days dark">
        <p class="week-days">Sun,Mon,Tue,Wed,Thu,Fri,Sat</p>
            <!-- <div class="days">
                <h3>
                    <span>Sun </span>
                    <span>Mon </span>
                    <span>Tue </span>
                    <span>Wed </span>
                    <span>Thu </span>
                    <Span>Fri </Span>
                    <span>Sat </span>

                </h3>
            </div> -->
        </div>
    </div>
    <span class="live-center" style="align-items: center;display:block;">
        <a href="javascript:void(0)" id="myBtn" class="oldRed btn sl-all">Old Result</a>
        <!-- <a href="javascript:void(0)" id="myBtn" class="oldRed">Old Result</a> -->
    </span>
</div>
<!-- Game Variation Result and Time duration -->
<div class="container gv-wrapper">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center cre" id="spinakda">
                <?php
                if ($result != "--") {
                    echo $result;
                } else {
                    echo '***-**-***';
                }
                ?>
            </h3>
        </div>
        <div class="col-md-12" id="streming"></div>
        <!-- <div class="col-md-12" id="stremingGif"></div> -->
        <img id="bgimage" class="bgimage" src="/assets/media/wheel.png">
        <div class="col-md-12" id="spinthewheel">
            <div class="wheelContainer">
                <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" text-rendering="optimizeSpeed">
                    <defs>
                        <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%">
                            <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset>
                            <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop" />
                            <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0   0
                                            0 0 0 0   0 
                                            0 0 0 0   0 
                                            0 0 0 .3 0" />
                            <feBlend in="SourceGraphic" in2="color-out" mode="normal" />
                        </filter>
                    </defs>
                    <g class="mainContainer">
                        <g class="wheel" />
                        <!-- <image xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/assets/media/wheel.png" x="0%" y="39.5%" height="100%" width="100%"></image>        -->
                    </g>
                    <g class="centerCircle" Click />
                    <image class="clogo" xlink:href="/assets/media/clogo.png" width="460" height="460" x="282" y="453" />


                    <g class="wheelOutline">
                        <image class="clogo" xlink:href="/assets/media/outline.png" width="1024" height="900" x="0" y="232"></image>
                        <g class="pegContainer">
                            <image class="peg" xlink:href="/assets/media/peg.png" width="80" height="80" x="0" y="-20" />
                            <!-- <path  class="peg" fill="#e1c05c" d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232	s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z" />  -->
                        </g>
                        <g class="valueContainer" />

                </svg>
                <!-- <div class="toast"></div> -->

            </div>

        </div>
        <hr>
        <center class="clockdiv test1" data-date="<?= date('Y-m-d H:i:s', checkTime($gameDetail['time'])) ?>">
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
        </center>
        <!-- <div class="col-md-4 col-sm-8 col-xs-10 offset-md-4 offset-sm-2 offset-xs-1 gv-open-close">
                    <div class="open">Open Time</div>
                    <div class="pipe">|</div>
                    <div class="close">Close Time</div>
                </div> -->
    </div>
</div>
<!-- All Games List -->
<div class="container container-custom">
    <div class="row">
        <div class="col-12">
            <div class="gamelist akdaMain">
                <?php
                foreach ($gameType as $games) {
                ?>
                    <a href="<?= base_url(); ?>d04cd65a193d25064eb7375b799adc29/<?= $gameDetail['bazar_id'] ?>/<?= $games['id'] ?>/<?= $gameDetail['id'] ?><?= $tUrl ?>" class="akda-block">
                        <div class="game">
                            <img src="<?php echo base_url() . 'assets/' . $imgF . '/' . $games['icon']; ?>" alt="">
                            <label>
                                <?php
                                if ($games['id'] == 5) {
                                    echo 'CHOICE PANA';
                                } else if ($games['id'] == 12) {
                                    echo 'TWO DIGIT PANEL';
                                } else {
                                    echo $games['game_name'];
                                }
                                ?>
                            </label>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <table class="table table-responsive text-center">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Result Date</th>
                    <th>Patti</th>
                    <th>Akda</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;

                foreach ($marketResultOld as $r) {
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date("d-m-Y", strtotime($r['result_date'])) ?></td>
                        <td><?= $r['result_patti'] ?></td>
                        <td><?= $r['result_akda'] ?></td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    // setInterval(everyTime, 1000);
    // function everyTime(){
    //     var d=new Date();
    //     var open=<?= strtotime($gameDetail['time']) ?>;
    //     var ct= parseInt(d.getTime() / 1000)-360;
    //     var at= ct+360;
    //     var o=parseInt(open)-180;
    //     if (o > ct && o < at){
    //         if($("#streming").html() == ''){
    //             // var dome = '<div style="position:relative;"><iframe src="https://vdo-feedstg.jaaztech.com/?token=QVbu0naS1M" title="Live Satta Result" id="iFrameWin"></iframe></div>';
    //             $("#stremingGif").empty();
    //             var dome = '<div style="position:relative;"><iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-3"></iframe></div>';
    //             $("#streming").append(dome);
    //             console.log('working Not')
    //         }else{
    //             console.log("123");
    //         }
    //     }else{
    //         if($("#stremingGif").html() == ''){
    //             $("#streming").empty();
    //             var k = '<div style="position:relative;"><img src="<?= base_url() ?>assets/images/regular/starline.gif" alt="" id="iFrameWin"></div>';
    //             // console.log(<?= $marketDetail['id'] ?>)
    //             // console.log(gif)
    //             $("#stremingGif").append(k);
    //             // $("#timeID").show();
    //         }
    //     }
    // };
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
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/utils/Draggable.min.js'></script>
<script src='/assets/js/spinthewheel/ThrowPropsPlugin.min.js'></script>
<script src='/assets/js/spinthewheel/ChillSpinTheWheel.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
<script src="/assets/js/spinthewheel/index.js"></script>