$(document).ready(function () {

    var accountResponseData = null;
    var transResponseData = null;
    var currentDiffBalance = 0;
    var tableLoaded = false;
    var t;
    var jsonData;

    // Initialize the table
    t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });

    // Gets the bank accounts based off of clientID in session info
    var ClientId = 3;
    var pdata = '{"ClientID":"' + ClientId + '"}';

    $.ajax({
        type : "POST",  
        url  : "reconciliationGetInfo.php",
        data : { 
            'ClientID' : pdata,
            'function' : 'getAccounts'
        },
        async: false,
        success: function(res){  
            accountResponseData = res;
        }
    });

    // Get bank accounts and add to select statement
    jsonAccountData = JSON.parse(accountResponseData);

    var select = document.getElementById("BankAccount");

    for (var i = 0; i < jsonAccountData.length; i++) {
        var opt = document.createElement('option');
        opt.value = jsonAccountData[i].BankAccountID;
        opt.innerHTML = jsonAccountData[i].BankName + " " + (jsonAccountData[i].AccountNumber).substr(jsonAccountData[i].AccountNumber.length - 4);
        select.appendChild(opt);
    }
    

    // Submits the reconciliation data to the server
    $("#sumbitButton").click(function(){
        var pdata = '[';

        for (var i = 0; i < jsonData.length; i++) {
            pdata += '{"TransactionID":"' + jsonData[i].TransactionID + '","row' + i + 'reconciled":"' + $('#row-' + i + '-reconciled').is(":checked") + '"},';
        }

        $.ajax({
            type : "POST",  
            url  : "submitReconciliation.php", 
            data : { 
                data : pdata,
                rowCount : jsonData.length,
                bankAccountID : document.getElementById("BankAccount").value,
                endingBalance : document.getElementById("endBalance").value,
                endingDate    : document.getElementById("reconciliationDate").value
            },
            success: function(res){  
                alert(res);
            }
        });
    });

    // Stops the form from clearing the information on submit
    var form = document.querySelector("#ReconInfo");

    form.addEventListener("submit", (e) => {
      e.preventDefault();
    });


    // Gets reconciliation info from the server
    $("#ReconInfoSubmit").click(function(){

        if (!tableLoaded) {
            $.ajax({
                type : "POST",  
                url  : "reconciliationGetInfo.php",
                data : { 
                    'function' : 'getTransactions',
                    'BankAccountID' : document.getElementById("BankAccount").value
                },
                async: false,
                success: function(res){  
                    transResponseData = res;
                }
            });

            jsonData = JSON.parse(transResponseData);
        
            var debit, credit;
        
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
                    jsonData[i].TransNum,
                    jsonData[i].AccountTypeName,
                    jsonData[i].Description,
                    debit,
                    credit,
                    '<input type="checkbox" id="row-' + i + '-reconciled" name="row-' + i + '-reconciled">'
                ];
                t.row.add(row).draw(false);
            
            }
            tableLoaded = true;
        }

        if (document.getElementById("endBalance").value == "") {
            $("#CurrAccountTotal").text("0.00");
        } else {
            $("#CurrAccountTotal").text(document.getElementById("endBalance").value);
        }

        if (document.getElementById("PrevAccountTotal").value == "") {
            $("#PrevAccountTotal").text("0.00");
        } else {
            $("#PrevAccountTotal").text(jsonData[0].lastReconBalance);
        }

        currentDiffBalance = Number(jsonData[0].lastReconBalance - Number(document.getElementById("endBalance").value));

        if (Number(currentDiffBalance) < 0) {
            currentDiffBalance = "(" + currentDiffBalance.toFixed(2).slice(1) + ")";
        }
        $("#DiffAccountTotal").text(currentDiffBalance.toFixed(2));
    });

    // Handles checking off transactions and updating difference equation
    $("tbody").on('click', 'tr', function(){
        var rowName = this.cells[6].children.item(0).name
        var total = 0;
        
        if ($('#' + rowName)[0].checked) {
            $('#' + rowName).prop("checked", false);
        } else {
            $('#' + rowName).prop("checked", true)
        }
        
        for (var i = 0; i < jsonData.length; i++) {
            if ($('#row-' + i + '-reconciled').is(":checked")) {
                total = total + Number(jsonData[i].Amount);
            }
        }

        //889541.21
        var newDiff = Number(currentDiffBalance) + Number(total);

        if (Number(newDiff.toFixed(2)) < 0) {
            $("#DiffAccountTotal").text("(" + newDiff.toFixed(2).slice(1) + ")");
        } else {
            $("#DiffAccountTotal").text(newDiff.toFixed(2));
        }

    });

    // Handles when the bank account is changed (resets the table and needed variables)
    $("#BankAccount").on('change', function() {
        tableLoaded = false;
        jsonData = "";
        transResponseData = "";
        accountResponseData = "";
        t.clear();
        t.draw();
    });
        
});