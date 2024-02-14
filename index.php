<?php
    include_once "php/DBHandler.php";
    session_start();
    $handler = new DBHandler();
    $username = $_SESSION['username'] ?? "Uživatel nepřihlášen";
    $dropdownMessage = isset($_SESSION['userId']) ? "Odhlásit se" : "Přihlášení/Registrace";
    $randomFilm = $handler -> ExecuteNoParamSQL("SELECT * FROM Films ORDER BY RAND() LIMIT 1", false);
    $mostActiveUsersArray = $handler -> ExecuteNoParamSQL("SELECT Username, u.Id, COUNT(c.Id) AS CommentCount FROM Users u LEFT JOIN Comments c ON u.Id = c.UserId GROUP BY Username, u.Id ORDER BY CommentCount DESC LIMIT 10", true);
    $mostCommentedFilmsArray = $handler -> ExecuteNoParamSQL("SELECT Name, f.Id, COUNT(*) AS CommentCount FROM Films f JOIN Comments c ON f.Id=c.FilmId GROUP BY Name, f.Id ORDER BY CommentCount DESC LIMIT 10", true);
    $handler -> Close();
?>

<!DOCTYPE html>

<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icon.png">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" media="print" href="styles/print.css">
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
                <div class="textDiv">
                    <header>
                        <h3>Vítej na stránkách ČVUTFD!</h3>
                    </header>
                    <p>Vítej na stránkách ČVUTFD! Naplněná filmová databáze, do které můžeš i ty přispívat. Stačí se přihlásit nebo si vytvořit nový účet, a hurá na psaní recenzí! A pokud se nechceš zaregistrovat, i tak tě čeká mnoho filmů a recenzí, které si můžeš přečíst.</p>
                </div>
                <div class="textDiv">
                    <header>
                        <h3>Novinky ze světa filmů</h3>
                    </header>
                    <h4>Nový Jason Bourne odhalen?</h4>
                    <p>Jason Bourne s tváří Matta Damona se údajně má po sedmi letech vrátit na plátna kin a v současnosti je hlavním cílem studia získat zpět na palubu herce, jenž sérii odstartoval. Naposledy jsme Damona v jedné z jeho nejslavnějších rolí viděli po spinoffu s Jeremy Rennerem v rozporuplně přijatém Jasonu Bourneovi, kde se k látce vrátil i režisér Paul Greengrass.</p>
                    <h4>Oznámen nový film o Elonovi Muskovi</h4>
                    <p>Životní příběh Elona Muska, mimo jiné generálního ředitele společností Tesla a SpaceX, bude založen na autorizované biografii spisovatele Waltera Isaacsona, která ve Spojených státech vyšla letos 11. září a o jejíž filmová práva svedla hollywoodská studia údajně velký boj. Není to navíc poprvé, co Isaacsonovo dílo bude sloužit jako předloha pro vysoce profilovaný životopisný film.</p>
                </div>
                <div class="textDiv randomFilm">
                    <header>
                        <h3>Výběr redakce</h3>
                    </header>
                    <a href="film.php?id=<?php echo $randomFilm['Id'] ?>"><img src="<?php echo htmlspecialchars($randomFilm['PosterLink']) ?>" alt="Náhodný film"></a>
                    <p><?php echo htmlspecialchars($randomFilm['Name']) . " (". htmlspecialchars($randomFilm['Year']) . ")"?></p>
                </div>
                    <div class="textDiv top10">
                        <header>
                            <h3>Uživatelé - TOP 10</h3>
                        </header>
                        <table>
                            <tr>
                                <th>Uživatel</th>
                                <th>Počet komentářů</th>
                            </tr>
                            <?php
                                foreach ($mostActiveUsersArray as $item)
                                {
                                    $itemUser = $item['Username'];
                                    $itemCount = $item['CommentCount'];

                                    echo "<tr><td class='center'><a href='profile.php?id=".$item['Id']."'>".htmlspecialchars($itemUser)."</a></td><td class='center'>$itemCount</td></tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <div class="textDiv top10">
                        <header>
                            <h3>Nejkomentovanější filmy</h3>
                        </header>
                        <table>
                            <tr>
                                <th>Film</th>
                                <th>Počet komentářů</th>
                            </tr>
                            <?php
                                foreach ($mostCommentedFilmsArray as $item)
                                {
                                    $itemFilm = $item['Name'];
                                    $itemCount = $item['CommentCount'];

                                    echo "<tr><td class='center'><a href='film.php?id=".$item['Id']."'>".htmlspecialchars($itemFilm)."</a></td><td class='center'>$itemCount</td></tr>";
                                }
                            ?>
                        </table>
                    </div>
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

