<?php 
    //récupère les posts
    $post = $result["data"]['post']; 
?>
<h1>Modifier le message</h1>

<div class="form_display">
    <form action="index.php?ctrl=forum&action=updatePost&id=<?=$post->getId()?>" method="POST" >
        <label for="text"></label>
        <textarea id="text" name="text" rows="5" cols="33"><?=$post->getText()?></textarea>
        <input type="submit" name="submit" value="Modifier">
    </form>
</div>