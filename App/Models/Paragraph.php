<?php

namespace App\Models;

use App\Core\Model;

class Paragraph extends Model
{
    protected $id;
    protected $post_content_elements_id;
    protected $text;
    protected $title;



//    /**
//     * Return default primary key column name
//     * @return string
//     */
//    public static function getPkColumnName() : string
//    {
//        return 'post_content_elements_id';
//    }


    /**
     * @return mixed
     */
    public function getPostcontentelementsId()
    {
        return $this->post_content_elements_id;
    }

    /**
     * @param mixed $post_content_elements_id
     */
    public function setPostcontentelementsId($post_content_elements_id): void
    {
        $this->post_content_elements_id = $post_content_elements_id;
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


}