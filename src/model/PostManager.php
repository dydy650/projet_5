<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\Post;
use App\model\Entity\Category;
use App\model\Entity\Comment;

class PostManager extends DBManager
{

    /**
     * @param Post $post
     * @return bool
     */
    public function savePost($post) // On recoit le post a enregistrer
    {
        $req = $this->db->prepare('INSERT INTO post ( id_category, username, content, post_at ) VALUES(?, ?, ?, NOW())');
        $req->execute(array(
            $post->getIdCategory(),
            $post->getUsername(),
            $post->getContent(),
        ));
        return $this->db->lastInsertId ();

    }

   /* public function getPosts() //on liste les posts
    {
        $datas =$this->db->query('SELECT p.id, p.id_category, p.username, p.content, ca.name_category, p.post_at FROM post p ORDER BY p.post_at DESC LIMIT 0, 10');
        $posts = array();
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        var_dump ($posts);
        return $posts; //le tableau est

    }*/

    /**
     * @return array
     */
    public function getPostsWithComs() //Liste des posts avec leurs commentaires
    {
        $req =$this->db->query('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment , c.post_id, c.comment_at, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at
FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
ORDER BY p.post_at DESC ');
        //requete->selection des champs par table / integration des alias / jointure avec les 2 tables

        $req->setFetchMode(\PDO::FETCH_ASSOC); //Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes
        $posts = [];
        //on crée un tableau pour intégrer les post
        // while pour lire toutes les lignes en faisant une boucle
        while ($row = $req->fetch())
        {
            //SI comment est NULL je n'instancie pas $comment
            if (!empty($row["post_id"])){
                $comment = new Comment();
                $comment
                    ->setPostId ($row["post_id"])
                    ->setContent ($row["contentComment"])
                    ->setUsername ($row["nameComment"])
                    ->setCommentAt ($row["comment_at"]);
            }

        //Si $posts[id_courant] existe c'est que l'entité post a dejà été créée dans le tableau "posts".
            // Dans ce cas on ajoute le commentaire au post du tableau
            if (isset($posts["post".$row["id"]]) && isset($comment)){
                $posts["post".$row["id"]]->addComment($comment);
            }else{
                //Si $posts[id_courant] n'existe pas, on instancie une nouvelle entitée post + category / on les hydrate /
                // et on les ajoute au tableau en utilisant son id comme clé associatif
            $category = new Category(); //on instancie l'entité
            $category->setIdCategory ($row["id_category"]) // on l'hydrate
                   ->setNameCategory($row["name_category"]);


            $post = new Post(); // on instancie l'entité proprietaire
            $post->setId ($row["id"]) // on hydrate avec les autres entités
                ->setIdCategory ($row["id_category"])
                ->setUsername($row["username"])
                ->setContent ($row["content"])
                ->setPostAt ($row["post_at"])
                ->setIsSignaled ($row["is_signaled"])
                ->setCategory ($category);// // on hydrate avec les autres entités

                if(isset($comment)){
               $post->addComment ($comment);// on hydrate avec les autres entités
                }

                $posts["post".$row["id"]] = $post;
            }
        }
        $req->closeCursor(); // on libere la memoire
//dd ($posts['post16']);
        return $posts;

    }
//---------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------------------------------------------------------------------------------------------//
    /**
     * @param $username
     * @return mixed
     */
    public function getPostsWithComsByUser($username) //Liste des posts avec leurs commentaires
    {
        $req =$this->db->prepare('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment , c.post_id, c.comment_at, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at
FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE p.username = ?
ORDER BY p.post_at DESC 
');
        //requete->selection des champs par table / integration des alias / jointure avec les 2 tables
        $req->execute (array($username));
        $req->setFetchMode(\PDO::FETCH_ASSOC); //Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes
        $posts = [];
        //on crée un tableau pour intégrer les post
        // while pour lire toutes les lignes en faisant une boucle
        while ($row = $req->fetch())
        {
            //SI comment est NULL je n'instancie pas $comment
            if (!empty($row["post_id"])){
                $comment = new Comment();
                $comment
                    ->setPostId ($row["post_id"])
                    ->setContent ($row["contentComment"])
                    ->setUsername ($row["nameComment"])
                    ->setCommentAt ($row["comment_at"]);
            }

            //Si $posts[id_courant] existe c'est que l'entité post a dejà été créée dans le tableau "posts".
            // Dans ce cas on ajoute le commentaire au post du tableau
            if (isset($posts["post".$row["id"]]) && isset($comment)){
                $posts["post".$row["id"]]->addComment($comment);
            }else{
                //Si $posts[id_courant] n'existe pas, on instancie une nouvelle entitée post + category / on les hydrate /
                // et on les ajoute au tableau en utilisant son id comme clé associatif
                $category = new Category(); //on instancie l'entité
                $category->setIdCategory ($row["id_category"]) // on l'hydrate
                ->setNameCategory($row["name_category"]);


                $post = new Post(); // on instancie l'entité proprietaire
                $post->setId ($row["id"]) // on hydrate avec les autres entités
                ->setIdCategory ($row["id_category"])
                    ->setUsername($row["username"])
                    ->setContent ($row["content"])
                    ->setPostAt ($row["post_at"])
                    ->setIsSignaled ($row["is_signaled"])
                    ->setCategory ($category);// // on hydrate avec les autres entités

                if(isset($comment)){
                    $post->addComment ($comment);// on hydrate avec les autres entités
                }

                $posts["post".$row["id"]] = $post;
            }
        }
        $req->closeCursor(); // on libere la memoire
//dd ($posts['post16']);
        return $posts;

    }


    public function getPost($id) // afficher 1 billet
    {
        $req = $this->db->prepare('SELECT id, username, content, DATE_FORMAT(post_at, \'%d/%m/%Y \'), categorie FROM post p WHERE id = ?');
        $req->execute(array($id));
        $req->setFetchMode(\PDO::FETCH_CLASS,Post::class); // Ligne necessaire pour utiliser les entitiés dans les vues
        $post = $req->fetch();
        return $post;
    }

    /*----------------------------------- getPost-- CATEGORIES----------------------------------------------*/


    public function getPostsWithComsByCat($id_category) //Liste des posts avec leurs commentaires
    {
        $req =$this->db->prepare('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment , c.post_id, c.comment_at, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at
FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE p.id_category = ?
ORDER BY p.post_at DESC ');
        //requete->selection des champs par table / integration des alias / jointure avec les 2 tables
        $req->execute (array($id_category));
        $req->setFetchMode(\PDO::FETCH_ASSOC); //Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes
        $posts = [];
        //on crée un tableau pour intégrer les post
        // while pour lire toutes les lignes en faisant une boucle
        while ($row = $req->fetch())
        {
            //SI comment est NULL je n'instancie pas $comment
            if (!empty($row["post_id"])){
                $comment = new Comment();
                $comment
                    ->setPostId ($row["post_id"])
                    ->setContent ($row["contentComment"])
                    ->setUsername ($row["nameComment"])
                    ->setCommentAt ($row["comment_at"]);
            }

            //Si $posts[id_courant] existe c'est que l'entité post a dejà été créée dans le tableau "posts".
            // Dans ce cas on ajoute le commentaire au post du tableau
            if (isset($posts["post".$row["id"]]) && isset($comment)){
                $posts["post".$row["id"]]->addComment($comment);
            }else{
                //Si $posts[id_courant] n'existe pas, on instancie une nouvelle entitée post + category / on les hydrate /
                // et on les ajoute au tableau en utilisant son id comme clé associatif

                $category = new Category(); //on instancie l'entité
                $category->setIdCategory ($row["id_category"]) // on l'hydrate
                ->setNameCategory($row["name_category"]);


                $post = new Post(); // on instancie l'entité proprietaire
                $post
                    ->setId ($row["id"]) // on hydrate avec les autres entités
                    ->setIdCategory ($row["id_category"])
                    ->setUsername($row["username"])
                    ->setContent ($row["content"])
                    ->setPostAt ($row["post_at"])
                    ->setIsSignaled ($row["is_signaled"])
                    ->setCategory ($category);// // on hydrate avec les autres entités

                if(isset($comment)){
                    $post->addComment ($comment);// on hydrate avec les autres entités
                }

                $posts["post".$row["id"]] = $post;
            }
        }
        $req->closeCursor(); // on libere la memoire
//dd ($posts['post16']);
        return $posts;

    }




}
