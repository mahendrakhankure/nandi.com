<?php
include 'includes/header.php';
$imgF = 'images';
?>
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

    #wheelContainer1 {
      position: relative;
      width: 90vw;
      max-width: 500px;
      aspect-ratio: 1 / 1;
    }

    #wheelCanvas1 {
      position: absolute;
      top: 3%;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    #outerRingGIF {
      position: absolute;
      top: 3%;
      left: 0;
      pointer-events: none;
      height: 115%;
      transform: translate(-6.5%, -6.5%);
      width: 115%;
      z-index: 9;
    }

    #startWheel1 {
      margin-top: 20px;
      padding: 12px 24px;
      font-size: 16px;
      background: #ff9800;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    #startWheel1:hover {
      background: #e57c00;
    }
    #centerImage1 {
      position: absolute;
      top: 45%;
      left: 50%;
      width: 25%;
      height: 33%;
      transform: translate(-50%, -50%);
      z-index: 2;
      pointer-events: none;
    }
    
    .clockdiv {
      margin-bottom: 0rem !important;
      margin-top: 1.6rem !important;
    }
    #spinthewheel{
        display: flex;
        justify-content: center;   /* horizontal center */
        align-items: center;       /* vertical center */
        flex-direction: column;    /* stack items vertically */
        text-align: center;
    }
</style>
<link rel="stylesheet" href="<?=base_url()?>/assets/newDesign/css/custom.css">
<link rel="stylesheet" href="<?=base_url()?>/assets/newDesign/css/responsive.css">
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
        <!-- <img id="bgimage" class="bgimage" src="/assets/media/wheel.png"> -->
        <div class="col-md-12" id="spinthewheel">
            <div class="wheelContainer" id="wheelContainer1">
                <img id="outerRingGIF" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/ring-yellow1.png" />
                <!-- Inner wheel -->
                <canvas id="wheelCanvas1"></canvas>
                <img id="centerImage1" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/starlinen1.png" />
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?=base_url()?>/assets/js/starlineCanvasWheel.js"></script>