
let penyusutanTable;

document.addEventListener('DOMContentLoaded', function () {
    penyusutanTable = initGlobalDatatable('#table_penyusutan');
    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (penyusutanTable) penyusutanTable.ajax.reload();
        });
    });
});

