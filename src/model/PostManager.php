<?php
namespace App\model;
//require_once('DBManager.php');
use App\model\Entity\Post;

class PostManager extends DBManager
{

    public function savePost($post) // On recoit le billet a enregistrer
    {
        $req = $this->db->prepare('INSERT INTO post(username, content, post_at, categorie) VALUES(?, ?, NOW()),?');
        $req->execute(array($post->getUsername(),$post->getContent(),$post->getCategorie()));
        return $this->db->lastInsertId ();
    }

    public function getPosts() //on liste les posts
    {
        $datas =$this->db->query('SELECT id, username, content, post_at, categorie FROM post ORDER BY username DESC LIMIT 0, 10');
        $posts = array();
        $datas->setFetchMode(\PDO::FETCH_CLASS,Post::class); // on veux recupérer une class billet
        while ($post = $datas->fetch())  // tant qu on peut lire une ligne on fait la boucle
        {
            $posts[] = $post; // on rajoute la ligne dans le tableau
        }
        $datas->closeCursor(); // on libere la memoire
        return $posts; //le tableau est

    }

    public function getPost($id) // afficher 1 billet
    {
        $req = $this->db->prepare('SELECT id, username, content, post_at, categorie FROM post WHERE id = ?');
        $req->execute(array($id));
        $req->setFetchMode(\PDO::FETCH_CLASS,Post::class); // Ligne necessaire pour utiliser les entitiés dans les vues
        $post = $req->fetch();
        return $post;
    }

}
