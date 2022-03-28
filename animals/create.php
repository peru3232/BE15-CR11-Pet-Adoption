<?php

require_once '../components/session.php';

//if its not a admin redirect to home
if (!$b_admin) {
    header("Location: ../home.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../components/styles.php' ?>
    <title>CR 11 - Add an animal</title>
</head>

<body>
    <fieldset>
        <legend class='h2'>Add an animal</legend>
        <form action="actions/a_create.php" method="post" enctype="multipart/form-data">
            <table class='table'>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name="breed" placeholder="eg. pink elephant" /></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name" placeholder="whatever" /></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name="location" placeholder="under the table" /></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><input class='form-control' type="text" name="description" placeholder="some information about the animal" /></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><input class='form-control' type="text" name="size" placeholder="How tall is the pet (small to large) " /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name="age" step="any" /></td>
                </tr>
                <tr>
                    <th>Hobbies</th>
                    <td><input class='form-control' type="text" name="hobbies" placeholder="what does it like?" /></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class='form-control' type="file" name="picture" /></td>
                </tr>
                <tr>
                    <td><button class='btn btn-success' type="submit">Add this pet</button></td>
                    <td><a href="../home.php"><button class='btn btn-warning' type="button">Home</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>