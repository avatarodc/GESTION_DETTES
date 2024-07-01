<?php

require_once MODEL . 'Dette.php';

class DetteController {
    private $detteModel;

    public function __construct() {
        $this->detteModel = new DetteModel();
    }

    public function index() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
    
        $dettes = $this->detteModel->getAllDettes($limit, $offset);
        $totalRows = $this->detteModel->getTotalDettesCount();
    
        // Récupérer tous les produits depuis le modèle pour le select
        $produits = $this->detteModel->getAllProduits();
    
        // Utilisez var_dump pour vérifier ce que retourne getAllProduits
        // var_dump($_SESSION['user']);
    
        require_once VIEWS . 'dette/index.php';
    }
    

    public function verifyProduct() {
        $produit = $_GET['produit'] ?? '';

        // Vérifier si le produit existe en utilisant le modèle
        $produitExists = $this->detteModel->checkProductExists($produit);

        // Retourner une réponse JSON indiquant si le produit existe ou non
        header('Content-Type: application/json');
        echo json_encode(['exists' => $produitExists]);
    }

    public function addDette() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client = $_POST['client'];
            $produit = $_POST['produit'];
            $quantite = $_POST['quantite'];

            try {
                // Récupérer l'ID du client par son numéro de téléphone
                $clientId = $this->detteModel->getClientIdByTelephone($client);
                
                // Récupérer l'ID du produit par son libellé
                $produitId = $this->detteModel->getProduitIdByLibelle($produit);
                
                // Récupérer l'ID de l'utilisateur à partir de la session
                $utilisateurId = $_SESSION['utilisateur_id'];

                // Insérer une nouvelle dette dans la base de données
                $detteId = $this->detteModel->insertDette(date('Y-m-d'), $clientId, $utilisateurId);
                
                // Récupérer le prix unitaire du produit par son ID
                $prixUnitaire = $this->detteModel->getProduitPrixById($produitId);

                // Insérer une nouvelle ligne de dette pour le produit spécifié
                $this->detteModel->insertLigneDette($quantite, $prixUnitaire, $detteId, $produitId);
                
                // Mettre à jour le stock du produit
                $this->detteModel->updateProduitStock($produitId, $quantite);

                // Rediriger vers la page des dettes après l'ajout
                header('Location: /dette');
                exit; // Arrêter l'exécution du script après la redirection
            } catch (Exception $e) {
                // En cas d'erreur, afficher un message d'erreur et éventuellement journaliser l'erreur
                echo 'Erreur lors de l\'ajout de la dette : ' . $e->getMessage();
                // Vous pouvez ajouter une redirection vers une page d'erreur ou une gestion spécifique ici
            }
        }
    }

    public function getProduitsForSelect() {
        $produits = $this->detteModel->getAllProduits();
        var_dump($produits);
        require_once VIEWS . 'dette/index.php';
    }
}


?>
