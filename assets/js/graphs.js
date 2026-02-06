function getDate(d){
    var currentDate = new Date();
    currentDate.setDate(currentDate.getDate() - d);
    var day = currentDate.getDate();
    var month = currentDate.getMonth()+1;
    var year = currentDate.getFullYear();
    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = '0' + month;
    }
    var formattedDate = day + '/' + month + '/' + year;
    return formattedDate;
    
}
var dataBet = [];
var dataWin = [];
var dataGGR = [];

allMarketGgrGraph('1');
regularMarketGraph('1');


function worliMarketGraph(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'worli',date:d},
        beforeSend: function(){
            $('#loader').show()
        },
        success: function (res) {
            $('#loader').hide();
            var d = JSON.parse(res);
            $.each(d, function( index, value ) {
                dataBet.push(Math.round(value.amt));
                dataWin.push(Math.round(value.win));
                dataGGR.push(Math.round(value.ggr));
            });
            var days = [getDate(6), getDate(5), getDate(4), getDate(3), getDate(2), getDate(1), getDate(0)];
            
            var trace1 = {
                x: days,
                y: dataBet,
                name: 'BET',
                type: 'bar'
            };
            var trace2 = {
                x: days,
                y: dataWin,
                name: 'WIN',
                type: 'bar'
            };
            var trace3 = {
                x: days,
                y: dataGGR,
                name: 'GGR',
                type: 'bar'
            };
            var data = [trace1, trace2, trace3];
            var layout = { 
                title: 'Worli Market Data'
            };
    
            var config = {
                displaylogo:false,
                modeBarButtons: [[{
                    name: 'stack',
                    click: function(gd) {
                    Plotly.relayout(gd, 'barmode', 'stack');
                    }
                }, {
                    name: 'overlay',
                    click: function(gd) {
                    Plotly.relayout(gd, 'barmode', 'overlay');
                    }
                }, {
                    name: 'group',
                    click: function(gd) {
                    Plotly.relayout(gd, 'barmode', 'group');
                    }, 
                }, {
                    name: 'relative',
                    click: function(gd) {
                    Plotly.relayout(gd, 'barmode', 'relative');
                    }, 
                }].reverse()]
            }
    
            Plotly.newPlot('graph', data, layout, config);
        }
    });
}

function regularMarketGraph(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'regular',date:d},
        beforeSend: function(){
            $('#loader1').show()
        },
        success: function (res) {
            $('#loader1').hide();
            var d = JSON.parse(res);
            const dataBet = [];
            const dataWin = [];
            const dataGGR = [];
            $.each(d, function( index, value ) {
                dataBet.push(Math.round(value.amt));
                dataWin.push(Math.round(value.win));
                dataGGR.push(Math.round(value.ggr));
            });
            var days = [getDate(6), getDate(5), getDate(4), getDate(3), getDate(2), getDate(1), getDate(0)];
            const data = [{
                x:dataBet,
                y:days,
                type:"bar",
                orientation:"h",
                name: 'BET',
                marker: {color:"rgba(255,0,0,0.6)"}
            },
            {
                x:dataWin,
                y:days,
                type:"bar",
                name: 'WIN',
                orientation:"h",
                marker: {color:"#2b6280"}
            },
            {
                x:dataGGR,
                y:days,
                type:"bar",
                name: 'GGR',
                orientation:"h",
                marker: {color:"#5600f8"}
            }];
            var config = {
                displaylogo:false
            }
            const layout = {title:"Regular market data"};
            Plotly.newPlot("regulrPlot", data, layout, config);
        }
    });
}

function starlineMarketGraph(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'starline',date:1},
        beforeSend: function(){
            $('#loader1').show()
        },
        success: function (res) {
            $('#loader1').hide();
            var d = JSON.parse(res);
            const dataBet = [];
            const dataWin = [];
            const dataGGR = [];
            $.each(d, function( index, value ) {
                dataBet.push(Math.round(value.amt));
                dataWin.push(Math.round(value.win));
                dataGGR.push(Math.round(value.ggr));
            });
            var days = [getDate(6), getDate(5), getDate(4), getDate(3), getDate(2), getDate(1), getDate(0)];
            
            var trace1 = {
                x: days,
                y: dataBet,
                name: 'Bet',
                type: 'scatter'
            };
            var trace2 = {
                x: days,
                y: dataWin,
                name: 'Win',
                type: 'scatter'
            };
            var trace3 = {
                x: days,
                y: dataGGR,
                name: 'GGR',
                type: 'scatter'
            };
            var data = [trace1, trace2, trace3];
            var layout = {
                title: {
                    text:"Starline market data",
                    font: {
                        family: 'Courier New, monospace',
                        size: 24
                    },
                    xref: 'paper',
                    x: 0.05,
                },
                xaxis: {
                    title: {
                        text: 'x Axis',
                        font: {
                            family: 'Courier New, monospace',
                            size: 18,
                            color: '#7f7f7f'
                        }
                    },
                },
                yaxis: {
                    title: {
                        text: 'y Axis',
                        font: {
                            family: 'Courier New, monospace',
                            size: 18,
                            color: '#7f7f7f'
                        }
                    }
                }
            };
            var config = {
                displaylogo:false
            }
            Plotly.newPlot("starlinePlot", data, layout, config);
        }
    });
}

function kingMarketGraph(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'king',date:d},
        beforeSend: function(){
            $('#loader1').show()
        },
        success: function (res) {
            $('#loader1').hide();
            var d = JSON.parse(res);
            const dataBet = [];
            const dataWin = [];
            const dataGGR = [];
            $.each(d, function( index, value ) {
                dataBet.push(Math.round(value.amt));
                dataWin.push(Math.round(value.win));
                dataGGR.push(Math.round(value.ggr));
            });
            var days = [getDate(6), getDate(5), getDate(4), getDate(3), getDate(2), getDate(1), getDate(0)];
            
            var trace1 = {
                x: days,
                y: dataBet,
                name: 'Bet',
                type: 'scatter'
            };
            var trace2 = {
                x: days,
                y: dataWin,
                name: 'Win',
                type: 'scatter'
            };
            var trace3 = {
                x: days,
                y: dataGGR,
                name: 'GGR',
                type: 'scatter'
            };
            var data = [trace1, trace2, trace3];
            var layout = {
                title: {
                    text:"King Bazar market data",
                    font: {
                        family: 'Courier New, monospace',
                        size: 24
                    },
                    xref: 'paper',
                    x: 0.05,
                },
                xaxis: {
                    title: {
                        text: 'x Axis',
                        font: {
                            family: 'Courier New, monospace',
                            size: 18,
                            color: '#7f7f7f'
                        }
                    },
                },
                yaxis: {
                    title: {
                        text: 'y Axis',
                        font: {
                            family: 'Courier New, monospace',
                            size: 18,
                            color: '#7f7f7f'
                        }
                    }
                }
            };
            var config = {
                displaylogo:false
            }
            Plotly.newPlot("kingPlot", data, layout, config);
        }
    });
}

function allMarketGgrGraph(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'all',date:d},
        beforeSend: function(){
            $('#loader2').show()
        },
        success: function (res) {
            console.log('this is live page')
            $('#loader2').hide();
            var d = JSON.parse(res);
            const x1Values = [];
            const x2Values = [];
            const x3Values = [];
            const x4Values = [];
            const y1Values = [];
            const y2Values = [];
            const y3Values = [];
            const y4Values = [];
            const y5Values = [];
            var days = [getDate(6), getDate(5), getDate(4), getDate(3), getDate(2), getDate(1), getDate(0)];
            $.each(d.worli, function( index, value ) {
                y1Values.push(Math.round(value.ggr));
            });
    
            $.each(d.reg, function( index, value ) {
                y2Values.push(Math.round(value.ggr));
            });
            $.each(d.star, function( index, value ) {
                y3Values.push(Math.round(value.ggr));
            });
    
            $.each(d.king, function( index, value ) {
                y4Values.push(Math.round(value.ggr));
            });

            $.each(d.blueTable, function( index, value ) {
                y5Values.push(Math.round(value.ggr));
            });
            
            const data = [
                {x: days, y: y1Values, name:"Worli", mode:"lines"},
                {x: days, y: y2Values, name:"Regular", mode:"lines"},
                {x: days, y: y3Values, name:"Starline", mode:"lines"},
                {x: days, y: y4Values, name:"King Bazar", mode:"lines"},
                {x: days, y: y5Values, name:"Blue Table", mode:"lines"}
            ];
            const layout = {title: "All market last 7 days GGR"};
            var config = {
                displaylogo:false
            }
            Plotly.newPlot("myPlot", data, layout, config);
        }
    });
}

function marketShear(d){
    $.ajax({
        type: 'POST',
        url: "831889aa06026edc2a57fce35fad5b70",
        data: {type:'MarketShear',date:d},
        beforeSend: function(){
            $('#loader').show()
        },
        success: function (res) {
            $('#loader').hide();
            var d = JSON.parse(res);
            const xArray = ["Instant Worli", "Regular", "Starline", "King Bazar"];
            const yArray = [d.worli.ggr, d.reg.ggr, d.star.ggr, d.king.ggr];
            sum = 0;
            $.each(yArray,function(){sum+=parseFloat(this) || 0;});
            const layout = {title:"Todays Market Shear "+Math.round(sum)};
            const data = [{labels:xArray, values:yArray, type:"pie"}];
            var config = {
                displaylogo:false
            }
            Plotly.newPlot("todaysMarketShear", data, layout, config);
        }
    });
}