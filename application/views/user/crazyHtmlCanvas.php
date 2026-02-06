<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=" ">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> 
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/crezyMatkaSpeen/crezyStyle.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/crezyMatkaSpeen/crezyStyleFlipCoin.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/crezyMatkaSpeen/style.css"> 
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/timer.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script> -->
</head>
<?php date_default_timezone_set('Asia/Kolkata'); ?>
<body>
<!-- <div id="loader">
  <div class="circle-loader">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
    <div class="circle circle-4"></div>
  </div>
</div> -->
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/back-flip-coin-wheel1.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips01.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips02.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips03.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips04.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips05.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips06.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips07.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips08.png" style="display: none;">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/blankchips09.png" style="display: none;">
<span id="TokenId" style="display: none;"><?=$_GET['token']?></span>
<style>
    /* css for loader start */
    #loader{
    width:100%;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    position: absolute;
    z-index: 9;
    }
    .circle-loader {
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .circle {
    position: absolute;
    border: 3.5px solid transparent;
    border-radius: 50%;
    animation: rotate 3s infinite ease-in-out;
    }

    .circle-1 {
    width: 250px;
    height: 250px;
    border-top-color: rgb(99, 102, 241);
    border-right-color: rgb(99, 102, 241);
    animation-delay: -0.15s;
    }

    .circle-2 {
    width: 200px;
    height: 200px;
    border-top-color: #404041;
    border-right-color: #404041;
    animation-delay: -0.3s;
    }

    .circle-3 {
    width: 150px;
    height: 150px;
    border-top-color: rgb(99, 102, 241);
    border-right-color: rgb(99, 102, 241);
    animation-delay: -0.45s;
    }

    .circle-4 {
    width: 100px;
    height: 100px;
    border-top-color: #404041;
    border-right-color: #404041;
    animation-delay: -0.6s;
    }

    @keyframes rotate {
    50% {
        transform: rotate(360deg);
    }
    }

    .timer-text {
    position: absolute;
    font-size: 48px;
    color: black;
    }
    /* css for loader end */
    /* Responsive Coin */
    .pos-rupi
    {
    position: absolute;
        top: 29%;
        right: 20px;
        width: 25%;
    }
    .pos-rupi img{
        width: 100%;
    }
    .betInfo
    {
        position: relative
    }

    .pos-rupi-s1
    {
        position: absolute;
        top: 20%;
        right: 20px;
        width: 8%;
    }
    .pos-rupi-s2
    {
        position: absolute;
        top: 20%;
        right: 20px;
        width: 8%;
    }
    .betInfo
    {
        position: relative
    }
    /* Responsive Coin */
    
    .innerMain{
        /* background-image: linear-gradient(#000, #FDB14E); */
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(253, 177, 78, 0.5));
        /* top:47% !important; */
    }
    .coinImg{
        margin-top: 10px;
    }
    .point0 .countNo {
        position: absolute;
        text-align: center;
        left: 75%;
        margin-left: -59px !important;
        font-size: 14px;
    }
    .point0 .countNo{
        top: 13%;
        margin-left: -79px;
    }
    .countNo{
        position: absolute;
        text-align: center;
        top: 40%;
        left: 0%;
        /* margin-left: -62px; */
        font-size: 14px;
        width: 100%;
        color:#000;
        font-family: "Poppins Bold";
        font-weight:700;
    }
    .text-center{
        text-align: right !important;
    }
    .point0 .pos-rupi{
        position: absolute;
        top: -17%;
        right: 12px;
        width: 13%;
    }
    .point0.pos-rupi {
        position: absolute;
        top: -9%;
        right: 12px;
        width: 13%;
    }
   
    .point0.pos-rupi  .countNo{
        top: 46% !important;
        margin-left: 0;
    }
    .wheelSVG1{
        transform: translate(-0%, -25%) matrix(1, 0, 0, 1, 0, 0) !important;
        overflow: visible;
    }
    .buttonToSpeen{
        width: 140px;
        display: block;
        margin: auto;
        text-decoration: none;
    }
    #alertJ div {
        left: 10%;
        top: 75px;
        text-align: center;
    }
    /* .my-popup-outer {
        box-shadow: 0px 0px 8px 2px #fbb700;
        width: 225px;
        height: 125px;
        position: absolute;
        background: rgba(243, 246, 244, 0.1);
        text-align: center;
        left: 50%;
        top: 43%;
        transform: translate(-50%, -30%);
        z-index: 1000;
        border: 2px solid #eee;
        border-radius: 15px;
    } */
    .my-popup-outer {
        width: 225px;
        height: 125px;
        position: absolute;
        background: rgba(243, 246, 244, 0.1);
        text-align: center;
        left: 50%;
        top: 43%;
        transform: translate(-50%, -30%);
        z-index: 1000;
    }
    .my-popup {
        margin-top: 16px;
        color: #fff;
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
    .my-popup-inner h3 {
        text-transform: uppercase;
        font-size: 18px;
        font-weight: 750;
        letter-spacing: 1.1px;
        line-height: 30px;
    }
    .my-popup-inner i.fa-star {
        color: #1af764;
    }
    .my-popup-inner i {
        font-size: 13px;
    }
    .alert{
        z-index: 9;
    }
    
    .wheelSvg1{
        margin-top: -35px;
    }
    #canvas{
        position: absolute;
        display:none;
    }  
    .mainOuter{
        background-image:url('https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/wheelBackground3.webp');
        background-repeat: no-repeat;
        background-size: cover;
        background-position:center;
    }
    .countNo1{
        position: absolute;
        top: 40%;
        left: 45%;
        text-align: center;
        font-size: 14px;
        color: #000;
        font-family: "Poppins Bold";
        font-weight: 700;
    }
    .countNo2{
        position: absolute;
        text-align: center;
        color: #000;
        font-family: "Poppins Bold";
        width: 100%;
    }
    /* Flip the coin start */
    .container{
        width: 400px;
        padding: 35px;
        position: absolute;
        transform: translate(-50%,-50%);
        top: 50%;
        left: 50%;
        box-shadow: 15px 30px 35px rgba(0,0,0,0.1);
        border-radius: 10px;
        -webkit-perspective: 300px;
        perspective: 300px;
    }
    .stats{
        display: flex;
        color: #ffffff;
        font-weight: 500;
        padding: 20px;
        margin-bottom: 20px;
        margin-top: 35px;
        box-shadow: 0 0 20px rgba(0,139,253,0.25);
    }
    .stats #spades-count{
        margin-left: 15%;
    }
    .stats #diamonds-count{
        margin-left: 25%;
    }
    .coin{
        height: 150px;
        width: 150px;
        position: relative;
        margin: 32px auto;
        right: 0% !important;
        -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
    }
    .coin img{
        width: 145px;
    }
    .spades,.diamonds{
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
    }
    .diamonds{
        transform: rotateX(180deg);
    }
    /* @keyframes spin-diamonds{
        0%{
            transform: rotateX(0);
        }
        100%{
        
            transform: rotateX(-2000deg) rotateY(10797deg) rotateZ(0deg)
        
        }
    }
    @keyframes spin-spades{
        0%{
            transform: rotateX(0);
        }
        100%{
            transform: rotateX(-1080deg) rotateY(5760deg) rotateZ(0deg);
        }
    } */
    @keyframes spin-diamonds{
        0%{
            transform: rotateX(0deg);
        }
        100%{
        
            transform: rotateX(5760deg);
        
        }
    }
    @keyframes spin-spades{
        0%{
            transform: rotateX(0deg);
        }
        100%{
            transform: rotateX(5760deg);
        }
    }
    /* Flip the coin end */
    /* Media Query Start */
        @media only screen and (max-width: 1200px) {
        
        }
        @media only screen and (max-width: 840px) {
            .point0 .countNo1 {
                max-width: 60%; 
            }
        }

        @media only screen and (max-width: 767px) {
        
        }
        @media only screen and (max-width: 720px) {
            .point0 .countNo1 {
                max-width: 85%; 
            }
        }
        @media only screen and (max-width: 640px) {
            .betInfo .point0 .countNo1 {
                left: 42% !important;
                top: 45%;
            }
            .tp .pos-rupi .countNo1 {
                left: 36% !important;
                top: 42% !important;
            }
        }
        @media only screen and (max-width: 620px) {
            .betInfo .point0 .countNo1 {
                left: 41% !important;
                top: 45%;
            }
            .tp .pos-rupi .countNo1 {
                left: 36% !important;
                top: 42% !important;
            }
        }
        @media only screen and (max-width: 580px) {
            .betInfo .point0 .countNo1 {
                left: 40% !important;
                top: 45% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 34% !important;
                top: 42% !important;
            }
        }
        @media only screen and (max-width: 540px) {
            .betInfo .point0 .countNo1 {
                left: 40% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 34% !important;
            }
        }

        @media only screen and (max-width: 480px) {
            .betInfo .point0 .countNo1 {
                left: 40% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 30% !important;
            }
        }

        @media only screen and (max-width: 440px) {
            .betInfo .point0 .countNo1 {
                left: 38% !important;
                top: 44% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 30% !important;
            }
        }
        @media only screen and (max-width: 420px) {
            .betInfo .point0 .countNo1 {
                left: 36% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 28% !important;
            }
        }
        @media only screen and (max-width: 390px) {
            .betInfo .point0 .countNo1 {
                left: 35% !important;
            }
            .tp .pos-rupi .countNo1 {
                left: 28% !important;
            }
        }

        @media only screen and (max-width: 360px) {
            .betInfo .point0 .countNo1 {
                left: 34% !important;
            }
            .tp .pos-rupi .countNo1 {
                top: 40% !important;
                left: 24% !important;
            }
        }
    /* Media Query End */
    .winnerList{
        height: 150px;
        position: absolute;
    }
    #winnerList::-webkit-scrollbar {
        background: transparent; /* make scrollbar transparent */
        width: 0px;
    }
    .betInfo1 {
        width: 50%;
        margin-top: 10px;
        margin-bottom: 10px;
        position: relative;
    }
    .betInfo1 img{
        width: 100%;
    }
    /* fire effect start */
    :root {
        /* the only thing needed is a grainy/noisy background image */
        --glitter: url("https://assets.codepen.io/13471/silver-glitter-background.png");
    }

    .fire::before,
    .fire::after {
        content: "";
        position: absolute;
        inset: 0;
    }

    .fire::before {
        content: "";
        background-image: var(--glitter), var(--glitter),
            linear-gradient(
                0deg,
                white 0px,
                #ff8951 5px,
                #dcbc169c 30%,
                transparent 70%
            ),
            radial-gradient(ellipse at bottom, transparent 30%, black 60%);
        background-size: 350px 500px, 400px 650px, 100% 100%, 100% 100%;
        background-blend-mode: hard-light, color-dodge, multiply;
        background-position: 0px 0px, 0px 0px, var(--gradientPos);
        background-repeat: repeat, repeat, repeat, no-repeat;
        mix-blend-mode: color-dodge;
        filter: brightness(3.7) blur(7px) contrast(6);
        animation: fire 1.75s linear infinite;
        box-shadow: inset 0 -40px 50px -60px #63bbc5;
    }

    @keyframes fire {
        0% {
            background-position: center 0px, center 0px, 50% 100%, center center;
        }
        100% {
            background-position: center -500px, center -650px, 50% 100%, center center;
        }
    }

    .fire {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    /* fire effect end */
    .ud1{
        float:right;
    }
    @keyframes toTheTop {
        0% {
            transform: translateY(0%);
        }
        100% {
            transform: translateY(-100%);
        }
    }
    .stack {
        height: 100%;
        width: fit-content;
        justify-content: center;
        align-items: center;
        /* animation: toTheTop 3s linear; */
        animation: toTheTop 3s infinite linear;
        z-index: -2;
    }
    ul{
        padding-left: 0rem !important;
    }
    .btn-red, .btn-black {
      border-radius: 10px;
      margin: -23% 0%;
      width: 50%;
    }
    
    .btn-black1, .btn-red1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0% 0%;
        font-weight: 800;
        font-size: 160%;
        font-weight: bold;
        font-family: Arial, sans-serif;
        background: linear-gradient(45deg, #f9d976, #f39f2c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }
    .number1 {
      position: relative;
      float: left;
      text-align: center;
      font-size: 12px;
      font-weight: bold; 
      margin: 0% 0%;
    }
    .number2 {
      position: relative;
      float: right;
      text-align: center;
      font-size: 12px;
      font-weight: bold;
      margin: 0% 0%;
    }


    .bottomDv {
        /* padding-bottom: 100px !important; */
    }
    .col.circl-md.col-inner {
        /* margin: 2% 0%; */
    }
    .betInfo1 {
        /* margin-top: 20px !important;
        margin-bottom: 25px !important; */
    }
    /* .inner {
        width: 50px !important;
    } */
    .inner {
        width: 15% !important;
    }
    .pos-rupi {
        right: 2px;
        width: 45%;
    }
    .payOut{
        /* position: absolute;
        margin-left: -85%; */
        color: #09d747;
        font-size: 12px;
    }

    .mkAni,.mkAni1 {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      /* object-fit: cover; */
      z-index: 999;
      display:none;
      /* transform: translate(-50%, -50%) scale(0);
      transition: transform 1s ease-out; */
    }

    /* Animation for the image */
    .zoom-in {
      /* transform: scale(1); Zoom to full size */
      transform: translate(0%, 0%) scale(1);
    }
    .redBlackButton {
        position: absolute;
        top: 145%;
    }
    .amt{
        margin: 0% 20% !important;
    }
    .pegContainer1 {
        transform: matrix(1.2, 0, 0, 1.2, -98.4, -66.8) !important;
    }

    .mainOuter, .transac {
        transition: transform 0.8s ease;
        will-change: transform; /* Hints browser for performance */
    }

    .vd-cont {
        max-width: 600px;
        margin: auto;
        position: relative;
        background-color: #30384e;
        padding: 10px;
            color: white;
    }

    .vd-header {
        text-align: center;
        font-size: 1.2em;
        margin-bottom: 15px;
    }

    .vd-inner {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .dv-card {
        background-color: #1b233e;
        border-radius: 10px;
        padding: 5px 6px;
        width: 24%;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);
        border: 1px solid #4b536e;
    }

    .dv-card h3 {
        margin: 4px 0 5px;
        font-size: 2em;
        color: #00ffff;
    }

    .dv-card p {
        margin: 5px 0;
        font-size: 0.78em;
    }

    .play-button {
        margin-top: 5px;
        background-color: #ffffff;
        color: #333;
        border: none;
        padding: 5px 32%;
        border-radius: 25px;
        cursor: pointer;
    }

    .footer-vd {
        margin-top: 30px;
        text-align: center;
        font-size: 0.9em;
        color: #fff;
    }

    .footer-vd p {
        margin: 0;
        padding-bottom: 5px;
    }

    .betInfo {
        text-align: center
    }

    .sep {
        width: 45%;
        border: 1px solid #fff;
        display: block;
        margin: auto;
        margin-top: 7px;
        margin-bottom: 9px;
    }

    .ldv {
        float: left;
        text-align: left;
    }

    .Rdv {
        float: right;
        text-align: right
    }

    .clrBoth {
        clear: both;
        height: 0;
        line-height: 0;
        width: 100%
    }

    .auto-img {
        width: 18px;
        height: 16px;

    }

    .cross {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #fff;
        text-decoration: none
    }
    .wheelContainer,.wheelContainer1,.wheelContainer2 {
        width: 74vw;
        max-width: 600px;
        
    }
    #wheelCanvas {
        width: 100%;
        height: auto;
        display: block;
        transform: translate(0%, 52%);
    }

    #wheelCanvas2 {
      /* position: absolute; */
      top: 0;
      left: 0;
      width: 100%;
      /* height: 100%; */
      pointer-events: none;
      transform: translate(0%, 60%);
    }

    #outerRingGIF2 {
      position: absolute;
      top: 0;
      left: 0;
      pointer-events: none;
      /* height: 115%; */
      transform: translate(-8.8%, 40.2%);
      width: 122%;
    }

    #startWheel2 {
      margin-top: 20px;
      padding: 12px 24px;
      font-size: 16px;
      background: #ff9800;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    #startWheel2:hover {
      background: #e57c00;
    }
    #centerImage2 {
        position: absolute;
        top: 45%;
        left: 50%;
        width: 25%;
        height: 33%;
        transform: translate(-50%, 75%);
        z-index: 2;
        pointer-events: none;
    }
    #wheelCanvas1 {
      /* position: absolute; */
      top: 0;
      left: 0;
      width: 100%;
      /* height: 100%; */
      pointer-events: none;
      transform: translate(0%, 9%);
    }

    #outerRingGIF1 {
      position: absolute;
      top: 0;
      left: 0;
      pointer-events: none;
      /* height: 115%; */
      width: 86%;
      transform: translate(9%, 4.5%);
    }

    #startWheel1 {
      margin-top: -40px;
      font-size: 16px;
      background: #ff9800;
      color: white;
      border: none;
      cursor: pointer;
    }

    #startWheel1:hover {
      background: #e57c00;
    }
    #centerImage1 {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 25%;
        height: 33%;
        transform: translate(-50%, -50%);
        z-index: 2;
        pointer-events: none;
    }
    #outerRingGIF {
        position: absolute;
        top: 50%;
        left: 0;
        pointer-events: none;
        /* height: 115%; */
        width: 107%;
        transform: translate(-3%, -5.5%);
    }
</style>

<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Red-and-White.webp" class="mkAni">
<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/crazy-wheel_lowpixel.webp" class="mkAni1">

<div id="alertJ" style="display: none;"></div>
<!-- <div class="col-12 my-popup-outer" id="popUpDiv" style="display: none;">
    <div class="my-popup">
        <div class="my-popup-inner">
            <h3>
                <i class="fa fa-star fa-sharp fa-solid"></i>You Win<i class="fa fa-star fa-sharp fa-solid"></i>
            </h3>
            <p>
                <i class="fa fa-solid fa-indian-rupee-sign"></i>
                <span id="popUpWin">93.1</span>
            </p>
        </div>
    </div>    
</div> -->
<div class="col-12 my-popup-outer" id="popUpDiv" style="display:none;overflow: hidden;">
    <img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/win.webp" style="position: absolute;width:100%;height:100%;left: 0;object-fit:cover;">
    <p id="popUpWin" style="position: relative;margin-top: 37%;">93.1</p>
</div>
<div class="mainOuter container-fluid">
    <div onclick="sound()" style='cursor: pointer; position: absolute; z-index: 999; width: 5%;'><i class="fa-solid fa-volume-up"></i></i></div>
    

    
    <!-- Voice Command start -->
        <!-- <div class="ud1"  onclick="startConverting()">
            <a href="javascript:void(0)" class="awBtn">
                <i class="fa fa-microphone btn btn-danger"></i>
            </a>
        </div> -->
    <!-- Voice Command end -->
    <canvas id="canvas"></canvas>        
    <div class="videoDv"> 
        <div class="col-12">
            <h3 class="text-center cre" id="spinakda">
            </h3>
        </div>
        <div class="col-md-12" id="spinthewheel">
            <div class="wheelContainer" id="crezyWheel">
                <canvas id="wheelCanvas"></canvas>
                <img id="outerRingGIF" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Wheel-Ring-Light-1.webp" />
                <button id="startWheel">Start</button>
            </div>

            <div class="wheelContainer1 crezyWheelContainer" id="crezyWheelWin">
                    <!-- Outer animated ring -->
                <img id="outerRingGIF1" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Wheel-Ring-Light-1.webp" />

                <!-- Inner wheel -->
                <canvas id="wheelCanvas1"></canvas>
                <img id="centerImage1" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/POINTER3.svg" />
                <button id="startWheel1">Start</button>
            </div>
            <!-- Coin flip start -->
            <div class="wheelContainer2" id="crezyWheel2">
                <!-- Outer animated ring -->
                <img id="outerRingGIF2" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/outline.png" />

                <!-- Inner wheel -->
                <canvas id="wheelCanvas2"></canvas>
                <img id="centerImage2" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/POINTER3.svg" />
                <button id="startWheel2">Start</button>
                <div style="display:flex; flex-direction: row;" class='redBlackButton' >
                    <div class='number1'><img src='https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/red-button-n1.png' class='btn-red'><div class="btn-red1"></div></div>
                    <div class='number2'><img src='https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/black-button-n1.png' class='btn-black'><div class="btn-black1"></div></div>
                </div>
                <!-- <button class='btn btn-red'>RED</button>
                <button class='btn btn-black'>BLACK</button> -->
            </div>
            <!-- Coin flip end -->
        </div>
    </div>
    <div class="winnerList">
        <ul id="winnerList" style="list-style-type: none;overflow: scroll;height: 160px;margin-top: -150px;">
        <div class="stack">
            <!-- <li>name</li>
            <li>mack</li>
            <li>401</li>
            <li>at</li>
            <li>logic</li>
            <li>assess</li>
            <li>nagpur</li>
            <li>as</li>
            <li>senior</li>
            <li>php</li>
            <li>developer</li> -->
        </div>
        </ul>
    </div>
    <div class="centerCoin" id="centerCoin" style="display:none;">
    </div>
    <div class="innerMain bootOuter">
        <div class="transac">
            <div class="outer-scrolling bootScroll">
                <div class="inner-scrolling" style="padding-left: 10px; padding-right: 10px;">
                    <?php
                        if($res){
                            for($i=count($res); $i>-1; $i--){
                                if(isset($res[$i]['akda'])){
                                    echo "<div class='inner scrollitem'>
                                        <img src='https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/".$res[$i]['akda'].".avif'>
                                    </div>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
                <div class="middletop tp">
                    <div class="row">
                        <div class="col circl-md col-inner cplace place-input-main" onclick="queueAddCoin(1,'/SinglePatti/')">
                            <span class="payOut lable-desc-1"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-1.avif">
                            <div id="SinglePatti01Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(2,'/SinglePatti/')">
                            <span class="payOut lable-desc-2"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-2.avif">
                            <div id="SinglePatti02Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(3,'/SinglePatti/')">
                            <span class="payOut lable-desc-3"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-3.avif">
                            <div id="SinglePatti03Akda-wrapper" class="cplace-box text-center pos-rupi unlocked"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(4,'/SinglePatti/')">
                            <span class="payOut lable-desc-4"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-4.avif">
                            <div id="SinglePatti04Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(5,'/SinglePatti/')">
                            <span class="payOut lable-desc-5"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-5.avif">
                            <div id="SinglePatti05Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col circl-md col-inner" onclick="queueAddCoin(6,'/SinglePatti/')">
                            <span class="payOut lable-desc-6"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-6.avif">
                            <div id="SinglePatti06Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(7,'/SinglePatti/')">
                            <span class="payOut lable-desc-7"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-7.avif">
                            <div id="SinglePatti07Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(8,'/SinglePatti/')">
                            <span class="payOut lable-desc-8"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-8.avif">
                            <div id="SinglePatti08Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner" onclick="queueAddCoin(9,'/SinglePatti/')">
                            <span class="payOut lable-desc-9"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-9.avif">
                            <div id="SinglePatti09Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                        </div>
                        <div class="col circl-md col-inner cplace place-input-main" onclick="queueAddCoin(0,'/SinglePatti/')">
                            <span class="payOut lable-desc-0"></span>
                            <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Ticket-0.avif">
                            <div id="SinglePatti00Akda-wrapper" class="cplace-box text-center pos-rupi"></div> 
                        </div>
                    </div>
                    <div class="clrBoth"></div>
            </div>
            <div class="row">
                <div class="betInfo1 col-md-6" onclick="queueAddCoin(11,'/SinglePatti/')">
                    <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/bonus2.avif">
                    <div class="btInput pos">
                        <div id="SinglePatti11Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div>
                    </div> 
                </div>
                <div class="betInfo1 col-md-6" onclick="queueAddCoin(10,'/SinglePatti/')">
                    <img class="imag" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Long-Strip-RED-BLACK-Ticket-GIF.gif">
                    <div class="btInput pos">
                        <div id="SinglePatti10Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div>
                    </div> 
                </div>
            </div>
            <div class="clrBoth"></div>
                <a href="javascript:void(0)" class="allbet-l" id="Odd"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Odd1.png"></a>
                <a href="javascript:void(0)" class="allbet" id="allbet"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/bets-all1.png"></a>
                <a href="javascript:void(0)" class="allbet-r" id="Even"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Even1.png"></a>
            <div class="clrBoth"></div>
            
            <div class="bottomDv">
                <div class="bottomTop">
                <span class="rdv" id="2X"><a href="javascript:void(0)" class="awBtn">
                    <i class="fa fa-bars"></i>
                    </a></br>2X</span>
                <span class="rdv1" id="autoLast"><a href="javascript:void(0)" class="awBtn">
                    <i class="fa fa-bars"></i>
                    </a></br>Auto</span>
                <div class="middlebtm">
                    <a href="#"  onclick="resetAllCrezyMatka()" class="awBtn">
                        <i class="fa fa-undo"></i>
                        <span href="#" class="ud">Undo</span>
                    </a>
                    <span class="amt">
                        <!------/* Circle pop-put  CHips */ ----------->
                        <div class="menu">
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(10)" id="coin10"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips3.png"></a>
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(20)" id="coin20"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips4.png"></a>
                            
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(50)" id="coin50"><img src="<?=base_url()?>\assets\images\blankchips05.png"></a>
                            <!-- <a href="javascript:void(0)" onclick="setCoinCrezyMatka(50)" id="coin50"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips5.png"></a> -->
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(100)" id="coin100"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips6.png"></a>
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(500)" id="coin500"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips7.png"></a>
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(1000)" id="coin1000"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips8.png"></a>
                            <a href="javascript:void(0)" onclick="setCoinCrezyMatka(10000)" id="coin10000"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/chips9.png"></a>
                            <button id="toggle-btn">
                                <img src="<?=base_url()?>\assets\images\blankchips05.png" id="main-char">
                            </button>
                        </div>
                        <!------/* ##### Circle pop-put  CHips */ ----------->
                    </span>   
                    <a href="javascript:void(0)" class="awBtn" id="repeatLast">
                        <i class="fa fa-refresh"></i>
                        <span class="rd">Repeat</span>
                    </a>
                <div class="clrBoth"></div>   
                </div>    
                <div class="clrBoth"></div>    
                </div>
                <div class="clrBoth"></div>   
                <div class="bottoml">
                    <p><span>Balance :</span> <?php //$_GET['app']=="BD"?"TAKA":"&#x20B9;"; ?> <span id="bal">10000<?= round($bal); ?></span></p> 
                </div>
                <div class="bottomr">
                    <p>Total Bet : <span id="totalAmount">0</span></p>
                    <span style='display:none;' id='r'><?=$rate['bhav']?></span>
                </div>
                <div class="clrBoth"></div>   
            </div>
        </div>
    </div>
    <div class="clrBoth"></div> 
    <!-- timer start here -->
        <div class="main-container" id="mainContainer">
            <div class="countdown-container">
            <svg class="countdown-svg" viewBox="0 0 100 100">
                <defs>
                <linearGradient id="calm-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <!-- Default Gradient for initial load -->
                    <stop offset="0%" style="stop-color:#9a4e2b" />
                    <stop offset="50%" style="stop-color:#693d1e" />
                    <stop offset="100%" style="stop-color:#3b2416" />
                </linearGradient>
                </defs>
                <circle class="countdown-circle" cx="50" cy="50" r="45"></circle>
            </svg>
            <div class="countdown-text" id="countdown">00</div>
            </div>
            <div class="ot">
                <div class="countdown-input-wrapper">
                <input type="number" class="countdown-input" id="timeInput" placeholder="Enter Seconds" min="1" value="35">
                <div class="input-arrows">
                    <i class="fas fa-chevron-up" onclick="incrementTime()"></i>
                    <i class="fas fa-chevron-down" onclick="decrementTime()"></i>
                </div>
                </div>
                <div class="button-container">
                <button class="countdown-button" onclick="startCountdown()" id="startButton">
                    <i class="fa-solid fa-hourglass-start" id="startIcon"></i> Start
                    <span class="tooltip">Enter Seconds</span>
                </button>
                <button class="countdown-button" onclick="stopCountdown()" id="stopButton" disabled>
                    <i class="fa-solid fa-hourglass-start" id="stopIcon"></i> Stop
                </button>
                </div>
                <div class="season-icons">
                <i class="fas fa-snowflake season-icon" onclick="changeSeason('winter')" id="winterIcon"></i>
                <i class="fas fa-seedling season-icon" onclick="changeSeason('spring')" id="springIcon"></i>
                <i class="fas fa-sun season-icon" onclick="changeSeason('summer')" id="summerIcon"></i>
                <i class="fas fa-leaf season-icon active" onclick="changeSeason('fall')" id="fallIcon"></i>
                </div>
            </div>
        </div>
    <!-- timer end here -->
</div>
<div class="vd-cont" style="display:none;">
        <a href="#" class="cross">X</a>
        <div class="vd-header"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Auto-Play.png" class="auto-img"> Autoplay</div>
        <p class="betInfo">Bet per Round <span id="_betPerRound"></span></p>
        <!-- <p class="betInfo">Bet per Round <span class="rd">120</span></p> -->
        <div class="vd-inner">
            <div class="dv-card" onclick="setAutoBet(10)">
                <h3>10 </h3>
                <p>ROUNDS</p>
                <span class="sep"></span>
                <p id="_10round"></p>
                <button class="play-button">▶</button>
            </div>
            <div class="dv-card" onclick="setAutoBet(15)">
                <h3>15 </h3>
                <p>ROUNDS</p>
                <span class="sep"></span>
                <p id="_15round"></p>
                <button class="play-button">▶</button>
            </div>
            <div class="dv-card" onclick="setAutoBet(25)">
                <h3>25 </h3>
                <p>ROUNDS</p>
                <span class="sep"></span>
                <p id="_25round"></p>
                <button class="play-button">▶</button>
            </div>
        </div>
    </div> 
<audio id="audioBackground" autoplay muted loop playsinline>
<source src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/abcde.mp3" type="audio/mp3">
<!-- <source src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/Crazy-TimeMain-GameBGM.mp3" type="audio/mp3"> -->
</audio>
<span style='display:none;' id='clientCommission'><?=$client['commission']?></span>
<input type="hidden" name="rId" id="rId" value="<?=$rId['roundId']?>">
<input type="hidden" id="visibilitychange" readonly="true" value="<?=$rId['roundId']?>"/>
<input type="hidden" id="userName" readonly="true" value="<?=$userName?>"/>
<audio id="pegSnd" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/WhatsApp_Audio.mpeg"></audio>

<audio id="audio" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/fireworks.mp3"></audio>
<?php include 'includes/footer.php'; ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/utils/Draggable.min.js'></script>
<script src='<?=base_url()?>/assets/js/crezyMatkaSpeen/ThrowPropsPlugin.min.js'></script>
<script src='<?=base_url()?>/assets/js/crezyMatkaSpeen/ChillSpinTheWheel.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
<script src="<?=base_url()?>/assets/js/crezyMatkaSpeen/index.js"></script>
<script src="<?=base_url()?>/assets/js/canvasWheel.js"></script>
<script src="<?=base_url()?>/assets/js/canvasWheelRedAndBlack.js"></script>
<script src="<?=base_url()?>/assets/js/canvasWheelCrazyMatka.js"></script>
<script>
    $("#autoLast, .cross, .dv-card").click(function(){
        if(!jQuery.isEmptyObject(lastCrezyBet)){
            const totalCoin = lastCrezyBet.reduce((sum, item) => sum + item.coin, 0);
            $("#_betPerRound").text(totalCoin);
            $("#_10round").text(totalCoin*10);
            $("#_15round").text(totalCoin*15);
            $("#_25round").text(totalCoin*25);
            $(".vd-cont").toggle();
        }else{
            error('please play bet first');
        }
    });
    $(window).on('load', function () {
        $('#loader').hide();
    });
// alert("Click on the black button");
    let toggleBtn = document.getElementById("toggle-btn");
    let menuItems = document.querySelectorAll(".menu a");
    let menuActive = false;
    let resultSector;
    let resultSector1;
    let resultSector2;
    toggleBtn.addEventListener("click", () => {
        if (!menuActive) {
            menuItems[0].style.transform = "translate(-67px, 7px)";
            menuItems[1].style.transform = "translate(-61px, -25px)";
            menuItems[2].style.transform = "translate(-38px, -49px)";
            menuItems[3].style.transform = "translate(-7px, -57px)";
             menuItems[4].style.transform = "translate(25px, -51px)";
             menuItems[5].style.transform = "translate(47px, -26px)";
            menuItems[6].style.transform = "translate(54px, 7px)";
            menuActive = true;
            //toggleBtn.classList.add("active");
        } else {
            menuItems.forEach((menuItem) => {
                menuItem.style.transform = "translate(0,0)";
            });
            menuActive = false;
            //toggleBtn.classList.remove("active");
        }
    });
    let toggleClose = document.getElementsByClassName("place-input-main");
    toggleClose.addEventListener("click", () => {
        menuItems.forEach((menuItem) => {
            menuItem.style.transform = "translate(0,0)";
        });
        menuActive = false;
    });
</script>
<script>
    var coinSlelcted = '';
    let imgFlipCoinBackground = new Image();
    imgFlipCoinBackground.src = 'https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/red-balck-bg.avif';
    $( document ).ready(function() {
        var audioBackground = $('#audioBackground')[0]; // Get the audio element
        audioBackground.muted = true;
        // audioBackground.play();
        
        audioBackground.play().catch(function(e){
            console.log("Autoplay blocked:", e);
        });

        // On first click/tap, unmute
        $(document).one('click', function () {
            console.log('click on page')
            audioBackground.muted = false;
            audioBackground.play(); // retrigger play in case autoplay was blocked
        });

        $("#toggle-btn").click();
        setCoinCrezyMatka(50); // to set bet coin
        // const button = document.querySelector(".centerCircle1 circle");
        // button.setAttribute("r", "60");
        $('#spinthewheel').show();
        setSpinthewheel(1)
        $('#crezyWheelWin').hide()
        $('#crezyWheel2').hide()
        setTime();

        // Function to update the status text
        function updateStatus() {
            if (document.hidden) {
                $('#visibilitychange').val('0');
            } else {
                if($('#visibilitychange').val()=='0'){
                    // window.location.reload(true);
                    // location.href = location.pathname;
                    // location.href = window.location;
                }
            }
        }
        // Check the visibility state when the page loads
        updateStatus();
        // Add an event listener for visibility change
        // $(document).on("visibilitychange", function() {
        //     updateStatus();
        // });
    });
    function setTime(){
        // if("<?=$res[5]['akda']?>"=="10" || "<?=$res[5]['akda']?>"=="11"){
        //     var t = 25;
        // }else{
        //     var t = 35;
        // }
        console.log(20-<?=abs(strtotime(date('Y-m-d H:i:s'))-strtotime($rId['updated']))?>)
        $('#timeInput').val(20-<?=abs(strtotime(date('Y-m-d H:i:s'))-strtotime($rId['updated']))?>);
        $('#startButton')[0].click();
    }

    socket.on('zatkamatka', function (d) {
        console.log(d)
        roundStartCrazyWheel=0;
        startCrazyMatka=1;
        var res = d.data;
        if (res.market=='speenZatkamatka') {
            console.log('inside speen')
            stopSound();
            $('.countdown-container').hide();
            $('.valueContainer image').remove();
            $('.valueContainer g').remove();
            console.log(res)
            $('#rId').val(res.round_id);
            $('#crezyWheelWin').hide();
            $('#crezyWheel').show();
            var win = 0;
            var winAmount = 0;
            if(typeof(result) != "undefined" && result !== null){
                $(result).each(function(t) {
                    if((result[t].akda == res.res)){
                        win = 1;
                        var calWin = result[t].coin*parseFloat($('#r').text());
                        var winCom = (parseFloat($('#clientCommission').text()) / 100) * calWin;
                        winAmount = calWin - winCom;
                    }
                });
            }
            
            $(".mainOuter").css("transform", "translate(0, 15%) scale(1.3)");
            setTimeout(function(){$(".transac").css("transform", "translate(0, -12%) scale(0.75)");})
            resultSector = (res.akda-1);
            $('#startWheel').click();
            // spinthewheel(res.akda)
            setTimeout(function(){
                if(res.akda!=11 && res.akda!=22 && res.akda!=33 && res.akda!=44){
                    var c1 = '<img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/c'+res.res+'.gif">';
                    $("#centerCoin").empty().append(c1).show().delay(4000).hide(0);
                }
                $('.inner-scrolling').find('div').first().fadeOut('slow', function() {
                    $(this).remove();
                });
                var ap = $('<div class="inner scrollitem"><img src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/' + res.res + '.avif"></div>');
                $(".inner-scrolling").last().append(ap.hide().fadeIn('slow'));
                setTimeout(function(){
                    $(".mainOuter").css("transform", "none");
                    $(".transac").css("transform", "none");
                },1000); 
                
            },10000); 

            if(res.akda==22 || res.akda==44){
                $('.valueContainer1 image').remove()
                $('.valueContainer1 g').remove()
                setTimeout(function(){
                    // setTimeout(function(){
                    //     crezyMatka();
                    // },1000);
                    // $(".mkAni1").show();
                    $(".mkAni1").fadeIn(1000);
                    setTimeout(function(){
                        // crezyMatka();
                        // $(".mkAni").toggleClass("zoom-in");
                        // $(".mkAni1").hide();
                        setSpinthecrezywheel(0);
                        $('#crezyWheel').hide()
                        $('#crezyWheelWin').show()
                        $("#speenAction").hide();
                        $("#speenCrezyMatka").show();
                        $(".mkAni1").fadeOut(1000);
                    },2000);
                    // success('congratulations you won crezy matka speen again to get winning price');
                },12000);
                
            }else if(res.akda==11 || res.akda==33){
                setTimeout(function(){
                    // $(".mkAni").show();
                    $(".mkAni").fadeIn(1000);
                    // $(".mkAni").toggleClass("zoom-in");
                    setSpintheFlipCoinwheel(0);
                    
                    $('.wheelSVG2').each(function () {
                        this.style.setProperty('top', '50%', 'important');
                        this.style.setProperty('left', '50%', 'important');
                        this.style.setProperty('transform', 'translate(-50%, 18%) matrix(1, 0, 0, 1, 0, 0)', 'important');
                    });
                    
                    setTimeout(function(){
                        // crezyMatka();
                        // $(".mkAni").toggleClass("zoom-in");
                        // $(".mkAni").hide();
                        $(".mkAni").fadeOut(1000);
                        $('.mainOuter').css('background-image', 'url(' + imgFlipCoinBackground.src + ')');
                        $('#crezyWheel').hide();
                        $("#speenAction").hide();
                        $('#crezyWheel2').show();
                        $("#cIn").show();
                    },2000);
                    // success('congratulations. Flip the coin to get winning price');
                    
                },12000);
            }else{
                setTimeout(function(){
                    var targetScrollTop = $(document).height() * 0.2;
                    // $('html, body').animate({ scrollTop: targetScrollTop }, 'smooth');
                    // $('.innerMain').fadeIn(3000)
                    if(win==1 && arr1.length > 0){
                        console.log('==============>',arr1)
                        var amt = parseFloat(winAmount);
                        console.log(amt)
                        var bal = parseFloat($('#bal').text())+amt;
                        console.log(bal)
                        $('#bal').text(bal.toFixed(2));
                        $('#popUpWin').text(winAmount);
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){
                            $('.videoDv').css({'filter':'blur(0px)'});
                            playSound();
                        },10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        if (!document.hidden) {
                            $('#audio')[0].play();
                        }
                    }else{
                        playSound();
                    }
                    
                    // $('.countdown-container').delay(10000).show();
                    // $('#timeInput').val(20);
                    // $('#startButton')[0].click();
                    startCrazyMatka=0;
                    resetAllCrezyMatka();
                },12000);
                
                result = undefined;
            } 
        }else{
            error(res.message);
        }
    });

    socket.on('crezyMatka', function (d) {
        $(".mainOuter").css("transform", "translate(0, 15%) scale(1.3)");
        setTimeout(function(){$(".transac").css("transform", "translate(0, -12%) scale(0.75)");})
        var res = d.data;
        console.log(res)
        resultSector1 = (res.akda);
        console.log(resultSector1)
        $('#startWheel1').click();
        // spinthecrezywheel(res.akda);
        setTimeout(function(){
            // $(".innerMain.bootOuter").animate({ top: "47%" }, 500);
            resetAllCrezyMatka();
            $('#crezyWheel').show();
            $('#crezyWheelWin').hide();
            $("#speenCrezyMatka").hide();
            $("#speenAction").show();
            
            // $('.innerMain').fadeIn(3000);
            if (typeof result !== 'undefined' && result !== null){
                $(result).each(function(t) {
                    if((result[t].akda == 11)){
                        // var amt = parseInt(result[t].coin)*parseInt(res.into);

                        var calWin = parseFloat(result[t].coin)*parseFloat(res.into);
                        var winCom = (parseFloat($('#clientCommission').text()) / 100) * calWin;
                        amt = calWin - winCom;
                        console.log('inside crazy wheel win')

                        var bal = parseFloat($('#bal').text())+amt;
                        $('#bal').text(bal.toFixed(2));
                        $('#popUpWin').text(amt);
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){
                            $('.videoDv').css({'filter':'blur(0px)'});
                            playSound();
                        },10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        if (!document.hidden) {
                            $('#audio')[0].play();
                        }
                    }
                });
            }else{
                playSound();
            }
            
            // $('.countdown-container').delay(3000).show();
            // $('#timeInput').val(10);
            // $('#startButton')[0].click();
            startCrazyMatka=0;
            resetAllCrezyMatka();
            result = undefined;
            $(".mainOuter").css("transform", "none");
            $(".transac").css("transform", "none");
        },12000);
    });


    socket.on('crezyFlipCoinMatka', function (d) {
        $(".mainOuter").css("transform", "translate(0, 15%) scale(1.3)");
        setTimeout(function(){$(".transac").css("transform", "translate(0, -12%) scale(0.75)");})
        var res = d.data;
        console.log(res)
        $('#crezyWheel').hide();
        $("#speenAction").hide();
        $('#crezyWheel2').show();
        if(res.wheelAkda){
            var nAkR = res.wheelAkda;
        }else{
            var nAkR = res.random;
        }
        resultSector2 = (nAkR-1);
        $('#startWheel2').click();
        // spintheFlipCoinwheel(nAkR)
        $(".btn-red1").text(`${res.red}X`);
        $(".btn-black1").text(`${res.black}X`);
        setTimeout(function(){
            $('#crezyWheel').show();
            $('#crezyWheelWin').hide();
            $("#speenCrezyMatka").hide();
            $("#speenAction").show();
            $('#crezyWheel2').hide();
            
            if (typeof result !== 'undefined' && result !== null){
                $(result).each(function(t) {
                    if((result[t].akda == 10)){
                        // var amt = parseInt(result[t].coin)*parseInt(res.rate);
                        var calWin = parseFloat(result[t].coin)*parseFloat(res.rate);
                        var winCom = (parseFloat($('#clientCommission').text()) / 100) * calWin;
                        amt = calWin - winCom;
                        console.log('inside red and black win')

                        var bal = parseFloat($('#bal').text())+amt;
                        $('#bal').text(bal.toFixed(2));
                        $('#popUpWin').text(amt+' || '+res.rate+'X');
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){
                            $('.videoDv').css({'filter':'blur(0px)'});
                            playSound();
                        },10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        if (!document.hidden) {
                            $('#audio')[0].play();
                        }
                    }
                });
            }else{
                playSound();
            }
            // $('.countdown-container').delay(3000).show();
            // $('#timeInput').val(10);
            // $('#startButton')[0].click();
            startCrazyMatka=0;
            resetAllCrezyMatka();
            result = undefined;
            $('.mainOuter').css('background-image','url(https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/wheelBackground3.webp)');
            $(".mainOuter").css("transform", "none");
            $(".transac").css("transform", "none");
        },12000);
    });

    socket.on('startTimer', function (d) {
        console.log('start timer')
        $('.countdown-container').show();
        $('#timeInput').val(20);
        $('#startButton')[0].click();
        roundStartCrazyWheel=1;
        resetAllCrezyMatka();
    });
    socket.on('winnerListCrezyMatka', function (d) {
        // setTimeout(function(){
        //     $('.winnerList').show();
        //     for (let i=0; i<d.data.length; i++) {
        //         var li = '<li>'+d.data[i].customerName+' win '+d.data[i].winning_point+'</li>';
        //         append(i,li); 
        //         var hi = $('ul').prop("scrollHeight")+10;
        //         $("ul").animate({ scrollTop: hi}, 1000);
        //     }
        // },5000);
        // $('.winnerList').hide();
    });

    function append(i,li) { 
        setTimeout(function() {
            $('#winnerList .stack').append(li);
        }, 1000 * i); 
    } 

    socket.on('disconnect', function(reason) {
        if (confirm('Disconnected from server. Refresh the page') == true) {
            location.reload();
        } else {
            console.log("You canceled!");
        }
    });

    // socket.on('connect_timeout', () => {
    //     if (confirm('Disconnected from server. Refresh the page') == true) {
    //         location.reload();
    //     } else {
    //         console.log("You canceled!");
    //     }
    // });

        window.addEventListener("resize", resizeCanvas, false);
        window.addEventListener("DOMContentLoaded", onLoad, false);
        window.requestAnimationFrame = 
            window.requestAnimationFrame       || 
            window.webkitRequestAnimationFrame || 
            window.mozRequestAnimationFrame    || 
            window.oRequestAnimationFrame      || 
            window.msRequestAnimationFrame     || 
            function (callback) {
                window.setTimeout(callback, 1000/60);
            };
        var canvas, ctx, w, h, particles = [], probability = 0.04,
            xPoint, yPoint;
        function onLoad() {
            canvas = document.getElementById("canvas");
            ctx = canvas.getContext("2d");
            resizeCanvas();
            
            window.requestAnimationFrame(updateWorld);
        } 
        function resizeCanvas() {
            if (!!canvas) {
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
            }
        } 
        function updateWorld() {
            update();
            paint();
            window.requestAnimationFrame(updateWorld);
        } 
        function update() {
            if (particles.length < 500 && Math.random() < probability) {
                createFirework();
            }
            var alive = [];
            for (var i=0; i<particles.length; i++) {
                if (particles[i].move()) {
                    alive.push(particles[i]);
                }
            }
            particles = alive;
        } 
        function paint() {
            ctx.clearRect(0, 0, w, h); 
            ctx.globalCompositeOperation = 'lighter';
            for (var i = 0; i < particles.length; i++) {
                particles[i].draw(ctx);
            }
        } 
        function createFirework() {
            xPoint = Math.random()*(w-200)+100;
            yPoint = Math.random()*(h-200)+100;
            var nFire = Math.random()*50+100;
            var c = "rgb("+(~~(Math.random()*200+55))+","
                 +(~~(Math.random()*200+55))+","+(~~(Math.random()*200+55))+")";
            for (var i=0; i<nFire; i++) {
                var particle = new Particle();
                particle.color = c;
                var vy = Math.sqrt(25-particle.vx*particle.vx);
                if (Math.abs(particle.vy) > vy) {
                    particle.vy = particle.vy>0 ? vy: -vy;
                }
                particles.push(particle);
            }
        } 
        
        function Particle() {
            this.w = this.h = Math.random()*4+1;
            
            this.x = xPoint-this.w/2;
            this.y = yPoint-this.h/2;
            
            this.vx = (Math.random()-0.5)*10;
            this.vy = (Math.random()-0.5)*10;
            
            this.alpha = Math.random()*.5+.5;
            
            this.color;
        } 
        
        Particle.prototype = {
            gravity: 0.05,
            move: function () {
                this.x += this.vx;
                this.vy += this.gravity;
                this.y += this.vy;
                this.alpha -= 0.01;
                if (this.x <= -this.w || this.x >= screen.width ||
                    this.y >= screen.height ||
                    this.alpha <= 0) {
                        return false;
                }
                return true;
            },
            draw: function (c) {
                c.save();
                c.beginPath();
                
                c.translate(this.x+this.w/2, this.y+this.h/2);
                c.arc(0, 0, this.w, 0, Math.PI*2);
                c.fillStyle = this.color;
                c.globalAlpha = this.alpha;
                
                c.closePath();
                c.fill();
                c.restore();
            }
        } 


       
        socket.on('flipTheCoin', function (d) {
            var res = d.data;
            let spades = 0;
            let diamonds = 0;
            let coin = document.querySelector(".coin");
            let i = res.akda;
            coin.style.animation = "none";
            $("#spades-count").text(`Head: ${res.head}`);
            $("#diamonds-count").text(`Tail: ${res.tail}`);
            if(i==1){
                setTimeout(function(){
                    coin.style.animation = "spin-spades 8s forwards";
                }, 100);
                spades++;
            }
            else{
                setTimeout(function(){
                    coin.style.animation = "spin-diamonds 8s forwards";
                }, 100);
                diamonds++;
            }
            setTimeout(function(){
                resetAllCrezyMatka();
                $('#crezyWheel').show();
                $('#flipTheCoin1').hide();
                $("#flipTheCoinBtn").hide();
                $("#speenAction").show();
                if (typeof result !== 'undefined' && result !== null){
                    $(result).each(function(t) {
                        if((result[t].akda == 10)){
                            if(coinSlelcted=="head"){
                                var amt = parseInt(result[t].coin)*parseInt(res.head);
                            }else{
                                var amt = parseInt(result[t].coin)*parseInt(res.tail);
                            }
                            var bal = parseFloat($('#bal').text())+amt;
                            $('#bal').text(bal.toFixed(2));
                            $('#popUpWin').text(amt);
                            $('.videoDv').css({'filter':'blur(4px)'});
                            setTimeout(function(){$('.videoDv').css({'filter':'blur(0px)'})},10000);
                            $('.my-popup-outer').show(0).delay(10000).hide(0);
                            $('#canvas').show(0).delay(10000).hide(0);
                            if (!document.hidden) {
                                $('#audio')[0].play();
                            }
                        }
                    });
                }
                startCrazyMatka=0;
                // $('#timeInput').val(34);
                // $('#startButton')[0].click();
                result= undefined;
            },10000);
        });
        
        $('#headV,#tailV').click(function (){
            coinSlelcted = $(this).attr('flip');
            $("#cIn").hide();
        })

        socket.on('getBets', function (d) {
            // $(".innerMain.bootOuter").css({"top":"47%"});
            // $(".innerMain.bootOuter").animate({ top: "47%" }, 500);
            var res = d.data;
            if(arr1!=''){
                var bet = placeBetCrezyMatkaAll();
                console.log(bet)
            }
        });
        socket.on('startRound', function (d) {
            var res = d.data;
        });


        $(".circl-md").click(function() {
            // if ($(this).hasClass('unlocked')) {
            //     $("#main-char").animate( {
            //         top: $("#SinglePatti03Akda-wrapper").offset().top -27
            //         // top: $(this).offset().top -27
            //     }, 1000, function() {});
            // }else {
            //     console.log("Sorry, broken");
            // }
                $("#main-char").animate( {
                    top: $("#SinglePatti03Akda-wrapper").offset().top -27
                    // top: $(this).offset().top -27
                }, 1000, function() {});
        });


        // voice to text script start
        function startConverting () {
            if('webkitSpeechRecognition' in window) {
                var speechRecognizer = new webkitSpeechRecognition();
                speechRecognizer.continuous = true;
                speechRecognizer.interimResults = false;  // Only get the final result
                speechRecognizer.lang = 'en-US';
                speechRecognizer.start();
                var finalTranscripts = '';
                speechRecognizer.onresult = function(event) {
                    var interimTranscripts = '';
                    for(var i = event.resultIndex; i < event.results.length; i++){
                        var transcript = event.results[i][0].transcript;
                        transcript.replace("\n", "<br>");
                        if(event.results[i].isFinal) {
                            finalTranscripts += transcript;
                        }else{
                            interimTranscripts += transcript;
                        }
                    }
                    // result.innerHTML = finalTranscripts + '<span style="color: #999">' + interimTranscripts + '</span>';
                    var t = finalTranscripts;
                    // var d = t.split('on');
                    if(t){
                        // var d = t.split('-');
                        var r = t.toLowerCase().match(/(crazy)|(crezy)|(matka)/);
                        var c = t.toLowerCase().match(/(coin)|(flip)|(toss)/);
                        if(r){
                            var m1 = t.replace ( /[^\d.]/g, '' );
                            $('#toggle-btn').click()
                            setCoinCrezyMatkaVoiceCommand(m1);
                            queueAddCoin(10,'/SinglePatti/');
                        }else if(c){
                            var m1 = t.replace ( /[^\d.]/g, '' );
                            $('#toggle-btn').click()
                            setCoinCrezyMatkaVoiceCommand(m1);
                            queueAddCoin(11,'/SinglePatti/');
                        }else{
                            var d = t.split('on');
                            if(d[0]&&d[1]){
                                var m1 = d[0].replace ( /[^\d.]/g, '' );
                                var m2 = d[1].replace ( /[^\d.]/g, '' );
                            }else{
                                var d = t.split('pe');
                                var m2 = d[0].replace ( /[^\d.]/g, '' );
                                var m1 = d[1].replace ( /[^\d.]/g, '' );
                            }
                            if(d[0]&&d[1]){
                                if(m1>9){
                                    $('#toggle-btn').click()
                                    setCoinCrezyMatkaVoiceCommand(m1);
                                    queueAddCoin(m2,'/SinglePatti/');
                                }else{
                                    $('#toggle-btn').click()
                                    setCoinCrezyMatkaVoiceCommand(m2);
                                    queueAddCoin(m1,'/SinglePatti/');
                                }
                            }else{
                                alert('am not understanding what you say')
                            }
                        }
                    }
                };
                speechRecognizer.onerror = function (event) {

                };
            }else {
                // result.innerHTML = 'Your browser is not supported. Please download Google chrome or Update your Google chrome!!';
                console.log('Your browser is not supported. Please download Google chrome or Update your Google chrome!!');
            }	
        }
        // voice to text script end
    var soundStatus = 1;
    function sound(){
        $('#audioBackground').each(function () {
            if(!this.paused){
                $( ".fa-volume-up" ).replaceWith('<i class="fa-solid fa-volume-mute"></i>');
                soundStatus = 0;
            }else{
                $( ".fa-volume-mute" ).replaceWith('<i class="fa-solid fa-volume-up"></i>');
                soundStatus = 1;
            }
            this[this.paused ? 'play' : 'pause']();
        });
    }
    function playSound(){
        if (!document.hidden) {
            if(soundStatus==1){
                $('#audioBackground').each(function () {
                    this.play();
                }); 
                $('#pegSnd').each(function () {
                    this.pause();
                });
            }
        }
    }
    function stopSound(){
        if (!document.hidden) {
            $('#audioBackground').each(function () {
                this.pause();
            });
            $('#pegSnd').each(function () {
                this.play();
            });
        }
    }


    document.addEventListener("visibilitychange", function() {
        let audio = document.querySelector("audio");
        if (document.hidden) {
            if(audio) audio.pause();
            $('#pegSnd').each(function () {
                this.pause();
            });
        } else {
            if(startCrazyMatka==0){
                if(audio) audio.play(); // optional
            }else{
                $('#pegSnd').each(function () {
                    this.play();
                });
            }
        }
    });

    // window.addEventListener("blur", function() {
    //     if(audio) audio.pause();
    //     $('#pegSnd').each(function () {
    //         this.pause();
    //     });
    // });

    // window.addEventListener("focus", function() {
    //     if(startCrazyMatka==0){
    //         if(audio) audio.play(); // optional
    //     }else{
    //         $('#pegSnd').each(function () {
    //             this.play();
    //         });
    //     }
    // });
</script>

<script src="<?=base_url()?>/assets/js/timer.js"></script>