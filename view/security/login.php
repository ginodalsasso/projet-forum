<h1>Se connecter</h1>
    <form action="index.php?ctrl=security&action=addLogin" method="POST" enctype="multipart/form-data">
        
        <label for="pseudo">Pseudo</label>
        <input type="pseudo" name="pseudo" id="pseudo" required><br>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required><br>
        
        <input type="submit" name="submit" value="Se connecter">
    </form>