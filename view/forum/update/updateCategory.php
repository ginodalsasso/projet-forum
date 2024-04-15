<?php
$category = $result["data"]['category'];
?>
<form action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" method="POST">
    <label for="title"></label>
    <input type="text" name="name" placeholder="<?= $category-> getName() ?>" id="name" required><br>
    <input type="submit" name="submit" value="Envoyer">
</form>