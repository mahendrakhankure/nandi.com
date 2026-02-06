 <?php 
    include 'includes/header.php'; 
 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">   
          <h1>
              <i class="fa fa-users"></i> Regular Bazar Bet List
          </h1>
      </div>
    </section>
    <section class="content">
        <div class="row">
           
            <div class="col-xs-12">
                <div class="form-group" id="mysearch">
                    <input type="text" placeholder="Enter Transaction Id" id = "transactionId" name="transactionId" value="<?php echo $searchName; ?>" >
                    <input type="text" placeholder="Enter Customer Id" id="customerId" name="customerId" value="<?php echo $searchMode; ?>" >
                    <input list="bazarname"  onkeyup="searchDataList('client/ClientPanel', 'searchDataList', 'regular_bazar', 'bazar_name', $(this).val(), 'bazarname')" type="text" placeholder="Enter Bazar Name" id="bazarName" name="bazarName" value="<?php echo $searchMode; ?>" >
                     <datalist id="bazarname">
                         
                    </datalist>

                    <input list="gamename" onkeyup="searchDataList('client/ClientPanel', 'searchDataList', 'regular_game_type', 'game_name', $(this).val(), 'gamename');" type="text" placeholder="Enter Game Name" id="gameName" name="gameName" value="<?php echo $searchMode; ?>" >
                     <datalist id="gamename">
                         
                    </datalist>
                   

                    <input type="date" placeholder="Enter Result Date" id="resultDate" name="resultDate" value="<?php echo $searchMode; ?>" >
                    <input type="text" placeholder="Enter Game Type" id="gameType" name="gameType" value="<?php echo $searchMode; ?>" >
                   <!--  <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" > -->

                    <select name="status" id="status">
                          <option value="">Select Status</option>
                          <option value="P">Pending</option>
                          <option value="W">Win</option>
                          <option value="L">Loose</option>
                          <option value="V">Void</option>   
                    </select>
                    <button id="submit" onload="preventDefault();"  onclick="callSearchRB('regular_bazar_games', 'client/ClientPanel', 'searchResultRB');"> <i class="fa fa-search"></i> Search </button>

                    <div style="margin-top:25px; margin-left: auto">
                        <button  id="resetall" onload="preventDefault();"  onclick="resetAll('regular_bazar_games', 'client/ClientPanel', 'searchResultRB');"> Reset All </button>
                    </div>
                </div>
            </div>

        </div>

 

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Regular Bazar List</h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                <tr>
                    <th>SR#</th>
                    <th>Transaction Id</th>
                    <th>Customer Id</th>
                    <th>Bazar Name</th>
                    <th>Game Name</th>
                    <th>Game Type</th>
                    <th>Result Date</th>
                    <th>Game</th>
                    <th>Point</th>
                    <th>Status</th>
                    <th>Winning Point</th>
                </tr>
                <?php
                    // print_r($regularbazar[0])
                    if(!empty($regularbazar)){
                        $gamesr = 1;
                        foreach($regularbazar as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['transaction_id']; ?></td>
                                <td><?php echo $games['customer_id']; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['game_name']; ?></td>
                                 <td><?php echo $games['game_type']; ?></td>
                                <td><?php echo $games['result_date']; ?></td>
                                <td><?php echo $games['game']; ?></td>
                                <td><?php echo $games['point']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td><?php  ?></td>
                                 
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
                            if(!empty($regularbazar)){
                                $gamesr = 1;

                                foreach($regularbazar as $games){     
                                  if($gamesr <= 3)   {
                                    ?>
                                    <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageRB(<?php echo $gamesr;?>, "<?php echo $total_records; ?>", "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", <?php echo json_encode($fields)?>)'  ><?php echo $gamesr;?></span>
                                    <?php  
                                  }
                                  $gamesr++;
                                }  
                            }  
                            
                            if($total_pages > 3) {
                                ?>
                                <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick='prevNextRB("next", "<?php echo $total_records;?>", "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", <?php echo json_encode($fields);?>, 4)'>Next</span>
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


  