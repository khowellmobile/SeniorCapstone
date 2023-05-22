const statementInput = document.getElementById('statementInput');
const reconciliation = document.getElementById('reconciliation');
const accountAdjustment = document.getElementById('accountAdjustment');
const reports = document.getElementById('reports');

statementInput.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/statementInput.php");
})

reconciliation.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/reconciliation.php");
})
accountAdjustment.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/accountAdjustment.php");
})
reports.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("http://scribe.capstone.csi.miamioh.edu/reports.php");
})