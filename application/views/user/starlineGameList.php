<?php 
    include 'includes/header.php'; 
    if($_GET['app']=='FB' || $_GET['app']=='LM'){
        $imgF=$_GET['app'];
    }else{
        $imgF='images';
    }
?>

 

<div class="container container-custom">
    <div class="row">
        <div class="bz-wrapper" style="margin-left: auto; margin-right: auto; width: auto;"><!-- class starMain  is removed-->
            <?php
                foreach($starlinegame as $data){
                    if($_GET['app']=='BD')
                        $data['bazar_name']=='Milan Starline'?$data['bazar_name']='Dhaka Starline':$data['bazar_name']=$data['bazar_name'];
            ?>
                <div class="bazar"> <!-- class StarBZ  is removed-->
                    <a href="<?=base_url().'b53e70fa24904d94988757105672a5e0/'.$data['id'].'/'.$data['bazar_name'].$tUrl?>"> 
                            <img src="<?=base_url().'assets/'.$imgF.'/'.$data['icon']?>" alt="">
                            <h3 class="text-center "><?=$data['bazar_name']?></h3> <!--class starLabel is removed h3 replaced by span-->
                    </a>
                </div>
            <?php
                }
            ?>     
            <div class="clrBoth"></div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>