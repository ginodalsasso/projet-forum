<?php
$user = $result["data"]['user'];
// var_dump($user);die;
?>

<h2>Votre profil:</h2>

<p>Pseudo: <?= $user->getPseudo() ?></p>
<p>Email: <?= $user->getEmail() ?></p>
<p>Rôle: <?= $user->getRole() ?></p>
<p>Date de création: <?= $user->getCreationDate() ?></p>
