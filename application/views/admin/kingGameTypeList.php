<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
    .box{
        padding: 50px;
        margin-top: 50px;
    }
    .res{
        color: #45ff45;
        font-weight: 600;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-12">
                <h3 class="title">
                    <?=strtoupper(urldecode($bazarName))?>
                    <span class="res">
                        <?=!empty($res['result'])?$res['result']:'';?>
                    </span>
                </h3>
            </div>
        </div>
        <div class="row sec-margin mktlist">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="<?=base_url().'c1881587b76a7f53805cae24277e5aa5/'.$bazarId.'/1/'.$bazarName?>">
                    <div class="dark mktitem box border rounded text-center">
                        <h4 class="mktitem-name">First Digit</h4>
                        <div class="col-md-6">
                            Bets : <p class="mktitem-result resDisply"><?=$first['id']?></p>
                        </div>
                        <div class="col-md-6">
                            Points : <p class="mktitem-result resDisply"><?=empty($first['point'])?0:$first['point'];?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="<?=base_url().'c1881587b76a7f53805cae24277e5aa5/'.$bazarId.'/2/'.$bazarName?>">
                    <div class="dark mktitem box border rounded text-center">
                        <h4 class="mktitem-name">Second Digit</h4>
                        <div class="col-md-6">
                            Bets : <p class="mktitem-result resDisply"><?=$second['id']?></p>
                        </div>
                        <div class="col-md-6">
                            Points : <p class="mktitem-result resDisply"><?=empty($second['point'])?0:$second['point'];?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="<?=base_url().'c1881587b76a7f53805cae24277e5aa5/'.$bazarId.'/3/'.$bazarName?>">
                    <div class="dark mktitem box border rounded text-center">
                        <h4 class="mktitem-name">Jodi</h4>
                        <div class="col-md-6">
                            Bets : <p class="mktitem-result resDisply"><?=$jodi['id']?></p>
                        </div>
                        <div class="col-md-6">
                            Points : <p class="mktitem-result resDisply"><?=empty($jodi['point'])?0:$jodi['point'];?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>