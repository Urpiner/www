<!-- v Posts/index.view.php mam okomentovane co v tom href je -->
<form method="post" action="?c=posts&a=store" enctype="multipart/form-data">


    <?php /** @var \App\Models\Post $data */
    // $data je premenna ktora vznikne zavolanim $this->html($posts); v metode edit() alebo create() v triede PostsController
    // bude v nej to co sa posiela parametrom, v tomto pripade to bude Post

    //ak je id uz nastavene, tak chceme editovat post, inac sa bude vytvarat novy post - mohol na to mesko spravit 2 viewy, ale co uz, obidve logiky su v create.form.view.php
    if ($data->getId()) { //vrati true ak je nenullove ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"> <!-- skryty parameter, len hodi do $_POST['id'] idecko postu na editnutie -->
    <?php } ?>

    <label>
        Title:
        <!-- vo value su veci ktore budu v tom input okienku uz zo zaciatku vpisane -->
        <input type="text" name="title" value="<?php echo $data->getTitle() ?>">
    </label>
    <label>
        Text:
        <!-- vo value su veci ktore budu v tom input okienku uz zo zaciatku vpisane -->
        <input type="text" name="text" value="<?php echo $data->getText() ?>">
    </label>

    <input type="file" name="img">

    <input type="submit" value="Odoslat">
</form>
