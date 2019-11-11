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


    protected function render($view, $params = array())
    {
        $params['session']=$_SESSION;
        $path = realpath (__DIR__. '/../../template');
        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader, ['cache'=>false]);

        echo $twig->render($view, $params);

    }
}

