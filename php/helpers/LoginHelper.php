<?php
/**
 * Class for adding new users and checking login
 *
 * This class allows storing of new users into the db, verifying logins and adding data to session
 */

include_once "php/DBHandler.php";

class LoginHelper
{
    static private DBHandler $handler;

    /**
     * Constructor - redirects user if logged in
     */
    function __construct()
    {
        if (isset($_SESSION['userId']))
        {
            header("Location: logout.php");
            die();
        }
        self::$handler = new DBHandler();
    }

    /**
     * Finds existing user in db
     * @param string $username
     * @param bool $fetchAll
     * @return array|null
     */
    function CheckExistingUser(string $username, bool $fetchAll) : mixed
    {
        return self::$handler -> GetEntryOnId("Users", $username, "Username", $fetchAll);
    }

    /**
     * Checks for existing user, adds new user if no match is found
     * @return bool
     */
    function RegisterNewUser() : bool
    {
        if (isset($_POST['register']) && self::CheckExistingUser($_POST['registerUser'], true) == null)
        {
            $firstName = trim($_POST['registerName']);
            $lastName = trim($_POST['registerSurname']);
            $username = trim($_POST['registerUser']);

            if (strlen(trim($firstName)) && strlen(trim($lastName)) && strlen(trim($username)) && strlen(trim($_POST['registerPass'])))
            {
                $password = password_hash($_POST['registerPass'], PASSWORD_DEFAULT); //required hashing
                $targetFile = "img/profiles/" . $username . ".gif";
                $arr = getimagesize($_FILES['registerImage']['tmp_name']);
                if (is_uploaded_file($_FILES["registerImage"]["tmp_name"]) && $arr && $arr[0] <= 400 && $arr[1] <= 400)
                {
                    move_uploaded_file($_FILES["registerImage"]["tmp_name"], $targetFile);
                    self::$handler->InsertIntoTable("Users(Username, FirstName, LastName, Password) VALUES(?, ?, ?, ?)", [$username, $firstName, $lastName, $password]);
                    header("Location: success.php?origin=login.php&id");
                    die();
                }

                return false;
            }
        }

        return true;
    }

    /**
     * Checks if username exists, then compares passwords
     * @return bool
     */
    function LoginUser() : bool
    {
        if (isset($_POST['login']))
        {
            $user = self::CheckExistingUser(trim($_POST['loginUser']), false);

            if ($user && password_verify($_POST['loginPass'], $user['Password']))
            {
                $_SESSION['userId'] = $user['Id'];
                $_SESSION['username'] = $user['Username'];
                header("Location: index.php");
                die();
            }
            return false;
        }

        return true;
    }

    /**
     * Destructor
     */
    function __destruct()
    {
        self::$handler -> Close();
    }
}
