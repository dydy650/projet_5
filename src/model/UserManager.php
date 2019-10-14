<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\User;

class UserManager extends DBManager
{
    /**
     * @param User $user
     * @return bool vrai si utilisateur enregistre sinon faux
     */
    public function postUser($user) //j'enregistre un user dans la BDD user
    {
        //je hash le password que je stock dans une variable
        $hash = md5($_POST["password"]);
        var_dump ($hash);
        //Puis on stock le résultat dans la base de données :
        $req = $this->db->prepare('INSERT INTO user (username, password, nom, prenom, birthday_date, city, email, uniqid) VALUES(:username, :password, :nom, :prenom, :birthday_date, :city, :email, :uniqid)');
        return $req->execute(array(
                'username'=> $user->getUsername(),
                'password'=> $hash,
                'nom'=> $user->getNom(),
                'prenom'=> $user->getPrenom(),
                'birthday_date'=> $user->getBirthdayDate(),
                'city'=> $user->getCity(),
                'email'=> $user->getEmail(),
                'uniqid' => $user->getUniqid()

        ));
    }

}
