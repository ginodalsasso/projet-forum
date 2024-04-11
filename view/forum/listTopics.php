<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics'];
?>
<h1><?= $category->getName() ?></h1>
<h2>Liste des topics</h2>

<a href="index.php?ctrl=forum&action=listCategory">Catégories</a>
<?php
//si un ou plusieurs topics de la catégorie éxiste alors
if($topics){
    //affichage des topics
    foreach($topics as $topic ){ 
        // closed = 0  sinon afficher qu'il est verouillé action pour le lien plus bas pour vérouiller
        if($topic->getClosed()){
            $statut= "<i class='fa-solid fa-unlock'></i>"; 
            $action="<a href='index.php?ctrl=forum&action=unlockedTopics&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-unlock'></i></a>";
        } else {
            $statut = "<i class='fa-solid fa-lock'></i>";
            $action="<a href='index.php?ctrl=forum&action=lockedTopics&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-lock'></i></a>";
        }

        ?> 

       <p><?=$action?><a href="index.php?ctrl=forum&action=listPostsByTopics&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?></p>
    <?php }
} ?>

<form action="index.php?ctrl=forum&action=addTopic&id=<?=$category->getId()?>" method="POST" >
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" required><br>
        <textarea id="text" name="text" rows="5" cols="33"></textarea>
        <input type="submit" name="submit" value="Envoyer">
</form>