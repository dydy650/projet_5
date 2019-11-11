<?php

namespace App\model\Entity;
use App\model\Entity\Comment;
use App\model\Entity\Category;


class Post
{
    protected $id;
    protected $id_category;
    protected $username;
    protected $content;
    protected $post_at;
    protected $is_signaled;
    protected $comments =array();
    protected $category;

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function addComment($comment)
    {
        $this->comments[] = $comment;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }


    /*----------------Comment & Category--------------------*/



    /**-----------------------------POST----------------------------------------
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