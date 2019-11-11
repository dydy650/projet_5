<?php

namespace App\model\Entity;

class Comment
{
    protected $post_id;
    protected $username;
    protected $content;
    protected $comment_at;
    protected $is_signaled;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Comment
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
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
    public function getIsSignaled()
    {
        return $this->is_signaled;
    }

    /**
     * @param mixed $is_signaled
     * @return Comment
     */
    public function setIsSignaled($is_signaled)
    {
        $this->is_signaled = $is_signaled;
        return $this;
    }

}
