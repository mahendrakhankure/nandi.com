<?php 
    include 'includes/header.php';
?>
    <style type="text/css">
        a { color: #ccc; text-decoration: none !important;}a:hover {color: yellow;}
        .p3-game-list{border: 1px solid red; height: 180px; width: 300px; margin: 20px; border-radius: 10px; text-align: center;}
        .boxRegular:nth-child( odd ) {
            background-color: #F44236;
            box-shadow: 5px 5px #ccc;
        }
        .gameName{
            font-size: 25px;
            font-weight: bold;
        }


        .tabs {
            max-width: 100%;
            float: none;
            list-style: none;
            padding: 0;
            /*margin: 75px auto;*/
            /*border-bottom: 4px solid #ccc;*/
        }
        .tabs:after {
            content: '';
            display: table;
            clear: both;
        }
        .tabs input[type=radio] {
            display:none;
        }
        .tabs label {
            display: block;
            float: left;
            width: 18%;
            color: #ccc;
            font-size: 20px;
            font-weight: normal;
            text-decoration: none;
            text-align: center;
            line-height: 2;
            cursor: pointer;
            box-shadow: inset 0 4px #ccc;
            border-bottom: 4px solid #ccc;
            -webkit-transition: all 0.5s; /* Safari 3.1 to 6.0 */
            transition: all 0.5s;
            width: 33.3% !important;
        }
        .tabs label span {
            display: none;
        }
        .tabs label i {
            padding: 5px;
            margin-right: 0;
        }
        .tabs label:hover {
            color: #3498db;
            box-shadow: inset 0 4px #3498db;
            border-bottom: 4px solid #3498db;
            /*width: 33.3%;*/
        }
        .tab-content {
            display: none;
            float: left;
            padding: 15px;
            box-sizing: border-box;
            background-color:#ffffff;
            font-size: 3px;
            width: 100% !important;
        }
        .tab-content * {
            -webkit-animation: scale 0.7s ease-in-out;
            -moz-animation: scale 0.7s ease-in-out;
            animation: scale 0.7s ease-in-out;
        }
        @keyframes scale {
          0% {
            transform: scale(0.9);
            opacity: 0;
            }
          50% {
            transform: scale(1.01);
            opacity: 0.5;
            }
          100% {
            transform: scale(1);
            opacity: 1;
          }
        }
        .tabs [id^="tab"]:checked + label {
            background: #FFF;
            box-shadow: inset 0 4px #3498db;
            /*border-bottom: 4px solid #3498db;*/
            color: #3498db;
        }

        thead th {
            font-size: 15px;
        }
        tbody th {
            font-size: 13px;
        }
        tbody td {
            font-size: 11px;
        }

        #tab1:checked ~ #tab-content1,
        #tab2:checked ~ #tab-content2,
        #tab3:checked ~ #tab-content3{
            display: block;
        }
        @media (min-width: 768px) {
            .tabs i {
                padding: 5px;
                margin-right: 10px;
            }
            .tabs label span {
                display: inline-block;
            }
            .tabs {
            max-width: 100%;
            margin: 50px auto;
            }
        }

        .tab_container {
            font-family: sans-serif;
            background: #f6f9fa;
        }

        .tab_container .tab-cnt, #t1, #t2 {
          clear: both;
          padding-top: 10px;
          display: none;
        }

        .tab_container .tab-cnt2, #t3, #t4 {
          clear: both;
          padding-top: 10px;
          display: none;
        }

        .tab_container .tab-cnt3, #t5, #t6 {
          clear: both;
          padding-top: 10px;
          display: none;
        }

        #t5:checked ~ #content5,
        #t6:checked ~ #content6 {
          display: block;
          padding: 20px;
          background: #fff;
          color: #999;
          border-bottom: 2px solid #f0f0f0;
        }

        #t3:checked ~ #content3,
        #t4:checked ~ #content4 {
          display: block;
          padding: 20px;
          background: #fff;
          color: #999;
          border-bottom: 2px solid #f0f0f0;
        }

        .tab_container label {
          font-weight: 700;
          font-size: 18px;
          display: block;
          float: left;
          width: 20%;
          color: #757575;
          cursor: pointer;
          text-decoration: none;
          text-align: center;
          background: #f0f0f0;
        }

        #t1:checked ~ #content1,
        #t2:checked ~ #content2 {
          display: block;
          padding: 20px;
          background: #fff;
          color: #999;
          border-bottom: 2px solid #f0f0f0;
        }

        .tab_container [id^="t"]:checked + label {
          background: #fff;
          box-shadow: inset 0 3px #0CE;
          width: 33% !important;
        }

        .tab_container [id^="t"]:checked + label .fa {
          color: #0CE;
        }

        .tab_container label .fa {
          font-size: 1.3em;
          margin: 0 0.4em 0 0;
        }

        /*Media query*/
        @media only screen and (max-width: 900px) {
          .tab_container label span {
            display: none;
          }
          
          .tab_container {
            width: 98%;
          }
        }

        /*Content Animation*/
        @keyframes fadeInScale {
          0% {
            transform: scale(0.9);
            opacity: 0;
          }
          
          100% {
            transform: scale(1);
            opacity: 1;
          }
        }
    </style>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="tabs col-12">
                     
                        <input type="radio" name="tabs" id="tab1" checked >
                        <label for="tab1">
                            <i class="fa fa-brands fa-slack"></i><span>Regular Market</span>
                        </label>

                        <input type="radio" name="tabs" id="tab2">
                        <label for="tab2">
                            <i class="fa fa-star"></i><span>Starline Market</span>
                        </label>

                        <input type="radio" name="tabs" id="tab3">
                        <label for="tab3">
                            <i class="fa fa-chess-king"></i><span>King Market</span>
                        </label>
                     

                <div id="tab-content1" class="tab-content">
                    <table class="table table-responsive text-center">
                        <thead>
                          <tr>
                            <th colspan="2">REGULAR BAZAR BHAV</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Game Name</th>
                                <th>Bhav</th>
                            </tr>
                            <tr>
                                <td>Single Digit</td>
                                <td>1=9.9</td>
                            </tr>
                            <tr>
                                <td>Jodi</td>
                                <td>1=95</td>
                            </tr>
                            <tr>
                                <td>Single Patti</td>
                                <td>1=140</td>
                            </tr>
                            <tr>
                                <td>Double Patti</td>
                                <td>1=280</td>
                            </tr>
                            <tr>
                                <td>Triple Patti</td>
                                <td>1=700</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tab-content2" class="tab-content">
                    <table class="table table-responsive text-center">
                        <thead>
                          <tr>
                            <th colspan="2">STARLINE BAZAR BHAV</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Game Name</th>
                                <th>Bhav</th>
                            </tr>
                            <tr>
                                <td>Single Digit</td>
                                <td>1=9.9</td>
                            </tr>
                            <tr>
                                <td>Single Patti</td>
                                <td>1=140</td>
                            </tr>
                            <tr>
                                <td>Double Patti</td>
                                <td>1=280</td>
                            </tr>
                            <tr>
                                <td>Triple Patti</td>
                                <td>1=700</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tab-content3" class="tab-content">
                    <table class="table table-responsive text-center">
                        <thead>
                          <tr>
                            <th colspan="2">King BAZAR BHAV</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Game Name</th>
                                <th>Bhav</th>
                            </tr>
                            <tr>
                                <td>First Digit</td>
                                <td>1=9.5</td>
                            </tr>
                            <tr>
                                <td>Second Digit</td>
                                <td>1=9.5
                                </td>
                            </tr>
                            <tr>
                                <td>Jodi</td>
                                <td>1=90</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>