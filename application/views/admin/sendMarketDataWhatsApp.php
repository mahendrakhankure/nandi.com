<?php include 'includes/header.php';
?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="form-group">
                        <label for="bazarName">Bazar Name</label>
                        <select class="form-control" id="bazarName" name="bazar_name">
                            <option value="">Select Bazar Name...</option>
                            <?php foreach ($bazar as $b) { ?>
                                <option value="<?php echo $b['id']; ?>"><?= $b['bazar_name']; ?></option>
                            <?php } ?>    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bazarType">Bazar Type</label>
                        <select class="form-control" id="bazarType" name="bazar_type">
                            <option value="">Select Bazar Type...</option>
                            <option value="Open">Open</option> 
                            <option value="Close">Close</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <span class="btn btn-primary m-2" id="sendMarketData">Submit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $('#sendMarketData').click(function(){
        var bN = $('#bazarName').val();
        var bT = $('#bazarType').val();
        if(bN=='' || bT==''){
            alert('Please select bazar name and bazar type');
        }else{
            $('.flexbox').show()
            $.ajax({
                type: "GET",
                url: base_url+"/d52fd43f65ca5d07612f11904e8919cf/"+bN+"/"+bT,
                success: function (res) {
                    $('.flexbox').hide()
                    var nR = JSON.parse(res);
                    console.log(nR)
                    if(nR.sent){
                        alert(nR.message);
                    }else{
                        alert(nR.message)
                    }
                }
            });
        }
    })   
</script>