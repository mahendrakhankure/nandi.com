    <input type="hidden" name="PartnerId" value="<?=$_SESSION['partner']?>" id="PartnerId">
    <input type="hidden" name="myBalance" value="<?=$_SESSION['balance']?>" id="myBalance">
    <input type="hidden" name="CustomerID" value="<?=$_SESSION['customer_id']?>" id="CustomerID">
    <input type="hidden" name="userName" value="<?=$_SESSION['userName']?>" id="userName">
    <input type="hidden" name="endPointUrl" value="<?=$_SESSION['end_point_url']?>" id="endPointUrl">
    <input type="hidden" name="userAppCurrency" value="<?=$_GET['app']?>" id="userAppCurrency">
    <input type="hidden" name="minMaxBetLimit" value="<?=$minMax?>" id="minMaxBetLimit">
    <!-- Bootstrap JavaScript File -->
    <script src="<?php echo base_url(); ?>assets/dist/js/bootstrap/bootstrap.min.js"></script>
   <!-- <script src="<?php echo base_url(); ?>assets/dist/js/bootstrap/bootstrap.min.js.map"></script> -->

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script> -->
    
     <!-- Custom JavaScript Files -->
    <script src="<?php echo base_url(); ?>assets/js/my_functions.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/page.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/page-irfan.js"></script> duplicate of page.js file -->
    <script type="text/javascript">
        if (window.ReactNativeWebView) {
            $('#bc-arrow').hide();
        }
        $(document).on("contextmenu", function (e) {
            e.preventDefault();
        });
        var newBFUrl = '';
        var bST = 0;
        var urlPath = window.location.pathname;
        if(urlPath=='/'){
            $('.bc-arrow').hide();
        }
        var checkUrl = window.location.href;
        if(checkUrl.includes("&lt") || checkUrl.includes("%3C") || checkUrl.includes("%3E") || checkUrl.includes("{") || checkUrl.includes("}") || checkUrl.includes("(") || checkUrl.includes(")")){
            window.location.href = "<?=base_url();?>404_override";
        }
        var k = checkUrl.split("?");
        if(urlPath.includes("/9a27a7e97c16a7b3ac6382d21205357f/") || k[0]=='http://localhost'){
            $(".serchDv").show();
        }
        // function isNumber(evt) {
        //     evt = (evt) ? evt : window.event;
        //     var charCode = (evt.which) ? evt.which : evt.keyCode;
        //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //         return false;
        //     }
        //     return true;
        // }
        // function openNav() {
        //     $("#mySidenav").toggleClass("sideNavHistory");
        // }
        // function maxLengthCheck(object) {
        //     if (object.value.length > object.maxLength)
        //         object.value = object.value.slice(0, object.maxLength)
        // }

    </script>

    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k"
        crossorigin="anonymous"></script>

    <script>

        var socket = io.connect('https://node.dpbosses.live', {
            reconnection: true,           // Enable auto-reconnection
            reconnectionAttempts: 3,      // Try only 3 times
            reconnectionDelay: 1000,      // 1 second delay between attempts
            timeout: 20000                // Connection timeout
        });
        
        socket.on("<?=$_SESSION['customer_id']?>", function (data) {
            var url = $('#endPointUrl').val();
            var customer_id = $('#CustomerID').val();
            resetAll();
            $('#pBet').show();
            $('#chiplistNew').removeAttr('disabled');
            $('#allPattiSelect').removeAttr('disabled');
            $('#totalBetAmount').text('0');
            if(data.status=="W"){
                $.ajax({
                    type: "POST",
                    url: base_url+"/00e3219d7bca5968d8f7b24854070195",
                    data: {url:url,customer_id:customer_id},
                    success: function (res) {
                        var data = jQuery.parseJSON(res);
                        if(data['code']==200){
                            $('#myBalance').val(data['balance']);
                            $('#CustomerAmount').text(data['balance']);
                        }
                    }
                });
            }
        });
        socket.on('error', function () { console.error(arguments) });
        socket.on('message', function () { console.log(arguments) });
        socket.on('resultdeclare', function (d) {
            var res = d.data;
            // console.log(res)
            if(res.market=='Regular'){
                if(res.bazarID==$('#bazarIdFR').val()){
                    $('.res-digit-no').text(res.result);
                }
            }else if (res.market=='Worli') {
                if($('.last5res').find('div').last().text()!=res.patti+''+res.akda){
                    $('.last5res').find('div').first().remove();
                    var ap = '<div>'+res.patti+'<br>'+res.akda+'</div>';
                    $(".last5res").last().append(ap);
                }

                $('#totalBetAmount').text('0');
                $(res.resultStatus).each(function(w){
                    if(res.resultStatus[w].id=="<?=$_SESSION['customer_id']?>"){
                        var oB = $('#CustomerAmount').text();
                        var nB = parseInt(oB)+parseInt(res.resultStatus[w].winning_point);
                        $('#CustomerAmount').empty();
                        $('#CustomerAmount').append(nB.toFixed(2));
                        $('#myBalance').val(nB.toFixed(2));
                        $('#popUpWin').text(res.resultStatus[w].winning_point);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                    }
                });
            }else if (window.location.href.indexOf(res.url) > -1) {
                if(res.type=='Open'){
                    $('#random-num').text(res.result);
                }else{
                    $('#random-num').text($('#random-num').text()+res.result);
                }
            }else if (res.market=='redTable') {
                $('#totalBetAmount').text('0');
                $(res.resultStatus).each(function(w){
                    if(res.resultStatus[w].id=="<?=$_SESSION['customer_id']?>"){
                        var oB = $('#CustomerAmount').text();
                        var nB = parseInt(oB)+parseInt(res.resultStatus[w].winning_point);
                        $('#CustomerAmount').empty();
                        $('#CustomerAmount').append(nB);
                        $('#myBalance').val(nB);
                        $('#popUpWin').text(res.resultStatus[w].winning_point);
                        $('.my-popup-outer').show(0).delay(10000).hide(0);
                    }
                });
            }else if (res.market=='ForBuffer') {
                if(res.status=='0'){
                    $('#iFrameWin').css('opacity','0');
                    var img = '<img src="'+base_url+'/assets/images/buffer.png" style="width: 100% !important;height: 303.75px;">';
                    $('#streming').empty();
                    $('#streming').append(img);
                }else{
                    // var img = '<span><i class="fa-solid fa-message"></i></span><iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-1" title="Live Satta Result" id="iFrameWin"></iframe>';
                    var img = '<span><i class="fa-solid fa-message"></i></span><iframe src="https://buyphotography.online/?nocache" title="Live Satta Result" class="test" id="iFrameWin"></iframe>';
                    $('#streming').empty();
                    $('#streming').append(img);
                }
            }else if (res.market=='BufferForRegular') {
                var bId = "<?=@$param['bazar_id']?>";
                if(bId.length<0){
                    bId = '0';
                }
                if(res.status=='0'){
                    if(bId==res.bazar_id){
                        $('#stremingGif').remove();
                        $('#streming1').empty();
                        var vi = '<div class="col-12" id="divVideo"><video width="400" id="videoID" muted autoplay playsinline poster="../../assets/images/buffer.png" autobuffer="true"><source src="" type="video/mp4"></source><img src="../../assets/images/buffer.png" title="Your browser does not support the live streaming" /></video></div>';
                        $('#streming1').append(vi);
                        newBFUrl = res.vUrl;
                        var dT = res.startTime.split(" ");
                        var tm = dT[1].split(":");
                        var hS1 = (parseInt(tm[0])*60)*60;
                        var mS1 = parseInt(tm[1])*60;
                        var s1 = parseInt(tm[2]);
                        var bufferStartTime = hS1+mS1+s1;
                        bST = bufferStartTime;
                        var d = new Date();
                        var hS = (d.getHours()*60)*60;
                        var mS = d.getMinutes()*60;
                        var s = d.getSeconds();
                        var currentTime = hS+mS+s;
                        var vTime = currentTime-bufferStartTime;
                        var $video = $('#divVideo video'),
                        // videoSrc = $('source', $video).attr('src', base_url+'/'+res.vUrl);
                        videoSrc = $('source', $video).attr('src', res.vUrl);
                        console.log(res.vUrl)
                        $video[0].load();
                        $video[0].currentTime = vTime;
                        $video[0].play();
                        $('#iFrameWinRegular').css('opacity','0');
                        // var img = '<img src="'+base_url+'/assets/images/buffer.png" style="width: 100% !important;height: 303.75px;">';
                        // $('#streming1').empty();
                        // $('#streming1').append(img);

                        // var vids = document.querySelectorAll("video");
                        // for (var x = 0; x < vids.length; x++) {
                        //     vids[x].addEventListener('error', function(e) {
                        //         if (this.networkState > 2) {
                        //             this.setAttribute("poster", "http://localhost/assets/images/buffer.png");
                        //         }
                        //     }, true);
                        // }
                    }
                }else{
                    if(bId==parseInt(res.bazar_id)){
                        newBFUrl = '';
                        bST = '';
                        // if($("#stremingGif").html() == '' || $('#stremingGif').length < 0){
                            // var img = '<span><i class="fa-solid fa-message"></i></span><iframe src="https://buyphotography.online/?nocache" title="Live Satta Result" id="iFrameWin"></iframe>';
                            // var img = '<span><i class="fa-solid fa-message"></i></span><iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-2" title="Live Satta Result" id="iFrameWin"></iframe>';
                            var img = '<img src="'+base_url+'/assets/images/buffer.png" style="width: 100% !important;height: 303.75px;">';
                            $('#streming1').empty();
                            $('#streming1').append(img);
                        // }
                    }
                }
            }else if (res.market=='ForBufferBlueTable') {
                console.log(res)
                if(res.status=='0'){
                    $('#iFrameWinRegular').css('opacity','0');
                    var img = '<img src="'+base_url+'/assets/images/buffer.png" style="width: 100% !important;height: 303.75px;">';
                    // $('.stremingBlueTable').empty();
                    // $('.stremingBlueTable').append(img);
                    $('#streming').empty();
                    $('#streming').append(img);
                }else{
                    var img = '<span><i class="fa-solid fa-message"></i></span><iframe src="https://matkaui.livedealersol.com/Video/Video?token=QVbu0naS1M&table=Matka-2" title="Live Satta Result" id="iFrameWin" style="width:100%"></iframe>';
                    // $('.stremingBlueTable').empty();
                    // $('.stremingBlueTable').append(img);
                    $('#streming').empty();
                    $('#streming').append(img);
                }
            }else if (res.market=='spinTheWheel') {
                var str1 = window.location.href; 
                var str2 = "627c9e487ce67279be0ba390dbbf2735";
                if(str1.indexOf(str2) != -1){
                    var time = "<?=$param['bazar_id']?>";
                    var bazar = "<?=$param['bazar']?>";
                    if(res.time==time && res.bazar_name==bazar){
                        startSpinTheWheel(res.akda)
                        $('#spinthewheel').show();
                        var time  = Date($.now());
                        // spinthewheel(res.akda)
                        console.log(res)
                        setTimeout(function(){
                            var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                            var str = $('#spinakda').text();
                            if(!numberRegex.test(str)) {
                                $('#spinakda').text('');
                            }
                            var spinakda = $('#spinakda').text();
                            var sa = spinakda+res.akda;
                            $('#spinakda').text(sa);
                            if(res.result_akda){
                                // $('#spinakda').text(sa+'-'+res.result_akda);
                                $('#spinakda').text(res.result_patti+'-'+res.result_akda);
                            }
                        },10000);
                    }
                }
            }else if (res.market=='jackpotroller') {
                var str1 = window.location.href; 
                var str2 = "9c8f59a017280083c64fbc7e958e590f";
                if(str1.indexOf(str2) != -1){
                    var id = "<?=$bazar_id?>";
                    if(res.bazar_name==id){
                        $('#spinthewheelkingbazar').show();
                        // spinthewheel(res.akda)
                        startSpinKingBazarWheel(res.akda)
                        setTimeout(function(){
                            var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                            var str = $('#spinking').text();
                            if(!numberRegex.test(str)) {
                                $('#spinking').text('');
                            }
                            var spinakda = $('#spinking').text();
                            var sa = spinakda+res.akda;
                            $('#spinking').text(sa);
                            if (typeof variable_name !== 'undefined') {
                                $('#spinking').text(res.result_patti);
                            }
                        },10000);
                    }
                }
            }else if (res.market=='refresh') {
                location.reload();
            }
       	});
        socket.on('disconnect', function(reason) {
            console.log("socket disconnected because => "+reason)
        });
    </script>
</body>
</html>

<script>
    
        $( document ).ready(function() {
            $(".sdown-outer").click(function(){
                var disp = $(this).find(".sddown").css("display");
                // alert("SidNav Inner Links Display : "+disp);
                if(disp == "none")  {
                    $(this).find(".sddown").css("display", "block");
                    $(this).find("i").removeClass('fa-arrow-right');
                    $(this).find("i").addClass('fa-arrow-down');
                } else {
                    $(this).find(".sddown").css("display", "none");
                    $(this).find("i").removeClass('fa-arrow-down');
                    $(this).find("i").addClass('fa-arrow-right');
                }
            });

            $(".user-pic").click(function(){
                var disp = $("#mySidenav").css("display");
                if(disp == "none")  {
                    $("#mySidenav").css("display", "block");
                } else {
                    $("#mySidenav").css("display", "none");
                }
            });
        });


        function refresh(){
            location.reload(true)
        }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $.urlParam = function(name){
	        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }
        if($.urlParam('app')=="PH"){
            const v = $('.walletDV .amt').text();
            var numbers = v.match(/\d+/g); // Extracts numbers
            $('.amt').text(numbers[0]+" PH");
            $('.fa').removeClass("fa-inr").addClass("fa-peso-sign");
        }
        

        var urlToken = "";
        var tokenOfUser = <?php echo (!empty($_GET['token']) ? json_encode($_GET['token']) : '""');?>;
        var idOfUser = <?php echo (!empty($_GET['id']) ? json_encode($_GET['id']) : '""');?>;
        var appOfUser = <?php echo (!empty($_GET['app']) ? json_encode($_GET['app']) : '""');?>;
        var checkUrl = window.location.href;
        if(tokenOfUser.includes("&lt") || tokenOfUser.includes("%3C") || tokenOfUser.includes("%3E") || tokenOfUser.includes("{") || tokenOfUser.includes("}") || tokenOfUser.includes("(") || tokenOfUser.includes(")")){
            window.location.href = "<?=base_url();?>404_override";
        }else if(idOfUser.includes("&lt") || idOfUser.includes("%3C") || idOfUser.includes("%3E") || idOfUser.includes("{") || idOfUser.includes("}") || idOfUser.includes("(") || idOfUser.includes(")")){
            window.location.href = "<?=base_url();?>404_override";
        }else if(appOfUser.includes("&lt") || appOfUser.includes("%3C") || appOfUser.includes("%3E") || appOfUser.includes("{") || appOfUser.includes("}") || appOfUser.includes("(") || appOfUser.includes(")")){
            window.location.href = "<?=base_url();?>404_override";
        }else{
            urlToken = "?token="+tokenOfUser+"&id="+idOfUser+"&app="+appOfUser;
        }
        
        
        if(window.location.href.indexOf("9a27a7e97c16a7b3ac6382d21205357f") > -1 || window.location.href.indexOf("2f7b8019e658ea93b1e4d76ac4c6096f") > -1) {
            $('#regularChart').empty();
           var d = '<div>Regular Bazar History <i class="fa-solid fa-arrow-right"></i></div><ul class="sddown"><li><i class="fa-regular fa-circle"></i><a href="'+base_url+'/349d83014cb89afe429b9745fe2c2a6e/'+'<?=$param['bazar_id']?>/jodiChart/regular'+urlToken+'">Jodi Chart</a></li><li><i class="fa-regular fa-circle"></i><a href="'+base_url+'/349d83014cb89afe429b9745fe2c2a6e/'+'<?=$param['bazar_id']?>/panelChart/regular'+urlToken+'">Panel Chart</a></li></ul>';
           // $('#regularChart').append(d);
        }else if(window.location.href.indexOf("9c8f59a017280083c64fbc7e958e590f") > -1 || window.location.href.indexOf("5bfdc27f43fb4f5d76b0028e908b64a4") > -1){
            $('#kingChart').empty();
            var d = '<div>King Bazar History <i class="fa-solid fa-arrow-right"></i></div><ul class="sddown"><li><i class="fa-regular fa-circle"></i><a href="'+base_url+'/349d83014cb89afe429b9745fe2c2a6e/'+'<?=$param['bazar_id']?>/panelChart/king'+urlToken+'">Jodi Chart</a></li></ul>';
            // $('#kingChart').append(d);
        }else if(window.location.href.indexOf("b53e70fa24904d94988757105672a5e0") > -1 || window.location.href.indexOf("627c9e487ce67279be0ba390dbbf2735") > -1 || window.location.href.indexOf("d04cd65a193d25064eb7375b799adc29") > -1){
            $('#starlineChart').empty();
            var d = '<div>Starline Bazar History <i class="fa-solid fa-arrow-right"></i></div><ul class="sddown"><li><i class="fa-regular fa-circle"></i><a href="'+base_url+'/349d83014cb89afe429b9745fe2c2a6e/'+'<?=$param['bazar_id']?>/panelChart/starline'+urlToken+'">Panel Chart</a></li></ul>';
            // $('#starlineChart').append(d);
        }

        $('#regularChart').empty();
        var d = '<div><a href="'+base_url+'/b8fbf0c6a442d7d8b687cb8585938131'+'">Bhav List</a></div>';
        $('#regularChart').append(d);
    });

   
    const message1 = document.getElementById( 'message-1' )
    const tip1 = document.getElementById( 'tip-1' )
    const messages = [
    'Loading',
    'Loading B',
    'Loading Be',
    'Loading Bet',
    'Loading Bet.',
    'Loading Bet..',
    'Loading Bet...'
    ]
    let i = 0
    function showMessage_1() {
        if ( i == 7 ) { i = 0 }
        message1.textContent = messages[i]
        i++
    }
    // setInterval( showMessage_1, 500 )
</script>