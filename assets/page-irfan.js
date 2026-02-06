/*------------------------- Function Public Start --------------------*/
    // var base_url = 'https://'+window.location.host;
    var base_url = 'http://localhost/p1/';
    var coin=0;
    var data=[];
    var dataImgArr=[];
    var coinImg='';
    var arr1=[];
    var totalAmount=0;
    function setCoin(point){
        var previous = coin;
        coin=point;
        coinImg=getCoinImage(point);
        $(function() {
            $("#coin"+previous).find("img").removeClass("active");
            // add class to the one we clicked
            $("#coin"+coin).find("img").addClass("active");
      });
    }
    function getCoinImage(type){
        var arr=Array();
        arr['1']='/assets/images/blankchips01.png';
        arr['5']='/assets/images/blankchips02.png';
        arr['10']='/assets/images/blankchips03.png';
        arr['20']='/assets/images/blankchips04.png';
        arr['50']='/assets/images/blankchips05.png';
        arr['100']='/assets/images/blankchips06.png';
        arr['200']='/assets/images/blankchips07.png';
        arr['500']='/assets/images/blankchips08.png';
        arr['1000']='/assets/images/blankchips09.png';
        return arr[type];
    }
    function undo(type){
        
        if(arr1!=''){
            
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" >'+newVal+'</span>';
                // $("#"+type+arr1[arr1.length-1].akda+"Akda").append(newVal);
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").find('img').remove();
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").find('span').remove();
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").append(newImg);    
            }
            totalAmount=totalAmount-arr1[arr1.length-1].coin;
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            arr1.splice(-1);
        }
         
    }
    function resetAll(){
        /*JodiAll*/
        $('#ent-digit').val('');
        $('#ent-amount').val('');
        $("table tbody .table-body").remove();
        data=[];
        /*SingleDigit*/
        $(".cplace-box").find("span").remove();
        $(".cplace-box").find("img").remove();
        //$(".cplace-box").find("div").remove();
        // $(".centered").text('');
        arr1=[];
        totalAmount=0;
        coinImg='';
        coin = '';
        $(".coin").find("img").removeClass("active");
        $("#totalAmount").text('');
        $("#totalAmount").append(totalAmount);
        $("#totalBet").append(totalAmount);
    }
    function deleteFromList(r,page){
        if(data.length>0){
            if(r.toString().length < 2)
                r= "0"+r;
            $("#totalAmount").text(parseInt($("#totalAmount").text()-parseInt($($("table tbody #"+r)).closest('tr').find('td:nth-child(2)').text())));
            $('#totalBet').text(parseInt($('#totalBet').text())-1);
            if(page=='/choicePana/'){
                var newData = [];
                $(data).each(function(i) {
                    if(Number(data[i]['akda'])!=r){
                        newData.push(data[i])
                    }
                });
                data=[];
                data=newData;
                $("table tbody #"+r).remove();
            }else{
                $("table tbody #"+r).remove();
                data.splice(data.indexOf(r.toString()),1);
            }
        }
    }
/*------------------------- Function Public End --------------------*/

/*------------------------ Page Singale Digit Start ------------------*/
    function placeBet(bazar_id,type_id){
        var totalA = 0;
        var t = $("input[type='radio'][name='gt-radio']:checked").val();
        if(arr1!=''){
            var newData = arr1;
            result = arr1.reduce((a, c) => {
              let found = a.find(el => el.akda === c.akda);
              if (found) {
                found.coin += c.coin;
                totalA += c.coin;
              } else {
                a.push(c);
                totalA += c.coin;
              }
              return a;
            }, []);
            var json = {
                games:result,
                bazar_name:bazar_id,
                game_name:type_id,
                game_type:t,
                result_date:$('#date').val(),
                totalAmount:totalA,
            }
        }else{
            var newData = data;
            var table = Array();
            $("table tr").each(function(i, v){
                table[i] = {};
                $(this).children('td').each(function(ii, vv){
                    if(ii==0){
                        table[i].akda = $(this).text();
                    }else if(ii==1){
                        totalA += parseInt($(this).text());
                        table[i].coin = $(this).text();
                    }else if(ii==2){
                        table[i].game_type = $(this).text();
                    }
                }); 
            });
            var json = {
                games:table,
                bazar_name:bazar_id,
                game_name:type_id,
                game_type:t,
                result_date:$('#date').val(),
                totalAmount:totalA,
            }
        }
        if($('#CustomerID').val()=='' || $('#PartnerId').val()=='' || $('#date').val()==''){
            error('Please Login First');
        }else if(newData.length<0){
            error('Please Select The Bet');
        }else if (parseInt($('#myBalance').val()) < totalA){
            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Waller!');
        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
            error('Please Login First!');
        }else{
            
            $.ajax({
                type: "POST",
                url: base_url+"/RegularMarket/PlaceBets",
                data: json,
                success: function (res) {
                    var data = jQuery.parseJSON(res);
                    if(data['code']==203){
                        error(data['message']);
                    }else{
                        success(data['message']);
                        $('#myBalance').val(data['balance']);
                        $('#CustomerAmount').text(data['balance']);
                    }
                    resetAll();
                }
            });
        }
    }

   
     

    function addCoinSingleDigit(akda,page){
      
        var variable = $("input[type='radio'][name='gt-radio']:checked").val();
        if(typeof(variable) == "undefined"  && variable == null && !(page == "RedBracket" || page == "HalfRed"  || page == 'PrimeJodi' )){ //  && variable == null && page == 'SingleDigit'
            error('Lavde Open Close Select Kar');
        }else if(coin!=0 && (page == 'SinglePatti' || page == 'DoublePatti' || page == 'TriplePatti'  || page == 'SingleAkda' || page == 'SingleDigit' || page == "RedBracket" || page == "HalfRed" || page == 'PrimeJodi' || page == 'FavouritePana' || page == '52PanaChart' || page == '56PanaChart' || page == '77Pana9CutChart' || page == 'AllFigureHalfRedPana' ||  page == 'LinePanaChart' || page == 'NonFavouritePana' || page == 'TouchChipkePana' || page == 'UntouchBhikrePana')){
            var addC = $("#"+page+akda+"Akda").text();
            if(parseInt(akda)<10 && page == 'TriplePatti')  {
                akda = '00'+akda;
                console.log("I am in and updated akda is"+akda);
            }
            
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#"+page+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda"   >'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Abe Coin To Select Kar Be');
        }
    } 
/*------------------------ Page Singale Digit End ------------------*/
/*------------------------ Page Jodi All Start ------------------*/

    function getGameTypePatti(event){
        var dome ='';
        if(event=='All'){
            for(var i = 0; i < 100; i++){
                if(i<10){
                    i='0'+i;
                }
                dome = dome+'<div class="cplace" onclick="addCoinJodiAll('+i+')"><span>'+i+'</span><div class="cplace-box"><span id="Jodi'+i+'Akda-wrapper" class="text-center"></span></div></div>';
            } 
        }else{
            var response = GetOddEvenJodi(event);
            $(response['data']).each(function(i) {
                var r = response['data'][i];
                dome = dome+'<div class="cplace" onclick="addCoinJodiAll('+r+')"><span>'+r+'</span><div class="cplace-box"><span id="Jodi'+r+'Akda-wrapper" class="text-center"></span></div></div>';
            });
        }
        $('#getJodiPana').text('');
        resetAll();
        $('#getJodiPana').append(dome);
    }
    function getGameTypePana(event){
            var dome ='';
            var response =  GetOddEven(event);
            $(response['data']).each(function(i) {
                var r = response['data'][i];
                dome = dome+'<div class="cplace" onclick="addEvenOddPana('+r+')"><span>'+r+'</span><div class="cplace-box"><span id="EvenOddPana'+r+'Akda-wrapper" class="text-center"></span></div></div>';
            });
            $('#getEvenOddPana').text('');
            resetAll();
            $('#getEvenOddPana').append(dome);
    }
    function addEvenOddPana(akda){
        if(coin!=0){
            if(akda<10 && $('#typeOfdata').val()!="Choose a Game"){
                akda='00'+akda;
            }
            var addC = $("#EvenOddPana"+akda+"Akda").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#EvenOddPana"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="EvenOddPana'+akda+'Akda"   >'+newVal+'</span>';
            // $("#"+page+akda+"Akda-wrapper").append(valImg);
            $("#EvenOddPana"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
            // // var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda" class="centered">'+newVal+'</span>';
            // var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda"   >'+newVal+'</span>';
            // $("#Jodi"+akda+"Akda-wrapper").append(valImg);
            // // $("#Jodi"+akda+"Akda").append(newVal);
            // arr1.push({akda:akda,coin:coin,img:coinImg});
            // console.log(arr1)
        }else{
            error('Coin To Select Kr Be');
        }
    }

    function addCoinJodiAll(akda){
        if(coin!=0){
            if(akda<10 && $('#typeOfJodi').val()!="Choose a Game"){
                akda='0'+akda;
            }
            var addC = $("#Jodi"+akda+"Akda").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#Jodi"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda"   >'+newVal+'</span>';
            // $("#"+page+akda+"Akda-wrapper").append(valImg);
            $("#Jodi"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
            // // var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda" class="centered">'+newVal+'</span>';
            // var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda"   >'+newVal+'</span>';
            // $("#Jodi"+akda+"Akda-wrapper").append(valImg);
            // // $("#Jodi"+akda+"Akda").append(newVal);
            // arr1.push({akda:akda,coin:coin,img:coinImg});
            // console.log(arr1)
        }else{
            error('Coin To Select Kr Be');
        }
    }
   

    function addCoin(akda, page)  {
        if(coin!=0 && page == 'PrimeJodi' || page == 'HalfRed'){
            var addC = $("#"+page+""+akda+"Akda").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = coin;
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            
        
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#"+page+""+akda+"Akda").text('');
            var valImg='<img src="'+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="centered">'+newVal+'</span>';
            $("#"+page+""+akda+"Akda").append(valImg);
            arr1.push({akda:akda, coin:coin, img:coinImg});
        }else{
            error('Abe Coin To Select Kar Be');
        }
    }

    function placeBetJodiAll(bazar_id,type_id){
        if(arr1.length>0){
            result = arr1.reduce((a, c) => {
              let found = a.find(el => el.akda === c.akda);
              if (found) {
                found.coin += c.coin;
              } else {
                a.push(c);
              }
              return a;
            }, []);
            var data = {
                games:result,
                bazar:bazar_id,
                game_type:type_id
            }
           
        }else{
            error('Please Select The Bet');
        }
    }
/*------------------------ Page Jodi All End ------------------*/
/*------------------------ Page Tow Digit Pannel Start ------------------*/
    function addBets(page){
        var type = $('input[name="gt-radio"]:checked').val();
        if(page=='towDigitPannel' || page=='SPMotor' || page=='DPMotor'){
            var akda = $('#ent-digit').val();
            var ak = 'Akda';
        }else{
            var akda = $('#left').val()+$('#middle').val()+$('#right').val();
            var gameType = [];
            $('input[name="check"]:checked').each(function() {
                gameType.push($(this).val());
            });
            var ak = 'SP/DP/TP';
            
        }
        var point = $('#ent-amount').val();
        var date = $('#date').val();
        if(type=='' || type==null && akda=='' && point==''){
            error('Please All Feilds');
        }else if(akda=='' && point==''){
            error('Please Akda Open/Close And Akda');
        }else if(point==''){
            error('Please Select Amount');
        }else if(akda==''){
            error('Please Select '+ak);
        }else if(type=='' || type==null){
            error('Please Select Open/Close');
        }else{
            
            var dome = '';
            var tP = $('#totalAmount').text();
            var tB = $('#totalBet').text();
            if(page=='towDigitPannel'){
                if(akda.length != 2)    {
                    error('Digit Length must be 2');
                }
                var response = towDigitPannel(akda);
                $(response['data']).each(function(i) {
                     
                    var r = response['data'][i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td><td>'+type+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/towDigitPannel/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
            }else if(page=='SPMotor' || page == 'DPMotor'){
                if($('#game-name').text()=='DP Motor'){
                    var g = 'DP';
                }else{
                    var g = 'SP';
                }
                 
                var response = GetMotarPatti(akda,g);
                
                $(response['data']).each(function(i) {
                    
                    var r = response['data'][i];
                     
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td><td>'+type+'</td><td>'+r+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/motarSpDp/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
            }else if(page=='ABR100' || page=='ABRCut'){
                if(page=='ABR 100'){
                    var response = abr100();
                }else{
                    var response = abrCut();
                }
                 
                $(response).each(function(i) {
                    var r = response[i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td><td>'+type+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/'+page+'/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
             }
             
            else{
                var response = checkPannaType(gameType,akda);
                $(response).each(function(i) {
                    var r = response[i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r['akda']+'"  class="table-body"><td>'+r['akda']+'</td><td>'+point+'</td><td>'+type+'</td><td>'+r['type']+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r['akda']+',/'+page+'/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
            }
            $("table tbody").append(dome);
            $('#ent-digit').val('');
            $('#ent-amount').val('');
            $('#totalAmount').text(tP);
            $('#totalBet').text(tB);
        
        }

    }
    function addBetsJodiCount(page){
         
        var akda = $('#ent-digit').val();
        var ak = 'Akda';
        var point = $('#ent-amount').val();
        var date = $('#date').val();
        if(akda=='' && point==''){
            error('Please enter digits and amount');
        }else if(point==''){
            error('Please Select Amount');
        }else if(akda==''){
            error('Please Select '+ak);
        }else{
            var dome = '';
            var tP = $('#totalAmount').text();
            var tB = $('#totalBet').text();
            if(page =='JodiCount'){
                var response = getJodiCount(akda);
                $(response['data']).each(function(i) {
                     
                    var r = response['data'][i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/towDigitPannel/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
            }
            $("table tbody").append(dome);
            $('#ent-digit').val('');
            $('#ent-amount').val('');
            $('#totalAmount').text(tP);
            $('#totalBet').text(tB);
        }
    }
    function addBetsTable(page){
        if(page == 'DigitBasedJodi'){
            var leftValue = $('#left').val();
            var rightValue = $('#right').val();
            var arrName;
            var akda;
            var type = page;
            if(leftValue == '' ){
                arrName = "right";
                akda = rightValue;
            } else  if(rightValue =='')   {
                arrName = "left";
                akda = leftValue;  
            } else {
                error('Unknow Error. Check and try again');
            }
            var point = $('#ent-amount').val(); 
            betAmount = point;
            var ak = 'akda';
            if(akda=='' && point=='')   {
                error('Please fill all the fields');
            }else if(akda==''){
                error('Please Select Digits');
            }else if(betAmount==''){
                error('Please enter betting amount');
            }
            else {
                var dome = '';
                var tP = $('#totalAmount').text();
                var tB = $('#totalBet').text();
                if(page=='DigitBasedJodi'){
                    var response = loadDigitBasedJodi(akda, arrName);
                    $(response).each(function(i) {
                        var r = response[i];
                        if(data.indexOf(r)==-1){
                            dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td id="r-point">'+point+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/DigitBasedJodi/)"></i></td></tr>';
                            data.push(r);
                            tP=parseInt(tP)+parseInt(point);
                            tB=parseInt(tB)+1;
                        }
                    });

                    $("table tbody").append(dome);
                    $('#ent-digit').val('');
                    $('#ent-amount').val('');
                    $('#totalAmount').text(tP);
                    $('#totalBet').text(tB);
                }
            }
             
        }
         
         
    }

    function addBetsPana(page){
        var type = $('input[name="gt-radio"]:checked').val();
        var akda = $('input[name="ent-digit"]').val();
        var amount = $('input[name="ent-amount"]').val();
        var point = parseInt(amount);
        var ak = 'Akda';
        var date = $('#date').val();
        
        if(type=='' || type==null && akda =='' ||  akda==null &&  amount == '' || amount == null){
            error('Please All Feilds');
        }else if(type=='' || type==null){
            error('Please Select Open/Close');
        }else{
            var tP = $('#totalAmount').text();
            var tB = $('#totalBet').text();
            if(page=='PanaDiffrence'){
                    var dome = '';
                    var response = getPanaDifference(akda);
                    $(response).each(function(i) {
                        var r = response[i];
                        if(data.indexOf(r)==-1){
                            dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td> <td class="point">'+point+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/pannaDifference/)"></i></td></tr>';
                            data.push(r);
                            tP=parseInt(tP)+parseInt(point);
                            tB=parseInt(tB)+1;
                        }
                    });
                    $("table tbody").append(dome);
                    $('#ent-digit').val('');
                    $('#ent-amount').val('');

            }else if(page == 'PanaFamilySP' || page == 'PanaFamilyDP'){
                 
                var dome = ''; 
                if(akda.length<3)   {
                    error('Digit Length Must be 3');
                }else {
                    var response = getPanaFamily(akda);
                if(response['status'] == 0) {
                    error('This digit is not available');
                }else {
                    $(response['data']).each(function(i) {
                        var r = response['data'][i];
                        if(data.indexOf(r)==-1){
                            dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td> <td class="point">'+point+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/panaFamily/)"></i></td></tr>';
                            data.push(r);
                            tP=parseInt(tP)+parseInt(point);
                            tB=parseInt(tB)+1;
                        }
                    });
                    
                    $("table tbody").append(dome);
                    $('#ent-digit').val('');
                    $('#ent-amount').val('');
                }
                }
                 
            }
        }
        $('#totalAmount').text(tP);
        $('#totalBet').text(tB); 
    }
/*------------------------ Page Tow Digit Pannel End ------------------*/
/*------------------------ Page Group Jodi Start ------------------*/

    function addJodiBets(page){
        var point = $('#ent-amount').val();
        var akda = $('#ent-digit').val();
        var date = $('#date').val();
        if(point==''){
            error('Please Select Amount');
        }else if(akda==''){
            error('Jodi Must Be 2 Digit');
        }else{
            var dome = '';
            var tP = $('#totalAmount').text();
            var tB = $('#totalBet').text();
            if(page=='GroupJodi'){
                var response = GroupJodi(akda);
                $(response['data']).each(function(i) {
                    var r = response['data'][i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/towDigitPannel/)"></i></td></tr>';
                        data.push(r);
                        tP=parseInt(tP)+parseInt(point);
                        tB=parseInt(tB)+1;
                    }
                });
            }else{
                // var response = checkPannaType(gameType,akda);
                // $(response).each(function(i) {
                //     var r = response[i];
                //     if(data.indexOf(r)==-1){
                //         dome = dome+'<tr style="height: 25px;" id="'+r['akda']+'"  class="table-body"><td>'+r['akda']+'</td><td>'+point+'</td><td>'+type+'</td><td>'+r['type']+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r['akda']+',/choicePana/)"></i></td></tr>';
                //         data.push(r);
                //         tP=parseInt(tP)+parseInt(point);
                //         tB=parseInt(tB)+1;
                //     }
                // });
            }
            $("table tbody").append(dome);
            $('#ent-digit').val('');
            $('#ent-amount').val('');
            $('#totalAmount').text(tP);
            $('#totalBet').text(tB);
        }
    }
/*------------------------ Page Group Jodi End ------------------*/