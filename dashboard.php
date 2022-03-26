<?php

require_once 'components/db_connect.php';
require_once 'components/session.php';
// if session is not set this will redirect to login page
if (!$b_signedIn) {
    header("Location: home.php");
    exit;
}
//if session user exist go to update page
if ($b_user) {
    header("Location: update.php?id={$_SESSION['user']}");
    exit;
}

//searching for user data
$userName = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE users.status != '$status'";
$result = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='images/" . $row['picture'] . "' alt=" . $row['userName'] . "></td>
            <td>" . $row['userName'] . "</td>
            <td>" . $row['firstName'] . " " . $row['lastName'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . $row['phoneNumber'] . "</td>
            <td>" . $row['address'] . "</td>
            <td><a href='update.php?id=" . $row['userName'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='delete.php?id=" . $row['userName'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='7'><center>No Data Available </center></td></tr>";
}

//searching for our own data
$sql = "SELECT * FROM users WHERE userName = '$userName'";
$res = mysqli_query($connect, $sql);
if (mysqli_num_rows($res) == 1) {
    $admin = mysqli_fetch_assoc($res);
    $avatar = $admin['picture'];
} else {
    header("location: error.php");
}


mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-Dashboard</title>
    <?php require_once 'components/styles.php' ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img class="userImage" src="images/<?= $avatar ?>" alt="Adm avatar">
                <p class="">Administrator: (<?= $userName ?>)</p>
                <a class="btn btn-success" href="home.php">Home</a>
                <a class="btn btn-danger" href="logout.php?logout">Sign Out</a>
            </div>
            <div class="col-9 mt-2">
                <p class='h2'>Users</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>user</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>