<?php
namespace App\model;
//require_once('DBManager.php'); 
use App\model\Entity\Comment;

class CommentManager extends DBManager
{
    public function getComments($post_id)
    {
        $comments= $this->db->prepare('SELECT id, username, content, DATE_FORMAT(comment_at, \'%d/%m/%Y \') AS comment_at FROM comment WHERE post_id = ? ORDER BY comment_at DESC');
        $comments->execute(array($post_id));
        $comments->setFetchMode(\PDO::FETCH_CLASS,Comment::class);
        return $comments;
    }
}