<?php
$category = $result["data"]['category'];
$topics = $result["data"]['topics'];
?>
<h1><?= $category->getName() ?></h1>

<a href="index.php?ctrl=forum&action=listCategory">Catégories</a>

<!----------------- Liste des topics ----------------->
<section class="card_container_container">
    <div class="card_list">
        <h2>Liste des topics</h2>
        <?php
        //si un ou plusieurs topics de la catégorie éxiste alors
        if ($topics) {
            //affichage des topics
            foreach ($topics as $topic) { ?>
                <div class="titles_container">
                    <div class="titles_container_left">
                        <?php
                        // si le topic est closed alors propose de l'unlock
                        if ($topic->getClosed()) {
                            $statut = "<i class='fa-solid fa-unlock'></i>";
                            $action = "<a href='index.php?ctrl=forum&action=unlockedTopics&id=" . $topic->getId() . "' class='topic-update'><i class='fa-solid fa-lock'></i></a>";
                        } else {
                            $statut = "<i class='fa-solid fa-lock'></i>";
                            $action = "<a href='index.php?ctrl=forum&action=lockedTopics&id=" . $topic->getId() . "' class='topic-update'><i class='fa-solid fa-unlock'></i></a>";
                        } ?>
                        <!-- $action récupère la méthode à appliquer si le topic doit être lock ou unlock -->
                        <?= $action ?>
                        <a href="index.php?ctrl=forum&action=viewUpdateTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="index.php?ctrl=forum&action=listPostsByTopics&id=<?= $topic->getId() ?>"><?= $topic ?></a>
                        <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-trash"></i></a>
                        <br>par <?= ($topic->getUser()) ? $topic->getUser() : "Anonymous" ?> le <?= $topic->getCreationDate() ?>
                    </div>

                    <div class="titles_container_right">
                        <p><?= $topic->getNbPosts() ?></p>
                    </div>
                </div>
                <hr>
        <?php }
        } ?>
    </div>
</section>

<!----------------- Ajouter un topic ----------------->
<div class="form_display">
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="POST">
        <label for="title">Titre du topic</label>
        <input type="text" name="title" id="title" required><br>
        <textarea id="text" name="text" rows="5" cols="33"></textarea>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>