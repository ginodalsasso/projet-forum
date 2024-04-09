<h1>S'inscrire</h1>
    <form action="index.php?ctrl=security&action=register" method="POST" enctype="multipart/form-data">
        <label for="pseudo">Pseudo</label>
        <!-- c'est bien les name que nous seront "filtrés" -->
        <input type="text" name="pseudo" id="pseudo"><br>
        
        <label for="email">Mail</label>
        <input type="email" name="email" id="email"><br>
        
        <label for="pass1">Mot de passe</label>
        <input type="password" name="pass1" id="pass1"><br>
        
        <label for="pass2">Confirmation du mot de passe</label>
        <input type="password" name="pass2" id="pass2"><br>

        <input type="submit" name="submit" value="S'enregistrer">
    </form>