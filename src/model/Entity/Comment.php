<?php

namespace App\model\Entity;

class Comment
{
    private $id_comment;

    /**
     * @return mixed
     */
    public function getIdComment()
    {
        return $this->id_comment;
    }

    /**
     * @param mixed $id_comment
     * @return Comment
     */
    public function setIdComment($id_comment)
    {
        $this->id_comment = $id_comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     * @return Comment
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsernameComment()
    {
        return $this->username_comment;
    }

    /**
     * @param mixed $username_comment
     * @return Comment
     */
    public function setUsernameComment($username_comment)
    {
        $this->username_comment = $username_comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentComment()
    {
        return $this->content_comment;
    }

    /**
     * @param mixed $content_comment
     * @return Comment
     */
    public function setContentComment($content_comment)
    {
        $this->content_comment = $content_comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentAt()
    {
        return $this->comment_at;
    }

    /**
     * @param mixed $comment_at
     * @return Comment
     */
    public function setCommentAt($comment_at)
    {
        $this->comment_at = $comment_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsSignaledComment()
    {
        return $this->is_signaled_comment;
    }

    /**
     * @param mixed $is_signaled_comment
     * @return Comment
     */
    public function setIsSignaledComment($is_signaled_comment)
    {
        $this->is_signaled_comment = $is_signaled_comment;
        return $this;
    }
    private $post_id;
    private $username_comment;
    private $content_comment;
    private $comment_at;
    private $is_signaled_comment;
}
