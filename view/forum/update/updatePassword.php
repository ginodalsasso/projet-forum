<?php
$user = $result["data"]['user'];
?>

<h1>Modifier mon mot de passe</h1>

<div class="form_display">
    <form action="index.php?ctrl=security&action=updatePassword&id=<?= $user->getId() ?>" method="POST" enctype="multipart/form-data">

        <label for="pass1">Nouveau Mot de passe</label>
        <input type="password" name="pass1" id="pass1" required><br>
        
        <label for="pass2">Confirmation du nouveau mot de passe</label>
        <input type="password" name="pass2" id="pass2" required><br>

        <input type="submit" name="submit" value="S'enregistrer">
    </form>
</div>