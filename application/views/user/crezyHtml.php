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
    <link rel="stylesheet" href="/assets/css/crezyMatkaSpeen/crezyStyle.css">
    <link rel="stylesheet" href="/assets/css/crezyMatkaSpeen/crezyStyleFlipCoin.css">
    <link rel="stylesheet" href="/assets/css/crezyMatkaSpeen/style.css"> 
    <link rel="stylesheet" href="/assets/css/timer.css">
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
<img src="<?=base_url()?>assets/images/crezyMatka/back-flip-coin-wheel1.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips01.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips02.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips03.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips04.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips05.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips06.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips07.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips08.png" style="display: none;">
<img src="<?=base_url()?>assets/images/blankchips09.png" style="display: none;">
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
        background-image:url('https://testnandibucket.s3.us-east-2.amazonaws.com/wheelBackground3.webp');
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
    .inner {
        width: 50px !important;
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
</style>

<img src="https://testnandibucket.s3.us-east-2.amazonaws.com/Red-and-White.webp" class="mkAni">
<img src="https://testnandibucket.s3.us-east-2.amazonaws.com/crazy-wheel_lowpixel.webp" class="mkAni1">
<!-- <img src="/assets/images/crezyMatka/wheel.gif" class="mkAni">
<img src="/assets/images/crezyMatka/crazyWheelWin.gif" class="mkAni1"> -->

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
    <img src="https://testnandibucket.s3.us-east-2.amazonaws.com/win.webp" style="position: absolute;width:100%;height:100%;left: 0;object-fit:cover;">
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
    <!-- <img src="/assets/images/crezyMatka/wheel.gif" class="mkAni"> -->
    <div class="videoDv"> 
        <div class="col-12">
            <h3 class="text-center cre" id="spinakda">
            </h3>
        </div>
        <div class="col-md-12" id="spinthewheel">
            <div class="wheelContainer" id="crezyWheel">
                <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" text-rendering="optimizeSpeed">
                    <defs>
                        <!-- Gradient Start -->
                        <radialGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                        </radialGradient>
                        <!-- <radialGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:red;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:yellow;stop-opacity:1" />
                        </radialGradient> -->
                        <radialGradient id="gradientA" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3baedd;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientB" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientC" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientD" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientE" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3baedd;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientF" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientG" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientH" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientI" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3baedd;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientJ" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientCF" x1="100%" y1="0%" r="100%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:red;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:black;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientK" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientL" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientM" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3baedd;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientN" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientO" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientP" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientQ" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3baedd;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientR" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="gradientS" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                        </radialGradient>

                        <radialGradient id="gradientT" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#da217e;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#90144e;stop-opacity:1" />
                        </radialGradient>
                        <!-- Gradient End -->
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
                    </g>
                    <g class="centerCircle" Click />
                    <image class="clogo" xlink:href="/assets/images/crezyMatka/clogo.avif" width="160" height="160" x="430" y="600" />


                    <g class="wheelOutline" />
                    <image class="clogo" xlink:href="https://testnandibucket.s3.us-east-2.amazonaws.com/Wheel-Ring-Light-1.webp" width="1035" height="850" x="0" y="255"></image>
                    <!-- <image class="clogo" xlink:href="/assets/images/crezyMatka/Wheel-Ring-3.png" width="1035" height="850" x="0" y="255"></image> -->
                    <!-- <image class="clogo" xlink:href="/assets/media/outline.png" width="1024" height="900" x="0" y="232"></image> -->
                        <g class="pegContainer">
                            <!-- <image class="peg" xlink:href="/assets/media/peg.png" width="80" height="80" x="0" y="-20" /> -->
                            <image class="peg" xlink:href="/assets/images/crezyMatka/peg.png" width="80" height="80" x="0" y="-20" />
                        </g>
                    <g class="valueContainer" />

                </svg>
            </div>

            <div class="wheelContainer1 crezyWheelContainer" id="crezyWheelWin">
                <svg class="wheelSVG1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" text-rendering="optimizeSpeed">
                    <defs>
                        
                        <radialGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                            </radialGradient>

                            <radialGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient4" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient5" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient6" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient7" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient8" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient9" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient10" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient11" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient12" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient13" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                            </radialGradient>
                            <!-- Gradient Start -->
                        
                            
                            <radialGradient id="gradient14" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient15" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient16" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient17" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#d3bd3b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#8ba525;stop-opacity:1" />
                            </radialGradient>
                        
                            
                            <radialGradient id="gradient18" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient19" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>

                            <radialGradient id="gradient20" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient21" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient22" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient23" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient24" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient25" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                            </radialGradient>
                            
                            <radialGradient id="gradient26" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient27" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient28" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>

                            <radialGradient id="gradient29" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#da217e;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#90144e;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient30" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient31" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient32" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient33" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#eeb83b;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#dd7925;stop-opacity:1" />
                            </radialGradient>
                            
                            
                            <radialGradient id="gradient34" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6e4d76;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#533a58;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient35" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient36" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                            <radialGradient id="gradient37" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#533a58;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2368b0;stop-opacity:1" />
                            </radialGradient>
                        <!-- Gradient Start -->
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
                    <g class="mainContainer1">
                        <g class="wheel1" />
                    </g>
                    <g class="centerCircle1" Click />
                    <image class="clogo1" xlink:href="/assets/images/crezyMatka/clogo.avif" width="160" height="160" x="430" y="600" />


                    <g class="wheelOutline1" />
                        <!-- <image class="clogo1" xlink:href="/assets/images/crezyMatka/Wheel-Ring-3.png" width="1035" height="850" x="0" y="255"></image> -->
                        <image class="clogo1" xlink:href="https://testnandibucket.s3.us-east-2.amazonaws.com/Wheel-Ring-Light-1.webp" width="1035" height="850" x="0" y="255"></image>
                        <!-- 1024 820 0 266 -->
                        <g class="pegContainer1">
                        <image class="peg1" xlink:href="/assets/images/crezyMatka/peg.png" width="80" height="80" x="0" y="-20" />
                        <!-- <image class="peg1" xlink:href="/assets/media/peg.png" width="80" height="80" x="0" y="-20" /> -->
                        </g>
                        <g class="valueContainer1" />

                </svg>
            </div>
            <!-- Coin flip start -->
            <div class="wheelContainer2" id="crezyWheel2">
                <svg class="wheelSVG2 svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" text-rendering="optimizeSpeed">
                    <defs>
                        <!-- Gradient Start -->
                        <radialGradient id="_gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientA" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientB" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientC" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientD" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientE" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientF" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientG" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientH" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientI" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientJ" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                        </radialGradient>
                        <radialGradient id="_gradientK" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#212529;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#212529;stop-opacity:1" />
                        </radialGradient>
                        <!-- Gradient End -->
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
                    <g class="mainContainer2">
                        <g class="wheel2" />
                    </g>
                    <g class="centerCircle2" Click />
                    <image class="clogo2" xlink:href="/assets/images/crezyMatka/clogo.avif" width="160" height="160" x="430" y="600" />


                    <g class="wheelOutline2" />
                    <!-- <image class="clogo2" xlink:href="/assets/images/crezyMatka/Wheel-Ring-Light-1.gif" width="1035" height="850" x="0" y="255"></image> -->
                    <image class="clogo" xlink:href="/assets/images/crezyMatka/wheel-ringn1.png" width="1035" height="850" x="0" y="255"></image>
                    <!-- <image class="clogo" xlink:href="/assets/media/outline.png" width="1024" height="900" x="0" y="232"></image> -->
                        <g class="pegContainer2">
                            <!-- <image class="peg" xlink:href="/assets/media/peg.png" width="80" height="80" x="0" y="-20" /> -->
                            <image class="peg2" xlink:href="/assets/images/crezyMatka/peg.png" width="80" height="80" x="0" y="-20" />
                        </g>
                        <g class="valueContainer2" />

                </svg>
                <div style="display:flex; flex-direction: row;" class='redBlackButton' >
                    <div class='number1'><img src='/assets/images/crezyMatka/red-button-n1.png' class='btn-red'><div class="btn-red1"></div></div>
                    <div class='number2'><img src='/assets/images/crezyMatka/black-button-n1.png' class='btn-black'><div class="btn-black1"></div></div>
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
        <!-- <img src="/assets/images/crezyMatka/c1.png">    -->
    </div>
    
    <div class="innerMain bootOuter">
    <!-- <a href="javascript:void(0)" class="buttonToSpeen" id="speenAction"><img src="/assets/images/crezyMatka/new-spin-2.png" style="width:100%;"></a>
    <a href="javascript:void(0)" class="buttonToSpeen" id="speenCrezyMatka" style="display:none;"><img src="/assets/images/crezyMatka/new-spin-2.png" style="width:100%;"></a>
    <a href="javascript:void(0)" class="buttonToSpeen" id="flipTheCoinBtn" style="display:none;"><img src="/assets/images/crezyMatka/new-spin-2.png" style="width:100%;"></a> -->
        <div class="outer-scrolling bootScroll">
            <div class="inner-scrolling" style="padding-left: 10px; padding-right: 10px;">
                <?php
                    if($res){
                        for($i=count($res); $i>-1; $i--){
                            if(isset($res[$i]['akda'])){
                                echo "<div class='inner scrollitem'>
                                    <img src='/assets/images/crezyMatka/".$res[$i]['akda'].".avif'>
                                </div>";
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <!-- <div class="betInfo cplace place-input-main" onclick="addCoinCrezyMatka(0,'/SinglePatti/')">
            <img class="imag" src="assets/images/crezyMatka/strip.png">
            <div id="SinglePatti00Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div> 
        </div> -->
            <div class="middletop tp">
                <div class="row">
                    <div class="col circl-md col-inner cplace place-input-main" onclick="addCoinCrezyMatka(1,'/SinglePatti/')">
                        <span class="payOut lable-desc-1"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/bsuhijinubaknm6dqksa.avif">
                        <div id="SinglePatti01Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(2,'/SinglePatti/')">
                        <span class="payOut lable-desc-2"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/xabvvmxakk5n0byjdwh4.avif">
                        <div id="SinglePatti02Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(3,'/SinglePatti/')">
                        <span class="payOut lable-desc-3"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/ko1c5oyagdkecxaqaikw.avif">
                        <div id="SinglePatti03Akda-wrapper" class="cplace-box text-center pos-rupi unlocked"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(4,'/SinglePatti/')">
                        <span class="payOut lable-desc-4"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/cm99u3b4pozgz8oek4xu.avif">
                        <div id="SinglePatti04Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(5,'/SinglePatti/')">
                        <span class="payOut lable-desc-5"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/ljmyxjzq0m1r0jhzxv2n.avif">
                        <div id="SinglePatti05Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(6,'/SinglePatti/')">
                        <span class="payOut lable-desc-6"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/zbdwx0y1kvl16irjtasn.avif">
                        <div id="SinglePatti06Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(7,'/SinglePatti/')">
                        <span class="payOut lable-desc-7"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/z90pwathzasxgijrhptw.avif">
                        <div id="SinglePatti07Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(8,'/SinglePatti/')">
                        <span class="payOut lable-desc-8"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/fqon5hfwlkdjuwvan0n1.avif">
                        <div id="SinglePatti08Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner" onclick="addCoinCrezyMatka(9,'/SinglePatti/')">
                        <span class="payOut lable-desc-9"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/u5e1a3gzdnlbp3a8n3oc.avif">
                        <div id="SinglePatti09Akda-wrapper" class="cplace-box text-center pos-rupi"></div>
                    </div>
                    <div class="col circl-md col-inner cplace place-input-main" onclick="addCoinCrezyMatka(0,'/SinglePatti/')">
                        <span class="payOut lable-desc-0"></span>
                        <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/ezad0u28knd3lnypxnai.avif">
                        <div id="SinglePatti00Akda-wrapper" class="cplace-box text-center pos-rupi"></div> 
                    </div>
                </div>
                <div class="clrBoth"></div>
        </div>
        <div class="row">
            <div class="betInfo1 col-md-6" onclick="addCoinCrezyMatka(10,'/SinglePatti/')">
                <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/bonus2.avif">
                <div class="btInput pos">
                    <div id="SinglePatti10Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div>
                </div> 
            </div>
            <div class="betInfo1 col-md-6" onclick="addCoinCrezyMatka(11,'/SinglePatti/')">
                <img class="imag" src="https://testnandibucket.s3.us-east-2.amazonaws.com/red%26black.avif">
                <!-- <img class="imag" src="assets/images/crezyMatka/coinFlip.png"> -->
                <div class="btInput pos">
                    <div id="SinglePatti11Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div>
                </div> 
            </div>
        </div>
        
        <!-- <div class="betInfo" onclick="addCoinCrezyMatka(11,'/SinglePatti/')">
            <img class="imag" src="assets/images/crezyMatka/bonus.png">
            <div class="btInput pos">
                <div id="SinglePatti11Akda-wrapper" class="cplace-box text-center point0 pos-rupi"></div>
            </div> 
        </div> -->
        <div class="clrBoth"></div>
            <a href="javascript:void(0)" class="allbet-l" id="Odd"><img src="/assets/images/crezyMatka/Odd1.png"></a>
            <a href="javascript:void(0)" class="allbet" id="allbet"><img src="/assets/images/crezyMatka/bets-all1.png"></a>
            <a href="javascript:void(0)" class="allbet-r" id="Even"><img src="/assets/images/crezyMatka/Even1.png"></a>
        <div class="clrBoth"></div>
        
        <div class="bottomDv">
            <div class="bottomTop">
            <span href="javascript:void(0)" class="rdv" id="2X"><a href="javascript:void(0)" class="awBtn">
                <i class="fa fa-bars"></i>
                </a></br>2X</span>
            <div class="middlebtm">
                <a href="javascript:void(0)" class="awBtn">
                    <i class="fa fa-undo"></i>
                    <span href="javascript:void(0)" class="ud"  onclick="resetAllCrezyMatka()">UNDO</span>
                </a>
                <span class="amt">
                    <!------/* Circle pop-put  CHips */ ----------->
                    <div class="menu">
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(5)" id="coin5"><img src="/assets/images/chips2.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(10)" id="coin10"><img src="/assets/images/chips3.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(20)" id="coin20"><img src="/assets/images/chips4.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(50)" id="coin50"><img src="/assets/images/chips5.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(100)" id="coin100"><img src="/assets/images/chips6.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(500)" id="coin500"><img src="/assets/images/chips7.png"></a>
                        <a href="javascript:void(0)" onclick="setCoinCrezyMatka(1000)" id="coin1000"><img src="/assets/images/chips8.png"></a>
                        <button id="toggle-btn">
                            <img src="/assets/images/chips5.png" id="main-char">
                        </button>
                    </div>
                    <!------/* ##### Circle pop-put  CHips */ ----------->
                </span>   
                <a href="javascript:void(0)" class="awBtn">
                    <i class="fa fa-refresh"></i>
                    <span href="#" class="rd" id="repeatLast">Repeat</span>
                </a>
            <div class="clrBoth"></div>   
            </div>    
            
            <div class="clrBoth"></div>    
            </div>
            <div class="clrBoth"></div>   
            <div class="bottoml">
                <p><span>Balence</span> <?= $_GET['app']=="BD"?"TAKA":"INR"; ?> <span id="bal"><?= round($bal); ?></span></p> 
            </div>
            <div class="bottomr">
                <p>Total Bet Amount : <span id="totalAmount">0</span></p>
                <span style='display:none;' id='r'><?=$rate['bhav']?></span>
            </div>
            <div class="clrBoth"></div>   
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
<audio id="audioBackground" loop>
<source src="https://testnandibucket.s3.us-east-2.amazonaws.com/Crazy+Time+-+Main+Game+BGM+(FULL)+(1).mp3" type="audio/mp3">
<!-- <source src="https://testnandibucket.s3.us-east-2.amazonaws.com/crazy-time-bg-music.mp3" type="audio/mp3"> -->
</audio>
<input type="hidden" name="rId" id="rId" value="<?=$rId['roundId']?>">
<input type="hidden" id="visibilitychange" readonly="true" value="<?=$rId['roundId']?>"/>
<input type="hidden" id="userName" readonly="true" value="<?=$userName?>"/>

<audio id="audio" src="assets/images/crezyMatka/fireworks.mp3"></audio>
<?php include 'includes/footer.php'; ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/utils/Draggable.min.js'></script>
<script src='/assets/js/crezyMatkaSpeen/ThrowPropsPlugin.min.js'></script>
<script src='/assets/js/crezyMatkaSpeen/ChillSpinTheWheel.js'></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/TextPlugin.min.js'></script>
<script src="/assets/js/crezyMatkaSpeen/index.js"></script>
<script>
    $(window).on('load', function () {
        $('#loader').hide();
    });
// alert("Click on the black button");
    let toggleBtn = document.getElementById("toggle-btn");
    let menuItems = document.querySelectorAll(".menu a");
    let menuActive = false;
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
    imgFlipCoinBackground.src = 'assets/images/crezyMatka/red-balck-bg.avif';
    // imgFlipCoinBackground.src = 'assets/images/crezyMatka/back-flip-coin-wheel1.png';
    $( document ).ready(function() {
        var audioBackground = $('#audioBackground')[0]; // Get the audio element
        audioBackground.play();


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
                    location.href = window.location;
                }
            }
        }
        // Check the visibility state when the page loads
        updateStatus();
        // Add an event listener for visibility change
        $(document).on("visibilitychange", function() {
            updateStatus();
        });
    });
    function setTime(){
        if("<?=$res[5]['akda']?>"=="10"){
            var t = 57;
        }else{
            var t = 60;
        }
        console.log(t,<?=strtotime(date('Y-m-d H:i:s'))?>,<?=strtotime($rId['updated'])?>)
        console.log(t-<?=abs(strtotime(date('Y-m-d H:i:s'))-strtotime($rId['updated']))?>)
        $('#timeInput').val(t-<?=abs(strtotime(date('Y-m-d H:i:s'))-strtotime($rId['updated']))?>);
        $('#startButton')[0].click();
    }

    socket.on('zatkamatka', function (d) {
        startCrazyMatka=1;
        var res = d.data;
        if (res.market=='speenZatkamatka') {
            console.log(res)
            $('#rId').val(res.round_id)
            $('#crezyWheelWin').hide()
            $('#crezyWheel').show()
            var win = 0;
            var winAmount = 0;
            if(typeof(result) != "undefined" && result !== null){
                $(result).each(function(t) {
                    if((result[t].akda == res.res)){
                        win = 1;
                        winAmount = result[t].coin*parseInt($('#r').text());
                    }
                });
            }
            spinthewheel(res.akda)
            
            setTimeout(function(){
                if(res.akda!=11 && res.akda!=22){
                    $('.inner-scrolling').find('div').first().fadeOut('slow', function() {
                        $(this).remove();
                    });
                    // var ap = '<div class="inner scrollitem"><img src="/assets/images/crezyMatka/'+res.res+'.avif"></div>';
                    var ap = $('<div class="inner scrollitem"><img src="/assets/images/crezyMatka/' + res.res + '.avif"></div>');
                    $(".inner-scrolling").last().append(ap.hide().fadeIn('slow'));
                    var c1 = '<img src="/assets/images/crezyMatka/c'+res.res+'.gif">';
                    $("#centerCoin").empty().append(c1).show().delay(10000).hide(0);
                    setTimeout(function(){
                        // $(".innerMain.bootOuter").css({"top":"47%"});
                        // $(".innerMain.bootOuter").animate({ top: "47%" }, 500);
                    },1000); 
                }
            },10000);    
            if(res.akda==22){
                $('.valueContainer1 image').remove()
                $('.valueContainer1 g').remove()
                setTimeout(function(){
                    setTimeout(function(){
                        crezyMatka();
                    },1000);
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
                    },4000);


                    console.log('after creazy matka')
                    // success('congratulations you won crezy matka speen again to get winning price');
                },11500);
                
            }else if(res.akda==11){
                setTimeout(function(){
                    // $(".mkAni").show();
                    $(".mkAni").fadeIn(1000);
                    // $(".mkAni").toggleClass("zoom-in");
                    console.log('am inside of flip coin')
                    setSpintheFlipCoinwheel(0);
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
                    },4000);
                    // success('congratulations. Flip the coin to get winning price');
                    
                },11500);
            }else{
                setTimeout(function(){
                    var targetScrollTop = $(document).height() * 0.2;
                    // $('html, body').animate({ scrollTop: targetScrollTop }, 'smooth');
                    // $('.innerMain').fadeIn(3000)
                    if(win==1){
                        var amt = parseInt(winAmount);
                        var bal = parseInt($('#bal').text())+amt;
                        $('#bal').text(bal);
                        $('#popUpWin').text(winAmount);
                        // console.log('im inside of win')
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){$('.videoDv').css({'filter':'blur(0px)'})},10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        $('#audio')[0].play();
                    }
                    
                    $('#timeInput').val(50);
                    $('#startButton')[0].click();
                    startCrazyMatka=0;
                    resetAllCrezyMatka();
                },10000);
                
                result = undefined;
            }

           
        }else{
            error(res.message);
        }
    });

    socket.on('crezyMatka', function (d) {
        var res = d.data;
        spinthecrezywheel(res.akda);
        console.log(res);
        setTimeout(function(){
            // $(".innerMain.bootOuter").animate({ top: "47%" }, 500);
            console.log('its working')
            resetAllCrezyMatka();
            $('#crezyWheel').show();
            $('#crezyWheelWin').hide();
            $("#speenCrezyMatka").hide();
            $("#speenAction").show();
            
            // $('.innerMain').fadeIn(3000);
            if (typeof result !== 'undefined' && result !== null){
                $(result).each(function(t) {
                    if((result[t].akda == 10)){
                        var amt = parseInt(result[t].coin)*parseInt(res.into);
                        var bal = parseInt($('#bal').text())+amt;
                        $('#bal').text(bal);
                        $('#popUpWin').text(amt);
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){$('.videoDv').css({'filter':'blur(0px)'})},10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        $('#audio')[0].play();
                    }
                });
            }
            $('#timeInput').val(31);
            $('#startButton')[0].click();
            startCrazyMatka=0;
            resetAllCrezyMatka();
            result = undefined;
        },13000);
    });


    socket.on('crezyFlipCoinMatka', function (d) {
        var res = d.data;
        $('#crezyWheel').hide();
        $("#speenAction").hide();
        $('#crezyWheel2').show();
        spintheFlipCoinwheel(res.wheelAkda)
        $(".btn-red1").text(`${res.red}X`);
        $(".btn-black1").text(`${res.black}X`);
        setTimeout(function(){
            $('#crezyWheel').show();
            $('#crezyWheelWin').hide();
            $("#speenCrezyMatka").hide();
            $("#speenAction").show();
            $('#crezyWheel2').hide();
            
            if (typeof result !== 'undefined' && result !== null){
                console.log(result)
                $(result).each(function(t) {
                    if((result[t].akda == 11)){
                        var amt = parseInt(result[t].coin)*parseInt(res.rate);
                        var bal = parseInt($('#bal').text())+amt;
                        $('#bal').text(bal);
                        $('#popUpWin').text(amt);
                        $('.videoDv').css({'filter':'blur(4px)'});
                        setTimeout(function(){$('.videoDv').css({'filter':'blur(0px)'})},10000);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                        $('#canvas').show(0).delay(10000).hide(0);
                        $('#audio')[0].play();
                    }
                });
            }
            $('#timeInput').val(34);
            $('#startButton')[0].click();
            startCrazyMatka=0;
            resetAllCrezyMatka();
            result = undefined;
            $('.mainOuter').css('background-image','url(https://testnandibucket.s3.us-east-2.amazonaws.com/wheelBackground3.webp)');
        },12000);
    });

    socket.on('winnerListCrezyMatka', function (d) {
        // setTimeout(function(){
        //     $('.winnerList').show();
        //     for (let i=0; i<d.data.length; i++) {
        //         console.log(d.data[i].customerName)
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
        console.log('Disconnected from server. Reason:', reason);
        if (confirm('Disconnected from server. Refresh the page') == true) {
            // location.reload();
            location.href = location.pathname;
        } else {
            console.log("You canceled!");
        }
    });

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
            console.log(d)
            console.log('working flip coin')
            let spades = 0;
            let diamonds = 0;
            let coin = document.querySelector(".coin");
            let i = res.akda;
            // console.log(i)
            coin.style.animation = "none";
            $("#spades-count").text(`Head: ${res.head}`);
            $("#diamonds-count").text(`Tail: ${res.tail}`);
            if(i==1){
                setTimeout(function(){
                    coin.style.animation = "spin-spades 8s forwards";
                }, 100);
                spades++;
                // console.log('head')
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
                        if((result[t].akda == 11)){
                            if(coinSlelcted=="head"){
                                var amt = parseInt(result[t].coin)*parseInt(res.head);
                            }else{
                                var amt = parseInt(result[t].coin)*parseInt(res.tail);
                            }
                            var bal = parseInt($('#bal').text())+amt;
                            $('#bal').text(bal);
                            $('#popUpWin').text(amt);
                            $('.videoDv').css({'filter':'blur(4px)'});
                            setTimeout(function(){$('.videoDv').css({'filter':'blur(0px)'})},10000);
                            $('.my-popup-outer').show(0).delay(10000).hide(0);
                            $('#canvas').show(0).delay(10000).hide(0);
                            $('#audio')[0].play();
                        }
                    });
                }
                startCrazyMatka=0;
                $('#timeInput').val(34);
                $('#startButton')[0].click();
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
            console.log('round start')
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
                    console.log(t)
                    if(t){
                        // var d = t.split('-');
                        var r = t.toLowerCase().match(/(crazy)|(crezy)|(matka)/);
                        var c = t.toLowerCase().match(/(coin)|(flip)|(toss)/);
                        if(r){
                            var m1 = t.replace ( /[^\d.]/g, '' );
                            console.log(m1)
                            $('#toggle-btn').click()
                            setCoinCrezyMatkaVoiceCommand(m1);
                            addCoinCrezyMatka(10,'/SinglePatti/');
                        }else if(c){
                            var m1 = t.replace ( /[^\d.]/g, '' );
                            console.log(m1)
                            $('#toggle-btn').click()
                            setCoinCrezyMatkaVoiceCommand(m1);
                            addCoinCrezyMatka(11,'/SinglePatti/');
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
                                    addCoinCrezyMatka(m2,'/SinglePatti/');
                                }else{
                                    $('#toggle-btn').click()
                                    setCoinCrezyMatkaVoiceCommand(m2);
                                    addCoinCrezyMatka(m1,'/SinglePatti/');
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
    function sound(){
        $('#audioBackground').each(function () {
            if(!this.paused){
                $( ".fa-volume-up" ).replaceWith('<i class="fa-solid fa-volume-mute"></i>');
            }else{
                $( ".fa-volume-mute" ).replaceWith('<i class="fa-solid fa-volume-up"></i>');
            }
            this[this.paused ? 'play' : 'pause']();
        });
    }
</script>

<script src="/assets/js/timer.js"></script>