<?php
namespace App\controller;

use App\model\Entity\User;
use App\model\UserManager;
use App\model\DBManager;

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
        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["prenom"]) || empty($_POST["nom"]) || empty($_POST["email"]) || empty($_POST["city"]) || empty($_POST["code_parrainage"]))  {
            echo 'error';
        } else {
            if ($_POST['password'] === $_POST['password2'])  {
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
                    ->setCodeParrain ($_POST["code_parrainage"])
                    ->setCodeParrainagePerso (uniqid());

                // Verification si le code de parrainage existe dans la BDD
               $code_parrain = $user->getCodeParrain();
               $parrainExist = $userManager->parrainExist($code_parrain);

            /// Si le code_Parrainge existe --> return "true" / J appelle la methode createUser
                if ($parrainExist === true){
                    $result = $userManager->createUser($user);
                    dd ($user);
                         if ($result){ // Si user créé dans la BDD
                             $this->addFlash('success','votre compte est enregistré');
                             header ('Location:index.php?action=homeAccess');
                         }else{
                            $this->addFlash('danger','votre compte n\'a pas pu etre enregistré');
                             header ('Location:index.php?action=newUser');
                         }
                } else {
                    $this->addFlash('warning','Code parrainage inconnu');
                    echo 'erreur';
                }

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
