<?php
require_once 'components/db_connect.php';
require_once 'components/session.php';

if (!$b_admin) {
    header("Location: home.php");
    exit;
}

//initial bootstrap class for the confirmation message
$class = 'd-none';
//the GET method will show the info from the user to be deleted
if ($_GET['id']) {
    $userName = $_GET['id'];
    $sql = "SELECT * FROM users WHERE userName = '$userName'";
    $result = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $picture = $data['picture'];
    }
}
//the POST method will delete the user permanently
if ($_POST) {
    $userName = $_POST['id'];
    $picture = $_POST['picture'];
    $picture == "avatar.png" || unlink("images/$picture");

    $sql = "DELETE FROM users WHERE userName = '$userName'";
    if ($connect->query($sql) === TRUE) {
        $class = "alert alert-success";
        $message = "Successfully Deleted!";
    } else {
        $class = "alert alert-danger";
        $message = "The entry was not deleted due to: <br>" . $connect->error;
    }
    $message .= "<br>redirected in 3 seconds...";
    header("refresh:3;url=dashboard.php");
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CR 11 Delete User</title>
    <?php require_once 'components/styles.php' ?>
</head>

<body>
    <div class="<?php echo $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
    </div>
    <fieldset>
        <legend class='h2 mb-3'>Delete request <img class='img-thumbnail rounded-circle' src='images/<?php echo $picture ?>' alt="<?= $userName ?>"></legend>
        <h5>You have selected the data below:</h5>
        <table class="table w-75 mt-3">
            <tr>
                <td><?= $userName ?></td>
                <td><?= $firstName.' '.$lastName ?></td>
                <td><?= $email ?></td>
            </tr>
        </table>
        <h3 class="mb-4">Do you really want to delete this user?</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $userName ?>" />
            <input type="hidden" name="picture" value="<?php echo $picture ?>" />
            <button class="btn btn-danger" type="submit">Yes, delete it!</button>
            <a href="dashboard.php"><button class="btn btn-warning" type="button">No, go back!</button></a>
        </form>
    </fieldset>
</body>
</html>