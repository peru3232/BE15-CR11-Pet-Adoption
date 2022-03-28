<?php
require_once '../../components/session.php';

if (!$b_admin) {
    header("Location: ../home.php");
    exit;
}

require_once '../../components/db_usage.php';

if ($_POST) {
    $id = $_POST['id'];
    $picture = $_POST['picture'];
    $picture == "leer.png" || unlink("../../images/$picture"); //deletes picture from the pic folder

    $sql = "DELETE FROM animals WHERE id = $id";
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "Successfully Deleted!";
    } else {
        $class = "danger";
        $message = "The entry was not deleted due to: <br>" . $connect->error;
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
    <title>CR 11 - Delete Animal Data</title>
    <?php require_once '../../components/styles.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Delete request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?= $message; ?></p>
            <a href='../../home.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>