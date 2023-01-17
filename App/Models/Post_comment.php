<?php

namespace App\Models;

use App\Core\Model;

class Post_comment extends Model
{
    protected $id;
    protected $posts_id;
    protected $post_comments_id;
    public $date;
    public $username;
    public $text;

    public function getAllReplies() {
        return Post_comment::getAll('post_comments_id = ?', [$this->getId()]);
    }

    /**
     * @return mixed
     */
    public function getPostCommentsId()
    {
        return $this->post_comments_id;
    }

    /**
     * @param mixed $post_comments_id
     */
    public function setPostCommentsId($post_comments_id): void
    {
        $this->post_comments_id = $post_comments_id;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPostsId()
    {
        return $this->posts_id;
    }

    /**
     * @param mixed $posts_id
     */
    public function setPostsId($posts_id): void
    {
        $this->posts_id = $posts_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
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
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }


}