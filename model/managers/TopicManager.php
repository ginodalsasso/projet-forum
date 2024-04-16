<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    //connexion à la base de donnée (chez son parent Manager)
    public function __construct()
    {
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id)
    {

        $sql = "SELECT t.*, COUNT(p.id_post) AS nbPosts
                FROM " . $this->tableName . " t 
                INNER JOIN post p ON t.id_topic = p.topic_id
                WHERE t.category_id = :id
                GROUP BY t.id_topic";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    //topic d'un utilisateur
    public function findTopicsByUser($id)
    {
        $sql = "SELECT * from " . $this->tableName . " t
                WHERE t.user_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function lockedTopic($id)
    {
        $sql = "UPDATE topic SET closed = 1
                WHERE id_topic = :id";

        return  $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function unlockedTopic($id)
    {
        $sql = "UPDATE topic SET closed = 0
                WHERE id_topic = :id";

        return  $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findTopicByTitle($titre)
    {

        $sql = "SELECT *
                FROM " . $this->tableName . " t
                WHERE t.title = :title ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['title' => $titre], false),
            $this->className
        );
    }

    public function updateTopic($data, $id)
    {

        $sql = "UPDATE topic
                SET ". $data ."
                WHERE id_topic = :id
        ";
        return DAO::update($sql, ['id' => $id]);
    }
}
