<?php
$topic = $result["data"]['topic'];
// var_dump($topic); die;
?>

<div class="form_display">
    <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="POST">
        <label for="title"></label>
        <input type="text" name="title" value="<?= $topic-> getTitle() ?>" id="title" required><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>