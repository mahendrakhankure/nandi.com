 
    var currentPage = 1;
    var tableName = '';
    var totalRecords = 0;
    var fields = [];
    var offset = 0;
    var flag = 0;
     

    ///////////////////////=================== Search and Load Data ================/////////////////////////////
 

    function callSearch(cnName, cnFunction, tableName, len){
         for(var i=1; i<=len; i++) {
            fiels[i] = $("#"+i).val();
            if(fields[i] != '' || fields[i] != null)    {
                flag = 1;
            }
         }
         
        if(flag == 0)    {
            alert("All Search Field Can't Be Empty");
        } else {
            loadpage(cnName, cnFunction, tableName, fields, currentPage, totalRecords);
        }
    }
    function loadpage(cnName, cnFunction, tableName, fields, currentPage, total_records){     
        tbl1=tableName;
        $.ajax({
            url:cnName+"/"+cnFunction,
            method:"POST",
            data:{'cnFunction':cnFunction, 'tableName':tableName, 'fields':fields, 'total_records':total_records, 'currentPage':currentPage },
            success:function(data){
                $('#table-wrapper').html(data);  
            }
        });
    }
     




















    // function resetAll(tableName, cnName, cnMethod) {
        
    //     offset = 0;
    //     page_id = 1;
    //     total_records = 0;
    //     var fields = new Array(10);
    //       $("#transactionId").val('');
    //       $("#customerId").val('');
    //       $("#bazarName").val('');
    //       $("#gameName").val('');
    //       $("#gameType").val('');
    //       $("#resultDate").val('');
    //       $("#status").val('');
    
    //     $.ajax({
    //         url:cnName+"/"+cnMethod,
    //         method:"POST",
    //         data:{'tableName':tableName, 'page':page_id, 'fields':fields, 'total_records':total_records},
    //         success:function(data){
    //             $('#table-wrapper').html(data);  
    //         }
    //     });
    // }

    // function searchDataList(cnName, cnMethod, tableName, fieldName, fieldValue, id)  {
    //      if(fieldValue != '')    {
    //         $.ajax({
    //         url:cnName+"/"+cnMethod,
    //         method:"POST",
    //         data:{'tableName':tableName, 'fieldName':fieldName, 'fieldValue':fieldValue},
    //         success:function(data){ 
    //             var mydata1 = $.parseJSON(data);
    //             var key =  Object.keys(mydata1[0])[0];
    //             $.each(mydata1, function(index, value){
    //                  $('#'+id).append("<option value='" + value[key] + "'></option>");
    //             });   
                
    //         }
    //     });
    //      }
    // }
 

 

 


 
 

 
