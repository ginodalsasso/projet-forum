<?php
// $category = $result["data"]['category'];
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
// var_dump($topic); die;
?>
<form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="POST">
    <label for="title"></label>
    <input type="text" name="title" placeholder="<?= $topic-> getTitle() ?>" id="title" required><br>
    <textarea id="text" name="text" rows="5" cols="33"></textarea>
    <input type="submit" name="submit" value="Envoyer">
</form>