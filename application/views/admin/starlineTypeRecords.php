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
        <div class="row sec-margin mktlist">
            <h3 class="resHead">
                <?=urldecode($bazarName)?>
                <span class="res">
                    <?=!empty($res)?'( '.$res['result_patti'].'-'.$res['result_akda'].' )':'';?>
                </span>
            </h3>
            
            <?php
                foreach($arr as $data){
                    if(in_array($data['game_id'],['1','2','3','4','13','14','15','16','25','26','27','28'])){
            ?>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <a href="<?=base_url().'e8403aadfc2add778d1d778245c5f25b/'.$bazar_id.'/'.$time_id.'/'.$data['game_id'].'/'.$bazarName.'/'.$data['game_name']?>">
                                <div class="dark mktitem box border rounded text-center">
                                    <h2 class="mktitem-name"><?=$data['game_name']?></h2>
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
                }
            ?> 
            
            
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>