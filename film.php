<?php
    session_start();
    include_once "php/helpers/FilmHelper.php";
    $username = $_SESSION['username'] ?? "Uživatel nepřihlášen";
    $dropdownMessage = isset($_SESSION['userId']) ? "Odhlásit se" : "Přihlášení/Registrace";
    $helper = new FilmHelper();
    $helper -> CheckAndAddComment();
    $film = $helper -> GetFilmData();
    $comments = $helper -> GetCommentData();
?>

<!DOCTYPE html>

<html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/icon.png">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/login.css">
        <link rel="stylesheet" media="print" href="styles/print.css">
        <script src="scripts/LoggedIn.js"></script>
        <title>ČVUTFD</title>
    </head>
    <body>
        <header>
            <a href="index.php"><img src="./img/logo.png" alt="Hlavní stránka"></a>
            <div class="dropdown">
                <img class="headerPanelRight" src="./img/user.png" alt="Profil">
                <div class="dropdown-selection">
                    <a href="profile.php"><?php echo htmlspecialchars($username)?></a>
                    <a href="login.php"><?php echo $dropdownMessage ?></a>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="films.php">Filmy</a></li>
                    <li><a href="users.php">Uživatelé</a></li>
                    <li><a href="about.php">O nás</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="container">
                <div class="textDiv randomFilm">
                    <header>
                        <h3><?php echo htmlspecialchars($film['Name'])."<br>".htmlspecialchars($film['Year'])?></h3>
                    </header>
                    <img src="<?php echo htmlspecialchars($film['PosterLink'])?>" alt="Poster">
                    <p><?php echo htmlspecialchars($film['Description']) ?></p>
                </div>
                <div class="textDiv">
                    <header>
                        <h3>Nejnovější komentáře</h3>
                    </header>
                    <?php
                        if (count($comments) != 0)
                        {
                            foreach ($comments as $item)
                            {
                                $username = htmlspecialchars($item['Username']);
                                $id = $item['UserId'];
                                $content = htmlspecialchars($item['Content']);
                                $date = date_format(date_create($item['CommentDate']), "d.m.Y H:i:s");
                                echo "<h4><a href='profile.php?id=".$id."'>$username</a> ($date)</h4><p>$content</p>";
                            }
                        }
                        else
                            echo "<p class='center'>Nic tu není :(</p>";
                    ?>
                </div>
            <?php if (isset($_SESSION['userId'])) echo "
                <div class='textDiv' id='filmForm'>
                    <header>
                        <h3>Přidej komentář</h3>
                    </header>
                    <form method='post' action='film.php?id=".$_GET['id']."'>
                        <label>
                            <span>Obsah komentáře</span>
                            <textarea id='commentContentId' name='commentContent' placeholder='Napište zde váš komentář' required></textarea>
                        </label>
                        <p class='errorMessage' id='commentErrorId'></p>
                        <button type='submit' name='comment' id='commentButton' value='true'>Publikovat</button>
                    </form>
                   </div>" ?>
<script src='scripts/Comment.js'></script>
</div>
        </main>
        <footer>
            <nav>
                <ul>
                    <li><a href="about.php">O nás</a></li>
                    <li><a href="films.php">Filmy</a></li>
                    <li><a href="users.php">Uživatelé</a></li>
                    <li><a href="https://gitlab.fel.cvut.cz/croftjos/zwa-semestralka">Gitlab</a></li>
                </ul>
            </nav>
            <h5>Written by cakeman105 © 2023</h5>
        </footer>
    </body>
</html>

