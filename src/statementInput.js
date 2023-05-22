var rowCount = 0;


$(document).ready(function () {
    var t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });

    // Gets the bank accounts based off of clientID in session info
    var ClientId = document.getElementById("clientID").value;
    var responseData;
    var pdata = '{"ClientID":"' + ClientId + '"}';

    $.ajax({
        type : "POST",  
        url  : "submitTransactionGetInfo.php",
        data : { 
            'ClientID' : pdata,
            'function' : 'getAccounts'
        },
        async: false,
        success: function(res){  
            responseData = res;
        }
    });

    // Get bank accounts and add to select statement
    jsonAccountData = JSON.parse(responseData);

    var select = document.getElementById("BankAccount");

    for (var i = 0; i < jsonAccountData.length; i++) {
        var opt = document.createElement('option');
        opt.value = jsonAccountData[i].BankAccountID;
        opt.innerHTML = jsonAccountData[i].BankName + " " + (jsonAccountData[i].AccountNumber).substr(jsonAccountData[i].AccountNumber.length - 4);
        select.appendChild(opt);
    }
 
    $('#addRow').on('click', function () {
        let row = [
            '<td><input type="text" id="row-' + rowCount + '-date" name="row-' + rowCount + '-date"></td>',
            '<td><input type="num" id="row-' + rowCount + '-debit" name="row-' + rowCount + '-debit"></td>',
            '<td><input type="num" id="row-' + rowCount + '-credit" name="row-' + rowCount + '-credit"></td>',
            '<td><input type="text" id="row-' + rowCount + '-transNum" name="row-' + rowCount + '-transNum" value="ACH"></td>',
            '<td><input type="text" id="row-' + rowCount + '-memo" name="row-' + rowCount + '-memo"></td>',
            '<td><select size="1" id="row-' + rowCount + '-account" name="row-' + rowCount + '-account">' +
                            '<option value="1" selected="selected">Income</option>' +
                            '<option value="2">Expenses</option>' +
                            '<option value="3">Liabilities</option>' +
                            '<option value="4">Assets</option>' +
                            '<option value="5">Equity</option></select></td>'
        ];
        t.row.add(row).draw(false);
        rowCount++;
    });

    for (let i = 0; i < 5; i++) {
        $('#addRow').click();
    }

    // Submits transactions to php file
    $("#sumbitButton").click(function(){
        var pdata = t.$('input, select').serialize();

        $.ajax({
            type : "POST",  
            url  : "submitTransaction.php", 
            data : { 
                data : pdata,
                rowCount : rowCount,
                BankAccountID : document.getElementById("BankAccount").value
            },
            success: function(res){  
                
            }
        });
    });
});
