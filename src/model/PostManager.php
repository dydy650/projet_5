<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\Post;
use App\model\Entity\Category;

class PostManager extends DBManager
{

    public function savePost($post) // On recoit le billet a enregistrer
    {
        $req = $this->db->prepare('INSERT INTO post(username, content, post_at, categorie) VALUES(?, ?, NOW())');
        $req->execute(array($post->getUsername(),$post->getContent(),$post->getCategorie()));
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

    public function getPostsWithComs() //on liste les posts
    {
        $req =$this->db->prepare('SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content_comment test, c.username_comment, c.comment_at, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS post_at 
FROM post p 
    INNER JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
ORDER BY p.post_at');
        $req->execute ();
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        //var_dump ($posts);
        $posts = array();
       //$datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($row = $req->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $category = new Category();
            //hydrater la category

            $comment = new Comment();
            //hydrater comment


            $post = new Post();
            $post->setId ($row["id"])
                ->setIdCategory ($row["id_category"]); // methode qui ait $post->setCategory($category)

            $posts[] = $post;// on rajoute la ligne dans le tableau
            echo"<pre>";
            var_dump ($row, $post);
            die;
        }
        $req->closeCursor(); // on libere la memoire
       //var_dump ($posts);
        return $posts; //le tableau est*/

    }
//---------------------------------------------------------------------------------------------------------------------------//

//---------------------------------------------------------------------------------------------------------------------------//
    /**
     * @param $username
     * @return mixed
     */
    public function getPostsByUser($username) //on liste les posts
    {
        $datas = $this->db->prepare('
SELECT p.id,  p.username, p.content, p.id_category, ca.name_category, c.content, DATE_FORMAT(post_at, \'%d/%m/%Y \') AS FR_date 
FROM post p 
    INNER JOIN `comment` c ON p.id = c.post_id 
    INNER JOIN category ca ON p.id_category = ca.id_category 
WHERE  p.username = ?');
        $datas->execute(array($username));
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class);// on veux recupérer une class post
        $posts=[];
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau tant que $post est true
            var_dump ($post);

        }
        $datas->closeCursor(); // on libere la memoire*/
        var_dump ($username);
        var_dump ($posts);

        return $posts; //le tableau avec mes posts est prete et envoyé au controller

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

    /**
     * @param $id_category
     * @return array
     */
    public function getPostsByCategory($id_category)
    {
        $req =$this->db->prepare(/**/ '
SELECT p.id, p.username, p.content, p.id_category, DATE_FORMAT(post_at, \'%d/%m/%Y \') 
FROM post p
INNER JOIN `category` ca ON p.id_category = ca.id_category 
WHERE $id_category = ?
ORDER BY post_at DESC 
LIMIT 0, 10
');
        $req->execute(array($id_category));
        $req->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        $posts=[];
        while ($post = $req->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $req->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

/*
    public function getPostsCatGarde() //on liste les posts
    {
        $datas =$this->db->query('
SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') 
FROM post 
WHERE categorie = "#garde_enfant" 
ORDER BY post_at DESC 
LIMIT 0, 10
');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatImmo() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#immobilier" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatTroc() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#vente_troc" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatLifestyle() //on liste les posts
    {
        $datas = $this->db->query ('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#lifestyle" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode (\PDO::FETCH_CLASS, Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch ())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor (); // on libere la memoire
        return $posts; //le tableau est
    }

    public function getPostsCatSorties() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#sorties_loisirs" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatHumeur() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#humeur_du_jour" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatSport() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#sport" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }


    public function getPostsCatBonsPlans() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#bons_plans" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatAide() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#aide_SOS" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatAutres() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#autres" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPostsCatVoyages() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, categorie, DATE_FORMAT(post_at, \'%d/%m/%Y \') FROM post WHERE categorie = "#voyages" ORDER BY post_at DESC LIMIT 0, 10');
        $posts = array();
        var_dump ($posts);
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }*/


}
