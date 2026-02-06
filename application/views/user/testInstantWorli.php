<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFRAME PROJECT | <?=$marketDetail['bazar_name']?> </title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/bootstrap/bootstrap.min.css"> 
    <?php
        if($_SESSION['app']=='OS'){
            echo '<link rel="stylesheet" href="'.base_url().'assets/css/main.css">';
        }else if($_SESSION['app']=='SB'){
            echo '<link rel="stylesheet" href="'.base_url().'assets/css/main.css">';
        }else{
            echo '<link rel="stylesheet" href="'.base_url().'assets/css/main.css">';
        }
    ?>

<style type="text/css">
        select{text-transform: uppercase;}

        @media only screen and (max-width: 600px)  {
            
            .tabs table tbody {
                border-top: none !important;
            }
            .tabs table th, .tabs table td {
                font-size: 8px;
            }
            .tabs table th {
                border: 2px solid #000;
                padding: 5px;
            }
            .tab .table>:not(caption)>*>*   {
                padding: 0.5rem 0rem !important;
            }
            .container {
                padding-right: 0rem;
                padding-left: 0rem;
                margin-right: 0rem;
                margin-left: 0rem;
            }
            .tabs label{
                background-color: #fff;
                display: grid;
                grid-template-rows: 1fr;
                justify-content: center;
                 
            }
            .tabs label span {
                display:block !important;
                font-size :  11px;
            }

        }

         /* Sidebar Styles */
         .topbar-right-warpper {
                grid-template-columns : 1fr 1fr !important;
            }
            .topbar-right-warpper .user-pic  {
                text-align: right;
                font-weight: 600 !important;
                background-color: #222 !important;
                color: #eee !important;
                padding: 8px !important;
                border-radius: 5px !important;
                margin-top: -2px !important;
                font-size:11px !important;
                box-shadow: #8b8000 0px 4px 8px;
                
            }
            #mySidenav  {
                /* border-left : 0.25px solid #ddd !important; */
                background-color : #343c40 !important;
                padding-top: 0px !important;
                width :  240px !important;
                padding-top: 20px !important;
                display: none;
            }
            #mySidenav  li{
                font-size: 13px !important;
                padding-bottom: 8px;
                border-bottom: 1px solid #eee;
                margin-bottom: 12px ; 
                list-style-type : none !important;
                margin-right: 10px;  
                text-transform: capitalize !important;
            }
            #mySidenav li a {
                font-size: 13px !important;
                padding : 0px !important; 
                padding-bottom: 4px !important;
                text-transform: capitalize !important; 
                text-align: left !important;
            }

            #mySidenav li div {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px !important;
            }
            .sddown {
                padding-left: 1rem !important;
                display: none;
            }
            .sddown li {
                border-bottom: none !important;
                padding-bottom: 4px !important;
                text-align: left !important;
                margin-bottom: 0rem !important;
            }
            .sddown li a {
                display: inline-block;
                margin-left: 10px;
            }
            .sddown li i {
                font-size : 11px;
            }
    </style>
    
</head>
<body>
    <!-- Toolbar -->
     
    <div class="container-fluid">
        <div class="rows">
            <div class="col-12 topbar-wrapper darkbg">
                <div class="topbar">
                    <div class="topbar-left-wrapper">
                        <span id="back-btn" class="backbtn-wrapper" onclick="goBack()"><img src="<?=base_url()?>assets/images/backbtn-white.png"></span>
                        <h3><?=$marketDetail['bazar_name']?></h3>
                    </div>
                    <div class="topbar-right-warpper">
                         
                        <span id="endPontUrl" style="display: none;"><?=$_SESSION['end_point_url']?></span> 
                        <!-- <span  id="customerName"><?=$_SESSION['userName']?></span> -->
                        <span class="amount" id="CustomerAmount"><?=round($_SESSION['balance'])?> INR</span>
                        <span id="TokenId" style="display: none;"><?=$_GET['token']?></span>
                        <span class="user-pic" onclick="openNav()" style="cursor:pointer;">Result/History</span> <!--<i class="fa-regular fa-user"></i>-->
                    </div>   
                </div>
            </div>    
        </div>
    </div>
    <div id="alertJ"></div>
    
   
    <div id="mySidenav" class="sidenav text-center" style="top:50px;">
         
        <ul>
            
            <li><a href="<?=base_url()?>f8ae0c9c3c9747d5ebe48e99a257dea7/<?=$_SESSION['partner']['id']?>/<?=$_SESSION['customer_id']?>?token=<?=$_GET['token']?>&&id=<?=$_GET['id']?>&app=<?=$_GET['app']?>">My Bet History</a></li>
            
            <li>
                <a href="<?=base_url()?>d22e6d9a374680c5deecbc33f514e652/<?=$_SESSION['partner']['id']?>/<?=$_SESSION['customer_id']?>?token=<?=$_GET['token']?>&&id=<?=$_GET['id']?>&app=<?=$_GET['app']?>">
                    Instant Worli History
                </a>
            </li>
            <li><a href="<?=base_url()?>d22e6d9a374680c5deecbc33f514e662/warli_result">Last Result</a></li>
        </ul>
    </div>
 

<!-- Modal -->
<div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  onclick="$('#exampleModalCenter').hide();">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="text-align: center;">
        <h5 class="modal-title text-center" style="color: #000;" id="exampleModalLongTitle">
            <?=$marketDetail['bazar_name']?> LAST 7 DAYS RESULT
        </h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

        <style type="text/css">
            .progressbar {
              width: 80%;
              margin: 25px auto;
              border: solid 1px #000;
            }
            .progressbar .inner {
              height: 15px;
              animation: progressbar-countdown;
              /* Placeholder, this will be updated using javascript */
              animation-duration: 40s;
              /* We stop in the end */
              animation-iteration-count: 1;
              /* Stay on pause when the animation is finished finished */
              animation-fill-mode: forwards;
              /* We start paused, we start the animation using javascript */
              animation-play-state: paused;
              /* We want a linear animation, ease-out is standard */
              animation-timing-function: linear;
            }
            @keyframes progressbar-countdown {
              0% {
                width: 100%;
                background: #0F0;
              }
              100% {
                width: 0%;
                background: #F00;
              }
            }
        </style>

        <!-- Red -->
        <!-- <style type="text/css">
             
            body {
              background: #67110d !important;
            }
            body .topbar-wrapper {
              background: #290705 !important;
               
            }
            .app-heading    {
                display: none !important;
            }
            .batt-name  {
                margin-top: -1rem !important;
            }
            .batt-name h3 {
                min-width: 100px !important;
                width: 150px !important;
                background: #290705 !important;
                color: #fff;
                box-shadow: none !important;
                border-width: 3px;
                border-style: solid;
                border-image: linear-gradient(90deg, #ffeb76, #c09a2f) 15 stretch;
            }
            .tabpatti-wrapper   {
                text-align: center;
                background: #290705 !important;
                margin-top: -0.3rem;
                border-top: 5px solid #0fb90f;
            }
            .tabpatti-wrapper ul {
                margin: 0rem;
                padding:8px 0px;
                padding-left:0rem !important;
            }
            .tabpatti-wrapper ul li {
                color: #fff;
                font-size: 13px;
                text-transform: uppercase;
            }
            .tabpatti-wrapper ul li:hover {
                color: gold;
            }
            .cplace-outer   {
                background: #3f0604 !important;
                box-shadow: none !important;
                 
            }
            .cplace-outer .cplace-box {
                background: #290705 !important;
            }
            .cplace-outer span {
                color: #fff !important;
            }
            .undo-wrapper p {
                color: #fff !important;
            }
            .undo-wrapper span {
                background: #290705 !important;
            }
            .total-wrapper h3 {
                color: #fff !important;
            }
            .total-wrapper span {
                background: #290705 !important;
            }
            .bett-action a  {
                background: linear-gradient(90deg, #ffeb76, #c09a2f) !important;
                box-shadow: none !important;
                border:none !important;
                color: #000 !important;
            }
            .timer {
                display: flex;
                justify-content: center;
                flex-direction: row;
                gap:25px;
                margin-bottom: 1rem;
            }
            .timer h3 {
                background: linear-gradient(90deg, #ffeb76, #c09a2f);
                color: #000;
                margin-top: 0.5rem;
                margin-bottom: 0rem;
                border-radius: 5px;
                padding: 8px 0px;
            }
            #streming   {
                position: relative;
            }
            #streming span {
                position: absolute;
                top: 10px;
                right: 10px;
                color: gold;
            }
            #streming span i {
                font-size: 18px;
            }
        </style> -->
        <!-- Golden Yellow -->
        <!-- <style type="text/css">
            body {
              /*background: #b7a471 !important;*/
              background: hsla(43, 38%, 72%, 1.0) !important;
            }
            body .topbar-wrapper {
              background: #6a5a38 !important;
            }
            .app-heading    {
                display: none !important;
            }
            .app-heading h3 {
                background: linear-gradient(180deg, #e4bf53, #c09128);
                -webkit-background-clip: text;
                -webkit-text-fill-color: #6a5a38;
            }
            .batt-name  {
                margin-top: -1rem !important;
            }
            .batt-name h3 {
                min-width: 100px !important;
                width: 150px !important;
                background: #6a5a38 !important;
                color: #fff;
                box-shadow: none !important;
                border-width: 3px;
                border-style: solid;
                border-image: linear-gradient(90deg, #ffeb76, #c09a2f) 15 stretch;
                box-shadow: 0px 2px 4px #000 !important;
            }
            .batt-notes h3 {
                color: #6a5a38 !important;
            }
            .tabpatti-wrapper   {
                text-align: center;
                background: #6d5938 !important;
                margin-top: -0.3rem;
                border-top: 3px solid #0fb90f;
            }
            .tabpatti-wrapper ul {
                margin: 0rem
                padding:0rem;
                padding-left:0rem !important;
            }
            .tabpatti-wrapper ul li {
                color: #fff;
                font-size: 13px;
                text-transform:uppercase;
            }
            .tabpatti-wrapper ul li:hover {

            }
            .chiplist-wrapper h3 {
                color: #6a5a38 !important;
            }
            .cplace-outer   {
                background: #9d8959 !important;
                box-shadow: none !important;
            }
            .cplace-outer .cplace-box {
                background: #6a5a38 !important;
            }
            .cplace-outer span {
                color: #fff !important;
            }
            .undo-wrapper p {
                color: #fff !important;
            }
            .undo-wrapper span {
                background: #6a5a38 !important;
            }
            .total-wrapper h3 {
                color: #fff !important;
            }
            .total-wrapper span {
                background: #6a5a38 !important;
            }
            .bett-action a  {
                background: linear-gradient(90deg, #ffeb76, #c09a2f) !important;
                color: #000;
                box-shadow: none !important;
                border:none !important;
                box-shadow: 0px 2px 4px #000 !important;
            }
            .timer {
                display: flex;
                justify-content: center;
                flex-direction: row;
                gap:25px;
                margin-bottom: 1rem;
            }
            .timer .minutes div {
                border-radius: 5px;
                -webkit-border-radius : 5px;
            }
            .timer h3 {
                background: #6a5a38;
                color: hsla(43, 38%, 72%, 1.0) !important;
                margin-top: 0.5rem;
                margin-bottom: 0rem;
                border-radius: 5px;
                padding: 8px 0px;
                border-width: 3px;
                border-style: solid;
                border-image: linear-gradient(90deg, #ffeb76, #c09a2f) 15 stretch;
                box-shadow: 0px 2px 4px #000 !important;
            }
            .timer span {
                color: #6a5a38 !important;
            }

            #streming   {
                position: relative;
            }
            #streming span {
                position: absolute;
                top: 10px;
                right: 10px;
                color: gold;
            }
            #streming span i {
                font-size: 18px;
            }
        </style> -->
        
        <!-- Blue -->
        <style type="text/css">
        	.srId{
        		display: block;
        		width: 100%;
        		height: 20px;
        		margin-top: -0.8rem;
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
            body {
              background: #0b1833 !important;
            }
            body .topbar-wrapper {
              background: #040e1e !important;
            }
            .app-heading    {
                display: none !important;
            }
            .batt-name  {
                margin-top: -1rem !important;
                margin-bottom: 0.5rem;
                display: none;
            }
            .batt-name h3 {
                min-width: 100px !important;
                width: 150px !important;
                background: #040e1e !important;
                color: #fff;
                box-shadow: none !important;
                border-width: 3px;
                border-style: solid;
                border-image: linear-gradient(90deg, #ffeb76, #c09a2f) 15 stretch;
                 
            }
            .topbar-left-wrapper h3 {
                color: #fff !important;
            }
            .topbar-right-warpper span  {
                color:#fff !important;
            }
            .topbar-right-warpper span i {
                color: #fff !important;
                border: 2px solid #fff !important;
            }
            .tabpatti-wrapper   {
            	position: sticky;
            	top: 0rem;
                text-align: center;
                background: #040e1e !important;
                margin-top: -0.3rem;
                border-top: 3px solid #0fb90f;
            }
            .tabpatti-wrapper ul {
                margin: 0rem
                padding:0rem;
                padding-left:0rem !important;
            }
            .tabpatti-wrapper ul li {
                color: #fff;
                font-size: 9px;
                text-transform: uppercase;
            }
           /* .tabpatti-wrapper ul li:active {
            	color:white;
            	padding-bottom: 5px;
            	border-bottom: 2px solid white;
            }*/
            .tabpatti-wrapper ul li:hover {
            	color:#fff;
            	padding-bottom: 5px;
            	/*background: gold;*/
            	border-bottom: 2px solid gold;
            }
            .chiplist-wrapper h3 {
                /*display: none;*/
                margin-top: -0.5rem !important;
            }
            .cplace-outer   {
                background: #0b1833 !important;
                box-shadow: none !important;
                height: 165px !important;
            }
            .cplace-outer .cplace-box {
                background: #040e1e !important;
            }
            .cplace-outer span {
                color: #fff !important;
            }
            .undo-wrapper p {
                color: #fff !important;
            }
            .undo-wrapper span {
                background: #040e1e !important;
            }
            .total-wrapper h3 {
                color: #fff !important;
            }
            .total-wrapper span {
                background: #040e1e !important;
            }
            .bett-action a  {
                background: linear-gradient(90deg, #ffeb76, #c09a2f) !important;
                box-shadow: none !important;
                border: none !important;
                color: #000;
            }

            .timer {
                /*display: flex;*/
                display: none;
                justify-content: center;
                flex-direction: row;
                gap:25px;
                margin-bottom: 1rem;
            }
            .timer h3 {
                background : linear-gradient(90deg, #ffeb76, #c09a2f);
                color: #000;
                margin-top: 0.5rem;
                margin-bottom: 0rem;
                border-radius: 5px;
                padding: 8px 0px;
            }
            #streming   {
                position: relative;
            }
            
            #streming span {
                position: absolute;
                top: 10px;
                right: 10px;
                color: #040e1e;
                background: white;
                padding: 7px 6px 2px 6px;
                border-radius: 50%
            }

            #streming span i {
                font-size: 18px;
            }
            #allPattiSelect   {
                background:linear-gradient(90deg, #ffeb76, #c09a2f) !important;
                box-shadow:none !important;
            }

            @media screen and(max-width: 600px)	{
            	 #streming iframe {
                height: 52vw !important;
            }
            }
        </style>
        <!-- Result Popup Css Start -->
        <style type="text/css">
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
        </style>
        <!-- Result Popup Css End -->
        <img src="<?=base_url()?>assets/images/blankchips01.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips02.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips03.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips04.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips05.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips06.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips07.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips08.png" style="display: none;">
        <img src="<?=base_url()?>assets/images/blankchips09.png" style="display: none;">
     
     <!--   <style>
            .chat-wrapper   {
                width: 90%;
                height: 100vh;
                z-index: 1000;
                position: absolute;
                top: 0px;
                right: 0px;
            }
            .chatbox {
                position: fixed;
                background: #040e1e !important;
                display: grid;
                grid-template-rows:  50px calc(100vh -120px) 40px;
                margin: 0px;
                width: 100%;
                height: 100vh;

            }
            .chatbox-header {
                 background: #0b1833 !important;
                 padding: 8px 0px;  
                 text-align: center;
                 height: 50px;
                 box-sizing: border-box;
            }
            .chatbox-header h3  {
                margin-bottom: 0rem;
                font-size: 13px !important;
                text-transform: uppercase;
            }
            .chatbox-header p {
                margin-bottom: 0rem;
                font-size: 11px;
            }
            .chatbox-header span {
                color: #fff;
            }
            .chatbox-header span.status i {
                color: lightgreen !important;
                margin-right: 2px;
            }
            .chatbox-header span.close-icon  {
                position: absolute;
                top: 12px;
                left: 12px;

            }
            .chatbox-header span.close-icon i {
                color: lightyellow;
                font-size: 21px;
            }
            .chatbox-body {
                height: calc(100vh -120px);
            }
            .chatbox-body h4 {
                width: 60%;
                margin-left: 15%;
                text-align: center;
                font-size: 13px;
                padding-top: 12px;
                padding-bottom: 8px;
                border-bottom: 2px solid white;
            }

            .chatbox-footer {
                background: #999;
                width: 90%;
                height: 40px;
                margin-left: auto;
                margin-right: auto;
                border-radius: 30px;
                padding: 8px;
                box-sizing: border-box;
            }
            .footer-inner {
                display: grid;
                grid-template-columns: 1fr 4fr 1fr;
            }
            .footer-inner span {

            }
            .footer-inner input {
                /*width: 70%;*/
                border: none;
                outline: none;
                font-size: 13px;
            }
            .footer-inner button {
                background: red;
                padding: 4px 12px;
                border-radius: 30px;
                border: none;
            }
       </style>
 -->
     <!-- Chat page -->
      <!--  <div class="chat-wrapper">
            <div class="chatbox">
                <div class="chatbox-header">
                    <h3>Chat Box</h3>
                    <p><span class="status"><i class="fa-solid fa-circle"></i> Online </span></p>
                    <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
                </div>
                <div class="chatbox-body">
                     <h4>Today</h4>
                     <div class="chatbot-innerbody">
                        
                     </div>
                </div>
                <div class="chatbox-footer">
                    <div class="footer-inner">
                        <span><i class="fa-solid fa-face-laugh"></i></span>
                        <input type="text" id="chatinput" name="chatinput">
                        <button type="button">Send</button>
                    </div>
                </div>


            </div>
       </div> -->
    <!-- Result Popup Start -->
    <div class="col-12 my-popup-outer" id="popUpDiv">
        <div class="my-popup">
            <div class="my-popup-inner">
                <h3><i class="fa-sharp fa-solid fa-star"></i>You Win<i class="fa-sharp fa-solid fa-star"></i></h3>
                <p><i class="fa-solid fa-indian-rupee-sign"></i><span id="popUpWin"></span></p>
            </div>
        </div>    
    </div>
    <!-- Result Popup End -->
     <div class="rows">
        <div class="col-12">
            <div class="batt-name">
                <h3 class="heading-wbd">Single Digit</h3>
            </div>  
        </div>
      <!--   <div class="col-12 batt-notes ele-margin-tb">
            <h3 class="heading">NOTE:- BET AMOUNT SHOULD GREATER OR EQUAL TO 10</h3>
        </div>       -->
    </div>
    <div class="col-md-12 timer">
        <div class="minutes">
            <div><h3>02</h3></div>
            <span>minutes</span>
        </div>
        <div class="seconds">
            <div><h3>00</h3></div>
            <span>seconds</span>
        </div>
    </div>
    <div id="result"></div>
    <div class="col-md-12 promo-video" id="streming">
        <span><i class="fa-solid fa-message"></i></span>
        <iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-1" title="Live Satta Result" id="iFrameWin"></iframe>
       
    </div>
    <!-- <div id='progressbar3'></div> -->
     <div class="tabpatti-wrapper">
         <ul class="tabpatti slider">
            <li onclick="getPattiResponce('SingleDigit','4')" class="btn btn-default slide">Single Digit</li>
            <li onclick="getPattiResponce('SinglePatti','1')" class="btn btn-default slide">Single Patti</li>
            <li onclick="getPattiResponce('DoublePatti','2')" class="btn btn-default slide">Double Patti</li>
            <li onclick="getPattiResponce('TriplePatti','3')" class="btn btn-default slide">Triple Patti</li>
         </ul>
     </div>
      
        <!-- Batting Chips List -->
        <div class="container chiplist-wrapper">
            <div class="rows">
                <div class="col-12">
                    <h3 class="heading  ">Select the chips and Bet</h3>
                    <div class="chiplist" id="chiplistNew">  
                        <ul>
                            <li class="chip coin" id="coin1" onclick="setCoin(1)">
                                <img src="<?=base_url()?>assets/images/chips1.png" alt="">
                            </li>
                            <li class="chip coin" id="coin5" onclick="setCoin(5)">
                                <img src="<?=base_url()?>assets/images/chips2.png" alt="">
                            </li>
                            <li class="chip coin" id="coin10" onclick="setCoin(10)">
                                <img src="<?=base_url()?>assets/images/chips3.png" alt="">
                            </li>
                            <li class="chip coin" id="coin20" onclick="setCoin(20)">
                                <img src="<?=base_url()?>assets/images/chips4.png" alt="">
                            </li> <li class="chip coin" id="coin50" onclick="setCoin(50)">
                                <img src="<?=base_url()?>assets/images/chips5.png" alt="">
                            </li>
                            <li class="chip coin" id="coin100" onclick="setCoin(100)">
                                <img src="<?=base_url()?>assets/images/chips6.png" alt="">
                            </li>
                            <li class="chip coin" id="coin200" onclick="setCoin(200)">
                                <img src="<?=base_url()?>assets/images/chips7.png" alt="">
                            </li>
                            <li class="chip coin" id="coin500" onclick="setCoin(500)">
                                <img src="<?=base_url()?>assets/images/chips8.png" alt="">
                            </li>
                            </li> 
                            <li class="chip coin" id="coin1000" onclick="setCoin(1000)">
                                <img src="<?=base_url()?>assets/images/chips9.png" alt="">
                            </li>
                        </ul>
                            
                    </div>
                </div>   
            </div>
        </div>
        <!-- Betting Boxes to Place chip -->
        <div class="container cplace-container">
            <div class="row">
                <div class="cplace-outer-top">
                    <div id="sAll"></div>
                    <div class="total-box">
                        <h3>Total Amount : <span id="totalAmount">0</span> INR</h3>
                        <h3>Total Bet Amount : <span id="totalBetAmount">0</span> INR</h3>
                    </div>
                </div>
                <div class="col-12 cplace-outer">

                    <div class="cplace-wrapper " id="dome">
                       <!--  <?php
                            for($i=0;$i<10;$i++){
                        ?>
                        <div class="cplace" onclick="addCoinInstantWorli(<?=$i?>,'SingleAkda')">
                            <span><?=$i?></span>
                            <div class="cplace-box" >
                                <div id="SinglePatti<?=$i?>Akda-wrapper" class="text-center"></div>
                            </div>
                        </div>          
                       
                        <?php
                            }
                        ?>  -->
                    </div>          
                </div>
            </div>
        </div>
        
        <span class="iId" id="roundId"></span>
        <span class="iId" id="gameName">SingleDigit</span>
        <span class="iId" id="gameId">4</span>
        <span class="iId" id="timeId"></span>
        <!-- Bet Action Button -->
       <!--  <div class="container foot-content">
            <div class="rows">
            	<div class="total-undo col-12">
                    <div class="undo-wrapper" onclick="undo('SinglePatti')">
                        <span><i class="fa-solid fa-rotate-left"></i></span>
                        <p>Undo</p>
                    </div>
                    <div class="total-wrapper">  
                        <div class="total-box">
                            <h3>Total Amount<span id="totalAmount">0</span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1 bett-action" id="pBet">
                    	 <a href="javascript:void(0)" onclick="placeBetInstantWorli()">PLACE BET</a>
                    	 <a  href="javascript:void(0)" onclick="resetAllInstantWorli()">RESET BET</a>
                </div>
            </div>
        </div> -->

        <!-- Bet Action Button -->
        <div class="container">
            <div class="rows">
                <div class="col-md-8 col-sm-10 offset-md-2 offset-sm-1 bett-action" id="pBet">
                    <a  href="javascript:void(0)" onclick="reBetInstantWorli()">REPEAT BET</a>
                    <div class="undo-wrapper" onclick="undo('SinglePatti')">
                         <span><i class="fa-solid fa-rotate-left"></i></span>
                    </div>
                    <a href="javascript:void(0)" onclick="placeBetInstantWorli()">PLACE BET</a>
                </div>
            </div>
        </div>
        
        <div id="chat-messages"></div>
        <div class="messages"></div>
         
     
       
    <?php 
          include 'includes/footer.php'; 
    ?>

    <script>
    	$(document).ready(function(){
            var arr=['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            var dome = '';
            $(arr).each(function(t) {
                dome += '<div class="cplace" onclick="addCoinInstantWorli('+arr[t]+',/'+"SingleDigit"+'/)"><span>'+arr[t]+'</span><div class="cplace-box"><div id="SinglePatti'+arr[t]+'Akda-wrapper" class="text-center"></div></div></div>';
            });
            var sAll = '<span class="btn" id="allPattiSelect" onclick="checkAll(['+arr+'],/'+"SingleDigit"+'/)">Select All Digit</span>';
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
            var dome = '';
            for (var i = 1; i < arr.length; i++) {
            	if(i==10){
            		dome += '<div class="srId"><span class="btn btn-default" for="srid0" onclick="checkAll(['+arr[10]+'],/'+p+'/)">Select All</span><label for="srid0">0</label><br></div>';
            	}else{
            		dome += '<div class="srId"><span id="srid'+i+'" class="btn btn-default" onclick="checkAll(['+arr[i]+'],/'+p+'/)">Select All</span><label for="srid'+i+'">'+i+'</label><br></div>';
            	}
                $(arr[i]).each(function(t) {
                    dome += '<div class="cplace" onclick="addCoinInstantWorli('+arr[i][t]+',/'+p+'/)"><span>'+arr[i][t]+'</span><div class="cplace-box"><div id="SinglePatti'+arr[i][t]+'Akda-wrapper" class="text-center"></div></div></div>';
                    pattiAll.push(arr[i][t]);
                });
                dome += '<hr>';
            }
            var sAll = '<span class="btn" id="allPattiSelect" onclick="checkAll(['+pattiAll+'],/'+p+'/)">'+sA+'</span>';
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
            $(".cplace-outer").height(cplaceHeight);
        }
        if(parseInt(viewWidth) > 340 && parseInt(viewWidth) <= 460) {
            cplaceHeight = viewHeight-370+60;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) > 460 && parseInt(viewWidth) < 768)   {
            cplaceHeight = viewHeight-394+60;
            $(".cplace-outer").height(cplaceHeight);
        }else if(parseInt(viewWidth) >= 768) {
            cplaceHeight = viewHeight-359+60;
            $(".cplace-outer").height(cplaceHeight);
        }

    });
    

    // console.log(base_url+"99e5e8bcc18ef557c15876675bf8e7e6")
    // if(typeof(EventSource) !== "undefined") {
    //   var source = new EventSource(base_url+"/99e5e8bcc18ef557c15876675bf8e7e6");
    //   source.onmessage = function(event) {
    //     // alert('this')
    //     document.getElementById("result").innerHTML += event.data + "<br>";
    //   };
    // } else {
    //   document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    // }



    </script>
    <!-- <script src="socket.io-client/socket.io.js"></script>  
    <script>
            var socket = io.connect("ws://p1/99e5e8bcc18ef557c15876675bf8e7e6");

            $('.message').on('change', function(){
                socket.emit('send message', $(this).val());
                $(this).val('');
            });

            socket.on('new message', function(data){
                $('#chat-messages').append('<p>' + data +'</p>');
            });
    </script> -->
