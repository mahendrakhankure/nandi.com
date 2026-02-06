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


 

</script>
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
            <i class="fa fa-users"></i> Manage Clients
            <small>Add, Edit, Delete</small>
        </h1>
      </div>
      <div class="form-group add-button">
          <a class="btn btn-primary" href="<?php echo base_url(); ?>534deb2130b02322d84f24d0e7af5c55/0"><i class="fa fa-plus"></i> Add Clients</a>
      </div>
    </section>
    <section class="content">
         
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

                    <h3 class="box-title">Clients List</h3>

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

                        <th>Client Name</th>

                        <th>Mobile</th>

                        <th>Alternative Mobile</th>

                        <th>Domain</th>

                        <th>Ip Address</th>

                        <th>Country</th>

                        <th>State</th>

                        <th>Currency</th>

                        <th>Currency Rate</th>

                        <th>Percentage</th>

                        <th>End Point Url</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Update</th>

                        <th class="text-center">Actions</th>

                    </tr>

                    <?php

                    if(!empty($clients)){

                        $gamesr = 1;

                        foreach($clients as $adminguessing){
                            
                    ?>

                            <tr>

                                <td><?php echo $gamesr; ?></td>

                                <td width="12%"><?php echo $adminguessing['client_name']; ?></td>
                                <td width="10%"><?php echo $adminguessing['mobile']; ?></td>
                                <td width="10%"><?php echo $adminguessing['alternate_mobile']; ?></td>
                                <td width="10%"><?php echo $adminguessing['domain']; ?></td>
                                <td width="10%"><?php echo $adminguessing['ip_address']; ?></td>
                                <td width="10%"><?php echo $adminguessing['country']; ?></td>
                                <td width="10%"><?php echo $adminguessing['state']; ?></td>
                                <td width="10%"><?php echo $adminguessing['currency']; ?></td>
                                <td width="10%"><?php echo $adminguessing['currancy_rate']; ?></td>
                                <td width="10%"><?php echo $adminguessing['percentage']; ?></td>
                                <td width="10%"><?php echo $adminguessing['end_point_url']; ?></td>
                                <td width="10%"><?php echo $adminguessing['status']; ?></td>
                                <td width="10%"><?php echo $adminguessing['created']; ?></td>
                                <td width="10%"><?php echo $adminguessing['updated']; ?></td>

                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>534deb2130b02322d84f24d0e7af5c55/<?php echo $adminguessing['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                    
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

<?php include 'includes/footer.php'; ?>