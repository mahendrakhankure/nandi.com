<?php
include 'includes/header.php';
?>
<style type="text/css">
    .mktitem-wrapper .mktitem1 #kingtime {
        margin-top: 40px;
    }

    .mktitem1 {
        position: relative;

    }

    .mktitem1 .tv-icon-wrapper,
    .holi-icon-wrapper {
        position: absolute;
        top: 10%;
    }

    .mktitem1 .tv-icon-wrapper p,
    .holi-icon-wrapper p {
        font-size: 9px;
        margin-top: 5px;
    }

    .mktitem1 .tv-icon-wrapper {
        left: 5%;
    }

    .mktitem1 .holi-icon-wrapper {
        right: 5%;
    }

    .mktitem1 .bazar-icon {
        width: 40px;
    }

    .resHead {
        font-size: 18px;
    }
</style>
<link href="assets/newDesign/css/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>assets/newDesign/css/responsive.css" rel="stylesheet">
<div class="container container-custom">
    <h3 class="resHead text-center">
        <?= urldecode($starlineName) ?>
    </h3>
    <div class="row sec-margin mktlist app-heading">


        <?php
        foreach ($starlineTime as $data) {
            $sql = "SELECT result_patti,result_akda FROM starline_bazar_result WHERE bazar_name='" . $data['bazar_name'] . "' AND time='" . $data['id'] . "' AND result_date='" . date('Y-m-d') . "' ORDER BY id desc";
            $res = $this->db->query($sql);
            $row = $res->row_array();
            
            if (empty($row['result_patti'])) {
                $sql = "SELECT result_patti,result_akda FROM starline_bazar_result WHERE bazar_name='" . $data['bazar_name'] . "' AND time='" . $data['id'] . "' AND result_date='" . date('Y-m-d', strtotime(' -1 day')) . "' ORDER BY id desc";
                // echo $sql;
                $res = $this->db->query($sql);
                $row = $res->row_array();
            }

            if (!empty($row)) {
                $r = $row['result_patti'] . '-' . $row['result_akda'];
                $u = $r;
            } else {
                $r = '***-*';
                $u = '--';
            }
            // echo $data['time'];
            // if($_GET['app']=='BD'){
            //     echo '<pre>';
            //     print_r($data);
            //     print_r(date('Y-m-d g:i a', checkTime($data['time'])));
            //     die();
            // }
        ?>
            <div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
                <a href="<?= base_url() . '627c9e487ce67279be0ba390dbbf2735/' . $data['id'] . '/' . $u . '/' . $data['bazar_name'] . $tUrl ?>">
                    <div class="pricing-item borderdv">
                        <img class="bzimg" src="<?= $data['bazar_image'] ?>" alt="">
                        <div class="btmDv">
                            <div class="lfirst">
                                <div class="ldv">
                                    <p class="retime">
                                    <div class="mktitem-time clockdiv" data-date="<?= date('Y-m-d g:i a', checkTime($data['time'])) ?>">
                                        <div style="display:none;">
                                            <span class="days"></span>
                                        </div>
                                        <div class="cld">
                                            <span class="hours"></span>H
                                        </div>
                                        <div class="cld">
                                            <span class="minutes"></span>M
                                        </div>
                                        <div class="cld">
                                            <span class="seconds"></span>S
                                        </div>
                                    </div>
                                    </p>
                                    <p class="re-txt"><?= $r ?></p>

                                </div>
                            </div>
                            <div class="middle">
                                <img src="<?= base_url() ?>assets/newDesign/images/clock.png" class="clck">
                            </div>
                            <div class="llast">
                                <div class="rdv">
                                    <span class="liv-txt time-text"><?= date('g:i a', checkTime($data['time'])) ?></span>
                                </div>
                            </div>
                            <div class="clrBoth"></div>
                            <?php
                                if (date('H:i:s', checkTime($data['time'])) > date('H:i:s')) {
                                    echo '<p class="run run-status"><span class="blink">Running for today</span></p>';
                                } else {
                                    echo '<p class="run run-status">Closed For Today</p>';
                                }
                            ?>
                        </div>
                        
                    </div>
                </a>
            </div>
        <?php
        }
        ?>


    </div>
</div>

<?php include 'includes/footer.php'; ?>