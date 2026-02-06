<?php 
    include 'includes/header.php';
?>
    <style type="text/css">
        #iFrameWin{
            width: 100%;
            height: 100vh;
        }
    </style>
        <!-- Batting Name, Batting Notes, Batting Date with Video Link -->
        <div class="batt-name select-wrapper" id="panel"></div> 
    <?php 
          include 'includes/footer.php'; 
    ?>
     
    <script>
        $(document).ready(function(){
            if('<?=$market?>'=='regular'){
                if('<?=$type?>'=='panelChart'){
                    var chartJodi = getUrlDpBoss('<?=$id?>','Regular','panelChart');
                }else if('<?=$type?>'=='jodiChart'){
                    var chartJodi = getUrlDpBoss('<?=$id?>','Regular','jodiChart');
                }
            }else if('<?=$market?>'=='starline'){
                var chartJodi = getUrlDpBoss('<?=$id?>','Starline','jodiChart');
            }else if('<?=$market?>'=='king'){
                var chartJodi = getUrlDpBoss('<?=$id?>','Kingbazar','jodiChart');
            }
            var dome = '<div style="position:relative;"><iframe src="'+chartJodi+'" title="Live Satta Result" id="iFrameWin"></iframe></div>';
            // $().append(dome);
            $("#panel").empty();
            $("#panel").append(dome);
        });
    </script>