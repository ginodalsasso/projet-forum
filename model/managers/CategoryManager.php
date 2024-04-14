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

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
        );
    }
}