<?php
session_start ();

require_once 'vendor/autoload.php';
require_once 'functions.php';
use \App\controller\BlogController;
use \App\controller\AdminController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$blogController = new BlogController();
$adminController = new AdminController();

//rendu du template
$loader = new \Twig\Loader\FilesystemLoader(__DIR__. '/template');
$twig = new \Twig\Environment($loader, ['cache'=>false,//__DIR__ . '/tmp'
]);

// routing

$page='home';
    if (isset($_GET['action']))
    {
        $page= $_GET['action'];
    }
try{
    switch ($page)
    {
        case 'home':
            if($_SESSION['username']== NULL){
                $blogController->homeAccess();
            }else{
            $blogController->home();
            }
            break;
        case '':
            $blogController->homeAccess();
            break;
        case 'contact':
            $blogController->contact();
            break;
        case 'categories':
            $blogController->listCategories();
            break;
        case 'category':
            $blogController->category ();
            break;
        case 'aboutUs':
            $blogController->aboutUs();
            break;
        case 'parametres':
            $blogController->parametres();
            break;
        case 'homeAccess':
            $blogController->homeAccess();
            break;
        case 'login':
            $blogController->login();
            break;
        case 'newUser':
            $adminController->newUser ();
            break;
        case 'addUser':
            $adminController->createUser();
            break;
        case 'actualites':
            $blogController->listPostsWithComs();
            break;
        case 'posts':
            $blogController->listPostsByUser();
            break;
        case 'addComment':
            $blogController->addComment($_GET['id'], $_SESSION['username'], $_POST['contentNewComment']);
            break;
        case 'newPost':
            $blogController->newPost();
            break;
        case 'addPost':
            $blogController->addPost ();
            break;
        case 'editUserInfo':
            $blogController->editUserInfo ();
            break;
        case 'editUserConnexion':
            $blogController->editUserConnexion ();
            break;
        case 'updateUserInfo':
            $id = $_GET['id'];
            $blogController->updateUserInfo ($id);
            break;
        case 'updateUserConnexion':
            $id = $_GET['id'];
            $blogController->updateUserConnexion($id);
            break;
       case 'editPost':
           $id = $_GET['id'];
            $blogController->editPost ($id);
            break;
        case 'updatePost':
            $id = $_GET['id'];
            $blogController->updatePost ($id);
            break;
        case 'deletePost':
            $id = $_GET['id'];
            $blogController->deletePost($id);
            break;
        case 'deleteComment':
            $id = $_GET['id'];
            $blogController->deleteComment($id);
            break;
        default:
        header ('HTTP/1.0 404 Not Found');
        echo $twig->render ('404.twig');
        break;
    }
}
catch (Exception $e) {
    //$blogController ->error($e);
    //$this->addFlash ('warning', $e->getMessage ());

    //$errorMessage = $e->getMessage ();

    //echo $twig->render ('error.twig');
    echo 'Erreur : ' . $e->getMessage ();
}

