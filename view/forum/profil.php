<?php
$user = $result["data"]['user'];
// var_dump($user);die;
?>

<h1><?= $user->getPseudo() ?></h1>

<section class="card_container_container">
    <div class="card_list">
        <h2>Votre profil:</h2>
        <p>Pseudo: <?= $user->getPseudo() ?></p>
        <p>Email: <?= $user->getEmail() ?></p>
        <p>Rôle: <?= $user->getRole() ?></p>
        <p>Date de création: <?= $user->getCreationDate() ?></p>
    </div>
</section>
<div class="button_container_container">
<div class="button_container">
    <a class="button" href="index.php?ctrl=security&action=viewUpdateProfil&id=<?= $user->getId() ?>">Modifier</a>
    <a class="button_delete" href="index.php?ctrl=security&action=deleteAccount&id=<?= $user->getId() ?>">Suprimer mon compte</a>
</div>
</div>