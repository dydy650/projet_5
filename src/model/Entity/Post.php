<?php

namespace App\model\Entity;

class Post
{
    private $id;
    private $id_category;
    private $username;
    private $content;
    private $post_at;
    private $is_signaled;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * @param mixed $id_category
     * @return Post
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
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
     * @return Post
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
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostAt()
    {
        return $this->post_at;
    }

    /**
     * @param mixed $post_at
     * @return Post
     */
    public function setPostAt($post_at)
    {
        $this->post_at = $post_at;
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
     * @return Post
     */
    public function setIsSignaled($is_signaled)
    {
        $this->is_signaled = $is_signaled;
        return $this;
    }
}

