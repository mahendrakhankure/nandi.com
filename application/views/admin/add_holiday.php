<?php 

    include 'includes/header.php'; 

?>



<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <i class="fa fa-users"></i> Holidays

        <small>Add / Edit Holiday</small>

      </h1>

    </section>

    

    <section class="content">

    

        <div class="row">

            <!-- left column -->

            <div class="col-md-8">

              <!-- general form elements -->

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title">Enter Holiday Details</h3>

                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form  role="form" id="addUser" action="<?php echo base_url(); ?>762a1c6be55b9a89fceffe61a6666aa3/<?php echo $holiday['id']; ?>" method="post" role="form">

                    <div class="box-body">

                        <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="massage">Massage</label>
                                <input type="text" class="form-control required" id="massage" value="<?php echo $holiday['massage']; ?>" name="massage"  required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="market_type">Select Market Type</label>
                                <select class="form-control" id="market_type" name="market_type" required>
                                    <!-- <option value="">Select Market Type...</option> -->
                                    <option value="Regular">Regular</option>
                                    <option value="Starline">Starline</option>
                                    <option value="King">King</option> 
                                </select>
                            </div>
                        </div>
                        
                             

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bazar_name">Select Bazar Name</label>
                                <select class="form-control" id="bazar_name" name="bazar_name" required>
                                    <option value="">Select Bazar...</option>
                                     
                                </select>

                            </div>
                        </div>


                        <?php 

                            if ($holiday['date'] != '') {
                                $currdate = $holiday['date'];
                            }else{
                            $currdate = date('Y-m-d'); 
                            }

                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Select Date</label>
                                <input type="date" class="form-control required" value="<?php echo $currdate; ?>" id="date" name="date" required>
                            </div>
                        </div>

                        </div>

                         

                    </div>

                    <div class="box-footer">

                        <input type="submit" class="btn btn-primary" value="Submit" />

                        <input type="reset" class="btn btn-default" value="Reset" />

                    </div>



                    </form>

                </div>

            </div>

            <div class="col-md-4">

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

    </section>

    

</div>

<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>



<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $( document ).ready(function() {
        var marketName = $('#market_type :selected').val();
        var gameList = '';
        var gameListId = '';
        var dome = '';
        const regular = ["BHOOTNATH MORNING", "TIME SYNDICATE", "MORNING MADHURI","MAIN SRIDEVI", "DHANLAXMI DAY", "BALAJI DAY", "TIME BAZAR", "MADHURI DAY", "MORNING SYNDICATE", "KAMDHENU", "MILAN DAY", "MAIN RATAN DAY", "KALYAN","JANTA DAY","MAIN SRIDEVI NIGHT","DISAWAR NIGHT","SYNDICATE NIGHT","BALAJI NIGHT","MADHURI NIGHT","BHOOTNATH NIGHT","MILAN NIGHT", "RAJDHANI NIGHT","MAIN BAZAR","MAIN RATAN","MAIN MUMBAI","MORNING SYNDICATE NIGHT","TIME KALYAN","DHANLAXMI NIGHT","MAIN BAZAR DAY","KALYAN NIGHT"];
        const regularId = ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '68', '69', '70', '73'];
        gameList = regular;
        gameListId = regularId;
        
        dome ='<option value="">Select Bazar</option>';
        for(var i=0; i<gameList.length; i++)    {
            dome = dome+'<option value="'+gameListId[i]+'">'+gameList[i]+'</option>';
        }
        $('#bazar_name').find('option').remove().end().append(dome);
    });
    $(document).on("change","#market_type", function() {
        var marketName = $('#market_type :selected').val();
        var gameList = '';
        var gameListId = '';
        var dome = '';
        const regular = ["BHOOTNATH MORNING", "TIME SYNDICATE", "MORNING MADHURI","MAIN SRIDEVI", "DHANLAXMI DAY", "BALAJI DAY", "TIME BAZAR", "MADHURI DAY", "MORNING SYNDICATE", "KAMDHENU", "MILAN DAY", "MAIN RATAN DAY", "KALYAN","JANTA DAY","MAIN SRIDEVI NIGHT","DISAWAR NIGHT","SYNDICATE NIGHT","BALAJI NIGHT","MADHURI NIGHT","BHOOTNATH NIGHT","MILAN NIGHT", "RAJDHANI NIGHT","MAIN BAZAR","MAIN RATAN","MAIN MUMBAI","MORNING SYNDICATE NIGHT","TIME KALYAN","DHANLAXMI NIGHT","MAIN BAZAR DAY","KALYAN NIGHT"];
        const regularId = ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '68', '69', '70', '73'];
        const starline = ["Kalyan Star Line", "Milan Starline", "Dubai Starline"];
        const starlineId = ['1', '2','3'];
        const king = ["Balaji", "DISAWAR", "JANTA", "METRO", "GALI GOLD", "KALYAN GOLD", "FARIDABAD", "DISAWAR GOLD", "GHAZIABAD", "RAJDHANI GOLD", "KUBER", "GALI", "DHANLAXMI", "MUMBAI"];
        const kingId = ['2', '3','4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'];
        if(marketName == 'Regular')  {
            gameList = regular;
            gameListId = regularId;
        }else if(marketName == 'Starline'){
            gameList = starline;
            gameListId = starlineId;
        }else if(marketName == 'King'){
            gameList = king;
            gameListId = kingId;
        }
        dome ='<option value="">Select Bazar</option>';
        for(var i=0; i<gameList.length; i++)    {
            dome = dome+'<option value="'+gameListId[i]+'">'+gameList[i]+'</option>';
        }
        $('#bazar_name').find('option').remove().end().append(dome);
    });
</script>