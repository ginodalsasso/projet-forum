<?php
//récupère la catégorie du topic  
$category = $result["data"]['category'];
//récupère le titre du topic 
$topic = $result["data"]['topic'];
//récupère les posts
$posts = $result["data"]['posts'];
?>

<h1><?= $topic->getTitle() ?></h1>

<a href="index.php?ctrl=forum&action=listCategory">Catégories</a>
><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>

<!----------------- Liste des posts ----------------->

<?php
foreach ($posts as $post) { ?>
    <section class="card_container_container">
        <div class="card_list">
            <h2 class="user_post"><?= ($post->getUser()) ? $post->getUser() : "Anonymous" ?><br><?= $post->getCreationDate() ?></h2>
            <div class="titles_container">
                <div class="titles_container_left">
                    <?php
                    //si l'utilisateur est connecté qui à écrit le post OU si l'admin est connecté alors
                    if (($post->getUser()->getId() === app\Session::getUser()->getId()) || app\Session::isAdmin()) {
                    ?>
                        <a href="index.php?ctrl=forum&action=viewUpdatePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php } ?>
                    <?= $post->getText() ?>
                </div>
                <div class="titles_container_right">
                    <?php
                    //si l'utilisateur est connecté qui à écrit le post OU si l'admin est connecté alors
                    if (($post->getUser()->getId() === app\Session::getUser()->getId()) || app\Session::isAdmin()) {
                    ?>
                        <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-trash"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!----------------- Ajouter un post ----------------->
<?php
// si le topic est verrouillé alors
if ($topic->getClosed()) { ?>
    <p>Le topic est verrouillé</p>
<?php } else { ?>
    <div class="form_display">
        <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST">
            <label for="text"></label>
            <textarea id="text" name="text" placeholder="Mon message" rows="5" cols="33"></textarea>
            <input type="submit" name="submit" value="Envoyer">
        </form>
    </div>

<?php }
