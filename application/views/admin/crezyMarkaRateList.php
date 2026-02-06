<?php 
    include 'includes/header.php'; 
?>
<style>
    tr th,tr td, {text-align:center;}
</style>

<div class="content-wrapper">
<section class="content-header">
    <div>
    <h1>
        <i class="fa fa-users"></i> Crezy Matka Bhav
        <small></small>
    </h1>
    </div>
</section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table id='userTable' class='display dataTable'>
                  <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Bhav</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <select class="form-control" aria-label="Default select example" id="changeRate">
                                <option value="0" <?=$bhav['bhav']==0?"selected":false;?>>0</option>
                                <option value="1" <?=$bhav['bhav']==1?"selected":false;?>>1</option>
                                <option value="2" <?=$bhav['bhav']==2?"selected":false;?>>2</option>
                                <option value="3" <?=$bhav['bhav']==3?"selected":false;?>>3</option>
                                <option value="4" <?=$bhav['bhav']==4?"selected":false;?>>4</option>
                                <option value="5" <?=$bhav['bhav']==5?"selected":false;?>>5</option>
                                <option value="6" <?=$bhav['bhav']==6?"selected":false;?>>6</option>
                                <option value="7" <?=$bhav['bhav']==7?"selected":false;?>>7</option>
                                <option value="8" <?=$bhav['bhav']==8?"selected":false;?>>8</option>
                                <option value="9" <?=$bhav['bhav']==9?"selected":false;?>>9</option>
                            </select>
                        </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $('#changeRate').change(function(){
        $.ajax({
            type: "POST",
            url: base_url+"/54b22f50f2014719083912d00c950505",
            data: {
                bhav:$('#changeRate').val()
            },
            success: function (res) {
                var data = jQuery.parseJSON(res);
                alert(data.massage);
            },
            error: function (err){
                alert(err);
            }
        });
    })
</script>