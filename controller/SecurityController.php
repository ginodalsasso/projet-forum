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
    

    //----------------------------------------------------Registration / Connexion----------------------------------------------------


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
                // vérifie si l'email ou le pseudo n'éxiste pas dans la BDD
                $verifyEmail = $userManager->findOneByEmail($email);
                $verifyPseudo = $userManager->findOneByPseudo($pseudo);
                //si l'email existe en BDD aors
                if($verifyEmail){
                    Session::addFlash("error", "L'adresse e-mail est déjà utilisée par un autre utilisateur.");
                    $this->redirectTo("forum", "viewProfil");
                    exit;
                }

                //si le pseudo existe en BDD aors
                if($verifyPseudo){
                    Session::addFlash("error", "Le pseudo est déjà utilisé par un autre utilisateur.");
                    $this->redirectTo("forum", "viewProfil");
                    exit;
                }
                // éxige au minimum: 8 caractères, une minuscule, une majuscule, un chiffre, un caractère spécial dans le mot de passe
                $regexPassword = preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass1);
                //si l'utilisateur existe (email et pseudo) alors
                if($verifyEmail && $verifyPseudo){
                    //redirection et traitement des messages
                    Session::addFlash("error", "Votre pseudo et/ou adresse email sont déjà utilisés !");
                    // header("Location: index.php?ctrl=security&action=register"); exit;
                    $this -> redirectTo("security", "register"); exit;
                } else{
                    //insertion de l'utilisateur en BDD si les deux mdp match
                    if($pass1 == $pass2 && $regexPassword) {//ici je vérifie si les deux mdp sont identiques et donne les conditions du mdp (regex ...)
                        //tableau attendu par la fonction dans app\Manager add($data)
                        //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];
                        $data = [
                            'pseudo' => $pseudo, 
                            'email' => $email, 
                            'password' => password_hash($pass1, PASSWORD_DEFAULT), 
                            "role" => "ROLE_USER"
                        ];

                        $userManager->add($data);
                        $this -> redirectTo("security", "login"); exit;
                    }
                    //si mauvaise saison de mot de pas alors message et redirection
                    Session::addFlash("error", "Mauvaise saisie de mot de passe ! Votre mot de passe doit contenir au minimum 8 caractères, une minuscule, une majuscule, un chiffre, un caractère spécial.");
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

    
    // login----------------------------------------------------
    public function addLogin () {
        $userManager = new UserManager();
        if($_POST['submit']){
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //si les filtres sont valides
            if($pseudo && $password){
                // vérifie si le pseudo n'éxiste pas dans la BDD sinon false est assigné
                $user = $userManager->findOneByPseudo($pseudo);
                //si le pseudo est différent de NULL alors
                if($user != NULL){
                    //je récupère le mot de passe en BDD suite à la requête précédente
                    $hash = $user->getPassword();

                    //compare le mot de passe saisi à  l'emprunte numérique en BDD si ok alors
                    if(password_verify($password, $hash)){
                        $_SESSION["user"] = $user; // stock en session l'intégralité de notre tableau $user (nous pourrions en stocker qu'une partie)
                    }else{
                        Session::addFlash("error", "Pseudo ou mot de passe incorrect !");
                        $this -> redirectTo("security", "login"); exit;
                    }
                }else{
                    Session::addFlash("error", "Utilisateur inconnu ou mot de passe incorrect !");
                    $this -> redirectTo("security", "login"); exit;
                }
                $this -> redirectTo("forum", "listCategory"); exit;
            }
        } 
    }

    public function logout () {
        //unset supprime une partie d'un tableau ou un tableau complet
        unset($_SESSION["user"]);
        $this -> redirectTo("home", "index"); exit;
    }


    //----------------------------------------------------Profil----------------------------------------------------


    //affichage de la vue de profil d'un utilisateur($id))----------------------------------------------------
    public function viewProfil(){
        $userManager = new UserManager();
        $user = Session::getUser();
        
        if(Session::getUser()->getId() || Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/profil.php",
                "meta_description" => "Mon profil",
                "data" => [
                    "user" => $user
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }             

    //affichage de la vue de modification de profil d'un utilisateur($id))----------------------------------------------------
    public function viewUpdateProfil(){
        $userManager = new UserManager();
        $user = Session::getUser();
        
        if(Session::getUser()->getId() || Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/update/updateProfil.php",
                "meta_description" => "Modifier mon profil",
                "data" => [
                    "user" => $user
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }    

    //affichage de la vue de modification de mot de passe d'un utilisateur($id))----------------------------------------------------
    public function viewUpdatePassword(){
        $userManager = new UserManager();
        $user = Session::getUser();
        
        if(Session::getUser()->getId() || Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/update/updatePassword.php",
                "meta_description" => "Modifier mon mot de passe",
                "data" => [
                    "user" => $user
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }             
    
    //modifier le profil($id)----------------------------------------------------
    public function updateAccount($id){
        $userManager = new UserManager();
        // Si l'utilisateur connecté = à l'user en session ou si l'admin est connecté alors
        if((Session::getUser()->getId()) || Session::isAdmin()){
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            
            // vérifie si l'email ou le pseudo n'éxiste pas dans la BDD
            if($pseudo && $email){
                $verifyPseudo = $userManager->findOneByPseudo($pseudo);
                $verifyEmail = $userManager->findOneByEmail($email);

                // vérifie si un utilisateur avec cet e-mail existe en BDD et si l'ID de l'utilisateur trouvé n'est pas égal à l'ID de l'utilisateur actuel en cours de modification
                if($verifyEmail && $verifyEmail->getId() !== $id){
                    Session::addFlash("error", "L'adresse e-mail est déjà utilisée par un autre utilisateur.");
                    $this->redirectTo("forum", "viewProfil");
                    exit;
                }
    
                if($verifyPseudo && $verifyPseudo->getId() !== $id){
                    Session::addFlash("error", "Le pseudo est déjà utilisé par un autre utilisateur.");
                    $this->redirectTo("forum", "viewProfil");
                    exit;
                }
                
                $data = [
                    "id" => $id,
                    "email" => $email,
                    "pseudo" => $pseudo
                ];

                $sqlUpdate = "pseudo = :pseudo, email = :email";
                $userManager->updateUser($data, $sqlUpdate); 
                unset($_SESSION['user']);
                
                Session::addFlash("success", "Votre compte à été modifié !");
                $this -> redirectTo("forum", "update", "updateProfil", $id); exit;
            
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }
    }

    // modifier le mot de passe($id)----------------------------------------------------
    public function updatePassword($id){
        $userManager = new UserManager();
        // Si l'utilisateur connecté = à l'user en session ou si l'admin est connecté alors
        if((Session::getUser()->getId()) || Session::isAdmin()){
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($pass1 && $pass2){
                // éxige au minimum: 8 caractères, une minuscule, une majuscule, un chiffre, un caractère spécial dans le mot de passe
                $regexPassword = preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass1);
                
                //insertion du password en BDD si les deux mdp match
                if($pass1 == $pass2 && $regexPassword) {//ici je vérifie si les deux mdp sont identiques et donne les conditions du mdp (regex ...)
                    //tableau attendu par la fonction dans app\Manager add($data)
                $data = [
                    "id" => $id,
                    "password" => password_hash($pass1, PASSWORD_DEFAULT)
                ];

                $sqlUpdate = "password = :password";
                $userManager->updatePassword($data, $sqlUpdate);      
                // var_dump($userManager);die;
                    unset($_SESSION['user']);
                }
                
                Session::addFlash("success", "Votre mot de passe à été modifié !");
                $this -> redirectTo("forum", "update", "updateProfil", $id); exit;
            
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }
    }

    //suppression d'un user($id)----------------------------------------------------
    public function deleteAccount($id){
        $userManager = new UserManager();

        // Si l'utilisateur connecté = à l'user en session ou si l'admin est connecté alors
        if((Session::getUser()->getId()) || Session::isAdmin()){
            $userManager->delete($id);
            unset($_SESSION['user']);

            Session::addFlash("success", "Votre compte  à été supprimé !");
            $this -> redirectTo("forum", "index"); exit;
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }
    
}