<?php
require_once 'components/session.php';

// if session is not set this will redirect to login page
if (!$b_signedIn) {
    header("Location: home.php");
    exit;
}


$b_user ? $backBtn = "home.php" : $backBtn = "dashboard.php";

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

$error = true;

//fetch and populate form
if ($_GET['id']) {
    $error = false;
    $userName = $_GET['id'];
    $sql = "SELECT * FROM users WHERE userName = '$userName'";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phoneNumber = $data['phoneNumber'];
        $address = $data['address'];
        $picture = $data['picture'];
    }
}

//update
$class = 'd-none';
if (ISSET($_POST['submit'])) {
    $error = false;

    // sanitise user input to prevent sql injection
    // trim - strips whitespace (or other characters) from the beginning and end of a string
    $firstName = trim($_POST['firstName']);


    // strip_tags -- strips HTML and PHP tags from a string
    $firstName = strip_tags($firstName);

    // htmlspecialchars converts special characters to HTML entities
    $firstName = htmlspecialchars($firstName);

    $lastName = trim($_POST['lastName']);
    $lastName = strip_tags($lastName);
    $lastName = htmlspecialchars($lastName);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $userName = trim($_POST['userName']);
    $userName = strip_tags($userName);
    $userName = htmlspecialchars($userName);

    $phoneNumber = trim($_POST['phoneNumber']);
    $phoneNumber = strip_tags($phoneNumber);
    $phoneNumber = htmlspecialchars($phoneNumber);

    $address = trim($_POST['address']);
    $address = strip_tags($address);
    $address = htmlspecialchars($address);

    // basic name validation
    if (empty($firstName) || empty($lastName)) {
        $error = true;
        $firstNameError = "Please enter your full name and surname";
    } else if (strlen($firstName) < 3 || strlen($lastName) < 3) {
        $error = true;
        $firstNameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $firstName) || !preg_match("/^[a-zA-Z]+$/", $lastName)) {
        $error = true;
        $firstNameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    $uploadError = $pictureInsert = '';
    $pictureArray = file_upload($_FILES['picture']); //file_upload() called
    $picture = $pictureArray->fileName;

    if ($pictureArray->error === 0) {
        $_POST["picture"] == "avatar.png" || unlink("images/{$_POST["picture"]}");
        $pictureInsert = ", picture = '$picture'";
    }

    $sql = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', email = '$email', phoneNumber = '$phoneNumber', address = '$address'$pictureInsert WHERE userName = '$userName'";
    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
    }
    $message .= "<br> redirected in 3 seconds...";
    $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
    header("refresh:3;url=$backBtn");
//    exit;
}

// if no submit, we are wrong...
//if ($error) {
//    header("Location: home.php");
//    exit;
//}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php require_once 'components/styles.php' ?>
</head>

<body>
    <div class="container">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <h2>Update</h2>
        <img class='img-thumbnail rounded-circle' src='images/<?= $picture ?>' alt="<?= $userName ?>">
        <form method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>First Name</th>
                    <td><input class="form-control" type="text" name="firstName" placeholder="First Name" value="<?= $firstName ?>" /></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><input class="form-control" type="text" name="lastName" placeholder="Last Name" value="<?= $lastName ?>" /></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input class="form-control" type="email" name="email" placeholder="Email" value="<?= $email ?>" /></td>
                </tr>
                <tr>
                    <th>Phone number</th>
                    <td><input class="form-control" type="text" name="phoneNumber" placeholder="Last Name" value="<?= $phoneNumber ?>" /></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input class="form-control" type="text" name="address" placeholder="Last Name" value="<?= $address ?>" /></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class="form-control" type="file" name="picture" /></td>
                </tr>
                <tr>
                    <input type="hidden" name="userName" value="<?= $userName ?>" />
                    <input type="hidden" name="picture" value="<?= $picture ?>" />
                    <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="<?= $backBtn ?>"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>