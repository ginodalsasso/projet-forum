<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }

    public function deleteContentCategory($id){
        $sql = "DELETE c, t, p
                FROM category c
                INNER JOIN topic t ON c.id_category = t.category_id
                INNER JOIN post p ON t.id_topic = p.topic_id
                WHERE c.id_category = :id";
                
                return DAO::delete($sql, ['id' => $id]); 
    }

    public function updateCategory($data, $id)
    {

        $sql = "UPDATE category
                SET ". $data ."
                WHERE id_category = :id
        ";
        return DAO::update($sql, ['id' => $id]);
    }

    //count pour le nombre de topic et l'affichage de chaque catégories
    public function findAllCategories(){
        $sql = "SELECT   c.name, c.id_category , COUNT(t.id_topic) AS nbTopics
                FROM category c
                LEFT JOIN topic t ON c.id_category = t.category_id
                GROUP BY c.id_category
                ORDER BY c.name";

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }


    public function lastPostInCategory($id){
        $sql = "SELECT CONCAT(:u.pseudo, :p.creationDate) AS lastPost
                FROM post p
                INNER JOIN user u ON p.user_id = u.id_user
                INNER JOIN topic t ON p.topic_id = t.id_topic
                INNER JOIN category c ON t.category_id = c.id_category
                WHERE c.id_category = :id
                ORDER BY p.creationDate DESC
                LIMIT 1
                ";

    return $this->getOneOrNullResult(
        DAO::select($sql, ['id' => $id], false), 
        $this->className
    );
    }
}