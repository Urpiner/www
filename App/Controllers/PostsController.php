<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Like;
use App\Models\Post;

class PostsController extends AControllerBase
{

    /**
     * povoli spustat v casoch uvedene requesty iba ak je uzivatel prihlaseny
     * vola sa automaticky frameworkom
     * @param $action
     * @return bool
     */
//    public function authorize($action)
//    {
//        switch ($action) {
//            case "delete":
//            case "store":
//            case "create":
//            case "edit":
//            case "like":
//                return $this->app->getAuth()->isLogged();
//        }
//        return true;
//    }

    public function index(): Response
    {
        $posts = Post::getAll();
        return $this->html($posts);
    }

    // tieto metody sa volaju v html kodoch pomocou urlky "?c=Posts&a="tuto ide meno metody ktoru chcem zavolat""  // c=Posts urcuje v ktory controller ... a=delete urcuje ze sa spusti akcia(metoda) delete
    // npr: <form method="post" action="?c=posts&a=store">                                                      -> toto spusti store ked sa vyplni formular
    // alebo: <a href="?c=posts&a=delete&id=<?php echo $post->getId() ?,>" class="btn btn-danger">Zmazat</a>    -> toto spusti delete, ked sa stlaci na button
    // alebo: <a href="?c=posts&a=create">Vytvor post</a>  -> po kliknuti na button spusti metodu create

    public function delete() {
        // toto je funkcionalita frameworku, getValue('id') bude hladat hodnotu v superglob. poli $_POST['id']
        // Post['id'] sa naplnuje v buttone Zmaz v Posts/index.view.php
        $id = $this->request()->getValue('id');
        $postToDelete = Post::getOne($id);
        if ($postToDelete) { //vrati true ak je nenullova hodnota
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
        // toto je funkcionalita frameworku, getValue('text') bude hladat hodnotu v superglob. poli $_POST['text']
        // Post['text'] sa naplnuje vo formulari v Posts/create.form.view.php
        $post->setText($this->request()->getValue('text'));
        $post->setTitle($this->request()->getValue('title'));

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

        }



        $post->save();
        return $this->redirect("?c=posts");
    }

    public function create() {
        // vrati ten view kde je formular (create.form.view.php - .view.php tam nemusi pisat - je to postfix)
        // prvy parameter: sa posle hocijaky objekt do atributu $data, a ten $data bude potom pristupny v tom subore create.form.view.php (ako globalny variable alebo co)
        // druhy parameter: view, ktory sa ma zobrazit
        return $this->html(new Post(), viewName: 'create.form');
    }

    public function edit() {
        // toto je funkcionalita frameworku, getValue('id') bude hladat hodnotu v superglob. poli $_POST['id']
        $id = $this->request()->getValue('id');
        $postToEdit = Post::getOne($id);

        // vrati ten view kde je formular (create.form.view.php - .view.php tam nemusi pisat - je to postfix)
        // prvy parameter: sa posle hocijaky objekt do atributu $data, a ten $data bude potom pristupny v tom subore create.form.view.php (ako globalny variable alebo co)
        // druhy parameter: view, ktory sa ma zobrazit
        return $this->html($postToEdit, viewName: 'create.form');
    }

    public function content() {
        $id = $this->request()->getValue('id');
        ///$post = Post::getOne($id);

        ///return $this->html($post, viewName: 'content');
        $url = "?c=postContent&id=" . $id;
        return $this->redirect($url);
    }

}