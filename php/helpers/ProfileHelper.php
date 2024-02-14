<?php
/**
 * Class for manipulating profile data
 *
 * This class allows reading/editing data of the logged user or reading of other users' data
 * @author Joshua David Crofts
 */

include_once "php/DBHandler.php";

class ProfileHelper
{
    static private DBHandler $handler;

    /**
     * Constructor
     */
    function __construct()
    {
        self::$handler = new DBHandler();
    }

    /**
     * Gets profile data based on user id, reverts user to login page if no id is set in get request
     * @return array|null
     */
    function GetProfileData() : ?array
    {
        if (isset($_GET['id']))
        {
            if (!($user = self::$handler->GetEntryOnId("Users", $_GET['id'], "Id", false)))
            {
                header("Location: error.php?origin=profile");
                die();
            }

            return $user;
        }
        else if (!isset($_SESSION['userId']))
        {
            header("Location: login.php"); //might be lousy code, but works
            die();
        }

        $user = self::$handler -> GetEntryOnId("Users", $_SESSION['userId'] ?? 1, "Id", false);
        $_GET['id'] = $user['Id'];
        return $user;
    }

    /**
     * Edits user data if form is submitted
     * @return bool
     */
    function EditUserData() : bool
    {
        if (isset($_POST['submitted']))
        {
            if (strlen(trim($_POST['description'])))
                self::$handler->UpdateEntry("Users", "Description", [$_POST['description'], $_SESSION['userId']], "Id");
            if (strlen(trim($_POST['pass'])) && strlen(trim($_POST['repeatPass'])))
                self::$handler->UpdateEntry("Users", "Password", [password_hash($_POST['pass'], PASSWORD_DEFAULT), $_SESSION['userId']], "Id");
            if (is_uploaded_file($_FILES["profilePhoto"]["tmp_name"]))
            {
                if (($img = getimagesize($_FILES["profilePhoto"]["tmp_name"])) && $img[0] <= 400 && $img[1] <= 400)
                {
                    $targetFile = "img/profiles/" . $_SESSION['username'] . ".gif";
                    move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $targetFile);
                }

                return false;
            }
            header("Location: success.php?origin=profile.php&id=".$_SESSION['userId']);
        }

        return true;
    }

    /**
     * Gets relative path to profile picture
     * @param string $username
     * @return string
     */
    function GetProfileImage(string $username) : string
    {
        return "img/profiles/".$username.".gif";
    }

    /**
     * Adds a new film to the database if user is admin
     * @return bool
     */
    function AdminAddNewFilm() : bool
    {
        if (isset($_POST['submitFilm']) && strlen(trim($_POST['filmName'])) && strlen(trim($_POST['filmPoster'])) && strlen(trim($_POST['filmDescription'])) && strlen(trim($_POST['filmYear'])))
        {
            if (!self::$handler -> GetEntryOnId("Films", $_POST['filmName'], "Name", true))
            {
                self::$handler -> InsertIntoTable("Films(Name, Description, Year, PosterLink) VALUES(?, ?, ?, ?)", [$_POST['filmName'], $_POST['filmDescription'], $_POST['filmYear'], $_POST['filmPoster']]);
                header("Location: success.php?origin=profile.php&id=".$_SESSION['userId']);
            }

            return false;

        }

        return true;
    }

    /**
     * Gets the 5 newest comments written by the user
     * @return array|null
     */
    function GetUserComments() : ?array
    {
        return self::$handler -> GetEntryOnId("Comments", $_GET['id'], "UserId", true, "JOIN Films ON Films.Id = Comments.FilmId", "ORDER BY CommentDate DESC LIMIT 5");
    }

    /**
     * Destructor
     */
    function __destruct()
    {
        self::$handler -> Close();
    }
}
