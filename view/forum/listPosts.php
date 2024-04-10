<?php
    //récupère les posts
    $posts = $result["data"]['posts']; 
    //récupère le titre de la page
    $topic = $result["data"]['topic']; 
?>

<h1>Liste des posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post->getText() ?> par <?= $post->getUser() ?></p>
<?php } ?>


<?php 
//si le topic n'est pas verouillé alors:
// if ($topic->getClosed() === 1){ ?>
    <form action="index.php?ctrl=forum&action=addPost&id=<?=$topic->getId()?>" method="POST" >
        <label for="text"></label>
        <textarea id="text" name="text" rows="5" cols="33"></textarea>
        <input type="submit" name="submit" value="Envoyer">
<?php 
// } else{
//             echo "Ce topic est fermé, vous ne pouvez donc plus y participer.";
//     }
?>