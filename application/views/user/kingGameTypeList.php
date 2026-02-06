<?php 
    include 'includes/header.php'; 
?>
<!-- Application Heading -->
<div class="container">
    <div class="row">
        <div class="col-12 app-heading">
            <h3 class="heading">
               <?=$gameDetail['bazar_name']?> 
            </h3>
        </div>
    </div>
</div>

<!-- Game Variation Days -->
<div class="container-fluid">
    <div class="rows"><div class="col-12 gv-days dark">
        <div class="days">
            <h3> 
                <span>Sun </span> 
                <span>Mon </span>
                <span>Tue </span>
                <span>Wed </span>
                <span>Thu </span>
                <Span>Fri </Span>
                <span>Sat </span>
            </h3>
        </div>
    </div></div>
</div>
<!-- Game Variation Result and Time duration -->
<div class="container gv-wrapper" >
    <div class="row">
        <div class="col-12">  
                <h3 class="text-center Res"><?=$result?></h3>
        </div>
            <div class="open text-center"><h3 class="text-center"><?=$gameDetail['time']?> </h3></div>
   

        
    </div>
</div>

<div class="container-fluid">
    <div class="rows"><div class="col-12 gv-days dark">
        <div class="days">
            <h3> BID ON SINGLE DIGIT </h3>
        </div>
    </div></div>
</div>



<!-- All Games List -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="gamelist kingList">
                <a href="<?=base_url().'d04cd65a193d25064eb7375b799adc29/'.$gameDetail['id'].'/first'?>">
                    <div class="game">
                        <img src="/assets/images/tab3.png" alt="">
                        <p>First Digit (Ekai)</p>
                    </div>
                </a>
                <a href="<?=base_url().'d04cd65a193d25064eb7375b799adc29/'.$gameDetail['id'].'/secound'?>">
                    <div class="game">
                        <img src="/assets/images/tab3.png" alt="">
                        <p>Second Digit (Haruf)</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="rows"><div class="col-12 gv-days dark">
        <a href="<?=base_url().'d04cd65a193d25064eb7375b799adc29/'.$data['id'].'/jodi'?>">
            <div class="days">
                <h3> BID ON JODI </h3>
            </div>
        </a>
    </div></div>
</div>

<!-- All Games List -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="gamelist kingList">
                   <div class="game">
                    <img src="/assets/images/tab15.png" alt="">
                    <p>JODI</p>
                </div>
                
            </div>
        </div>
    </div>
</div>
    
<?php include 'includes/footer.php'; ?>