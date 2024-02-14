<?php

/**
 * This is the source code for the ajax function
 * @author Joshua David Crofts
 */

include_once "../DBHandler.php";
session_start();

$handler = new DBHandler();

$user = $handler -> GetEntryOnId("Users", $_POST['username'], "Username", true);

if ($user)
{
    echo "Uživatelské jméno už existuje v databázi!";
}
