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
     *@throws \Exception
     */
    public function createUser()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["prenom"]) || empty($_POST["nom"]) || empty($_POST["email"]) || empty($_POST["city"]) || empty($_POST["code_parrainage"]))  {
            throw new \Exception('Tous les champs ne sont pas renseignés');
        } else {
            //$userManager = new UserManager();
            //$validDatas = $userManager->validityInfosUser ();
            //dd ($validDatas);
            if ($validDatas = true && $_POST['password'] === $_POST['password2'])  {
                $userManager = new UserManager();
                $user = new User;
                $hash = md5 ($_POST["password"]);
                $user
                    ->setUsername ($_POST['username'])
                    ->setPassword ($hash)
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
                    $user = $userManager->createUser($user);
                         if ($user instanceof User){ // est ce que $user est bine une instance de la classe User
                             $this->addFlash('success','votre compte est enregistré');
                             $this->addToSession('user', $user);
                             header ('Location:index.php?action=homeAccess');
                         }else{
                            $this->addFlash('danger','votre compte n\'a pas pu etre enregistré');
                             header ('Location:index.php?action=newUser');
                         }
                } else {
                    $this->addFlash('warning','Code parrainage inconnu');

                }
            }else{
                $this->addFlash('warning','mot de passe incorrecte');
                header ('Location:index.php?action=newUser');
            }
        }
    }


    public function uploadFichier (){
        if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0) {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['monfichier']['size'] <= 1000000)
            {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['monfichier']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) {
                    move_uploaded_file($_FILES['monfichier']['tmp_name'], 'uploads/' .$this->user->getId ().".jpg");
                    $this->addFlash('success',"photo de profil mise à jour !");
                    header ('Location:index.php?action=parametres');
                }
            }
        }
    }
   /* public function existFile(){
        $filename = 'uploads/' .$this->user->getId ().".jpg";
        if (file_exists ($filename)){
          return true;
        }else{
           return false;
        }
    }*/




}
