<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $pseudo;
    private $password;
    private $email;
    private $role;
    private $creationDate;
    private $banned;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of pseudo
     */ 
    public function getPseudo(){
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo($pseudo){
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    // check le rôle de l'utilisateur 
    public function hasRole($role){
        
        if ($this->getRole() === $role){
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        $date = new \DateTime($this->creationDate);
        return $date->format("d-m-Y");    
    }
    
    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        
        return $this;
    }

    
    /**
     * Get the value of banned
     */ 
    public function getBanned()
    {
        return $this->banned;
    }
    
    /**
     * Set the value of banned
     *
     * @return  self
     */ 
    public function setBanned($banned)
    {
        $this->banned = $banned;
        
        return $this;
    }

    // check le statut de l'utilisateur 
    // public function isBanned($banned){
    
    //     if ($this->getBanned() === $banned){
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    
    public function __toString() {
        return $this->pseudo;
    }

}