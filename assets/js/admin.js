// var base_url = 'http://'+window.location.host;

var base_url = 'http://localhost/p1/';
function updateWallet(ids,div){
    $('.flexbox').show();
    $.ajax({
        type: "POST",
        url: base_url+"/e6e9a4f45aa1534488f516530c534059",
        data: Object.assign({}, ids),
        success: function (res) {
            $('.flexbox').hide();
            var data = jQuery.parseJSON(res);
            if(data['status']==200){
                success(data['message']);
                $('#'+div).remove();
            }else{
                error(data['message']);
            }
        }
    });
}

function updateWalletStar(ids,div){
    $('.flexbox').show();
    $.ajax({
        type: "POST",
        url: base_url+"/d50323af60643ba9e1da40d643c44966",
        data: Object.assign({}, ids),
        success: function (res) {
            $('.flexbox').hide();
            console.log(res)
            var data = jQuery.parseJSON(res);
            if(data['status']==200){
                success(data['message']);
                $('#'+div).remove();
            }else{
                error(data['message']);
            }
        }
    });
}

function updateWalletKing(ids,div){
    $('.flexbox').show();
    $.ajax({
        type: "POST",
        url: base_url+"/7ae7165a06ebd76c2c5ee3d24213805e",
        data: Object.assign({}, ids),
        success: function (res) {
            $('.flexbox').hide();
            var data = jQuery.parseJSON(res);
            if(data['status']==200){
                success(data['message']);
                $('#'+div).remove();
            }else{
                error(data['message']);
            }
        }
    });
}


function getTabData(id,name,o,j,c){
    if(name=='JODI'){
        o = j;
    }
    $('.flexbox').show();
    if($('#'+name).is(':empty')){
        $.ajax({
            type: "POST",
            url: base_url+"/ea6f993d7d823816d85299977da11f45",
            data: {id:id,name:name},
            success: function (res) {
                $('.flexbox').hide();
                var data = jQuery.parseJSON(res);
                if(data.length>0){
                    var ta = 0;
                    if(name=='JODI'){
                        var d = data;
                    }else{
                        var d = data[0];
                    }
                    var dome = '<p id="'+name+'123" style="float: right;font-size: 15px;font-weight: 600;"></p>';
                    dome +='<table class="table table-resopncive text-center"><thead></thead><tbody>';
                    $(d).each(function(t) {
                        var sr = t+1;
                        if(name=='JODI'){
                            sr = sr-1;
                        }
                        if(sr==10){
                            sr=0;
                        }
                        dome += '<tr><td class="sr">'+sr+'</td>';
                        $(d[t]).each(function(k) {
                        	if(o != undefined && parseInt(o)==parseInt(d[t][k].akda)){
                                dome += '<td class="win">'+d[t][k].akda+'</td>';
                            }else{
                                // console.log(d[t][k])
                                // var regExp = /[a-zA-Z]/g;
                                // if(!regExp.test(d[t][k].akda)){
                                // if(d[t][k].akda){
                                    dome += '<td class="l">'+d[t][k].akda+'</td>';
                                // }
                            }
                        });
                        dome += '<td></td>';
                        dome += '</tr>';
                        dome += '<tr><td>-</td>';
                        var tJodi = 0;
                        $(d[t]).each(function(k) {
                            var fSangam = '';
                            if(d[t][k].point != null && d[t][k].point != '0'){
                                var p = d[t][k].point;
                                if(p%5!=0 && data[2]=='Out'){
                                    p = p - (p%5);
                                }
                                if(d[t][k].fSangam==1){
                                    fSangam = '<span class="fSangam">#</span>';
                                }
                                dome += '<td class="bet">'+fSangam+p+'</td>';
                            }else{
                                var p = 0;
                                dome += '<td>'+p+'</td>';
                            }
                            tJodi += parseInt(p);
                            ta += parseInt(p);
                        });
                        dome += '<td  class="tBet">'+tJodi+'</td>';
                        dome += '</tr>';
                    });
                    dome +='</tbody></table>';
                    $('#'+name).append(dome);
                    $('#'+name+'123').append('Total '+ta);
                    if(name!='JODI'){
                        var taC = 0;
                        var dome1 ='<p id="'+name+'456" style="float: right;font-size: 15px;font-weight: 600;"></p><table class="table table-resopncive text-center"><thead></thead><tbody>';
                        $(data[1]).each(function(t) {
                            var sr = t+1;
                            if(sr==10){
                                sr=0;
                            }
                            dome1 += '<tr><td>'+sr+'</td>';
                            $(data[1][t]).each(function(k) {
                                if(c != undefined && parseInt(c)==parseInt(data[1][t][k].akda)){
                                    dome1 += '<td class="win">'+data[1][t][k].akda+'</td>';
                                }else{
                                    dome1 += '<td class="p">'+data[1][t][k].akda+'</td>';
                                }
                            });
                            dome1 += '<td></td>';
                            dome1 += '</tr>';
                            dome1 += '<tr><td>-</td>';
                            var tClose = 0;
                            $(data[1][t]).each(function(k) {
                                var fSangam = '';
                                if(data[1][t][k].point != null && data[1][t][k].point != '0'){
                                    var p = data[1][t][k].point;
                                    if(p%5!=0 && data[2]=='Out'){
                                        p = p - (p%5);
                                    }
                                    if(data[1][t][k].fSangam==1){
                                        fSangam = '<span class="fSangam">#</span>';
                                    }
                                    dome1 += '<td class="bet">'+fSangam+p+'</td>';
                                }else{
                                    var p = 0;
                                    dome1 += '<td>'+p+'</td>';
                                }
                                tClose += parseInt(p);
                                taC += parseInt(p);
                            });
                            dome1 += '<td class="tBet">'+tClose+'</td>';
                            dome1 += '</tr>';
                        });
                        dome1 +='</tbody></table>';
                        $('#'+name+'close').append(dome1);
                        $('#'+name+'456').append('Total '+taC);
                    }
                }else{
                    error(data['message']);
                }
            }
        });
    }else{
        $('.flexbox').hide();
    }
}

function getTabDataBackBusiness(from,to,id,name,o,j,c){
    if(name=='JODI'){
        o = j;
    }
    $('.flexbox').show();
    if($('#'+name).is(':empty')){
        $.ajax({
            type: "POST",
            url: base_url+"/ad7c4ca6c28dcbed88f64d3bb1875637",
            data: {id:id,name:name,from:from,to:to},
            success: function (res) {
                $('.flexbox').hide();
                var data = jQuery.parseJSON(res);
                if(data.length>0){
                    var ta = 0;
                    var taW = 0;
                    if(name=='JODI'){
                        var d = data;
                    }else{
                        var d = data[0];
                    }
                    var dome = '<div style="float: right;"><p style="font-size: 15px;font-weight: 600;"><span id="'+name+'123"></span></p><p style="font-size: 15px;font-weight: 600;"><span id="'+name+'123W"></span></p>--------------------------------<p style="font-size: 15px;font-weight: 600;"><span id="'+name+'123ggr"></span></p></div>';
                    dome +='<table class="table table-resopncive text-center"><thead></thead><tbody>';
                    $(d).each(function(t) {
                        var sr = t+1;
                        if(name=='JODI'){
                            sr = sr-1;
                        }
                        if(sr==10){
                            sr=0;
                        }
                        dome += '<tr><td class="sr">'+sr+'</td>';
                        $(d[t]).each(function(k) {
                        	if(o != undefined && parseInt(o)==parseInt(d[t][k].akda)){
                                dome += '<td class="win">'+d[t][k].akda+'</td>';
                            }else{
                                // console.log(d[t][k])
                                // var regExp = /[a-zA-Z]/g;
                                // if(!regExp.test(d[t][k].akda)){
                                // if(d[t][k].akda){
                                    dome += '<td class="l">'+d[t][k].akda+'</td>';
                                // }
                            }
                        });
                        dome += '<td></td>';
                        dome += '</tr>';
                        dome += '<tr><td>-</td>';
                        var tJodi = 0;
                        $(d[t]).each(function(k) {
                            
                            if(d[t][k].point != null && d[t][k].point != '0'){
                                var p = d[t][k].point;
                                if(p%5!=0 && data[2]=='Out'){
                                    p = p - (p%5);
                                }
                                dome += '<td class="bet">'+p+'</td>';
                            }else{
                                var p = 0;
                                dome += '<td>'+p+'</td>';
                            }
                            tJodi += parseInt(p);
                            ta += parseInt(p);
                            if (d[t][k].win != null || d[t][k].win != undefined) {
                                taW += parseInt(d[t][k].win);
                            }
                            console.log(taW)
                        });
                        dome += '<td  class="tBet">'+tJodi+'</td>';
                        dome += '</tr>';
                    });
                    dome +='</tbody></table>';
                    $('#'+name).append(dome);
                    $('#'+name+'123').append('Total Bet =>'+ta);
                    $('#'+name+'123W').append('Total Win =>'+taW);
                    $('#'+name+'123ggr').append('GGR => '+(ta-taW));
                    console.log(taW)
                    if(name!='JODI'){
                        var taC = 0;
                        var taCW = 0;
                        var dome1 ='<div style="float: right;"><p style="font-size: 15px;font-weight: 600;"><span id="'+name+'456"></span></p><p style="font-size: 15px;font-weight: 600;"><span id="'+name+'456W"></span></p><p style="font-size: 15px;font-weight: 600;"><span id="'+name+'456ggr"></span></p></div><table class="table table-resopncive text-center"><thead></thead><tbody>';
                        $(data[1]).each(function(t) {
                            var sr = t+1;
                            if(sr==10){
                                sr=0;
                            }
                            dome1 += '<tr><td>'+sr+'</td>';
                            $(data[1][t]).each(function(k) {
                                if(c != undefined && parseInt(c)==parseInt(data[1][t][k].akda)){
                                    dome1 += '<td class="win">'+data[1][t][k].akda+'</td>';
                                }else{
                                    dome1 += '<td class="p">'+data[1][t][k].akda+'</td>';
                                }
                            });
                            dome1 += '<td></td>';
                            dome1 += '</tr>';
                            dome1 += '<tr><td>-</td>';
                            var tClose = 0;
                            $(data[1][t]).each(function(k) {
                                if(data[1][t][k].point != null && data[1][t][k].point != '0'){
                                    var p = data[1][t][k].point;
                                    if(p%5!=0 && data[2]=='Out'){
                                        p = p - (p%5);
                                    }
                                    dome1 += '<td class="bet">'+p+'</td>';
                                }else{
                                    var p = 0;
                                    dome1 += '<td>'+p+'</td>';
                                }
                                tClose += parseInt(p);
                                taC += parseInt(p);
                                if (data[1][t][k].win != null || data[1][t][k].win != undefined) {
                                    taCW += parseInt(data[1][t][k].win);
                                }
                                
                            });
                            dome1 += '<td class="tBet">'+tClose+'</td>';
                            dome1 += '</tr>';
                        });
                        dome1 +='</tbody></table>';
                        $('#'+name+'close').append(dome1);
                        $('#'+name+'456').append('Total '+taC);
                        $('#'+name+'456W').text('Total Win =>'+taCW);
                        $('#'+name+'456ggr').text('GGR => '+(taC-taCW));
                    }
                }else{
                    error(data['message']);
                }
            }
        });
    }else{
        $('.flexbox').hide();
    }
}

function getTabDataCutting(perJ,from,to,id,type,name,o,j,c){
    console.log(perJ)
    var per = perJ.jodiP;
    if(name=='JODI'){
        o = j;
    }
    if(per==100){
        per=0;
    }
    $('.flexbox').show();
    if($('#'+name).is(':empty')){
        $.ajax({
            type: "POST",
            url: base_url+"/ad7c4ca6c28dcbed88f64d3bb1875637",
            data: {id:id,name:name,from:from,to:to},
            success: function (res) {
                $('.flexbox').hide();
                var data = jQuery.parseJSON(res);
                if(data.length>0){
                    var ta = 0;
                    if(name=='JODI'){
                        var d = data;
                    }else{
                        var d = data[0];
                    }
                    var dome = '<p id="'+name+'123" style="float: right;font-size: 15px;font-weight: 600;"></p>';
                    dome +='<table class="table table-resopncive text-center"><thead></thead><tbody>';
                    $(d).each(function(t) {
                        var sr = t+1;
                        if(name=='JODI'){
                            sr = sr-1;
                        }
                        if(sr==10){
                            sr=0;
                        }
                        dome += '<tr><td class="sr">'+sr+'</td>';
                        $(d[t]).each(function(k) {
                        	if(o != undefined && parseInt(o)==parseInt(d[t][k].akda)){
                                dome += '<td class="win">'+d[t][k].akda+'</td>';
                            }else{
                                dome += '<td class="l">'+d[t][k].akda+'</td>';
                            }
                        });
                        dome += '<td></td>';
                        dome += '</tr>';
                        dome += '<tr><td>-</td>';
                        var tJodi = 0;
                        var nJodiFC = 0;
                        $(d[t]).each(function(k) {
                            
                            if(d[t][k].point != null && d[t][k].point != '0'){
                                var p = d[t][k].point;
                                if(p%5!=0 && data[2]=='Out'){
                                    p = p - (p%5);
                                }
                                dome += '<td class="bet">'+p+'</td>';
                            }else{
                                var p = 0;
                                dome += '<td>'+p+'</td>';
                            }
                            tJodi += parseFloat(p);
                            ta += parseFloat(p);
                            nJodiFC += parseFloat(p);
                        });
                        
                        if($('#bazarType').val()=='Close'){
                            if(per==0){
                                var nP = 100;
                            }else{
                                var nP = per;
                            }
                            var resultOfJodi = $('#res').text();
                            if(resultOfJodi[0]==t){
                                var nJFC = nJodiFC*10;
                                $('#jodi').text(nJFC);
                                var nJFCP = Math.ceil(nJFC - ((nJFC / 100) * nP));
                                // var nJFCP = Math.ceil(((nJFC / 100) * per) - nJFC);
                                $('#jodiC').text(nJFCP.toFixed(0));
                            }
                        }

                        dome += '<td  class="tBet">'+tJodi+'</td>';
                        dome += '</tr>';
                        dome += '<tr><td>-</td>';
                        var tCutJodi = 0;
                        $(d[t]).each(function(k) {
                            if(d[t][k].point != null && d[t][k].point != '0'){
                                // var p = d[t][k].point;
                                // var p = Math.ceil(d[t][k].point - ((d[t][k].point / 100) * per));
                                var p = parseFloat(d[t][k].point) - ((parseFloat(d[t][k].point) / 100) * per);
                                
                                if(p%5!=0 && data[2]=='Out'){
                                    p = p - (p%5);
                                }
                                var s1 = $('#res').text();
                                var cls = '';
                                if(type=='Close' && s1[0]==t){
                                    p = parseFloat(p)*10;
                                    $('#0amt'+k).text(p.toFixed(2));
                                    $('#1amt'+k).text(parseFloat($('#amt'+k).text()).toFixed(2)+parseFloat(p).toFixed(2));
                                    $('#0amtHalf'+k).text(p.toFixed(0));
                                    // $('#1amtCut'+k).text(parseInt(p-((p / 100) * per))+parseInt($('#amt'+k).text()));
                                    var jk = parseFloat($('#amt'+k).text());
                                    var perOK = perJ.akP;
                                    if(perJ.akP==0 || perJ.akP==100){
                                        perOK=per;
                                    }
                                    console.log(Math.round(p+(jk-((jk / 100) * perOK))))
                                    console.log(p+(jk-((jk / 100) * per)))
                                    // console.log(amtCut)
                                    // $('#1amtCut'+k).text(Math.round(p+(jk-((jk / 100) * perOK))));
                                    $('#1amtCut'+k).text(Math.round(p+(jk-((jk / 100) * perOK))) || 0);
                                    // $('#1amtCut'+k).text(p+(jk-((jk / 100) * per)));
                                    cls = 'bet1';
                                }
                                dome += '<td class="'+cls+'">'+p.toFixed(0)+'</td>';
                            }else{
                                var p = 0;
                                dome += '<td>'+p+'</td>';
                            }
                            tCutJodi += parseFloat(p);
                        });
                        
                        if(type=='Open'){
                            var perO = perJ.akP;
                            if(perJ.akP==0 || perJ.akP==100){
                                perO=100;
                            }
                            var amtHalf = parseFloat($('#amt'+t).text())-((parseFloat($('#amt'+t).text())/100)*perO);
                            var amtPer = ((parseFloat($('#amt'+t).text())/100)*perO);
                            // var amtCut = parseFloat($('#amt'+t).text())-((parseFloat($('#amt'+t).text())/100)*perO)+parseFloat(tCutJodi);
                            var amtCut = parseFloat(tCutJodi);
                            // $('#0amtHalf'+t).text(Math.round(amtHalf));
                            
                            // $('#1amtCut'+t).text(Math.round(amtCut+amtPer));
                            if(perJ.akP!=0 && perJ.akP!=100){
                                $('#1amtCut'+t).text(Math.round(amtCut+amtHalf));
                            }else{
                                $('#1amtCut'+t).text(Math.round(amtCut+amtPer));
                            }
                            $('#0amtHalf'+t).text(tCutJodi.toFixed(0));
                        }
                        dome += '<td  class="tBet1">'+parseFloat(tCutJodi).toFixed(0)+'</td>';
                        dome += '</tr>';
                    });
                    dome +='</tbody></table>';
                    $('#'+name).append(dome);
                    $('#'+name+'123').append('Total '+ta);
                }else{
                    error(data['message']);
                }
            }
        });
    }else{
        $('.flexbox').hide();
    }
}
function updatePending(ids,div,t){
    $('.flexbox').show();
    $.ajax({
        type: "POST",
        url: base_url+"/fd4c7ff1732d564d0f412461c4795af8",
        data: {ids:ids,res:div,type:t},
        success: function (res) {
            $('.flexbox').hide();
            // console.log(res)
            var data = jQuery.parseJSON(res);
            if(data['status']==200){
                success(data['message']);
                $('#'+div).remove();
                $('.'+div).remove();
            }else{
                error(data['message']);
            }
        }
    });
}

 function updateLoseBet(table,ids,resultId){
        $('#'+resultId).hide();
        if(table == 'regular_bazar_games')  {
            table == 'regular_bazar_games'
            var u ='/fd4c7ff1732d564d0f412461c4795af8'
        }else if(table == 'king_bazar_game')  {
            table = 'king_bazar_game';
            var u ='/ec516ad04cf15b3a7c32a132c187f006'
        }else if(table == 'starline_bazar_game')  {
            table == 'starline_bazar_game'
            var u ='/f4ef46e12f8b9f9b7bfc2bddd832080a'
        }
        $.ajax({
            type: "POST",
            url: base_url+u,
            data: {ids:ids,res:resultId},
            success: function (res) {
                var data = jQuery.parseJSON(res);
                console.log(data)
                if(data['code']==200){
                    success(data['message']);
                }else{
                    error(data['message']);
                }
            }
        });
        
    }