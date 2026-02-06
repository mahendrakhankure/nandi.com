<?php 
    include 'includes/header.php'; 
    // if($_GET['app']){
    //     $imgF=$_GET['app'];
    // }else{
    //     $imgF='images';
    // }
    $imgF='images';
?>
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/spinthewheel/style.css">
    <style type="text/css">
        body{
            background-color:#1d1d27;
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
          width: 70%;
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
        .cre{
            color:#fff;
        }
        .clockdiv{
            color:#fff;
            margin-top: 5%;
        }
         #wheelContainer1 {
            position: relative;
            width: 90vw;
            max-width: 500px;
            aspect-ratio: 1 / 1;
            /* left:25%; */
            z-index: 9;
        }

        #kingBazarWheelCanvas {
            position: absolute;
            top: 3%;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #outerRingGIF {
            position: absolute;
            top: 3%;
            pointer-events: none;
            height: 110%;
            transform: translate(-4.5%, -4.5%);
            width: 110%;
            z-index: 99;
        }

        #centerImage1 {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 25%;
            height: 25%;
            transform: translate(-50%, -50%);
            z-index: 2;
            pointer-events: none;
        }
        .wheelContainer{
            margin-left: auto;
            margin-right: auto;
            left: 0% !important;
            top: 0% !important;
            transform: translate(0%, 0%) !important;
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
        <!-- Game Variation Days -->
        <div class="container-fluid  container-custom">
            <div class="rows"><div class="col-12 gv-days dark">
                <p class="week-days">Sun,Mon,Tue,Wed,Thu,Fri,Sat</p>
            </div></div>
            <div style="align-items: center;" class="h-100 d-flex align-items-center justify-content-center">
                <a href="javascript:void(0)" id="myBtn" class="btn sl-all">Old Result</a>
            </div>
            <!-- <span class="bett-action" style="align-items: center;">
                
                <a  href="javascript:void(0)" id="myBtn" class="btn btn-lg">Old Result</a>
            </span> -->
        </div>
        <!-- Game Variation Result and Time duration -->
        <div class="container gv-wrapper" >
            <div class="row">
                <div class="col-12">  
                    <h3 class="text-center cre" id="spinking">
                        <?php
                            if($result['result']!="--"){
                                echo $result['result'];
                            }else{
                                echo '***-**-***';
                            }
                        ?>
                    </h3>
                </div>
                
                <div id='wheelContainer1' class="wheelContainer">
                    <img id="outerRingGIF" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ring1.png" />
                    <canvas id="kingBazarWheelCanvas"></canvas>
                    <img id="centerImage1" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/KING-BAZAR.png" />
                </div>
                <hr>
                <center class="clockdiv"  data-date="<?=date('Y-m-d H:i:s',checkTime($marketDetail['time']))?>">
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
            </div>
        </div>
        
        <!-- All Games List -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="gamelist akdaMain">
                        <a href="<?=base_url();?>5bfdc27f43fb4f5d76b0028e908b64a4/<?=$marketDetail['id']?>/1<?=$tUrl?>" class="akda-block">
                            <div class="game">
                                <img src="<?php echo base_url().'assets/'.$imgF.'/tab10.png'; ?>" alt="">
                                <label>First Digit(Ekai)</label>
                            </div>
                        </a>
                        <a href="<?=base_url();?>5bfdc27f43fb4f5d76b0028e908b64a4/<?=$marketDetail['id']?>/2<?=$tUrl?>" class="akda-block">
                            <div class="game">
                                <img src="<?php echo base_url().'assets/'.$imgF.'/tab10.png'; ?>" alt="">
                                <label>Second Digit(Haruf)</label>
                            </div>
                        </a>
                        <a href="<?=base_url();?>5bfdc27f43fb4f5d76b0028e908b64a4/<?=$marketDetail['id']?>/3<?=$tUrl?>" class="akda-block">
                            <div class="game">
                                <img src="<?php echo base_url().'assets/'.$imgF.'/tab17.png'; ?>" alt="">
                                <label>Jodi</label>
                            </div>
                        </a>
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
                        <th>Jodi</th>
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
                        <td><?=$r['result']?></td>
                    </tr>
                <?php $i++; } ?>
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
    <script src="<?=base_url()?>/assets/js/kingBazarCanvasWheel.js"></script>