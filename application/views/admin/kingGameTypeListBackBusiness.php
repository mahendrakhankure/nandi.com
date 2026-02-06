<?php 
    include 'includes/header.php'; 
?>
<style type="text/css">
    .box{
        padding: 50px;
        margin-top: 50px;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid" >
        <div class="row sec-margin mktlist">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="<?=base_url().'1997a99c1b8b89695a25211764b9e7e1/'.$bazarId.'/1/'.$bazarName?>?from=<?=$from?>&to=<?=$to?>">
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
                <a href="<?=base_url().'1997a99c1b8b89695a25211764b9e7e1/'.$bazarId.'/2/'.$bazarName?>?from=<?=$from?>&to=<?=$to?>">
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
                <a href="<?=base_url().'1997a99c1b8b89695a25211764b9e7e1/'.$bazarId.'/3/'.$bazarName?>?from=<?=$from?>&to=<?=$to?>">
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