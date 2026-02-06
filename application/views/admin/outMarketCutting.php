<?php 
    include 'includes/header.php';
    $d1 = isset($_GET['date1'])?$_GET['date1']:date('Y-m-d');
    $d2 = isset($_GET['date2'])?$_GET['date2']:date('Y-m-d');
?>
     <style type="text/css">
        .sanG{
            color:#1a237e;
        }
        .s{
            background-color: #3b9e12;
            color: #fff;
        }
        .d{
            background-color: red;
            color: #fff;
        }
        table{
            font-weight: 600;
        }
        .j{
            
            color: rgb(255, 255, 255);
            background-color: rgb(30, 140, 178);
            padding: 2px 6px;
            border-radius: 10px;
        }
        .patti{
            background-color: red;
            color: #fff;
        }
        hr{
            border-bottom: solid;
        }
        td.bet {
            background-color: red;
            color: #fff;
        }
        td.bet1,td.tBet1,td.amt1{
            background-color: green;
            color: #fff;
        }
        .amt1{
            background-color: green;
            color: #fff;
        }
        
                
        /* Button used to open the contact form - fixed at the bottom of the page */
        #myForm,.open-button{
            display:none;
        }

        .open-button {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 23px;
        right: 28px;
        width: 280px;
        }

        /* The popup form - hidden by default */
        .form-popup {
        display: none;
        position: fixed;
        bottom: 0;
        right: 15px;
        border: 3px solid #f1f1f1;
        z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
        max-width: 300px;
        padding: 10px;
        background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=number] {
        width: 100%;
        padding: 5px;
        margin: 5px 0 10px 0;
        border: none;
        background: #f1f1f1;
        }


        /* Set a style for the submit/login button */
        .form-container .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom:10px;
        opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
        background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
        opacity: 1;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class='col-md-6'>
                <h1>
                    <i class="fa fa-users"></i> Regular Bazar
                </h1>
            </div>
            <div class='col-md-6'>
                <button class="open-button" onclick="openForm()">Cutting</button>
                <div class="form-popup" id="myForm" >
                    <div class="form-container">
                        <label for="akda"><b>Akda%</b></label>
                        <input type="number" placeholder="Enter Akda %" id="akInp" name="akda" required>

                        <label for="jodi"><b>jode%</b></label>
                        <input type="number" placeholder="Enter Jodi %" id="jodiInp" name="jodi" required>
                        <label for="sp"><b>SP</b></label>
                        <input type="number" placeholder="Enter Sp greater than" id="spInp" name="sp" required>

                        <label for="dp"><b>DP</b></label>
                        <input type="number" placeholder="Enter Dp greater than" id="dpInp" name="dp" required>
                        <label for="tp"><b>TP</b></label>
                        <input type="number" placeholder="Enter Tp greater than" id="tpInp" name="tp" required>
                        <button type="submit" class="btn" onclick="changeCuttint(this)">Change</button>
                        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="daterange">Bazar Name</label>
                            <select class="form-control" aria-label="Default select example" id="bazarName">
                                <option value=''>Search Bazar Name</option>
                                <?php
                                    foreach ($bazar as $b) {
                                        echo '<option value="'.$b['id'].'">'.$b['bazar_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bazar_type">Bazar Type</label>
                            <select class="form-control" aria-label="Default select example" id="bazarType">
                                <option value=''>Search Bazar Type</option>
                                <option value='Open'>Open</option>
                                <option value='Close'>Close</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="daterange">Bazar Date</label>
                                <input type="date" class="form-control" name="date" id="resultDate" placeholder="Enter Date's" value="<?=date('Y-m-d')?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" onclick="getCutting()" id="submit">Submit</button>
                        <button type="submit" class="btn btn-primary" onclick="submitCutting()" id="cut" style="float:right; display:none;">Cut</button>
                    </div>
                    <h3 style="text-align:center;"><span id='res0'></span>-<span id='res'></span>-<span id='res1'></span></h3>
                </div>
            </div>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive" style="text-align:center">
                            <tbody>
                                <tr>
                                    <td>Akda<br><span id='pAk'></span></td>
                                    <td>Jodi<br><span id='pJodi'></span></td>
                                    <td>Single Patti<br><span id='pSp'></span></td>
                                    <td>Double Patti<br><span id='pDp'></span></td>
                                    <td>Triple Patti<br><span id='pTp'></span></td>
                                </tr>
                                <tr>
                                    <td id="ak"></td>
                                    <td id="jodi"></td>
                                    <td id="sp"></td>
                                    <td id="dp"></td>
                                    <td id="tp"></td>
                                </tr>
                                <tr>
                                    <td id="akC"></td>
                                    <td id="jodiC"></td>
                                    <td id="spC"></td>
                                    <td id="dpC"></td>
                                    <td id="tpC"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="spB"></div>
                        <div id="dpB"></div>
                        <div id="tpB"></div>
                        <table class="table table-responsive" style="text-align:center">
                            <tbody>
                                <tr id="akdaSep"></tr>
                                <tr id="akdaSep1"></tr>
                            </tbody>
                        </table>
                        <p>Cutting Line Total => <span id="TotalofJodi">0</span></p>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <p>Akda+Jodi Total => <span id="akjodiT"></span></p>
                        <!-- <p>Akda+Jodi Cutting Total => <span id="akjodiT1"></span></p> -->
                    </div>
                    <div class="col-md-6">
                        <p>All Patti Total => <span id="allPattiT"></span></p>
                        <p>All Patti Cutting Total => <span id="allPattiT1"></span></p>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div id="JODI"></div>
        </section>
    </div>
    
    <div class="hidden" style="width:100%; height:100px; visibility:hidden" >
    </div>
<?php include 'includes/footer.php'; ?>
<script>
    function changeCuttint(inp){
        console.log(inp)
        var akInp = $("#akInp").val();
        var jodiInp = $("#jodiInp").val();
        var spInp = $("#spInp").val();
        var dpInp = $("#dpInp").val();
        var tpInp = $("#tpInp").val();
        var bazarInp = $("#bazarName").val();
        if(akInp > 100 || jodiInp > 100){
            alert('Akda % or jodi % should not be greater than 100')
            return false;
        }else{
            $('.flexbox').show();
            $.ajax({
                type: "POST",
                url: base_url+"/1b490b4efaaeab4a7e0185d0c71389b7",
                data: {akInp:akInp,jodiInp:jodiInp,spInp:spInp,dpInp:dpInp,tpInp:tpInp,bazarInp:bazarInp},
                success: function (res) {
                    $('.flexbox').hide();
                    var data = jQuery.parseJSON(res);
                    if(data['status']==200){
                        $("#myForm").hide();
                        getCutting();

                    }else{
                        $('.flexbox').hide();
                        error(data['message']);
                    }
                }
            });
        }
    }
    function openForm() {
        $("#myForm").show();
        $(".open-button").hide();
    }

    function closeForm() {
        $("#myForm").hide();
        $(".open-button").show();
    }

    async function getCutting(){
        if($('#bazarName').val() && $('#bazarType').val()){
            $('.flexbox').show();
            $('#ak').text('');
            $('#jodi').text('');
            $('#sp').text('');
            $('#dp').text('');
            $('#tp').text('');

            
            $('#TotalofJodi').text('0');
            $('#akC').text('');
            $('#jodiC').text('');
            $('#spC').text('');
            $('#dpC').text('');
            $('#tpC').text('');

            $('#spB').empty('');
            $('#dpB').empty('');
            $('#tpB').empty('');
            $('#akdaSep').empty('');
            $('#akdaSep1').empty('');

            $('#JODI').empty('');
            $('#akjodiT').text('');
            $('#allPattiT').text('');

            $.ajax({
                type: "POST",
                url: base_url+"/4f5cc6d9d04718c0705f232595e1ab98",
                data: {bazarId:$('#bazarName').val(),bazarType:$('#bazarType').val(),resultDate:$('#resultDate').val()},
                success: function (res) {
                    var data = jQuery.parseJSON(res);
                    var baz = data.baz;
                    var akP = (100 - baz.cutAk);
                    var jodiP = (100 - baz.cutJodi);
                    var spP = baz.cutSp;
                    var dpP = baz.cutDp;
                    var tpP = baz.cutTp;

                    $(".open-button").show();
                    $('#akInp').val(baz.cutAk);
                    $('#jodiInp').val(baz.cutJodi);
                    $('#spInp').val(spP);
                    $('#dpInp').val(dpP);
                    $('#tpInp').val(tpP);

                    if(data.res!=null){
                        var rO = data.res.open;
                        var rJ = data.res.jodi;
                        var rC = data.res.close;
                        $('#res0').text(rO);
                        $('#res').text(rJ);
                        $('#res1').text(rC);
                    }

                    var akC = data.ak.point - ((data.ak.point / 100) * akP);
                    var jodiC = data.jodi.point - ((data.jodi.point / 100) * jodiP);
                    var spC = 0;
                    var dpC = 0;
                    var tpC = 0;
                    var spDome = '<table class="table table-responsive" style="text-align:center"><tbody><tr>';
                    var dpDome = '<table class="table table-responsive" style="text-align:center"><tbody><tr>';
                    var tpDome = '<table class="table table-responsive" style="text-align:center"><tbody><tr>';
                    var akDome = '';
                    var akDome1 = '';
                    var sT = 0;
                    var l = data.sangam;
                        

                    $(data.spB).each(function(k) {
                        var NV1 = 0;
                        var pA = parseInt(data.spB[k].point);
                        l.forEach(function(item) {
                            var s = item.game.split("-");
                            if($('#bazarType').val()=='Close'){
                                if((s[0]==rO && data.spB[k].game==s[1]) || (s[0]==rJ[0] && data.spB[k].game==s[1])){
                                    if(s[1].length == 3){
                                        NV1 += (item.point*150);
                                    }
                                }
                            }else{
                                if(s[0].length == 3 && s[0]==data.spB[k].game){
                                    NV1 += parseInt(item.point);
                                }
                            }
                        });
                        NV1 = NV1+pA;
                        var sanG = "";
                        if(parseInt(NV1) > parseInt(spP)){
                            if(NV1 > pA){
                                sanG = "<span class='sanG'>#</span>";
                            }
                            spC += parseInt(NV1)-parseInt(spP);
                            spDome += "<td><div class='patti' id='"+data.spB[k].game+"'>"+data.spB[k].game+"</div><div class='amt1' id='"+data.spB[k].game+"amt'>"+sanG+(parseInt(NV1)-parseInt(spP))+"</div></td>";
                            if((sT%10)===0 && sT!=0){
                                spDome += "</tr><tr>";
                            }
                            sT++;
                        }else if((NV1-pA)!=0){
                            sanG = "<span class='sanG'>#</span>";
                            spDome += "<td><div class='patti' id='"+data.spB[k].game+"'>"+data.spB[k].game+"</div><div class='amt1' id='"+data.spB[k].game+"amt'>"+sanG+(NV1-pA)+"</div></td>";
                            if((sT%10)===0 && sT!=0){
                                spDome += "</tr><tr>";
                            }
                            sT++;
                        }
                    });
                    spDome += "</tr></tbody></table>";
                    var dT = 0;
                    $(data.dpB).each(function(k) {
                        var NV1 = 0;
                        var pA = parseInt(data.dpB[k].point);
                        l.forEach(function(item) {
                            var s = item.game.split("-");
                            if($('#bazarType').val()=='Close'){
                                if((s[0]==rO && data.dpB[k].game==s[1]) || (s[0]==rJ[0] && data.dpB[k].game==s[1])){
                                    if(s[1].length == 3){
                                        NV1 += (item.point*70);
                                    }
                                }
                            }else{
                                if(s[0].length == 3 && s[0]==data.dpB[k].game){
                                    NV1 += parseInt(item.point);
                                }
                            }
                        });
                        NV1 = NV1+pA;
                        var sanG = "";
                        if(parseInt(NV1) > parseInt(dpP)){
                            if(NV1 > pA){
                                sanG = "<span class='sanG'>#</span>";
                            }
                            dpC += parseInt(NV1)-parseInt(dpP);
                            dpDome += "<td><div class='patti' id='"+data.dpB[k].game+"'>"+data.dpB[k].game+"</div><div class='amt1' id='"+data.dpB[k].game+"amt'>"+sanG+(parseInt(NV1)-parseInt(dpP))+"</div></td>";
                            if((dT%10)===0 && dT!=0){
                                dpDome += "</tr><tr>";
                            }
                            dT++;
                        }else if(NV1 > 0){

                        }
                    });
                    dpDome += "</tr></tbody></table>";
                    var tT = 0;
                    $(data.tpB).each(function(k) {
                        var NV1 = 0;
                        var pA = parseInt(data.tpB[k].point);
                        l.forEach(function(item) {
                            var s = item.game.split("-");
                            if($('#bazarType').val()=='Close'){
                                if((s[0]==rO && data.tpB[k].game==s[1])|| (s[0]==rJ[0] && data.tpB[k].game==s[1])){
                                    if(s[1].length == 3){
                                        NV1 += (item.point*70);
                                    }
                                }
                            }else{
                                if(s[0].length == 3 && s[0]==data.tpB[k].game){
                                    NV1 += parseInt(item.point);
                                }
                            }
                        });
                        NV1 = NV1+pA;
                        var sanG = "";
                        if(parseInt(data.tpB[k].point) > parseInt(tpP)){
                            if(NV1 > pA){
                                sanG = "<span class='sanG'>#</span>";
                            }
                            tpC += parseInt(NV1)-parseInt(tpP);
                            tpDome += "<td><div class='patti' id='"+data.tpB[k].game+"'>"+data.tpB[k].game+"</div><div class='amt1' id='"+data.tpB[k].game+"amt'>"+sanG+(parseInt(NV1)-parseInt(tpP))+"</div></td>";
                            if((tT%10)===0 && tT!=0){
                                tpDome += "</tr><tr>";
                            }
                            tT++;
                        }
                    });
                    tpDome += "</tr></tbody></table>";
                    $(data.akB).each(function(k) {
                        akDome += "<td><div class='patti'>"+data.akB[k].game+"</div></td>";

                        var NV1 = 0;
                        l.forEach(function(item) {
                            var s = item.game.split("-");
                            if(s[0].length == 1 && $('#bazarType').val()=='Open'){
                                if(s[0]==data.akB[k].game){
                                    NV1 += parseInt(item.point);
                                }
                            }else if(s[1].length == 1 && $('#bazarType').val()=='Close'){
                                if(s[1]==data.akB[k].game && s[0]==rO){
                                    NV1 += (item.point*85);
                                }
                            }
                        });
                        var sanG = "";
                        if(NV1 > 0){
                            sanG = "<span class='sanG'>#</span>";
                        }

                        akDome1 += "<td><div class='amt' id='amt"+data.akB[k].game+"'>"+(parseInt(data.akB[k].point))+"</div><div class='amt0' id='0amtHalf"+data.akB[k].game+"'></div><div class='amt1' id='1amtCut"+data.akB[k].game+"'></div><div class='amt2' id='halfSangamCut"+data.akB[k].game+"'>"+sanG+NV1+"</div></td>";
                    });

                   
                    
                    
                    $('#pAk').text("("+baz.cutAk+"%)");
                    $('#pJodi').text("("+baz.cutJodi+"%)");
                    $('#pSp').text("(Greter Than "+spP+")");
                    $('#pDp').text("(Greter Than "+dpP+")");
                    $('#pTp').text("(Greter Than "+tpP+")");

                    
                    $('#ak').text(data.ak.point);
                    $('#jodi').text(data.jodi.point);
                    $('#sp').text(data.sp.point);
                    $('#dp').text(data.dp.point);
                    $('#tp').text(data.tp.point);

                    $('#akC').text(akC.toFixed(0));
                    $('#jodiC').text(jodiC.toFixed(0));
                    $('#spC').text(spC);
                    $('#dpC').text(dpC);
                    $('#tpC').text(tpC);

                    $('#spB').append(spDome);
                    $('#dpB').append(dpDome);
                    $('#tpB').append(tpDome);

                    $('#akdaSep').append(akDome);
                    $('#akdaSep1').append(akDome1);

                    // $('#akjodiT').text((parseInt(data.ak.point)+parseInt(data.jodi.point)));
                    $('#allPattiT').text((parseInt(data.sp.point || 0)+parseInt(data.dp.point || 0)+parseInt(data.tp.point || 0)));
                    // $('#allPattiT').text((parseInt(data.sp.point)+parseInt(data.dp.point)+parseInt(data.tp.point)));
                    // console.log(data.dp.point)
                    // console.log(data.tp.point)
                    $('#cut').show();
                    $('.flexbox').hide();

                    
                    $('#allPattiT1').text(spC+dpC+tpC);
                    $('#akjodiT1').text((akC+jodiC));
                    var pr = 0;
                    if($('#bazarType').val()=='Open'){
                        pr = {jodiP,akP};
                    }else{
                        pr = {jodiP,akP};
                    }
                    getTabDataCutting(pr,$('#resultDate').val(),$('#resultDate').val(),$('#bazarName').val(),$('#bazarType').val(),'JODI','-','-','-');
                    setTimeout(function(){
                        if($('#bazarType').val()=='Open'){
                            $('#akjodiT').text((parseInt(data.ak.point)+parseInt(data.jodi.point)));
                        }else{
                            $('#akjodiT').text((parseInt(data.ak.point)+parseInt($('#jodi').text())));
                        }
                        var cT = 0;
                        for(var i = 0; i < 10; i++){
                            cT += parseInt($('#1amtCut'+i).text()||0);
                        }
                        $('#TotalofJodi').text(cT)
                    }, 2000);
                }
            });
        }else{
            alert('Plz select all feilds');
        }
    }

    // functiion submitCutting(){
    //     alert('Plz select all feilds');
    // }
</script>