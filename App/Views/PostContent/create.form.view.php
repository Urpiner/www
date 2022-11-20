<?php /** @var \App\Models\Paragraph $data */ ?>


<!-- v Posts/index.view.php mam okomentovane co v tom href je -->
<!-- ak este nebol paragraf ulozeny v db, tak nebude mat nastavene id (v tabulke je autoincrement id)-->
<form method="post" action="?c=postContent&a=storeParagraph&id=<?php echo $data->getId() ?>&post_id=<?php echo $data->getPostsId() ?>" enctype="multipart/form-data">

    <!-- ak je id uz nastavene, tak chceme editovat paragraph, inac sa bude vytvarat novy paragraph -->
    <?php if ($data->getId()) { //vrati true ak je nenullove ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"> <!-- skryty parameter, len hodi do $_POST['id'] idecko paragraphu na editnutie -->
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

    <input type="submit" value="Odoslat">
</form>
