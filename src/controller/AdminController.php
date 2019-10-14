<?php
namespace App\controller;

use App\model\Entity\User;
use App\model\UserManager;

class AdminController extends AbstractController
{
    //Users
    /**
     * @throws \Exception
     */
    public function addUser()
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
                    ->setCity ($_POST["city"]);
var_dump ($user);
uniqid ();
                $result = $userManager->postUser($user);
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
