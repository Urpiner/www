<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Post;
use App\Models\Post_comment;

class PostCommentsController extends AControllerBase {

    public function authorize($action)
    {
        switch ($action) {
            case "deleteComment":
            case "storeComment":
            case "createComment":
                return $this->app->getAuth()->isLogged();
        }
        return true;
    }


    public function index(): Response
    {
        $post_id = $this->request()->getValue("post_id"); //tento parameter posielam urlkou v content() v PostsController
        $post = Post::getOne($post_id);
        return $this->html($post);
    }


    public function deleteComment() {
        $id = $this->request()->getValue('id');
        $postComment = Post_comment::getOne($id);

        $post_id = $postComment->getPostsId(); //kvoli redirectu

        //zalezi na poradi deletov
        if ($postComment) { //vrati true ak je nenullova hodnota
            $postComment->delete();
        }

        $url = "?c=postComments&post_id=" . $post_id;
        return $this->redirect($url);
    }

    public function storeComment() {

        $id = $this->request()->getValue('id');
        $post_id = $this->request()->getValue('post_id');

        if ($id) {
            $postComment = Post_comment::getOne($id);
        } else {
            $postComment = new Post_comment();
        }

        $inputText = $this->request()->getValue('text');
        $inputUsername = $this->request()->getValue('username');
        if ($inputText == null || strlen($inputText) == 0) {
            $url = "?c=postComments&post_id=" . $post_id;
            return $this->redirect($url);
        }
        if ($inputUsername != null && strlen($inputUsername) == 0) {
            $url = "?c=postComments&post_id=" . $post_id;
            return $this->redirect($url);
        }
        $postComment->setText($inputText);
        $postComment->setUsername($inputUsername);
        $postComment->setDate(date("Y-m-d h:i:sa"));
        $postComment->setPostsId($post_id);

        //po uspesnych kontrolach vstupov, mozem ukladat na databazu
        $postComment->save();

        $url = "?c=postComments&post_id=" . $post_id;
        return $this->redirect($url);
    }

    public function createComment() {
        $post_id = $this->request()->getValue('post_id');
        $newComment = new Post_comment();
        $newComment->setPostsId($post_id);

        //newParagraph tam posielam aby nevznikol nullpointerexception ... a posuniem si nim post_id, ktore budem potrebovat v store()
        //v store() sa vytvori zas nova instancia paragrafu, cize tuto $newParagraph len zozerie garbage collector asi
        return $this->html($newComment, viewName: 'create.form');
    }

//    public function editParagraph() {
//        $id = $this->request()->getValue('id');
//        //$paragraphToEdit = Paragraph::getOne($id);
//        //$postContentElementToEdit = Post_content_element::getOne($id);
//        $paragraphArray = \App\Models\Paragraph::getAll('post_content_elements_id = ?', [$id]);
//        $paragraphToEdit = $paragraphArray[0];
//
//
//        return $this->html($paragraphToEdit, viewName: 'create.form');
//    }

}