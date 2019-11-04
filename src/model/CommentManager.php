<?php
namespace App\model;
//require_once('DBManager.php'); 
use App\model\Entity\Comment;

class CommentManager extends DBManager
{
    public function getComments($post_id)
    {
        $comments= $this->db->prepare('SELECT id_comment, username_comment, content_comment, DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at FROM comment WHERE post_id = ? ORDER BY comment_at DESC');
        $comments->execute(array($post_id));
        $comments->setFetchMode(\PDO::FETCH_CLASS,Comment::class);
        return $comments;
    }

    /**
     * @return array|false|\PDOStatement
     */
    public function getCommentsBis()
    {
        $req = $this->db->query('SELECT c.id_comment, c.username_comment, c.content_comment, DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at FROM comment c ORDER BY comment_at');
        $comments = array();
        $req->setFetchMode(\PDO::FETCH_CLASS,Comment::class);
        var_dump ($comments);
        return $comments;
    }

    public function saveComment($comment)
    {
        $req = $this->db->prepare('INSERT INTO comment(post_id, username, content, comment_at) VALUES(?, ?, ?, NOW())');
        $affectedLines = $req->execute(array($comment->getPostId(),$comment->getUsername(),$comment->getContent()));
        return $affectedLines;


    }
}