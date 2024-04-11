
<?php
//récupère la catégorie ou le topic sera créé
$category = $result["data"]['category']; 
?>

<form action="index.php?ctrl=forum&action=addTopic&id=<?=$category->getId()?>" method="POST" >
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" required><br>
            <textarea id="text" name="text" rows="5" cols="33"></textarea>
            <input type="submit" name="submit" value="Envoyer">
        </form>