var rowCount = 0;

var transResponseData = null;
var jsonData = null;


$(document).ready(function () {
    
    var t = $('#displayTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });

    // Gets all client transactions
    var clientID = document.getElementById("clientID").value;

    $.ajax({
        type : "POST",  
        url  : "clientRegisterGetInfo.php",
        data : { 
            'clientID' : clientID,
            'function' : 'getTransactions'
        },
        async: false,
        success: function(res){  
            transResponseData = res;
        }
    });

    jsonData = JSON.parse(transResponseData);
        
    var debit, credit;

    // Parses the Json Data into rows and adds it to the table
    for(var i = 0; i < jsonData.length; i++) {
        if (jsonData[i].Amount < 0) {
            debit = Math.abs(jsonData[i].Amount);
            credit = "";
        } else {
            credit = jsonData[i].Amount;
            debit = "";
        }
    
        let row = [
            jsonData[i].Date_Processed,
            jsonData[i].BankName + " " + (jsonData[i].AccountNumber).substr(jsonData[i].AccountNumber.length - 4),
            debit,
            credit,
            jsonData[i].TransNum,
            jsonData[i].Description,
            jsonData[i].AccountTypeName,
            jsonData[i].isReconciled,
            '<input type="checkbox" id="row-' + i + '-delete" name="row-' + i + '-delete">'
        ];
        t.row.add(row).draw(false);
    }


    // Submits the checked off transactions to be deleted
    $("#deleteButton").click(function(){

        var pdata = "[";

        if (confirm("Are you sure you would like to delete checked transactions?")) {
            for (var i = 0; i < jsonData.length; i++) {
                pdata += '{"TransactionID":"' + jsonData[i].TransactionID + '","row' + i + 'deleted":"' + $('#row-' + i + '-delete').is(":checked") + '"},';
            }
    
            $.ajax({
                type : "POST",  
                url  : "clientRegisterGetInfo.php",
                data : { 
                    'data' : pdata,
                    'function' : 'deleteTransactions'
                },
                async: false,
                success: function(res){  
                    alert(res);
                }
            });
        }
    });

});
