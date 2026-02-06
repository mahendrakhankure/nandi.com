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
            <i class="fa fa-users"></i> Manage Starline Bhav
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
            <a class="btn btn-primary" href="<?php echo base_url(); ?>5799688ce86ca0aeee3a5db6e27dae22/0"><i class="fa fa-plus"></i> Add Starline Bhav</a>
      </div>
    </section>
    <!-- <section class="content">
        <div class="row">
            <div class="col-12 form-group" id="mysearch">
                    <input type="text" placeholder="Enter Bazar Name" id = "bazarName" name="bazarName" value="<?php echo $searchName; ?>" >
                    <input type="text" placeholder="Enter Game Name" id="gameName" name="gameName" value="<?php echo $searchMode; ?>" >
                    <button id="submit" onclick="callSearchSLAB('starline_bhav', 'Manage_Starlinegames', 'searchResultSLAB')"> <i class="fa fa-search"></i>Search </button>
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
                    <h3 class="box-title">Starline Bhav List</h3>
                <div  id="table-wrapper">
                <div class="box-body table-responsive no-padding" id="table-wrapper">
                 <table class="table table-hover">
                <tr>
                <tr>
                        <th>SR#</th>
                        <th>Bazar Name</th>
                        <th>Game Name</th>
                        <th>Bhav</th>
                        <th class="text-center">Actions</th>
                </tr>
                <?php

                    if(!empty($starlinegameslab)){
                        $gamesr = 1;
                        foreach($starlinegameslab as $games){     
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['game_name']; ?></td>
                                <td><?php echo $games['rate']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Starlinegames/addNewBhav/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
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
                    if(!empty($starlinegameslab)){
                        $gamesr = 1;
                        foreach($starlinegameslab as $games){     
                          if($gamesr <= 3)   {
                             
                            ?>
                            <span id="<?php echo $gamesr; ?>" style='cursor: pointer; margin: 0px 10px;' onClick='loadpageSLAB(<?php echo $gamesr;?>, <?php echo $total_records; ?>, "<?php echo $controllerName;?>", "<?php echo $controllerFunction;?>", "<?php echo $tableName;?>", "<?php echo $bazarName;?>", "<?php echo $gameName;?>")'  ><?php echo $gamesr; ?></span>
                            <?php  
                        }
                          $gamesr++;
                        }  
                    }  
                    if($total_pages > 3) {
                        ?>
                        <span id="next" style="cursor: pointer; margin: 0px 10px"  onClick="prevNextSLAB('next', <?php echo $total_records;?>, '<?php echo $controllerName;?>', '<?php echo $controllerFunction;?>', '<?php echo $tableName;?>', '<?php echo $bazarName;?>', '<?php echo $gameName;?>', 4)" >Next</span>
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
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="bazar_name">
                                <option value=''>Search Bazar Name</option>
                                <?php
                                    foreach ($bazarList as $b) {
                                        echo '<option value="'.$b['id'].'">'.$b['bazar_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="game_name">
                                <option value=''>Search Game Name</option>
                                <?php
                                    foreach ($gameList as $b) {
                                        echo '<option value="'.$b['id'].'">'.$b['game_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bazar Name</th>
                      <th>Game Name</th>
                      <th>bhav</th>
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
              'url':'<?=base_url()?>bc81603a6bb850328fa301e58be072ed',
              'data': function(data){
                    data.bazar_name = $('#bazar_name').val();
                    data.game_name = $('#game_name').val();
              }
            },
            'columns': [
                { data: 'id','render':function(data, type, row, meta){
                    return row.sr;
                } },
                { data: 'bazar_name' },
                { data: 'game_name' },
                { data: 'bhav' },
                { data: 'action' ,'render':function(data, type, row, meta){
                    return '<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>5799688ce86ca0aeee3a5db6e27dae22/'+row.id+'" title="Edit"><i class="fa fa-pencil"></i></a>';
                }},
            ]
        });
        $('#bazar_name,#game_name').change(function(){
            userDataTable.draw();
        });
        $('#userTable_filter').hide();

    });
</script>