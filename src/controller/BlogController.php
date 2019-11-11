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
    // MENU
    public function home()
    {
        $this->render('./home.twig', array('infoSession'=>"contenu"));
    }

    public function contact()
    {
        $this->render('./contact.twig');
    }

    public function aboutUs()
    {
        $this->render('./aboutUs.twig');
    }

    public function parametres()
    {
        $this->render('./parametres.twig');
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
    public function login()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]))
        {
            throw new \Exception('error !');
        }
        $userManager = new UserManager();
        $user = $userManager->getUser($_POST["username"]);
        var_dump ($user);
        $hash = md5 ($_POST["password"]);
        if ($user instanceof User && $hash === $user->getPassword()){
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['is_admin'] = $user->getIsAdmin();


            if ($user->getIsAdmin () === "1") {
                header ('Location:index.php?action=home');


            } else {
                $_SESSION['is_admin'] = $user->getIsAdmin();
                header ('Location:index.php?action=XX');
            }

        } else {
            echo('Username ou mot de passe incorrection');
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

    /**
     *
     */
    public function listPostsByUser()
    {
            $username = $_SESSION['username'];
            $postManager = new PostManager();
            $posts = $postManager->getPostsWithComsByUser($username);
            $this->render('./myposts.twig', array("posts" => $posts));



    }

    public function listPostsWithComs()
    {

            $postManager = new PostManager();
            $posts = $postManager->getPostsWithComs();
            $this->render('./actu.twig', array("posts" => $posts));




    }


    //----------------------------------------------------POST CATEGORIES-----------------------------------------------------

    public function listCategories()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategories ();
        //echo "<pre>";
        $this->render ('listCategories.twig', array("categories" => $categories));
    }


    public function category(){
        $postManager = new PostManager;
        $posts = $postManager->getPostsWithComsByCat ($_GET['id_category']);
        var_dump ($posts);
        $this->render('./category.twig', array("posts" => $posts));

    }




    /*
 * @param $id_category
 * @param $content
     *  @param $username
 */

    /**
     *
     */
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
            echo "<pre>";
            var_dump ($post);
            var_dump ($id);
            if ($id){
                $this->addFlash('success','Votre post a été créé');
            }else{
                $this->addFlash('danger','votre post n\'a pas pu etre enregistré');
            }
            //header ('Location: index.php?action=home');

    }
//
    public function deletePost()
    {

    }

    public function updatePost()
    {

    }

    public function signalPost(){

    }

    //COMMENTAIRES
    public function listComment()
    {

    }

   /* public function addComment()
    {
        $commentManager = new CommentManager();
        $comment = new Comment(); // je creé un Objet qui regroupe toute les infos de mon commentaire que je vais utiliser ensuite dans ma methode postComment
        $comment
            ->setUsername ($_SESSION['username'])
            ->setContent ($_POST['responsePost'])
            ->setPostId ($id);
        $affectedLines = $commentManager->saveComment($comment);
        if ($affectedLines === false) {
            $this->addFlash('danger','Impossible d\'ajouter le commentaire');
        } else {
            $this->addFlash('success','Commentaire ajouté');
            header ('Location: index.php?action=singlePost&id=' . $post_id);
        }
    }*/

    public function deleteComment()
    {

    }

    public function updateComment()
    {

    }

    public function signalComment(){

    }


}
