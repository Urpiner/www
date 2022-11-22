
<form method="post" action="?c=posts&a=store" enctype="multipart/form-data">


    <?php /** @var \App\Models\Post $data */
    // $data je premenna ktora vznikne zavolanim $this->html($posts); v metode edit() alebo create() v triede PostsController
    // bude v nej to co sa posiela parametrom, v tomto pripade to bude Post

    //ak je id uz nastavene, tak chceme editovat post, inac sa bude vytvarat novy post - mohol na to mesko spravit 2 viewy, ale co uz, obidve logiky su v create.form.view.php
    if ($data->getId()) { //vrati true ak je nenullove ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"> <!-- skryty parameter, len hodi do $_POST['id'] idecko postu na editnutie -->
    <?php } ?>


    <div>
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $data->getTitle() ?>"><br>
    </div>

    <div>
        <label for="text">Text:</label><br>
        <input type="text" id="text" name="text" value="<?php echo $data->getText() ?>"><br>
    </div>

    <div>
        <label for="image">Image:</label><br>
        <input type="file" name="img" id="img">
    </div>

    <br>
    <div>
        <input type="submit" value="Odoslať" id="submit">
    </div>

    <div id="submit-info">
        Formulár obsahuje chyby a nie je možné ho odoslať.
    </div>
</form>
