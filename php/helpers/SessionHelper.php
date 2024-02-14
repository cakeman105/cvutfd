<?php

/**
 * Returns userid for ajax
 */
session_start();
if (isset($_SESSION['userId']))
    echo $_SESSION['userId'];
else
    echo "false";
