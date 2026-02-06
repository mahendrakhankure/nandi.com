  //////////////////============== Global Code for Search and Pagination===========//////////////////////
    page_id = 1;
    var con1 = '';
    var tbl1 = '';
    var total_records = 0;
    var bazarName = '';
    var gameName = '';
    var resultDate = '';
    var gameMode = '';
    var status = '';

    
  ///////////////////////=================== Matka Games Start================/////////////////////////////


    function loadpageMG(id, total_records, cnName, cnMethod, tableName, gameName, gameMode){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getMG(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getMG(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }else {
            this.getMG(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchMG(tableName, cnName, cnMethod){
        var gameName = $("#gameName").val();
        var gameMode = $("#gameMode").val();
        page_id = 1;
        if(gameName == '' && gameMode == '')    {
            alert("Please enter the search Field");
        } else {
            getMG(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }
    }
    function getMG(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextMG(temp, total_records,cnName, cnMethod, tableName, gameName, gameMode,  currentPage){
        tbl1=tableName;

        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


 ////////////////////////////////// Matka Games Bazar Rate List Start //////////////////////////////////////////


    function loadpageMGBL(id, total_records, cnName, cnMethod, tableName, bazarName, gameName){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getMGBL(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getMGBL(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }else {
            this.getMGBL(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchMGBL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var gameName = $("#gameName").val();
        // alert(total_records);
        page_id = 1;
        if(bazarName == '' && gameName == '')    {
            alert("Please enter the search Field");
        } else {
            getMGBL(tableName, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }
    }
    function getMGBL(tableName, bazarName, gameName, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextMGBL(temp, total_records,cnName, cnMethod, tableName, bazarName, gameName,  currentPage){
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

 ///////////////////////////////// Matka Games Game Type List Start /////////////////////////////////////


    function loadpageMGGTL(id, total_records, cnName, cnMethod, tableName, gameName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getMGGTL(tbl1, gameName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getMGGTL(tbl1, gameName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getMGGTL(tbl1, gameName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchMGGTL(tableName, cnName, cnMethod){
        var gameName = $("#gameName").val();
        var status = $("#status").val();
        page_id = 1;
        if(gameName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getMGGTL(tableName, gameName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getMGGTL(tableName, gameName, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextMGGTL(temp, total_records,cnName, cnMethod, tableName, gameName, status,  currentPage){
        tbl1=tableName;

        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

/////////////////////////////////////// Matka Games Allot Bazar Games List /////////////////////////////////////////////


    function loadpageMGABGL(id, total_records, cnName, cnMethod, tableName, bazarName, gameName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getMGABGL(tbl1, bazarName, gameName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getMGABGL(tbl1, bazarName, gameName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getMGABGL(tbl1, bazarName, gameName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchMGABGL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var gameName = $("#gameName").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && gameName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getMGABGL(tableName, bazarName, gameName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getMGABGL(tableName, bazarName, gameName, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextMGABGL(temp, total_records, cnName, cnMethod, tableName, bazarName, gameName, status, currentPage){
        tbl1=tableName;

        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }



 ////////////////////////////////// Matka All Games Start //////////////////////////////////////////


    function loadpageMAG(id, total_records, cnName, cnMethod, tableName, bazarName, bazarDate){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getMAG(tbl1, bazarName, bazarDate, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getMAG(tbl1, bazarName, bazarDate, page_id, total_records, cnName, cnMethod);
        }else {
            this.getMAG(tbl1, bazarName, bazarDate, page_id, total_records, cnName, cnMethod);
        }    
        }
    function callSearchMAG(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var bazarDate = $("#bazarDate").val();
        // tableName = 'regular_bazar_result';
        page_id = 1;
        if(bazarName == '' && bazarDate == '')    {
            alert("Please enter the search Field");
        } else {
            getMAG(tableName, bazarName, bazarDate, page_id, total_records, cnName, cnMethod);
        }
    }
    function getMAG(tableName, bazarName, bazarDate, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'bazarDate':bazarDate, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextMAG(temp, total_records,cnName, cnMethod, tableName, bazarName, bazarDate,  currentPage){
        tbl1=tableName;

        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'bazarDate':bazarDate, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }




 ////////////////================= Starline Games(All Bazar Time) Start ====================/////////////////////////////


    function loadpageSL(id, total_records, cnName, cnMethod, tableName, bazarName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getSL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getSL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getSL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getSL(tableName, bazarName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSL(tableName, bazarName, status, page_id, total_records, cnName, cnMethod)
    { 
         
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSL(temp, total_records,cnName, cnMethod, tableName, bazarName, status,  currentPage){
        tbl1=tableName;

        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

 //////////////////////////////////////Starline Games Bazar List Start ////////////////////////////////////////////


    function loadpageSLBL(id, total_records, cnName, cnMethod, tableName, bazarName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getSLBL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getSLBL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getSLBL(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSLBL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getSLBL(tableName, bazarName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSLBL(tableName, bazarName, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSLBL(temp, total_records,cnName, cnMethod, tableName, bazarName, status,  currentPage){
        tbl1=tableName;

        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


 ///////////////////////////// Starline Games All Result Start //////////////////////////////////////////


    function loadpageSLAL(id, total_records, cnName, cnMethod, tableName, bazarName, resultDate){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getSLAL(tbl1, bazarName, resultDate, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getSLAL(tbl1, bazarName, resultDate, page_id, total_records, cnName, cnMethod);
        }else {
            this.getSLAL(tbl1, bazarName, resultDate, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSLAL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var resultDate = $("#resultDate").val();
         
        page_id = 1;
        if(bazarName == '' && resultDate == '')    {
            alert("Please enter the search Field");
        } else {
            getSLAL(tableName, bazarName, resultDate, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSLAL(tableName, bazarName, resultDate, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'resultDate':resultDate, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSLAL(temp, total_records,cnName, cnMethod, tableName, bazarName, resultDate,  currentPage){
        tbl1=tableName;

        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'resultDate':resultDate, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

 ///////////////////////////// Starline Games All Bhav Start //////////////////////////////////////////


    function loadpageSLAB(id, total_records, cnName, cnMethod, tableName, bazarName, gameName){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getSLAB(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getSLAB(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }else {
            this.getSLAB(tbl1, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSLAB(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var gameName = $("#gameName").val();
        page_id = 1;
 
        if(bazarName == '' && gameName == '')    {
            alert("Please enter the search Field");
        } else {
            getSLAB(tableName, bazarName, gameName, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSLAB(tableName, bazarName, gameName, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSLAB(temp, total_records,cnName, cnMethod, tableName, bazarName, gameName,  currentPage){
        tbl1=tableName;

        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameName':gameName, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

 ////////////////////////// Starline Games Game Type List Start ///////////////////////////////////////////////


    function loadpageSLGTL(id, total_records, cnName, cnMethod, tableName, gameName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getSLGTL(tbl1,  gameName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getSLGTL(tbl1, gameName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getSLGTL(tbl1, gameName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSLGTL(tableName, cnName, cnMethod){
        // var bazarName = $("#bazarName").val();
        var gameName = $("#gameName").val();
        var status = $("#status").val();
        page_id = 1;
        if(gameName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getSLGTL(tableName, gameName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSLGTL(tableName, gameName, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSLGTL(temp, total_records,cnName, cnMethod, tableName, gameName, status, currentPage){
        tbl1=tableName;

        $.ajax({
            url: cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


  ///////////////////////=================== King Bazar Games Start================/////////////////////////////


    function loadpageKB(id, total_records, cnName, cnMethod, tableName, bazarName, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getKB(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getKB(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getKB(tbl1, bazarName, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchKB(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getKB(tableName, bazarName, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getKB(tableName, bazarName, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextKB(temp, total_records,cnName, cnMethod, tableName, bazarName, status,  currentPage){
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

  ////////////////////////////////////// King Bazar Games Bazar Bhavlist Start /////////////////////////////////////////


    function loadpageKBBL(id, total_records, cnName, cnMethod, tableName, bazarName, gameType, status){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getKBBL(tbl1, bazarName, gameType, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getKBBL(tbl1, bazarName, gameType, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getKBBL(tbl1, bazarName, gameType, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchKBBL(tableName, cnName, cnMethod){
        var bazarName = $("#bazarName").val();
        var gameType = $("#gameType").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && gameType == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getKBBL(tableName, bazarName, gameType, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getKBBL(tableName, bazarName, gameType, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameType':gameType, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextKBBL(temp, total_records,cnName, cnMethod, tableName, bazarName, gameType, status,  currentPage){
        tbl1=tableName;
        $.ajax({
            // url:cnName+"/"+cnMethod,
            url:cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'gameType':gameType, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

  ////////////////////////////////////// King Bazar Games Bazar Bhavlist Start /////////////////////////////////////////


    function loadpageKBAR(id, total_records, cnName, cnMethod, tableName, gameName, gameMode){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getKBAR(tbl1, bazarName, resultDate, status, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getKBAR(tbl1, bazarName, resultDate, status, page_id, total_records, cnName, cnMethod);
        }else {
            this.getKBAR(tbl1, bazarName, resultDate, status, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchKBAR(tableName, cnName, cnMethod){
        var baarName = $("#bazarName").val();
        var resultDate = $("#resultDate").val();
        var status = $("#status").val();
        page_id = 1;
        if(bazarName == '' && resultDate == '' && status == '')    {
            alert("Please enter the search Field");
        } else {
            getKBAR(tableName, bazarName, resultDate, status, page_id, total_records, cnName, cnMethod);
        }
    }
    function getKBAR(tableName, bazarName, resultDate, status, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'resultDate':resultDate, 'status':status, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextKBAR(temp, total_records, cnName, cnMethod, tableName, bazarName, resultDate, status, currentPage){
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'bazarName':bazarName, 'resultDate':resultDate, 'status':status, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


  ///////////////////////=================== Global Matka Patti List ================/////////////////////////////


    function loadpageGMPL(id, total_records, cnName, cnMethod, tableName, gameName, gameMode){
        page_id = id;  
        tbl1 = tableName;
        // con1 = con;
        if(page_id == 'next') {
            this.getGMPL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }else if(page_id == 'prev') {
            this.getGMPL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }else {
            this.getGMPL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchGMPL(tableName, cnName, cnMethod){
        var gameName = $("#gameName").val();
        var gameMode = $("#gameMode").val();
        page_id = 1;
        if(gameName == '' && gameMode == '')    {
            alert("Please enter the search Field");
        } else {
            getGMPL(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod);
        }
    }
    function getGMPL(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod)
    { 
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextGMPL(temp, total_records,cnName, cnMethod, tableName, gameName, gameMode,  currentPage){
        tbl1=tableName;

        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


/////////////////////////////////// Global Client List/////////////////////////////////////////////////


function loadpageGCL(id, total_records, cnName, cnMethod, tableName, gameName, gameMode){
    page_id = id;  
    tbl1 = tableName;
    // con1 = con;
    if(page_id == 'next') {
        this.getGCL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }else if(page_id == 'prev') {
        this.getGCL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }else {
        this.getGCL(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }    
}
function callSearchGCL(tableName, cnName, cnMethod){
    var gameName = $("#gameName").val();
    var gameMode = $("#gameMode").val();
    page_id = 1;
    if(gameName == '' && gameMode == '')    {
        alert("Please enter the search Field");
    } else {
        getGCL(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }
}
function getGCL(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod)
{ 
    tbl1=tableName;
    $.ajax({
        url:cnName+"/"+cnMethod,
        method:"POST",
        data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':page_id, 'total_records':total_records},
        success:function(data){
            $('#table-wrapper').html(data);  
        }
    });
}
function prevNextGCL(temp, total_records,cnName, cnMethod, tableName, gameName, gameMode,  currentPage){
    tbl1=tableName;

    $.ajax({
        url:cnName+"/"+cnMethod,
        method:"POST",
        data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':currentPage, 'total_records':total_records},
        success:function(data){
            $('#table-wrapper').html(data);  
        }
    });
}

////////////////////////////// Global Add Remove Point of User /////////////////////////////////////////


function loadpageGARP(id, total_records, cnName, cnMethod, tableName, gameName, gameMode){
    page_id = id;  
    tbl1 = tableName;
    // con1 = con;
    if(page_id == 'next') {
        this.getGARP(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }else if(page_id == 'prev') {
        this.getGARP(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }else {
        this.getGARP(tbl1, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }    
}
function callSearchGARP(tableName, cnName, cnMethod){
    var gameName = $("#gameName").val();
    var gameMode = $("#gameMode").val();
    page_id = 1;
    if(gameName == '' && gameMode == '')    {
        alert("Please enter the search Field");
    } else {
        getGARP(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod);
    }
}
function getGARP(tableName, gameName, gameMode, page_id, total_records, cnName, cnMethod)
{ 
    tbl1=tableName;
    $.ajax({
        url:cnName+"/"+cnMethod,
        method:"POST",
        data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':page_id, 'total_records':total_records},
        success:function(data){
            $('#table-wrapper').html(data);  
        }
    });
}
function prevNextGARP(temp, total_records,cnName, cnMethod, tableName, gameName, gameMode,  currentPage){
    tbl1=tableName;
    $.ajax({
        url:cnName+"/"+cnMethod,
        method:"POST",
        data:{'tableName':tableName, 'gameName':gameName, 'gameMode':gameMode, 'page':currentPage, 'total_records':total_records},
        success:function(data){
            $('#table-wrapper').html(data);  
        }
    });
}


////////////////////////////// Reset All /////////////////////////////////////////
function resetAllMG(tableName, cnName, cnMethod) {
        
        offset = 0;
        page_id = 1;
        total_records = 0;
        $("#gameName").val('');
        $("#gameMode").val('');
        var gameName = '';
        var gameMode = '';
        var flag = 0;
    
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'page':page_id, 'gameName':gameName, 'gameMode':gameMode, 'total_records':total_records, 'flag':flag},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
}
