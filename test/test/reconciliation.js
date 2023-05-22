var rowCount = 0;


$(document).ready(function () {
    var t = $('#inputTable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false
    });
 
    $('#addRow').on('click', function () {
        let row = [
            rowCount + '/' + rowCount + 2 + '/' + rowCount + 1 ,
            rowCount,
            'CC Charge',
            'Equity',
            'Kent Howell CHASEBANK==' + Math.floor(Math.random() * 10),
            rowCount + Math.floor(Math.random() * 10),
            '<input type="checkbox" id="row-' + rowCount + '-reconciled" name="row-' + rowCount + '-reconciled" value="reconciled">'
        ];
        t.row.add(row).draw(false);
        rowCount++;
    });

    for (let i = 0; i < 5; i++) {
        $('#addRow').click();
    }

    $("#sumbitButton").click(function(){
        var data = t.$('input, select').serialize();
        alert('Would submit checked off transactions to database');
        return false;
    });

    $("tbody").on('click', 'tr', function(){
        var rowName = this.cells[6].children.item(0).name
        
        if ($('#' + rowName)[0].checked) {
            $('#' + rowName).prop("checked", false);
        } else {
            $('#' + rowName).prop("checked", true)
        }
        
    });
        
});