<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model
{
    //musia byt protected aby isiel framework
    protected $id;
    protected $text;
    protected $img;
    protected $title;

//    public function getParagraphs() {
//        return Paragraph::getAll('posts_id = ?', [$this->getId()]);
//    }
    public function getPostComments() {
        return Post_comment::getAll('posts_id = ?', [$this->getId()]);
    }

    public function getPostContentElements() {
        return Post_content_element::getAll('posts_id = ?', [$this->getId()], 'priority');
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
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
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