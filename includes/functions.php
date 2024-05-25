<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'Admin';
}

function isOperator() {
    return isLoggedIn() && $_SESSION['role'] === 'Operator';
}

function isManager() {
    return isLoggedIn() && $_SESSION['role'] === 'Manajer';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function redirectIfNotAuthorized() {
    if (!isAdmin() && !isOperator() && !isManager()) {
        header("Location: login.php");
        exit();
    }
}
?>
