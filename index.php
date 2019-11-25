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
if (isset($_GET['action'])){
    $page= $_GET['action'];
}

switch ($page){
    case 'home':
        $blogController->home();
        break;
    case 'contact':
        $blogController->contact();
        break;
    case 'categories':
        $blogController->listCategories();
        break;
    case 'category':
        //echo $twig->render ('catGardeEnfant.twig');
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
        //$blogController->post ();
        $blogController->listPostsByUser();
        //echo $twig->render ('myPosts.twig');
        break;
    case 'addComment':
        //$blogController->post ();
        $blogController->addComment($_GET['id'], $_SESSION['username'], $_POST['contentNewComment']);
        //echo $twig->render ('myPosts.twig');
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


/*if ($page==='home'){
    echo $twig->render ('home.twig', ['user' =>[
        'name' => "Sandy",
        'age' => "33",
    ]]);
}*/


/*


require_once 'vendor/autoload.php';
use App\controller\BlogController;
use App\controller\AdminController;

// routing
$blogController = new BlogController();

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'home' || $_GET['action'] == '') {
            $blogController->home ();
        } elseif ($_GET['action'] == 'categories') {
            $blogController->categories ();
        }
    } else {
        $blogController->home ();
    }
}
catch (Exception $e) {
    $blogController ->error($e);
}

*/

