function validateTransactionInputForm() {
    let n = document.getElementById("BankAccountID").value;
    if (n == "" || !/^\d+$/.test(n)) {
        alert("Bank Account ID is invalid");
        return false;
    }
    let u = document.getElementById("Date_Made").value;
    if (u == "" || !/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/.test(u)) {
        alert("Date Made is invalid");
        return false;
    }
    let i = document.getElementById("Date_Processed").value;
    if (i == "" || !/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/.test(i)) {
        alert("Date Processed is invalid");
        return false;
    }
    let p = document.getElementById("TransactionTypeID").value;
    if (p == "" || !/^\d+$/.test(p)) {
        alert("Transaction Type ID is invalid");
        return false;
    }
    return true;
}

function validateReportsForm() {
    let n = document.getElementById("startDate").value;
    if (n == "" || !/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/.test(n)) {
        alert("Bank Account ID is invalid");
        return false;
    }
    let u = document.getElementById("endDate").value;
    if (u == "" || !/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/.test(u)) {
        alert("Date Made is invalid");
        return false;
    }
    return true;
}