const statementInput = document.getElementById('statementInput');
const reconciliation = document.getElementById('reconciliation');
const accountAdjustment = document.getElementById('accountAdjustment');
const clientRegister = document.getElementById('clientRegister');
const reports = document.getElementById('reports');
const clients = document.getElementById('clients');

statementInput.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/statementInput.php");
})

reconciliation.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/reconciliation.php");
})
accountAdjustment.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/accountAdjustment.php");
})
clientRegister.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/clientRegister.php");
})
reports.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/reports.php");
})
clients.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/clients.php");
})
