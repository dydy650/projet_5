<?php
namespace App\model;
//require_once('DBManager.php'); 
use App\model\Entity\Comment;

class CommentManager extends DBManager
{

    /**
     * @param Comment $comment
     * @return bool
     */
    public function saveComment($comment)
    {
        $req = $this->db->prepare('INSERT INTO comment(post_id, username, content, comment_at) VALUES(?, ?, ?, NOW())');
        $affectedLines = $req->execute(array(
            $comment->getPostId(),
            $comment->getUsername(),
            $comment->getContent()
        ));
        return $affectedLines;


    }
}