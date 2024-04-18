<?php
$category = $result["data"]['category'];
?>

<h1>Modifier la catégorie</h1>

<div class="form_display">
    <form action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" method="POST">
        <label for="title"></label>
        <input type="text" name="name" value="<?= $category->getName() ?>" id="name" required><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>