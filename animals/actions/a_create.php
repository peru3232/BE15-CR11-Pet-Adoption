<?php
require_once '../../components/session.php';

//if its not a admin redirect to home
if (!$b_admin) {
    header("Location: ../../home.php");
    exit;
}

require_once '../../components/db_usage.php';
require_once '../../components/file_upload.php';

$error = false;
$breed = $name = $location = $description = $size = $hobbies = $picture = ''; $age = 0;
$breedError = $nameError = $locationError = $descriptionError = $sizeError = $hobbiesError = $ageError = $pictureError = '';

if ($_POST) {

    $breed = normalize($_POST['breed']);
    $name = normalize($_POST['name']);
    $location = normalize($_POST['location']);
    $description = normalize($_POST['description']);
    $size = normalize($_POST['size']);
    $hobbies = normalize($_POST['hobbies']);
    $age = normalize($_POST['age']);

    $uploadError = '';

    $picture = file_upload($_FILES['picture'], 'animal');

    $sql = "INSERT INTO animals (breed, name, location, description, size, hobbies, age, photo) VALUES ('$breed', '$name', '$location', '$description', '$size', '$hobbies', $age, '$picture->fileName')";

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'><tr>
            <td> $name </td>
            <td> $breed </td>
            </tr></table><hr>";
    } else {
        $class = "danger";
        $message = "Error while creating animal entry. Try again: <br>" . $connect->error;
    }
    $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    $message .= "<br> redirected in 3 seconds...";
    header("refresh:3;url=../create.php");

} else {
    header("location: ../error.php");
}
mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CR 11 - Create Animal Data</title>
    <?php require_once '../../components/styles.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../../home.php'><button class="btn btn-primary" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>