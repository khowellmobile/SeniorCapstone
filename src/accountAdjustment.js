var rowCount = 0;


$(document).ready(function () {

    // Intialize the table
    var t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });
 
    // Function to add rows
    $('#addRow').on('click', function () {
        let row = [
            rowCount,
            '<td><select size="1" id="row-' + rowCount + '-account" name="row-' + rowCount + '-account">' +
                            '<option value="1" selected="selected">Income</option>' +
                            '<option value="2">Expenses</option>' +
                            '<option value="3">Liabilities</option>' +
                            '<option value="4">Assets</option>' +
                            '<option value="5">Equity</option></select></td>',
            '<td><input type="num" id="row-' + rowCount + '-debit" name="row-' + rowCount + '-debit"></td>',
            '<td><input type="num" id="row-' + rowCount + '-credit" name="row-' + rowCount + '-credit"></td>',
            '<td><input type="text" id="row-' + rowCount + '-memo" name="row-' + rowCount + '-memo"></td>'
        ];
        t.row.add(row).draw(false);
        rowCount++;
    });

    // Populate table with an initial 5 rows
    for (let i = 0; i < 5; i++) {
        $('#addRow').click();
    }

    // Function to submit information to be updated in the database
    $("#sumbitButton").click(function(){
        var pdata = t.$('input, select').serialize();
        var clientID = document.getElementById("clientID").value;
        $.ajax({
            type : "POST",  
            url  : "submitAccountAdjustment.php", 
            data : { 
                data : pdata,
                rowCount : rowCount,
                clientID : clientID,
                adjustmentDate : document.getElementById("adjustmentDate").value,
                adjustmentName: document.getElementById("adjustmentName").value
            },
            success: function(res){  
                alert('Success!')
            }
        });
    });

    // Handles totaling and display of credits, debits, and their difference
    $("tbody").on('change', 'tr', function(){
        var data = t.$('input, select').serializeArray();
        var creditsTotal = 0, debitsTotal = 0, difference = 0;

        for (var i = 1, j = 2; i < rowCount * 4; i += 4, j += 4) {
            creditsTotal += Number(data[j].value);
            debitsTotal += Number(data[i].value);
        }
        
        difference = Number(debitsTotal) - Number(creditsTotal);

        if (Number(difference) < 0) {
            difference = '(' + difference.toFixed(2).slice(1) + ')';
        } else {
            difference = difference.toFixed(2);
        }

        $("#debitsTotal").text(debitsTotal.toFixed(2));
        $("#creditsTotal").text('(' + creditsTotal.toFixed(2) + ')');
        $("#difference").text(difference);
    });
});
