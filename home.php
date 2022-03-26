<?php
require_once 'components/db_connect.php';
require_once 'components/session.php';

if (!$b_signedIn) {
    //Button triggers modal
    $logBtn = '<a class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#userLogin">Login / Register</a>';
} else {
    $logBtn = '<a class="btn btn-danger" href="logout.php?logout">Sign Out</a>';
}

$error = false;
$userName = $password = $userNameError = $passError = $errMSG = '';

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $userName = trim($_POST['userName']);
    $userName = strip_tags($userName);
    $userName = htmlspecialchars($userName);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($userName)) {
        $userName = true;
        $userNameError = "Please enter your username.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing

        $sql = "SELECT * FROM users WHERE userName = '$userName'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1 && $row['password'] == $password) {
            if ($row['status'] == 'adm') {
                $_SESSION['adm'] = $row['userName'];
            } else {
                $_SESSION['user'] = $row['userName'];
            }
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }
}



$row = $content = '';
$empty = '';

$header = 'Our possible new friends ';
$sql = 'SELECT * FROM animals';
if ($b_admin) {
    $selectBtn='Add animals';
    $selectLink="animals/create.php";
} else {
    $selectBtn='Show only "Oldies"';
    $selectLink="home.php?oldies=true";
}
if (@$_GET['oldies'] == true) {
    $header .= "<span class='text-primary'>(only oldies)</span>";
    $sql .= " WHERE age > 7";
    $selectBtn = 'Show ALL';
    $selectLink="home.php";
}



$result = mysqli_query($connect ,$sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $b_admin?$extraButtons="<a href='animals/update.php?id={$row['id']}'><button class='text-center mx-1 p-2 text-light rounded-pill bg-secondary'>Edit</button></a>
            <a href='animals/delete.php?id={$row['id']}'><button class='text-center mx-1 p-2 text-light rounded-pill bg-danger'>Delete</button></a> 
        ":$extraButtons="";
        $content .= "
        <div class='card col-lg-3 col-md-5 col-sm-10 col-11 p-0 mx-4 mb-auto mt-3 border-2 card-shadow animate__animated animate__fadeIn'>
            <img src='images/{$row['photo']}' class='card-img-top d-none d-sm-block img-task' alt='{$row['name']}'>
            <h4 class='card-title text-center py-2 bg-black text-light'>{$row['name']}</h4>
            <div class='card-body text-center py-0'>
                <p>Breed : {$row['breed']}</p>
                <p>{$row['size']}</p>
            </div>
            <a href='animals/details.php?id={$row['id']}'><h4 class='text-center mx-1 p-2 text-light rounded-pill bg-success'>Details</h4></a>
            $extraButtons
        </div>
";
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codereview 11 - Pet Adoption</title>

    <!-- Stylesheets -->
    <?php require_once 'components/styles.php' ?>

</head>
<body>
<!-- NAVBAR -->
<nav class="navbar fixed-top navbar-expand-sm bg-black p-0">
    <div class="container-fluid animate__animated animate__fadeInDown">
        <a class="navbar-brand" href=""><img id="logo" src="images/logo2.png" alt="logo" width="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><?php
                        if ($b_signedIn) {
                            if ($b_admin) {echo "Usercenter ( {$_SESSION['adm']} )";
                            } else {echo "Usercenter ( {$_SESSION['user']} )";
                            }
                        }
                            ?></a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="javascript:sortByAge('down');" id="sort">Age<i class="ps-1 fad fa-sort-amount-down"></i></a>-->
<!--                </li>-->
            </ul>
            <div class="navbar-nav d-flex flex-grow-1 justify-content-end">
                <?= $logBtn ?>
            </div>
        </div>
    </div>
</nav>
<!-- HEADER -->
<header>
    <div class="row align-content-center" id="header-bg"><a href='<?= $selectLink ?>' class="text-center"><button class='btn btn-secondary fs-4 p-2'><?= $selectBtn ?></button></a>
    </div>
</header>
<!-- MAIN CONTENT -->
<main class="pb-5">
    <h2 class="pt-3 mx-2 text-center animate__animated animate__pulse"> <?= $header ?> </h2>
    <!-- Card Container -->
    <div class="row justify-content-center pb-5">
        <div class="row justify-content-center"> <?= $content ?> </div>
    </div>

<!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userLogin">-->
<!--        Login / Register-->
<!--    </button>-->

</main>
<!-- Modal -->
<div class="modal fade" id="userLogin" tabindex="-1" aria-labelledby="userLogin" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLoginLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <?= $errMSG ?>

                    <input type="text" autocomplete="off" name="userName" class="form-control" placeholder="Your Username" value="<?php echo $userName; ?>" maxlength="16" minlength="6" />
                    <span class="text-danger"><?php echo $userNameError; ?></span>

                    <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                    <span class="text-danger"><?php echo $passError; ?></span>
                    <hr />
                    <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign In</button>
                    <a class="ps-5 text-secondary" href="register.php">Not registered yet? Click here</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php require_once 'components/footer.html' ?>

<!-- Scripts -->
<?php require_once 'components/scripts.php' ?>

</body>
</html>