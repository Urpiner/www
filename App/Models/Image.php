<?php

namespace App\Models;

use App\Core\Model;

class Image extends Model
{
    protected $post_content_elements_id;
    protected $img;
    protected $text;


    /**
     * Return default primary key column name
     * @return string
     */
    public static function getPkColumnName() : string
    {
        return 'post_content_elements_id';
    }

    /**
     * @return mixed
     */
    public function getPostContentElementsId()
    {
        return $this->post_content_elements_id;
    }

    /**
     * @param mixed $post_content_elements_id
     */
    public function setPostContentElementsId($post_content_elements_id): void
    {
        $this->post_content_elements_id = $post_content_elements_id;
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
}