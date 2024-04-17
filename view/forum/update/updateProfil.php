<?php
$user = $result["data"]['user'];
// var_dump($user->getId());
?>
<div class="form_display">
    <form action="index.php?ctrl=security&action=updateAccount&id=<?= $user->getId() ?>" method="POST">
        <label for="pseudo"></label>
        <input type="text" name="pseudo" placeholder="<?= $user-> getPseudo() ?>" id="pseudo"><br>
        <label for="email"></label>
        <input type="email" name="email" placeholder="<?= $user-> getEmail() ?>" id="email"><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>