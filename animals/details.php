<?php
require_once '../components/db_usage.php';
require_once '../components/session.php';

$sql = "SELECT * FROM animals where `id` = $_GET[id]";
$result = mysqli_query($connect ,$sql);
$output='';


$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$b_admin?$extraButtons="<a href='update.php?id={$row['id']}'><button class='btn btn-secondary me-3'>Edit</button></a>
            <a href='delete.php?id={$row['id']}'><button class='btn btn-danger me-3'>Delete</button></a> 
":(
$b_user?$extraButtons="<a href='adoption.php?id={$row['id']}'><button class='btn btn-success px-3'>Take me home</button></a>"
:$extraButtons="");
$output =  "
<h1 class='pb-3 text-center bg-warning bg-opacity-50 display-2'>Details to the choosen pet:</h1>
<div class='row justify-content-center pt-5'>
<!-- Content Container -->
  <div class='row justify-content-center content-container'>
      <div class='row justify-content-around g-0'>
        <div class='col-sm-4'>
          <img src='../images/{$row['photo']}' class='img-fluid rounded-start my-3' alt='{$row['name']}'>
        </div>
        <div class='col-sm-7'>
          <div class='card-body'>
            <h2 class='card-title'>{$row['name']}</h2>
            <h5 class='card-title'>Breed {$row['breed']} lives in {$row['location']}</h5><hr>
            <p class='card-text'>{$row['description']}</p>
            <h6> Hobbies: </h6>
            <p class='card-text'>{$row['hobbies']}</p>
            <p class='card-text'><small class='text-muted'>Size: <i>{$row['size']}</i> and is {$row['age']} years old. </small></p>
        </div>
      </div>
    </div>
</div>

        <div class='py-2 text-center'>
            <a href='../home.php'><button class='btn btn-primary mx-3'>Back</button></a>
            $extraButtons
        </div>

";

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CR 11 - Detailspage <?= $row['title'] ?></title>
    <?php require_once '../components/styles.php'?>
</head>
<body>
<?= $output ?>
<div class="p-5"> </div>
<?php require_once '../components/footer.html'?>
<?php require_once '../components/scripts.php'?>
</body>
</html>