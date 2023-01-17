<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Image;
use App\Models\Paragraph;
use App\Models\Post;
use App\Models\Post_content_element;

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

// CRUD paragraph ---------------

    public function deleteParagraph() {
        $id = $this->request()->getValue('id');
        $postContentElementToDelete = Post_content_element::getOne($id);
        $paragraphArray = \App\Models\Paragraph::getAll('post_content_elements_id = ?', [$id]);
        $paragraphToDelete = $paragraphArray[0];

        $post_id = $postContentElementToDelete->getPostsId(); //kvoli redirectu



        //zvys prioritu tym co su nizsie na stranke (aby neboli medzery npr 0 1 2 4 5, ale aby sli postupne 0 1 2 3 4)
        $postContentElementsWithLowerPriority = \App\Models\Post_content_element::getAll('priority > ? AND posts_id = ?', [$postContentElementToDelete->getPriority(), $postContentElementToDelete->getPostsId()]);
        foreach ($postContentElementsWithLowerPriority as $postContentElement) {
            $postContentElement->setPriority($postContentElement->getPriority() - 1);
            $postContentElement->save();
        }

        //zalezi na poradi deletov
        if ($paragraphToDelete) { //vrati true ak je nenullova hodnota
            $paragraphToDelete->delete();
        }
        if ($postContentElementToDelete) { //vrati true ak je nenullova hodnota
            $postContentElementToDelete->delete();
        }

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function storeParagraph() {

        $id = $this->request()->getValue('id'); //post_content_elements_id
        $post_id = $this->request()->getValue('post_id');

        if ($id) {
            //$paragraph = Paragraph::getOne($id);
            $paragraphArray = \App\Models\Paragraph::getAll('post_content_elements_id = ?', [$id]);
            $paragraph = $paragraphArray[0];
        } else {
            $paragraph = new Paragraph();
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

        //po uspesnych kontrolach vstupov, mozem ukladat na databazu
        if (!$id) { //ak neni id paragrafu -> este nebol vytvoreny newPostContentElement
            $elements = Post_content_element::getAll('posts_id = ?', [$post_id]);
            $elementCount = count($elements);

            $newPostContentElement = new Post_content_element();
            $newPostContentElement->setPostsId($post_id);
            $newPostContentElement->setPriority($elementCount); //najnizsia priorita (najvyssia je 0)
            $newPostContentElement->setElementType("par"); //par = paragraf
            $newPostContentElement->save();

            $paragraph->setPostcontentelementsId($newPostContentElement->getId());
        }
        $paragraph->save();

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function createParagraph() {
        $post_id = $this->request()->getValue('post_id');
        $newParagraph = new Paragraph();
        //$newParagraph->setPostsId($post_id);

        //newParagraph tam posielam aby nevznikol nullpointerexception ... a posuniem si nim post_id, ktore budem potrebovat v store()
        //v store() sa vytvori zas nova instancia paragrafu, cize tuto $newParagraph len zozerie garbage collector asi
        return $this->html($newParagraph, viewName: 'create.form');
    }

    public function editParagraph() {
        $id = $this->request()->getValue('id');
        //$paragraphToEdit = Paragraph::getOne($id);
        //$postContentElementToEdit = Post_content_element::getOne($id);
        $paragraphArray = \App\Models\Paragraph::getAll('post_content_elements_id = ?', [$id]);
        $paragraphToEdit = $paragraphArray[0];


        return $this->html($paragraphToEdit, viewName: 'create.form');
    }

// CRUD Image ------------

    public function deleteImage() {
        $id = $this->request()->getValue('id');
        $postContentElementToDelete = Post_content_element::getOne($id);
        $imageArray = \App\Models\Image::getAll('post_content_elements_id = ?', [$id]);
        $imageToDelete = $imageArray[0];

        $post_id = $postContentElementToDelete->getPostsId(); //kvoli redirectu

        //zvys prioritu tym co su nizsie na stranke (aby neboli medzery npr 0 1 2 4 5, ale aby sli postupne 0 1 2 3 4)
        $postContentElementsWithLowerPriority = \App\Models\Post_content_element::getAll('priority > ? AND posts_id = ?', [$postContentElementToDelete->getPriority(), $postContentElementToDelete->getPostsId()]);
        foreach ($postContentElementsWithLowerPriority as $postContentElement) {
            $postContentElement->setPriority($postContentElement->getPriority() - 1);
            $postContentElement->save();
        }

        //zalezi na poradi deletov
        if ($imageToDelete) { //vrati true ak je nenullova hodnota
            $imageToDelete->delete();
        }
        if ($postContentElementToDelete) { //vrati true ak je nenullova hodnota
            $postContentElementToDelete->delete();
        }

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function storeImage() {

        $id = $this->request()->getValue('id'); //post_content_elements_id
        $post_id = $this->request()->getValue('post_id');

        if ($id) {
            //$paragraph = Paragraph::getOne($id);
            $imageArray = \App\Models\Image::getAll('post_content_elements_id = ?', [$id]);
            $image = $imageArray[0];
        } else {
            $image = new Image();
        }

        $inputText = $this->request()->getValue('text');
        if ($inputText == null || strlen($inputText) == 0) {
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }
        $image->setText($inputText);

        $files = $this->request()->getFiles(); //vo $files bude cele superglob pole $_FILES
        if (isset($files['img']) && $files['img']['error'] == UPLOAD_ERR_OK) {  // ak je obrazok v superglobalnej premennej (vo formulari je input typu 'file' a s name='img' -> tam sa bude zadavat obrazok) a zaroven nedoslo k chybe
            //prida na zaciatok mena obrazku timestamp (fcia "time()"), aby ak uzivatel nahra 2 obrazky s tym istym menom aby neboli problemy s duplicitami
            //$_FILES["fileToUpload"]["name"] ----> je nazov uploadnuteho suboru formularom

            //$imgRelativePath =   . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . time() . "_" . $files["img"]["name"]; //$newName bude teda relativna cesta (+ pridany timestamp na konci mena obrazku)
            $imgName = time() . "_" . $files["img"]["name"];
            $imgPath = "C:\Users\Asus\Desktop\Vajko\php_mysql_home_2022\php_mysql\www\public\images" . DIRECTORY_SEPARATOR . $imgName;
            if (move_uploaded_file($files["img"]["tmp_name"], $imgPath)) {        // movne uploadnuty obrazok na miesto v premennej $newName
                $image->setImg($imgName);
            }
        } else {
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }


        //po uspesnych kontrolach vstupov, mozem ukladat na databazu
        if (!$id) { //ak neni id  -> este nebol vytvoreny newPostContentElement
            $elements = Post_content_element::getAll('posts_id = ?', [$post_id]);
            $elementCount = count($elements);

            $newPostContentElement = new Post_content_element();
            $newPostContentElement->setPostsId($post_id);
            $newPostContentElement->setPriority($elementCount); //najnizsia priorita (najvyssia je 0)
            $newPostContentElement->setElementType("img"); //img = image
            $newPostContentElement->save();

            $image->setPostcontentelementsId($newPostContentElement->getId());
        }
        $image->save();

        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function createImage() {
        $post_id = $this->request()->getValue('post_id');
        $newImage = new Image();
        //$newParagraph->setPostsId($post_id);

        return $this->html($newImage, viewName: 'createImage.form');
    }

    public function editImage() {
        $id = $this->request()->getValue('id');
        //$paragraphToEdit = Paragraph::getOne($id);
        //$postContentElementToEdit = Post_content_element::getOne($id);
        $imageArray = \App\Models\Image::getAll('post_content_elements_id = ?', [$id]);
        $imageToEdit = $imageArray[0];


        return $this->html($imageToEdit, viewName: 'createImage.form');
    }




    public function increasePriority() {
        $postContentElementId = $this->request()->getValue('id');
        $postContentElement = Post_content_element::getOne($postContentElementId);

        if ($postContentElement->getPriority() == 0) { //element uz ma najvyssiu prioritu
            //presmerovanie spat na vnutro konkretneho postu
            $post_id = $postContentElement->getPostsId();
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }

        //najdi element s o 1 vyssou prioritou, zniz mu prioritu a sebe zvys prioritu
        $postContentElementHigher = Post_content_element::getAll('priority = ? AND posts_id = ?', [($postContentElement->getPriority() - 1), $postContentElement->getPostsId()]);
        if (count($postContentElementHigher) != 1) { //getAll musi vratit iba 1 zaznam (stlpec priority je unikatny)
            //presmerovanie spat na vnutro konkretneho postu
            $post_id = $postContentElement->getPostsId();
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }

        $postContentElement->setPriority($postContentElement->getPriority() - 1);
        $postContentElementHigher[0]->setPriority($postContentElement->getPriority() + 1);
        $postContentElement->save();
        $postContentElementHigher[0]->save();

        //presmerovanie spat na vnutro konkretneho postu
        $post_id = $postContentElement->getPostsId();
        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }

    public function decreasePriority() {
        $postContentElementCount = $this->request()->getValue('elementCount'); //pocet elementov v poste
        $postContentElementId = $this->request()->getValue('id');
        $postContentElement = Post_content_element::getOne($postContentElementId);

        if ($postContentElement->getPriority() == ($postContentElementCount - 1)) { //element uz ma najnizsiu prioritu (0 - najvyssia ... ($postContentElementCount - 1) - najnizsia)
            //presmerovanie spat na vnutro konkretneho postu
            $post_id = $postContentElement->getPostsId();
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }

        //najdi element s o 1 nizsou prioritou, zvys mu prioritu a sebe zniz prioritu
        $postContentElementLower = Post_content_element::getAll('priority = ? AND posts_id = ?', [($postContentElement->getPriority() + 1), $postContentElement->getPostsId()]);
        if (count($postContentElementLower) != 1) { //getAll musi vratit iba 1 zaznam (stlpec priority je unikatny)
            //presmerovanie spat na vnutro konkretneho postu
            $post_id = $postContentElement->getPostsId();
            $url = "?c=postContent&id=" . $post_id;
            return $this->redirect($url);
        }

        $postContentElement->setPriority($postContentElement->getPriority() + 1);
        $postContentElementLower[0]->setPriority($postContentElement->getPriority() - 1);
        $postContentElement->save();
        $postContentElementLower[0]->save();

        //presmerovanie spat na vnutro konkretneho postu
        $post_id = $postContentElement->getPostsId();
        $url = "?c=postContent&id=" . $post_id;
        return $this->redirect($url);
    }



}