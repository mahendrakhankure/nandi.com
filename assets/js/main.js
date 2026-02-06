
    // $(document).bind("contextmenu",function(e){
    //     return false;
    // });
    // document.onkeydown = function(e) {
    //   if(event.keyCode == 123) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
    //      return false;
    //   }
    // }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        // if(charCode == 46){
        //     return true;
        // }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function openNav() {
        $("#mySidenav").toggleClass("sideNavHistory");
    }
    function maxLengthCheck(object) {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }
    

     