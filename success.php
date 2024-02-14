<?php
session_start();
$username = $_SESSION['username'] ?? "Uživatel nepřihlášen";
$dropdownMessage = isset($_SESSION['userId']) ? "Odhlásit se" : "Přihlášení/Registrace";
if (!isset($_GET['origin']))
{
    header("Location: index.php");
    die();
}
$url = $_GET['origin']."?id=".$_GET['id'];
header("Refresh: 5; url=".$url);
?>

<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/icon.png">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
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
        <div class="textDiv success">
            <header>
                <h3>Úspěch!</h3>
            </header>
            <p>Váš požadavek byl úspěšně zpracován. Za okamžik budete přesměrováni. Jestli to nefunguje, klikněte <a href=<?php echo $url ?>>zde</a></p>
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

