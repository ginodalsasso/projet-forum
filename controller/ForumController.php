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

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategory.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function listPostsByTopics($id) {

        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts par topic : ".$topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }

    //ajout d'un post dans un topic($id)
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
                $this -> redirectTo("forum", "listPostsByTopics", $id); exit;
            }
        }
    }

    //vérouillage d'un topic($id) par l'utilisateur créateur ou l'admin
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
                $this -> redirectTo("forum", "listCategory"); exit;
            }
    }

    //devérouillage d'un topic($id) par l'utilisateur créateur ou l'admin
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
                $this -> redirectTo("forum", "listCategory"); exit;
            }
    }
}