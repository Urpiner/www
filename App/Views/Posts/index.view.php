<?php


// $data je premenna ktora vznikne zavolanim $this->html($posts); v metode index() v triede PostsController
// bude v nej to co sa posiela parametrom, v tomto pripade to bude pole Postov

use App\Models\Post;
/** @var Post[] $data */
/** @var App\Core\IAuthenticator $auth */
?>

<!-- content stranky -->
<div class="container">
    <div class="row">


        <!-- v tomto dive su vsetky headliny clankov -->
        <div class="col-lg-12">

            <!-- v tomto dive je hlavny clanok -->
            <div class="d-flex justify-content-center">
                <div class="col-lg-10 clanok">
                    <img src="../../../public/images/merciak-headline.png" alt="..." />
                    <div class="clanok-telo">
                        <h2>Top 10 dôvodov prečo zarezali Merčiaka na živom prenose</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                        <a class="btn btn-primary" href="merciak.html">Čítať viac →</a>
                    </div>
                </div>
            </div>



            <!-- v tomto dive su vsetky ostatne clanky -->
            <div class="row d-flex justify-content-center">
                <?php foreach($data as $post) { ?>
                    <div class="col-lg-5">
                        <!-- headline clanku -->
                        <div class="clanok">
                            <img src="../../../public/images/<?php echo $post->getImg() ?>" alt="..." />
                            <div class="clanok-telo">
                                <h2><?php echo $post->getTitle() ?></h2>
                                <p><?php echo $post->getText() ?></p>
                                <a class="btn btn-primary" href="?c=posts&a=content&id=<?php echo $post->getId() ?>">Čítať viac →</a>
                                <?php if ($auth->isLogged()) { ?>
                                    <a href="?c=posts&a=delete&id=<?php echo $post->getId() ?>" class="btn btn-danger">Zmazat</a>
                                    <a href="?c=posts&a=edit&id=<?php echo $post->getId() ?>" class="btn btn-warning">Upravit</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>
    </div>

    <?php if ($auth->isLogged()) { ?>
        <div class="row py-3">
            <div class="col-lg-12">
                <a class="btn btn-success" href="?c=posts&a=create">Pridaj post →</a>
            </div>
        </div>
    <?php } ?>

</div>

<!-- pagination -->
<nav aria-label="Pagination">
    <hr class="my-0" />
    <ul class="pagination justify-content-center my-4">
        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
        <li class="page-item"><a class="page-link" href="#!">2</a></li>
        <li class="page-item"><a class="page-link" href="#!">3</a></li>
        <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
        <li class="page-item"><a class="page-link" href="#!">15</a></li>
        <li class="page-item"><a class="page-link" href="#!">Older</a></li>
    </ul>
</nav>