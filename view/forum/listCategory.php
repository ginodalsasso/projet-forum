<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Welcome to the <br> Afterwork <br>Community <br>Forum</h1>

<!----------------- Liste des catégories ----------------->
<section class="card_container_container">
    <div class="card_list">
       <h2>Catégories</h2> 
        <?php
        foreach($categories as $category ){ ?>
            <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?><?= $category->getLastPost() ?></a>
                <a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-trash"></i><hr></a>
            </p>
        <?php } ?>
    </div>
</section>

<!----------------- Ajouter une catégorie ----------------->
<form action="index.php?ctrl=forum&action=addCategory" method="POST" >
    <label for="title">Titre de la catégorie</label>
    <input type="text" name="name" id="title" required><br>
        <input type="submit" name="submit" value="Envoyer">
</form>