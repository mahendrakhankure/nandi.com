<!-- <?php
include 'includes/header.php';
$page = str_replace(' ', '', str_replace(')', '', str_replace('(', '', $gameDetail['game_name'])));
$imgF = 'images';

    // echo '<pre>';
    // print_r($_SESSION['usid']->balance);
    // die();
?>
<link href="assets/newDesign/css/custom.css" rel="stylesheet"> -->
<link href="assets/newDesign/css/responsive.css" rel="stylesheet">
<script src="assets/newDesign/js/bootstrap.bundle.min.js"></script>
<div class="headerTop">
    
    <?php if($_SESSION['usid']){ ?>
        <div class="walletDV">
            <span class="wal-ico"><img src="assets/newDesign/images/Group.png"></span>
            INR
            <span class="amt">
                <?= round($_SESSION['usid']->balance) ?>
                <?php echo $crn; ?>
            </span>
        </div>
        <a href="<?=base_url()?>signout" class="plceBet">Signout</a>
    <?php }else{ ?>
        <a href="<?=base_url()?>signup" class="plceBet">Signup</a>
    <?php } ?>
    <!-- <div class="serchDv">
        <div class="icon-input">
            <input class="icon-input__text-field" id='checkBazar' type="text" onkeyup="checkBazar()">
            <i class="fa fa-search sricon" aria-hidden="true"></i>
        </div>
    </div>
    <div class="clrBoth"></div> -->
</div>
<div class="container container-custom">
    <div class="tabOuter">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item nav-custom" role="presentation">
                <a class="nav-link active" id="first-tab" data-bs-toggle="tab" data-bs-target="#first" type="button" role="tab" aria-controls="home" aria-selected="true"><span class="img img-status"><img class="activ-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/regular-bazar.webp"><img class="deactive-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/regular-bazar.webp"></span><span class="bazarName">Regular Bazar</span></a>
            </li>
            <!-- in_array($_GET['token'],['2ba24f5e18fff8a504f84d22a2c160db']) ||   -->
            <!-- 15f9d4a1b225118231d11388e5b42e3, 7697e7de71295fa3aa42f06fc583b844 -->
            <?php if($_GET['token'] != '6fb981ea0a3cb5411569b68bd4e30bf8'){ ?>
            <li class="nav-item nav-custom blink-soft" role="presentation">
                <a href="<?= base_url(); ?>64175b4c45ba44a1ff364556867ce775/<?= $tUrl ?>" class="nav-link"><span class="img img-status"><img class="deactive-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/wheel-icon1.webp"><img class="activ-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/wheel-icon1.webp"></span><span class="bazarName">Crazy Wheel</span></a>
            </li>
            <?php } ?>
            <li class="nav-item nav-custom" role="presentation" onclick="checkV()">
                <a class="nav-link" id="second-tab" data-bs-toggle="tab" data-bs-target="#second" type="button" role="tab" aria-controls="profile" aria-selected="false"><span class="img img-status"><img class="deactive-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/king11.webp"><img class="activ-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/king11.webp"></span><span class="bazarName">King Bazar</span></a>
            </li>
            <li class="nav-item nav-custom" role="presentation">
                <a class="nav-link" id="third-tab" data-bs-toggle="tab" data-bs-target="#third" type="button" role="tab" aria-controls="contact" aria-selected="false"><span class="img img-status"><img class="deactive-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/starline.webp"><img class="activ-img" src="https://testingbucketforvdo.s3.ap-southeast-1.amazonaws.com/starline.webp"></span><span class="bazarName">Starline Bazar</span></a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent"  style="text-align:center">
        <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
            <div class="row">
                <?php
                $i = 0;
                foreach ($marketList as $list) {
                ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
                        <a href="<?= base_url(); ?>9a27a7e97c16a7b3ac6382d21205357f/<?= $list['bazar_id'] ?>/<?= $list['result'] ?><?= $tUrl ?>">
                            <div class="pricing-item">
                                
                                <div class="btmDv">
                                <p class="bzname"><?= $list['bazar_name']; ?></p>
                                    <p class="re-txt">
                                        <?php
                                        if ($list['result'] != "--") {
                                            echo $list['result'];
                                        } else {
                                            echo '***-**-***';
                                        }
                                        ?>
                                    </p>
                                    <p class="run">
                                        <?php
                                        if (strtotime($list['close_time']) <= time()) {
                                            echo 'Running for tomorrow';
                                        } else {
                                            echo '<span class="blink">Running for today</span>';
                                        }
                                        ?>
                                    </p>
                                    <div class="lfirst">
                                        <p><?= date('h:i A', strtotime($list['open_time'])) ?></p>
                                        <p>OPEN</p>
                                        <p class="retime">
                                        <div class="mktitem-time clockdiv" data-date="<?= date($list['oD'][0] . ' H:i:s', strtotime($list['open_time'])) ?>">
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

                                    <div class="llast">
                                        <p><?= date('h:i A', strtotime($list['close_time'])) ?></p>
                                        <p>CLOSE</p>
                                        <p class="retime">
                                        <div class="mktitem-time clockdiv" data-date="<?= date($list['cD'][0] . ' H:i:s', strtotime($list['close_time'])) ?>">
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
                <?php $i++;
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
            <div class="row">
                <div class="row" id="kingList"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
            <div class="row">
                <div id="starList">
                    <div class="container container-custom">
                        <div class="live-center milanDv">
                            <div class="akdaMain" style="text-align: center">
                            <?php
                            foreach ($starlinegame as $data) {
                                if($_GET['app']=='BD')
                                    $data['bazar_name']=='Milan Starline'?$data['bazar_name']='Dhaka Starline':$data['bazar_name']=$data['bazar_name'];
                            ?>
                                <a href="<?= base_url() . 'b53e70fa24904d94988757105672a5e0/' . $data['id'] . '/' . $data['bazar_name'] . $tUrl ?>" class="akda-block starLink">
                                    <img src="<?= $data['bazar_image'] ?>">
                                    <label><?= $data['bazar_name'] ?></label>
                                </a>
                            <?php
                            }
                            ?>
                                <div class="clrBoth"></div>
                            </div>
                            <div class="clrBoth"></div>
                        </div>
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
    function checkBazar() {
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

        var input1, filter1, ul1, li1, a1, i1, txtValue1;
        input1 = document.getElementById("checkBazar");
        filter1 = input1.value.toUpperCase();
        ul1 = document.getElementById("second");
        li1 = ul1.getElementsByClassName("col-cus");
        for (i1 = 0; i1 < li1.length; i1++) {
            a1 = li1[i1].getElementsByClassName("bzname")[0];
            txtValue1 = a1.textContent || a1.innerText;
            if (txtValue1.toUpperCase().indexOf(filter1) > -1) {
                li1[i1].style.display = "";
            } else {
                li1[i1].style.display = "none";
            }
        }
    }

    function checkV() {
        if ($('#kingList').html() == "") {
            console.log('===================>',base_url)
            $.ajax({
                type: "POST",
                // headers: {
                //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                // },
                data: {token:"<?=$_GET['token']?>",customer_id:"<?=$_GET['id']?>",app:"<?=$_GET['app']?>"} ,
                url: "http://localhost/p1/250130c21dbbd5247d6f38fac054ba64",
                success: function(res) {
                    var r = JSON.parse(res);
                    $('#kingList').append(r);
                    loadTimer();
                }
            });
        }
    }
</script>