<?php
namespace App\controller;

use App\model\Entity\Post;
use App\model\Entity\User;
use App\model\Entity\Category;
use App\model\Entity\Comment;
use App\model\UserManager;
use App\model\PostManager;
use App\model\CommentManager;
use App\model\CategoryManager;


class BlogController extends AbstractController
{
    /**
     * @param \Exception $e
     */
    public function error(\Exception $e)
    {
        $this->addFlash ('warning', $e->getMessage ());
        $this->render ('./error.twig');
    }
      // MENU
    public function home()
    {
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $userManager = new UserManager();
        $user = $userManager->getUser($_SESSION['username']);
        $this->render('./home.twig', array('infoSession'=>"contenu", 'user'=>$user, 'page'=>$page));
    }
    public function contact()
    {
        $this->render('./contact.twig');
    }
    public function aboutUs()
    {
        $this->render('./aboutUs.twig');
    }
    public function editPost($id)
    {
        $postManager = new PostManager();
        $post = $postManager->getPost($id);
        $this->render('./editPost.twig', array("post" => $post));
    }
    public function updatePost($id)
    {
        $postManager = new PostManager();
        $post = new Post();
        $post
            ->setId ($_GET['id'])
            ->setContent ($_POST['contentNewPost'])
            ->setIdCategory ($_POST['category']);
        $update = $postManager->updatePost ($post);
        if ($update) {
            $this->addFlash ('success', 'Votre post a été créé');
            header ('Location: '.$_SERVER['HTTP_REFERER']);
        } else {
            $this->addFlash ('danger', 'votre post n\'a pas pu etre enregistré');
            header ('Location: index.php?action=home');
        }
    }
    public function deletePost($id)
    {
        $postManager = new PostManager();
        $delete = $postManager->deletePost($id);
        if ($delete)
        {
            $this->addFlash('success','le post a bien été supprimé');
        }else{
            $this->addFlash('warning','erreur le post n\'a pas été supprimé');
        }
        header ('Location: '.$_SERVER['HTTP_REFERER']);
    }
    public function deleteComment($id)
    {
        $commentManager = new CommentManager();
        $delete = $commentManager->deleteComment($id);
        if ($delete)
        {
            $this->addFlash('success','le commentaire a bien été supprimé');
        }else{
            $this->addFlash('warning','erreur le commentaire n a pas été supprimé');
        }
        header ('Location: '.$_SERVER['HTTP_REFERER']);
    }
    public function editUserInfo()
    {
    $userManager = new UserManager();
    $user = $userManager->getUser($_SESSION['username']);
    $this->render('./editUserInfo.twig', array("user" => $user));
    }
    public function updateUserInfo()
    {
        $userManager = new UserManager();
        $user = new user();
        $user
            ->setId ($_GET['id'])
            ->setUsername ($_POST['username'])
            ->setPrenom ($_POST['prenom'])
            ->setNom ($_POST['nom'])
            ->setEmail ($_POST['email'])
            ->setBirthdayDate ($_POST['birthday_date'])
            ->setCity ($_POST['city']);
        $update = $userManager->updateUserInfo($user);
        if ($update){
            $this->addFlash('success','Vos informations ont été modifiées');
        }else{
            $this->addFlash('danger','Les modifications n\'ont pas pu etre mises à jour');
        }
        $_SESSION['username'] = $user->getUsername();
        header ('Location:index.php?action=parametres');
    }
    public function editUserConnexion()
    {
        $userManager = new UserManager();
        $user = $userManager->getUser($_SESSION['username']);
        $this->render('./editUserConnexion.twig', array("user" => $user));
    }
    /**
     * @throws \Exception
     */
    public function updateUserConnexion()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password1"]) || empty($_POST["password2"])) {
            throw new \Exception('error !');
        }
        $userManager = new UserManager();
        $user = $userManager->getUser ($_POST["username"]);
        $hash = md5 ($_POST["password"]);
        if ($user instanceof User && $hash === $user->getPassword () && ($_POST["password1"]) === ($_POST["password2"])) {
            $user = new user();
            $hash2 = md5 ($_POST["password1"]);
            $user
                ->setId ($_GET['id'])
                ->setUsername ($_POST["username"])
                ->setPassword ($hash2);
            //condition 1 -->si $POST_username = $user->username ET que $POST_ancienMDP = $user->password
            //ALORS je passe à la condition 2
            //  ET Si password 1 = password 2 alors je peux le hash
            // Je créé ensuite une nouvelle entité que j alimente .

            $update = $userManager->updateUserConnexion ($user);
            if ($update) {
                $this->addFlash ('success', 'Vos informations de commexion ont été modifiées');
            } else {
                $this->addFlash ('danger', 'Les informations  de connexion n\'ont pas pu etre mis à jour');
            }
            $_SESSION['username'] = $user->getUsername ();
            header ('Location:index.php?action=parametres');
        }
    }


    public function parametres()
    {
        $userManager = new UserManager();
        $user = $userManager->getUser($_SESSION['username']);
        $filename = 'uploads/' .$this->user->getId ().".jpg";
        $timestamp = time ();
        $existFile = file_exists ($filename);
        $this->render('./parametres.twig', array("user" => $user, "existFile"=> $existFile, "filename" => $filename, "timestamp" => $timestamp));

    }
    public function homeAccess()
    {
        $this->render('./homeAccess.twig');

    }
    public function newPost()
    {
        $this->render('./newPost.twig');
    }

//connexion
    /**
     * @throws \Exception
     */
    public function login()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]))
        {
            throw new \Exception('error !');
        }
        $userManager = new UserManager();
        $user = $userManager->getUser($_POST["username"]);
        $hash = md5 ($_POST["password"]);
        if ($user instanceof User && $hash === $user->getPassword()){
            $_SESSION['username'] = $user->getUsername();
            $this->addToSession('user', $user);
            header ('Location:index.php?action=home');

        } else {
            throw new \Exception('Username ou mot de passe incorrect');
        }
    }
    public function logout()
    {
        $_SESSION = array();
        session_destroy ();
        header ('Location:index.php?action=loginPage');
        exit();
    }
    //POST
    public function listPostsByUser()
    {
        $username = $_SESSION['username'];
        //page courante
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        //nb de posts totals
        $postManager = new PostManager();
        $nb_posts_totals = $postManager->getPostCountUser ($username);  //nb de page
        $limite = PostManager::LIMIT;
        $nombreDePages = ceil($nb_posts_totals / $limite);

        $tableIdPosts = $postManager->getIdPosts ($page, array("username = '$username'" ));
        if (empty($tableIdPosts)){
            $this->addFlash ('warning', 'Vous n\'avez pas encore publié de post');
            header ('Location: index.php?action=home');
        }else{
        $posts = $postManager->getPostsWithComs($tableIdPosts);
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategories ();
        $userManager = new UserManager();
        $user = $userManager->getUser($_SESSION['username']);
        $this->render('./myposts.twig', array(
            "posts" => $posts,
            "categories" =>$categories,
            "user"=>$user,
            "page" => $page,
            "nombreDePages"=>$nombreDePages
        ));}

    }
    public function listPostsWithComs()
    {
       //page courante
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        //nb de posts totals
        $postManager = new PostManager();
        $nb_posts_totals = $postManager->getPostCount ();        //nb de page
        $limite = PostManager::LIMIT;
        $nombreDePages = ceil($nb_posts_totals / $limite);

            $tableIdPosts = $postManager->getIdPosts ($page);
            $posts = $postManager->getPostsWithComs($tableIdPosts);
            $categoryManager = new CategoryManager();
            $categories = $categoryManager->getCategories ();
            $userManager = new UserManager();
            $user = $userManager->getUser($_SESSION['username']);
            $this->render('./actu.twig', array(
                "posts" => $posts,
                "categories" =>$categories,
                "user"=>$user,
                "page" => $page,
                "nombreDePages"=>$nombreDePages));

    }
    //----------------------------------------------------POST CATEGORIES-----------------------------------------------------
    public function listCategories()
    {
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategories ();
        $this->render ('listCategories.twig', array(
            "categories" => $categories,
            "page" => $page,));
    }
    public function category()
    {
        //page courante
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
        //nb de posts totals
        $postManager = new PostManager();
        $nb_posts_totals = $postManager->getPostCountCat($_GET['id']);//nb de page
        $id_category = $_GET['id'];
        $limite = PostManager::LIMIT;
        $nombreDePages = ceil($nb_posts_totals / $limite);
        $category = new Category();
        $category->setIdCategory ($id_category);

        $tableIdPosts = $postManager->getIdPosts ($page, array("id_category = '$id_category'" ));
        $posts = $postManager->getPostsWithComs ($tableIdPosts);
        $this->render('./category.twig', array(
            "posts" => $posts,
            "page" => $page,
            "nombreDePages"=>$nombreDePages,
            "category"=>$category
            ));

    }
    public function addPost()
    {
        //une condition qui vérifie si les données $_POST sont présentes, sinon on lève une Exception
        //On instancie un nouveau billet, donc vide
        //On hydrate le billet avec les données $_POST, puisqu\'on sait qu\'elles sont présentes
        //On envoie le billet hydraté au model
        /*if (empty($_POST['categories']) || empty($_POST['content'])) {
            echo ('error : il manque des datas !');
        } else {*/
        $postManager = new PostManager();
        $post = new Post();
        $post
            ->setContent ($_POST['contentNewPost'])
            ->setIdCategory ($_POST['category'])
            ->setUsername ($_SESSION['username']);
        $id = $postManager->savePost ($post);

        if ($id) {
            $this->addFlash ('success', 'Votre post a été créé');
        } else {
            $this->addFlash ('danger', 'votre post n\'a pas pu etre enregistré');
        }
        header ('Location: index.php?action=home');
    }
    //COMMENTAIRES
    /**
     * @param $post_id
     * @param $username
     * @param $content
     */
    public function addComment($post_id, $username, $content)
    {
        $commentManager = new CommentManager();
        $comment = new Comment(); // je creé un Objet qui regroupe toute les infos de mon commentaire que je vais utiliser ensuite dans ma methode postComment
        $comment
            ->setPostId ($post_id)
            ->setUsername ($username)
            ->setContent ($content);

        $affectedLines = $commentManager->saveComment($comment);
        if ($affectedLines === false) {
            $this->addFlash('danger','Impossible d\'ajouter le commentaire');
        } else {
            $this->addFlash('success','Commentaire ajouté');
            header ('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}
