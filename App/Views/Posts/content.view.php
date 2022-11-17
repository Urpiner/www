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
<?php } ?>

