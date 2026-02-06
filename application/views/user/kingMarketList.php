<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
     
    /* .mktitem-wrapper .mktitem1 #kingtime {
        font-size: 12px;
        text-transform: lowercase;
        width: 100px;
        margin-left: auto;
        margin-right: auto;
        margin-top: -0.5rem;
        margin-bottom: -0.3rem;
        transform: skew(-8deg);
    }
    #icn{
        height: 25px;
        width: 25px;
        float: left;
    }
    #icn1{
        height: 25px;
        width: 25px;
        float: right;
    }
    #icnText{
        float: left;
    }
    #icnText1{
        float: right;
    }
    .tv-ioco
    {
        margin-left: 12px;    
    }
    .l-txt        
    {
        margin-top: 28px;
        margin-bottom: 0;
        margin-left: -50px;
    }
    .r-txt
    {
        margin-bottom: 0;
        margin-top: 25px;
        margin-right: -40px;
    }
    .holi-ico    
    {
        margin-right: 5px;
        margin-top: 0px;
    }
    .mktitem-time.time-detail
    {
            margin-top: 30px;
    }
    .mktitem-wrapper .mktitem1 #kingtime {
        margin-top: 40px;
    } */


    /* .mktitem-wrapper .mktitem1 #kingtime {
        margin-top: 40px;
    }   */

    .mktitem1   {
        position: relative;

    }
    .mktitem1 .tv-icon-wrapper, .mktitem1 .holi-icon-wrapper  {
        position: absolute;
        top : 25%;
    }
    .mktitem1 .tv-icon-wrapper p, .holi-icon-wrapper p {
        font-size : 9px;
        margin-top : 5px;
    }
    .mktitem1 .tv-icon-wrapper  {
        left : 5%;
    } 
    .mktitem1 .holi-icon-wrapper    {
        right:5%;
    }
    .mktitem1 .bazar-icon   {
        width: 40px;
    }
</style>
        <!-- Market List -->
        <div class="container container-custom">
            <div class="row sec-margin mktlist">
                <?php 
                    foreach($kingGame as $list){
                ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6 col-cus col-p">
                    <a href="<?=base_url()?>9c8f59a017280083c64fbc7e958e590f/<?=$list['id']?>?token=<?=$_SESSION['token']?>&id=<?=$_SESSION['customer_id']?>&app=<?=$_SESSION['app']?>">
                        <div class="pricing-item">
                            <img class="bzimg" src="<?=$list['bazar_image']?>" alt="">
                            <div class="ldv">
                                <p class="bzname"><?=$list['bazar_name']?></p>
                                <p class="re-txt"><?=$list['result']?></p>
                                <p class="run">
                                    <?php
                                        if(checkTime($list['time'])<=time()){
                                            echo 'Running for tomorrow';
                                        }else{
                                            echo '<span class="blink">Running for today</span>';
                                        }
                                    ?>
                                </p>
                            </div>
                            <?php
                                if($d['icon_status']=='1'){
                                    echo '<div class="rdv">
                                                <img src="'.base_url().'assets/newDesign/images/tv.png" class="tv" id="icn">
                                                <span class="liv-txt">'.
                                                    $list['text'].
                                                '</span>
                                            </div>';
                                }
                                if($d['icon_status1']=='1'){
                                    echo '<div class="rdv">
                                                <img src="'.base_url().$list['icon1'].'" class="tv" id="icn1">
                                                <span class="liv-txt">'.
                                                    $list['text1'].'
                                                </span>
                                            </div>';
                                }
                            
                    echo '<div class="clrBoth"></div>
                            <div class="btmDv kdg">
                                <div class="lfirst">
                                    <p>'.date('h:i A',checkTime($list['time'])).'</p>
                                    <p class="retime">
                                    <div class="mktitem-time time-detail clockdiv" data-date="'.date('Y-m-d H:i:s',checkTime($list['time'])).'">
                                        <div style="display:none;">
                                            <span class="days"></span>
                                        </div>
                                        <div>
                                            <span class="hours"></span>H
                                        </div>
                                        <div>
                                            <span class="minutes"></span>M
                                        </div>
                                        <div>
                                            <span class="seconds"></span>S
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                <div class="clrBoth"></div>
                            </div>
                        </div>
                    </a>
                </div>'; 
             } ?>
            </div>
        </div>
         
<?php include 'includes/footer.php'; ?>