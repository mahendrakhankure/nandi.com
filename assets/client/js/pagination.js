  //////////////////============== Global Code for Search and Pagination===========//////////////////////
    page_id = 1;
    var con1 = '';
    var tbl1 = '';
    var total_records = 0;
    var fields = new Array(10);
     
  ///////////////////////=================== Regular Bazar Start================/////////////////////////////
 
    function loadpageRB(id, total_records, cnName, cnMethod, tableName, fields){
        page_id = id;  
        tbl1 = tableName;
        if(page_id == 'next') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else if(page_id == 'prev') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else {
            this.getRB(tbl1, fields, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchRB(tableName, cnName, cnMethod){

        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[5] = $("#gameType").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
        var flag = 0;
        for(var i=1; i<10; i++) {
            if(fields[i] != '' && fields[i] != null)    {
                flag = 1;
            }
        }
        if(flag == 0)    {
            alert("Please enter atleast one search Field");
        } else {
            getRB(tableName, fields, page_id, total_records, cnName, cnMethod);
        }
    }
    function getRB(tableName, fields, page_id, total_records, cnName, cnMethod)
    {  
        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[5] = $("#gameType").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
         
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields,  'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextRB(temp, total_records,cnName, cnMethod, tableName, fields,  currentPage){
        tbl1=tableName;
        
        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[5] = $("#gameType").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();


        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }


  ///////////////////////=================== Starline Bazar Start================/////////////////////////////
 

    function loadpageSB(id, total_records, cnName, cnMethod, tableName, fields){
        page_id = id;  
        tbl1 = tableName;
        if(page_id == 'next') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else if(page_id == 'prev') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else {
            this.getRB(tbl1, fields, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchSB(tableName, cnName, cnMethod){

        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
        var flag = 0;
        for(var i=1; i<10; i++) {
            if(fields[i] != '' && fields[i] != null)    {
                flag = 1;
            }
        }
        if(flag == 0)    {
            alert("Please enter atleast one search Field");
        } else {
            getRB(tableName, fields, page_id, total_records, cnName, cnMethod);
        }
    }
    function getSB(tableName, fields, page_id, total_records, cnName, cnMethod){  
        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
         
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields,  'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextSB(temp, total_records,cnName, cnMethod, tableName, fields,  currentPage){
        tbl1=tableName;
        
        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();


        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

      ///////////////////////=================== King Bazar Start================/////////////////////////////
 

    function loadpageKB(id, total_records, cnName, cnMethod, tableName, fields){
        page_id = id;  
        tbl1 = tableName;
        if(page_id == 'next') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else if(page_id == 'prev') {
            this.prevNextRB(page_id, total_records,cnName, cnMethod, tableName, fields,  currentPage);
        }else {
            this.getRB(tbl1, fields, page_id, total_records, cnName, cnMethod);
        }    
    }
    function callSearchKB(tableName, cnName, cnMethod){

        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
        var flag = 0;
        for(var i=1; i<10; i++) {
            if(fields[i] != '' && fields[i] != null)    {
                flag = 1;
            }
        }
        if(flag == 0)    {
            alert("Please enter atleast one search Field");
        } else {
            getRB(tableName, fields, page_id, total_records, cnName, cnMethod);
        }
    }
    function getKB(tableName, fields, page_id, total_records, cnName, cnMethod){  
        // var fields = new Array(10);
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();
         
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields,  'page':page_id, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
    function prevNextKB(temp, total_records,cnName, cnMethod, tableName, fields,  currentPage){
        tbl1=tableName;
        
        fields[1] = $("#transactionId").val();
        fields[2] = $("#customerId").val();
        fields[3] = $("#bazarName").val();
        fields[4] = $("#gameName").val();
        fields[6] = $("#resultDate").val();
        fields[9] = $("#status").val();


        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fields':fields, 'page':currentPage, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
 

    function resetAll(tableName, cnName, cnMethod) {
        
        offset = 0;
        page_id = 1;
        total_records = 0;
        var fields = new Array(10);
          $("#transactionId").val('');
          $("#customerId").val('');
          $("#bazarName").val('');
          $("#gameName").val('');
          $("#gameType").val('');
          $("#resultDate").val('');
          $("#status").val('');
    
        $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'page':page_id, 'fields':fields, 'total_records':total_records},
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }

    function searchDataList(cnName, cnMethod, tableName, fieldName, fieldValue, id)  {
         if(fieldValue != '')    {
            $.ajax({
            url:cnName+"/"+cnMethod,
            method:"POST",
            data:{'tableName':tableName, 'fieldName':fieldName, 'fieldValue':fieldValue},
            success:function(data){ 
                var mydata1 = $.parseJSON(data);
                var key =  Object.keys(mydata1[0])[0];
                $.each(mydata1, function(index, value){
                     $('#'+id).append("<option value='" + value[key] + "'></option>");
                });   
                
            }
        });
         }
    }
 

 

 


 
 

 
