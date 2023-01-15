<?php /** @var \App\Models\Post $data */ ?>
<?php /** @var App\Core\IAuthenticator $auth */ ?>

<header class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder"><?php echo $data->getTitle() ?></h1>
        </div>
    </div>
</header>

<?php ///** @var \App\Models\Paragraph $paragraph */ ?>
<?php //foreach ($data->getParagraphs() as $paragraph) { ?>
<!--    <div class="container">-->
<!--        <div class="text-center my-5">-->
<!--            <h2 class="fw-bolder">--><?php //echo $paragraph->getTitle() ?><!--</h2>-->
<!--            <p>--><?php //echo $paragraph->getText() ?><!--</p>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?php //if ($auth->isLogged()) { ?>
<!--        <div class="row py-3">-->
<!--            <div class="col-lg-12">-->
<!--                <a class="btn btn-warning" href="?c=postContent&a=editParagraph&id=--><?php //echo $paragraph->getId() ?><!--">Uprav paragraf →</a>-->
<!--                <a class="btn btn-danger" href="?c=postContent&a=deleteParagraph&id=--><?php //echo $paragraph->getId() ?><!--">Zmaz paragraf →</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    --><?php //} ?>
<?php //} ?>




<?php $postContentElements = $data->getPostContentElements()?>
<?php /** @var \App\Models\Post_content_element $postContentElement */ ?>
<?php foreach ($postContentElements as $postContentElement) { ?>
    <?php if ($postContentElement->getElementType() == "par") { ?>

        <?php $paragraph = \App\Models\Paragraph::getOne($postContentElement->getId()) ?>
        <div class="container">
            <div class="text-center my-5">
                <h2 class="fw-bolder"><?php echo $paragraph->getTitle() ?>priority=<?php echo $postContentElement->getPriority() ?></h2>
                <p><?php echo $paragraph->getText() ?></p>
            </div>
        </div>
        <?php if ($auth->isLogged()) { ?>
            <div class="row py-3">
                <div class="col-lg-12">
                    <a class="btn btn-warning" href="?c=postContent&a=editParagraph&id=<?php echo $paragraph->getPostContentElementsId() ?>">Uprav paragraf →</a>
                    <a class="btn btn-danger" href="?c=postContent&a=deleteParagraph&id=<?php echo $paragraph->getPostContentElementsId() ?>">Zmaz paragraf →</a>
                </div>
            </div>
        <?php } ?>

    <?php } else if ($postContentElement->getElementType() == "img") { ?>
        <?php $image = \App\Models\Image::getOne($postContentElement->getId()) ?>

        <div class="container">
            <div class="clanok">
                <img src="../../../public/images/<?php echo $image->getImg() ?>" alt="..." />
                <div class="clanok-telo">
                    <p><?php echo $image->getText() ?>priority=<?php echo $postContentElement->getPriority()?></p>
                </div>
            </div>
        </div>
        <?php if ($auth->isLogged()) { ?>
            <div class="row py-3">
                <div class="col-lg-12">
                    <a class="btn btn-warning" href="?c=postContent&a=editImage&id=<?php echo $image->getPostContentElementsId() ?>">Uprav obrazok →</a>
                    <a class="btn btn-danger" href="?c=postContent&a=deleteImage&id=<?php echo $image->getPostContentElementsId() ?>">Zmaz obrazok →</a>
                </div>
            </div>
        <?php } ?>

    <?php } ?>

    <?php if ($auth->isLogged()) { ?>
        <div class="row py-3">
            <div class="col-lg-12">
                <a class="btn btn-warning" href="?c=postContent&a=increasePriority&id=<?php echo $postContentElement->getId() ?>">Posun vyssie →</a>
                <a class="btn btn-danger" href="?c=postContent&a=decreasePriority&id=<?php echo $postContentElement->getId() ?>&elementCount=<?php echo count($postContentElements) ?>">Posun nizsie →</a>
            </div>
        </div>
    <?php } ?>

<?php } ?>





<?php if ($auth->isLogged()) { ?>
    <div class="row py-3">
        <div class="col-lg-12">
            <a class="btn btn-success" href="?c=postContent&a=createParagraph&post_id=<?php echo $data->getId() ?>">Pridaj paragraf →</a>
        </div>
    </div>
<?php } ?>
<?php if ($auth->isLogged()) { ?>
    <div class="row py-3">
        <div class="col-lg-12">
            <a class="btn btn-success" href="?c=postContent&a=createImage&post_id=<?php echo $data->getId() ?>">Pridaj obrazok →</a>
        </div>
    </div>
<?php } ?>
