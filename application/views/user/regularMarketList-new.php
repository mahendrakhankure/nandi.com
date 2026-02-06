<?php
include 'includes/header.php';
$page = str_replace(' ', '', str_replace(')', '', str_replace('(', '', $gameDetail['game_name'])));
if ($_GET['app'] == 'FB' || $_GET['app'] == 'LM') {
    $imgF = $_GET['app'];
} else {
    $imgF = 'images';
}
?>
<style>
    .clockdiv div {
        color: #EABA13 !important;
    }
</style>
<!-- <link href="assets/newDesign/css/custom.css" rel="stylesheet"> -->
<link href="assets/newDesign/css/responsive.css" rel="stylesheet">
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
            <?= round($_SESSION['balance']) ?>
            <?php echo $_GET['app'] == "BD" ? "TAKA" : "INR"; ?>
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
  <div class="row" id="first">
    <?php
      $i = 0;
      foreach ($marketList as $list) {
    ?>
        <div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
            <a href="<?= base_url(); ?>9a27a7e97c16a7b3ac6382d21205357f/<?= $list['bazar_id'] ?>/<?= $list['result'] ?><?= $tUrl ?>">
                <div class="pricing-item">
                    <img class="bzimg" src="<?=$list['bazar_image'];?>" alt="">
                    <div class="ldv">
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
                    </div>
                    <?php
                    if ($list['icon_status'] == '1') {
                    ?>
                        <div class="rdv">
                            <img src="<?= base_url() ?>assets/newDesign/images/tv.png" class="tv" id="icn">
                            <span class="liv-txt">
                                <?= $list['text'] ?>
                            </span>
                        </div>
                    <?php } ?>
                    <?php
                    if ($list['icon_status1'] == '1') {
                    ?>
                        <div class="rdv">
                            <img src="<?= base_url() . $list['icon1'] ?>" class="tv" id="icn1">
                            <span class="liv-txt">
                                <?= $list['text1'] ?>
                            </span>
                        </div>
                    <?php } ?>

                    <div class="clrBoth"></div>
                    <div class="btmDv">
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
                        <div class="middle">
                            <img src="assets/newDesign/images/clock.png" class="clck">
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
</script>