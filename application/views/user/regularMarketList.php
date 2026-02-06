<?php 
    include 'includes/header.php'; 
?>
    <style type="text/css">a { color: #ccc; text-decoration: none !important;}a:hover {color: yellow;}</style>

    <div class="container-fluid  " >
        <div class="row p3-game-list-wrapper">
            <?php 
                foreach($marketList as $list){
            ?>
            <div class="col-md-4 col-sm-6">
                <a href="<?php echo base_url();?>9a27a7e97c16a7b3ac6382d21205357f/<?=$list['bazar_id']?>/<?=$list['result']?>">
                    <div class="p3-game-list darkbg">
                        <h2><?=$list['bazar_name'];?></h2>
                        <h3>
                            <?php 
                                if($list['result']!="--"){
                                    echo $list['result'];
                                }else{
                                    echo '***-**-***';
                                }
                            ?>
                        </h3>
                        
                        <p>
                            <?php 
                                if(strtotime($list['close_time'])<=time()){
                                    echo 'Running for tomorrow';
                                }else{
                                    echo 'Running for today';
                                }
                            ?>
                        </p>
                        <div class="p3-open-close-time">
                            <span class="p3-open-time"><?=date('H:i',strtotime(3600-$list['open_time']))?></span>
                            <span class="p3-open-close-bar"></span>
                            <span class="p3-close-time"><?=3600-$list['close_time']?></span>
                        </div>
                    </div> 
                </a>
            </div>
            <?php } ?>
        </div>
    </div>

    
     

    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >

    </div>

<?php include 'includes/footer.php'; ?>