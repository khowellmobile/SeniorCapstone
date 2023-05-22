const statementInput = document.getElementById('statementInput');
const reconciliation = document.getElementById('reconciliation');
const accountAdjustment = document.getElementById('accountAdjustment');
const reports = document.getElementById('reports');

statementInput.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("https://ceclnx01.cec.miamioh.edu/~oneilfm/Capstone/saas-accounting-project/src/statementInput.html");
})

reconciliation.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("https://ceclnx01.cec.miamioh.edu/~oneilfm/Capstone/saas-accounting-project/src/reconciliation.html");
})
accountAdjustment.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("https://ceclnx01.cec.miamioh.edu/~oneilfm/Capstone/saas-accounting-project/src/accountAdjustment.html");
})
reports.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
    location.replace("https://ceclnx01.cec.miamioh.edu/~oneilfm/Capstone/saas-accounting-project/src/reports.html");
})
