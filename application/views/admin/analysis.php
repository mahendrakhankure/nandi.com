<?php
include 'includes/header.php';
?>
<style>
    .clear {
        clear: both;
    }

    .load-wrapp {
        float: left;
        width: 100px;
        height: 100px;
        margin: 0 10px 10px 0;
        padding: 20px 20px 20px;
        border-radius: 5px;
        text-align: center;
        display:none;
    }

    .load-wrapp p {
        padding: 0 0 20px;
    }
    .load-wrapp:last-child {
        margin-right: 0;
    }
    .ring-1 {
        width: 10px;
        height: 10px;
        margin: 0 auto;
        padding: 10px;
        border: 7px dashed #4b9cdb;
        border-radius: 100%;
    }
    .load-4 .ring-1 {
        animation: loadingD 1.5s 0.3s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
    }

        @keyframes loadingD {
        0 {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="content-wrapper check">
    <section class="content">
        <div class="rows">
            <!-- <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div> -->
            <div class='col-md-12'>
                <div class="load-wrapp" id="loader1">
                    <div class="load-4">
                        <p>Loading All GGR</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="myPlot" style="width:100%;max-width:100%"></div>
            </div>
            <div class='col-md-12'>
                <div class="load-wrapp" id="loader">
                    <div class="load-4">
                        <p>Loading Worli Section</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="regulrPlot" style="width:100%;max-width:100%"></div>
            </div>
            <div class='col-md-12'>
                <div class="load-wrapp" id="loader2">
                    <div class="load-4">
                        <p>Loading Regular Section</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="graph" style="width:100%;max-width:100%"></div>
            </div>
        </div>
        <div class="rows">
            <div class='col-md-12'>
                <div class="load-wrapp" id="loader3">
                    <div class="load-4">
                        <p>Loading 4</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="starlinePlot" style="width:100%;max-width:100%"></div>
            </div>
            <div class='col-md-12'>
                <div class="load-wrapp" id="loader1">
                    <div class="load-4">
                        <p>Loading All GGR</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="kingPlot" style="width:100%;max-width:100%"></div>
            </div>

            <!-- <div class='col-md-12'>
                <div class="load-wrapp" id="loader1">
                    <div class="load-4">
                        <p>Loading Todays Market Shear</p>
                        <div class="ring-1"></div>
                    </div>
                </div>
                <div id="todaysMarketShear" style="width:100%;max-width:100%; height: 390px !important;"></div>
                <input type="text" class="form-control daterange" name="dateRange" id="dateRange" placeholder="Enter Date's" />
            </div> -->
        </div>
    </section>
</div>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/graphs.js"></script>
<script>
    $(document).ready(function() {
        $(".daterangepicker").click(function(){
            marketShear($("#dateRange").val());
        });
    });
    var height = 1000;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= height){
            if(height==1000){
                worliMarketGraph('1')
            }else if(height==1400){
                starlineMarketGraph('1');
            }else if(height==1800){
                kingMarketGraph('1');
            }
            // else if(height==2200){
            //     marketShear('1');
            // }
            height = height+400;
        }
    });
</script>
<?php include 'includes/footer.php'; ?>
