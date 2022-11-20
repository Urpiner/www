<?php /** @var \App\Models\Post $data */ ?>

<header class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder"><?php echo $data->getTitle() ?></h1>
        </div>
    </div>
</header>

<?php /** @var \App\Models\Paragraph $paragraph */ ?>
<?php foreach ($data->getParagraphs() as $paragraph) { ?>
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder"><?php echo $paragraph->getTitle() ?></h1>
            <p><?php echo $paragraph->getText() ?></p>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-lg-12">
            <a class="btn btn-warning" href="?c=postContent&a=editParagraph&id=<?php echo $paragraph->getId() ?>">Uprav paragraf →</a>
            <a class="btn btn-danger" href="?c=postContent&a=deleteParagraph&id=<?php echo $paragraph->getId() ?>">Zmaz paragraf →</a>
        </div>
    </div>
<?php } ?>

<div class="row py-3">
    <div class="col-lg-12">
        <a class="btn btn-success" href="?c=postContent&a=createParagraph&post_id=<?php echo $data->getId() ?>">Pridaj paragraf →</a>
    </div>
</div>

