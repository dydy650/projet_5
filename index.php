<?php
require_once 'vendor/autoload.php';
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
        $blogController->home ();
       //echo $twig->render ('home.twig');
        break;
    case 'contact':
        echo $twig->render ('contact.twig');
        break;
    case 'categories':
        echo $twig->render ('categories.twig');
        break;
    case 'aboutUs':
        echo $twig->render ('aboutUs.twig');
        break;
    case 'parametres':
        echo $twig->render ('parametres.twig');
        break;
    case 'homeAccess':
        echo $twig->render ('homeAccess.twig');
        break;
    case 'newUser':
        //$adminController->addUser ();
        echo $twig->render ('newUser.twig');
        break;
    case 'addUser':
        $adminController->addUser ();
        break;
    case 'actualites':
        echo $twig->render ('actu.twig');
        break;
    case 'posts':
        //$blogController->post ();
        $blogController->listPosts ();
        //echo $twig->render ('myPosts.twig');
        break;
    case 'newPost':
        echo $twig->render ('newPost.twig');
        break;
    case 'addUser':
        echo $twig->render ('homeAccess.twig');
        break;
    case 'addPost':
        echo $twig->render ('myPosts.twig', ['posts' => posts()]);
        break;
    case 'garde':
        echo $twig->render ('catGardeEnfant.twig');
        break;
    case 'immo':
        echo $twig->render ('catImmo.twig');
        break;
    case 'troc':
        echo $twig->render ('catTroc.twig');
        break;
    case 'lifestyle':
        echo $twig->render ('catLifestyle.twig');
        break;
    case 'sorties':
        echo $twig->render ('catSorties.twig');
        break;
    case 'humeur':
        echo $twig->render ('catHumeur.twig');
        break;
    case 'sport':
        echo $twig->render ('catSport.twig');
        break;
    case 'bonsPlans':
        echo $twig->render ('catBonsPlans.twig');
        break;
    case 'aide':
        echo $twig->render ('catAide.twig');
        break;
    case 'autres':
        echo $twig->render ('catAutres.twig');
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

