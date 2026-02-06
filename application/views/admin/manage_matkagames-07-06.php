<?php 
    include 'includes/header.php'; 
    // print_r($matkagame);die();
?>
<style>
a {
    padding: 5px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Matka Games
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Manage_Matkagames/addNewGame"><i class="fa fa-plus"></i> Add Game</a>
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
                    <h3 class="box-title">Regular Bazar List</h3>
                    <!-- <div class="box-tools">
                        <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div> -->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>SR#</th>
                        <th>Game</th>
                        <th>Start Time</th>
                        <th>End TIme</th>
                        <th>Priority</th>
                        <th>Days In Week</th>
                        <th>Result Mode</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($matkagame)){

                        
                        $gamesr = 1;
                        foreach($matkagame as $games){
                            
                    ?>
                            <tr>
                                <td><?php echo $gamesr; ?></td>
                                <td><?php echo $games['bazar_name']; ?></td>
                                <td><?php echo $games['open_time']; ?></td>
                                <td><?php echo $games['close_time']; ?></td>
                                <td><?php echo $games['sequence']; ?></td>
                                <td><?php echo $games['days']; ?></td>
                                <td><?php echo $games['status']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>Manage_Matkagames" title="view"><i class="fa fa-history"></i></a> | 

                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>Manage_Matkagames/addNewGame/<?php echo $games['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>

                                    <a class="btn btn-sm btn-danger deleteUser" href="javascript:void(0);" onclick="deleteGame('<?php echo $games['id']; ?>');" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php $gamesr++;
                        }
                        
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
					<?php 
						//echo $this->pagination->create_links(); 
						$str_links = $this->pagination->create_links();
						$links = explode('&nbsp;',$str_links );
						//print_r($links);die;
					?>
					<ul class="pagination pull-right">
					  <?php 
					  foreach ($links as $link) {
						echo "<span>". $link."</span>";
					  } 
					  ?>
					</ul>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
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

    function deleteGame(gameid) {
        if (gameid != '') {
            if (confirm('De you want to detete game?')) {
              // Save it!
              window.location = '<?php echo base_url(); ?>Manage_Matkagames/deleteGame/'+gameid+'/'+'regular_bazar';
            } else {
              // Do nothing!
              console.log('Thing was not saved to the database.');
            }
        }
    }
</script>


<?php include 'includes/footer.php'; ?>