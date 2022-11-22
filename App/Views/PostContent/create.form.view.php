<?php /** @var \App\Models\Paragraph $data */ ?>



<!-- ak este nebol paragraf ulozeny v db, tak nebude mat nastavene id (v tabulke je autoincrement id)-->
<form method="post" action="?c=postContent&a=storeParagraph&id=<?php echo $data->getId() ?>&post_id=<?php echo $data->getPostsId() ?>" enctype="multipart/form-data">

    <!-- ak je id uz nastavene, tak chceme editovat paragraph, inac sa bude vytvarat novy paragraph -->
    <?php if ($data->getId()) { //vrati true ak je nenullove ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"> <!-- skryty parameter, len hodi do $_POST['id'] idecko paragraphu na editnutie -->
    <?php } ?>


    <div>
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $data->getTitle() ?>"><br>
    </div>

    <div>
        <label for="text">Text:</label><br>
        <input type="text" id="text" name="text" value="<?php echo $data->getText() ?>"><br>
    </div>



    <br>
    <div>
        <input type="submit" value="Odoslať" id="submit">
    </div>

    <div id="submit-info">
        Formulár obsahuje chyby a nie je možné ho odoslať.
    </div>



</form>
