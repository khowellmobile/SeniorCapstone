const statementInput = document.getElementById('statementInput');
const reconciliation = document.getElementById('reconciliation');
const accountAdjustment = document.getElementById('accountAdjustment');
const reports = document.getElementById('reports');
const clients = document.getElementById('clients');

statementInput.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/test/statementInput.php");
})

reconciliation.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/test/reconciliation.php");
})
accountAdjustment.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/test/accountAdjustment.php");
})
reports.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/test/reports.php");
})
clients.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/test/test/clients.php");
})
