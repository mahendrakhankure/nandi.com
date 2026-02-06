<?php include 'includes/header.php';
?>
<style type="text/css">
    .switch {
      position: relative;
      display: inline-block;
      vertical-align: top;
      width: 56px;
      height: 20px;
      padding: 3px;
      background-color: white;
      border-radius: 18px;
      box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
      cursor: pointer;
      background-image: -webkit-linear-gradient(top, #eeeeee, white 25px);
      background-image: -moz-linear-gradient(top, #eeeeee, white 25px);
      background-image: -o-linear-gradient(top, #eeeeee, white 25px);
      background-image: linear-gradient(to bottom, #eeeeee, white 25px);
    }

    .switch-input {
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
    }

    .switch-label {
      position: relative;
      display: block;
      height: inherit;
      font-size: 10px;
      text-transform: uppercase;
      background: #eceeef;
      border-radius: inherit;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
      -webkit-transition: 0.15s ease-out;
      -moz-transition: 0.15s ease-out;
      -o-transition: 0.15s ease-out;
      transition: 0.15s ease-out;
      -webkit-transition-property: opacity background;
      -moz-transition-property: opacity background;
      -o-transition-property: opacity background;
      transition-property: opacity background;
    }
    .switch-label:before, .switch-label:after {
      position: absolute;
      top: 50%;
      margin-top: -.5em;
      line-height: 1;
      -webkit-transition: inherit;
      -moz-transition: inherit;
      -o-transition: inherit;
      transition: inherit;
    }
    .switch-label:before {
      content: attr(data-off);
      right: 11px;
      color: #aaa;
      text-shadow: 0 1px rgba(255, 255, 255, 0.5);
    }
    .switch-label:after {
      content: attr(data-on);
      left: 11px;
      color: white;
      text-shadow: 0 1px rgba(0, 0, 0, 0.2);
      opacity: 0;
    }
    .switch-input:checked ~ .switch-label {
      background: #47a8d8;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
    }
    .switch-input:checked ~ .switch-label:before {
      opacity: 0;
    }
    .switch-input:checked ~ .switch-label:after {
      opacity: 1;
    }

    .switch-handle {
      position: absolute;
      top: 4px;
      left: 4px;
      width: 18px;
      height: 18px;
      background: white;
      border-radius: 10px;
      box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
      background-image: -webkit-linear-gradient(top, white 40%, #f0f0f0);
      background-image: -moz-linear-gradient(top, white 40%, #f0f0f0);
      background-image: -o-linear-gradient(top, white 40%, #f0f0f0);
      background-image: linear-gradient(to bottom, white 40%, #f0f0f0);
      -webkit-transition: left 0.15s ease-out;
      -moz-transition: left 0.15s ease-out;
      -o-transition: left 0.15s ease-out;
      transition: left 0.15s ease-out;
    }
    .switch-handle:before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -6px 0 0 -6px;
      width: 12px;
      height: 12px;
      background: #f9f9f9;
      border-radius: 6px;
      box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
      background-image: -webkit-linear-gradient(top, #eeeeee, white);
      background-image: -moz-linear-gradient(top, #eeeeee, white);
      background-image: -o-linear-gradient(top, #eeeeee, white);
      background-image: linear-gradient(to bottom, #eeeeee, white);
    }
    .switch-input:checked ~ .switch-handle {
      left: 40px;
      box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
    }

    .switch-green > .switch-input:checked ~ .switch-label {
      background: #4fb845;
    }
    #streming iframe {
        height: 400px;
        width: 90%;
    }
    
</style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 promo-video" id="streming">
                    <span><i class="fa-solid fa-message"></i></span>
                    <iframe src="https://buyphotography.online/?nocache" title="Live Satta Result" id="iFrameWin"></iframe>
                </div>
                <div class="col-md-4">
                    <?php 
                        if($round['round']==0){
                            echo '<label class="switch">
                            <input type="checkbox" class="switch-input" id="roundStatus">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>';
                        }else{
                            echo '<label class="switch">
                            <input type="checkbox" checked class="switch-input" id="roundStatus">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                          </label>';
                        }
                    ?>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="res" placeholder="Result"/>
                        <input type="text" readonly="true" class="form-control" value="<?=$round['roundId']?>" id="roundId"/>
                        <span class="btn btn-primary m-2" id="resWorli">Submit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="visibilitychange" value="1"/>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    $('#roundStatus').click(function(){
        if($("#roundStatus").is(":checked")){
            var s = '1';
            $('#res').val('');
        }else{
            var s = '0';
        }
        $.ajax({
            type: "POST",
            url: base_url+"/eb1c2c7a0179400c52ba3dceea05037b",
            data: {round:s},
            success: function (res) {
                var r = jQuery.parseJSON( res );
                if($("#roundStatus").is(":checked")){
                  $('#roundId').val(r.roundId);
                }
                
                if(r.status!=200){
                    $('#roundStatus').prop('checked', false);
                }
                alert(r.msg);
            },
            error: function (err) {
                if($("#roundStatus").is(":checked")){
                    $('#roundStatus').prop('checked', false);
                }else{
                    $('#roundStatus').prop('checked', true);
                }
                console.log(err);
                alert(err);
            }
        });
    });
    $('#resWorli').click(function(){
        if($("#roundStatus").is(":checked")==0){
            var r = $('#res').val();
            var gId = $('#roundId').val();
            $.ajax({
                type: "POST",
                url: base_url+"/88c6f52a96587d4580b6301082e68c94",
                data: {res:r,GameId:gId},
                success: function (res) {
                    // var r = jQuery.parseJSON( res );
                    // $('#res').val('');
                    if(r.status==200){
                      $('#res').val('');
                      $('#roundId').val(r.roundId);
                      $('#roundStatus').prop('checked', true);
                    }
                    alert(r.massage);
                },
                error: function(err){
                    console.log(err);
                    alert(err);
                }
            });
        }else{
           alert('Stop Round First.')
        }
    });
    $(document).ready(function() {
        // Function to update the status text
        function updateStatus() {
            if (document.hidden) {
                $('#visibilitychange').val('0');
            } else {
                if($('#visibilitychange').val()=='0'){
                    window.location.reload(true);
                }
            }
        }
        // Check the visibility state when the page loads
        updateStatus();
        // Add an event listener for visibility change
        $(document).on("visibilitychange", function() {
            updateStatus();
        });
    });
</script>