<?php
include_once MODEL.'User.php';


class AuthController extends Controller {
    public function __construct() {
        $this->table = 'Utilisateur';
        parent::__construct();
    }
    

    // Fonction pour vérifier si l'utilisateur est connecté
public static function checkAuthentication() {
    if (!isset($_SESSION['user'])) {
        header("Location: /login"); // Rediriger vers la page de connexion
        exit;
    }
}


    // Méthode pour vérifier l'authentification
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_REQUEST['login'];
            $motdepasse = $_REQUEST['motdepasse'];

            
            try {
                $query = "SELECT * FROM " . $this->table . " WHERE login = :login AND motdepasse = :mdp";


                $result = $this->db->query($query, [
                    'login' => $login,
                    'mdp' => $motdepasse
                ]);

                $user = $result->fetch(PDO::FETCH_ASSOC);

                if($result->rowCount() > 0 && ($user['motdepasse'] == $motdepasse && $user['login'] == $login)) {
                    $_SESSION['user'] = $user;
                    header("Location: /home");
                    exit;
                }else{
                    header("Location: /");
                }
            } catch (PDOException $e) {
                // En cas d'erreur SQL, afficher l'erreur
                echo "Erreur SQL : " . $e->getMessage();
            }
            die;

        }
    }
}





// $user = new User($this->conn);
            // $user->id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
            // $user->nom = $stmt->fetch(PDO::FETCH_ASSOC)['nom'];
            // $user->prenom = $stmt->fetch(PDO::FETCH_ASSOC)['prenom'];
            // $user->login = $stmt->fetch(PDO::FETCH_ASSOC)['login'];
            // $user->motdepasse = $stmt->fetch(PDO::FETCH_ASSOC)['motdepasse'];
            // $user->role_id = $stmt->fetch(PDO::FETCH_ASSOC)['role_id'];

            // var_dump($user);
?>


