<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to the login page or any other desired location.
    header("Location: login.html");
    exit;
}
?>
