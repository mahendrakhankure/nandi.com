<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFRAME PROJECT | <?=$marketDetail['bazar_name']?> </title>
   
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.min.css"  />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/bootstrap/bootstrap.min.css"> 
    <link href="<?php echo base_url(); ?>assets/newDesign/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/buffer.css">

    <style type="text/css">
        body{
            background-color:#1d1d27;
        }
        select{text-transform: uppercase;}
        @media only screen and (max-width: 600px)  {
            /*.tabs table {
                width: 90vw !important;
            }*/
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
            /*.container {
                padding-right: 0rem;
                padding-left: 0rem;
                margin-right: 0rem;
                margin-left: 0rem;
            }*/
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


            .result-outer-wrapper h2 {
                font-size:15px;
                text-align:center;
                text-transform: uppercase;
            }
            .result-inner-wrapper   {
                display:flex;
                justify-content:center;
                margin-bottom: 0.8rem;
            }
            .result-inner-wrapper .result-item  {
                border-right: 2px solid #fbb700;
                padding: 0px 10px;
            }
            .result-inner-wrapper .result-item:last-child {
                border-right: none !important;
            }
            .result-inner-wrapper .result-item h4 {
                font-size: 13px;
            }
            .result-inner-wrapper .result-item h3 {
                font-size: 15px;
                color: #fbb700;
                margin-top:-0.2rem;
                margin-bottom:0rem;
                padding-bottom:0rem;
            }
    </style>
    <style>
        .dialog-ovelay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.50);
            z-index: 999999
        }
        .dialog-ovelay .dialog {
            width: 400px;
            margin: 100px auto 0;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,.2);
            border-radius: 3px;
            overflow: hidden
        }
        .dialog-ovelay .dialog header {
            padding: 10px 8px;
            background-color: #f6f7f9;
            border-bottom: 1px solid #e5e5e5
        }
        .dialog-ovelay .dialog header h3 {
            font-size: 14px;
            margin: 0;
            color: #555;
            display: inline-block
        }
        .dialog-ovelay .dialog header .fa-close {
            float: right;
            color: #c4c5c7;
            cursor: pointer;
            transition: all .5s ease;
            padding: 0 2px;
            border-radius: 1px    
        }
        .dialog-ovelay .dialog header .fa-close:hover {
            color: #b9b9b9
        }
        .dialog-ovelay .dialog header .fa-close:active {
            box-shadow: 0 0 5px #673AB7;
            color: #a2a2a2
        }
        .dialog-ovelay .dialog .dialog-msg {
            padding: 12px 10px
        }
        .dialog-ovelay .dialog .dialog-msg p{
            margin: 0;
            font-size: 15px;
            color: #333
        }
        .dialog-ovelay .dialog footer {
            border-top: 1px solid #e5e5e5;
            padding: 8px 10px
        }
        .dialog-ovelay .dialog footer .controls {
            direction: rtl
        }
        .dialog-ovelay .dialog footer .controls .button {
            padding: 5px 15px;
            border-radius: 3px
        }
        .button {
        cursor: pointer
        }
        .button-default {
            background-color: rgb(248, 248, 248);
            border: 1px solid rgba(204, 204, 204, 0.5);
            color: #5D5D5D;
        }
        .button-danger {
            background-color: #f44336;
            border: 1px solid #d32f2f;
            color: #f5f5f5
        }
        .link {
        padding: 5px 10px;
        cursor: pointer
        }
        .blink {
            animation: blinker 1.5s linear infinite;
            color:#ffffff;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        #betL {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: absolute;
            z-index: 99;
            height: 180px;
            width: 180px;
            margin-left: -90px;
            top: 229px;
            left: 50%;
        }
        #loaderBet {
            border: 12px double #367fa9;
            border-radius: 50%;
            border-top: 12px double #292a2c;
            width: 100px;
            height: 100px;
            animation: spin 1s ease-in-out infinite;
        }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                
                100% {
                    transform: rotate(360deg);
                }
            }

            #message-1 {
            color: #367fa9;
            font-family: auto;
            font-size: 20px;
            margin-top: 30px;
            margin-left: 5px;
            }
    </style>
</head>
<body>
    <!-- Toolbar -->
    <div class="headerTop">
        <?php if($_SESSION['usid']){ ?>
        <div class="walletDV">
            <span class="wal-ico">
                <img src="<?=base_url()?>assets/newDesign/images/Group.png">
            </span>
            <span class="amt">
                <span id="CustomerAmount"><?=round($_SESSION['balance'])?></span>
                INR
            </span>
        </div>
        <a href="<?=base_url()?>signout" class="plceBet">Signout</a>
    <?php }else{ ?>
        <a href="<?=base_url()?>signup" class="plceBet">Signup</a>
    <?php } ?>




        
    </div>
    <div id="alertJ"></div>
    <span id="TokenId" style="display: none;"><?=$_GET['token']?></span>