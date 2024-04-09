<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    
    // Affiche la vue du formulaire register
    public function register () {
        return [
            "view" => VIEW_DIR."security/register.php",
            "meta_description" => "Formulaire d'inscription"
        ]; 
    }
    
    public function addRegister () {
        //-- on filtre les champs du formulaire
        // -- si les filtres sont valides, on vérifie que le mail n'existe pas déjà (sinon message d'erreur) ----condition if else erreur
        // -- on vérifie que le pseudo n'existe pas non plus (sinon message d'erreur) -----condition if else erreur
        // -- on vérifie que les 2 mots de passes du formulaire soient identiques, simple comparaison de string if password1 == password2 -----condition if else erreur
        // -- si c'est le cas, on hash le mot de passe (password_hash) -----alors on hash
        // -- on ajoute l'utilisateur en base de données
       
        $userManager = new UserManager();
        // vérifie si le form est submit
        if($_POST['submit']){
            //filter les champs "name" du formulaire d'inscription (faille XSS)
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            var_dump($pseudo);
            if($pseudo && $email && $pass1 && $pass2){
                // vérifie si le mail n'éxiste pas dans la BDD sinon false est assigné
                $verifyEmail = $userManager->findOneByEmail($email) ?? false;
                $verifyPseudo = $userManager->findOneByPseudo($pseudo) ?? false;

                //si l'utilisateur existe (email et pseudo)
                if($verifyEmail && $verifyPseudo){
                    //redirection et traitement des messages votre adresse mail existe déjà
                    header("Location: index.php?ctrl=security&action=login"); exit;
                } else{
                    //insertion de l'utilisateur en BDD 
                    if($pass1 == $pass2 && strlen($pass1) >= 6) {//ici je vérifie si les deux mdp sont identiques et donne les conditions du mdp (regex ...)
                        $insertUser = $pdo -> prepare("INSERT INTO user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
                        $insertUser -> execute ([
                            "pseudo" => $pseudo,
                            "email" => $email,
                            "password" => password_hash($pass1, PASSWORD_DEFAUT) //version hashée stockée en BDD
                        ]);
                        header("Location: index.php?ctrl=security&action=login"); exit;
                    }
                }
            }
        }
    }


    // Affiche la vue du formulaire login
    public function login () {
        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Formulaire de connexion"
        ]; 
    }

    public function addLogin () {
        // -- on filtre les champs du formulaire 
        // -- si les filtres passent, on retrouve le password correspondant au mail entré dans le formulaire ----condition if else erreur
        // -- si on le trouve, on récupère le hash de la base de données
        // -- on retrouve l'utilisateur correspondant ----mettre l'utilisateur en session, $_SESSION["user"] = $user;
        // -- on vérifie le mot de passe (password_verify)
        // -- si on arrive à se connecte, on fait passer le user en session
        // -- si aucune des conditions ne passent (mauvais mot de passe, utilisateur inexistant, etc) --> message d'erreur
    }

    public function logout () {
        // $_SESSION["user"] = $user;
    }
}