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

}