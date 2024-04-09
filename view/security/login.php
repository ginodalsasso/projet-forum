<h1>Se connecter</h1>
    <form action="index.php?ctrl=security&action=login" method="POST" enctype="multipart/form-data">
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>
        
        <input type="submit" name="submit" value="Se connceter">
    </form>