var mynumber = 0;

function loadJSON(callback) {

  var xobj = new XMLHttpRequest();
  xobj.overrideMimeType("application/json");
  xobj.open('GET', '/assets/js/wheel_data.json', true); 
  // console.log(xobj)
  xobj.onreadystatechange = function() {
    if (xobj.readyState == 4 && xobj.status == "200") {
      //Call the anonymous function (callback) passing in the response
      var jsonobj = $.parseJSON(xobj.responseText);
      console.log(jsonobj.minSpinDuration)
      jsonobj.spinDestinationArray[0] = mynumber;
      var newObj = JSON.stringify(jsonobj);
     
      callback(newObj);
    }
  };
  xobj.send(null);
}

function myResult(e) {
    console.log('Spin Count: ' + e.spinCount + ' - ' + 'Win: ' + e.win + ' - ' + 'Message: ' +  e.msg);
  if(e.spinCount == 3){
    console.log(e.target.getGameProgress());
    
    //e.target.restart();
  }  

}

function myError(e) {
  //e is error object
  console.log('Spin Count: ' + e.spinCount + ' - ' + 'Message: ' +  e.msg);

}

function myGameEnd(e) {
  console.log(e);
}


// function init() {
//   loadJSON(function(response) {
    
//     var jsonData = JSON.parse(response);
    
//     var mySpinBtn = document.createElement('button');
    
//     var myWheel = new ChillSpinTheWheel();
    
//     myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError, spinTrigger:mySpinBtn});

  
//     mySpinBtn.onclick();
//   });
// }
var myWheel = new ChillSpinTheWheel();

function spinthewheel(n) {
  mynumber = n;
  $('#bgimage').hide();
  loadJSON(function(response) {
    
    var jsonData = JSON.parse(response);
    
    var mySpinBtn = document.createElement('button');
    
    // var myWheel = new ChillSpinTheWheel();
    
    myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError, spinTrigger:mySpinBtn, mynumber});

  
    mySpinBtn.onclick();
  });
}


// function init() {
//   loadJSON(function(response) {
//     var jsonData = JSON.parse(response);
//     //var mySpinBtn = document.querySelector('.spinBtn');
//     var myWheel = new ChillSpinTheWheel();
    
//     //myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError, spinTrigger:mySpinBtn});
    
//     myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError});
//   });
// }

// init();

// spinthewheel(2);


