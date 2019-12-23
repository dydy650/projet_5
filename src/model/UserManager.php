<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\User;
use mysql_xdevapi\Exception;
use Twig\Node\Expression\Binary\AndBinary;

class UserManager extends DBManager
{
    public function getUser($username) // afficher 1 user
    {
        $req = $this->db->prepare ('SELECT id, username, nom, prenom, DATE_FORMAT(birthday_date, \'%d/%m/%Y \') AS birthday_date_FR, city, email, code_parrainage_perso, code_parrain, password,is_admin 
        FROM user WHERE  username = ?');
        $req->execute (array($username));
        $req->setFetchMode (\PDO::FETCH_CLASS, User::class); //
        $user = $req->fetch ();
        return $user;
    }

    /**
     * @param $user
     * @return bool
     */
    public function updateUserInfo($user)
    {
        $req =  $this->db->prepare('UPDATE user SET username = ?, prenom = ?, nom = ?, birthday_date = ?, city = ?, email= ? WHERE id = ?');
        $result = $req->execute(array(
            $user->getUsername(),
            $user->getPrenom(),
            $user->getNom(),
            $user->getBirthdayDate (),
            $user->getCity (),
            $user->getEmail (),
            $user->getId(),
        ));
        return $result;
    }

    /**
     * @param $user
     * @return bool
     */
    public function updateUserConnexion($user)
    {
        $req =  $this->db->prepare('UPDATE user SET username = ?, password = ? WHERE id = ?');
        $result = $req->execute(array(
            $user->getUsername(),
            $user->getPassword(),
            $user->getId(),
        ));
        return $result;
    }

    /**
     * @param $code_parrain
     * @return bool
     */
    public function parrainExist($code_parrain)
    {
        $req = $this->db->prepare ('SELECT COUNT(code_parrainage_perso) FROM user WHERE code_parrain = ?');
        $req->execute(array($code_parrain));
        $result = $req->fetch ();
        return $result > 0;
    }
    //verifier si le code parrain match avec le code parrain Perso dans la BDD
    // return bolean vrai ou faux

    /**
     * @param User $user
     * @return User|false  renvoi false en d echec sinon renvoi le User hydraté avec ID qui vient de recup
     */
    public function createUser($user)
    {
        $req = $this->db->prepare ('
INSERT INTO user (username, password, nom, prenom, birthday_date, city, email, code_parrain, code_parrainage_perso) 
VALUES(:username, :password, :nom, :prenom, :birthday_date, :city, :email, :code_parrain, :code_parrainage_perso)
');
        if( $req->execute(array(
            'username' => $user->getUsername (),
            'password' => $user->getPassword (),
            'nom' => $user->getNom (),
            'prenom' => $user->getPrenom (),
            'birthday_date' => $user->getBirthdayDate (),
            'city' => $user->getCity (),
            'email' => $user->getEmail (),
            'code_parrain' => $user->getCodeParrain (),
            'code_parrainage_perso' => $user->getCodeParrainagePerso ()
            )))
        {
            $id = $this->db->lastInsertId ();
            $user->setId ($id);
            return $user;
        } else {
            return false;
        }
    }
}



