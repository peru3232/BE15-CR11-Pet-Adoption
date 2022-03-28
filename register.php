<?php
require_once 'components/db_usage.php';
require_once 'components/session.php';

if ($b_signedIn) {
    header("Location: home.php"); // redirects to home.php
    exit;
}

require_once 'components/file_upload.php';

$error = false;
$firstName = $lastName = $email = $userName = $pass = $picture = $address = $phoneNumber = '';
$firstNameError = $lastNameError = $emailError = $userNameError = $passwordError = $pictureError = $addressError = $phoneNumberError = '';
if (isset($_POST['btn-signup'])) {

    $firstName = normalize($_POST['firstName']);
    $lastName = normalize($_POST['lastName']);
    $email = normalize($_POST['email']);
    $userName = normalize($_POST['userName']);
    $phoneNumber = normalize($_POST['phoneNumber']);
    $address = normalize($_POST['address']);
    $pass = normalize($_POST['password']);

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);

    //check if user is unique
    if (!preg_match("/^[a-zA-Z0-9]+$/", $userName)) {
        $error = true;
        $userNameError = "username can contain only letters and numbers";
    } else {
        // checks whether the user exists or not
        $query = "SELECT userName FROM users WHERE userName='$userName'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $userNameError = "Provided username is already in use.";
        }
    }

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
    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users(userName, firstName, lastName, email, phoneNumber, address, picture, password, status)
                  VALUES('$userName', '$firstName', '$lastName', '$email', '$phoneNumber', '$address','$picture->fileName', '$password', 'user')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        $errMSG .= "<br> Redirected in 3 seconds...";
        header("refresh:3;url=home.php");

    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CR 11 - User Registration</title>
    <?php require_once 'components/styles.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Sign Up.</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="text" name="userName" class="form-control" placeholder="Select a username" maxlength="50" value="<?php echo $userName ?>" />
            <span class="text-danger"> <?php echo $userNameError; ?> </span>

            <input type="text" name="firstName" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $firstName ?>" />
            <span class="text-danger"> <?php echo $firstNameError; ?> </span>

            <input type="text" name="lastName" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $lastName ?>" />
            <span class="text-danger"> <?php echo $lastNameError; ?> </span>

            <input type="text" name="address" class="form-control" placeholder="Address" maxlength="50" value="<?php echo $address ?>" />
            <span class="text-danger"> <?php echo $addressError; ?> </span>

            <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" maxlength="50" value="<?php echo $phoneNumber ?>" />
            <span class="text-danger"> <?php echo $phoneNumberError; ?> </span>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>

            <div class="d-flex">
                <input type="password" name="password" class="form-control w-50" placeholder="Enter Password" maxlength="15" />
                <span class="text-danger"> <?php echo $passwordError; ?> </span>

                <input class='form-control w-50' type="file" name="picture">
                <span class="text-danger"> <?php echo $pictureError; ?> </span>
            </div>

            <hr />
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            <hr />
            <a href="index.php">Sign in Here...</a>
        </form>
    </div>
</body>
</html>