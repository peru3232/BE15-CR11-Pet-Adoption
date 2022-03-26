<?php
require_once '../components/session.php';

if (!$b_signedIn) {
    header("Location: ../home.php");
    exit;
}

require_once '../components/db_connect.php';

if (@$_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $breed = $data['breed'];
        $name = $data['name'];
        $location = $data['location'];
        $description = $data['description'];
        $size = $data['size'];
        $age = $data['age'];
        $hobbies = $data['hobbies'];
        $picture = $data['photo'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Product</title>
    <?php require_once '../components/styles.php' ?>
</head>

<body>
    <fieldset>
        <legend class='h2'>Update request <img class='img-thumbnail rounded-circle' src='../images/<?= $picture ?>' alt="<?= $name ?>"></legend>
        <form action="actions/a_update.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name="breed" value="<?= $breed ?>" /></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name" value="<?= $name ?>" /></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name="location" value="<?= $location ?>" /></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><input class='form-control' type="text" name="description" value="<?= $description ?>" /></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><input class='form-control' type="text" name="size" value="<?= $size ?>" /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name="age" step="any" value="<?= $age ?>" /></td>
                </tr>
                <tr>
                    <th>Hobbies</th>
                    <td><input class='form-control' type="text" name="hobbies" value="<?= $hobbies ?>" /></td>
                </tr>

                <tr>
                    <th>Picture</th>
                    <td><input class="form-control" type="file" name="photo" /></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?= $id ?>" />
                    <input type="hidden" name="photo" value="<?= $picture ?>" />
                    <td><button class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="../home.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>

</body>
</html>