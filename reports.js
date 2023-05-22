$(document).ready(function () {

    // Submits the reconciliation data to the server
    $("#sumbitButton").click(function(){

        var resData = null;

        var clientID = document.getElementById("clientID").value

        // If blocks to handle some improper entry issues
        if (clientID == "") {
            alert('Please select a client to continue');
            return;
        }

        if (document.getElementById("startDate").value > document.getElementById("endDate").value) {
            alert("The start date should be before the end date. Please try again");
            return;
        }

        // Ajax call to get needed information
        $.ajax({
            type : "POST",  
            url  : "reportsGetInfo.php", 
            data : {
                function : document.getElementById("reportChoice").value,
                clientID : clientID,
                startDate : document.getElementById("startDate").value,
                endDate : document.getElementById("endDate").value
            },
            async: false,
            success: function(res){  
                resData = res;
            }
        });

        // If blocks to create the chosen report
        if (document.getElementById('reportChoice').value == 'balanceSheet') {
            var jsonData = JSON.parse(resData);
            createBalanceSheet(jsonData);
        } else if (document.getElementById('reportChoice').value == 'profitLoss') {
            var jsonData = JSON.parse(resData);
            createProfitLoss(jsonData);
        }
    });

    //Stops the form from clearing the information on submit
    var form = document.querySelector("#reportInfo");

    form.addEventListener("submit", (e) => {
      e.preventDefault();
    });
        
});

// Function to 
function createBalanceSheet(jsonData) {
    // Getting needed totals
    var assetTotal = getAssetTotal(jsonData.assets);
    var equityTotal = getEquityTotal(jsonData.equity);
    var liabilityTotal = getLiabilityTotal(jsonData.liabilities);
    var netIncomeTotal = getIncomeTotal(jsonData.netIncome);
    var retainedIncomeTotal = getIncomeTotal(jsonData.retainedIncome);
    var netExpenseTotal = getExpenseTotal(jsonData.netExpense);
    var retainedExpenseTotal = getExpenseTotal(jsonData.retainedExpense);
    var netIncMinusExp = (netIncomeTotal - netExpenseTotal);
    var retIncMinusExp = (retainedIncomeTotal - retainedExpenseTotal);

    // Getting the div and adding the report to it
    var reportDiv = document.getElementById('reportDiv');

    var reportHTML = '<h1 class="welcome" style=" margin-top: 50px;">Balance Sheet</h1>' +
    '<h4 class="welcome">' + document.getElementById("endDate").value + "<h2>" +
    '<h2>Assets: ' + checkAddBrackets(assetTotal) + '</h2>' +
    '<h2>liabilities: ' + checkAddBrackets(liabilityTotal) + '</h2>' +
    '<h2>Equity: ' + checkAddBrackets(equityTotal) + '</h2>' +
    '<h3>Net Income: ' + checkAddBrackets(netIncMinusExp) + '</h3>' +
    '<h3>Retained Earnings: ' + checkAddBrackets(retIncMinusExp) + '</h3>';

    reportDiv.innerHTML = reportHTML;
    
}

function createProfitLoss(jsonData) {
    // Getting the needed variables
    var incomeTotal = getIncomeTotal(jsonData.netIncome);
    var expenseTotal = getExpenseTotal(jsonData.netExpense);
    let netProfitLoss = incomeTotal - expenseTotal;

    // Getting report div and adding needed HTML
    var reportDiv = document.getElementById('reportDiv');

    var reportHTML = '<h1 class="welcome" style=" margin-top: 50px;">Profit & Loss</h1>' +
    '<h4 class="welcome">' + document.getElementById("startDate").value + ' to ' + document.getElementById("endDate").value + '<h2>' +
    '<h2>Revenues: ' + checkAddBrackets(incomeTotal) + '</h2>' +
    '<h2>Expenses: ' + checkAddBrackets(expenseTotal) + '</h2>'+
    '<h3>Net Profit(Loss): ' + checkAddBrackets(netProfitLoss) + '</h3>';

    reportDiv.innerHTML = reportHTML;

}

// Function to get the Asset total. Works backwards to remove transactions from an account balance.
// Parameter jsonData holds the transactions to remove.
function getAssetTotal(jsonData) {
    if (jsonData == undefined) {
        return 0;
    }

    var total = 0;
    for (let i = 1; i < jsonData.length; i++) {
        if (jsonData[i] < 0) {
            total -= Math.abs(jsonData[i]);
        } else {
            total += jsonData[i];
        }
    }
    return jsonData[0] + total;
}

// Function to get the Equity total. Works backwards to remove transactions from an account balance.
// Parameter jsonData holds the transactions to remove.
function getEquityTotal(jsonData) {
    if (jsonData == undefined) {
        return 0;
    }

    var total = 0;
    for (let i = 1; i < jsonData.length; i++) {
        total -= jsonData[i];
    }
    return jsonData[0] + total;
}

// Function to get the Liability total. Works backwards to remove transactions from an account balance.
// Parameter jsonData holds the transactions to remove.
function getLiabilityTotal(jsonData) {
    if (jsonData == undefined) {
        return 0;
    }

    var total = 0;
    for (let i = 1; i < jsonData.length; i++) {
        total -= jsonData[i];
    }
    return jsonData[0] + total;
}

// Function to get the Income(revenue) total. Works backwards to remove transactions from an account balance.
// Parameter jsonData holds the transactions to remove.
function getIncomeTotal(jsonData) {
    if (jsonData == undefined) {
        return 0;
    }

    var total = 0;
    for (let i = 1; i < jsonData.length; i++) {
        total += jsonData[i];
    }
    return jsonData[0] + total;
}

// Function to get the Expense total. Works backwards to remove transactions from an account balance.
// Parameter jsonData holds the transactions to remove.
function getExpenseTotal(jsonData) {
    if (jsonData == undefined) {
        return 0;
    }
    
    var total = 0;
    for (let i = 1; i < jsonData.length; i++) {
        if (jsonData[i] < 0) {
            total += Math.abs(jsonData[i]);
        } else {
            total -= jsonData[i];
        }
    }
    return jsonData[0] + total;
}

// Function to add brackets to negative numbers
// Paramter total holds the number to be checked
function checkAddBrackets(total) {
    if (total < 0) {
        return '(' + Math.abs(total) + ')';
    } else {
        return total;
    }
}