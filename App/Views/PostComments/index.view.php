<?php /** @var \App\Models\Post $data */ ?>
<?php /** @var App\Core\IAuthenticator $auth */ ?>

<header class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">Diskusia k článku: <?php echo $data->getTitle() ?></h1>
        </div>
    </div>
</header>



<?php $postComments = $data->getPostComments()?>
<?php /** @var \App\Models\Post_comment $postComment */ ?>
<?php foreach ($postComments as $postComment) { ?>
    <div class="container">
        <div class="text-center my-5">
            <h2 class="fw-bolder"><?php echo $postComment->getText() ?></h2>
            <p><?php echo $postComment->getUsername() ?></p>
            <p><?php echo $postComment->getDate() ?></p>
        </div>
    </div>
    <?php if ($auth->isLogged()) { ?>
        <div class="row py-3">
            <div class="col-lg-12">
                <a class="btn btn-danger" href="?c=postComments&a=deleteComment&id=<?php echo $postComment->getId() ?>">Zmaz koment →</a>
            </div>
        </div>
    <?php } ?>
<?php } ?>







<div class="row py-3">
    <div class="col-lg-12">
        <a class="btn btn-success" href="?c=postComments&a=createComment&post_id=<?php echo $data->getId() ?>">Pridaj koment →</a>
    </div>
</div>


