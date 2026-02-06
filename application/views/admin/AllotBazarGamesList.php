<?php 
    include 'includes/header.php';
?>
<script type="text/javascript">

    jQuery(document).ready(function(){

        jQuery('ul.pagination li a').click(function (e) {

            e.preventDefault();            

            var link = jQuery(this).get(0).href;            

            var value = link.substring(link.lastIndexOf('/') + 1);

            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);

            jQuery("#searchList").submit();

        });

    });



    // function deleteGame(gameid) {

    //     if (gameid != '') {

    //         if (confirm('De you want to detete game?')) {

    //           // Save it!

    //           window.location = '<?php echo base_url(); ?>Manage_Globles/deleteGame/'+gameid+'/'+'allot_regular_bazar_game';

    //         } else {

    //           // Do nothing!

    //           console.log('Thing was not saved to the database.');

    //         }

    //     }

    // }

</script>
         <style>
            a {
                padding: 5px;
            }
           
        </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> AllotNew Bazar Games
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-3 text-left">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Matkagames/allotNewBazarGames"><i class="fa fa-plus"></i> Add Clients</a>
                </div>
            </div>
            <div class="col-xs-9 text-right">
                <div class="form-group" id="mysearch">
                        <input type="text" placeholder="Enter Bazar Name" id = "bazarName" name="bazarName" value="<?php echo $searchName; ?>" >
                        <input type="text" placeholder="Enter Game Name" id = "gameName" name="gameName" value="<?php echo $searchName; ?>" >
                        <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" >
                        <button id="submit" onclick="callSearchMGABGL('allot_regular_bazar_game', 'Manage_Matkagames', 'searchResultABGL')"> <i class="fa fa-search"></i>Search </button>
                        <button id="resetall" onload="preventDefault();" onclick="resetAll()"> Reset All </button>
                </div>
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
                    <h3 class="box-title">Client List</h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                    <th>SR#</th>
                    <th>Bazar Name</th>
                    <th>Game Name</th>
                    <th>Sequence</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                <?php
                    if(!empty($matkagameabgl)){
                        $gamesr = 1;
                        foreach($matkagameabgl as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['game_name']; ?></td>
                                <td><?php echo $games['sequence']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Matkagames/allotNewBazarGames/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
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
                    if(!empty($matkagameabgl)){
                        $gamesr = 1;
                        foreach($matkagameabgl as $games){     
                          if($gamesr <= 3)   {
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageMGABGL(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $bazarName;?>", "<?php echo $gameName;?>", "<?php echo $status;?>")'><?php echo $gamesr; ?></span>
                            <?php  
                          }
                          $gamesr++;
                        }  
                    } 
                   
                    if($total_pages > 3) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextMGABGL('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $bazarName;?>', '<?php echo $gameName;?>', '<?php echo $status;?>', 4)">Next</span>
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
 