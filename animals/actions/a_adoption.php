<?php
require_once '../../components/session.php';

if (!$b_user) {
    header("Location: ../home.php");
    exit;
}

require_once '../../components/db_usage.php';

if ($_POST) {
    $id = $_POST['id'];
    $userName = $_SESSION['user'];
    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO adoption (fk_userName, fk_pet_id, date) values ('$userName', $id, '$currentDateTime') ";
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "Successfully adopted!";
    } else {
        $class = "danger";
        $message = "The adoption wasn't successfully: <br>" . $connect->error;
    }
    $message .= "<br> redirected in 3 seconds...";
    header("refresh:3;url=../../home.php");
} else {
    header("location: ../error.php");
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CR 11 - Make the adoption</title>
    <?php require_once '../../components/styles.php' ?>
</head>

<body>
<div class="container">
    <div class="mt-3 mb-3">
        <h1>Adoption request response</h1>
    </div>
    <div class="alert alert-<?= $class; ?>" role="alert">
        <p><?= $message; ?></p>
        <a href='../../home.php'><button class="btn btn-success" type='button'>Home</button></a>
    </div>
</div>
</body>
</html>