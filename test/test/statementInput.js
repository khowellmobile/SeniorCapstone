var rowCount = 1;


$(document).ready(function () {
    var t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });
 
    $('#addRow').on('click', function () {
        let row = [
            '<td><input type="text" id="row-' + rowCount + '-date" name="row-' + rowCount + '-date"></td>',
            '<td><input type="num" id="row-' + rowCount + '-amount" name="row-' + rowCount + '-amount"></td>',
            '<td><input type="text" id="row-' + rowCount + '-memo" name="row-' + rowCount + '-memo"></td>',
            '<td><select size="1" id="row-' + rowCount + '-account" name="row-' + rowCount + '-account">' +
                            '<option value="Income" selected="selected">Income</option>' +
                            '<option value="Expenses">Expenses</option>' +
                            '<option value="Liabilities">Liabilities</option>' +
                            '<option value="Assets">Assets</option>' +
                            '<option value="Equity">Equity</option></select></td>'
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
});