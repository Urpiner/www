<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Paragraph;
use App\Models\Post;

class PostContentController extends AControllerBase
{
    public function authorize($action)
    {
        switch ($action) {
            case "deleteParagraph":
            case "storeParagraph":
            case "createParagraph":
            case "editParagraph":
                return $this->app->getAuth()->isLogged();
        }
        return true;
    }


    public function index(): Response
    {
        $id = $this->request()->getValue("id"); //tento parameter posielam urlkou v content() v PostsController
        $post = Post::getOne($id);
        return $this->html($post);
    }

    public function deleteParagraph() {
        $id = $this->request()->getValue('id');
        $paragraphToDelete = Paragraph::getOne($id);

        $post_id = $paragraphToDelete->getPostsId(); //kvoli redirectu

        if ($paragraphToDelete) { //vrati true ak je nenullova hodnota
            $paragraphToDelete->delete();
        }

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function storeParagraph() {

        $id = $this->request()->getValue('id');
        $post_id = $this->request()->getValue('post_id');

        if ($id) {
            $paragraph = Paragraph::getOne($id);
        } else {
            $paragraph = new Paragraph();
            $paragraph->setPostsId($post_id);
        }

        $inputText = $this->request()->getValue('text');
        $inputTitle = $this->request()->getValue('title');
        if ($inputText == null || strlen($inputText) == 0) {
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }
        if ($inputTitle != null && strlen($inputTitle) == 0) {
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }
        $paragraph->setText($inputText);
        $paragraph->setTitle($inputTitle);

        $paragraph->save();

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function createParagraph() {
        $post_id = $this->request()->getValue('post_id');
        $newParagraph = new Paragraph();
        $newParagraph->setPostsId($post_id);

        //newParagraph tam posielam aby nevznikol nullpointerexception ... a posuniem si nim post_id, ktore budem potrebovat v store()
        //v store() sa vytvori zas nova instancia paragrafu, cize tuto $newParagraph len zozerie garbage collector asi
        return $this->html($newParagraph, viewName: 'create.form');
    }

    public function editParagraph() {
        $id = $this->request()->getValue('id');
        $paragraphToEdit = Paragraph::getOne($id);

        return $this->html($paragraphToEdit, viewName: 'create.form');
    }



}