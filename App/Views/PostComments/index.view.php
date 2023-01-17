<?php /** @var \App\Models\Post $data */ ?>
<?php /** @var App\Core\IAuthenticator $auth */ ?>

<header class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">Diskusia k článku: <?php echo $data->getTitle() ?></h1>
        </div>
    </div>
</header>




<div class="container bootstrap snippets">
    <div class="row">
        <div class="col-md-12">
            <div class="blog-comment">
                <ul class="comments">


                    <?php $postComments = $data->getPostComments()?>
                    <?php /** @var \App\Models\Post_comment $postComment */ ?>
                    <?php foreach ($postComments as $postComment) { ?>
                        <?php if (!$postComment->getPostCommentsId()) { //lebo vtedy je koment.. ak ma toto nastavene, tak je to reply ?>

                            <li class="comment">

                                <div class="post-comment">
                                    <p class="meta"> <a class="comment-username" href="#"><?php echo $postComment->getUsername() ?></a> <?php echo $postComment->getDate() ?> </p>
                                    <p>
                                        <?php echo $postComment->getText() ?>
                                    </p>
                                </div>


                                <ul id="<?php echo $postComment->getId() ?>" class="replies">

                                </ul>
                                <ul>
                                    <!--    button spusta zobrazenie replies (javascriptom)-->
                                    <button class="mb-5 btn btn-primary" id="btn-replies" value="<?php echo $postComment->getId() ?>">Zobraz odpovede</button>
                                </ul>

                            </li>




                            <!--    tu su replies (javascriptom)-->
                            <div id="<?php echo $postComment->getId() ?>">
                            </div>


                            <?php if ($auth->isLogged()) { ?>
                                <div class="row py-3">
                                    <div class="col-lg-12">
                                        <a class="btn btn-danger" href="?c=postComments&a=deleteComment&id=<?php echo $postComment->getId() ?>">Zmaz koment →</a>
                                    </div>
                                </div>
                            <?php } ?>


                        <?php } ?>
                    <?php } ?>


                </ul>
            </div>
        </div>
    </div>
</div>








<div class="row py-3">
    <div class="col-lg-12">
        <a class="btn btn-success" href="?c=postComments&a=createComment&post_id=<?php echo $data->getId() ?>">Pridaj koment →</a>
    </div>
</div>


