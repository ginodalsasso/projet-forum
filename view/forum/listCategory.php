<?php
$categories = $result["data"]['categories'];
?>

<h1>Welcome to the <br> Afterwork <br>Community <br>Forum</h1>

<!----------------- Liste des catégories ----------------->
<section class="card_container_container">
    <div class="card_list">
        <h2>Catégories</h2>
        <?php
        foreach ($categories as $category) {
        ?>
            <div class="titles_container">
                <div class="titles_container_left">
                    <?php
                    //si l'utilisateur est connecté qui à écrit le post OU si l'admin est connecté alors
                    if (app\Session::isAdmin()) {
                    ?>
                        <a href="index.php?ctrl=forum&action=viewUpdateCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php } ?>
                    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                </div>
                <div class="titles_container_right">
                    <p><?= $category->getNbTopics() ?></p>
                    <p><?= $category->getLastPost() ?></p>
                </div>
            </div>
            <hr>

        <?php } ?>
    </div>
</section>

<?php
if (app\Session::isAdmin()) {
?>
    <!----------------- Ajouter une catégorie ----------------->
    <div class='card_list_ariane_container'>
        <button class="button toogle_button">Créer une catégorie</button>
    </div>
    <div class="toggle_display">
        <div class="form_display">
            <form class="form" action="index.php?ctrl=forum&action=addCategory" method="POST">
                <!-- <label for="title">Titre de la catégorie</label> -->
                <input type="text" name="name" id="title" placeholder="Titre de la catégorie" required><br>
                <input class="button" type="submit" name="submit" value="Envoyer">
            </form>
        </div>
    </div>
<?php } ?>