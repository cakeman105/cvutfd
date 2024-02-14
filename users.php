<?php
    session_start();
    include_once "php/DBHandler.php";
    $username = $_SESSION['username'] ?? "Uživatel nepřihlášen";
    $dropdownMessage = isset($_SESSION['userId']) ? "Odhlásit se" : "Přihlášení/Registrace";
    $handler = new DBHandler();
    $totalCount = $handler -> GetDbCount("Users");
    $pageCount = ceil($totalCount / 30);
    $arr = $handler -> GetEntriesWithLimit("Users", $_GET['offset'] ?? 0, "Username", 30);
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
                <table class="filmTable">
                    <tr><th>Username</th><th>Jméno</th><th>Příjmení</th></tr>
                    <?php
                    foreach ($arr as $item)
                    {
                        $username = htmlspecialchars($item['Username']);
                        $firstname = htmlspecialchars($item['FirstName']);
                        $lastname = htmlspecialchars($item['LastName']);
                        $id = $item['Id'];
                        echo "<tr><td class='number'><a href='profile.php?id=$id'>".$username."</a></td><td>".$firstname."</td><td>".$lastname."</td></tr>";
                    }
                    ?>
                </table>
                <div class="pageFlex">
                    <a href="users.php?offset=0">Začátek</a>
                    <?php
                    for ($i = 1; $i < $pageCount + 1; $i++)
                    {
                        echo "<a href='users.php?offset=". 30 * ($i - 1) ."'>$i</a>";
                    }
                    ?>
                    <a href="users.php?offset=<?php echo 30 * ($pageCount - 1)?>">Konec</a>
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
