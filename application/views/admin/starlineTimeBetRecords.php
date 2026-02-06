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
            <h3 class="resHead">
                <?=urldecode($bazarName)?>
            </h3>
            
            <?php
                foreach($arr as $data){
            ?>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <a href="<?=base_url().'7bec85cdcef85df6822179a95c64b80f/'.$bazar_id.'/'.$data['time_id'].'/'.$bazarName?>">
                        <div class="dark mktitem box border rounded text-center">
                            <h2 class="mktitem-name"><?=$data['time']?></h2>
                            <div class="col-md-6">
                                Bets : <p class="mktitem-result resDisply"><?=$data['id']?></p>
                            </div>
                            <div class="col-md-6">
                                Points : <p class="mktitem-result resDisply"><?=empty($data['point'])?0:$data['point'];?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?> 
            
            
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>