<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct()
    {
        parent::connect();
    }

    //méthode qui retrouve l'email qui a été renseigné 
    public function findOneByEmail($email)
    {
        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.email = :email";

        // la requête renvoie d'un enregistrement --> getOneOrNullResult
        return  $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    //méthode qui retrouve le pseudo qui a été renseigné 
    public function findOneByPseudo($pseudo)
    {
        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.pseudo = :pseudo";

        // la requête renvoie d'un enregistrement --> getOneOrNullResult
        return  $this->getOneOrNullResult(
            DAO::select($sql, ['pseudo' => $pseudo], false),
            $this->className
        );
    }

    public function profile($id)
    {

        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.user_id = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function updateUser($data, $sqlUpdate)
    {
        $sql = "UPDATE user u
                SET " . $sqlUpdate . "
                WHERE u.id_user = :id
        ";
        return DAO::update($sql, [
            'id' => $data["id"],
            'email' => $data["email"],
            'pseudo' => $data["pseudo"],
        ]);
    }

    public function updatePassword($data, $sqlUpdate)
    {
        $sql = "UPDATE user u
                SET " . $sqlUpdate . "
                WHERE u.id_user = :id
        ";
        return DAO::update($sql, [
            'id' => $data["id"],
            'password' => $data["password"],
        ]);
    }
}
