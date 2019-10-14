<?php
namespace App\controller;

use App\model\Entity\Post;
use App\model\Entity\User;
use App\model\UserManager;
use App\model\PostManager;
use App\model\CommentManager;



class BlogController extends AbstractController
{
    public function home()
    {
        $this->render('./home.twig');
        var_dump ("ok");

    }

    public function test()
    {
        $this->render ('../view/test.phtml');
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
        $hash = md5 ($_POST["password"]);
        if ($user instanceof User && $hash === $user->getPassword()){
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['is_admin'] = $user->getIsAdmin();
            if ($user->getIsAdmin () === "1") {
                header ('Location:index.php?action=adminHome');
            } else {
                $_SESSION['is_admin'] = $user->getIsAdmin();
                header ('Location:index.php?action=home');
            }
        } else {
            throw new \Exception('Username ou mot de passe incorrection');
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

    /*public function post()
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $post = $postManager->getPost ($_GET['id']);
        var_dump ($post);
        $comments = $commentManager->getComments ($_GET['id']);
        var_dump ($comments);
        $this->render('./myposts.twig', array("post" => $post, "comments" => $comments));
    }*/


    public function listPosts()
    {
        {
            $postManager = new PostManager();
            $posts = $postManager->getPosts ();
            var_dump ($posts);
            $this->render('./myposts.twig', array("posts" => $posts));
           // var_dump (array("posts" => $posts));
            var_dump ("ok2");// je veux appeler la articlelist et celle ci aura $posts en parametre
        }

    }


    public function addPost()
    {
        //une condition qui vérifie si les données $_POST sont présentes, sinon on lève une Exception
        //On instancie un nouveau billet, donc vide
        //On hydrate le billet avec les données $_POST, puisqu\'on sait qu\'elles sont présentes
        //On envoie le billet hydraté au model
        if (empty($_POST['categories']) || empty($_POST['content'])) {
            throw new \Exception('error : il manque des datas !');
        } else {
            $postManager = new PostManager();
            $post = new Post();
            $post
                ->setContent ($_POST['contentNewPost'])
                ->setCategorie ($_POST['categories'])
                ->setUsername ($_SESSION['username']);
            $id = $postManager->savePost ($post);
            if ($id){
                $this->addFlash('success','Votre post a été créé');
            }else{
                $this->addFlash('danger','votre post n\'a pas pu etre enregistré');
            }
            header ('Location: index.php?action=post&id=' . $id);
        }

    }

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

    public function addComment()
    {

    }

    public function deleteComment()
    {

    }

    public function updateComment()
    {

    }

    public function signalComment(){

    }


}
