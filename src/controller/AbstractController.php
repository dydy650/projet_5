<?php
namespace App\controller;
use App\model\Entity\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected $user;

    public function __construct() // methode pour recupérer l entité User partout dans le code apres l avoir unserialisé
    {
        if(isset($_SESSION['user']))
        {
            $user = unserialize ($_SESSION['user']);
            if ($user instanceof User){
                $this->user = $user;
            }
        }
    }

    protected function  addFlash($type, $message)
    {
        $_SESSION['message'] = ['type'=>$type, 'message'=>$message];
    }


    protected function render($view, $params = array())
    {
        if ($this->user instanceof User){
            $params['loggedUser'] = $this->user; // ajout du parametre pour recupérer les données de l objet User dans la session
        }
        if (!empty($_SESSION['message'])){
            $message = $_SESSION['message'];
            $params['messageFlash'] = $message; // rajouter a la liste des param qu on envoi à la vue
            unset($_SESSION['message']);
        }
        $params['session'] = $_SESSION;
        $path = realpath (__DIR__. '/../../template');
        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader, ['cache'=>false]);

        echo $twig->render($view, $params);

    }

    protected function addToSession($key, $value)
    {
        $serializedValue = serialize ($value); // transforme un objet en chaine de caractere
        $_SESSION[$key] = $serializedValue;

    }

}

