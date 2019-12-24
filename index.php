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
        case 'uploadFichier':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $adminController->uploadFichier ();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'home':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
                $blogController->home ();
            }else{
                $blogController->homeAccess ();
                }
            break;
        case '':
            $blogController->homeAccess();
            break;
        case 'contact':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->contact();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'categories':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->listCategories();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'category':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->category ();
            }else{
            $blogController->homeAccess ();
             }
            break;
        case 'aboutUs':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->aboutUs();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'parametres':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->parametres();
            }else{
            $blogController->homeAccess ();
            }
            break;
        case 'homeAccess':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->homeAccess();
            }else{
                $blogController->homeAccess ();
            }
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
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->listPostsWithComs();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'posts':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->listPostsByUser();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'addComment':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->addComment($_GET['id'], $_SESSION['username'], $_POST['contentNewComment']);
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'newPost':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->newPost();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'addPost':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->addPost ();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'editUserInfo':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->editUserInfo ();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'editUserConnexion':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $blogController->editUserConnexion ();
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'updateUserInfo':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $id = $_GET['id'];
            $blogController->updateUserInfo ($id);
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'updateUserConnexion':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $id = $_GET['id'];
            $blogController->updateUserConnexion($id);
            }else{
                $blogController->homeAccess ();
            }
            break;
       case 'editPost':
           if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
           $id = $_GET['id'];
            $blogController->editPost ($id);
           }else{
               $blogController->homeAccess ();
           }
            break;
        case 'updatePost':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $id = $_GET['id'];
            $blogController->updatePost ($id);
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'deletePost':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $id = $_GET['id'];
            $blogController->deletePost($id);
            }else{
                $blogController->homeAccess ();
            }
            break;
        case 'deleteComment':
            if(isset($_SESSION['username'])&& ($_SESSION['username'] !== NULL)) {
            $id = $_GET['id'];
            $blogController->deleteComment($id);
            }else{
                $blogController->homeAccess ();
            }
            break;
        default:
        header ('HTTP/1.0 404 Not Found');
        echo $twig->render ('404.twig');
        break;
    }
}
catch (Exception $e) {
    $blogController ->error($e);
}

