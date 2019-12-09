<?php
namespace App\model;
//require_once('DBManager.php');
use PDO;
use App\model\Entity\Post;
use App\model\Entity\Category;
use App\model\Entity\Comment;

class PostManager extends DBManager
{
    const LIMIT = 5; // constante de classe

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

    /**
     * @param $id_category
     * @return int
     */
    public function getPostCountCat($id_category)
    {
        $id_category = intval ($id_category); // ca converti une variable en nombre entier
        $resultFoundRows = $this->db->prepare('SELECT id from post WHERE id_category = ?');
        $resultFoundRows->execute (array($id_category));
        $resultFoundRows->setFetchMode(\PDO::FETCH_ASSOC);
        $nb_posts_totals = $resultFoundRows->rowCount();
//dd($nb_posts_totals);
        return $nb_posts_totals;
    }

    public function getPostCountUser($username)
    {
        $resultFoundRows = $this->db->prepare('SELECT id from post WHERE username = ?');
        $resultFoundRows->execute (array($username));
        $resultFoundRows->setFetchMode(\PDO::FETCH_ASSOC);
        $nb_posts_totals = $resultFoundRows->rowCount();
        return $nb_posts_totals;
    }

    public function getPostCount(){
    $resultFoundRows = $this->db->query('SELECT id from post');
    $nb_posts_totals = $resultFoundRows->rowCount();

    return $nb_posts_totals;
}

    /**
     * @param $page
     * @param array $filters
     * @return array
     */
    public function getIdPosts($page, $filters = array())
    {
        $limite = self::LIMIT;// avoir acces à la constante de classe courante
        $debut = ($page - 1) * $limite;
        $tableIdPosts =array();
        //Début de la requête
        $result = 'SELECT id FROM post';
        //Ajout clause WHERE s'il y en a dans le tableau
        if (count($filters) > 0)
        {
            $result .= ' WHERE ' . implode(' AND ', $filters);
        }
        //Et on fini la requête
        $result .= ' LIMIT :limite OFFSET :debut';

        $result = $this->db->prepare($result);
        $result->bindValue ('limite', $limite, PDO::PARAM_INT);
        $result->bindValue ('debut', $debut, PDO::PARAM_INT);
        $result->execute ();

        foreach ($result as $row)
        {
            $tableIdPosts[]=$row['id'];
        }
        //dd ($result, $tableIdPosts);
        return $tableIdPosts;
    }


    /**
     * @param $tableIdPosts
     * @param $page
     * @return array
     */
    public function getPostsWithComs($tableIdPosts) //Liste des posts avec leurs commentaires
{
    $listPostsIds = implode (",", $tableIdPosts); // "1,2, 3..."
    //dd ($listPostsIds);

     $req =$this->db->query('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment, c.post_id, c.comment_at, c.id comment_id, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at
FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE p.id IN ('.$listPostsIds.')
ORDER BY p.post_at DESC');
// ici je recuprere les post ou les id sont les suivants
     /*$SQL contient la requete en chaine de caractere
     if (!empty($tableIdPosts)){ //[1,2,3...]
         $sql .= " where p.id in (".implode (",", $tableIdPosts).")"; // "1,2, 3..."
         var_dump ($sql);
     }*/
//dd ($tableIdPosts);
    $req->setFetchMode(PDO::FETCH_ASSOC); //Retourne la ligne suivante en tant qu'un tableau indexé par le nom des colonnes

    $posts = [];

 /*debut des test
        while ($row = $req->fetch())  {
            $posts[]=$row;
        }
        dd ($posts);
        // fin des test
 */

    //on crée un tableau pour intégrer les post
    // while pour lire toutes les lignes en faisant une boucle
    while ($row = $req->fetch())
    {
        //SI comment est NULL je n'instancie pas $comment
        if (!empty($row["post_id"])){
            $comment = new Comment();
            $comment
                ->setId ($row["comment_id"])
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
//dd ($posts);
    return $posts;
}


//---------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------------------------------------------------------------------------------------------//
    /**
     * @param $username
     * @param $tableIdPosts
     * @return mixed
     */
    public function getPostsWithComsByUser($username, $tableIdPosts) //Liste des posts avec leurs commentaires
    {
        $listPostsIds = implode (",", $tableIdPosts); // "1,2, 3..."
        //dd ($listPostsIds);

        $req =$this->db->prepare('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment , c.post_id, c.comment_at, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at
FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE p.id IN ('.$listPostsIds.') AND p.username = ?
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
//dd ($posts);
        return $posts;
    }

    public function getPost($id) // afficher 1 billet
    {
        $req = $this->db->prepare('SELECT p.id, p.username, p.content, p.id_category, ca.name_category, DATE_FORMAT(post_at, \'%d/%m/%Y \') 
FROM post p 
INNER JOIN category ca ON p.id_category = ca.id_category
WHERE id = ?');
        $req->execute(array($id));
        $req->setFetchMode(\PDO::FETCH_CLASS,Post::class); // Ligne necessaire pour utiliser les entitiés dans les vues
        $post = $req->fetch();
        return $post;
    }

    /*----------------------------------- getPost-- CATEGORIES----------------------------------------------*/


    public function getPostsWithComsByCat($id_category, $tableIdPosts) //Liste des posts avec leurs commentaires
    {    $listPostsIds = implode (",", $tableIdPosts); // "1,2, 3..."

        $req =$this->db->prepare('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content contentComment, c.username nameComment , c.post_id, c.comment_at, p.is_signaled, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at,DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at FROM post p 
    LEFT JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE p.id_category = ? AND p.id IN ('.$listPostsIds.')
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

    /**
     * @param $post
     * @return bool
     */
    public function updatePost($post) // On recoit le post a enregistrer
    {
        $req = $this->db->prepare('UPDATE post SET id_category = ?, content = ? WHERE id = ?');
        $result = $req->execute(array(
            $post->getIdCategory(),
            $post->getContent(),
            $post->getId(),
        ));

        return $result;

    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $req = $this->db->prepare("DELETE FROM post WHERE id = ?");
        $result = $req->execute(array($id));
        return $result;
    }


}
