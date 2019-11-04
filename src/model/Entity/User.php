<?php

namespace App\model\Entity;

class User
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthdayDate()
    {
        return $this->birthday_date;
    }

    /**
     * @param mixed $birthday_date
     * @return User
     */
    public function setBirthdayDate($birthday_date)
    {
        $this->birthday_date = $birthday_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeParrainagePerso()
    {
        return $this->code_parrainage_perso;
    }

    /**
     * @param mixed $code_parrainage_perso
     * @return User
     */
    public function setCodeParrainagePerso($code_parrainage_perso)
    {
        $this->code_parrainage_perso = $code_parrainage_perso;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeParrain()
    {
        return $this->code_parrain;
    }

    /**
     * @param mixed $code_parrain
     * @return User
     */
    public function setCodeParrain($code_parrain)
    {
        $this->code_parrain = $code_parrain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param mixed $is_admin
     * @return User
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
        return $this;
    }
    private $username;
    private $password;
    private $nom;
    private $prenom;
    private $birthday_date;
    private $city;
    private $email;
    private $code_parrainage_perso;
    private $code_parrain;
    private $is_admin;


}
