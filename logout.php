<?php
require_once 'components/session.php';

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['adm']);
    session_unset();
    session_destroy();
}
header("Location: home.php");
exit;
