<?php
namespace App\controller;

use App\model\Entity\User;
use App\model\UserManager;

class AdminController extends AbstractController
{
    // Access Pages

    public function newUser()
    {
        $this->render('./newUser.twig');
    }


    //Users
    /**
     * @throws \Exception
     */
    public function createUser()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"])) {
            echo 'error';
        } else {
            if ($_POST['password'] === $_POST['password2']) {
                $userManager = new UserManager();
                $user = new User;
                $user
                    ->setUsername ($_POST['username'])
                    ->setPassword ($_POST["password"])
                    ->setNom ($_POST["nom"])
                    ->setPrenom ($_POST["prenom"])
                    ->setEmail ($_POST['email'])
                    ->setBirthdayDate ($_POST["birthday_date"])
                    ->setCity ($_POST["city"])
                    ->setCodeParrainagePerso (uniqid ());
                   /* if (
                   // $reponse = $bdd->query('SELECT COUNT (*) FROM user);');
                   // if ($reponse >= 1)
                    //echo "setCodeParrain";
                //->setCodeParrain($_POST["code_parrainage"])
                else if ($reponse == 0)
                    echo "La TABLE VIDE !";
                ->setCodeParrain(empty());


                    /*;*/



//Verifier si user inscris
//si pas de user -> on créé le user en mode admin
                // si 1 ou plusieurs users on cherche le code parrainage parmi les users

                //si pas de code parrainage on refuse inscription
                // sinon on renseigne id du parrain , et on crée le user

                $result = $userManager->createUser($user);
                var_dump ($result);
                if ($result){
                    $this->addFlash('success','votre compte est enregistré');
                }else{
                    $this->addFlash('danger','votre compte n\'a pas pu etre enregistré');
                }
                //header ('Location:index.php?action=loginPage');
            }
        }
    }

    public function deleteUser()
    {

    }

    public function signaledCommentList()
    {

    }

    public function signaledPostList()
    {

    }

    public function listInfo(){

    }


}
