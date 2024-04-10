<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics'];
?>

<h1>Liste des topics</h1>

<?php
//si un ou plusieurs topics de la catégorie éxiste alors
if($topics){
    //affichage des topics
    foreach($topics as $topic ){ 
        // closed = 0  sinon afficher qu'il est verouillé action pour le lien plus bas pour vérouiller
        if($topic->getClosed() == 1){
            $statut= "<i class='fa-solid fa-unlock'></i>"; 
            $action="<a href='index.php?ctrl=forum&action=lockedTopics&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-lock'></i> Lock</a>";
        } else {
            $statut = "<i class='fa-solid fa-lock'></i>";
            $action="<a href='index.php?ctrl=forum&action=unlockedTopics&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-unlock'></i>  Unlock</a>";
        }

        ?> 

       <p><a href="index.php?ctrl=forum&action=listPostsByTopics&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?><?=$action?></p>
    <?php }
}
