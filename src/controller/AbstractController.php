<?php
namespace App\controller;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{

    protected function  addFlash($type, $message)
    {
        $_SESSION['message'] = ['type'=>$type, 'message'=>$message];
    }
    /**
     * @param $view
     * @param array $params
     */
    /*protected function render($view, $params = array()) // methode qui permet de supprimer les requires dans les methodes ci dessus
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        var_dump ($view);
        require $view;

    }*/


    protected function render($view, $params = array())
    {

        $path = realpath (__DIR__. '/../../template');
        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader, ['cache'=>false]);
        echo $twig->render($view, $params);

    }
}

