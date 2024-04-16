<?php
namespace Controller;

use App\Session;
use App\DAO;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface{

    //----------------------------------------------------Affichage----------------------------------------------------

    //affichage de l'index soit la liste des catégories)----------------------------------------------------
    public function index() {
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        $postManager = new PostManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);
        // $categories->findOneById($id);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategory.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories,
            ]
        ];
    }

    //affichage de la liste des topics avec catégorie ($id))----------------------------------------------------
    public function listTopicsByCategory($id) {
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        if(Session::getUser()){
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "meta_description" => "Liste des topics par catégorie : ".$category,
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }else{
            Session::addFlash("error", "Veuillez vous inscrire ou vous connecter pour accéder au contenu du forum !");
            $this -> redirectTo("forum", "index"); exit;
        }
    }

    //affichage de la liste des posts d'un topic($id))----------------------------------------------------
    public function listPostsByTopics($id) {
        $categoryManager = new CategoryManager();
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        //appel un objet (entité Category)
        $category = $topic->getCategory();
        //appel une méthode de postManager ($id topic)
        $posts = $postManager->findPostsByTopic($id);

        if(Session::getUser()){
            return [
                "view" => VIEW_DIR."forum/listPosts.php",
                "meta_description" => "Liste des posts par topic : ".$topic,
                "data" => [
                    "category" => $category,
                    "topic" => $topic,
                    "posts" => $posts
                ]
            ];
        }else{
            Session::addFlash("error", "Veuillez vous inscrire ou vous connecter pour accéder au contenu du forum !");
            $this -> redirectTo("forum", "index"); exit;
        }
    }

    //affichage de la vue update d'un post($id))----------------------------------------------------
    public function viewUpdatePost($id){
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);

        if(($post->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/update/updatePost.php",
                "meta_description" => "Modifier un post",
                "data" => [
                    "post" => $post
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }  

    //affichage de la vue update d'un topic($id))----------------------------------------------------
    public function viewUpdateTopic($id){
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        if(($topic->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/update/updateTopic.php",
                "meta_description" => "Modifier un topic",
                "data" => [
                    "topic" => $topic
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }    

    //affichage de la vue update d'une categorie($id))----------------------------------------------------
    public function viewUpdateCategory($id){
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);

        if(Session::isAdmin()){
            return [
                "view" => VIEW_DIR."forum/update/updateCategory.php",
                "meta_description" => "Modifier un topic",
                "data" => [
                    "category" => $category
                ]
            ];
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }   
    
    

    //----------------------------------------------------Category----------------------------------------------------

    //ajout d'une catégorie----------------------------------------------------
    public function addCategory(){
        if(Session::isAdmin()){
            if($_POST['submit']){
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if($name){
                        $categoryManager = new CategoryManager();
                        //tableau attendu par la fonction dans app\Manager add($data) pour l'ajout des données en BDD
                        //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];
                        $data = ['name' => $name];
                        $categoryManager->add($data);
                        $this -> redirectTo("forum", "index"); exit;
                    }else{
                        Session::addFlash("error", "Une erreur est survenue, réessayez.");
                        $this -> redirectTo("forum", "index"); exit;
                    }
                } else{
                    Session::addFlash("error", "Veuillez vous inscrire ou vous connecter pour accéder au contenu du forum !");
                    $this -> redirectTo("forum", "index"); exit;
                }
            }
            $this -> redirectTo("forum", "index"); exit;
    }

    //suppression d'une catégorie($id)----------------------------------------------------
    public function deleteCategory($id){
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);

        // si l'admin est connecté alors
        if(Session::isAdmin()){

            $categoryManager->delete($id);

            Session::addFlash("success", "La catégorie est supprimée !");
            $this -> redirectTo("forum", "index"); exit;
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }

    // modification d'une catégorie($id)----------------------------------------------------
    public function updateCategory($id){
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);  
    
        // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
        if(Session::isAdmin()){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($name){

                $data = "name = '". $name ."'";
                $categoryManager->updateCategory($data, $id);

                Session::addFlash("success", "La catégorie est modifiée !");
                $this -> redirectTo("forum", "index"); exit;
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }
    }
    //----------------------------------------------------Topic----------------------------------------------------

    //ajout d'un topic dans une catégorie($id))----------------------------------------------------
    public function addTopic($id){
        if($_POST['submit']){
            if(Session::getUser()){
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if($title && $text){
                    // récupère l'id de l'user ayant créé le topic et du coup le post aussi
                    $idUser = Session::getUser() -> getId();
                    $topicManager = new TopicManager();
                    //tableau attendu par la fonction dans app\Manager add($data) pour l'ajout des données en BDD
                    //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];
                    $dataTopic = ['title' => $title, 'user_id' => $idUser, 'category_id' => $id];
                    //initialisation de la variable pour récupérer l'id du nouveau topic
                    $idTopic = $topicManager->add($dataTopic);
                    $postManager = new PostManager();
                    //insertion du nouveau poste en BDD
                    $dataPost = ['text' => $text, 'user_id' => $idUser, 'topic_id' => $idTopic];
                    $postManager->add($dataPost);
                    $this -> redirectTo("forum", "listTopicsByCategory", $id); exit;
                }else{
                    Session::addFlash("error", "Une erreur est survenue, réessayez.");
                    $this -> redirectTo("forum", "listTopicsByCategory", $id); exit;
                }
            } else{
                Session::addFlash("error", "Veuillez vous inscrire ou vous connecter pour accéder au contenu du forum !");
                $this -> redirectTo("forum", "listTopicsByCategory", $id); exit;
            }
        }
        $this -> redirectTo("forum", "index"); exit;
    }

    //suppression d'un topic($id)----------------------------------------------------
    public function deleteTopic($id){
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $postManager = new postManager();
        $posts = $postManager->findPostsByTopic($id);
    
        // si l'admin est connecté alors
        if(Session::isAdmin()){  
            //boucle sur chaque post du topic, récupère l'id du post puis le supprime (grace à l'action (lors d'un DELETE) sur heidiSQL en "Cascade" permet d'éviter de boucler comme suit)
            foreach($posts as $post) {
                $idPost = $post->getId();
                $postManager->delete($idPost); 
            }
            $topicManager->delete($id);
            Session::addFlash("success", "Le topic est supprimé !");
            //récupère getCategory de l'entité Topic et son ID
            $this -> redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId()); exit;
        } else {
            Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
            $this -> redirectTo("forum", "index"); exit;
        }
    }
    
    
    //vérouillage d'un topic($id) par l'utilisateur créateur ou l'admin)----------------------------------------------------
    public function lockedTopics($id){
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        
        // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
        if(($topic->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
                $topicManager->lockedTopic($id);
                Session::addFlash("success", "Le topic est vérouillé !");
                $this -> redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId()); exit;
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }

        
        //devérouillage d'un topic($id) par l'utilisateur créateur ou l'admin)----------------------------------------------------
        public function unlockedTopics($id){
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($id);
        
            // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
            if(($topic->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
                $topicManager->unlockedTopic($id);
                Session::addFlash("success", "Le topic est devérouillé !");
                $this -> redirectTo("forum", "listTopicsByCategory", $topic->getCategory()->getId()); exit;
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }

        // modification d'un topic($id)----------------------------------------------------
        public function updateTopic($id){
            $topicManager = new TopicManager();
            $topic = $topicManager->findOneById($id);  
        
            // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
            if(($topic->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($title){

                    $data = "title = '". $title ."'";
                    // var_dump($data);die;
                    $topicManager->updateTopic($data, $id);

                    Session::addFlash("success", "Le topic est modifié !");
                    $this -> redirectTo("forum", "listPostsByTopics", $id); exit;
                } else {
                    Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                    $this -> redirectTo("forum", "index"); exit;
                }
            }
        }

        //----------------------------------------------------Post----------------------------------------------------
    
        //ajout d'un post dans un topic($id)----------------------------------------------------
        public function addPost($id){
            //si l'utilisateur est connecté
            if($_POST['submit']){
                //si l'utilisateur est connecté
                if(Session::getUser()){          
                    $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    if($text){
                        $postManager = new PostManager();
                        // récupère l'id de l'user ayant créé le post
                        $idUser = Session::getUser() -> getId();
                        //tableau attendu par la fonction dans app\Manager add($data) pour l'ajout des données en BDD
                        //$data = ['username' => 'Squalli', 'password' => 'dfsyfshfbzeifbqefbq', 'email' => 'sql@gmail.com'];
                        $data = ['text' => $text, 'user_id' => $idUser, 'topic_id' => $id];
                        $postManager->add($data);
                        $this -> redirectTo("forum", "listPostsByTopics", $id); exit;
                    } else {
                        Session::addFlash("error", "Une erreur est survenue, réessayez.");
                        $this -> redirectTo("forum", "listPostsByTopics", $id); exit;
                    }
                } else{
                    Session::addFlash("error", "Veuillez vous inscrire ou vous connecter pour écrire un message.");
                    $this -> redirectTo("forum", "index"); exit;
                }
            }
        }

        // modification d'un post($id)----------------------------------------------------
        public function updatePost($id){
            $postManager = new postManager();
            $post = $postManager->findOneById($id);
        
            // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
            if(($post->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
                
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                if($text){

                    $data = "text = '". $text ."'";
                    $postManager->updatePost($data, $id);
                    // var_dump($postManager);die;
                    Session::addFlash("success", "Le message est modifié !");
                    //récupère getTopic de l'entité Post et son ID
                    $this -> redirectTo("forum", "listPostsByTopics", $post->getTopic()->getId()); exit;
                } else {
                    Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                    $this -> redirectTo("forum", "index"); exit;
                }
            }
        }

        //suppression d'un post($id)----------------------------------------------------
        public function deletePost($id){
            $postManager = new postManager();
            $post = $postManager->findOneById($id);
        
            // si l'user associé au topic est identique à l'user actuellement connecté à la session ou si l'admin est connecté alors
            if(($post->getUser()->getId() === Session::getUser()->getId()) || Session::isAdmin()){
                $postManager->delete($id);
                Session::addFlash("success", "Le message est supprimé !");
                //récupère getTopic de l'entité Post et son ID
                $this -> redirectTo("forum", "listPostsByTopics", $post->getTopic()->getId()); exit;
            } else {
                Session::addFlash("error", "Une erreur est survenue, réessayez ou assurez vous d'avoir les droits.");
                $this -> redirectTo("forum", "index"); exit;
            }
        }




    }

