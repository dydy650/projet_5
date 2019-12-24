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
        $req = $this->db->prepare('INSERT INTO p5_comment(post_id, username, content, comment_at) VALUES(?, ?, ?, NOW())');
        $affectedLines = $req->execute(array(
            $comment->getPostId(),
            $comment->getUsername(),
            $comment->getContent()
        ));
        return $affectedLines;


    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteComment($id)
    {
        $req = $this->db->prepare("DELETE FROM p5_comment WHERE id = ?");
        $result = $req->execute(array($id));
        return $result;
    }
}