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

        $userManager = new UserManager();
        // vérifie si le form est submit
        if($_POST['submit']){
            //filter les champs "name" du formulaire d'inscription (faille XSS)
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($pseudo && $email && $pass1 && $pass2){
                // vérifie si le mail n'éxiste pas dans la BDD sinon false est assigné
                $verifyEmail = $userManager->findOneByEmail($email) ?? false;
                $verifyPseudo = $userManager->findOneByPseudo($pseudo) ?? false;
                //si l'utilisateur existe (email et pseudo) alors
                if($verifyEmail && $verifyPseudo){
                    //redirection et traitement des messages
                    Session::addFlash("error", "Votre pseudo et/ou adresse email sont déjà utilisés !");
                    // header("Location: index.php?ctrl=security&action=register"); exit;
                    $this -> redirectTo("security", "register"); exit;
                } else{
                    //insertion de l'utilisateur en BDD si les deux mdp match
                    if($pass1 == $pass2 && strlen($pass1) >= 6) {//ici je vérifie si les deux mdp sont identiques et donne les conditions du mdp (regex ...)
                        //tableau attendu par la fonction dans app\Manager add($data)
                        //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];
                        $data = ['pseudo' => $pseudo, 'email' => $email, 'password' => password_hash($pass1, PASSWORD_DEFAULT)];
                        $userManager->add($data);
                        // var_dump($userManager);die;
                        //stocke l'utilisateur en session
                        // $_SESSION["user"] = $user; 
                        $this -> redirectTo("security", "login"); exit;
                    }
                    //si mauvaise saison de mot de pas alors message et redirection
                    Session::addFlash("error", "Mauvaise saisie de mot de passe !");
                    $this -> redirectTo("security", "register"); exit;
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

        $userManager = new UserManager();
        // -- on filtre les champs du formulaire 
        // -- si les filtres passent, on retrouve le password correspondant au mail entré dans le formulaire ----condition if else erreur
        // -- si on le trouve, on récupère le hash de la base de données
        // -- on retrouve l'utilisateur correspondant ----mettre l'utilisateur en session, $_SESSION["user"] = $user;
        // -- on vérifie le mot de passe (password_verify)
        // -- si on arrive à se connecte, on fait passer le user en session
        // -- si aucune des conditions ne passent (mauvais mot de passe, utilisateur inexistant, etc) --> message d'erreur
        $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //si les filtres sont valides
        if($pseudo && $password){
            // vérifie si le mail n'éxiste pas dans la BDD sinon false est assigné
            $user = $userManager->findOneByPseudo($pseudo) ?? false;
            //si le pseudo est faux alors
            if($user){
                //je récupère le mot de passe eb BDD suite à la requête précédente
                $hash = $user["password"];
                //compare le mot de passe saisi à  l'emprunte numérique en BDD
                if(password_verify($password, $hash)){
                    $_SESSION["user"] = $user; // stock en session l'intégralité de notre tableau $user (nous pourrions en stocker qu'une partie)
                    //se servire de la méthode redirectTo ex: $this->redirectTo("security", "register");
                    $this -> redirectTo("forum", "listCategory"); exit;
                }else{
                    Session::addFlash("error", "Utilisateur inconnu ou mot de passe incorrect !");
                    $this -> redirectTo("security", "login"); exit;
                }
            }else{
                Session::addFlash("error", "Utilisateur inconnu ou mot de passe incorrect !");
                $this -> redirectTo("security", "login"); exit;
            }
        }
    }

    public function logout () {
        // $_SESSION["user"] = $user;
        //unset supprime une partie d'un tableau ou un tableau complet
        unset($_SESSION["user"]);
        $this -> redirectTo("security", "register"); exit;
    }
}