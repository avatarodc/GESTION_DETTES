document.addEventListener("DOMContentLoaded", function () {
    const btnAddNew = document.getElementById('btnAddNew');
    const popup = document.getElementById('popup');
    const btnClosePopup = document.getElementById('btnClosePopup');

    btnAddNew.addEventListener('click', function () {
        popup.classList.remove('hidden');
    });

    btnClosePopup.addEventListener('click', function () {
        popup.classList.add('hidden');
    });

    // Recherche en temps réel
    const searchInput = document.getElementById('searchInput');
    const membersTable = document.getElementById('membersTable');
    const tableRows = membersTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function () {
        const searchTerm = searchInput.value.toLowerCase();
        for (let row of tableRows) {
            const cells = row.getElementsByTagName('td');
            let rowContainsTerm = false;
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    rowContainsTerm = true;
                    break;
                }
            }
            if (rowContainsTerm) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
