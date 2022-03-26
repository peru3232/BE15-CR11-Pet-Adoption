<?php
require_once '../../components/session.php';

//if its not a admin redirect to home
if (!$b_admin) {
    header("Location: ../../home.php");
    exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

$error = false;
$breed = $name = $location = $description = $size = $hobbies = $picture = ''; $age = 0;
$breedError = $nameError = $locationError = $descriptionError = $sizeError = $hobbiesError = $ageError = $pictureError = '';

if ($_POST) {
    $breed = trim($_POST['breed']);
    $breed = strip_tags($breed);
    $breed = htmlspecialchars($breed);

    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $location = trim($_POST['location']);
    $location = strip_tags($location);
    $location = htmlspecialchars($location);

    $description = trim($_POST['description']);
    $description = strip_tags($description);
    $description = htmlspecialchars($description);

    $size = trim($_POST['size']);
    $size = strip_tags($size);
    $size = htmlspecialchars($size);

    $hobbies = trim($_POST['hobbies']);
    $hobbies = strip_tags($hobbies);
    $hobbies = htmlspecialchars($hobbies);

    $age = trim($_POST['age']);
    $age = strip_tags($age);
    $age = htmlspecialchars($age);

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
    <title>Update</title>
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