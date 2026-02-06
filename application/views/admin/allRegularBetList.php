<?php 

    include 'includes/header.php'; 

    // print_r($matkagameallresult);

?>

 

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <i class="fa fa-users"></i> Manage Regular Bet List

      </h1>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-xs-4 text-left">
               
            </div>
            <div class="col-xs-8 text-right">
                <div class="form-group" id="mysearch">
                        <input type="text" placeholder="Enter Bazar Name" id = "bazarName" name="bazarName" value="<?php echo $searchName; ?>" >
                        <input type="date" placeholder="Select Date" id="bazarDate" name="bazarDate" value="<?php echo $searchMode; ?>" >
                        <button id="submit" onclick="callSearchMAG('regular_bazar_games','Manage_Matkaallgames', 'searchResult')"> <i class="fa fa-search"></i>Search </button>
                        <button id="resetall" onload="preventDefault();" onclick="resetAll()"> Reset All </button>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <?php

                    $this->load->helper('form');

                    $error = $this->session->flashdata('error');

                    if($error)

                    {

                ?>

                <div class="alert alert-danger alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <?php echo $this->session->flashdata('error'); ?>                    

                </div>

                <?php } ?>

                <?php  

                    $success = $this->session->flashdata('success');

                    if($success)

                    {

                ?>

                <div class="alert alert-success alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <?php echo $this->session->flashdata('success'); ?>

                </div>

                <?php } ?>

                

                <div class="row">

                    <div class="col-md-12">

                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">GameList List</h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                    <th>SR#</th>
                    <th>Transaction Id</th>
                    <th>User Id</th>
                    <th>Bazar Name</th>
                    <th>Game Name</th>
                    <th>Game</th>
                    <th>Result Date</th>
                    <th>Point</th>
                    <th>Status</th>
                    <th>Winning Point</th>
                    <th class="text-center">Actions</th>
                </tr>
                <?php
                    if(!empty($matkaallgame)){
                        $gamesr = 1;
                       
                        foreach($matkaallgame as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['transaction_id']; ?></td>
                                <td><?php echo $games['customer_id']; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['game_name']; ?></td>
                                <td><?php echo $games['game']; ?></td>
                                <td><?php echo $games['result_date']; ?></td>
                                <td><?php echo $games['point']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td><?php echo $games['winning_point']; ?></td>
                                <td class="text-center" style="background-color:#FFF! important;">
                                  
                                </td>
                            </tr>
                    <?php $gamesr++;
                        }  
                    }      
                    ?>                   
                  </table>
                <div>
                <div class="box-footer clearfix" id="pagination">
                     <ul class="pagination pull-right">
                     <?php
                    if(!empty($matkaallgame)){
                        $gamesr = 1;
                        foreach($matkaallgame as $games){     
                          if($gamesr <= 3)   {
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageMAG(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $bazarName;?>", "<?php echo $bazarDate;?>")'  ><?php echo $gamesr; ?></span>
                            <?php  
                          } 
                          $gamesr++;
                        }  
                    } 
                   
                    if($total_pages > 3) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextMAG('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $bazarName;?>', '<?php echo $bazarDate;?>', 4)" >Next</span>
                        <?php
                    }     
                    ?>
                     </ul>
                </div>
                </div> 
              </div>
            </div>
        </div>

    </section>

</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>


<?php include 'includes/footer.php'; ?>
 