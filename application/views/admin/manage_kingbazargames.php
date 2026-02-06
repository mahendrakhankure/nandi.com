<?php 
    include 'includes/header.php'; 
?>
        <style>
            a {
                padding: 5px;
            }
 
        </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div>
        <h1>
            <i class="fa fa-users"></i> Manage KingBazzar Games
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Kingbazarallresult/AddKingBazarResult"><i class="fa fa-plus"></i> Add Result</a>
      </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12 form-group" id="mysearch">
                    <input type="text" placeholder="Enter Game Name" id = "bazarName" name="bazarName" value="<?php echo $searchName; ?>" >
                    <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" >
                    <button id="submit" onclick="callSearchKB('king_bazar', 'Manage_Kingbazargames', 'searchResultKB')"> <i class="fa fa-search"></i>Search </button>
                    <button id="resetall" onload="preventDefault();" onclick="resetAll()"> Reset All </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    // $this->load->helper('form');
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
                        <h3 class="box-title">King Bazar Games List </h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                <tr>
                        <th>SR#</th>
                        <th>Game</th>
                        <th>Start Time</th>
                        <th>Status</th>
                        <th>Winners</th>
                        <th class="text-center">Actions</th>
                </tr>
                <?php

                    if(!empty($kingbazargames)){
                        $gamesr = 1;
                        
                        foreach($kingbazargames as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['time']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td><?php $o = getWinnersKing($games['id']); echo empty($o) ? "" : "<span id='".$games['id']."' class='btn btn-success' onclick='updateWalletKing(".json_encode($o).','.$games['id'].")'>".count($o)."</span>"; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Kingbazargames/addKingBazzarGame/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
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
                    if(!empty($kingbazargames)){
                        $gamesr = 1;
                        foreach($kingbazargames as $games){     
                          if($gamesr < $total_pages)   {
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageKB(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $bazarName;?>", "<?php echo $status;?>")'  ><?php echo $gamesr; ?></span>
                            <?php  
                        }
                          $gamesr++;
                        }  
                    }  
                    if($total_pages > 3) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextKB('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $bazarName;?>','<?php echo $status;?>', 4)" >Next</span>
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
 