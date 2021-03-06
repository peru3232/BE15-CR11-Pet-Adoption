<?php
require_once '../../components/session.php';

if (!$b_signedIn) {
    header("Location: ../home.php");
    exit;
}

require_once '../../components/db_usage.php';
require_once '../../components/file_upload.php';


if ($_POST) {
    $id = $_POST['id'];

    $breed = normalize($_POST['breed']);
    $name = normalize($_POST['name']);
    $location = normalize($_POST['location']);
    $description = normalize($_POST['description']);
    $size = normalize($_POST['size']);
    $hobbies = normalize($_POST['hobbies']);
    $age = normalize($_POST['age']);

    $uploadError = $pictureInsert = '';
    $pictureArray = file_upload($_FILES['photo'], 'animal');
    $picture = $pictureArray->fileName;
    $oldPhoto = $_POST["photo"];

    if ($pictureArray->error === 0) {
        $oldPhoto == "leer.png" || unlink("../../images/$oldPhoto");
        $pictureInsert = ", photo = '$picture'";
    }
    $sql = "UPDATE animals SET breed = '$breed', name = '$name', location = '$location', description = '$description', size = '$size', age = $age, hobbies = '$hobbies'$pictureInsert WHERE id = $id";
//    echo $sql;
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The animal data was successfully updated";
    } else {
        $class = "danger";
        $message = "Error while updating animals data : <br>" . mysqli_connect_error();
    }
    $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
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
    <title>CR 11 - Update Animal Data</title>
    <?php require_once '../../components/styles.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../update.php?id=<?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../../home.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>