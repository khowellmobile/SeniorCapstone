var rowCount = 0;


$(document).ready(function () {
    var t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });
 
    $('#addRow').on('click', function () {
        let row = [
            rowCount,
            '<td><select size="1" id="row-' + rowCount + '-account" name="row-' + rowCount + '-account">' +
                            '<option value="Income" selected="selected">Income</option>' +
                            '<option value="Expenses">Expenses</option>' +
                            '<option value="Liabilities">Liabilities</option>' +
                            '<option value="Assets">Assets</option>' +
                            '<option value="Equity">Equity</option></select></td>',
            '<td><input type="num" id="row-' + rowCount + '-debits" name="row-' + rowCount + '-debits"></td>',
            '<td><input type="num" id="row-' + rowCount + '-credits" name="row-' + rowCount + '-credits"></td>',
            '<td><input type="text" id="row-' + rowCount + '-memo" name="row-' + rowCount + '-memo"></td>'
        ];
        t.row.add(row).draw(false);
        rowCount++;
    });

    for (let i = 0; i < 5; i++) {
        $('#addRow').click();
    }

    $("#sumbitButton").click(function(){
        var data = t.$('input, select').serialize();
        alert('The following data would have been submitted to the server: \n\n' + data.substr(0, 120) + '...');
        return false;
    });

    $("tbody").on('change', 'tr', function(){
        var data = t.$('input, select').serializeArray();
        var creditsTotal = 0, debitsTotal = 0;

        for (var i = 1, j = 2; i < rowCount * 4; i += 4, j += 4) {
            creditsTotal += Number(data[i].value);
            debitsTotal += Number(data[j].value);
        }
        
        $("#creditsTotal").text("Credits Total = " + creditsTotal);
        $("#debitsTotal").text("Debits Total = " + debitsTotal);
    });
});