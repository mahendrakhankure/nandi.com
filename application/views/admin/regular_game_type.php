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
                <i class="fa fa-users"></i> Manage Game Type
                <small>Add, Edit, Delete</small>
            </h1>
        </div>
        <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>ddfe6e4d6d774310c1034abfdd29c30d/0"><i class="fa fa-plus"></i> Add Game Type</a>
        </div>
    </section>
    <!-- <section class="content">
        <div class="row">
            <div class="col-12 form-group" id="mysearch">
                    <input type="text" placeholder="Enter Game Name" id = "gameName" name="gameName" value="<?php echo $searchName; ?>" >
                    <input type="text" placeholder="Enter Status" id="status" name="status" value="<?php echo $searchMode; ?>" >
                    <button id="submit" onclick="callSearchMGGTL('regular_game_type','Manage_Matkagames', 'searchResultGTL')"> <i class="fa fa-search"></i>Search </button>
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
                    <h3 class="box-title">Game Type List</h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                    <th>SR#</th>
                    <th>Game Name</th>
                    <th>Sequence</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                <?php
                    if(!empty($matkagamegtl)){
                        $gamesr = 1;
                        foreach($matkagamegtl as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['game_name']; ?></td>
                                <td><?php echo $games['sequence']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Matkagames/addNewGameType/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
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
                    if(!empty($matkagamegtl)){
                        $gamesr = 1;
                        foreach($matkagamegtl as $games){     
                          if($gamesr <= 3)   {
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageMGGTL(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $gameName;?>", "<?php echo $gameMode;?>")'  ><?php echo $gamesr; ?></span>
                            <?php  
                          }
                          $gamesr++;
                        }  
                    } 
                   
                    if($total_pages > 3) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextMGGTL('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $gameName;?>', '<?php echo $gameMode;?>', 4)" >Next</span>
                        <?php
                    }     
                    ?>
                     </ul>
                </div>
                </div> 
              </div>
            </div>
        </div>
    </section> -->
    <section class="content">
        <div class="rows">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" aria-label="Default select example" id="game_name">
                                    <option value=''>Search Bazar Name</option>
                                    <?php
                                        foreach ($type as $b) {
                                            echo '<option value="'.$b['game_name'].'">'.$b['game_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Game Name</th>
                      <th>Sequence</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        var i = 1;
        var userDataTable = $('#userTable').DataTable({
            "pageLength": 25,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?=base_url()?>495422a2a9c4fef025803d9180abc03b',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
                    data.game_name = $('#game_name').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return row.sr;
                } },
                { data: 'game_name' },
                { data: 'sequence' },
                { data: 'status' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>ddfe6e4d6d774310c1034abfdd29c30d/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });

        $('#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>