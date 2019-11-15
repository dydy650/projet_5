<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\User;

class UserManager extends DBManager
{
    public function getUser($username) // afficher 1 user
    {
        $req = $this->db->prepare ('SELECT id, username, nom, prenom, DATE_FORMAT(birthday_date, \'%d/%m/%Y \') AS birthday_date_FR, city, email, code_parrainage_perso, code_parrain, password,is_admin FROM user WHERE  username = ?');
        $req->execute (array($username));
        $req->setFetchMode (\PDO::FETCH_CLASS, User::class); // Ligne necessaire pour utiliser les entitiés ddans les vues
        $user = $req->fetch ();
        return $user;
    }

    /**
     * @param User $user
     * @return bool vrai si utilisateur enregistre sinon faux
     */
    public function createUser($user) //j'enregistre un user dans la BDD user
    {
        //je hash le password que je stock dans une variable
        $hash = md5 ($_POST["password"]);
        //Puis on stock le résultat dans la base de données :
        $req = $this->db->prepare ('INSERT INTO user (username, password, nom, prenom, birthday_date, city, email, code_parrainage_perso) VALUES(:username, :password, :nom, :prenom, :birthday_date, :city, :email, :uniqid)');
        return $req->execute (array(
            'username' => $user->getUsername (),
            'password' => $hash,
            'nom' => $user->getNom (),
            'prenom' => $user->getPrenom (),
            'birthday_date' => $user->getBirthdayDate (),
            'city' => $user->getCity (),
            'email' => $user->getEmail (),
            'code_parrainage_perso' => $user->getCodeParrainagePerso ()

        ));
    }

   /*public function checkParrainage()
    {
        $req = $this->db->query ('SELECT code_parrain FROM user');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $codes = [];
        while ($row = $req->fetch())
    }*/
}



    /*
     * @return mixed

    public function testBdd()
    {
        $reponse = $bdd->query ('SELECT COUNT (*) FROM user);');
        return $reponse;
    } */


