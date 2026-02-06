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
            <i class="fa fa-users"></i> Manage King Bazar Bhav
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Kingbazargames/addNewKingBazarBhav"><i class="fa fa-plus"></i> Add King Bazar Bhav</a>
      </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="form-group" id="mysearch">
                    <input type="text" placeholder="Enter Bazar Name" id = "bazarName" name="bazarName" value="<?php echo $searchName; ?>" >
                    <select id="gameType" name="gameType">
                        <option value="">Select Game Type</option>
                        <option value="1">First Digit(Ekai)</option>
                        <option value="2">Second Digit(Haruf)</option>
                        <option value="3">Jodi</option>  
                    </select>
                    <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" >
                    <button id="submit" onclick="callSearchKBBL('king_bazar_rate', 'Manage_Kingbazargames', 'searchResultKBBL')"> <i class="fa fa-search"></i>Search </button>
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
                        <h3 class="box-title">Bazar List </h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                <tr>
                        <th>SR#</th>
                        <th>Bazar name</th>
                        <th>Game Type</th>
                        <th>Bhav</th>
                        <th>Status</th>
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
                                <td><?php 
                                    if($games['game_type'] == 1)    {
                                        echo "First Digit(Ekai)";
                                    }else if($games['game_type'] == 2)  {
                                        echo "Second Digit(Haruf)"; 
                                    }else if($games['game_type'] == 3)  {
                                        echo "Jodi";
                                    }
                                ?></td>
                                <td><?php echo $games['rate']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Kingbazargames/addNewKingBazarBhav/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
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
                          if($gamesr <= 10 && $gamesr <= $total_pages)   {
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageKBBL(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $gameType;?>",  "<?php echo $bazarName;?>", "<?php echo $status;?>")'  ><?php echo $gamesr; ?></span>
                            <?php  
                        }
                          $gamesr++;
                        }  
                    }  
                    if($total_pages > 10) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextKBBL('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $bazarName;?>',   '<?php echo $gameType;?>', '<?php echo $status;?>', 4)" >Next</span>
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
 