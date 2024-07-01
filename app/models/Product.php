<?php

// src/php/models/Produit.php
class Produit {
    private $conn;
    private $table_name = "Produit";

    public $id;
    public $libelle;
    public $prix;
    public $quantiteStock;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT id, libelle, prix, quantitestock FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // lire un produit specifique
    public function readOne($id) {
        $query = "SELECT id, libelle, prix, quantitestock FROM " . $this->table_name . " WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
?>
