<?php
    session_start();

    if (!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    session_destroy();
    header("Refresh: 5; url=index.php");
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
            <a href="login.php"><img class="headerPanelRight" src="./img/user.png" alt="Profil"></a>
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
                <div class="textDiv success">
                    <header>
                        <h3>Úspěšné odhlášení</h3>
                    </header>
                    <p>Úspěšně jsme vás odhlásili z ČVUTFD. Za okamžik budete přesměrováni. Jestli to nefunguje, klikněte <a href="index.php">zde</a>.</p>
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

