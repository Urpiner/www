<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

use App\Models\Post;

class PostsController extends AControllerBase
{

    /**
     * povoli spustat v casoch uvedene requesty iba ak je uzivatel prihlaseny
     * vola sa automaticky frameworkom
     * @param $action
     * @return bool
     */

    public function authorize($action)
    {
        switch ($action) {
            case "delete":
            case "store":
            case "create":
            case "edit":
                return $this->app->getAuth()->isLogged();
        }
        return true;
    }

    public function index(): Response
    {
        $posts = Post::getAll();
        return $this->html($posts);
    }

    public function delete() {

        $id = $this->request()->getValue('id');
        $postToDelete = Post::getOne($id);

        if ($postToDelete) { //vrati true ak je nenullova hodnota

            if ($postToDelete->getImg()) {
                $imgPath = "C:\Users\Asus\Desktop\Vajko\php_mysql_home_2022\php_mysql\www\public\images" . DIRECTORY_SEPARATOR . $postToDelete->getImg();
                unlink($imgPath); //toto odstrani obrazok z foldera images
            }

            $postToDelete->delete();
        }
        return $this->redirect("?c=posts");
    }

    public function store() {
        $id = $this->request()->getValue('id');

        //v store() je logika aj pre editovanie existujuceho aj pre vytvaranie noveho postu
        //ak id este neni nastavene (pri vkladani do databazy sa automatikcy generuje id - autoincrement) -> vytvaram novy post ... inac editujem post
        if ($id) {
            $post = Post::getOne($id);
        } else {
            $post = new Post();
        }

        $inputText = $this->request()->getValue('text');
        $inputTitle = $this->request()->getValue('title');
        if ($inputText == null || strlen($inputText) == 0) {
            return $this->redirect("?c=posts");
        }
        if ($inputTitle != null && strlen($inputTitle) == 0) {
            return $this->redirect("?c=posts");
        }
        $post->setText($inputText);
        $post->setTitle($inputTitle);

        $files = $this->request()->getFiles(); //vo $files bude cele superglob pole $_FILES
        if (isset($files['img']) && $files['img']['error'] == UPLOAD_ERR_OK) {  // ak je obrazok v superglobalnej premennej (vo formulari je input typu 'file' a s name='img' -> tam sa bude zadavat obrazok) a zaroven nedoslo k chybe
            //prida na zaciatok mena obrazku timestamp (fcia "time()"), aby ak uzivatel nahra 2 obrazky s tym istym menom aby neboli problemy s duplicitami
            //$_FILES["fileToUpload"]["name"] ----> je nazov uploadnuteho suboru formularom

            //$imgRelativePath =   . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . time() . "_" . $files["img"]["name"]; //$newName bude teda relativna cesta (+ pridany timestamp na konci mena obrazku)
            $imgName = time() . "_" . $files["img"]["name"];
            $imgPath = "C:\Users\Asus\Desktop\Vajko\php_mysql_home_2022\php_mysql\www\public\images" . DIRECTORY_SEPARATOR . $imgName;
            if (move_uploaded_file($files["img"]["tmp_name"], $imgPath)) {        // movne uploadnuty obrazok na miesto v premennej $newName
                $post->setImg($imgName);
            }

        } else {
            return $this->redirect("?c=posts");
        }


        $post->save();
        return $this->redirect("?c=posts");
    }

    public function create() {
        return $this->html(new Post(), viewName: 'create.form');
    }

    public function edit() {
        // toto je funkcionalita frameworku, getValue('id') bude hladat hodnotu v superglob. poli $_POST['id']
        $id = $this->request()->getValue('id');
        $postToEdit = Post::getOne($id);

        return $this->html($postToEdit, viewName: 'create.form');
    }

    public function content() {
        $id = $this->request()->getValue('id');

        $url = "?c=postContent&id=" . $id;
        return $this->redirect($url);
    }

}