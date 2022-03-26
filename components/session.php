<?php
session_start();

$b_user = $b_admin = $b_signedIn = false;
if (@($_SESSION['user']) != "") {$b_user =true;}
//@$_SESSION['user']||$b_user =true;
if (@($_SESSION['adm']) != "") {$b_admin =true;}
$b_signedIn = $b_user || $b_admin;
