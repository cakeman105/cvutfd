<?php

/**
 * Class for manipulating film and comment data
 *
 * This class allows the viewing of film data and adding/viewing comments
 * @author Joshua David Crofts
 */

include_once "php/DBHandler.php";

class FilmHelper
{
    static private DBHandler $handler;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$handler = new DBHandler();
        date_default_timezone_set("Europe/Prague");
    }

    /**
     * Adds a new comment if form is submitted
     * @return void
     */
    function CheckAndAddComment() : void
    {
        if (isset($_POST['comment']) && strlen(trim($_POST['commentContent'])) && isset($_SESSION['userId']))
        {
            self::$handler->InsertIntoTable("Comments(FilmId, UserId, Content, CommentDate) VALUES(?, ?, ?, ?)",
                [$_GET['id'] ?? 1,
                    $_SESSION['userId'],
                    $_POST['commentContent'],
                    date("Y-m-d H:i:s ")]);

            header("Location: success.php?origin=film.php&id=".$_GET['id']);
        }
    }

    /**
     * Gets film data from db, sends user to error.php if entry doesn't exist
     * @return array|null $film
     */
    function GetFilmData() : ?array
    {
        $film = self::$handler -> GetEntryOnId("Films", $_GET['id'] ?? 1, "Id", false);
        if (!$film)
        {
            header("Location: error.php?origin=film");
            die;
        }

        return $film;
    }

    /**
     * Gets comment data from db
     * @return array|null
     */
    function GetCommentData() : ?array
    {
        return self::$handler -> GetEntryOnId("Comments", $_GET['id'] ?? 1, "FilmId", true, "JOIN Users ON Comments.UserId=Users.Id", "ORDER BY CommentDate DESC LIMIT 10");
    }

    /**
     * Destructor
     */
    function __destruct()
    {
        self::$handler -> Close();
    }
}