<?php
    //récupère la catégorie du topic  
    $category = $result["data"]['category']; 
    //récupère le titre du topic 
    $topic = $result["data"]['topic']; 
    //récupère les posts
    $posts = $result["data"]['posts']; 
?>

<h1><?= $topic->getTitle() ?></h1>
<h2>Liste des posts</h2>
<a href="index.php?ctrl=forum&action=listCategory">Catégories</a>
    ><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$category->getId()?>"><?=$category->getName()?></a>

<?php
foreach($posts as $post ){ ?>
    <p><?=$post->getText() ?> par <?= $post->getUser()?> <?= $post->getCreationDate() ?></p>
<?php } ?>


<?php 
// si le topic est verrouillé alors
if($topic->getClosed()) { ?>
    <p>Le topic est verrouillé</p>
<?php } else { ?>
        <form action="index.php?ctrl=forum&action=addPost&id=<?=$topic->getId()?>" method="POST" >
            <label for="text"></label>
            <textarea id="text" name="text" rows="5" cols="33"></textarea>
            <input type="submit" name="submit" value="Envoyer">
        </form>

<?php }
