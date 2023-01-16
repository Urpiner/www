<?php /** @var \App\Models\Post_comment $data */ ?>
<?php $post_id = $data->getPostsId() ?>


<!-- ak este nebol koment ulozeny v db, tak nebude mat nastavene id (v tabulke je autoincrement id)-->
<form method="post" action="?c=postComments&a=storeComment&id=<?php echo $data->getId() ?>&post_id=<?php echo $post_id ?>" enctype="multipart/form-data">

    <!-- ak je id uz nastavene, tak chceme editovat koment, inac sa bude vytvarat novy koment -->
    <?php if ($data->getId()) { //vrati true ak je nenullove ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"> <!-- skryty parameter, len hodi do $_POST['id'] idecko paragraphu na editnutie -->
    <?php } ?>


    <div>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $data->getUsername() ?>"><br>
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
