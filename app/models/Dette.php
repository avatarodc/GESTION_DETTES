<?php

require_once COOR . 'database.php'; // Assurez-vous d'inclure correctement votre classe Database

class DetteModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function getAllDettes($limit, $offset) {
        $sql = "SELECT d.id, d.datecreation, d.montant_total, d.estsoldee, c.nom, c.prenom, c.telephone as client_telephone, u.nom, u.prenom, u.telephone as utilisateur_telephone
                FROM Dette d
                INNER JOIN Client c ON d.client_id = c.id
                INNER JOIN Utilisateur u ON d.utilisateur_id = u.id
                WHERE d.estsoldee = FALSE
                ORDER BY d.datecreation DESC
                LIMIT :limit OFFSET :offset";

        $params = [
            'limit' => $limit,
            'offset' => $offset
        ];
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalDettesCount() {
        $sql = "SELECT COUNT(*) AS total FROM Dette";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function checkProductExists($produit) {
        $sql = "SELECT COUNT(*) AS count FROM Produit WHERE libelle = :libelle";
        $params = ['libelle' => $produit];
        $stmt = $this->db->query($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['count'] > 0);
    }

    public function insertDette($dateCreation, $clientId, $utilisateurId) {
        $sql = "INSERT INTO Dette (dateCreation, montant_Total, estSoldee, client_id, utilisateur_id) 
                VALUES (:dateCreation, 0.00, FALSE, :clientId, :utilisateurId) 
                RETURNING id";
        
        $params = [
            'dateCreation' => $dateCreation,
            'clientId' => $clientId,
            'utilisateurId' => $utilisateurId
        ];

        $stmt = $this->db->query($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function insertLigneDette($quantite, $prixUnitaire, $detteId, $produitId) {
        $sql = "INSERT INTO LigneDette (quantite, prixUnitaire, dette_id, produit_id) 
                VALUES (:quantite, :prixUnitaire, :detteId, :produitId)";
        
        $params = [
            'quantite' => $quantite,
            'prixUnitaire' => $prixUnitaire,
            'detteId' => $detteId,
            'produitId' => $produitId
        ];

        $this->db->query($sql, $params);
    }

    public function updateProduitStock($produitId, $quantite) {
        $sql = "UPDATE Produit 
                SET quantiteStock = quantiteStock - :quantite 
                WHERE id = :produitId";
        
        $params = [
            'quantite' => $quantite,
            'produitId' => $produitId
        ];

        $this->db->query($sql, $params);
    }

    public function getClientIdByTelephone($telephone) {
        echo "Appel de la méthode getClientIdByTelephone avec le téléphone: $telephone\n";
        $sql = "SELECT id FROM Client WHERE telephone = :telephone";
        $params = ['telephone' => $telephone];
        $stmt = $this->db->query($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function getProduitIdByLibelle($libelle) {
        echo "Appel de la méthode getProduitIdByLibelle avec le libellé: $libelle\n";
        $sql = "SELECT id FROM Produit WHERE libelle = :libelle";
        $params = ['libelle' => $libelle];
        $stmt = $this->db->query($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    public function getProduitPrixById($produitId) {
        echo "Appel de la méthode getProduitPrixById avec l'ID produit: $produitId\n";
        $sql = "SELECT prix FROM Produit WHERE id = :produitId";
        $params = ['produitId' => $produitId];
        $stmt = $this->db->query($sql, $params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['prix'];
    }

    public function getAllProduits() {
        $sql = "SELECT id, libelle FROM Produit ORDER BY libelle";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
