<?php

class User {
    // Propriétés
    public $id;
    public $nom;
    public $prenom;
    public $login;
    public $motdepasse;
    public $role_id;

    protected $conn; // Propriété pour stocker la connexion

    // Constructeur
    public function __construct($db) {
        $this->conn = $db;
    }

    //récupérer un utilisateur par son ID
    public function getUserById($id) {
        $query = "SELECT * FROM Utilisateur WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }
}
