<?php

namespace App\Models;

use App\Core\Model;

class Paragraph extends Model
{
    protected $id;
    protected $posts_id;
    protected $text;
    protected $title;

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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }


}