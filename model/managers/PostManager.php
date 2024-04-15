<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    //connexion à la base de donnée (chez son parent Manager)
    public function __construct(){
        parent::connect();
    }

    
    // récupérer tous les posts d'un topic spécifique (par son id)
    public function findPostsByTopic($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." p 
                WHERE p.topic_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    //posts d'un utilisateur
    public function findPostsByUser($id){

        $sql = "SELECT *
                FROM ".$this->tableName." p
                WHERE p.id_user = :id
                ORDER BY p.creationDate DESC";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), $this->className
        );
    }

    //dernier post écris de la catégorie ($id)
    public function lastPost($id){
        $sql = "SELECT u.pseudo, p.creationDate
                FROM ".$this->tableName." p
                INNER JOIN user u ON p.user_id = u.id_user
                INNER JOIN topic t ON p.topic_id = t.id_topic
                INNER JOIN category c ON t.category_id = c.id_category
                WHERE c.id_".$this->tableName." = :id
                ORDER BY p.creationDate DESC
                LIMIT 1
                ";
    }
}