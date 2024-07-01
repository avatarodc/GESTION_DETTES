<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 bg-purple-700 text-white min-h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Norsk Timeregistrering</h1>
            </div>
            <nav class="mt-6">
                <a href="/dette" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-800">Lister Dettese</a>
                <a href="/product" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-800">Clients</a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-800">Control Panel</a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-800">Projects</a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <!-- Top bar -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold">Members</h2>
                </div>
                <div class="flex items-center">
                    <span class="mr-4">Mamadou GUEYE</span>
                    <img class="w-8 h-8 rounded-full" src="path_to_avatar_image" alt="User Avatar">
                </div>
            </div>

            <!-- Search bar -->
            <div class="flex items-center mb-4">
                <input type="text" id="searchInput" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="Search...">
                <button id="searchButton" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 transition duration-200">Search</button>
            </div>

            <!-- Bouton pour ajouter une dette -->
            <div class="flex items-center mb-4">
                <button id="btnAddNew" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">Ajouter une dette</button>
            </div>

            <!-- Members table -->
            <div class="bg-white p-6 rounded-lg shadow">
                <table id="membersTable" class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-purple-700 text-white">
                            <th class="px-4 py-2">Date Création</th>
                            <th class="px-4 py-2">Montant Total</th>
                            <th class="px-4 py-2">Client</th>
                            <th class="px-4 py-2">Telephone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dettes as $dette) : ?>
                            <tr>
                                <td class="px-4 py-2"><?= $dette['datecreation'] ?></td>
                                <td class="px-4 py-2"><?= $dette['montant_total'] ?></td>
                                <td class="px-4 py-2"><?= $dette['nom'] . ' ' . $dette['prenom'] ?></td>
                                <td class="px-4 py-2"><?= $dette['client_telephone']  ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <?php
                $totalPages = ceil($totalRows / $limit);
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i' class='bg-gray-200 text-gray-700 px-4 py-2 rounded'>$i</a>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Popup -->
 
    <div id="popup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Ajouter une Dette</h2>
            <form action="/dette" method="POST">
                <div class="mb-4">
                    <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                    <input type="text" id="client" name="client" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Rechercher par numéro de téléphone" required>
                </div>
                <div class="mb-4">
                    <label for="produit" class="block text-sm font-medium text-gray-700">Produit</label>
                    <select id="produit" name="produit" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php foreach ($produits as $produit) : ?>
                            <option value="<?= $produit['id'] ?>"><?= $produit['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" id="quantite" name="quantite" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Enregistrer</button>
                    <button type="button" id="btnClosePopup" class="ml-4 bg-gray-400 text-white px-4 py-2 rounded">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnAddNew = document.getElementById('btnAddNew');
            const popup = document.getElementById('popup');
            const btnClosePopup = document.getElementById('btnClosePopup');

            btnAddNew.addEventListener('click', function() {
                popup.classList.remove('hidden');
            });

            btnClosePopup.addEventListener('click', function() {
                popup.classList.add('hidden');
            });

            // Recherche en temps réel
            const searchInput = document.getElementById('searchInput');
            const membersTable = document.getElementById('membersTable');
            const tableRows = membersTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
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

        // Recherche en temps réel pour le client par numéro de téléphone
        const clientInput = document.getElementById('client');
        clientInput.addEventListener('keyup', function() {
            const searchTerm = clientInput.value.trim().toLowerCase();
            filterTableByClient(searchTerm);
        });

        // Fonction pour filtrer le tableau par numéro de téléphone du client
        function filterTableByClient(searchTerm) {
            for (let row of tableRows) {
                const cells = row.getElementsByTagName('td');
                const clientPhoneNumber = cells[2].textContent.trim().toLowerCase(); // Index 2 correspond à la colonne du numéro de téléphone du client
                if (clientPhoneNumber.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

    //     document.addEventListener("DOMContentLoaded", function() {

    //         const form = document.querySelector('form');
    //         form.addEventListener('submit', function(event) {
    //             event.preventDefault();
    //             const produitInput = document.getElementById('produit');
    //             const produitError = document.getElementById('produitError');

    //             // Faire une requête AJAX pour vérifier si le produit existe
    //             const produitValue = produitInput.value.trim().toLowerCase();
    //             fetch(`http://www.mamadou.gueye:2711/dette?page=1&produit=${encodeURIComponent(produitValue)}`)
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     if (data.exists) {
    //                         form.submit();
    //                     } else {
    //                         produitError.classList.remove('hidden');
    //                     }
    //                 })
    //                 .catch(error => {
    //                     console.error('Erreur lors de la vérification du produit :', error);
    //                 });
    //         });
    //         document.addEventListener("DOMContentLoaded", function() {
    // const form = document.querySelector('form');
    // form.addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     const produitInput = document.getElementById('produit');
    //     const produitError = document.getElementById('produitError');

    //     // Faire une requête AJAX pour vérifier si le produit existe
    //     const produitValue = produitInput.value.trim().toLowerCase();
    //     fetch(`/verifyProductExists/${encodeURIComponent(produitValue)}`) // Adapter l'URL à votre structure de route
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.exists) {
    //                 // Le produit existe, soumettre le formulaire
    //                 form.submit();
    //             } else {
    //                 // Le produit n'existe pas, afficher un message d'erreur
    //                 produitError.classList.remove('hidden');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Erreur lors de la vérification du produit :', error);
    //         });
    // });
// });

//         });
    </script>

</body>

</html>