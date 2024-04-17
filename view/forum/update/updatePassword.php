<?php
$user = $result["data"]['user'];
?>

<form action="index.php?ctrl=security&action=updatePassword&id=<?= $user->getId() ?>" method="POST" enctype="multipart/form-data">

    <label for="pass1">Nouveau Mot de passe</label>
    <input type="password" name="pass1" id="pass1" value="Gino67540//!" required><br>
    
    <label for="pass2">Confirmation du nouveau mot de passe</label>
    <input type="password" name="pass2" id="pass2" value="Gino67540//!" required><br>

    <input type="submit" name="submit" value="S'enregistrer">
</form>