<?php
$user = $result["data"]['user'];
// var_dump($user->getId());
?>

<h1>Modifier mon profil</h1>
<div class="form_display">
    <form action="index.php?ctrl=security&action=updateAccount&id=<?= $user->getId() ?>" method="POST">
        <label for="pseudo">Modifier mon pseudo</label>
        <input type="text" name="pseudo" value="<?= $user-> getPseudo() ?>" id="pseudo"><br>
        <label for="email">Modifier mon email</label>
        <input type="email" name="email" value="<?= $user-> getEmail() ?>" id="email"><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>