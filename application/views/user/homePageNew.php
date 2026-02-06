<?php 
    include 'includes/header.php'; 
    $page = str_replace(' ', '', str_replace(')', '',str_replace('(', '', $gameDetail['game_name'])));  
?>
    <style>
        .clockdiv div {
            color: #EABA13 !important;
        }
    </style>
    <link href="assets/newDesign/css/custom.css" rel="stylesheet">
    <script src="assets/newDesign/js/bootstrap.bundle.min.js"></script>
    <div class="headerTop">
        <a href="#" class="bc-arrow"><img src="assets/newDesign/images/back.png"></a>
        <div class="walletDV"><span class="wal-ico"><img src="assets/newDesign/images/Group.png"></span>
            <span class="rupee">
                <?php
                    if($_GET['app']=="BD")
                        echo '&#2547;';
                    else
                        echo '<i class="fa fa-inr" aria-hidden="true"></i>';
                ?>
            </span>
            <!-- <span class="rupee"><i class="fa fa-inr" aria-hidden="true"></i></span> -->
            <span class="amt">
                    <?=round($_SESSION['balance'])?>
                    <?php echo $_GET['app']=="BD"?"TAKA":"INR"; ?>
                </span>
            </div>
        <div class="serchDv">
            <div class="icon-input">
                <input class="icon-input__text-field" id='checkBazar' type="text" onkeyup="checkBazar()">
                <i class="fa fa-search sricon" aria-hidden="true"></i>
            </div>
        </div>
        <div class="clrBoth"></div>
    </div>
    <div class="container container-custom">
        <div class="tabOuter">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item nav-custom" role="presentation">
                    <a class="nav-link active" id="first-tab" data-bs-toggle="tab" data-bs-target="#first" type="button" role="tab" aria-controls="home" aria-selected="true"><span class="img"><img src="assets/newDesign/images/22.png"><img class="activ-img" src="assets/newDesign/images/2.png"></span><span class="bazarName">Regular Bazar</span></a>
                </li>
                <li class="nav-item nav-custom" role="presentation">
                    <a class="nav-link" id="second-tab" data-bs-toggle="tab" data-bs-target="#second" type="button" role="tab" aria-controls="profile" aria-selected="false"><span class="img"><img src="assets/newDesign/images/1.png"><img class="activ-img" src="assets/newDesign/images/11.png"></span><span class="bazarName">King Bazar</span></a>
                </li>
                <li class="nav-item nav-custom" role="presentation">
                    <a class="nav-link" id="third-tab" data-bs-toggle="tab" data-bs-target="#third" type="button" role="tab" aria-controls="contact" aria-selected="false"><span class="img"><img src="assets/newDesign/images/3.png"><img class="activ-img" src="assets/newDesign/images/33.png"></span><span class="bazarName">Starline Bazar</span></a>
                </li>
                <li class="nav-item nav-custom" role="presentation">
                    <a class="nav-link" id="third-tab" data-bs-toggle="tab" data-bs-target="#forth" type="button" role="tab" aria-controls="contact" aria-selected="false"><span class="img"><img src="assets/newDesign/images/4.png"><img class="activ-img" src="assets/newDesign/images/44.png"></span><span class="bazarName">Instant Worli</span></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                <div class="row">
                    <?php 
                        $i=0;
                        foreach($marketList as $list){
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
                        <a href="<?php echo base_url();?>9a27a7e97c16a7b3ac6382d21205357f/<?=$list['bazar_id']?>/<?=$list['result']?><?=$tUrl?>">
                            <div class="pricing-item">
                                <img class="bzimg" src="assets/newDesign/images/image 1.png" alt="">
                                <div class="ldv">
                                    <p class="bzname"><?=$list['bazar_name'];?></p>
                                    <p class="re-txt">
                                        <?php
                                            if($list['result']!="--"){
                                                echo $list['result'];
                                            }else{
                                                echo '***-**-***';
                                            }
                                        ?>
                                    </p>
                                    <p class="run">
                                        <?php 
                                            if(strtotime($list['close_time'])<=time()){
                                                echo 'Running for tomorrow';
                                            }else{
                                                echo '<span class="blink">Running for today</span>';
                                            }
                                        ?>
                                    </p>
                                </div>
                                <?php
                                    if($list['icon_status']=='1'){
                                ?>
                                    <div class="rdv">
                                        <img src="<?=base_url()?>assets/newDesign/images/tv.png" class="tv" id="icn">
                                        <span class="liv-txt">
                                            <?=$list['text']?>
                                        </span>
                                    </div>
                                <?php } ?>
                                <?php
                                    if($list['icon_status1']=='1'){
                                ?>
                                    <div class="rdv">
                                        <img src="<?=base_url().$list['icon1']?>" class="tv" id="icn1">
                                        <span class="liv-txt">
                                            <?=$list['text1']?>
                                        </span>
                                    </div>
                                <?php } ?>
                                
                                <div class="clrBoth"></div>
                                <div class="btmDv">
                                    <div class="lfirst">
                                        <p><?=date('h:i A',strtotime($list['open_time']))?></p>
                                        <p>OPEN</p>
                                        <p class="retime">
                                        <div class="mktitem-time clockdiv" data-date="<?=date($list['oD'][0].' H:i:s',strtotime($list['open_time']))?>">
                                            <div style="display:none;">
                                                <span class="days"></span>
                                            </div>
                                            <div class="">
                                                <span class="hours"></span>H
                                            </div>
                                            <div class="">
                                                <span class="minutes"></span>M
                                            </div>
                                            <div class="">
                                                <span class="seconds"></span>S
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="middle">
                                        <img src="assets/newDesign/images/clock.png" class="clck">
                                    </div>

                                    <div class="llast">
                                        <p><?=date('h:i A',strtotime($list['close_time']))?></p>
                                        <p>CLOSE</p>
                                        <p class="retime">
                                        <div class="mktitem-time clockdiv" data-date="<?=date($list['cD'][0].' H:i:s',strtotime($list['close_time']))?>">
                                            <div style="display:none;">
                                                <span class="days"></span>
                                            </div>
                                            <div class="">
                                                <span class="hours"></span>H
                                            </div>
                                            <div class="">
                                                <span class="minutes"></span>M
                                            </div>
                                            <div class="">
                                                <span class="seconds"></span>S
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                    <div class="clrBoth"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; } ?>
                </div>
            </div>
            <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                <div class="row">
                    <h1 style="color: #fff">Second Tab</h1>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                            <p class="three-col"><span>Text 1</span><span>Text 1</span><span>Text 1</span></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                <div class="row">
                    <h1 style="color: #fff">Third Tabs</h1>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                            <p class="three-col"><span>Text 1</span><span>Text 1</span><span>Text 1</span></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="forth" role="tabpanel" aria-labelledby="forth-tab">
                <div class="row">
                    <h1 style="color: #fff">Forth Tab</h1>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <p>MORNING MADHURI</p>
                            <p class="three-col"><span>Text 1</span><span>Text 1</span><span>Text 1</span></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="pricing-item">
                            <img src="assets/newDesign/images/download.png" alt="">
                            <h4>Basic Plan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
          include 'includes/footer.php'; 
    ?>
    <script>
        function checkBazar(){
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("checkBazar");
            filter = input.value.toUpperCase();
            ul = document.getElementById("first");
            li = ul.getElementsByClassName("col-cus");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByClassName("bzname")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>