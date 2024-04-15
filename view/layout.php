<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <script src="https://kit.fontawesome.com/f3340c3342.js" crossorigin="anonymous"></script>
    <title>FORUM</title>
</head>

<body>
    <div class="content">
        <!--messages de succès ou d'erreur-->
        <h3><?= App\Session::getFlash("error") ?></h3>
        <h3><?= App\Session::getFlash("success") ?></h3>
        <div id="wrapper">
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <header class="header" id="header">
                    <span>
                        <p class="logo">ZINO</p>
                    </span>
                    <nav>
                        <ul class="nav_list">
                            <li>
                                <a class="nav_link" href="index.php?ctrl=forum&action=index">Accueil</a>
                            </li>
                            <li>
                                <a class="nav_link" href="index.php?ctrl=forum&action=listCategory">Catégories</a>
                            </li>
                            <li>
                                <?php if (App\Session::isAdmin()) { ?>
                                    <a class="nav_link" href="index.php?ctrl=home&action=users">Voir la liste des gens</a>
                                <?php } ?>
                            </li>
                            <li>
                                <?php
                                if (App\Session::getUser()) { ?>
                                    <a class="nav_link" href="index.php?ctrl=security&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?></a>
                            </li>
                            <li>
                                <a class="button" href="index.php?ctrl=security&action=logout">Déconnexion</a>
                            </li>
                        <?php
                                } else { ?>
                            <li>
                                <a class="button" href="index.php?ctrl=security&action=login">Connexion</a>
                            </li>
                            <li>
                                <a class="button_deco" href="index.php?ctrl=security&action=register">Inscription</a>
                            </li>
                        <?php } ?>
                        </ul>
                    </nav>
                </header>
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <footer>
                <div class="footer_effect">
                    <ul class="footer_list">
                        <li>
                            <a href="#" class="footer_link">Politique de Confidentialité</a>
                        </li>
                        <li>
                            <a href="#" class="footer_link">Mentions Légales</a>
                        </li>
                        <li>
                            <a href="#" class="footer_link">Contact</a>
                        </li>
                        <li>
                            <a href="#" class="footer_link">Aide</a>
                        </li>
                    </ul>
                    <ul>
                        <li class="footer_social_list">
                            <a class="footer_social" href="#"><i class="fa-brands fa-x-twitter"></i></a>
                            <a class="foote_social" href="#"><i class="fa-brands fa-facebook"></i></a>
                            <a class="footer_social" href="#"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <p id="copy">&copy; Gino <?= date_create("now")->format("Y") ?></p>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })
    </script>
    <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
</body>

</html>