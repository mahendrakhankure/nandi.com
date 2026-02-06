<?php 
    include 'includes/header.php';
    if(isset($res['open']) && $res['open']!=''){
        $rs = $res['open'].','.$res['jodi'].','.$res['close']!=''?$res['close']:"'-'";
    }else{
        $rs = "'-','-','-'";
    }
?>
    <style type="text/css">
        .fSangam {
            color: #0c18ff;
        }
        td.bet {
            background-color: red;
            color: #fff;
        }
        td.tBet{
            background-color: #2c33bd;
            color: #fff;
        }
        a { color: #ccc; text-decoration: none !important;}a:hover {color: yellow;}
        .tabs {
            max-width: 90%;
            float: none;
            list-style: none;
            padding: 0;
            margin: 75px auto;
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
        }
        .tab-content {
            display: none;
            width: 100%;
            float: left;
            padding: 15px;
            box-sizing: border-box;
            background-color:#ffffff;
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
        #tab1:checked ~ #tab-content1,
        #tab2:checked ~ #tab-content2,
        #tab3:checked ~ #tab-content3,
        #tab4:checked ~ #tab-content4,
        #tab5:checked ~ #tab-content5 {
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
            max-width: 950px;
            margin: 50px auto;
            }
        }


        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');


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
        .win{
            background-color: green;
            color: #fff;
        }
        .res{
            color: #45ff45;
            font-weight: 600;
        }
        .sr{
            background-color: #b029b9;
            color: #fff;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-users"></i> Regular Bazar <?=urldecode($bazar_name)?>
            <span class="res">
                <?=!empty($res['open'])?$res['open'].'-'.$res['jodi']:'';?>
                <?=!empty($res['close'])?'-'.$res['close']:'';?>        
            </span>
          </h1>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <?php 
                        foreach($arr as $list){
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="p3-game-list boxRegular">
                            <p class="time">
                                <?php
                                    if(in_array($list['game_id'], ['6','10','11','14','17','22','23'])){
                                ?>
                                <a href="<?=base_url();?>bd29495a162eff20974745d93895b1fa/<?=$bazar_id?>/<?=$list['game_id']?>/3/<?=$list['game_name']?>">
                                    <span class="t otime">
                                        Jodi
                                    </span>
                                </a>
                                <?php
                                    }else{
                                      $list['game_name'] =preg_replace('/[0-9\@\.\;\(\)\,]+/', ' ', $list['game_name']);
                                ?>
                                    <a href="<?=base_url();?>bd29495a162eff20974745d93895b1fa/<?=$bazar_id?>/<?=$list['game_id']?>/1/<?=$list['game_name']?>">
                                        <span class="t otime">
                                            Open
                                        </span>
                                    </a> 
                                    <span class="time-divider">|</span> 
                                    <a href="<?=base_url();?>bd29495a162eff20974745d93895b1fa/<?=$bazar_id?>/<?=$list['game_id']?>/2/<?=$list['game_name']?>">
                                        <span class="t ctime">
                                            Close
                                        </span>
                                    </a>
                                <?php
                                    }
                                ?>
                            </p>
                            <div class="inner">
                                    <h4 class="gameName"><?=$list['game_name'];?></h4>
                                    <p> <span class="ctext">  Total Bets </span> : <span class="cvalue bets"><?=$list['count_id']?></span></p>
                                    <p> <span class="ctext"> Total Amount </span> : <span class="cvalue bets"><?=empty($list['point'])?'0':$list['point'];?></span></p>
                            </div>
                            </div> 
                        <!-- </a> -->
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <h3 style="text-align: center;">
            <span class="res">
                <?=!empty($res['open'])?$res['open'].'-'.$res['jodi']:'';?>
                <?=!empty($res['close'])?'-'.$res['close']:'';?>        
            </span>
        </h3>
        <div class="tabs">
            <input type="radio" name="tabs" id="tab1" checked >
            <label for="tab1">
                <!-- <i class="fa fa-html5"></i> -->
                <span>SINGLE DIGIT</span>
            </label>

            <input type="radio" name="tabs" id="tab2">
            <label for="tab2" onclick="getTabData(<?=$bazar_id?>,'JODI',<?=$rs?>)">
                <!-- <i class="fa fa-css3"></i> -->
                <span>JODI</span>
            </label>

            <input type="radio" name="tabs" id="tab3">
            <label for="tab3" onclick="getTabData(<?=$bazar_id?>,'SINGLEPATTI',<?=$rs?>)">
                <!-- <i class="fa fa-code"></i> -->
                <span>SINGLE PATTI</span>
            </label>

            <input type="radio" name="tabs" id="tab4">
            <label for="tab4" onclick="getTabData(<?=$bazar_id?>,'DOUBLEPATTI',<?=$rs?>)">
                <!-- <i class="fa fa-code"></i> -->
                <span>DOUBLE PATTI</span>
            </label>

            <input type="radio" name="tabs" id="tab5">
            <label for="tab5" onclick="getTabData(<?=$bazar_id?>,'TRIPLEPATTI',<?=$rs?>)">
                <!-- <i class="fa fa-code"></i> -->
                <span>TRIPLE PATTI</span>
            </label>

            <div id="tab-content1" class="tab-content">
                <p id="tasd" style="float: right;font-size: 15px;font-weight: 600;"></p>
                <table class="table table-responsive text-center">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <th>Type</th>
                            <?php
                                for($i=0;$i<10;$i++){
                            ?>
                            <th>
                                <?=$i?>    
                            </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Open</td>
                            <?php 
                                $tOpen = 0;
                                $con=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazar_id.'" AND game_name="5" AND game_type="Open"';
                                // $feilds = 'SUM(point) as amt,game';
                                $feilds = 'SUM(point_in_rs) as amt,game';
                                $amtArr = $this->Common_model->getData('regular_bazar_games',$con,$feilds,'','','','game asc','game');
                                foreach($amtArr as $amt){ 
                                // echo '<pre>';
                                // print_r($amt);
                                // die();
                                    
                                // for($i=0;$i<10;$i++){ 
                                    // $con1 = ' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazar_id.'" AND game_name="5" AND game="'.$i.'" AND game_type="Open"';
                                    // $amt = $this->Common_model->getData('regular_bazar_games',$con1,'SUM(point) as amt','','','One','','');
                                    $tOpen += $amt['amt'];
                                    if(isset($res['jodi'][0])&&$res['jodi'][0]==$amt['game']){
                                        $r = 'win';
                                    }else{
                                        $r = 'loss';
                                    }
                            ?>
                            <td class="<?=$r?>">
                                <?=$amt['amt']==0?0:$amt['amt'];?>    
                            </td>
                            <?php } ?>
                            <td><?=$tOpen?></td>
                        </tr>
                        <tr>
                            <td>Close</td>
                            <?php 
                                $tClose = 0;
                                $con1=' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazar_id.'" AND game_name="5" AND game_type="Close"';
                                $feilds1 = 'SUM(point) as amt,game';
                                $amtArr1 = $this->Common_model->getData('regular_bazar_games',$con1,$feilds1,'','','','game asc','game');

                                foreach($amtArr1 as $amt1){  
                                // for($i=0;$i<10;$i++){ 
                                //     $con1 = ' WHERE result_date="'.date('Y-m-d').'" AND bazar_name="'.$bazar_id.'" AND game_name="5" AND game="'.$i.'" AND game_type="Close"';
                                //     $amt = $this->Common_model->getData('regular_bazar_games',$con1,'SUM(point) as amt','','','One','','');
                                    $tClose += $amt1['amt'];
                                    if(isset($res['jodi'][1])&&$res['jodi'][1]==$amt1['game']){
                                        $r = 'win';
                                    }else{
                                        $r = 'loss';
                                    }
                            ?>
                            <td class="<?=$r?>">
                                <?=$amt1['amt']==0?0:$amt1['amt'];?>    
                            </td>
                            <?php } ?>
                            <td><?=$tClose?></td>
                        </tr>
                        <span style="display: none;" id="tasd1"><?=$tOpen+$tClose?></span>
                    </tbody>
                </table>
            </div> <!-- #tab-content1 -->

            <div id="tab-content2" class="tab-content">
                <div id="JODI"></div>
            </div> <!-- #tab-content2 -->

            <div id="tab-content3" class="tab-content">
                <!-- ------------------------ -->
                <div class="tab_container">
                    <input id="t1" type="radio" name="tbs" checked>
                    <label for="t1"><i class="fa fa-folder-open-o"></i><span>Open</span></label>
                    <input id="t2" type="radio" name="tbs">
                    <label for="t2"><i class="fa fa-envelope-o"></i><span>Close</span></label>
                    <section id="content1" class="tab-cnt">
                        <div id="SINGLEPATTI"></div>
                    </section>
                    <section id="content2" class="tab-cnt">
                        <div id="SINGLEPATTIclose"></div>
                    </section>
                </div>
            </div> <!-- #tab-content3 -->

            <div id="tab-content4" class="tab-content">
                <div class="tab_container">
                    <input id="t3" type="radio" name="tbs1" checked>
                    <label for="t3"><i class="fa fa-folder-open-o"></i><span>Open</span></label>
                    <input id="t4" type="radio" name="tbs1">
                    <label for="t4"><i class="fa fa-envelope-o"></i><span>Close</span></label>
                    <section id="content3" class="tab-cnt2">
                        <div id="DOUBLEPATTI"></div>
                    </section>
                    <section id="content4" class="tab-cnt2">
                        <div id="DOUBLEPATTIclose"></div>
                    </section>
                </div>
            </div> <!-- #tab-content4 -->

            <div id="tab-content5" class="tab-content">
                <div class="tab_container">
                    <input id="t5" type="radio" name="tbs2" checked>
                    <label for="t5"><i class="fa fa-folder-open-o"></i><span>Open</span></label>
                    <input id="t6" type="radio" name="tbs2">
                    <label for="t6"><i class="fa fa-envelope-o"></i><span>Close</span></label>
                    <section id="content5" class="tab-cnt3">
                        <div id="TRIPLEPATTI"></div>
                    </section>
                    <section id="content6" class="tab-cnt3">
                        <div id="TRIPLEPATTIclose"></div>
                    </section>
                </div>
            </div> <!-- #tab-content5 -->

        </div> <!-- .tabs -->
    </div>
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tasd').text('Total '+$('#tasd1').text());
    });
</script>