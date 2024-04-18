<?php
$users = $result["data"]['user'];
?>

<h1>Liste des membres du forum</h1>

<section class="card_container_container">
    <div class="card_list">
        <?php
        foreach ($users as $user) {
        ?>
            <div class="card_list_profil card_list_users">
                <p><?= $user->getPseudo() ?></p>
                <p><?= $user->getEmail() ?></p>
                <p><?= $user->getRole() ?></p>
                <p><?= $user->getCreationDate() ?></p>
                <p><?= $user->getBanned() ?></p>
            </div>
            <hr>
        <?php
        } ?>
    </div>
</section>