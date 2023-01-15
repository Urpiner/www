<?php

namespace App\Models;

use App\Core\Model;

class Post_content_element extends Model
{

    protected $id;
    protected $priority;
    protected $posts_id;
    protected $element_type;

    /**
     * @return mixed
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * @param mixed $element_type
     */
    public function setElementType($element_type): void
    {
        $this->element_type = $element_type;
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
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
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



}