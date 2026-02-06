/*------------------------- Function Public Start --------------------*/
    
    // var base_url = 'https://'+window.location.host;
    var base_url = 'http://localhost/p1/';
    var coin=0;
    var data=[];
    var dataImgArr=[];
    var coinImg='';
    var arr1=[];
    var totalAmount=0;
    var rebet=[];
    function setCoin(point){
        // console.log('working'+point)
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
        console.log(arr1)
        if(arr1!=''){
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" class="countNo">'+newVal+'</span>';
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
        // $(".cplace-box span").html('');
        $(".cplace-box").find("span").empty();
        $(".cplace-box").find("img").remove();
        //$(".cplace-box").find("div").remove();
        // $(".centered").text('');
        arr1=[];
        totalAmount=0;
        coinImg='';
        coin = '';
        $(".coin").find("img").removeClass("active");
        $("#totalAmount").text('');
        $("#totalBet").text('');
        $("#totalAmount").append(totalAmount);
        $("#totalBet").append(totalAmount);
    }
    function deleteFromList(r,page){
        console.log(r+'=>'+page)
        if(data.length>0){
            // if((page == '/towDigitPannel/' || page == '/panaFamily/') && r.toString().length < 2){
            //     r= "00"+r;
            // }else if(r.toString().length < 2){
            //     r= "0"+r;
            // }
            if($('#00'+r).length){
                r= "00"+r;
            }
            if($('#0'+r).length){
                r= "0"+r;
            }
            
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
                console.log(r)
                $("table tbody #"+r).remove();
                data.splice(data.indexOf(r.toString()),1);
            }
        }
    }
/*------------------------- Function Public End --------------------*/

/*------------------------ Page Singale Digit Start ------------------*/
    function placeBet(bazar_id,type_id){
        var valBet = 0;
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
            $(result).each(function(t) {
                if(type_id != 5){
                    if((result[t].coin < 5) || (result[t].coin > 9999)){
                        error('Bet on '+result[t].akda+' Should be greter than 5!');
                        valBet = 1;
                    }
                }else{
                    if((result[t].coin < 10) || (result[t].coin > 9999)){
                        error('Bet on '+result[t].akda+' Should be greter than 10!');
                        valBet = 1;
                    }
                }
            });
            
            if(type_id==29){
                $(result).each(function(t) {
                    result[t].akdaType = checkPana(result[t].akda);
                    if(result[t].akdaType=='SP'){
                        result[t].gameName = 29;
                    }else if(result[t].akdaType=='DP'){
                        result[t].gameName = 39;
                    }
                });
            }
            if(type_id==30){
                $(result).each(function(t) {
                    result[t].akdaType = checkPana(result[t].akda);
                    if(result[t].akdaType=='SP'){
                        result[t].gameName = 30;
                    }else if(result[t].akdaType=='DP'){
                        result[t].gameName = 40;
                    }
                });
            }

            if(type_id==24){
                $(result).each(function(t) {
                    result[t].akdaType = checkPana(result[t].akda);
                    if(result[t].akdaType=='SP'){
                        result[t].gameName = 24;
                    }else if(result[t].akdaType=='DP'){
                        result[t].gameName = 43;
                    }
                });
            }

            var json = {
                games:result,
                bazar_name:bazar_id,
                game_name:type_id,
                game_type:t,
                result_date:$('#date').val(),
                totalAmount:totalA,
                customer_id:$('#CustomerID').val(),
                tokenId:$('#TokenId').text(),
            }
        }else{
            var newData = data;
            var table = Array();
            $("table tr").each(function(i, v){
                table[i] = {};
                $(this).children('td').each(function(ii, vv){
                    if(ii==0){
                        table[i].akda = $(this).text();
                        if(type_id==20){    
                            table[i].akdaType = checkPana($(this).text());
                            if(table[i].akdaType=='SP'){
                                table[i].gameName = 20;
                            }else if(table[i].akdaType=='DP'){
                                table[i].gameName = 33;
                            }else if(table[i].akdaType=='TP'){
                                table[i].gameName = 34;
                            }
                        }

                        if(type_id==19){    
                            table[i].akdaType = checkPana($(this).text());
                            if(table[i].akdaType=='SP'){
                                table[i].gameName = 19;
                            }else if(table[i].akdaType=='DP'){
                                table[i].gameName = 37;
                            }else if(table[i].akdaType=='TP'){
                                table[i].gameName = 42;
                            }
                        }

                        if(type_id==18){    
                            table[i].akdaType = checkPana($(this).text());
                            if(table[i].akdaType=='SP'){
                                table[i].gameName = 18;
                            }else if(table[i].akdaType=='DP'){
                                table[i].gameName = 36;
                            }else if(table[i].akdaType=='TP'){
                                table[i].gameName = 40;
                            }
                        }

                        if(type_id==7){    
                            table[i].akdaType = checkPana($(this).text());
                            if(table[i].akdaType=='SP'){
                                table[i].gameName = 7;
                            }else if(table[i].akdaType=='DP'){
                                table[i].gameName = 46;
                            }else if(table[i].akdaType=='TP'){
                                table[i].gameName = 47;
                            }
                        }
                    }else if(ii==1){
                        totalA += parseInt($(this).text());
                        table[i].coin = $(this).text();
                    }else if(ii==2){
                        table[i].game_type = $(this).text();
                    }
                }); 
            });

            $(table).each(function(t) {
                if(type_id!=5){
                    if((table[t].coin<5) || (table[t].coin>9999)){
                        error('Bet on '+table[t].akda+' Should be greter than 5!');
                        valBet = 1;
                        return;
                    }
                }else{
                    if((table[t].coin<10) || (table[t].coin>9999)){
                        error('Bet on '+table[t].akda+' Should be greter than 10!');
                        valBet = 1;
                        return;
                    }
                }
            });
            if(type_id==7){
                t="List";
            }
            var json = {
                games:table,
                bazar_name:bazar_id,
                game_name:type_id,
                game_type:t,
                result_date:$('#date').val(),
                totalAmount:totalA,
                customer_id:$('#CustomerID').val(),
                tokenId:$('#TokenId').text(),
            }
        }
        if($('#CustomerID').val()=='' || $('#PartnerId').val()=='' || $('#date').val()==''){
            error('Please Login First');
        }else if(newData.length<0){
            error('Please Select The Bet');
        }else if (parseInt($('#myBalance').val()) < totalA){
            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
            error('Please Login First!');
        }else{
            // valBet = 1;
            if(valBet!=1){
                $('#pBet').hide();
                $.ajax({
                    type: "POST",
                    url: base_url+"/RegularMarket/PlaceBets",
                    data: json,
                    success: function (res) {
                        var data = jQuery.parseJSON(res);
                        console.log(json)
                        if(data['code']==200){
                            success('Bet Placed Successfully!');
                            $('#myBalance').val(data['balance']);
                            $('#CustomerAmount').text(data['balance']);
                        }else{
                            error(data['message']);
                        }
                        resetAll();
                        $('#pBet').show();
                    }
                });
            }
        }
    }

   
     

    function addCoinSingleDigit(akda,page){
        // alert("working"+coin)
        var variable = $("input[type='radio'][name='gt-radio']:checked").val();
        if(coin!=0 && (page == 'SinglePatti' || page == 'DoublePatti' || page == 'TriplePatti'  || page == 'SingleAkda' || page == 'SingleDigit' || page == "RedBracket" || page == "HalfRed" || page == 'PrimeJodi' || page == 'FavouritePatti' || page == '52PanaChart' || page == '56PanaChart' || page == '77Pana9CutChart' || page == 'AllFigureHalfRedPanaSP' ||  page == 'LinePanaChartSP' || page == 'NonFavouritePana' || page == 'TouchChipkePana' || page == 'UntouchBhikrePana')){
             
            if(parseInt(akda)<10 && page == 'TriplePatti')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == 'RedBracket')  {
                akda = '0'+akda;  
            }
            if(parseInt(akda)<10 && page == 'HalfRed')  {
                akda = '0'+akda;  
            }
            var addC = $("#"+page+akda+"Akda").text();
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
            console.log(arr1)
        }else{
            error('Please Select The Coin');
        }
    } 
/*------------------------ Page Singale Digit End ------------------*/
/*------------------------ Page Jodi All Start ------------------*/

    function getGameTypePatti(event){
        var dome ='<table class="table"><tbody><div class="col-12 cplace-outer"><div class="cplace-wrapper">';
        if(event=='All'){
            var a = [];
            for($i=0;$i<100;$i++){
                a.push(i);
            }
            $(a).each(function(k) {
                console.log(k)
                dome = dome+'<tr>';
                $(k).each(function(i) {
                    if(i<10){
                        i='0'+i;
                    }
                    dome = dome+'<td><div class="cplace place-input-main" onclick="addCoinJodiAll('+i+')"><label class="inputNo">'+i+'</label><div class="cplace-box btInput pos"><div id="Jodi'+i+'Akda-wrapper" class="text-center"></div></div></div><td>';
                });
                dome = dome+'</tr>';
            });
        }else{
            var response = GetOddEvenJodi(event);
            var a = response,chunk

            while (a.length > 0) {
            chunk = a.splice(0,5)
                dome = dome+'<tr>';
                $(chunk).each(function(i) {
                    var r = chunk['data'][i];
                    dome = dome+'<td><div class="cplace place-input-main" onclick="addCoinJodiAll('+r+')"><label class="inputNo">'+r+'</label><div class="cplace-box btInput pos"><div id="Jodi'+r+'Akda-wrapper" class="text-center"></div></div></div><td>';
                });
                dome = dome+'</tr>';
            }
        }
        dome = dome+'</div></div></tbody></table>';
        $('#getJodiPana').text('');
        resetAll();
        $('#getJodiPana').append(dome);
    }
    function getGameTypePana(event){
            var dome ='';
            var response =  GetOddEven(event);
            $(response['data']).each(function(i) {
                var r = response['data'][i];
                dome = dome+'<div class="cplace" style="cursor:pointer;" onclick="addEvenOddPana('+r+')"><span>'+r+'</span><div class="cplace-box"><span id="EvenOddPanaSP'+r+'Akda-wrapper" class="text-center"></span></div></div>';
            });
            $('#getEvenOddPana').text('');
            resetAll();
            $('#getEvenOddPana').append(dome);
            var EvenOddPanaSP = 'EvenOddPanaSP';
            var sAll = '<span class="btn" id="allPattiSelect" onclick="selectAllPattiSingleDigit('+"'"+event+"'"+','+"'EvenOddPanaSP'"+')">Select All Patti</span>';
            $('#sAll').text('');
            $('#sAll').append(sAll);
    }
    function addEvenOddPana(akda){
        if(coin!=0){
            if(akda<10 && $('#typeOfdata').val()!="Choose a Game"){
                akda='00'+akda;
            }
            var addC = $("#EvenOddPanaSP"+akda+"Akda").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#EvenOddPanaSP"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="EvenOddPanaSP'+akda+'Akda"   >'+newVal+'</span>';
            // $("#"+page+akda+"Akda-wrapper").append(valImg);
            $("#EvenOddPanaSP"+akda+"Akda-wrapper").append(valImg);
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="Jodi'+akda+'Akda" class="countNo" >'+newVal+'</span>';
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
            error('Please Select The Coin');
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
            var valImg='<img src="'+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="centered countNo">'+newVal+'</span>';
            $("#"+page+""+akda+"Akda").append(valImg);
            arr1.push({akda:akda, coin:coin, img:coinImg});
        }else{
            error('Please Select The Coin.');
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
    function SPDPDigit(page, value, event)  {
        var flag = 0;
        var x = Array.from(String(value), Number);
    
        var digit = parseInt(event.keyCode)-48;
        if(page == 'SPMotor')   {
            for(var i=0; i<x.length-1; i++)   {
                if(x[i] == digit && digit != value)   {
                    flag = 1;
                    // error("Duplicate digit not allowed");
                    $("#ent-digit").val('');
                    break;
                }
            } 
        }else if(page == 'DPMotor'){
            for(var i=0; i<x.length-1; i++)   {
                if(x[i] == digit && digit != value)   {
                    if(flag == 1)   {
                        // error("A digit is allowed twice only.");
                        $("#ent-digit").val('');
                        break;
                    }else {
                        flag = 1;
                    }  
                }
            }
        }
    }

    function addBets(page){
        var type = $('input[name="gt-radio"]:checked').val();
        if(page=='twoDigitPanel' || page=='SPMotor' || page=='DPMotor'){
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
        if(page == 'twoDigitPanel' && akda.length !=2) {
            error("Enter digit of length 2");
        }
        else if(type=='' || type==null && akda=='' && point==''){
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
            if(page=='twoDigitPanel'){
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
                if(akda.length<4){
                    error('Please Enter Minimum 4 Digit');
                }else{
                    if(window.location.toString().includes("d04cd65a193d25064eb7375b799adc29")){
                        var nt = '';
                    }else{
                        var nt = '<td>'+type+'</td>';
                    }
                    var response = GetMotarPatti(akda,g);
                    $(response['data']).each(function(i) {
                        var r = response['data'][i];
                        if(data.indexOf(r)==-1){
                            dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td><td>'+point+'</td>'+nt+'<td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/motarSpDp/)"></i></td></tr>';
                            data.push(r);
                            tP=parseInt(tP)+parseInt(point);
                            tB=parseInt(tB)+1;
                        }
                    });
                }
            }else if(page=='ABR100' || page=='ABRCut'){
                if(page=='ABR100'){
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
            }else{
                if(page=='choicePana'){
                    var left = $('#left').val();
                    var middle = $('#middle').val();
                    var right = $('#right').val();
                    var response = getChoicePannaPatti(gameType,left,middle,right);
                }else{
                    var response = checkPannaType(gameType,akda);
                }
                if(window.location.toString().includes("d04cd65a193d25064eb7375b799adc29")){
                    var nt = '';
                }else{
                    var nt = '<td>'+type+'</td>';
                }
                $(response).each(function(i) {
                    var r = response[i];
                    if(data.indexOf(r)==-1){
                        dome = dome+'<tr style="height: 25px;" id="'+r['akda']+'"  class="table-body"><td>'+r['akda']+'</td><td>'+point+'</td>'+nt+'<td>'+r['type']+'</td><td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r['akda']+',/'+page+'/)"></i></td></tr>';
                        r['game_type']=type;
                        // arr1.push(r);
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
        if(page == 'JodiCount' && akda.length != 1)  {
            error("Enter digit of length 1");
        }
        else if(akda=='' && point==''){
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
            }else if(betAmount=='' || betAmount<5 || betAmount>999999){
                error('Minimum Bet Accept 5 & Maximum 999999');
            }else {
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
        // alert('working')
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
            if(page == 'PanaDiffrenceSP'){
                 
                    var dome = '';
                    if(akda.length != 1)   {
                        error('Enter digit of length 1');
                    }
                    else {
                        var response = getPanaDifference(akda);
                        console.log(response)
                        $(response).each(function(i) {
                            var r = response[i];
                            if(data.indexOf(r)==-1){
                                dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td> <td class="point">'+point+'</td><td>'+type+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/pannaDifference/)"></i></td></tr>';
                                data.push(r);
                                tP=parseInt(tP)+parseInt(point);
                                tB=parseInt(tB)+1;
                            }
                        });
                        $("table tbody").append(dome);
                        $('#ent-digit').val('');
                        $('#ent-amount').val('');
                    }

            }else if(page == 'PanaFamilySP' || page == 'PanaFamilyDP' || page == 'PanaFamily'){
                 
                var dome = ''; 
                if(akda.length<3)   {
                    error('Enter digit of length 3');
                }else {
                    var response = getPanaFamily(akda);
                if(response['status'] == 0) {
                    error('This digit is not available');
                }else {
                    $(response['data']).each(function(i) {
                        var r = response['data'][i];
                        if(data.indexOf(r)==-1){
                            // alert(r)
                            dome = dome+'<tr style="height: 25px;" id="'+r+'"  class="table-body"><td>'+r+'</td> <td class="point">'+point+'</td><td>'+type+'</td> <td><i class="fa fa-trash" aria-hidden="true" onclick="deleteFromList('+r+',/panaFamily/)"></i></td></tr>';
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
            error('Jodi Must be 2 Digit');
        }else{
            var dome = '';
            var tP = $('#totalAmount').text();
            var tB = $('#totalBet').text();
            if(page=='GroupJodi'){
                if(akda.length != 2)    {
                    error("Jodi must be 2 digit");
                } else {
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
                }
                 
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

/*------------------------ Add Coin Starline Start ------------------*/
    function addCoinStar(akda,page){
        if(coin!=0 && (page == '1' || page == '2' || page == '3'  || page == '4' || page == '13' || page == '14' || page == '15'  || page == '16' || page == '25' || page == '26' || page == '27'  || page == '28')){
            var addC = $("#"+page+akda+"Akda").text();
            if(parseInt(akda)<10 && page == '4' || parseInt(akda)<10 && page == '16' || parseInt(akda)<10 && page == '28')  {
                akda = '00'+akda;  
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin.');
        }
    }


    function placeBetStar(bazar_id,type_id){
        var valBet = 0;
        var totalA = 0;
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
           
           $(result).each(function(t) {
            // alert(type_id)
                if(type_id!='2'){
                    if(result[t].coin<5){
                        error('Bet on '+result[t].akda+' Should be greter than 5!');
                        valBet = 1;
                        return;
                    }
                }else{
                    if(result[t].coin<10){
                        error('Bet on '+result[t].akda+' Should be greter than 10!');
                        valBet = 1;
                        return;
                    }
                }
            });

            var json = {
                games:result,
                bazar_name:bazar_id,
                game_name:type_id,
                result_date:$('#date').val(),
                time:$('#time').val(),
                starTime:$('#starTime').val(),
                totalAmount:totalA,
                customer_id:$('#CustomerID').val(),
                tokenId:$('#TokenId').text(),
            }
        }else if(data!=''){
            var newData = data;
            var table = Array();

            $("table tr").each(function(i, v){
                table[i] = {};
                $(this).children('td').each(function(ii, vv){
                    if(ii==0){
                        table[i].akda = $(this).text();
                        table[i].akdaType = checkPana($(this).text());
                        if(bazar_id==1 && type_id==5){
                            var sp = 5;
                            var dp = 9;
                            var tp = 10;
                        }else if(bazar_id==2 && type_id==5){
                            var sp = 17;
                            var dp = 21;
                            var tp = 22;
                        }else if(bazar_id==3 && type_id==5){
                            var sp = 30;
                            var dp = 34;
                            var tp = 29;
                        }else if(bazar_id==1 && type_id==12){
                            var sp = 12;
                            var dp = 8;
                            var tp = 11;
                        }else if(bazar_id==2 && type_id==12){
                            var sp = 23;
                            var dp = 20;
                            var tp = 24;
                        }else if(bazar_id==3 && type_id==12){
                            var sp = 35;
                            var dp = 33;
                            var tp = 36;
                        }

                        if(table[i].akdaType=='SP'){
                            table[i].gameName = sp;
                        }else if(table[i].akdaType=='DP'){
                            table[i].gameName = dp;
                        }else if(table[i].akdaType=='TP'){
                            table[i].gameName = tp;
                        }
                    }else if(ii==1){
                        totalA += parseInt($(this).text());
                        table[i].coin = $(this).text();
                    }else if(ii==2){
                        table[i].game_type = $(this).text();
                    }
                });
            });

            $(table).each(function(t) {
                if(table[t].coin<5){
                    error('Bet on '+table[t].akda+' Should be greter than 10!');
                    valBet = 1;
                    return;
                }
            });

            var json = {
                games:table,
                bazar_name:bazar_id,
                game_name:type_id,
                result_date:$('#date').val(),
                time:$('#time').val(),
                starTime:$('#starTime').val(),
                totalAmount:totalA,
                customer_id:$('#CustomerID').val(),
                tokenId:$('#TokenId').text(),
            }
        }else{
            error('Please Select The Bet');
        }
        if($('#CustomerID').val()=='' || $('#PartnerId').val()=='' || $('#date').val()==''){
            error('Please Login First');
        }else if (parseInt($('#myBalance').val()) < totalA){
            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
            error('Please Login First!');
        }else{
            if(valBet!=1){
                console.log(json)
                $('#pBet').hide();
                $.ajax({
                    type: "POST",
                    url: base_url+"/36b3c7870f6be4f9ff75cb513bd18f8f",
                    data: json,
                    success: function (res) {
                        var data = jQuery.parseJSON(res);
                        if(data['code']==200){
                            success(data['message']);
                            $('#myBalance').val(data['balance']);
                            $('#CustomerAmount').text(data['balance']);
                        }else{
                            error(data['message']);
                        }
                        resetAll();
                        $('#pBet').show();
                    }
                });
            }
        }
    }

    function undoStar(type){
        if(arr1!=''){
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" >'+newVal+'</span>';
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
/*------------------------ Add Coin Starline End ------------------*/
/*------------------------ Add Coin King Start ------------------*/
    

    function undoKing(type){
        if(arr1!=''){
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" >'+newVal+'</span>';
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

    function addCoinKing(akda,page){
        if(coin!=0){
            if(akda.toString().length == 1 && page == 'Jodi')  {
                akda = '0'+akda;  
            }
            var addC = $("#"+page+akda+"Akda").text();
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
            console.log(arr1)
        }else{
            error('Please Select The Coin');
        }
    } 

    function placeBetKing(bazar_id,type_id){
        var valBet = 0;
        var totalA = 0;
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

            $(result).each(function(t) {
                if(result[t].coin<10){
                    error('Bet on '+result[t].akda+' Should be greter than 10!');
                    valBet = 1;
                    return;
                }
            });

            var json = {
                games:result,
                bazar_name:bazar_id,
                game_name:type_id,
                result_date:$('#date').val(),
                totalAmount:totalA,
                customer_id:$('#CustomerID').val(),
                tokenId:$('#TokenId').text(),
            }
        }else{
            error('Please Select The Bet');
        }
        if($('#CustomerID').val()=='' || $('#PartnerId').val()=='' || $('#date').val()==''){
            error('Please Login First');
        }else if (parseInt($('#myBalance').val()) < totalA){
            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
            error('Please Login First!');
        }else{
            if(valBet!=1){
                $('#pBet').hide();
                $.ajax({
                    type: "POST",
                    url: base_url+"/679a6a3e6bad2fa0fcc51a272283a9d9",
                    data: json,
                    success: function (res) {
                        var data = jQuery.parseJSON(res);
                        if(data['Code']==200){
                            success(data['message']);
                            $('#myBalance').val(data['balance']);
                            $('#CustomerAmount').text(data['balance']);
                        }else{
                            error(data['message']);
                        }
                        resetAll();
                        $('#pBet').show();
                    }
                });
            }
        }
    }
/*------------------------ Add Coin King End ------------------*/


function getUserData(tbl,pID,cID){
    $('#pBet').hide();
    if($('#'+tbl).html()==""){
        $.ajax({
            type: "POST",
            url: base_url+"/3ae43540be62a1c9e3c8a5420a09e07f",
            data: {tbl:tbl,id:cID,partner:pID},
            success: function (res) {
                $('#'+tbl).append(res);
                $('#pBet').show();
            }
        });
    }
}


function selectAllPattiSingleDigit(variation,page){
    var variable = $("input[type='radio'][name='gt-radio']:checked").val();
        if(typeof(variable) == "undefined"  && variable == null && (variation != "StarlinesALL")){ //  && variable == null && page == 'SingleDigit'
            error('Please Select Game Type Open/Close');
        }else if((variation == "StarlinesALL" && coin!=0) || (coin!=0 && (page == 'SinglePatti' || page == 'DoublePatti' || page == 'TriplePatti'  || page == 'SingleAkda' || page == 'SingleDigit' || page == "RedBracket" || page == "HalfRed" || page == 'PrimeJodi' || page == 'FavouritePatti' || page == '52PanaChart' || page == '56PanaChart' || page == '77Pana9CutChart' || page == 'AllFigureHalfRedPanaSP' ||  page == 'LinePanaChartSP' || page == 'NonFavouritePana' || page == 'TouchChipkePana' || page == 'UntouchBhikrePana' || page == 'EvenOddPanaSP' || page == 'Triplepana' || page == 'Jodi'))){
            
            if(page == 'SinglePatti' || page == 'DoublePatti' || page == 'TriplePatti'  || page == 'SingleAkda' || page == 'SingleDigit' || page == 'Triplepana'){
                // var data = getVariationPatti(page);
                var data = getVariationPattiAkdaWise(page);
            }else if(page=="UntouchBhikrePana"){
                var data = untouchBikhrePana();
            }else if(page=="TouchChipkePana"){
                var data = touchChipkePana();
            }else if(page=="NonFavouritePana"){
                var data = nonFavoritePana();
            }else if(page=="AllFigureHalfRedPanaSP"){
                var data = allFigureHalfRedPana();
            }else if(page=="77Pana9CutChart"){
                var data = panaChart77();
            }else if(page=="56PanaChart"){
                var data = panaChart56();
            }else if(page=="52PanaChart"){
                var data = panaChart52();
            }else if(page=="FavouritePatti"){
                var data = favoritePana();
            }else if(page=="LinePanaChartSP"){
                var data = linePanaChart();
            }else if(page=="52PanaChart"){
                var data = panaChart52();
            }else if(page=="FavouritePana"){
                var data = favoritePana();
            }else if(page=="EvenOddPanaSP"){
                var d = GetOddEven(variation);
                var data = d.data;
            }else if(page=="PrimeJodi"){
                var data = primeJodi();
            }else if(page=="RedBracket"){
                var data = redBracket();
            }else if(page=="HalfRed"){
                var data = halfRed();
            }else if(page=="Jodi"){
                var data = [];
                for (var i = 0; i < 100; i++) {
                    if(parseInt(i)<10)  {
                        i = '0'+i;
                    }
                    data.push(i)
                }
            }
            var v = $(location).attr('href').split( '/' ).at(-2);
            $(data).each(function (t){
                var akda = data[t];
                if(parseInt(akda)<10 && page == 'RedBracket' && akda.length==1 )  {
                    akda = '0'+akda;  
                }
                if(parseInt(akda)<10 && page == 'HalfRed' && page.length == 1)  {
                    akda = '0'+akda;  
                }
                var addC = $("#"+page+akda+"Akda").text();
                if(addC!=''){
                    var newVal = parseInt(addC)+parseInt(coin);
                }else{
                    var newVal = parseInt(coin);
                }
                totalAmount = totalAmount+parseInt(coin);

                if(variation == "StarlinesALL"){
                    var nV = $("#"+v+akda+"Akda").text();
                    if(nV){
                        newVal = parseInt(nV)+parseInt(coin);
                    }
                    $("#"+v+akda+"Akda-wrapper").text('');
                    var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+v+akda+'Akda">'+newVal+'</span>';
                    $("#"+v+akda+"Akda-wrapper").append(valImg);
                }else{
                    // alert(akda)
                    $("#"+page+akda+"Akda-wrapper").text('');
                    var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda">'+newVal+'</span>';
                    $("#"+page+akda+"Akda-wrapper").append(valImg);
                }

                arr1.push({akda:akda,coin:coin,img:coinImg});
            });
            console.log(arr1)
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
        }else{
            error('Please Select The Coin');
        }
}


/*------------------------ Instant Worli Bet Start ------------------*/
    function placeBetInstantWorli(){
        // coinImg='';
        // coin = '';
        // $(".coin").find("img").removeClass("active");
        // $('#allPattiSelect').focus();
        // $('#chiplistNew ul').css('display','none');
        alert('on function')
        $.ajax({
            type: "POST",
            url: base_url+"/af8a5002bdaeb9a4d17b8e1676aceca3",
            success: function (r) {
                var nR = jQuery.parseJSON(r);
                var newDate = new Date( nR.cTime );
                var betTimeCheck = (newDate.getTime()/ 1000)+60;
                var d = new Date();
                var currentTime = d.getTime()/ 1000;
                if(betTimeCheck > currentTime){
                    var roundId = nR.roundId;
                    if(roundId!=""){
                        typeId = $('#gameId').text();
                        type_id = $('#gameName').text();
                        var valBet = 0;
                        var totalA = 0;
                        var valBet = 0;
                            var newData = arr1;
                            rebet = arr1;
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
                            $(result).each(function(t) {
                                if((result[t].coin < 5) || (result[t].coin > 9999)){
                                    error('Bet on '+result[t].akda+' Should be greter than 5!');
                                    valBet = 1;
                                }
                            });
                            
                            var json = {
                                games:result,
                                gameId:typeId,
                                game_name:type_id,
                                roundId:roundId,
                                totalAmount:totalA,
                                customer_id:$('#CustomerID').val(),
                                tokenId:$('#TokenId').text(),
                            }
                        
                        if($('#CustomerID').val()=='' || $('#PartnerId').val()==''){
                            error('Please Login First');
                        }else if(newData.length<0){
                            error('Please Select The Bet');
                        }else if (parseInt($('#myBalance').val()) < totalA){
                            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
                        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
                            error('Please Login First!');
                        }else{
                            if(valBet!=1){
                                $('#pBet').hide();
                                $.ajax({
                                    type: "POST",
                                    url: base_url+"/0d8db88c3368c9fe8cfe903ba42c8b13",
                                    data: json,
                                    success: function (res) {
                                        var data = jQuery.parseJSON(res);
                                        console.log(data)
                                        if(data['code']==200){
                                            success(data['message']);
                                            $('#myBalance').val(data['balance']);
                                            $('#CustomerAmount').text(data['balance']);
                                        }else{
                                            error(data['message']);
                                        }
                                        var tA = parseInt($("#totalBetAmount").text())+parseInt($("#totalAmount").text());
                                       
                                        resetAll();
                                        $("#totalBetAmount").text(tA);
                                        $('#pBet').show();
                                    }
                                });
                            }
                        }
                    }

                }else{
                    // error('Please Wait For Five Second!');
                    error('Please Wait For Next Round!');
                }
            }
        });
        // alert('code are commeted!');
    }


    function reBetInstantWorli(){
        $.ajax({
            type: "POST",
            url: base_url+"/af8a5002bdaeb9a4d17b8e1676aceca3",
            success: function (r) {
                var nR = jQuery.parseJSON(r);
                var newDate = new Date( nR.cTime );
                var betTimeCheck = (newDate.getTime()/ 1000)+118;
                var d = new Date();
                var currentTime = d.getTime()/ 1000;
                if(betTimeCheck > currentTime){
                    var roundId = nR.roundId;
                    if(roundId!=""){
                        typeId = $('#gameId').text();
                        type_id = $('#gameName').text();
                        var valBet = 0;
                        var totalA = 0;
                        var valBet = 0;
                            var newData = rebet;
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
                            $(result).each(function(t) {
                                if((result[t].coin < 5) || (result[t].coin > 9999)){
                                    error('Bet on '+result[t].akda+' Should be greter than 5!');
                                    valBet = 1;
                                }
                            });
                            
                            var json = {
                                games:result,
                                gameId:typeId,
                                game_name:type_id,
                                roundId:roundId,
                                totalAmount:totalA,
                                customer_id:$('#CustomerID').val(),
                                tokenId:$('#TokenId').text(),
                            }
                        
                        if($('#CustomerID').val()=='' || $('#PartnerId').val()==''){
                            error('Please Login First');
                        }else if(newData.length<0){
                            error('Please Select The Bet');
                        }else if (parseInt($('#myBalance').val()) < totalA){
                            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
                        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
                            error('Please Login First!');
                        }else{
                            if(valBet!=1){
                                $('#pBet').hide();
                                $.ajax({
                                    type: "POST",
                                    url: base_url+"/0d8db88c3368c9fe8cfe903ba42c8b13",
                                    data: json,
                                    success: function (res) {
                                        var data = jQuery.parseJSON(res);
                                        console.log(data)
                                        if(data['code']==200){
                                            success(data['message']);
                                            $('#myBalance').val(data['balance']);
                                            $('#CustomerAmount').text(data['balance']);
                                        }else{
                                            error(data['message']);
                                        }
                                        var tA = parseInt($("#totalBetAmount").text())+parseInt($("#totalAmount").text());
                                       
                                        resetAll();
                                        $("#totalBetAmount").text(tA);
                                        $('#pBet').show();
                                    }
                                });
                            }
                        }
                    }

                }else{
                    error('Please Wait For Five Second!');
                }
            }
        });
    }

    function repeatCoinInstantWorli(akda,page,cn){
        if(cn!=0){ 
            if(parseInt(akda)<10 && page == '/TriplePatti/')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == '/SinglePatti/')  {
                akda = '0'+akda;  
            }
            var addC = $("#SinglePatti"+akda+"Akda-wrapper").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(cn);
            }else{
                var newVal = parseInt(cn);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(cn);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#SinglePatti"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="SinglePatti'+akda+'Akda">'+newVal+'</span>';
            $("#SinglePatti"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:cn,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    }

    function addCoinInstantWorli(akda,page){
        if(coin!=0){ 
            if(parseInt(akda)<10 && page == '/TriplePatti/')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == '/SinglePatti/')  {
                akda = '0'+akda;  
            }
            var addC = $("#SinglePatti"+akda+"Akda-wrapper").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#SinglePatti"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="SinglePatti'+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#SinglePatti"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    }

    function resetAllInstantWorli(){
        /*JodiAll*/
        $('#ent-digit').val('');
        $('#ent-amount').val('');
        $("table tbody .table-body").remove();
        data=[];
        /*SingleDigit*/
        // $(".cplace-box span").html('');
        $(".cplace-box").find("span").empty();
        $(".cplace-box").find("img").remove();
        //$(".cplace-box").find("div").remove();
        // $(".centered").text('');
        arr1=[];
        totalAmount=0;
        coinImg='';
        coin = '';
        $(".coin").find("img").removeClass("active");
        $("#totalAmount").text('');
        $("#totalBet").text('');
        $("#totalAmount").append(totalAmount);
        $("#totalBet").append(totalAmount);
    } 

    function undoInstantWarli(arr,type){
        console.log(arr1)
        if(arr1!=''){
            
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" >'+newVal+'</span>';
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
/*------------------------  Instant Worli Bet End ------------------*/

/*------------------------ Red Table Bet Start ------------------*/
    function placeBetRedTable(){
        $.ajax({
            type: "POST",
            url: base_url+"/a042e1213a78a8c3b1a657803bbb5d36",
            // url: base_url+"/a042e1213a78a8c3b1a657803bbb5d36",
            success: function (r) {
                console.log(r)
                var nR = jQuery.parseJSON(r);
                var newDate = new Date( nR.cTime );
                var betTimeCheck = (newDate.getTime()/ 1000)+118;
                var d = new Date();
                var currentTime = d.getTime()/ 1000;
                if(betTimeCheck > currentTime){
                    var roundId = nR.roundId;
                    if(roundId!=""){
                        typeId = $('#gameId').text();
                        type_id = $('#gameName').text();
                        var valBet = 0;
                        var totalA = 0;
                        var valBet = 0;
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
                            $(result).each(function(t) {
                                if((result[t].coin < 5) || (result[t].coin > 9999)){
                                    error('Bet on '+result[t].akda+' Should be greter than 5!');
                                    valBet = 1;
                                }
                            });
                            
                            var json = {
                                games:result,
                                gameId:typeId,
                                game_name:type_id,
                                roundId:roundId,
                                totalAmount:totalA,
                                customer_id:$('#CustomerID').val(),
                                tokenId:$('#TokenId').text(),
                            }
                        
                        if($('#CustomerID').val()=='' || $('#PartnerId').val()==''){
                            error('Please Login First');
                        }else if(newData.length<0){
                            error('Please Select The Bet');
                        }else if (parseInt($('#myBalance').val()) < totalA){
                            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
                        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
                            error('Please Login First!');
                        }else{
                            if(valBet!=1){
                                $('#pBet').hide();
                                $.ajax({
                                    type: "POST",
                                    url: base_url+"/77c95faa4fc09d86eb2b83663b42e692",
                                    data: json,
                                    success: function (res) {
                                        var data = jQuery.parseJSON(res);
                                        console.log(data)
                                        if(data['code']==200){
                                            success(data['message']);
                                            $('#myBalance').val(data['balance']);
                                            $('#CustomerAmount').text(data['balance']);
                                        }else{
                                            error(data['message']);
                                        }
                                        var tA = parseInt($("#totalBetAmount").text())+parseInt($("#totalAmount").text());
                                       
                                        resetAll();
                                        $("#totalBetAmount").text(tA);
                                        $('#pBet').show();
                                    }
                                });
                            }
                        }
                    }

                }else{
                    error('Please Wait For Five Second This Is Updated!');
                }
            }
        });
        // alert('code are commeted!');
    }

    function addCoinRedTable(akda,page){
        if(coin!=0){ 
            if(parseInt(akda)<10 && page == '/TriplePatti/')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == '/SinglePatti/')  {
                akda = '0'+akda;  
            }
            var addC = $("#SinglePatti"+akda+"Akda-wrapper").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#SinglePatti"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="SinglePatti'+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#SinglePatti"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    }

    function resetAllRedTable(){
        /*JodiAll*/
        $('#ent-digit').val('');
        $('#ent-amount').val('');
        $("table tbody .table-body").remove();
        data=[];
        /*SingleDigit*/
        // $(".cplace-box span").html('');
        $(".cplace-box").find("span").empty();
        $(".cplace-box").find("img").remove();
        //$(".cplace-box").find("div").remove();
        // $(".centered").text('');
        arr1=[];
        totalAmount=0;
        coinImg='';
        coin = '';
        $(".coin").find("img").removeClass("active");
        $("#totalAmount").text('');
        $("#totalBet").text('');
        $("#totalAmount").append(totalAmount);
        $("#totalBet").append(totalAmount);
    } 

    function undoRedTable(arr,type){
        console.log(arr1)
        if(arr1!=''){
            
            var addC = $("#"+type+arr1[arr1.length-1].akda+"Akda").text();
            var newVal = parseInt(addC)-parseInt(arr1[arr1.length-1].coin);
            $("#"+type+arr1[arr1.length-1].akda+"Akda").text('');
            if(newVal==0){
                $("#"+type+arr1[arr1.length-1].akda+"Akda-wrapper").text('');
            }else{
                var newImg = '<img src="'+base_url+arr1[arr1.length-2].img+'" alt=""><span id="'+type+arr1[arr1.length-1].akda+'Akda" >'+newVal+'</span>';
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
/*------------------------  Red Table Bet End ------------------*/

/*------------------------ Red Table Bet Start ------------------*/
    function placeBetGoldenTable(){
        $.ajax({
            type: "POST",
            url: base_url+"/2f4c93368e9c77d47db4774af504ddfd",
            // url: base_url+"/2f4c93368e9c77d47db4774af504ddfd",
            success: function (r) {
                console.log(r)
                var nR = jQuery.parseJSON(r);
                var newDate = new Date( nR.cTime );
                var betTimeCheck = (newDate.getTime()/ 1000)+118;
                var d = new Date();
                var currentTime = d.getTime()/ 1000;
                if(betTimeCheck > currentTime){
                    var roundId = nR.roundId;
                    if(roundId!=""){
                        typeId = $('#gameId').text();
                        type_id = $('#gameName').text();
                        var valBet = 0;
                        var totalA = 0;
                        var valBet = 0;
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
                            $(result).each(function(t) {
                                if((result[t].coin < 5) || (result[t].coin > 9999)){
                                    error('Bet on '+result[t].akda+' Should be greter than 5!');
                                    valBet = 1;
                                }
                            });
                            
                            var json = {
                                games:result,
                                gameId:typeId,
                                game_name:type_id,
                                roundId:roundId,
                                totalAmount:totalA,
                                customer_id:$('#CustomerID').val(),
                                tokenId:$('#TokenId').text(),
                            }
                        
                        if($('#CustomerID').val()=='' || $('#PartnerId').val()==''){
                            error('Please Login First');
                        }else if(newData.length<0){
                            error('Please Select The Bet');
                        }else if (parseInt($('#myBalance').val()) < totalA){
                            error('Sorry You Dont Have A Sufficent Balance Please Recharge Your Wallet!');
                        }else if($('#myBalance').val() == NaN || $('#myBalance').val()==''){
                            error('Please Login First!');
                        }else{
                            if(valBet!=1){
                                $('#pBet').hide();
                                $.ajax({
                                    type: "POST",
                                    url: base_url+"/40488a2c4347decb77f662843b126dab",
                                    data: json,
                                    success: function (res) {
                                        var data = jQuery.parseJSON(res);
                                        console.log(data)
                                        if(data['code']==200){
                                            success(data['message']);
                                            $('#myBalance').val(data['balance']);
                                            $('#CustomerAmount').text(data['balance']);
                                        }else{
                                            error(data['message']);
                                        }
                                        var tA = parseInt($("#totalBetAmount").text())+parseInt($("#totalAmount").text());
                                       
                                        resetAll();
                                        $("#totalBetAmount").text(tA);
                                        $('#pBet').show();
                                    }
                                });
                            }
                        }
                    }

                }else{
                    error('Please Wait For Five Second This Is Updated!');
                }
            }
        });
    }

    function addCoinGoldenTable(akda,page){
        if(coin!=0){ 
            if(parseInt(akda)<10 && page == '/TriplePatti/')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == '/SinglePatti/')  {
                akda = '0'+akda;  
            }
            var addC = $("#SinglePatti"+akda+"Akda-wrapper").text();
            if(addC!=''){
                var newVal = parseInt(addC)+parseInt(coin);
            }else{
                var newVal = parseInt(coin);
            }
            var tm = $("#totalAmount").text();
            totalAmount = parseInt(tm)+parseInt(coin);
            $("#totalAmount").text('');
            $("#totalAmount").append(totalAmount);
            $("#SinglePatti"+akda+"Akda-wrapper").text('');
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="SinglePatti'+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#SinglePatti"+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    }

/*------------------------  Red Table Bet End ------------------*/


    function addCoinSingleDigitRegular(akda,page){
        // alert("working"+coin)
        var variable = $("input[type='radio'][name='gt-radio']:checked").val();
             // alert(variable)
        if(!variable){
            error('Please Select Open/Close');
        }else if(coin!=0 && (page == 'SinglePatti' || page == 'DoublePatti' || page == 'TriplePatti'  || page == 'SingleAkda')){
            if(parseInt(akda)<10 && page == 'TriplePatti')  {
                akda = '00'+akda;  
            }
            var addC = $("#"+page+akda+"Akda").text();
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    } 


    function addCoinRegular(akda,page){
        if(coin!=0){ 
            if(parseInt(akda)<10 && page == 'TriplePatti')  {
                akda = '00'+akda;  
            }
            if(parseInt(akda)<10 && page == 'SinglePatti')  {
                akda = '0'+akda;  
            }
            var addC = $("#"+page+akda+"Akda-wrapper").text();
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
            var valImg='<img src="'+base_url+coinImg+'" alt=""><span id="'+page+akda+'Akda" class="countNo">'+newVal+'</span>';
            $("#"+page+akda+"Akda-wrapper").append(valImg);
            arr1.push({akda:akda,coin:coin,img:coinImg});
        }else{
            error('Please Select The Coin');
        }
    }

    
