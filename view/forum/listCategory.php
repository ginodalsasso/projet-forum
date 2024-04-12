<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $category ){ ?>
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
<?php } ?>


<form action="index.php?ctrl=forum&action=addCategory" method="POST" >
    <label for="title">Titre de la catégorie</label>
    <input type="text" name="name" id="title" required><br>
        <input type="submit" name="submit" value="Envoyer">
</form>